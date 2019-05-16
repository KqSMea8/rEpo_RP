<?
class banner extends dbClass
{
	
		function  ListBanner($id=0,$MemberID,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and b.BannerID='".$id."'"):("");
			$strAddQuery .= (!empty($MemberID))?(" and b.MemberID='".$MemberID."'"):("");

			if($SearchKey=='active' && ($SortBy=='b.Status' || $SortBy=='') ){
				$strAddQuery .= " and b.Status='1'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='b.Status' || $SortBy=='')){
				$strAddQuery .= " and b.Status='0'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (b.Title like '".$SearchKey."%' or b.Position like '".$SearchKey."%' or m.UserName like '".$SearchKey."%' or b.BannerType like '".$SearchKey."%')"):("");
				/*
				$strAddQuery .= (!empty($SearchKey))?(" and (b.Title like '".$SearchKey."%' or b.Position like '".$SearchKey."%' or b.ActDate like '".$SearchKey."%' or b.ExpDate like '".$SearchKey."%')"):("");*/
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by b.BannerID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");
			$strSQLQuery="select b.*,m.UserName from banner b left outer join members m on b.MemberID=m.MemberID ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

		function getBanners($page,$position,$image_banner,$BannerDisplayed){

			//$sql = "select * from banner where Status=1 and ActDate<=now() and ExpDate>=now() and TotalImpressions>0 and (TotalImpressions-Impressions)>0 ";

			$sql = "select * from banner where Status='1' ";

			$sql.= (!empty($page))?(" and ShowOn like '%".$page."%'"):("");

			$sql.= (!empty($position))?(" and position = '".$position."'"):("");

			$sql.= ($image_banner==1)?(" and ( Image like '%jpg%' or Image like '%gif%')"):("");

			$sql.= (!empty($BannerDisplayed))?(" and BannerID != '".$BannerDisplayed."'"):("");

			$sql.= " order by rand() ";

			 $sql.= " limit 0,1 "; 
			//$sql.= (!empty($BannerLimit))?(" limit 0,".$BannerLimit.""):("");

			//echo  $sql;
			return $this->query($sql, 1);
		}

		function addBanner($_REQUEST)
		{
			extract($_REQUEST);

			$sql="insert into banner (MemberID,Title, Position,ShowOn,Status,TotalImpressions,Impressions,ActDate,ExpDate,WebsiteUrl,DisplayWidth,DisplayHeight,Payment,TotalAmount,BannerType) values('".$MemberID."','".addslashes($Title)."', '$Position', '".rtrim($ShowOn,',')."', '$Status', '$TotalImpressions','$Impressions','".$actDate."', '$expDate', '$webUrl','$DisplayWidth','$DisplayHeight', '".$Payment."', '".$TotalAmount."', '".$BannerType."')";

		
			$this->query($sql,0);

			$BannerID = $this->lastInsertId();
			

			return $BannerID;
		}
		
		function updateBanner($_REQUEST)
		{
			extract($_REQUEST);
			
			$sql="update banner set Title='".addslashes($Title)."',ShowOn='".rtrim($ShowOn,',')."', Position='".$Position."', Status='".$Status."', TotalImpressions='".$TotalImpressions."', Impressions='".$Impressions."',  ActDate='".$actDate."', ExpDate='".$expDate."',WebsiteUrl='".$webUrl."',
			DisplayWidth='".$DisplayWidth."', DisplayHeight='".$DisplayHeight."', Payment='".$Payment."',TotalAmount='".$TotalAmount."',BannerType='".$BannerType."' where BannerID='".$BannerID."'"; 
			$this->query($sql,0);
			
			return true;
		}
		

		function BannerActiveEmail($BannerID)
		{

			$arryBanner = $this->getBanner($BannerID,'');

			if($arryBanner[0]['MemberID']>0){
				
				/*
				if($arryBanner[0]['BannerType']=='Duration'){
					$actDate = date('Y-m-d');
					$ExpDate = strtotime(date('Y-m-d'))+($arryBanner[0]['Validity']*24*3600);
					$expDate = date('Y-m-d',$ExpDate);
				$sql="update banner set Status='1', Payment='1',ActDate='".$actDate."', ExpDate='".$expDate."' where BannerID=".$BannerID; 
				}*/

				$sql="update banner set Status='1', Payment='1' where BannerID='".$BannerID."'"; 
				$this->query($sql,0);


				$contents = file_get_contents("../html/activebanner.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);


				$contents = str_replace("[USERNAME]",stripslashes($arryBanner[0]['UserName']),$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
			
				$contents = str_replace("[BANNER_NAME]",stripslashes($arryBanner[0]['Title']),$contents);
				$contents = str_replace("[BannerType]",$arryBanner[0]['BannerType'],$contents);

				if($arryBanner[0]['BannerUrl'] != ""){
					$ImageDestination = $arryBanner[0]['BannerUrl'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryBanner[0]['MemberEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Your banner has been activated.";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryBanner[0]['MemberEmail'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			}
		
			return 1;
		}



		function UpdateBannerCount($BannerID,$Amount)
		{
			$sql="update banner set Clicks=Clicks+1 where BannerID='".$BannerID."'"; 
			$this->query($sql,0);
			
			return true;
		}
		
		function UpdateImpressions($BannerIDs)
		{
			$sql="update banner set Impressions=Impressions+1 where BannerID in(".$BannerIDs.") and TotalImpressions>'0' and (TotalImpressions-Impressions)>'0' "; 
			$this->query($sql,0);
			
			return true;
		}


		function BannerDisabled($BannerIDs)
		{
					
			$sql="update banner set Status='0',TotalImpressions='0',Impressions='0',  ActDate='',ExpDate=''  where BannerID in(".$BannerIDs.")";
			$this->query($sql,0);
			return true;

		}
		
		function getAllBanner()
		{
			$sql="select * from banner order by BannerID Desc";
			return $this->query($sql);
		}
		
		function getBannerPages()
		{
			$sql="select * from banner_page order by PageID";
			return $this->query($sql);
		}

		function getBanner($BannerID,$Status)
		{
			$sql  = " where 1 "; 
			$sql .= (!empty($BannerID))?(" and b.BannerID='".$BannerID."'"):("");
			$sql .= (!empty($Status))?(" and b.Status='".$Status."'"):("");

			$sql="select b.*,m.UserName,m.Email as MemberEmail from banner b left outer join members m on b.MemberID=m.MemberID ".$sql." order by b.Title";
			return $this->query($sql);
		}

		function changeBannerStatus($BannerID)
		{
			$sql="select * from banner where BannerID='".$BannerID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update banner set Status='$Status' where BannerID='".$BannerID."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function UpdateBannerImage($Image,$BannerUrl,$BannerID)
		{
			$strSQLQuery = "update banner set Image='".$Image."', BannerUrl='".$BannerUrl."' where BannerID='".$BannerID."'"; 
			return $this->query($strSQLQuery, 0);
		}


		function deleteBanner($BannerID,$Front)
		{

			$strSQLQuery = "select Image from banner where BannerID='".$BannerID."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			
			if($Front > 0){
				$ImgDir = 'banner/';
			}else{
				$ImgDir = '../banner/';
			}

			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){					unlink($ImgDir.$arryRow[0]['Image']);	
			}

			$strSQLQuery = "delete from banner where BannerID='".$BannerID."'"; 
			$this->query($strSQLQuery, 0);


			return true;

		}


		function isBannerExists($Title,$BannerID)
		{
			$sql ="select * from banner where 1 and LCASE(Title) = '".strtolower(trim($Title))."'";
			$sql .= (!empty($BannerID))?(" and BannerID != '".$BannerID."'"):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['BannerID'])) {
				return true;
			} else {
				return false;
			}
		}


	function SendEmailToAdmin($BannerID,$Amount,$PackageID)
		{

			$arryPackage = $this->getPackage($PackageID,'');

			$arryBanner = $this->getBanner($BannerID,'');

			if($arryBanner[0]['BannerID']>0 && $arryBanner[0]['Payment']!=1 ){

	
				$strSQLQuery = "update banner set Payment='1', TotalAmount='".$Amount."' where BannerID='".$BannerID."'"; 
				$this->query($strSQLQuery, 0);


				$contents = file_get_contents("html/newbanner.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USER_NAME]",$arryBanner[0]['UserName'],$contents);
				$contents = str_replace("[EMAIL]",$arryBanner[0]['MemberEmail'],$contents);
				$contents = str_replace("[WEBSITE]",$arryBanner[0]['WebsiteUrl'],$contents);
				$contents = str_replace("[Amount]",$arryBanner[0]['TotalAmount'],$contents);
				$contents = str_replace("[Impressions]",$arryBanner[0]['TotalImpressions'],$contents);



				if($arryBanner[0]['BannerUrl'] != ""){
					$ImageDestination = $arryBanner[0]['BannerUrl'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.gif";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editBanner.php?edit='.$BannerID, $contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($_SESSION['Name'], $arryBanner[0]['MemberEmail']);   
				$mail->Subject = $Config['SiteName']." - Banner payment ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryBanner[0]['MemberEmail'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			}
		
			return 1;
		}

		

}

?>
