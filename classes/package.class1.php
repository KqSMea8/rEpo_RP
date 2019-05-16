<?
class package extends dbClass
{
	
		
		function  ListPackage($id=0,$CatID,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and PackageID=".$id):("");
			$strAddQuery .= (!empty($CatID))?(" and CatID=".$CatID):("");


			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (Name like '".$SearchKey."%' or Type like '%".$SearchKey."%' or Price like '%".$SearchKey."%') "):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by Type  ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			 $strSQLQuery = "select * from package".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		function addPackage($_REQUEST)
		{
			extract($_REQUEST);
			$sql="insert into package (Name, CatID, Validity, Price, Impression, Status,  Type) values('".addslashes($Name)."', '".$CatID."', '$Validity', '$Price','$Impression', '$Status', '$Type')";
			$this->query($sql,0);
			return true;
		}
		
		function updatePackage($_REQUEST)
		{
			extract($_REQUEST);
			$sql="update package set Name='".addslashes($Name)."', CatID='".addslashes($CatID)."', Validity='".$Validity."', Price='".$Price."',  Impression='".$Impression."',Status='".$Status."', Type='".$Type."'  where PackageID=".$PackageID; 
			$this->query($sql,0);
			return true;
		}
		
		
		function getPackage($PackageID,$Status)
		{
			$sql  = " where 1 "; 
			$sql .= (!empty($PackageID))?(" and PackageID=".$PackageID):("");
			$sql .= (!empty($Status))?(" and Status=".$Status):("");

			$sql="select * from package ".$sql." order by Price";
			return $this->query($sql);
		}

		function getPackageByType($PackageID,$CatID,$Type)
		{
			$sql  = " where Status=1 "; 
			$sql .= (!empty($PackageID))?(" and PackageID=".$PackageID):("");
			$sql .= (!empty($CatID))?(" and CatID=".$CatID):("");
			$sql .= (!empty($Type))?(" and Type='".$Type."'"):("");

			$sql="select * from package ".$sql." order by Price desc";
			return $this->query($sql);
		}
		
		function getCategory($CatID)
		{
			$sql  = " where 1 "; 
			$sql .= (!empty($CatID))?(" and CatID=".$CatID):("");
			$sql="select * from package_category ".$sql;
			return $this->query($sql);
		}


		function changePackageStatus($PackageID)
		{
			$sql="select * from package where PackageID=".$PackageID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update package set Status='$Status' where PackageID=".$PackageID;
				$this->query($sql,0);
				return true;
			}			
		}
		
		function deletePackage($PackageID)
		{
		 	 $sql = "delete from package where PackageID = ".$PackageID;
			$this->query($sql,0);
			return true;
		}


		function isPackageExists($Name,$PackageID,$CatID)
		{
			$sql ="select * from package where LCASE(Name) = '".strtolower(trim($Name))."'";
			$sql .= (!empty($PackageID))?(" and PackageID != ".$PackageID):("");
			$sql .= (!empty($CatID))?(" and CatID = ".$CatID):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['PackageID'])) {
				return true;
			} else {
				return false;
			}
		}


		function SendPackagePrdEmail($ProductID,$PackageID,$PaymentGateway)
		{
			$arryPackage = $this->getPackage($PackageID,'');

			$sql ="select p.*,m.UserName,m.Email from products p inner join members m on p.PostedByID=m.MemberID where p.ProductID = '".$ProductID."' and p.Featured!='Yes'";
			$arryProduct = $this->query($sql, 1);

			if($arryPackage[0]['PackageID']>0 && $arryProduct[0]['ProductID']>0 ){

				$strSQLQuery333 = "select *  from payment_gateway where id=".$PaymentGateway;
				$arryRow333 = $this->query($strSQLQuery333, 1);
				$payment_gateway = $arryRow333[0]['name'];
				
				$PaymentStatus=1;
				$payment_method_detail = '';

				if($PaymentGateway==3 || $PaymentGateway==4){

					$strSQLQuery22 ="select * from configuration where ConfigID=1";
					$arryRow22 = $this->query($strSQLQuery22, 1);

						$payment_method_detail .= '<table border=0 cellpadding=3 cellspacing=3>';
						$payment_method_detail .= '<tr><td nowrap>Account Holder : </td><td>'.$arryRow22[0]['AccountHolder'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Account Number : </td><td>'.$arryRow22[0]['AccountNumber'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Bank Name : </td><td>'.$arryRow22[0]['BankName'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Branch Code : </td><td>'.$arryRow22[0]['BranchCode'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Swift Number : </td><td>'.$arryRow22[0]['SwiftNumber'].'</td></tr>';
						$payment_method_detail .= '</table>';

					$PaymentStatus=0;

				}


				if($arryPackage[0]['Type']=='Duration'){
						$PaymentFor = $arryPackage[0]['Type'].' ('.$arryPackage[0]['Validity'].' Days)';
						$FeaturedStart = date('Y-m-d');
						$FeaturedEnd = strtotime(date('Y-m-d'))+($arryPackage[0]['Validity']*24*3600);
						$FeaturedEnd = date('Y-m-d',$FeaturedEnd);
				}else{
						$PaymentFor = $arryPackage[0]['Impression'].' (Impressions)';
				}
	
				$strSQLQuery = "update products set Featured='Yes',FeaturedAmount='".$arryPackage[0]['Price']."',Impression='".$arryPackage[0]['Impression']."',ImpressionCount=0,FeaturedStart='".$FeaturedStart."',FeaturedEnd='".$FeaturedEnd."',FeaturedType='".$arryPackage[0]['Type']."' where ProductID=".$ProductID; 

				$this->query($strSQLQuery, 0);
				

				global $Config;

				$AdminMesg = $arryProduct[0]['UserName'].' has done payment to make his below product as featured  on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a>.';

				$contents = file_get_contents("html/featuredPrdAdmin.htm");

				$contents = str_replace("[TOP_MESSAGE]",$AdminMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryProduct[0]['UserName'],$contents);
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);

				$contents = str_replace("[PRODUCT_LINK]",$Config['Url'].$Config['StorePrefix'].$arryProduct[0]['UserName']."/productDetails.php?id=".$ProductID,$contents);
				$contents = str_replace("[ADMIN_LINK]",$Config['Url']."admin/editProduct.php?edit=".$ProductID,$contents);
				
				$contents = str_replace("[STORE_LINK]",$Config['Url'].$Config['StorePrefix'].$arryProduct[0]['UserName']."/store.php",$contents);

				$contents = str_replace("[MEMBER_LINK]",$Config['Url']."view-company.php?view=".$arryProduct[0]['PostedByID'],$contents);


				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryProduct[0]['UserName'], $arryProduct[0]['Email']);   
				$mail->Subject = $Config['SiteName']." - Featured product payment ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryProduct[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

				/***************   mail to user ******************/

				$contents = file_get_contents("html/featuredPrd.htm");

				$UserMesg = 'Hi '.$arryProduct[0]['UserName'].',<BR><BR>
				Your payment for below product to make it featured has been processed successfully  on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a>.';


				$contents = str_replace("[TOP_MESSAGE]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
				$contents = str_replace("[USERNAME]",$arryProduct[0]['UserName'],$contents);
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);

				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryProduct[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - product has been marked as featured ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryProduct[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}
	


		function SendPackageStoreEmail($MemberID,$PackageID,$PaymentGateway)
		{
			$arryPackage = $this->getPackage($PackageID,'');

			// $sql ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$MemberID."' and m.Featured!='Yes'";
			 $sql ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$MemberID."' ";
			$arryMember = $this->query($sql, 1);


			$strSQLQuery333 = "select *  from payment_gateway where id=".$PaymentGateway;
			$arryRow333 = $this->query($strSQLQuery333, 1);
			$payment_gateway = $arryRow333[0]['name'];
			
			$PaymentStatus=1;
			$payment_method_detail = '';

			if($PaymentGateway==3 || $PaymentGateway==4){

				$strSQLQuery22 ="select * from configuration where ConfigID=1";
				$arryRow22 = $this->query($strSQLQuery22, 1);

					$payment_method_detail .= '<table border=0 cellpadding=3 cellspacing=3>';
					$payment_method_detail .= '<tr><td nowrap>Account Holder : </td><td>'.$arryRow22[0]['AccountHolder'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Account Number : </td><td>'.$arryRow22[0]['AccountNumber'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Bank Name : </td><td>'.$arryRow22[0]['BankName'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Branch Code : </td><td>'.$arryRow22[0]['BranchCode'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Swift Number : </td><td>'.$arryRow22[0]['SwiftNumber'].'</td></tr>';
					$payment_method_detail .= '</table>';

				$PaymentStatus=0;

			}


			if($arryPackage[0]['PackageID']>0 && $arryMember[0]['MemberID']>0 ){



				if($arryPackage[0]['Type']=='Duration'){
						$PaymentFor = $arryPackage[0]['Type'].' ('.$arryPackage[0]['Validity'].' Days)';
						$FeaturedStart = date('Y-m-d');
						$FeaturedEnd = strtotime(date('Y-m-d'))+($arryPackage[0]['Validity']*24*3600);
						$FeaturedEnd = date('Y-m-d',$FeaturedEnd);
				}else{
						$PaymentFor = $arryPackage[0]['Impression'].' (Impressions)';
				}
	

				if($PaymentStatus==1){
					$strSQLQuery = "update members set Featured='Yes',FeaturedAmount='".$arryPackage[0]['Price']."',Impression='".$arryPackage[0]['Impression']."',ImpressionCount=0,FeaturedStart='".$FeaturedStart."',FeaturedEnd='".$FeaturedEnd."',FeaturedType='".$arryPackage[0]['Type']."' where MemberID=".$MemberID; 
					$this->query($strSQLQuery, 0);
				}

			/******************/
			$objPay=new payment();
			$objPay->addPayment($PaymentFor,$PackageID , '4', $MemberID, $arryMember[0]['UserName'], $PaymentGateway, $arryPackage[0]['Price'], $PaymentStatus);
			/******************/

				global $Config;

				$AdminMesg = $arryMember[0]['UserName'].' has done payment to make his store as featured  on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a>.';

				$contents = file_get_contents("html/featuredStoreAdmin.htm");

				$contents = str_replace("[TOP_MESSAGE]",$AdminMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryMember[0]['UserName'],$contents);
				
				$StoreUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';


				$contents = str_replace("[STORE_URL]",$StoreUrl,$contents);

				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);

				$contents = str_replace("[ADMIN_LINK]",$Config['Url']."admin/editMember.php?opt=Seller&edit=".$MemberID,$contents);
				
				$contents = str_replace("[STORE_LINK]",$Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName']."/store.php",$contents);

				$contents = str_replace("[MEMBER_LINK]",$Config['Url']."view-company.php?view=".$MemberID,$contents);

				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryMember[0]['UserName'], $arryMember[0]['Email']);   
				$mail->Subject = $Config['SiteName']." - Featured store payment";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryMember[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

				/***************   mail to user ******************/

				$contents = file_get_contents("html/featuredStore.htm");

				$UserMesg = '<BR>
				Your payment to have your store featured on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a> has been processed successfully.';

				if($PaymentGateway==3 || $PaymentGateway==4){
					$UserMesg .= '<br><br>Your request will be processed once the amount due has reflected in our bank statements.<br> Please check your registered email address for further details.';
				}

				$contents = str_replace("[TOP_MESSAGE]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryMember[0]['UserName'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	

				$StoreUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';


				$contents = str_replace("[STORE_URL]",$StoreUrl,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);
				$contents = str_replace("[PAYMENT_GATWAY]",$payment_gateway,$contents);
				$contents = str_replace("[PAYMENT_METHOD_DETAIL]",$payment_method_detail,$contents);

				$contents = str_replace("[STORE_NAME]",stripslashes($arryMember[0]['CompanyName']),$contents);
				$contents = str_replace("[STORE_LINK]",$Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName']."/store.php",$contents);

				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryMember[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Featured  store payment has been received";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryMember[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}
		

		function UpdateFeaturedStoreAdmin($MemberID,$PackageID)
		{
			$arryPackage = $this->getPackage($PackageID,'');

			 $sql ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$MemberID."' ";
			$arryMember = $this->query($sql, 1);

			if($arryPackage[0]['PackageID']>0 && $arryMember[0]['MemberID']>0 ){



				if($arryPackage[0]['Type']=='Duration'){
						$PaymentFor = $arryPackage[0]['Type'].' ('.$arryPackage[0]['Validity'].' Days)';
						$FeaturedStart = date('Y-m-d');
						$FeaturedEnd = strtotime(date('Y-m-d'))+($arryPackage[0]['Validity']*24*3600);
						$FeaturedEnd = date('Y-m-d',$FeaturedEnd);
				}else{
						$PaymentFor = $arryPackage[0]['Impression'].' (Impressions)';
				}
	

			$strSQLQuery = "update members set Featured='Yes',FeaturedAmount='".$arryPackage[0]['Price']."',Impression='".$arryPackage[0]['Impression']."',ImpressionCount=0,FeaturedStart='".$FeaturedStart."',FeaturedEnd='".$FeaturedEnd."',FeaturedType='".$arryPackage[0]['Type']."' where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);


				global $Config;


				/***************   mail to user ******************/

				$contents = file_get_contents("../html/featuredStore.htm");

				$UserMesg = '<BR>
				Your payment to have your store featured on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a> has been received successfully.<br><br>your store has been marked as featured.';


				$contents = str_replace("[TOP_MESSAGE]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryMember[0]['UserName'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	

				$StoreUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';


				$contents = str_replace("[STORE_URL]",$StoreUrl,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);
				$contents = str_replace("[PAYMENT_GATWAY]",$payment_gateway,$contents);
				$contents = str_replace("[PAYMENT_METHOD_DETAIL]",$payment_method_detail,$contents);

				$contents = str_replace("[STORE_NAME]",stripslashes($arryMember[0]['CompanyName']),$contents);
				$contents = str_replace("[STORE_LINK]",$Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName']."/store.php",$contents);

				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryMember[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - your store has been marked as featured";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryMember[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}		

		function SendPackageSpnEmail($ProductID,$PackageID)
		{
			$arryPackage = $this->getPackage($PackageID,'');

			$sql ="select p.*,m.UserName,m.Email from products p inner join members m on p.PostedByID=m.MemberID where p.ProductID = '".$ProductID."' and p.Sponser!='Yes'";
			$arryProduct = $this->query($sql, 1);

			if($arryPackage[0]['PackageID']>0 && $arryProduct[0]['ProductID']>0 ){


				if($arryPackage[0]['Type']=='Duration'){
						$PaymentFor = $arryPackage[0]['Type'].' ('.$arryPackage[0]['Validity'].' Days)';
						$SponserStart = date('Y-m-d');
						$SponserEnd = strtotime(date('Y-m-d'))+($arryPackage[0]['Validity']*24*3600);
						$SponserEnd = date('Y-m-d',$SponserEnd);
				}else{
						$PaymentFor = $arryPackage[0]['Impression'].' (Impressions)';
				}
	
				$strSQLQuery = "update products set Sponser='Yes',SponserAmount='".$arryPackage[0]['Price']."',SponserImpression='".$arryPackage[0]['Impression']."',SponserImpressionCount=0,SponserStart='".$SponserStart."',SponserEnd='".$SponserEnd."',SponserType='".$arryPackage[0]['Type']."' where ProductID=".$ProductID; 

				$this->query($strSQLQuery, 0);

				global $Config;

				$AdminMesg = $arryProduct[0]['UserName'].' has done payment to make his below product as Sponsored product  on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a>.';

				$contents = file_get_contents("html/sponserPrd.htm");

				$contents = str_replace("[TOP_MESSAGE]",$AdminMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryProduct[0]['UserName'],$contents);
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);

				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryProduct[0]['UserName'], $arryProduct[0]['Email']);   
				$mail->Subject = $Config['SiteName']." - Sponsored product payment ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryProduct[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

				/***************   mail to user ******************/

				$contents = file_get_contents("html/sponserPrd.htm");

				$UserMesg = 'Hi '.$arryProduct[0]['UserName'].',<BR><BR>
				Your payment for below product to make it featured has been processed successfully  on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a>.';


				$contents = str_replace("[TOP_MESSAGE]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryProduct[0]['UserName'],$contents);
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);

				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryProduct[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Sponsored product payment ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryProduct[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}




	function SendPackageBannerEmail($BannerID,$PackageID,$PaymentGateway)
		{
			$arryPackage = $this->getPackage($PackageID,'');

			$sql ="select b.*,m.UserName,m.Email from banner b inner join members m on b.MemberID=m.MemberID where b.BannerID = '".$BannerID."' and b.Payment!='1'";
			$arryBanner = $this->query($sql, 1);

			if($arryPackage[0]['PackageID']>0 && $arryBanner[0]['BannerID']>0 ){


				if($arryPackage[0]['Type']=='Duration'){
						$PaymentFor = $arryPackage[0]['Type'].' ('.$arryPackage[0]['Validity'].' Days)';
						$ActDate = date('Y-m-d');
						$ExpDate = strtotime(date('Y-m-d'))+($arryPackage[0]['Validity']*24*3600);
						$ExpDate = date('Y-m-d',$ExpDate);
				}else{
						$PaymentFor = $arryPackage[0]['Impression'].' (Impressions)';
				}
	

			$strSQLQuery333 = "select *  from payment_gateway where id=".$PaymentGateway;
			$arryRow333 = $this->query($strSQLQuery333, 1);
			$payment_gateway = $arryRow333[0]['name'];
			
			$PaymentStatus=1;

			$payment_method_detail = '';

			if($PaymentGateway==3 || $PaymentGateway==4){

				$strSQLQuery22 ="select * from configuration where ConfigID=1";
				$arryRow22 = $this->query($strSQLQuery22, 1);

					$payment_method_detail .= '<table border=0 cellpadding=3 cellspacing=3>';
					$payment_method_detail .= '<tr><td nowrap>Account Holder : </td><td>'.$arryRow22[0]['AccountHolder'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Account Number : </td><td>'.$arryRow22[0]['AccountNumber'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Bank Name : </td><td>'.$arryRow22[0]['BankName'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Branch Code : </td><td>'.$arryRow22[0]['BranchCode'].'</td></tr>';
					$payment_method_detail .= '<tr><td nowrap>Swift Number : </td><td>'.$arryRow22[0]['SwiftNumber'].'</td></tr>';
					$payment_method_detail .= '</table>';

				$PaymentStatus=0;

			}




				$strSQLQuery = "update banner set Payment='".$PaymentStatus."',TotalAmount='".$arryPackage[0]['Price']."',TotalImpressions='".$arryPackage[0]['Impression']."',Impressions=0,ActDate='".$ActDate."',ExpDate='".$ExpDate."',BannerType='".$arryPackage[0]['Type']."',payment_gateway='".$payment_gateway."' where BannerID=".$BannerID; 

				$this->query($strSQLQuery, 0);

				/******************/
				$PaymentFor = 'Banner ('.stripslashes($arryBanner[0]['Title']).')';
				$objPay=new payment();
				$objPay->addPayment($PaymentFor,$BannerID,'3',$arryBanner[0]['MemberID'], $arryBanner[0]['UserName'], $PaymentGateway, $arryPackage[0]['Price'], $PaymentStatus);
				/******************/


				global $Config;

				$AdminMesg = $arryBanner[0]['UserName'].' has done payment for his banner on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a>.';

				$contents = file_get_contents("html/banner.htm");

				$contents = str_replace("[TOP_MESSAGE]",$AdminMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryBanner[0]['UserName'],$contents);
				$contents = str_replace("[TITLE]",stripslashes($arryBanner[0]['Title']),$contents);

				if($arryBanner[0]['BannerUrl'] != ""){
					$ImageDestination = $arryBanner[0]['BannerUrl'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);

				$contents = str_replace("[ACTIVATE_MSG]",'Please click the below link if you want to activate this banner.<br><br>',$contents);
				$contents = str_replace("[PAYMENT_GATWAY]",$payment_gateway,$contents);
				$contents = str_replace("[PAYMENT_METHOD_DETAIL]",'',$contents);

				$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editBanner.php?edit='.$arryPackage[0]['PackageID'], $contents);


				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryBanner[0]['UserName'], $arryBanner[0]['Email']);   
				$mail->Subject = $Config['SiteName']." - Banner payment ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryBanner[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

				/***************   mail to user ******************/

				$contents = file_get_contents("html/banner.htm");

				$UserMesg = $arryBanner[0]['UserName'].',<BR><BR>'.date("jS, F Y").'<BR><BR>
				Your payment for below banner has been processed successfully  on <a href="'.$Config['Url'].'" target="_blank" class="normallink">'.$Config['SiteName'].'</a>.';


				$contents = str_replace("[TOP_MESSAGE]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",'Thank  you for choosing Webo as your eCommerce solution. We are here to get your business growing.<br><br>'.$Config['MailFooter'],$contents);

	
				$contents = str_replace("[USERNAME]",$arryBanner[0]['UserName'],$contents);
				$contents = str_replace("[TITLE]",stripslashes($arryBanner[0]['Title']),$contents);
				if($arryBanner[0]['BannerUrl'] != ""){
					$ImageDestination = $arryBanner[0]['BannerUrl'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents = str_replace("[Amount]",$Config['Currency'].' '.$arryPackage[0]['Price'],$contents);
				$contents = str_replace("[PaymentFor]",$PaymentFor,$contents);
				$contents = str_replace("[ACTIVATE_MSG]",'',$contents);
				$contents = str_replace("[ACTIVATE_URL]",'',$contents);
				$contents = str_replace("[PAYMENT_GATWAY]",$payment_gateway,$contents);
				$contents = str_replace("[PAYMENT_METHOD_DETAIL]",$payment_method_detail,$contents);


				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryBanner[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Banner payment ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryBanner[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}	




		
		function FeaturedCounter($FeaturedIDs,$FeaturedType,$Type){
			

			$IpAddress = $_SERVER['REMOTE_ADDR'];
			//$IpAddress = GetHostByName($REMOTE_ADDR);

			$Date = strtotime(date('Y-m-d H:i:s'));
			
			$FeatArry = explode(",",$FeaturedIDs);
			$FeatTypeArry = explode(",",$FeaturedType);

			for($i=0;$i<sizeof($FeatArry);$i++){
				$FeaturedID = $FeatArry[$i];
				$FeatType = $FeatTypeArry[$i];

				 $strSQLQuery = "select * from featured_counter where FeaturedID=".$FeaturedID." and IpAddress='".$IpAddress."' and (".$Date."-Date)<200 and Type='".$Type."'";

				$arryRow = $this->query($strSQLQuery, 1);
				if (empty($arryRow[0]['FeaturedID'])) {
					$strSQLQuery = "insert into featured_counter(FeaturedID,Type,IpAddress,Date) values('".$FeaturedID."', '".$Type."', '".$IpAddress."','".$Date."')";
					$this->query($strSQLQuery, 0);


					if($FeatType=='Impression'){
						if($Type=='Product') {
							$strSQLQuery = "update products set ImpressionCount=ImpressionCount+1 where ProductID=".$FeaturedID; 
						}else if($Type=='Store') {
							$strSQLQuery = "update members set ImpressionCount=ImpressionCount+1 where MemberID=".$FeaturedID; 
						}else if($Type=='Sponser'){
							$strSQLQuery = "update products set SponserImpressionCount=SponserImpressionCount+1 where ProductID=".$FeaturedID; 
						}else if($Type=='Banner'){
							$strSQLQuery = "update banner set Impressions=Impressions+1 where BannerID=".$FeaturedID; 
						}

						$this->query($strSQLQuery, 0);
					}

				}
				

			}



		}




}

?>
