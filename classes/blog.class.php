<?
class blog extends dbClass
{
		//constructor
		function blog()
		{
			$this->dbClass();
		} 
		
		function  GetComments($id=0,$ProductID,$MemberID,$Status)
		{
			$strSQLQuery = "select c1.*,m1.FirstName,m1.LastName,m1.Email,m1.Image from comments c1 inner join members m1 on c1.MemberID = m1.MemberID where CommentType='new' ";

			$strSQLQuery .= (!empty($id))?(" and c1.CommentID='".$id."'"):("");
			$strSQLQuery .= ($ProductID>0)?(" and c1.ProductID='".$ProductID."'"):("");
			$strSQLQuery .= ($MemberID>0)?(" and c1.MemberID='".$MemberID."'"):("");

			$strSQLQuery .= ($Status>0)?(" and c1.Status='".$Status."' and m1.Status='".$Status."'"):("");
			$strSQLQuery .= ' order by c1.CommentDate desc';

			return $this->query($strSQLQuery, 1);
		}


		function  GetCommentsView($StoreID,$id=0,$SearchKey,$SortBy,$AscDesc,$TopicID,$MemberID,$Status)
		{
			$strAddQuery = " and c1.StoreID='".$StoreID."'";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and c1.CommentID='".$id."'"):("");
			$strAddQuery .= ($MemberID>0)?(" and c1.MemberID='".$MemberID."'"):("");
			$strAddQuery .= ($TopicID>0)?(" and c1.TopicID='".$TopicID."'"):(" and c1.TopicID='0' ");

			$strAddQuery .= ($Status>0)?(" and c1.Status='".$Status."' and m1.Status='".$Status."'"):("");

			$strAddQuery .= (!empty($SearchKey))?(" and (c1.CommentDate like '".$SearchKey."%' or LCASE(c1.Comment) like '%".$SearchKey."%' LCASE(m1.UserName) like '%".$SearchKey."%'  or LCASE(m1.Email) like '%".$SearchKey."%')"):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.CommentDate ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");

			$strSQLQuery = "select c1.*,m1.UserName as PostedByName ,m1.Image from comments c1 inner join members m1 on c1.MemberID = m1.MemberID where 1 ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

		function GetNumReplies($StoreID,$TopicID,$Status){
			$strAddQuery = " and c1.StoreID='".$StoreID."'";
			$strAddQuery .= ($Status>0)?(" and c1.Status='".$Status."' and m1.Status='".$Status."'"):("");

			$strSQLQuery = "select count(*) as NumReplies from comments c1 inner join members m1 on c1.StoreID = m1.MemberID where c1.TopicID = ".$TopicID.$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}


		function UpdateAttach($FieldName,$attachName,$CommentID)
		{
			 $strSQLQuery = "update comments set ".$FieldName."='".$attachName."' where CommentID='".$CommentID."'";
  			return $this->query($strSQLQuery, 0);
		}

		function AddComment($arryCommentDetails)
		{

			extract($arryCommentDetails);

			if($MemberID!=$StoreID) $Status= '0';


			$strSQLQuery = "insert into comments (StoreID,TopicID,MemberID,Comment,CommentDetail, CommentDate,Status) values ('".$StoreID."','".$TopicID."','".$MemberID."', '".addslashes($Comment)."','".addslashes($CommentDetail)."','".date('Y-m-d H:i:s')."','".$Status."')";

			$this->query($strSQLQuery, 0);
			$lastInsertId = $this->lastInsertId(); 

			if($MemberID!=$StoreID){
				global $Config;

				$objMember=new member();
				$arryMember = $objMember->GetMemberDetail($StoreID);

				$WebsiteUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/home.php';
				
				if($TopicID>0){
					$ModuleName = 'Comment';
					$CommentUrl = $Config['Url'].'editResponse.php?TopicID='.$TopicID.'&edit='.$lastInsertId;
				
				}else{
					$ModuleName = 'Topic';
					$CommentUrl = $Config['Url'].'editBlog.php?edit='.$lastInsertId;
				}


				$Mesg = "Dear ".$arryMember[0]['UserName'].",<br><br>".date("jS, F Y")."<br><br><br><br>A ".$ModuleName." has been posted on your website <a href='".$WebsiteUrl."' target='_blank'>".stripslashes($arryMember[0]['CompanyName'])."</a>.<br><bR>
	Please click here the below link to view/edit the ".$ModuleName." <br>  <a href='".$CommentUrl."' target='_blank'>View ".$ModuleName."</a>.";


				$contents = file_get_contents("html/ack.htm");

				$contents = str_replace("[MAIL_CONTENT]",$Mesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);


				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryMember[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - New ".$ModuleName." has been posted on your website.";
				$mail->IsHTML(true);

				//echo $arryMember[0]['Email'].$Config['AdminEmail'].$contents; exit;

				$mail->Body = $contents;   
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}


			return $lastInsertId;

			
		}
		
		function UpdateComment($arryCommentDetails)
		{
			extract($arryCommentDetails);

			$strSQLQuery = "update comments set  Comment='".addslashes($Comment)."', CommentDetail='".addslashes($CommentDetail)."',Status='".$Status."' where CommentID='".$CommentID."'";

			$this->query($strSQLQuery, 0);
		
			return 1;
		}


		function AddReply($arryCommentDetails)
		{

			extract($arryCommentDetails);

			if($CommentType == '') $CommentType='reply';

			$strSQLQuery = "insert into comments (ProductID,MemberID,ReplyToID,ReplyComment, CommentType,ReplyTime) values ('".$ProductID."','".$MemberID."','".$CommentID."',  '".addslashes($ReplyComment)."','".addslashes($CommentType)."' ,'".date('Y-m-d H:i:s')."')";

			$this->query($strSQLQuery, 0);
			
		
			if($OwnerEmailID != ''){
				$contents = file_get_contents("html/ack.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FULLNAME]",$OwnerName,$contents);
				$contents = str_replace("[DESCRIPTION]","New Comment has been posted for your topic .<BR>
Please login and view the comment on <a href='".$Config['Url']."'>".$Config['SiteName']."</a>.",$contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($OwnerEmailID);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - New Comment has been posted for your topic.";
				$mail->IsHTML(true);
				//echo $contents; exit;
				$mail->Body = $contents;    
				$mail->Send();	
			}				
			
			
			
			
			return 1;
			
		}

		function SendEmailToAdmin($arryCommentDetails,$lastInsertId,$imageComment)
		{
			extract($arryCommentDetails);

			if($FrontEnd > 0){
				$contents = file_get_contents("html/blog.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FULLNAME]",$PostedByComment,$contents);
				$contents = str_replace("[USER]",$MemberEmail,$contents);
				$contents = str_replace("[PRODUCTNAME]",$Comment,$contents);
				$contents = str_replace("[DESCRIPTION]",$CommentDetail,$contents);
				$contents = str_replace("[PRICE]",$Price,$contents);
				$contents = str_replace("[QUANTITY]",$Quantity,$contents);
				if($imageComment != ""){
					$ImageDestination = $Config['Url']."upload/comments/".$imageComment;
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}
				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'activatePrd.php?requestId='.$lastInsertId, $contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - New Comment has been posted for Sell.";
				$mail->IsHTML(true);
				//echo $contents; exit;
				$mail->Body = $contents;    
				$mail->Send();	
			}			
		
			return 1;
		}

		function ChangeCommentStatus($CommentID,$Status)
		{
			$strSQLQuery = "update comments set Status=".$Status." where CommentID='".$CommentID."'";
			$this->query($strSQLQuery, 0);
			return 1;
		}


		function RemoveComment($CommentID,$TopicID)
		{

			$strSQLQuery = "select AttachFile1,AttachFile2 from comments where CommentID='".$CommentID."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			
			$ImgDir = 'upload/blog/';

			if($arryRow[0]['AttachFile1'] !='' && file_exists($ImgDir.$arryRow[0]['AttachFile1']) ){			unlink($ImgDir.$arryRow[0]['AttachFile1']);	
			}
			if($arryRow[0]['AttachFile2'] !='' && file_exists($ImgDir.$arryRow[0]['AttachFile2']) ){			unlink($ImgDir.$arryRow[0]['AttachFile2']);	
			}

			$strSQLQuery = "delete from comments where CommentID='".$CommentID."'"; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery = "delete from comments where TopicID='".$CommentID."'"; 
			$this->query($strSQLQuery, 0);

			if(sizeof($rs))
				return true;
			else
				return false;

		}



		
		function isCommentExists($Comment,$CommentID,$StoreID)
		{
			$strSQLQuery = "select CommentID from comments where LCASE(Comment)='".strtolower(trim($Comment))."'";
			$strSQLQuery .= ($CommentID>0)?(" and CommentID != '".$CommentID."'"):("");
			$strSQLQuery .= (!empty($StoreID))?(" and StoreID = '".$StoreID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CommentID'])) {
				return true;
			} else {
				return false;
			}
		}


	
		function CheckBannedWords($CommentID,$arryCommentDetails)
		{
			extract($arryCommentDetails);

			$BannedWord = 'dog';

			 $strSQLQuery = "select * from comments where CommentID = '".$CommentID."' and (LCASE(Comment) like '%".strtolower(trim($BannedWord))."%' or LCASE(CommentDetail) like '%".strtolower(trim($BannedWord))."%') " ;


			$arryRow = $this->query($strSQLQuery, 1);
			if (empty($arryRow[0]['CommentID'])) {
				return 1;
			} else {
				return 0;
			}
		}		

		function CheckBannedWordsReply($CommentID)
		{

			$BannedWord = 'dog';

			$strSQLQuery = "select * from comments where CommentID = '".$CommentID."' and LCASE(ReplyComment) like '%".strtolower(trim($BannedWord))."%'" ;

			$arryRow = $this->query($strSQLQuery, 1);
			if (empty($arryRow[0]['CommentID'])) {
				return 1;
			} else {
				return 0;
			}
		}		

	/////////////////////------  Abuse Words ------ ////////////////////

		function  GetAbuseWords()
		{
			$strSQLQuery = "select BlogAbuseWords from configuration where ConfigID='1'";
			return $this->query($strSQLQuery, 1);

		}
		
		function  GetWords($id=0,$Status)
		{
			$strSQLQuery = "select * from abuse where 1 ";

			$strSQLQuery .= (!empty($id))?(" and abuseID='".$id."'"):("");
			$strSQLQuery .= ($Status>0)?(" and Status='".$Status."'"):("");
			$strSQLQuery .= ' order by Word Asc';

			return $this->query($strSQLQuery, 1);
		}

		function AddWord($arryDetails)
		{

			extract($arryDetails);

			$strSQLQuery = "insert into abuse (Word,Status) values ('".addslashes($Word)."' ,'".$Status."')";

			return $this->query($strSQLQuery, 0);
			
		}
		
		function UpdateWord($arryDetails)
		{
			extract($arryDetails);

			$strSQLQuery = "update abuse  set  Word='".addslashes($Word)."',Status='".$Status."' where abuseID='".$abuseID."'";

			$this->query($strSQLQuery, 0);
		
			return 1;
		}


		function RemoveWord($id)
		{
			
			$strSQLQuery = "delete from abuse  where abuseID='".$id."'"; 
			$this->query($strSQLQuery, 0);
			
			return 1;
		}


		function isAbuseWordExists($Word,$abuseID)
		{
			$strSQLQuery = "select * from abuse where LCASE(Word)='".strtolower(trim($Word))."'";

			$strSQLQuery .= ($abuseID>0)?(" and abuseID != '".$abuseID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['abuseID'])) {
				return true;
			} else {
				return false;
			}
		}

}

?>
