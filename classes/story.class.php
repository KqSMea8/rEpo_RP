<?
class story extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function story(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addStory($arryDetails)
	{
		@extract($arryDetails);	
		
		$sql = "insert into story (MemberID,heading,detail,SpeakerName,Designation,Image,storyDate,Status) values('".$MemberID."','".addslashes($heading)."', '".addslashes($detail)."','".addslashes($SpeakerName)."', '".addslashes($Designation)."','".$Image."','".$storyDate."', '".$Status."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();

		if($Front>0){
			
			global $Config;
			
			$contents = file_get_contents("html/ack.htm");
			$MailContent = 'Dear '.$SpeakerName.',<BR><BR>Thank you for posting the story at <a href="'.$Config['Url'].'">'.$Config['SiteName'].'</a>.<br><br>
			<B>Story Heading :</B> '.$heading.'<br><br><br>It will be activated soon, once it has been verified by the administrator.';


			$contents = str_replace("[MAIL_CONTENT]",$MailContent,$contents);
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($SpeakerEmail);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - New Story Posted ";
			$mail->IsHTML(true);
			$mail->Body = $contents;  
			//echo $SpeakerEmail.$Config['AdminEmail'].$contents; exit;
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}


			$contents = file_get_contents("html/ack.htm");
			$MailContent = 'New story has been posted on <a href="'.$Config['Url'].'">'.$Config['SiteName'].'</a>.<br><br>
			<B>Story Heading :</B> '.$heading.'<br><br><br>Click the below link to activate this story.<br><a href="'.$Config['Url'].'admin/editStory.php?edit='.$lastInsertId.'">'.$Config['Url'].'admin/editStory.php?edit='.$lastInsertId.'</a>';

			$contents = str_replace("[MAIL_CONTENT]",$MailContent,$contents);
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($SpeakerName, $SpeakerEmail);   
			$mail->Subject = $Config['SiteName']." - New Story Posted ";
			$mail->IsHTML(true);
			$mail->Body = $contents;  
			//echo $SpeakerEmail.$Config['AdminEmail'].$contents; exit;
			
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}





		}


		return $lastInsertId;

	}


	function updateStory($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update story set heading = '".addslashes($heading)."', detail = '".addslashes($detail)."',SpeakerName = '".addslashes($SpeakerName)."', Designation = '".addslashes($Designation)."', storyDate = '".$storyDate."', Status = '".$Status."'  where storyID = '".$storyID."'"; 
		$rs2 = $this->query($sql,0);
			

		if($Status==1 && $OldStatus!=1){

					$sql="select * from story where storyID='".$storyID."'";
					$rs = $this->query($sql);
			
					global $Config;
					$sql2="select UserName,Email from members where MemberID='".$rs[0]['MemberID']."'";
					$arryMember = $this->query($sql2);
					
					$contents = file_get_contents("../html/ack.htm");
					$MailContent = 'Dear '.$arryMember[0]['UserName'].',<BR><BR>Your story titled as "'.stripslashes($rs[0]['heading']).'" has been activated on <a href="'.$Config['Url'].'">'.$Config['SiteName'].'</a>.';


					$contents = str_replace("[MAIL_CONTENT]",$MailContent,$contents);
					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
							
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($arryMember[0]['Email']);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Story Activated ";
					$mail->IsHTML(true);
					$mail->Body = $contents;  
					//echo $arryMember[0]['Email'].$Config['AdminEmail'].$contents; exit;
					if($Config['DbUser'] != 'root'){
						$mail->Send();	
					}
			}



		if(sizeof($rs2))
			return true;
		else
			return false;

	}
	function getStory($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and s.storyID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and s.Status = '".$Status."'"):("");

		$sql = "select s.*,m.Image from story s left outer join members m on s.MemberID=m.MemberID ".$sql." order by s.storyID desc" ;
		return $this->query($sql, 1);
	}

	function changeStoryStatus($storyID)
	{
		$sql="select * from story where storyID='".$storyID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update story set Status='$Status' where storyID='".$storyID."'";
			$this->query($sql,0);


			if($Status==1){
			
					global $Config;
					$sql2="select UserName,Email from members where MemberID='".$rs[0]['MemberID']."'";
					$arryMember = $this->query($sql2);
					
					$contents = file_get_contents("../html/ack.htm");
					$MailContent = 'Dear '.$arryMember[0]['UserName'].',<BR><BR>Your story titled as "'.stripslashes($rs[0]['heading']).'" has been activated on <a href="'.$Config['Url'].'">'.$Config['SiteName'].'</a>.';


					$contents = str_replace("[MAIL_CONTENT]",$MailContent,$contents);
					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
							
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($arryMember[0]['Email']);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Story Activated ";
					$mail->IsHTML(true);
					$mail->Body = $contents;  
					//echo $arryMember[0]['Email'].$Config['AdminEmail'].$contents; exit;
					if($Config['DbUser'] != 'root'){
						$mail->Send();	
					}
			}










			return true;
		}			
	}

	function deleteStory($storyID)
	{

		$strSQLQuery = "select Image from story where storyID='".$storyID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		if($Front > 0){
			$ImgDir = 'upload/story/';
		}else{
			$ImgDir = '../upload/story/';
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							unlink($ImgDir.$arryRow[0]['Image']);	
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.'thumbs/'.$arryRow[0]['Image']) ){					unlink($ImgDir.'thumbs/'.$arryRow[0]['Image']);
		}

		$sql = "delete from story where storyID = '".$storyID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListStory($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and storyID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or SpeakerName like '%".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by storyID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from story ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function UpdateImage($imageName,$storyID)
	{
			$strSQLQuery = "update story set Image='".$imageName."' where storyID='".$storyID."'";
			return $this->query($strSQLQuery, 0);
	}


	function isStoryExists($heading,$storyID)
	{

		$strSQLQuery ="select * from story where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($storyID))?(" and storyID != '".$storyID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['storyID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
