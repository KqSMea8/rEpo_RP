<?
class member extends dbClass
{
		//constructor
		function member()
		{
			$this->dbClass();
		} 
		
		function  ListMember($id=0,$SearchKey,$SortBy,$AscDesc,$Type)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where m.MemberID=".$id):(" where 1");
			$strAddQuery .= (!empty($Type))?(" and m.Type='".$Type."'"):("");

			if($SearchKey=='active' && ($SortBy=='m.Status' || $SortBy=='') ){
				$strAddQuery .= " and m.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='m.Status' || $SortBy=='') ){
				$strAddQuery .= " and m.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (m.UserName like '".$SearchKey."%' or m.MemberID like '%".$SearchKey."%' or m.Email like '%".$SearchKey."%' or m.CompanyName like '%".$SearchKey."%' or m.Featured like '%".$SearchKey."%' or ms.Name like '%".$SearchKey."%') " ):("");
			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by m.JoiningDate ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");

			$strSQLQuery = "select m.*,ms.Name as Membership from members m left outer join membership ms on m.MembershipID=ms.MembershipID ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetMember($id=0,$Type)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where m.MemberID=".$id):(" where 1 ");
			$strAddQuery .= (!empty($Type))?(" and m.Type='".$Type."'"):("");

			$strAddQuery .= " order by m.JoiningDate Desc ";

			$strSQLQuery = "select m.*,ms.Name as Membership from members m left outer join membership ms on m.MembershipID=ms.MembershipID ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

		function  GetMemberImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where MemberID=".$id):(" where 1 ");

			$strSQLQuery = "select m.Image,m.Banner  from members m ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

		function  GetMemberForSMS($MemberID=0,$Status,$Type)
		{
			$strAddQuery = ' where SmsSubscribe=1';
			$strAddQuery .= (!empty($MemberID))?(" and m.MemberID!=".$MemberID):("");
			$strAddQuery .= (!empty($Type))?(" and m.Type='".$Type."'"):("");
			$strAddQuery .= ($Status>0)?(" and m.Status=".$Status):("");

			$strAddQuery .= " and m.Phone!='' order by m.JoiningDate Desc ";

			$strSQLQuery = "select m.MemberID,m.UserName,m.Email,m.Phone,m.isd_code from members m ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}


		function  GetMembers($MemberID,$Status,$Type)
		{
			$strSQLQuery = "select m.*,ms.Name as Membership,mt.MyGatePayment,mt.PaypalPayment,mt.EftPayment,mt.DepositPayment,mt.AccountHolder,mt.AccountNumber,mt.BankName,mt.BranchCode,mt.SwiftNumber,mt.Tax,mt.Shipping,mt.MyGate_Mode,mt.MyGate_MerchantID,mt.MyGate_ApplicationID,mt.PaypalID, mt.PostalCourier,mt.Airmail, mt.SeaFreight,mt.PostalCourierEnable, mt.AirmailEnable, mt.SeaFreightEnable, mt.currency_id	 from members m left outer join membership ms on m.MembershipID=ms.MembershipID left outer join member_site mt on m.MemberID=mt.MemberID";


			$strSQLQuery .= (!empty($MemberID))?(" where m.MemberID=".$MemberID):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and m.Status=".$Status):("");
			$strSQLQuery .= (!empty($Type))?(" and m.Type='".$Type."'"):("");

			return $this->query($strSQLQuery, 1);
		}


		function  GetMembersForEmail($MemberID,$Type)
		{
			$strSQLQuery = "select MemberID,UserName,Email from members where Status=1 and EmailSubscribe=1";

			$strSQLQuery .= (!empty($MemberID))?(" and MemberID!=".$MemberID):("");
			$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");
			return $this->query($strSQLQuery, 1);
		}
		function  GetSignUpEmail()
		{
			$strSQLQuery = "select * from email_signup";
			return $this->query($strSQLQuery, 1);
		}
		function UpdateWebsiteStoreOption($MemberID,$WebsiteStoreOption,$PaymentGateway,$Price)
		{

			$PaymentStatus=1;

			
			if(!empty($Price) && !empty($PaymentGateway)){

			/****** Email to User/Admin *******/
			//$sql = "select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$MemberID."' ";
		
			$sql ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$MemberID."' and m.WebsiteStoreOption!='".$WebsiteStoreOption."'";
		
			$arryMember = $this->query($sql, 1);


			if($arryMember[0]['MemberID']>0 ){

				global $Config;

				switch($WebsiteStoreOption){
					case 'w': 
							$PaymentFor = 'Website';
							break;
					case 's': 
							$PaymentFor = 'Online Store';
							break;
					case 'ws': 
							$PaymentFor = 'Website with Online Store';
							break;
				}

				if($PaymentGateway==3 || $PaymentGateway==4) 
					$PaymentStatus=0;


				$objPay=new payment();
				$objPay->addPayment($PaymentFor,$WebsiteStoreOption,'1',$MemberID,$arryMember[0]['UserName'],$PaymentGateway,$Price,$PaymentStatus);


				$AdminMesg = $arryMember[0]['UserName'].' has done payment to get '.$PaymentFor.'<br><br><b>Paid Amount: </b>'.$Price.' '.$Config['Currency'];

				$contents = file_get_contents("html/ack.htm");

				$contents = str_replace("[MAIL_CONTENT]",$AdminMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
		
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryMember[0]['UserName'], $arryMember[0]['Email']);   
				$mail->Subject = $Config['SiteName']." - payment done for ".$PaymentFor;
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryMember[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

				/***************   mail to user ******************/

				$UserMesg = "Dear ".$arryMember[0]['UserName'].', <br><br> Your payment for  '.$PaymentFor.' has been received.<br><br><b>Paid Amount: </b>'.$Price.' '.$Config['Currency'];

				$contents = file_get_contents("html/ack.htm");

				$contents = str_replace("[MAIL_CONTENT]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
		
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryMember[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - payment received for ".$PaymentFor;
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryMember[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}



			}
		
				/*************/


			}



			if($PaymentStatus==1){

				$sql = "select WebsiteStoreOption from members  where MemberID = '".$MemberID."'";
				$arryMember = $this->query($sql, 1);
				
				$FinalOption = $WebsiteStoreOption;

				if($arryMember[0]['WebsiteStoreOption']=='s' && $FinalOption=='w'){
					$_SESSION['WebsiteStoreOption'] = 'ws';
					$FinalOption = 'ws';
				}

				if($arryMember[0]['WebsiteStoreOption']=='w' && $FinalOption=='s'){
					$_SESSION['WebsiteStoreOption'] = 'ws';
					$FinalOption = 'ws';
				}

				
				$strSQLQuery = "update members set WebsiteStoreOption='".$FinalOption."'
				where MemberID=".$MemberID; 

				$this->query($strSQLQuery, 0);

			}


			return 1;
		}


		function SetupDoneEmail($MemberID,$WebsiteStoreOption)
		{

			$sql ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$MemberID."'";
		
			$arryMember = $this->query($sql, 1);


			if($arryMember[0]['MemberID']>0 ){

				global $Config;

				switch($WebsiteStoreOption){
					case 'w': 
							$SetupMsg = WESBITE_SETUP_SUCCESSFULLY;
							$WebUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/home.php';
							$UrlMsg = 'Website: <a href="'.$WebUrl.'">'.$WebUrl.'</a>';
							break;
					case 's': 
							$SetupMsg = STORE_SETUP_DONE;
							$StoreUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';
							$UrlMsg = 'Online Store: <a href="'.$StoreUrl.'">'.$StoreUrl.'</a>';
							break;
					case 'ws': 
							$SetupMsg = STORE_WESBITE_SETUP_SUCCESSFULLY;
							$StoreUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';
							$WebUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/home.php';
							$UrlMsg = 'Website: <a href="'.$WebUrl.'">'.$WebUrl.'</a>';
							$UrlMsg .= '<br><br>Online Store: <a href="'.$StoreUrl.'">'.$StoreUrl.'</a>';
						break;
				}


				/***************   mail to user ******************/

				$UserMesg = "Dear ".$arryMember[0]['UserName'].', <br><br>'.$SetupMsg.'<br><br>'.$UrlMsg;

				$contents = file_get_contents("html/ack.htm");

				$contents = str_replace("[MAIL_CONTENT]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryMember[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$SetupMsg;
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryMember[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}		


		function UpdateWebsiteStoreAdmin($PaymentID)
		{

			$sql="select p1.*,m1.UserName,m1.Email,m1.CompanyName,m1.WebsiteStoreOption from payments p1 inner join members m1 on p1.MemberID=m1.MemberID where p1.PaymentID=".$PaymentID." and p1.PaymentStatus=1";
			$arryMember = $this->query($sql, 1);
		
			if($arryMember[0]['PaymentID']>0 ){

				global $Config;
		

				/***************   mail to user ******************/

				$UserMesg = 'Dear '.$arryMember[0]['UserName'].', <br><br> Your payment for "'.$arryMember[0]['PaymentFor'].'" has been received.<br><br><b>Paid Amount: </b>'.$arryMember[0]['Amount'].' '.$Config['Currency'].'<br><br>Your account has been updated.<br>Please <a href="'.$Config['Url'].'login.php" target="_blank">click here</a> to login to your account and view your account details.';
				

				$contents = file_get_contents("../html/ack.htm");

				$contents = str_replace("[MAIL_CONTENT]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
		
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryMember[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - payment received for ".$arryMember[0]['PaymentFor'].' and your account has been updated';
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryMember[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			
				$FinalOption = $arryMember[0]['PaymentForCode'];

				if($arryMember[0]['WebsiteStoreOption']=='s' && $FinalOption=='w'){
					$FinalOption = 'ws';
				}

				if($arryMember[0]['WebsiteStoreOption']=='w' && $FinalOption=='s'){
					$FinalOption = 'ws';
				}

				
				$strSQLQuery = "update members set WebsiteStoreOption='".$FinalOption."'
				where MemberID=".$arryMember[0]['MemberID']; 

				$this->query($strSQLQuery, 0);


			}

			return 1;

		}	


		function UpdateTemplate($MemberID,$templateID)
		{
			if($templateID>0){
				$strSQLQuery = "update members set templateID='".$templateID."'
			where MemberID=".$MemberID; 

				$this->query($strSQLQuery, 0);
			}


			$sql = "select MemberID from member_site where MemberID='".$MemberID."'";
			$arryRow = $this->query($sql, 1); 

			if(empty($arryRow[0]['MemberID'])){
				$sql = "insert into member_site(MemberID,HeaderTitle) values('".$MemberID."','".addslashes($_SESSION['CompanyName'])."')";
				$this->query($sql, 0);
			}



			
			return 1;
		}		

		function CloseWebsiteStore($WebsiteStoreOption,$MemberID)
		{
			$strSQLQuery = "update members set WebsiteStoreOption='".$WebsiteStoreOption."'
			where MemberID=".$MemberID; 

			$this->query($strSQLQuery, 0);
			
			return 1;
		}		


		function  GetMemberSite($MemberID)
		{
			$strSQLQuery = "select ms.*,cs.symbol_left,cs.symbol_right,m.TaxType,m.CreditCard,t.HeaderMenuButton from member_site ms inner join members m on ms.MemberID=m.MemberID left outer join template t on m.templateID=t.templateID left outer join currencies cs on ms.currency_id=cs.currency_id where ms.MemberID=".$MemberID;
			return $this->query($strSQLQuery, 1);

		}

		function  GetStoreByUserName($UserName)
		{
			$strSQLQuery = "select m.*,ms.Name as Membership,c.name as Country,s.name as State,ct.name as City from members m left outer join  membership ms on m.MembershipID=ms.MembershipID left outer join country c on m.country_id=c.country_id left outer join state s on m.state_id=s.state_id left outer join city ct on m.city_id=ct.city_id where m.UserName='".$UserName."' and m.Status=1 and m.Type='Seller'";
			return $this->query($strSQLQuery, 1);
		}

		function  AlphaStores($Status,$key)
		{
			$strSQLQuery = "select MemberID,UserName,CompanyName,Image,TagLine,Ranking,CreditCard from members where Type='Seller' and WebsiteStoreOption in('s','ws')";

			$strSQLQuery .= ($Status>0)?(" and Status=".$Status):("");
			$strSQLQuery .= (!empty($key))?(" and (CompanyName LIKE '".$key."%')"):("");

			$strSQLQuery .= ' order by Ranking desc';

			return $this->query($strSQLQuery, 1);
		}

		function  AlphaWebsites($Status,$key)
		{
			$strSQLQuery = "select MemberID,UserName,CompanyName,Image,TagLine,Ranking,CreditCard from members where Type='Seller' and WebsiteStoreOption in('w','ws')";

			$strSQLQuery .= ($Status>0)?(" and Status=".$Status):("");
			$strSQLQuery .= (!empty($key))?(" and (CompanyName LIKE '".$key."%')"):("");

			$strSQLQuery .= ' order by MemberID desc';

			return $this->query($strSQLQuery, 1);
		}

		
		function  SearchStores($Status,$key,$country_id,$state_id)
		{
			$strSQLQuery = "select MemberID,UserName,CompanyName,Image,TagLine,Ranking,CreditCard from members where Type='Seller' ";

			$strSQLQuery .= ($Status>0)?(" and Status=".$Status):("");
			$strSQLQuery .= (!empty($key))?(" and (CompanyName LIKE '%".$key."%')"):("");
			$strSQLQuery .= (!empty($country_id))?(" and country_id=".$country_id):("");
			$strSQLQuery .= (!empty($state_id))?(" and state_id=".$state_id):("");

			$strSQLQuery .= ' order by MemberID desc';

			return $this->query($strSQLQuery, 1);
		}

		function getStoreCountry()
		{
			$sql  = " where m.Type='Seller' and m.Status=1 "; 

			$sql="select distinct(c.country_id),c.name from country c inner join members m on c.country_id=m.country_id ".$sql." order by c.name";
			return $this->query($sql);
		}

		function  AllStores($Status)
		{
			$strSQLQuery = "select MemberID,UserName,CompanyName,Image,TagLine,Ranking,CreditCard from members where Type='Seller' and WebsiteStoreOption in('s','ws')";

			$strSQLQuery .= ($Status>0)?(" and Status=".$Status):("");

			$strSQLQuery .= ' order by CompanyName Asc';

			return $this->query($strSQLQuery, 1);
		}


		function FeaturedDisabled($MemberIDs)
		{
					
			$sql="update members set Featured='No' where MemberID in(".$MemberIDs.")";
			$this->query($sql,0);
			return true;

		}

		function FeaturedWebDisabled($MemberIDs)
		{
					
			$sql="update members set FeaturedWeb='No' where MemberID in(".$MemberIDs.")";
			$this->query($sql,0);
			return true;

		}

		function  FeaturedStores($Status)
		{
			$strSQLQuery = "select * from members where Type='Seller' and Featured='Yes' and Status=1 and WebsiteStoreOption in('s','ws') ";

			$strSQLQuery .= ' order by rand()';

			return $this->query($strSQLQuery, 1);
		}

		function  FeaturedWebsites($Status)
		{
			$strSQLQuery = "select * from members where Type='Seller' and FeaturedWeb='Yes' and Status=1 and WebsiteStoreOption in('w','ws') order by CompanyName";

			//$strSQLQuery = "select * from members";

			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetCompanies($id=0)
		{
			$strAddQuery = (!empty($id))?(" where MemberID=".$id):(" where 1 ");

			$strAddQuery .= " and Status=1 order by rand() ";

			$strSQLQuery = "select * from members ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}


		function  GetStoreDetails($id=0)
		{
			$strSQLQuery = "select * from members where Status=1 and Type='Seller' and MemberID=".$id;
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetPremiumCompanies()
		{
			$strAddQuery .= " and Status=1 order by rand() ";

			$strSQLQuery = "select * from members where Premium='y' ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		function  GetCompaniesByCountry($country_id)
		{
			$strAddQuery = (!empty($country_id))?(" where country_id=".$country_id):(" where 1 ");

			$strAddQuery .= " and Status=1 order by rand() ";

			$strSQLQuery = "select * from members ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		function  GetMemberDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where m.MemberID=".$id):(" where 1 ");

			$strAddQuery .= " order by m.JoiningDate Desc ";

			$strSQLQuery = "select m.*,ms.Name as Membership,ms.MaxProductImage from members m left outer join  membership ms on m.MembershipID=ms.MembershipID ".$strAddQuery;
			return $this->query($strSQLQuery, 1); 
		}

		function  GetMemberInDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where m.MemberID=".$id." and m.Status=1"):(" where m.Status=1 ");

			$strAddQuery .= " order by m.JoiningDate Desc ";

			$strSQLQuery = "select m.*,ms.Name as Membership,c.name as Country from members m left outer join  membership ms on m.MembershipID=ms.MembershipID left outer join country c on m.country_id=c.country_id ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}
		
		function AddMember($arryDetails)
		{  
			
			extract($arryDetails);
			$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../html/"):("html/");

			if($Type=='Buyer') $MembershipID = 4;
			if($templatePage<=0) $templatePage = 1;
			
			/*
			$arryMembership = $this->getMembership($MembershipID,'');
			$MaxEmail = $arryMembership[0]['MaxEmail'];
			$MaxSms = $arryMembership[0]['MaxSms'];*/

			/*******************/	

			if($TaxType == 'Other'){
				$TaxType = $TaxTypeOther;
			}


			$strSQLQuery = "insert into members (Type,MembershipID,WebsiteStoreOption ,templateID,templatePage,UserName,Email,Password,FirstName,LastName,CompanyName,ContactPerson, Position, RegistrationNumber,VatNumber,VatPercentage,TaxType, ContactNumber,Address,Website, city_id,state_id, PostCode,country_id,Phone,LandlineNumber,IDNumber, SkypeAddress,AlternateEmail,Fax,Status,JoiningDate,SecurityQuestion,Answer,Featured,FeaturedWeb,TagLine,FeaturedType,Impression,ImpressionCount,FeaturedStart,FeaturedEnd ,FeaturedWebType,WebImpression,WebImpressionCount,FeaturedWebStart,FeaturedWebEnd
,EmailSubscribe,SmsSubscribe,BillingFirstName,BillingLastName,BillingCompany, BillingAddress,BillingLandline,BillingEmail,MaxEmail,MaxSms,AreaCode,isd_code) values( '".$Type."', '".$MembershipID."','".$WebsiteStoreOption."', '".$templateID."', '".$templatePage."','".addslashes($UserName)."','".addslashes($Email)."', '".$Password."','".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($CompanyName)."', '".addslashes($ContactPerson)."', '".addslashes($Position)."', '".addslashes($RegistrationNumber)."', '".addslashes($VatNumber)."','".addslashes($VatPercentage)."' ,'".addslashes($TaxType)."' , '".addslashes($ContactNumber)."', '".addslashes($Address)."', '".$Website."', '".$main_city_id."', '".$main_state_id."','".$PostCode."', '".$country_id."', '".addslashes($Phone)."','".addslashes($LandlineNumber)."','".addslashes($IDNumber)."','".addslashes($SkypeAddress)."', '".addslashes($AlternateEmail)."', '".addslashes($Fax)."','".$Status."', '".date('Y-m-d H:i:s')."', '".addslashes($SecurityQuestion)."', '".addslashes($Answer)."', '".$Featured."','".$FeaturedWeb."', '".addslashes($TagLine)."', '".$FeaturedType."'
			, '".$Impression."', '".$ImpressionCount."', '".$FeaturedStart."', '".$FeaturedEnd."', '".$FeaturedWebType."','".$WebImpression."','".$WebImpressionCount."', '".$FeaturedWebStart."','".$FeaturedWebEnd."', '".$EmailSubscribe."','".$SmsSubscribe."', '".addslashes($BillingFirstName)."', '".addslashes($BillingLastName)."', '".addslashes($BillingCompany)."', '".addslashes($BillingAddress)."', '".addslashes($BillingLandline)."', '".addslashes($BillingEmail)."','".$MaxEmail."', '".$MaxSms."', '".addslashes($AreaCode)."', '".addslashes($isd_code)."')";
			$this->query($strSQLQuery, 0);

			$Counter = $this->lastInsertId(); 
			
			$MemberID = 100+$Counter;


			$sql = "update members set MemberID='".$MemberID."' where Counter='".$Counter."'";
			$this->query($sql, 0);

		


			if($MemberApproval == 'Auto'){

				$sql = "select * from membership where MembershipID='".$MembershipID."'";
				$arryRow = $this->query($sql, 1);

				if($arryRow[0]['MembershipID']>0){

					$l_ExpiryDate = strtotime(date('Y-m-d H:i:s')) + round($arryRow[0]['Validity']*24*3600,0);
					$ExpiryDate = date('Y-m-d H:i:s',$l_ExpiryDate); 

					$strSQLQuery = "update members set  ExpiryDate='".$ExpiryDate."' where MemberID=".$MemberID; 
					$this->query($strSQLQuery, 0);


					$strSQLQuery = "insert into membership_history (MemberID,MembershipID,PackageName,StartDate,EndDate) values( '".$MemberID."','".$MembershipID."', '".addslashes($arryRow[0]['Name'])."','".date('Y-m-d H:i:s')."', '".$ExpiryDate."')";
					$this->query($strSQLQuery, 0); 

				}

				$contents = file_get_contents($htmlPrefix."logindetails.htm");
				$subject  = "Account Details";

			}else if($MemberApproval == 'Admin'){
				$_SESSION['mess_account'] = VERIFIED_BY_ADMIN;

				$contents = file_get_contents($htmlPrefix."verify_admin.htm");
				$subject  = "Account will be activated by administrator";
			}else {
				$_SESSION['mess_account'] = VERIFIED_BY_EMAIL;

				$verification_code = substr(md5(rand(100,1000)),0,15);
				$sql = "update members set verification_code = '".$verification_code."' where MemberID=".$MemberID;

				$this->query($sql, 0);
				$contents = file_get_contents($htmlPrefix."verify_account.htm");
				$subject  = "Account Verification";
			}



			global $Config;
			
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	

			$contents = str_replace("[ACTIVATE_URL]",$Config['Url']."activateAccount.php?activeID=".$MemberID."&vrCode=".$verification_code,$contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}

			//echo $Email.$Config['AdminEmail'].$contents; exit;



			if($Config['RecieveSignEmail']=='y'){

					/************ Send Acknowledgment Email to admin *********************/
					$remNum = $Counter%10;
					if($remNum==1) $CountSuffix = 'st';
					else if($remNum==2) $CountSuffix = 'nd';
					else if($remNum==3) $CountSuffix = 'rd';
					else $CountSuffix = 'th';

					$contents = file_get_contents($htmlPrefix."admin_signup.htm");

					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

					$contents = str_replace("[FULLNAME]",$FirstName." ".$LastName, $contents);
					$contents = str_replace("[EMAIL]",$Email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[TYPE]",$Type,$contents);
					$contents = str_replace("[USERNAME]",$UserName,$contents);
					$contents = str_replace("[ReferenceNo]",$MemberID,$contents);
					$contents = str_replace("[CountNum]",$Counter.$CountSuffix,$contents);

					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Config['AdminEmail']);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - ".$subject;
					$mail->IsHTML(true);
					//echo $Config['AdminEmail'].$contents; exit;
					$mail->Body = $contents;    
					if($Config['DbUser'] != 'root'){
						$mail->Send();	
					}

			}


			return $MemberID;

		}

		function UpdateMember($arryDetails)
		{   
			extract($arryDetails);

			if($Type=='Buyer') $MembershipID = 4;
			if($templatePage<=0) $templatePage = 1;


			if($TaxType == 'Other'){
				$TaxType = $TaxTypeOther;
			}


			$strSQLQuery = "update members set MembershipID='".$MembershipID."',templateID='".$templateID."',templatePage='".$templatePage."' ,ExpiryDate='".$ExpiryDate."', UserName='".addslashes($UserName)."', Email='".addslashes($Email)."', Password='".$Password."', FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', CompanyName='".addslashes($CompanyName)."', 
			ContactPerson='".addslashes($ContactPerson)."', Position='".addslashes($Position)."', RegistrationNumber='".addslashes($RegistrationNumber)."',  VatNumber='".addslashes($VatNumber)."', VatPercentage='".addslashes($VatPercentage)."' ,TaxType='".addslashes($TaxType)."',
			ContactNumber='".addslashes($ContactNumber)."',  
			Address='".addslashes($Address)."',  Website='".addslashes($Website)."', city_id='".$main_city_id."', state_id='".$main_state_id."', PostCode='".$PostCode."', country_id='".$country_id."', Phone='".addslashes($Phone)."', LandlineNumber='".addslashes($LandlineNumber)."', IDNumber='".addslashes($IDNumber)."', SkypeAddress='".addslashes($SkypeAddress)."', AlternateEmail='".addslashes($AlternateEmail)."', Fax='".addslashes($Fax)."', Status='".$Status."', SecurityQuestion='".addslashes($SecurityQuestion)."', Answer='".addslashes($Answer)."', Featured='".$Featured."' , FeaturedWeb='".$FeaturedWeb."', TagLine='".addslashes($TagLine)."', FeaturedType='".$FeaturedType."', Impression='".$Impression."', ImpressionCount='".$ImpressionCount."', FeaturedStart='".$FeaturedStart."', FeaturedEnd='".$FeaturedEnd."' , 
			FeaturedWebType='".$FeaturedWebType."', WebImpression='".$WebImpression."', WebImpressionCount='".$WebImpressionCount."', FeaturedWebStart='".$FeaturedWebStart."', FeaturedWebEnd='".$FeaturedWebEnd."',
			EmailSubscribe='".$EmailSubscribe."', SmsSubscribe='".$SmsSubscribe."', 
			BillingFirstName='".addslashes($BillingFirstName)."', BillingLastName='".addslashes($BillingLastName)."', BillingCompany='".addslashes($BillingCompany)."', BillingAddress='".addslashes($BillingAddress)."', BillingLandline='".addslashes($BillingLandline)."', BillingEmail='".addslashes($BillingEmail)."',
			PostingApproval='".$PostingApproval."',
			WebsiteStoreOption='".$WebsiteStoreOption."',
			MaxEmail='".$MaxEmail."', MaxSms='".$MaxSms."',AreaCode='".addslashes($AreaCode)."',isd_code='".addslashes($isd_code)."'
			where MemberID=".$MemberID; 

			$this->query($strSQLQuery, 0);

			

			//////******** Updating Expiry Date *********///////// 

			$MembershipID = $PackageID;
			if($ExpiryDate<=0 && $Status==1){

				$sql = "select * from membership where MembershipID='".$MembershipID."'";
				$arryRow = $this->query($sql, 1); 

				if($arryRow[0]['MembershipID']>0){

					$l_ExpiryDate = strtotime($JoiningDate) + round($arryRow[0]['Validity']*24*3600,0);
					$ExpiryDate = date('Y-m-d H:i:s',$l_ExpiryDate); 

					$strSQLQuery = "update members set  ExpiryDate='".$ExpiryDate."' where MemberID=".$MemberID; 
					$this->query($strSQLQuery, 0);

				}

			}


			return 1;
		}



		function UpdateCompany($arryDetails)
		{
			extract($arryDetails);

			if($TaxType == 'Other'){
				$TaxType = $TaxTypeOther;
			}


			$strSQLQuery = "update members set FirstName='".addslashes($FirstName)."',LastName='".addslashes($LastName)."',  CompanyName='".addslashes($CompanyName)."', ContactPerson='".addslashes($ContactPerson)."', Position='".addslashes($Position)."', RegistrationNumber='".addslashes($RegistrationNumber)."', 
			ContactNumber='".addslashes($ContactNumber)."', TagLine='".addslashes($TagLine)."', Address='".addslashes($Address)."',  Website='".addslashes($Website)."', city_id='".$main_city_id."', state_id='".$main_state_id."', PostCode='".$PostCode."', country_id='".$country_id."', Phone='".addslashes($Phone)."', LandlineNumber='".addslashes($LandlineNumber)."', IDNumber='".addslashes($IDNumber)."',SkypeAddress='".addslashes($SkypeAddress)."',AlternateEmail='".addslashes($AlternateEmail)."',
			Fax='".addslashes($Fax)."', EmailSubscribe='".$EmailSubscribe."', SmsSubscribe='".$SmsSubscribe."',  VatNumber='".addslashes($VatNumber)."', VatPercentage='".addslashes($VatPercentage)."' ,TaxType='".addslashes($TaxType)."',
			BillingFirstName='".addslashes($BillingFirstName)."', BillingLastName='".addslashes($BillingLastName)."', BillingCompany='".addslashes($BillingCompany)."', BillingAddress='".addslashes($BillingAddress)."', BillingLandline='".addslashes($BillingLandline)."', BillingEmail='".addslashes($BillingEmail)."',AreaCode='".addslashes($AreaCode)."',isd_code='".addslashes($isd_code)."'
			where MemberID=".$MemberID; 

			$this->query($strSQLQuery, 0);
			
			return 1;

		}

		function UpdateStorePayment($arryDetails)
		{
			extract($arryDetails);

			if($MyGatePayment==1 || $PaypalPayment==1){ 
				$CreditCard='Yes';
			}else{
				$CreditCard='No';
			}

			$strSQLQuery = "update members set CreditCard='".$CreditCard."' where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$this->query($strSQLQuery, 0);
			
			return 1;

		}


		function  GetDeliveryFee($StoreID,$Status)
		{
			$strSQLQuery = "select * from delivery_fee where StoreID=".$StoreID;
			$strSQLQuery .= (!empty($Status))?(" and Status=1"):("");
			$strSQLQuery .= " order by Name desc";
			
			return $this->query($strSQLQuery, 1);

		}


		function UpdateDeliveryFee($arryDetails)
		{
			extract($arryDetails);
			
		 	 $sql = "delete from delivery_fee where StoreID = ".$MemberID;
			 $this->query($sql,0);

				for($i=1; $i<=$DeliveryOption; $i++){
					$DeliveryName = 'DeliveryName'.$i; 
					$Name = $$DeliveryName;
					
					$DeliveryFee = 'DeliveryFee'.$i; 
					$Price = $$DeliveryFee;

					$DeliveryStatus = 'DeliveryStatus'.$i; 
					$Status = $$DeliveryStatus;
					

					$sql = "insert into delivery_fee(Name,Price,StoreID,Status) values('".addslashes($Name)."','".$Price."', '".$MemberID."', '".$Status."')";
					$rs = $this->query($sql,0);


					/*
					$sql2 ="select * from delivery_fee where LCASE(Name) = '".strtolower(trim($Name))."' and StoreID=".$MemberID;
					$arryRow = $this->query($sql2, 1);

					if (!empty($arryRow[0]['DeliveryID'])) {
						$sql="update delivery_fee set Name='".addslashes($Name)."', Price='".$Price."', Status='".$Status."'  where DeliveryID=".$arryRow[0]['DeliveryID']; 
						$rs = $this->query($sql,0);

					} else {

						$sql = "insert into delivery_fee(Name,Price,StoreID,Status) values('".addslashes($Name)."','".$Price."', '".$MemberID."', '".$Status."')";
						$rs = $this->query($sql,0);
						
					}
					*/
				}


			
			return 1;

		}


		function UpdateSellerAccount($arryDetails)
		{
			extract($arryDetails);


			$strSQLQuery = "update members set FirstName='".addslashes($FirstName)."',LastName='".addslashes($LastName)."',  CompanyName='".addslashes($CompanyName)."' ,Address='".addslashes($Address)."'  ,templateID='1', Website='".addslashes($Website)."', city_id='".$main_city_id."', state_id='".$main_state_id."', PostCode='".$PostCode."', country_id='".$country_id."', Phone='".addslashes($Phone)."',Fax='".addslashes($Fax)."',Type='Seller',EmailSubscribe='".$EmailSubscribe."',SmsSubscribe='".$SmsSubscribe."'
			where MemberID=".$MemberID; 

			$this->query($strSQLQuery, 0);
	
			
			return 1;

		}



		function UpdateAccount($arryDetails)
		{
			extract($arryDetails);

			$strSQLQuery = "update members set FirstName='".addslashes($FirstName)."',LastName='".addslashes($LastName)."', CompanyName='".addslashes($CompanyName)."', 
			ContactPerson='".addslashes($ContactPerson)."', Position='".addslashes($Position)."', RegistrationNumber='".addslashes($RegistrationNumber)."', 
			ContactNumber='".addslashes($ContactNumber)."',  Address='".addslashes($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', PostCode='".$PostCode."', country_id='".$country_id."', Phone='".addslashes($Phone)."', LandlineNumber='".addslashes($LandlineNumber)."',IDNumber='".addslashes($IDNumber)."',Fax='".addslashes($Fax)."', EmailSubscribe='".$EmailSubscribe."', SmsSubscribe='".$SmsSubscribe."',isd_code='".addslashes($isd_code)."'
			where MemberID=".$MemberID; 

			$this->query($strSQLQuery, 0);

			
			return 1;
		}		
		
	


	
		function UpdateMemberSeo($arryDetails)
		{
			extract($arryDetails);

			$sql ="select MemberID from member_info where MemberID=".$MemberID;

			$arryRow = $this->query($sql, 1);
			if (empty($arryRow[0]['MemberID'])) {
				$sql = "insert into member_info (MemberID,MetaTitle,MetaKeywords,MetaDescription) values('".$MemberID."','".addslashes($MetaTitle)."', '".addslashes($MetaKeywords)."', '".addslashes($MetaDescription)."')";
				$rs = $this->query($sql,0);
			} else {
				$sql = "update member_info set MetaTitle = '".addslashes($MetaTitle)."',MetaKeywords = '".addslashes($MetaKeywords)."',  MetaDescription = '".addslashes($MetaDescription)."'  where MemberID = ".$MemberID;
				$rs = $this->query($sql,0);
			}

			return true;

		}


		function ChangePassword($arryDetails)
		{
			extract($arryDetails);
			$strSQLQuery = "update members set Password='".$Password."'
			where MemberID=".$MemberID;

			$this->query($strSQLQuery, 0);


			/****************************/
			$UserName = $_SESSION['UserName'];

			


			/****************************/


			$contents = file_get_contents("html/password.htm");
			global $Config;
			$FullName = $Name;
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FULLNAME]",$FullName,$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[USERNAME]",$UserName,$contents);
				
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Your login details have been reset";
			$mail->IsHTML(true);
			$mail->Body = $contents;  
			//echo $Email.$Config['AdminEmail'].$contents; exit;
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}

			return 1;
		}		
		
		function GetMemberQuestion($Email)
		{
			$sql = "select SecurityQuestion,MemberID from members where Email='".$Email."' and Status = 1"; 
			$arryRow = $this->query($sql, 1);
			
			if(sizeof($arryRow))
			{
				return $arryRow[0]['SecurityQuestion'];
			}else{
				return 0;
			}
		}

		function IsActivatedMember($MemberID,$verification_code)
		{
			$sql = "select * from members where MemberID='".$MemberID."' and verification_code='".$verification_code."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['MemberID']>0) {
				if ($arryRow[0]['Status']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}

		function IsSubscribedMember($MemberID)
		{
			$sql = "select EmailSubscribe,MemberID from members where MemberID='".$MemberID."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['MemberID']>0) {
				if ($arryRow[0]['EmailSubscribe']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}
		
		function ActivateMember($MemberID,$verification_code)
		{
			
			$sql = "select * from members where MemberID='".$MemberID."' and verification_code='".$verification_code."'";
			$arryRow = $this->query($sql, 1);



			if ($arryRow[0]['MemberID']>0) {

				$MembershipID = 1 ;
				if($arryRow[0]['MembershipID'] > 0){
					$MembershipID=$arryRow[0]['MembershipID'];
				}

				 $sql = "select * from membership where MembershipID='".$MembershipID."'";

				$arryPackage = $this->query($sql, 1);


				$l_ExpiryDate = strtotime(date('Y-m-d')) + round($arryPackage[0]['Validity']*24*3600,0);
				$ExpiryDate = date('Y-m-d',$l_ExpiryDate); 
				
				$sql = "update members set Status='1',JoiningDate='".date('Y-m-d')."',ExpiryDate='".$ExpiryDate."',ExpiryMailSent=0 
				where MemberID=".$MemberID; 

				$this->query($sql, 0);


				$strSQLQuery = "insert into membership_history (MemberID,MembershipID,PackageName,StartDate,EndDate) values( '".$MemberID."','".$MembershipID."', '".addslashes($arryPackage[0]['Name'])."','".date('Y-m-d H:i:s')."', '".$ExpiryDate."')";
				$this->query($strSQLQuery, 0);


				$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../html/"):("html/");

				$contents = file_get_contents($htmlPrefix."afterActivate.htm");
				global $Config;
			
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$contents = str_replace("[FULLNAME]",$arryRow[0]['FirstName'], $contents);
				$contents = str_replace("[USERNAME]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EMAIL]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[PASSWORD]",$arryRow[0]['Password'],$contents);	
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
				
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Account activated";
				$mail->IsHTML(true);
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			}

			return 1;
		}
		

		function UpdatePaidMembership($MemberID,$MembershipID,$payment_gatewayId)
		{

			$sql = "select * from membership where MembershipID='".$MembershipID."'";
			$arryRow = $this->query($sql, 1);
			$price = round($arryRow[0]['Price'],2);
			
			$strSQLQuery333 = "select *  from payment_gateway where id=".$payment_gatewayId;
			$arryRow333 = $this->query($strSQLQuery333, 1);
			$payment_gateway = $arryRow333[0]['name'];


			$sqlMember = "select UserName,CompanyName from members where MemberID='".$MemberID."'";
			$arryMember = $this->query($sqlMember, 1);

				global $Config;


			if($payment_gatewayId==3 || $payment_gatewayId==4){
				$PaymentStatus=0;
				$sql = "insert into membership_history (MemberID,MembershipID,PackageName ,Price,PaymentGateway,Payment) values('".$MemberID."', '".$MembershipID."', '".stripslashes($arryRow[0]['Name'])."', '".$price."','".$payment_gateway."','0')";

				$this->query($sql, 0);



				$lastInsertId = $this->lastInsertId(); 


				/******** acknowledgement to administrator ********/

				$contents = file_get_contents("html/ack.htm");
				$StoreUrl = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';

				$MailContent = $payment_gateway.' payment has been done for membership amendment on <a href="'.$Config['Url'].'">'.$Config['SiteName'].'</a>.<br><br>
				<B>For Membership :</B> '.stripslashes($arryRow[0]['Name']).'<br><br>
				<B>User Name :</B> '.$arryMember[0]['UserName'].'<br><br>
				<B>Company Name :</B> '.$arryMember[0]['CompanyName'].'<br><br>
				<B>Store :</B> <a href="'.$StoreUrl.'" target="_blank">'.$StoreUrl.'</a><br>';

				$contents = str_replace("[MAIL_CONTENT]",$MailContent,$contents);
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
						
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$payment_gateway.' payment for membership amendment';
				$mail->IsHTML(true);
				$mail->Body = $contents;  

				//echo $Config['AdminEmail'].$contents; exit;
				
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

				
			}else{

				$PaymentStatus=1;
				
				/******************/
				$sql = "select max(StartDate) as LastTime from membership_history where MemberID='".$MemberID."'";
				$arryMembership= $this->query($sql, 1);
				$LastUpgradedMin = (strtotime(date('Y-m-d H:i:s')) - strtotime($arryMembership[0]['LastTime']))/60;
					
				/*
				if($LastUpgradedMin < 5){

					echo '<script>location.href="index.php";</script>';
					exit;

				}*/
				


				$StartExp = date('Y-m-d H:i:s');

				$sql_2 = "select * from members where MemberID='".$MemberID."'";
				$arryRow2 = $this->query($sql_2, 1);
				if ($arryRow2[0]['MembershipID']>1) {
					$StartExp = $arryRow2[0]['ExpiryDate'];
				}
				
				

				if ($arryRow[0]['MembershipID']>0) {

					$l_ExpiryDate = strtotime($StartExp) + round($arryRow[0]['Validity']*24*3600,0);
					$ExpiryDate = date('Y-m-d H:i:s',$l_ExpiryDate); 

					//$MaxEmail = $arryRow2[0]['MaxEmail']+$arryRow[0]['MaxEmail'];
					//$MaxSms = $arryRow2[0]['MaxSms']+$arryRow[0]['MaxSms'];

					//$sql = "update members set MembershipID='".$MembershipID."',PaidMember='yes',Status=1,ExpiryDate='".$ExpiryDate."',ExpiryMailSent=0,MaxEmail='".$MaxEmail."',MaxSms='".$MaxSms."' where MemberID=".$MemberID; 

					$sql = "update members set MembershipID='".$MembershipID."',PaidMember='yes',Status=1,ExpiryDate='".$ExpiryDate."',ExpiryMailSent=0 where MemberID=".$MemberID; 
					$this->query($sql, 0); 


					$sql = "insert into membership_history (MemberID,MembershipID,PackageName ,StartDate,EndDate,Price,PaymentGateway,Payment) values('".$MemberID."', '".$MembershipID."', '".stripslashes($arryRow[0]['Name'])."', '".date('Y-m-d H:i:s')."', '".$ExpiryDate."','".$price."','".$payment_gateway."','".$PaymentStatus."')";

					$this->query($sql, 0);
					$lastInsertId = $this->lastInsertId(); 
					

				}
				
			}


			/******************/
			$PaymentFor = 'Membership amendment ('.stripslashes($arryRow[0]['Name']).')';
			$objPay=new payment();
			$objPay->addPayment($PaymentFor,$lastInsertId , '2', $MemberID, $arryMember[0]['UserName'], $payment_gatewayId, $price, $PaymentStatus);
			/******************/


			return $lastInsertId;
			
		}


		function SendMembershipMail($MemberID,$id)
		{
			$sql = "select * from members where MemberID='".$MemberID."'"; 
			$arryRow = $this->query($sql, 1);
			
			if(sizeof($arryRow))
			{

				$sqlHist = "select id from membership_history where MemberID='".$MemberID."' and MembershipID>1";
				$arryHist = $this->query($sqlHist, 1);

				
				if(sizeof($arryHist)>0){
					$MembershipMessage = 'Thank you for renewing your membership. Your services will be reactivated shortly.';
				}else{
					$MembershipMessage = 'Welcome to the Oriental Merchant.<br><br>
						Please contact us if you need any assistance.';
				}


			$sqlPackage = "select hs.*,ms.Validity from membership_history hs inner join membership ms on hs.MembershipID=ms.MembershipID where hs.id='".$id."'";

			$arryPackage = $this->query($sqlPackage, 1);

			$payment_method_detail ='';
			

			if($arryPackage[0]['PaymentGateway']=='EFT / Bank Tranfer' || $arryPackage[0]['PaymentGateway']=='Direct Deposit'){

				if($arryPackage[0]['EndDate']>0 && $arryPackage[0]['Payment']==1){
					$ExpiryDate = '<b>Expiry Date :</b>'.date("jS F  y", strtotime($arryRow[0]['ExpiryDate']));
					$MembershipMessage = 'You below membership has been activated. Your services will be reactivated shortly. ';

				}else{
					$strSQLQuery22 ="select * from configuration where ConfigID=1";
					$arryRow22 = $this->query($strSQLQuery22, 1);
						$payment_method_detail .= '<table border=0 cellpadding=3 cellspacing=3>';
						$payment_method_detail .= '<tr><td nowrap>Account Holder : </td><td>'.$arryRow22[0]['AccountHolder'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Account Number : </td><td>'.$arryRow22[0]['AccountNumber'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Bank Name : </td><td>'.$arryRow22[0]['BankName'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Branch Code : </td><td>'.$arryRow22[0]['BranchCode'].'</td></tr>';
						$payment_method_detail .= '<tr><td nowrap>Swift Number : </td><td>'.$arryRow22[0]['SwiftNumber'].'</td></tr>';
						$payment_method_detail .= '</table>';

					$ExpiryDate = '';
				}
				
			}else{
				$ExpiryDate = '<b>Expiry Date:&nbsp;&nbsp;</b>'.date("jS F  y", strtotime($arryRow[0]['ExpiryDate']));

			}


				$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../html/"):("html/");
				$contents = file_get_contents("".$htmlPrefix."membership.htm");


				global $Config;
				$AmountPaid = $Config['Currency'].' '.$arryPackage[0]['Price'];
				$FullName = $arryRow[0]['Name'];
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[PACKAGE]",$arryPackage[0]['PackageName'],$contents);
				$contents = str_replace("[AMOUNT]",$AmountPaid,$contents);
				$contents = str_replace("[EXPIRY_DATE]",$ExpiryDate,$contents);
				$contents = str_replace("[FULLNAME]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[MEMBERSHIP_MSG]",$MembershipMessage,$contents);	
				$contents = str_replace("[PAYMENT_GATWAY]",$arryPackage[0]['PaymentGateway'],$contents);
				$contents = str_replace("[PAYMENT_METHOD_DETAIL]",$payment_method_detail ,$contents);

		
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Membership amendment";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

				$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../html/"):("html/");
				$contents = file_get_contents("".$htmlPrefix."membership.htm");


				global $Config;

				
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[PACKAGE]",$arryPackage[0]['PackageName'],$contents);
				$contents = str_replace("[AMOUNT]",$AmountPaid,$contents);
				$contents = str_replace("[EXPIRY_DATE]",$ExpiryDate,$contents);
				$contents = str_replace("[FULLNAME],",'',$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[MEMBERSHIP_MSG]<BR><BR><BR>",'',$contents);	
				$contents = str_replace("[PAYMENT_GATWAY]",$arryPackage[0]['PaymentGateway'],$contents);
				$contents = str_replace("[PAYMENT_METHOD_DETAIL]",$payment_method_detail ,$contents);

		
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryRow[0]['UserName'], $arryRow[0]['Email']);   
				$mail->Subject = $Config['SiteName']." - Membership amendment, your approval needed.";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}


				return 1;
			}else{
				return 0;
			}


		}	
		
		
		function ForgotPassword($Email,$Type)
		{
			$sql = "select * from members where Email='".$Email."' and Status=1"; 
			//$sql .= (!empty($Type))?(" and Type='".$Type."'"):("");

			$arryRow = $this->query($sql, 1);

			$UserName = $arryRow[0]['UserName'];

			if(sizeof($arryRow)>0)
			{
				$Password = substr(md5(rand(100,10000)),0,8);
				
				$sql_u = "update members set Password='".$Password."'
				where Email='".$Email."'";
				$this->query($sql_u, 0);


				


				$contents = file_get_contents("html/forgot.htm");
				global $Config;
				$FullName = $arryRow[0]['FirstName']." ".$arryRow[0]['LastName'];
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[USERNAME]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
						
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Email);
				$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - New password";
				$mail->IsHTML(true);
				$mail->Body = $contents;  

				//echo $Email.$Config['AdminEmail'].$contents; exit;

				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
				return 1;
			}else{
				return 0;
			}
		}		

		function SignUpEmail($Email)
		{
			$sql = "select * from email_signup where Email='".$Email."'"; 

			$arryRow = $this->query($sql, 1);

			if(sizeof($arryRow)>0){
				return 0;
			}else{

				$sql = "insert into email_signup (Email) values('".addslashes($Email)."')";
				$rs = $this->query($sql,0);

				return 1;
			}
		}		
		
		function RemoveMember($MemberID)
		{

			$strSQLQuery = "select Image,Banner,UserName,Email from members where MemberID=".$MemberID; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($Front > 0){
				$ImgDirPrefix = '';
			}else{
				$ImgDirPrefix = '../';
			}

			$ImgDir = $ImgDirPrefix.'upload/company/';
			$FckFolder = $ImgDirPrefix.'userfiles/'.$arryRow[0]['UserName'].'/';

			//Clear Fckeditor Image for User

			if(is_dir($FckFolder)) {
				$FckImageFolder = $ImgDirPrefix.'userfiles/'.$arryRow[0]['UserName'].'/image/';
				ClearDirectory($FckImageFolder);
				rmdir($FckImageFolder);
				rmdir($FckFolder);
			}
		
			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){					unlink($ImgDir.$arryRow[0]['Image']);	
			}


			if($arryRow[0]['Banner'] !='' && file_exists($ImgDir.$arryRow[0]['Banner']) ){					unlink($ImgDir.$arryRow[0]['Banner']);	
			}

			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.'thumbs/'.$arryRow[0]['Image']) ){			unlink($ImgDir.'thumbs/'.$arryRow[0]['Image']);
			}



			$strSQLQuery = "delete from members where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery = "delete from membership_history where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery = "delete from cart  where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from cart where StoreID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from orders where StoreID=".$MemberID; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "delete from orderdetail where StoreID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from ranking  where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "delete from ranking  where RaterID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from bid  where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "delete from bid  where SellerID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from banner  where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);


			$strSQLQuery = "delete from bulk where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "delete from bulk where StoreID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from comments where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "delete from comments where StoreID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from delivery_fee where StoreID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from store_categories where StoreID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from member_info where MemberID=".$MemberID; 
			$this->query($strSQLQuery, 0);

			return 1;

		}

		function UpdateImage($imageName,$MemberID)
		{
			$strSQLQuery = "update members set Image='".$imageName."' where MemberID=".$MemberID;
			return $this->query($strSQLQuery, 0);
		}
		function UpdateBanner($Banner,$MemberID)
		{
			$strSQLQuery = "update members set Banner='".$Banner."' where MemberID=".$MemberID;
			return $this->query($strSQLQuery, 0);
		}

		function SendExpiryNotification($MemberID)
		{
			$arryRow = $this->GetMemberDetail($MemberID);

			if(sizeof($arryRow)>0 && $arryRow[0]['ExpiryMailSent']==0)
			{

				$sql="update members set ExpiryMailSent='1' where MemberID=".$MemberID;
				$this->query($sql,0);

				$contents = file_get_contents("html/expiry_note.htm");
				global $Config;
				$FullName = $arryRow[0]['Name'];
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FULLNAME]",$arryRow[0]['FirstName'],$contents);
				$contents = str_replace("[PACKAGE]",$arryRow[0]['Membership'],$contents);	
				$contents = str_replace("[EXPIRY_DATE]",$arryRow[0]['ExpiryDate'],$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
				$contents = str_replace("[PORTAL_URL]",$Config['Url'].'member-area.php',$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Membership ".$arryRow[0]['Membership']." is about to expire ";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
				return 1;
			}
		}


		function ConvertMembership($MemberID)
		{
			$arryRow = $this->GetMemberDetail($MemberID);

			if(sizeof($arryRow)>0)
			{
				$sql="update members set MembershipID='1',ExpiryMailSent='0' where MemberID=".$MemberID;
				$this->query($sql,0);


				$contents = file_get_contents("html/expired.htm");
				global $Config;
				$FullName = $arryRow[0]['Name'];
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FULLNAME]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[PACKAGE]",$arryRow[0]['Membership'],$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
				$contents = str_replace("[PORTAL_URL]",$Config['Url'].'member-area.php',$contents);
						
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Membership (".$arryRow[0]['Membership'].") has expired ";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
				return 1;
			}
		}


		function changeFeaturedStatus($MemberID,$Featured)
		{
			$sql="update members set Featured='$Featured' where MemberID=".$MemberID;
			$this->query($sql,0);
		}

		function DisableStore($MemberID)
		{
			$sql="update members set Status='0' where MemberID=".$MemberID;
			$this->query($sql,0);
		}

		function UnsubscribeEmail($MemberID)
		{
			$sql="update members set EmailSubscribe='0' where MemberID=".$MemberID;
			$this->query($sql,0);
		}

		function changeMemberStatus($MemberID)
		{
			$sql="select * from members where MemberID=".$MemberID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update members set Status='$Status' where MemberID=".$MemberID;
				$this->query($sql,0);


				//////******** Updating Expiry Date *********///////// 

				if($rs[0]['ExpiryDate']<=0 && $Status==1){

					$sql = "select * from membership where MembershipID='".$rs[0]['MembershipID']."'";
					$arryRow = $this->query($sql, 1);

					if($arryRow[0]['MembershipID']>0){

						if($rs[0]['JoiningDate']<date('Y-m-d H:i:s')){
							$rs[0]['JoiningDate'] = date('Y-m-d H:i:s');
						}

						$l_ExpiryDate = strtotime($rs[0]['JoiningDate']) + round($arryRow[0]['Validity']*24*3600,0);
						$ExpiryDate = date('Y-m-d H:i:s',$l_ExpiryDate); 

						$strSQLQuery = "update members set  ExpiryDate='".$ExpiryDate."' where MemberID=".$MemberID; 
						$this->query($strSQLQuery, 0);

					}

				}

				return true;
			}			
		}

		function ActivateMembership($MemberID,$id)
		{
			$sql="select * from members where MemberID=".$MemberID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{

				$sql = "select hs.*,ms.Validity,ms.MaxEmail,ms.MaxSms from membership_history hs inner join membership ms on hs.MembershipID=ms.MembershipID where hs.id='".$id."'";
				$arryRow = $this->query($sql, 1);
				//////******** Updating Expiry Date *********///////// 
					if($arryRow[0]['MembershipID']>0){

						if($rs[0]['ExpiryDate']<date('Y-m-d H:i:s')){
							$rs[0]['ExpiryDate'] = date('Y-m-d H:i:s');
						}

						$l_ExpiryDate = strtotime($rs[0]['ExpiryDate']) + round($arryRow[0]['Validity']*24*3600,0);
						$ExpiryDate = date('Y-m-d H:i:s',$l_ExpiryDate); 


					//$MaxEmail = $rs[0]['MaxEmail']+$arryRow[0]['MaxEmail'];
					//$MaxSms = $rs[0]['MaxSms']+$arryRow[0]['MaxSms'];

					// $strSQLQuery = "update members set  MembershipID='".$arryRow[0]['MembershipID']."',ExpiryDate='".$ExpiryDate."',MaxEmail='".$MaxEmail."',MaxSms='".$MaxSms."' where MemberID=".$MemberID; 

					 $strSQLQuery = "update members set  MembershipID='".$arryRow[0]['MembershipID']."',ExpiryDate='".$ExpiryDate."' where MemberID=".$MemberID; 
					$this->query($strSQLQuery, 0);

						$strSQLQuery = "update membership_history set  StartDate ='".date('Y-m-d H:i:s')."',EndDate='".$ExpiryDate."',Payment=1 where id=".$id; 
						$this->query($strSQLQuery, 0);

					}

			}
			
			return true;


		}

		function MultipleMemberStatus($MemberIDs,$Status)
		{
			$sql="select * from members where MemberID in (".$MemberIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0)
			{

				$sql="update members set Status=".$Status." where MemberID in (".$MemberIDs.")";
				$this->query($sql,0);

				for($i=0;$i<sizeof($arryRow);$i++) {

						//////******** Updating Expiry Date *********///////// 

						if($arryRow[$i]['ExpiryDate']<=0 && $Status==1){

							$sql = "select * from membership where MembershipID='".$arryRow[$i]['MembershipID']."'";
							$arryRowMembership = $this->query($sql, 1);

							if($arryRowMembership[0]['MembershipID']>0){

								if($arryRow[$i]['JoiningDate']<date('Y-m-d H:i:s')){
									$arryRow[$i]['JoiningDate'] = date('Y-m-d H:i:s');
								}

								$l_ExpiryDate = strtotime($arryRow[$i]['JoiningDate']) + round($arryRowMembership[0]['Validity']*24*3600,0);
								$ExpiryDate = date('Y-m-d H:i:s',$l_ExpiryDate); 

								$strSQLQuery = "update members set  ExpiryDate='".$ExpiryDate."' where MemberID=".$arryRow[$i]['MemberID']; 
								$this->query($strSQLQuery, 0);

							}

						}

				}
				
			}	
			
			return true;

		}

		

		function UpdateMemberCart($MemberID, $PrdIDs)
		{
			$ProductIDArry = explode(",",$PrdIDs);

			foreach($ProductIDArry as $ProductID){
			
				$strSQLQuery = "select * from cart where MemberID='".$MemberID."' and ProductID='".$ProductID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['CartID'])) {
					$strSQLQuery = "delete from cart where CartID=".$arryRow[0]['CartID'];
					$this->query($strSQLQuery, 0);
				} 
				
			}
			$strSQLQuery = "update cart set MemberID='".$MemberID."' where MemberID='".session_id()."'"; 
			return $this->query($strSQLQuery, 0);
		}

		function ValidateMember($Email,$Password,$Type){
			$strSQLQuery = "select * from members where Email='".$Email."' and Password='".$Password."' and Status=1";
			$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");

		//echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}

		function isEmailExists($Email,$MemberID=0,$Type)
		{
			$strSQLQuery = (!empty($MemberID))?(" and MemberID != ".$MemberID):("");
			//$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");

			$strSQLQuery = "select * from members where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['MemberID'])) {
				return $arryRow[0]['Type'];
			} else {
				return false;
			}
		}

		function isUserNameExists($UserName,$MemberID=0,$Type)
		{
			$strSQLQuery = (!empty($MemberID))?(" and MemberID != ".$MemberID):("");
			//$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");

			$strSQLQuery = "select * from members where LCASE(UserName)='".strtolower(trim($UserName))."'".$strSQLQuery;
			
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['MemberID'])) {
				return $arryRow[0]['Type'];
			} else {
				return false;
			}
		}

		function isActiveMemberExists($Email)
		{
			$strSQLQuery = "select * from members where LCASE(Email)='".strtolower(trim($Email))."' and  Status=1";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['MemberID'])) {
				return true;
			} else {
				return false;
			}
		}
		function GetExtension($file){
			$revfile=strrev($file); // Reverse the string for getting the extension
			$arr_t=explode(".",$revfile);
			$file_type=$arr_t[0];
			return strrev($file_type);  // File Extension
		}
	

		/* ************** Membership Functions ****************/
		

		function UpdateMenuPostion($MembershipID,$sort_order)
		{
			 $sql = "select * from membership where MembershipID=".$MembershipID ;
			 $arr = $this->query($sql, 1);
			  $MembershipID = $arr[0]['MembershipID']; 
			 $OldPos = $arr[0]['sort_order'];
			
			if($MembershipID > 0){
				 $sql2 = "update membership set sort_order=".$OldPos." where sort_order=".$sort_order;
				 $this->query($sql2, 0);
				 
			}

			 $sql = "update membership set sort_order = ".$sort_order."  where MembershipID = ".$MembershipID;
			$rs = $this->query($sql,0);
			if(sizeof($rs))
				return true;
			else
				return false;
		}

		function UpdateTestPostion($MembershipID,$sort_order)
		{
			$sql = "update membership set sort_order = ".$sort_order."  where MembershipID = ".$MembershipID;
			$rs = $this->query($sql,0);
			if(sizeof($rs))
				return true;
			else
				return false;
		}
		function  ListMembership($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = ' where deleted=0 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and MembershipID=".$id):("");


			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (Name like '".$SearchKey."%' or Validity like '%".$SearchKey."%' or Price like '".$SearchKey."%')"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by sort_order ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from membership".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		function addMembership($ArryRequest)
		{
		 	extract($ArryRequest);

			$sql="select max(sort_order) as MaxSort from membership where deleted=0";
			$rs = $this->query($sql);
			$sort_order = $rs[0]['MaxSort']+1;


			$sql="insert into membership (Name, Description, Validity, Price, ReferralAmount, Status,  MaxProduct,MaxProductImage,MaxEmail,MaxSms,sort_order) values('".addslashes($Name)."', '".addslashes($Description)."', '$Validity', '$Price','$ReferralAmount', '$Status', '$MaxProduct', '$MaxProductImage','$MaxEmail', '$MaxSms','".$sort_order."')";
			$this->query($sql,0);
			return true;
		}
		
		function updateMembership($ArryRequest)
		{
			extract($ArryRequest);
			$sql="update membership set Name='".addslashes($Name)."', Description='".addslashes($Description)."', Validity='".$Validity."', Price='".$Price."',  ReferralAmount='".$ReferralAmount."',Status='".$Status."', MaxProduct='".$MaxProduct."', MaxProductImage='".$MaxProductImage."', MaxEmail='".$MaxEmail."', MaxSms='".$MaxSms."'  where MembershipID=".$MembershipID; 
			$this->query($sql,0);
			return true;
		}
		
		function getAllMembership()
		{
			$sql="select * from membership order by Price";
			return $this->query($sql);
		}
		
		function getMembership($MembershipID,$Status)
		{
			$sql  = " where deleted=0 "; 
			$sql .= (!empty($MembershipID))?(" and MembershipID=".$MembershipID):("");
			$sql .= (!empty($Status))?(" and Status=".$Status):("");

			$sql="select * from membership ".$sql." order by Price";
			return $this->query($sql);
		}

		function getPaidMembership($MembershipID,$Status)
		{
			$sql  = " where deleted=0 and Price>0 "; 
			$sql .= (!empty($MembershipID))?(" and MembershipID=".$MembershipID):("");
			$sql .= (!empty($Status))?(" and Status=".$Status):("");

			$sql="select * from membership ".$sql." order by sort_order";
			return $this->query($sql);
		}

		function getMembershipHistory($id,$MemberID,$MembershipID)
		{
			$sql  = " where 1 "; 
			$sql .= (!empty($MembershipID))?(" and MembershipID=".$MembershipID):("");
			$sql .= (!empty($MemberID))?(" and MemberID=".$MemberID):("");

			$sql="select * from membership_history ".$sql." order by id desc";
			return $this->query($sql);
		}

		function changeMembershipStatus($MembershipID)
		{
			$sql="select * from membership where MembershipID=".$MembershipID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update membership set Status='$Status' where MembershipID=".$MembershipID;
				$this->query($sql,0);
				return true;
			}			
		}
		
		function deleteMembership($MembershipID)
		{
			
			$sql = "select sort_order from membership where MembershipID = ".$MembershipID;
			$arryRow = $this->query($sql, 1);

			$sql="update membership set sort_order=sort_order-1 where sort_order>".$arryRow[0]['sort_order']." and deleted=0 ";
			$this->query($sql,0);
			
			
			$sql="update membership set deleted=1,Status=0 where MembershipID=".$MembershipID;
			$this->query($sql,0);
			return true;
		}


		function isMembershipExists($Name,$MembershipID)
		{
			$sql ="select * from membership where deleted=0 and LCASE(Name) = '".strtolower(trim($Name))."'";
			$sql .= (!empty($MembershipID))?(" and MembershipID != ".$MembershipID):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['MembershipID'])) {
				return true;
			} else {
				return false;
			}
		}




	
		
		/************* Get Number of Uploads ***********************/

		function GetPostingApproval($MemberID)
		{
			$sql = "select PostingApproval,VatNumber,VatPercentage,TaxType from members where MemberID = '".$MemberID."'";
			return $this->query($sql);

		}
		
		function GetNumProducts($PostedByID)
		{
			$sql = "select sum(1) as NumProducts from products where PostedByID = '".$PostedByID."'";
			return $this->query($sql);

		}	

		function GetNumPartners($MemberID)
		{
			$sql = "select sum(1) as NumPartners from partner where MemberID = '".$MemberID."'";
			return $this->query($sql);

		}

		/************* Rating System ***********************/
		function  ListReview($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and r.RankingID=".$id):("");


			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (r.Message like '%".$SearchKey."%' or r.Points like '".$SearchKey."' or m1.CompanyName like '%".$SearchKey."%' or m2.UserName like '%".$SearchKey."%' or r.Date like '%".$SearchKey."%')"):("");
			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by r.RankingID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

			$strSQLQuery = "select r.*,m1.CompanyName,m1.UserName,m2.UserName as RatedBy from ranking r left outer join members m1 on r.MemberID=m1.MemberID left outer join members m2 on r.RaterID =m2.MemberID".$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}

		function changeRankStatus($RankingID)
		{
			$sql="select * from ranking where RankingID=".$RankingID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update ranking set Status='$Status' where RankingID=".$RankingID;
				$this->query($sql,0);
				return true;
			}			
		}

		function AssignRank($ArryRequest)
		{
			extract($ArryRequest);

			$sql="insert into ranking (MemberID,RaterID,Points,Message,Date) values('".$RecieverID."', '".$RaterID."','$Points','".addslashes($Message)."','".date('d-m-Y')."')";
			$this->query($sql,0);

			$sql="update members set Ranking=Ranking+".$Points." where MemberID = ".$RecieverID;
			$this->query($sql,0);

			return true;
		}
		
		function UpdateRanking($ArryRequest)
		{
			extract($ArryRequest);

			$sql ="select * from ranking where RankingID=".$RankingID;

			$arryRow = $this->query($sql, 1);

			if (!empty($arryRow[0]['RankingID'])) {
				
				$sql="update ranking set Points='".$Points."',Message='".addslashes($Message)."' where RankingID = ".$RankingID;
				$this->query($sql,0);


				$sql ="select Ranking from members where MemberID=".$arryRow[0]['MemberID'];
				$arryMember = $this->query($sql, 1);
			
				if($arryRow[0]['Points']!=$Points){
					if ($arryMember[0]['Ranking']>0 && $arryMember[0]['Ranking']>=$arryRow[0]['Points']) {
						$sql="update members set Ranking=Ranking-".$arryRow[0]['Points']." where MemberID = ".$arryRow[0]['MemberID'];
						$this->query($sql,0);
					}

					$sql="update members set Ranking=Ranking+".$Points." where MemberID = ".$RecieverID;
					$this->query($sql,0);
				}



			} 

			return true;

		}

		function DeleteRank($RankingID)
		{

			$sql ="select * from ranking where RankingID=".$RankingID;

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['RankingID'])) {
				
				$strSQLQuery = "delete from ranking where RankingID=".$RankingID ; 
				$this->query($strSQLQuery, 0);



				$sql ="select Ranking from members where MemberID=".$arryRow[0]['MemberID'];
				$arryMember = $this->query($sql, 1);

				if ($arryMember[0]['Ranking']>0 && $arryMember[0]['Ranking']>=$arryRow[0]['Points']) {
					$sql="update members set Ranking=Ranking-".$arryRow[0]['Points']." where MemberID = ".$arryRow[0]['MemberID'];
					$this->query($sql,0);
				}

			} 

			return true;

		}



	


		function isRatedAlready($RaterID,$RecieverID)
		{

			$sql ="select * from ranking where MemberID=".$RecieverID." and RaterID=".$RaterID;

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['RankingID'])) {
				return true;
			} else {
				return false;
			}

		}	


		function GetRankingDetails($MemberID)
		{

			$sql = "select r.*,m.UserName,m.FirstName,m.LastName from ranking r inner join members m on r.RaterID =m.MemberID where r.Status=1 and r.MemberID=".$MemberID." order by r.RankingID desc"; 

			return $this->query($sql, 1);

		}

		function GetMyRankingDetails($RankingID,$RaterID)
		{
			
			$sql = "select r.*,m.UserName,m.CompanyName from ranking r inner join members m on r.MemberID =m.MemberID where 1 ";

			$sql .= (!empty($RankingID))?(" and r.RankingID = ".$RankingID):("");
			$sql .= (!empty($RaterID))?(" and r.RaterID = ".$RaterID):("");

			$sql .= " order by r.RankingID desc"; 

			return $this->query($sql, 1);

		}

		function GetMemberRanking($MemberID,$Type)
		{
			$sql ="select sum(Ranking) as TotalRanks from members where Status=1 and WebsiteStoreOption in('s','ws')";
			$sql .= (!empty($MemberID))?(" and MemberID = ".$MemberID):("");
			$sql .= (!empty($Type))?(" and Type='".$Type."'"):("");

			return $this->query($sql);

		}


		function SendFraudEmail($ArryRequest)
		{
			extract($ArryRequest);

			$arryReciever = $this->GetMemberDetail($RecieverID);
			$arryRater = $this->GetMemberDetail($RaterID);

			if(sizeof($arryReciever)>0 && sizeof($arryRater)>0)
			{

				$contents = file_get_contents("html/fraud.htm");
				global $Config;
				$FullName = $arryRow[0]['Name'];
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FROM_COMPANY]",$arryRater[0]['CompanyName'],$contents);
				$contents = str_replace("[FROM_ID]",$arryRater[0]['MemberID'],$contents);	
				$contents = str_replace("[COMPANY_NAME]",$arryReciever[0]['CompanyName'],$contents);
				$contents = str_replace("[NAME]",$arryReciever[0]['FirstName'].' '.$arryReciever[0]['LastName'],$contents);
				$contents = str_replace("[EMAIL]",$arryReciever[0]['Email'],$contents);
				$contents = str_replace("[PHONE]",$arryReciever[0]['Phone'],$contents);
				$contents = str_replace("[FRAUD_ID]",$arryReciever[0]['MemberID'],$contents);	
				$contents = str_replace("[MAIL_CONTENT]",addslashes($Message),$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
						
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryRater[0]['CompanyName'], $arryRater[0]['Email']);   
				$mail->Subject = $Config['SiteName']." - Fraud reported ";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRater[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
				return 1;
			}
		}


		/************* Bidding System ***********************/

		function InsertBid($ArryRequest)
		{
			extract($ArryRequest);

			$sql="insert into bid (ProductID,MemberID,SellerID,Amount,Message,Date,currency_id) values('".$ProductID."', '".$MemberID."', '".$SellerID."','".$Amount."', '".addslashes($Message)."','".date('d-m-Y')."','".$currency_id."')";
			$this->query($sql,0);

			return true;
		}
		
		function AssignBid($BidID)
		{
			
			$sql = "select * from bid where BidID=".$BidID;
			$arryRow = $this->query($sql, 1);

			global $Config;
			if (!empty($arryRow[0]['BidID'])) {

					$arryBuyer = $this->GetMemberDetail($arryRow[0]['MemberID']);
					$arrySeller = $this->GetMemberDetail($arryRow[0]['SellerID']);



					$objProduct=new product();
					$arryProduct = $objProduct->GetProducts($arryRow[0]['ProductID'],0,0,0);

					if(sizeof($arryBuyer)>0 && sizeof($arrySeller)>0 && sizeof($arryProduct)>0)
					{

						$sql="update bid set Status='Assigned' where BidID=".$BidID;
						$this->query($sql,0);
						$sql="update products set BidStatus='Assigned' where ProductID=".$arryRow[0]['ProductID'];
						$this->query($sql,0);

						$contents = file_get_contents("html/bidAssign.htm");
						
					
						$contents = str_replace("[URL]",$Config['Url'],$contents);
						$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
						$contents = str_replace("[BUYER_NAME]",$arryBuyer[0]['UserName'],$contents);
						$contents = str_replace("[FROM_COMPANY]",stripslashes($arrySeller[0]['CompanyName']),$contents);
						$contents = str_replace("[SELLER_ID]",$arrySeller[0]['MemberID'],$contents);	

						$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
						$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
						$contents = str_replace("[PRICE]",$arryRow[0]['Amount'],$contents);
						$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	

						if($arryProduct[0]['Image'] != ""){
							$ImageDestination = $Config['Url']."upload/products/".$arryProduct[0]['Image'];
						}else{
							$ImageDestination = $Config['Url']."images/no-image.jpg";
						}

						$contents = str_replace("[IMAGE]",$ImageDestination,$contents);

						$FullStoreUrl = $Config['Url'].$Config['StorePrefix'].$arrySeller[0]['UserName'];

						$contents= str_replace("[BUY_URL]",$FullStoreUrl.'/buyProduct.php?BidID='.$BidID.'&id='.$arryProduct[0]['ProductID'].'&StoreID='.$arryProduct[0]['PostedByID'], $contents);

						$contents= str_replace("[DECLINE_URL]",$FullStoreUrl.'/buyProduct.php?declineID='.$BidID.'&id='.$arryProduct[0]['ProductID'].'&StoreID='.$arryProduct[0]['PostedByID'], $contents);

						
						
						$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
								
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($arryBuyer[0]['Email']);
						$mail->sender(stripslashes($arrySeller[0]['CompanyName']), $arrySeller[0]['Email']);   
						$mail->Subject = $Config['SiteName']." - You have won an auction ";
						$mail->IsHTML(true);
						$mail->Body = $contents;  
						//echo $arryBuyer[0]['Email'].$arrySeller[0]['Email'].$contents; exit;
						if($Config['DbUser'] != 'root'){
							$mail->Send();	
						}
						return 1;
					}			
			
			}

			return true;


		}	
		


		function BidPurchased($BidID)
		{
			
			$sql = "select * from bid where BidID=".$BidID;
			$arryRow = $this->query($sql, 1);

			if (!empty($arryRow[0]['BidID'])) {

					$arrySeller = $this->GetMemberDetail($arryRow[0]['SellerID']);

					$objProduct=new product();
					$arryProduct = $objProduct->GetProducts($arryRow[0]['ProductID'],0,0,0);

					if(sizeof($arrySeller)>0 && sizeof($arryProduct)>0)
					{

						$sql="update bid set Status='Purchased' where BidID=".$BidID;
						$this->query($sql,0);

						$sql="delete from bid where BidID!=".$BidID." and ProductID=".$arryRow[0]['ProductID'];
						$this->query($sql,0);

						$sql="update products set BidStatus='' where ProductID=".$arryRow[0]['ProductID'];
						$this->query($sql,0);

						$contents = file_get_contents("html/bidPurchased.htm");
						global $Config;
					
						$contents = str_replace("[URL]",$Config['Url'],$contents);
						$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
						$contents = str_replace("[SELLER_NAME]",$arrySeller[0]['UserName'],$contents);
						$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
						$contents = str_replace("[FROM_COMPANY]",stripslashes($arrySeller[0]['CompanyName']),$contents);
						$contents = str_replace("[SELLER_ID]",$arrySeller[0]['MemberID'],$contents);	

						$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
						$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
						$contents = str_replace("[PRICE]",$arryRow[0]['Amount'],$contents);

						if($arryProduct[0]['Image'] != ""){
							$ImageDestination = $Config['Url']."upload/products/".$arryProduct[0]['Image'];
						}else{
							$ImageDestination = $Config['Url']."images/no-image.jpg";
						}

						$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
						$contents= str_replace("[BID_URL]",$Config['Url'].'editProduct.php?edit='.$arryProduct[0]['ProductID'], $contents);


						
						
						$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
								
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($arrySeller[0]['Email']);
						$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
						$mail->Subject = $Config['SiteName']." - An assigned auction has been purchased.";
						$mail->IsHTML(true);
						$mail->Body = $contents;  
						//echo $arrySeller[0]['Email'].$Config['AdminEmail'].$contents; exit;
						if($Config['DbUser'] != 'root'){
							$mail->Send();	
						}
						return 1;
					}			
			
			}

			return true;


		}	



		function BidDeclined($BidID)
		{
			
			$sql = "select * from bid where BidID=".$BidID;
			$arryRow = $this->query($sql, 1);

			if (!empty($arryRow[0]['BidID'])) {

					$arrySeller = $this->GetMemberDetail($arryRow[0]['SellerID']);

					$objProduct=new product();
					$arryProduct = $objProduct->GetProducts($arryRow[0]['ProductID'],0,0,0);

					if(sizeof($arrySeller)>0 && sizeof($arryProduct)>0)
					{

						$sql="update bid set Status='' where BidID=".$BidID;
						$this->query($sql,0);
						$sql="update products set BidStatus='' where ProductID=".$arryRow[0]['ProductID'];
						$this->query($sql,0);

						$contents = file_get_contents("html/bidDecline.htm");
						global $Config;
					
						$contents = str_replace("[URL]",$Config['Url'],$contents);
						$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
						$contents = str_replace("[SELLER_NAME]",$arrySeller[0]['UserName'],$contents);
						$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
						$contents = str_replace("[FROM_COMPANY]",stripslashes($arrySeller[0]['CompanyName']),$contents);
						$contents = str_replace("[SELLER_ID]",$arrySeller[0]['MemberID'],$contents);	

						$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
						$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
						$contents = str_replace("[PRICE]",$arryRow[0]['Amount'],$contents);

						if($arryProduct[0]['Image'] != ""){
							$ImageDestination = $Config['Url']."upload/products/".$arryProduct[0]['Image'];
						}else{
							$ImageDestination = $Config['Url']."images/no-image.jpg";
						}

						$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
						$contents= str_replace("[BID_URL]",$Config['Url'].'editProduct.php?edit='.$arryProduct[0]['ProductID'], $contents);


						
						
						$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
								
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($arrySeller[0]['Email']);
						$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
						$mail->Subject = $Config['SiteName']." - bid won product has been declined for purchase  ";
						$mail->IsHTML(true);
						$mail->Body = $contents;  
						//echo $arrySeller[0]['Email'].$Config['AdminEmail'].$contents; exit;
						if($Config['DbUser'] != 'root'){
							$mail->Send();	
						}
						return 1;
					}			
			
			}

			return true;


		}	



		function GetBidByID($BidID)
		{
			$sql .= (!empty($BidID))?(" and b.BidID = ".$BidID):("");

			$sql = "select b.*,p.Name,p.endDate,p.BidStatus,m.UserName from bid b inner join products p on b.ProductID =p.ProductID inner join members m on b.MemberID =m.MemberID where m.Status=1 and  p.Bidding='Auction' and b.Status='Assigned' ".$sql." order by Amount desc"; 

			return $this->query($sql, 1);

		}

		
		function GetBidDetails($ProductID,$SellerID)
		{
			$sql .= (!empty($ProductID))?(" and b.ProductID = ".$ProductID):("");
			$sql .= (!empty($SellerID))?(" and b.SellerID = ".$SellerID):("");

			$sql = "select b.*,cs.*,p.Name,p.endDate,p.BidStatus,m.UserName from bid b inner join products p on b.ProductID =p.ProductID inner join members m on b.MemberID =m.MemberID left outer join currencies cs on b.currency_id=cs.currency_id where p.Bidding='Auction' ".$sql." order by Amount desc"; 

			return $this->query($sql, 1);

		}




		function isBidAlready($MemberID,$ProductID)
		{

			$sql ="select * from bid where MemberID=".$MemberID." and ProductID=".$ProductID;

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['BidID'])) {
				return true;
			} else {
				return false;
			}

		}	

		function isValidBid($BidID)
		{

			$sql ="select * from bid where BidID=".$BidID;

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['BidID'])) {
				return true;
			} else {
				return false;
			}

		}

		function isBidAssgnedAlready($BidID)
		{

			$sql ="select * from bid where BidID=".$BidID." and Status in ('Assigned','Purchased')";

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['BidID'])) {
				return true;
			} else {
				return false;
			}

		}	




		function GetMaxAmount($ProductID)
		{
			$sql = "select Max(b.Amount) as MaxAmount from bid b inner join products p on b.ProductID=p.ProductID inner join members m on b.MemberID =m.MemberID where b.ProductID = ".$ProductID;

			return $this->query($sql, 1);

		}


		function RemoveBid($BidID )
		{
			
			$sql ="select * from bid where BidID=".$BidID;

			$arryRow = $this->query($sql, 1);

			if (!empty($arryRow[0]['BidID'])) {
				$strSQLQuery = "delete from bid  where BidID=".$BidID ; 
				$this->query($strSQLQuery, 0);

				$sql="update products set BidStatus='' where ProductID=".$arryRow[0]['ProductID'];
				$this->query($sql,0);

			} 
			

			return 1;

		}



		/********************************************************/

		function GetNumLimitations($MemberID)
		{
			$sql = "select m2.* from membership m2 inner join members m1 on m2.MembershipID=m1.MembershipID where m1.MemberID = '".$MemberID."'";
			return $this->query($sql);

		}	




		function SendBulkSMS($ids,$arryDetails)
		{
				@extract($arryDetails);

				global $Config;
	
				$idArray = explode(',' ,rtrim($ids,","));
				
				if($ccTo != ''){
					$ccToArray = explode(',' , $ccTo);
				}
				
				$Message = $SellerMessage.$Message;

				$Message .= ' | Oriental Merchant';

				
				$_SESSION['Numbers'] = "";

				if(!empty($StoreID)) {
					$TotalToSend = sizeof($idArray)+sizeof($ccToArray);
					if($TotalToSend>$MaxSms){
						$_SESSION['Numbers'] = '<b>SMS sending failed. You have exceeded your sms credit limit which is: '.$MaxSms.'</b>';
						return false;
					}
				}

				//echo $Message; exit;

				if($ids != ''){
					foreach($idArray as $MemberID){
						
						$sql = "Select FirstName,Email,isd_code,Phone,UserName from members where MemberID = '".$MemberID."'"; 

						$arryRow = $this->query($sql, 1);
						
						$contents = str_replace("[FULLNAME]",$arryRow[0]['FirstName'],$contents);

						$_SESSION['Numbers'] .= '<img src="arrows.gif">&nbsp;' .$arryRow[0]['UserName'] . "<br><br>";
						
						
						$mysms = new sms();
						$mysms->session;
						$mysms->getbalance();
						$mysms->send ($arryRow[0]['isd_code'].$arryRow[0]['Phone'],$Config['SMS_SenderID'], $Message);
						//echo $arryRow[0]['isd_code'].$arryRow[0]['Phone']; exit;
						
						if($MaxSms>0)$MaxSms--;

						

					}
				}

				

				if($ccTo != ''){
					foreach($ccToArray as $ccEmail){

					//echo $ccEmail.',';

					$contents = str_replace("[FULLNAME]",'Member',$contents);

					$_SESSION['Numbers'] .= '<img src="arrows.gif">&nbsp;' . $ccEmail . "<br><br>";
						
						$mysms = new sms();
						$mysms->session;
						$mysms->getbalance();
						
						$mysms->send ($ccEmail, $Config['SiteName'], $Message);

						if($MaxSms>0)$MaxSms--;


					}
				}
				
				

				if(!empty($StoreID)){
					$strSQLQuery = "update members set MaxSms='".$MaxSms."' where MaxSms>0 and MemberID=".$StoreID; 
					//$this->query($strSQLQuery, 0);

				}


				return true;
		}









		function SendBulkEmail($ids,$arryDetails)
		{
				@extract($arryDetails);
				
				$mail_content = stripslashes($content);

				$idArray = explode(',' ,rtrim($ids,","));
				
				if($ccTo != ''){
					$ccTo = rtrim($ccTo,",");
					$ccTo = rtrim($ccTo,", ");
					$ccToArray = explode(',' , $ccTo);
				}
				
				

				global $Config;

				$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../html/"):("html/");

				

				$contents = file_get_contents($htmlPrefix."sendEmail.htm");
				$UnsLink = $Config['Url'].'unsubscribe.php?unsbcrbId=[MEMBER_ID]';
				
				$AbuseLink = $Config['Url'].'abuse_email.php?memberId=[MEMBER_EMAIL]';
				
				if(!empty($StoreID)){
					$UnsLink .= '&StoreID='.$StoreID;
					$AbuseLink .= '&StoreID='.$StoreID;

					$Subject = $CompanyName.' | '.$Subject;

					$DirectUnsLink = $Config['Url'].'unsubscribe_mail.php?unsbcrbId=[MEMBER_ID]'.'&StoreID='.$StoreID;

					$DirectUnsubcibeLink = '<br><br><a href="'.$DirectUnsLink.'" target="_blank">Please send this Seller a direct eMail to remove me from their mailing lists.</a>';
				}


				$UnsubcibeLink = '<a href="'.$UnsLink.'" target="_blank">Please unsubscribe my registration for e-mail.</a>'.$DirectUnsubcibeLink;

				//$ComplainLink = '<br><a href="'.$AbuseLink.'" target="_blank">Complain</a>';

				
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[SELLER_CONTENT]",$SellerMessage,$contents);	
				$contents = str_replace("[MAIL_CONTENT]",$Message,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[UNSUBSCRIBE_LINK]",$UnsubcibeLink,$contents);
				$contents = str_replace("[COMPLAIN_LINK]",$ComplainLink,$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	


				$_SESSION['Emails'] = "";

				if(!empty($StoreID)) {
					$TotalEmailToSend = sizeof($idArray)+sizeof($ccToArray);
					if($TotalEmailToSend>$MaxEmail){
						$_SESSION['Emails'] = '<b>Mail sending failed. You have exceeded your email credit limit which is: '.$MaxEmail.'</b>';
						return false;
					}
				}




				if($ids != ''){
					foreach($idArray as $MemberID){

						
						$sql = "Select FirstName,LastName,Email,UserName from members where MemberID = '".$MemberID."'"; 

						$arryRow = $this->query($sql, 1);
			
/**************/
$MailTitle = 'Dear '.$arryRow[0]['FirstName'].' '.$arryRow[0]['LastName'].',<br><br>';

/**************/

						$contents = $MailTitle.$contents; 
						$contents = str_replace("[FULLNAME]",$arryRow[0]['FirstName'],$contents);
						$contents = str_replace("[MEMBER_ID]",$MemberID,$contents);
						$contents = str_replace("[MEMBER_EMAIL]",base64_encode($arryRow[0]['Email']),$contents);

						$_SESSION['Emails'] .= '<img src="arrows.gif">&nbsp;' . $arryRow[0]['UserName'] . "<br><br>";


						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->sender($Config['SiteName'], $AdminEmail);   
						$mail->Subject = $Config['SiteName']." | ".$Subject;
						$mail->IsHTML(true);

						$mail->Body = $contents;    
						$mail->AddAddress($arryRow[0]['Email']);

						if($Config['DbUser'] != 'root'){
							$mail->Send();	
						}

						//echo  $arryRow[0]['Email'].$AdminEmail.$contents; exit;


						if($MaxEmail>0)$MaxEmail--;

						
						$contents = str_replace($arryRow[0]['FirstName'], "[FULLNAME]",$contents);
						$contents = str_replace($MemberID, "[MEMBER_ID]",$contents);
						$contents = str_replace(base64_encode($arryRow[0]['Email']),"[MEMBER_EMAIL]",$contents);

					}

					
				}

				
				if($ccTo != ''){

					
						$DirectUnsubcibeLink ='';
						if(!empty($StoreID)) {
							$DirectUnsLink = $Config['Url'].'unsubscribe_me_mail.php?unsbcrbId=[MEMBER_ID]&StoreID='.$StoreID;

							$DirectUnsubcibeLink = '<br><a href="'.$DirectUnsLink.'" target="_blank">Please send this Seller a direct eMail to remove me from their mailing lists.</a>';
						}



					$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../html/"):("html/");
					$contents = file_get_contents($htmlPrefix."sendEmail.htm");


					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[SELLER_CONTENT]",$SellerMessage,$contents);	
					$contents = str_replace("[MAIL_CONTENT]",$Message,$contents);	
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[UNSUBSCRIBE_LINK]",$DirectUnsubcibeLink,$contents);
					$contents = str_replace("[COMPLAIN_LINK]",$ComplainLink,$contents);
					$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	


					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= "From: ".$AdminEmail. "\r\n" .
					   "Reply-To: ".$AdminEmail. "\r\n" .
					   "X-Mailer: PHP/" . phpversion();


					foreach($ccToArray as $ccEmail){

						$contents = str_replace("[FULLNAME]",'Member',$contents);

						$_SESSION['Emails'] .= '<img src="arrows.gif">&nbsp;' . trim($ccEmail) . "<br><br>";

						if($MaxEmail>0)$MaxEmail--;

						$contents = str_replace('Member', "[FULLNAME]",$contents);
						$contents = str_replace("[MEMBER_ID]",$ccEmail,$contents);
						$contents = str_replace("[MEMBER_EMAIL]",base64_encode($ccEmail),$contents);



						/*
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->sender($Config['SiteName'], $AdminEmail);   
						$mail->Subject = $Config['SiteName']." - ".$Subject;
						$mail->IsHTML(true);

						$mail->Body = $contents;    
						$mail->AddAddress(trim($ccEmail));
						
						if($Config['DbUser'] != 'root'){
							$mail->Send();	
						}

						*/

						//echo  $ccEmail.$AdminEmail.$contents;



						if($Config['DbUser'] != 'root'){
							mail(trim($ccEmail), $Config['SiteName']." - ".$Subject, $contents, $headers);
						}

					

						$contents = str_replace($ccEmail, "[MEMBER_ID]",$contents);
						$contents = str_replace(base64_encode($ccEmail), "[MEMBER_EMAIL]",$contents);


					}

					
					//exit;


				}
				
				
				if(!empty($StoreID)){
					$strSQLQuery = "update members set MaxEmail='".$MaxEmail."' where MaxEmail>0 and MemberID=".$StoreID; 
					$this->query($strSQLQuery, 0);

				}


				return true;
		}







}










?>
