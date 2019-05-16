<?
class cmp extends dbClass
{
	

	//constructor
	function cmp()
	{
		$this->dbClass();
	}



	function SendActivationMail($CmpID)
	{
			
		global $Config;
		if(!empty($CmpID)){
			$strSQLQuery = "select * from company where CmpID='".mysql_real_escape_string($CmpID)."'";
			$arryRow = $this->query($strSQLQuery, 1);
			$htmlPrefix = $Config['EmailTemplateFolder'];

			//$contents = file_get_contents($htmlPrefix."verify.htm");

			$contentActive=$this->getEmailTemplate('7');
			$contents=stripslashes($contentActive[0]['Content']);
			$subject=stripslashes($contentActive[0]['subject']);
			if(!empty($contentActive[0]['FromEmail'])){
				$Config['AdminEmail'] = stripslashes($contentActive[0]['FromEmail']);
			}
			//$subject  = "Verify Account";
			$VerifyUrl = $Config['WebUrl']."index.php?slug=activate&cmp=".base64_encode($arryRow[0]["Email"]);
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[VERIFY_URL]",$VerifyUrl,$contents);

			$contents = str_replace("[USERNAME]",$arryRow[0]["DisplayName"], $contents);


			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($arryRow[0]["Email"]);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);
			$mail->Subject = $Config['SiteName']." - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;
			//echo $subject.$arryRow[0]["Email"].$Config['AdminEmail'].$contents; exit;
			if($Config['Online'] == '1'){
				$mail->Send();
			}


			return true;
		}

	}


	function ActiveCompany($arryDet)
	{
		global $Config;
		extract($arryDet);

		if(!empty($Email)){
			$sql="select * from company where Email='".$Email."'";
			$arryCmp = $this->query($sql);
			if(sizeof($arryCmp))
			{
				$Status=0;
				$sql2="update company set Status='".$Status."',Password='".md5($Password)."' where CmpID='".$arryCmp[0]['CmpID']."'";
				$this->query($sql2,0);

				$this->addFreeOrder($Email);
	
				/************************/
				
				//mail to user
				$htmlPrefix = $Config['EmailTemplateFolder'];

				//$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$CompanyUrl = $Config['Url'].'crm/';

				/*if(!empty($BuyNow)) $emailtemplate = 'logindetails_buy.htm'; 
				else $emailtemplate = 'logindetails.htm';
				$contents = file_get_contents($htmlPrefix.$emailtemplate);*/

				if(!empty($BuyNow)){
					$contentBuy=$this->getEmailTemplate('9');
					$contents=stripslashes($contentBuy[0]['Content']);
					$subject=stripslashes($contentBuy[0]['subject']);
					if(!empty($contentBuy[0]['FromEmail'])){
						$Config['AdminEmail'] = stripslashes($contentBuy[0]['FromEmail']);
					}
				}else{
					$contentLogDetail=$this->getEmailTemplate('10');
					$contents=stripslashes($contentLogDetail[0]['Content']);
					$subject=stripslashes($contentLogDetail[0]['subject']);		
					if(!empty($contentLogDetail[0]['FromEmail'])){
						$Config['AdminEmail'] = stripslashes($contentLogDetail[0]['FromEmail']);
					}			
				}


				$contents = str_replace("[URL]",$CompanyUrl,$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$contents = str_replace("[DisplayName]",$arryCmp[0]['DisplayName'], $contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);
				$contents = str_replace("[FULLNAME]",$arryCmp[0]['DisplayName'], $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($Email);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;
				if($Config['Online'] == '1'){
					$mail->Send();
				}

				//echo $subject.$Email.$Config['AdminEmail'].$contents; exit;


				/************************/

			/********AMDIN EMAIL *******/
				
				if(!empty($BuyNow)){
					$contentBuyAdmin=$this->getEmailTemplate('16');
					$contentAdmin=stripslashes($contentBuyAdmin[0]['Content']);
					$subjectAdmin=stripslashes($contentBuyAdmin[0]['subject']);	
					if(!empty($contentBuyAdmin[0]['ToEmail'])){
						$Config['AdminEmail'] = stripslashes($contentBuyAdmin[0]['ToEmail']);
					}
				}else{
					$contentLogDetailAdmin=$this->getEmailTemplate('15');
					$contentAdmin=stripslashes($contentLogDetailAdmin[0]['Content']);
					$subjectAdmin=stripslashes($contentLogDetailAdmin[0]['subject']);
					if(!empty($contentLogDetailAdmin[0]['ToEmail'])){
						$Config['AdminEmail'] = stripslashes($contentLogDetailAdmin[0]['ToEmail']);
					}
				}

				$contentAdmin = str_replace("[URL]",$CompanyUrl,$contentAdmin);
				$contentAdmin = str_replace("[SITENAME]",$Config['SiteName'],$contentAdmin);
				$contentAdmin = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contentAdmin);

				$contentAdmin = str_replace("[USERNAME]",$arryCmp[0]['DisplayName'], $contentAdmin);
				$contentAdmin = str_replace("[EMAIL]",$Email,$contentAdmin);
				$contentAdmin = str_replace("[PASSWORD]",$Password,$contentAdmin);
				$contentAdmin = str_replace("[COMPANYNAME]",$arryCmp[0]['CompanyName'], $contentAdmin);
				$contentAdmin = str_replace("[COMPANYID]",$arryCmp[0]['CmpID'], $contentAdmin);
					
				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($Config['AdminEmail']);
				$mail->AddBCC('parwez005@gmail.com');
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subjectAdmin;
				$mail->IsHTML(true);
				$mail->Body = $contentAdmin;
				//echo $subjectAdmin.$arryCmp[0]["Email"].$Config['AdminEmail'].$contentAdmin; exit;
					
				if($Config['Online'] == '1'){
					$mail->Send();
				}
				
			   /********AMDIN EMAIL END HERES *******/



			  





			}
		}

		return true;

	}



function addFreeOrder($Email){
	    global $Config;

		$sql="select * from company where Email='".$Email."'";
		$arryCmp = $this->query($sql);


		$ipaddress = GetIPAddress();
		if(empty($CrmAdminID)){
			$CmpID = $_SESSION['CrmAdminID'];
		}
        $strSQLQuery = "INSERT INTO orders (
		CmpID,
		StartDate,
		EndDate,
		UpdatedDate,
		ipaddress,
		CompanyName,
		customer_email_id,
		customer_first_name,
		OrderType
		) values(
		'".$arryCmp[0]['CmpID']."',
		'".date('Y-m-d')."',
		'".$arryCmp[0]['ExpiryDate']."',
		'".date('Y-m-d')."',
		'".$ipaddress."',
		'".$arryCmp[0]['CompanyName']."',
		'".$Email."',
		'".$arryCmp[0]['DisplayName']."',
		'Free'
		)";
	   $this->query($strSQLQuery, 0);

	}


	
	function getPackagesById($packid){
		$sql="SELECT * FROM packages WHERE id= '".$packid."'";
		return $this->query($sql, 1);
	}

	function getPackagesByName($name){
		$sql="SELECT * FROM packages WHERE name= '".$name."' AND package_type='4'";
		return $this->query($sql, 1);
	}
	
	function showOderInformation(){
		if(isset($_SESSION['CrmAdminID'])){
			$sql="SELECT * FROM orders WHERE CmpID= '".$_SESSION['CrmAdminID']."' ORDER BY OrderID DESC LIMIT 0,1";
			return $this->query($sql, 1);
		}
	}
	
	
	function showOderInformationSA($id){
		$sql="SELECT * FROM orders WHERE CmpID= '".$id."' ORDER BY OrderID DESC LIMIT 0,1";
		return $this->query($sql, 1);
	}
	
	

	function AddOrder($arryDetails)
	{

		global $Config;
		extract($arryDetails);
		$ipaddress = GetIPAddress();
		$StartDate = date('Y-m-d');
		$arrDuration = explode("/",$PlanDuration);
	
		if($arrDuration[1]=='year'){
			$NumMonth = 12;
		}else if($arrDuration[1]=='quarter'){
			$NumMonth=3;
			
		}else if($arrDuration[1]=='halfyear'){
			$NumMonth=6;
		}	
		else{
			$NumMonth = 1;
		}

		$arryDate = explode("-",date('Y-m-d'));
		list($year, $month, $day) = $arryDate;
		$TempDate  = mktime(0, 0, 0, $month+$NumMonth , $day, $year);
		$EndDate = date("Y-m-d",$TempDate);

		$Status = '0';

		if(empty($CrmAdminID)){
			$CrmAdminID = $_SESSION['CrmAdminID'];
		}

	     $strSQLQuery = "INSERT INTO orders (
		CmpID,
		PaymentPlan,
		StartDate,
		EndDate,
		UpdatedDate,
		MaxUser ,
		PlanDuration,
		Price,
		TotalAmount,
		Status,
		FreeSpace,
		FreeSpaceUnit,
		AdditionalSpace,
		AdditionalSpaceUnit,
		ipaddress,
		CouponCode,
		CouponDiscount,
		CouponType,
		DiscountType,
		NumUser,
		customer_first_name,
		customer_last_name,
		customer_credit_card_type,
		customer_credit_card_number,
		cc_expiration_month,
		cc_expiration_year,
		cc_cvv2_number,
		customer_address1,
		customer_address2,
		customer_city,
		customer_state,
		country_id,
		customer_zip,
		customer_email_id,
		RsID,
		PaymentStatus
		) values(
		'".$CrmAdminID."',
		'".addslashes($PaymentPlan)."', 
		'".addslashes($StartDate)."', 
		'".addslashes($EndDate)."',
		'".date('Y-m-d')."', 
		'".addslashes($MaxUser)."', 
		'".addslashes($PlanDuration)."',
		'".addslashes($Price)."', 
		'".addslashes($TotalAmount)."',
		'".$Status."', 
		'".addslashes($FreeSpace)."',
		'".addslashes($FreeSpaceUnit)."',
		'".addslashes($AdditionalSpace)."',
		'".addslashes($AdditionalSpaceUnit)."',
		'".addslashes($ipaddress)."',
		'".$CouponCode."',
		'".$CouponDiscount."',
		'".$CouponType."',
		'".$DiscountType."',
		'".$NumUser."',
		'".$customer_first_name."',
		'".$customer_last_name."',
		'".$customer_credit_card_type."',
		ENCODE('".$customer_credit_card_number."','".$Config['EncryptKey']."'),
		'".$cc_expiration_month."',
		'".$cc_expiration_year."',
		'".$cc_cvv2_number."',
		'".$customer_address1."',
		'".$customer_address2."',
		'".$customer_city."',
		'".$customer_state."',
		'".$country_id."',
		'".$customer_zip."',
		'".$customer_email_id."',
		'".$RsID."',
		'".$PaymentStatus."'
		)";
		   //echo $strSQLQuery;exit;
		   $this->query($strSQLQuery, 0);
		   $OrderID = $this->lastInsertId();



		 /***************************/				   
		   $sql1="SELECT * FROM orders WHERE OrderID = '".$OrderID."'";
		   $arryOrder=$this->query($sql1, 1);
		   
		   
		   $sqlcmp="SELECT CompanyName FROM company WHERE CmpID = '".$arryOrder[0]['CmpID']."'";
		   $arryCmp=$this->query($sqlcmp, 1);
		   
		   
		   $DisplayName =$arryOrder[0]['customer_first_name'];
		   $DisplayName .= '&nbsp;&nbsp;'.$arryOrder[0]['customer_last_name'];
		   $orderMsg = '<br><br>Customer Name: '.$DisplayName;
		   $orderMsg .= '<br><br>Company Name: '.$arryCmp[0]['CompanyName'];
		   
		  if(!empty($arryOrder[0]['TransactionID']))
		   $orderMsg .= '<br><br>Transaction Id: '.$arryOrder[0]['TransactionID'];
		   $orderMsg .= '<br><br>Total Amount: $'.$arryOrder[0]['TotalAmount'];
		   $orderMsg .= '<br><br>Payment Plan : '.$arryOrder[0]['PaymentPlan'];
		   $orderMsg .= '<br><br>Max User: '.$arryOrder[0]['MaxUser'];
		   $orderMsg .= '<br><br>Expiry date: '.date("j F, Y",strtotime($arryOrder[0]['EndDate']));
			   
		    $htmlPrefix = $Config['EmailTemplateFolder'];
		    
		/******ADMIN EMAIL********/
		//$contents = file_get_contents($htmlPrefix."orderAdmin.htm");

		$contentActive=$this->getEmailTemplate('11');
		$contents=stripslashes($contentActive[0]['Content']);
		$subject=stripslashes($contentActive[0]['subject']);
		if(!empty($contentActive[0]['FromEmail'])){
			$Config['AdminEmail'] = stripslashes($contentActive[0]['FromEmail']);
		}
		//$subject  = "Package Order Details";
		$contents = str_replace("[URL]",$Config['Url'],$contents);
		$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
		$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
		$contents = str_replace("[DisplayName]",$DisplayName, $contents);
		$contents = str_replace("[ORDER_MSG]",$orderMsg,$contents);
		$mail = new MyMailer();
		$mail->IsMail();
		$mail->AddAddress($Config['AdminEmail']);
		
		$mail->sender($Config['SiteName'], $Config['AdminEmail']);
		$mail->Subject = $Config['SiteName']." - ".$subject;
		$mail->IsHTML(true);
		$mail->Body = $contents;
		#echo $subject.$Config['AdminEmail'].$Config['SiteName'].$contents; exit;		
		if($Config['Online'] == 1){
			$mail->Send();
		}
		/***************************/




		   return $OrderID;

	}
	
	
	
		function AddOrderForPrivateCloud($arryDetails)
	{

		global $Config;
		extract($arryDetails);
		$ipaddress = GetIPAddress();
		$StartDate = date('Y-m-d');
		$arrDuration = explode("/",$PlanDuration);
		if($arrDuration[1]=='year'){
			$NumMonth = 12;
		}else{
			$NumMonth = 1;
		}

		$arryDate = explode("-",date('Y-m-d'));
		list($year, $month, $day) = $arryDate;
		$TempDate  = mktime(0, 0, 0, $month+$NumMonth , $day, $year);
		$EndDate = date("Y-m-d",$TempDate);

		$Status = '0';
	    $strSQLQuery = "INSERT INTO orders (
		CmpID,
		PaymentPlan,
		StartDate,
		EndDate,
		UpdatedDate,
		MaxUser ,
		PlanDuration,
		Price,
		TotalAmount,
		Status,
		FreeSpace,
		FreeSpaceUnit,
		AdditionalSpace,
		AdditionalSpaceUnit,
		ipaddress,
		TransactionID,
		CouponCode,
		CouponDiscount,
		CouponType,
		DiscountType,
		NumUser,
		customer_first_name,
		customer_last_name,
		customer_credit_card_type,
		customer_credit_card_number,
		cc_expiration_month,
		cc_expiration_year,
		cc_cvv2_number,
		customer_address1,
		customer_address2,
		customer_city,
		customer_state,
		country_id,
		customer_zip,
		customer_email_id,
		DomainName,
		CompanyName
		
		) values(
		'".$_SESSION['CrmAdminID']."',
		'".addslashes($PaymentPlan)."', 
		'".addslashes($StartDate)."', 
		'".addslashes($EndDate)."',
		'".date('Y-m-d')."', 
		'".addslashes($MaxUser)."', 
		'".addslashes($PlanDuration)."',
		'".addslashes($Price)."', 
		'".addslashes($TotalAmount)."',
		'".$Status."', 
		'".addslashes($FreeSpace)."',
		'".addslashes($FreeSpaceUnit)."',
		'".addslashes($AdditionalSpace)."',
		'".addslashes($AdditionalSpaceUnit)."',
		'".addslashes($ipaddress)."',
		'".addslashes($TransactionID)."',
		'".$CouponCode."',
		'".$CouponDiscount."',
		'".$CouponType."',
		'".$DiscountType."',
		'".$NumUser."',
		'".$customer_first_name."',
		'".$customer_last_name."',
		'".$customer_credit_card_type."',
		ENCODE('".$customer_credit_card_number."','".$Config['EncryptKey']."'),
		'".$cc_expiration_month."',
		'".$cc_expiration_year."',
		'".$cc_cvv2_number."',
		'".$customer_address1."',
		'".$customer_address2."',
		'".$customer_city."',
		'".$customer_state."',
		'".$country_id."',
		'".$customer_zip."',
		'".$customer_email_id."',
		'".$DomainName."',
		'".$CompanyName."'
		
		)";
		           //echo $strSQLQuery;exit;
		           $this->query($strSQLQuery, 0);
		           $OrderID = $this->lastInsertId();
		           /***************************/
		           
		           /***************************/
		           
		           $sql1="SELECT * FROM orders WHERE OrderID = '".$OrderID."'";
		           $privateCloudOrder=$this->query($sql1, 1);
		           
		           $DisplayName =$privateCloudOrder[0]['customer_first_name'];
		           $DisplayName .= '&nbsp;&nbsp;'.$privateCloudOrder[0]['customer_last_name'];
		           $orderMsg = '<br>Order Id: '.$privateCloudOrder[0]['OrderID'];
		           $orderMsg .= '<br>Transaction Id: '.$privateCloudOrder[0]['TransactionID'];
		           $orderMsg .= '<br>Total Amount: '.$privateCloudOrder[0]['TotalAmount'];
		           $orderMsg .= '<br>Payment Plan : '.$privateCloudOrder[0]['PaymentPlan'];
 				   $orderMsg .= '<br>Max User: '.$privateCloudOrder[0]['MaxUser'];
 				   $orderMsg .= '<br>Expiry date: '.date("j F, Y",strtotime($privateCloudOrder[0]['EndDate']));
 				   
			    $htmlPrefix = $Config['EmailTemplateFolder'];
			    
			    /******ADMIN EMAIL********/
				//$contents = file_get_contents($htmlPrefix."orderAdmin.htm");
				//$subject  = "Private Cloud Order Details";

				$contentActive=$this->getEmailTemplate('12');
				$contents=stripslashes($contentActive[0]['Content']);
				$subject=stripslashes($contentActive[0]['subject']);
				if(!empty($contentActive[0]['ToEmail'])){
					$Config['AdminEmail'] = stripslashes($contentActive[0]['ToEmail']);
				}
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DisplayName]",$DisplayName, $contents);
				$contents = str_replace("[ORDER_MSG]",$orderMsg,$contents);
				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;
				//echo $arryRow[0]['Email'].$Config['SiteName'].$contents; exit;		
				$mail->Send();
				
				 /******USER  EMAIL********/
				
				/************************/
				$objLicense=new license();
				$arryLicenseKey['DomainName'] = $privateCloudOrder[0]['DomainName'];
				$arryLicenseKey['LicenseKey'] = GenerateKeyString();
				$arryLicenseKey['ExpiryDate'] = $privateCloudOrder[0]['EndDate'];
				$arryLicenseKey['Status'] = '1';
				$arryLicenseKey['MaxUser'] = $privateCloudOrder[0]['MaxUser'];
				$LicenseID = $objLicense->AddLicense($arryLicenseKey); 
				
				/************************/						
				
				$orderMsg .= '<br><br>Licence Expiry: '.$arryLicenseKey['ExpiryDate'];
				$orderMsg .= '<br><br>Licence Key: <br>'.$arryLicenseKey['LicenseKey'];
				//$contents = file_get_contents($htmlPrefix."orderUser.htm");
				//$subject  = "Private Cloud Order Details";
			
				$contentActive=$this->getEmailTemplate('13');
				$contents=stripslashes($contentActive[0]['Content']);
				$subject=stripslashes($contentActive[0]['subject']);
				if(!empty($contentActive[0]['FromEmail'])){
					$Config['AdminEmail'] = stripslashes($contentActive[0]['FromEmail']);
				}


				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[USERNAME]",$DisplayName, $contents);
				$contents = str_replace("[ORDER_MSG]",$orderMsg,$contents);
				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($privateCloudOrder[0]['customer_email_id']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;
				//echo $arryRow[0]['Email'].$Config['SiteName'].$contents; exit;				
				$mail->Send();
	           
			    return $OrderID;

	}
	
	
	
	function ActivateOrder($CmpID,$OrderID,$TransactionID)
	{

		global $Config;
		extract($arryDetails);
		$sql = "select o.*,c.CompanyName, c.DisplayName, c.Email,c.ExpiryDate, c.MaxUser as LastNumUser from orders o inner join company c on o.CmpID=c.CmpID where o.CmpID='".mysql_real_escape_string($CmpID)."' and o.OrderID='".mysql_real_escape_string($OrderID)."' ";

		$arryRow = $this->query($sql, 1);

		if($arryRow[0]['OrderID'] > 0){
			$Status = '1';
			$strSQLQuery = "update orders set Status='".$Status."',TransactionID='".mysql_real_escape_string($TransactionID)."' where OrderID='".mysql_real_escape_string($OrderID)."'";
			$this->query($strSQLQuery, 0);

			$MaxUser = $arryRow[0]['MaxUser'];
			$ExpiryDate =  $arryRow[0]['EndDate'];
				
			$StorageLimit = $arryRow[0]['FreeSpace'];
			$StorageLimitUnit  =  $arryRow[0]['FreeSpaceUnit'];
				
			if($arryRow[0]['AdditionalSpace']>0){
				$AdditionalGB = $arryRow[0]['AdditionalSpace'];
				if($arryRow[0]['AdditionalSpaceUnit']=='TB'){
					$AdditionalGB = 1024 * $arryRow[0]['AdditionalSpace'];
				}
				$StorageLimit = $StorageLimit + $AdditionalGB;
				if($StorageLimit>=1024){
					$StorageLimit = round($StorageLimit/1024,8);
					$StorageLimitUnit  =  'TB';
				}
					
			}
				
				
			$sql="update company set Status='1',PaymentPlan='".mysql_real_escape_string($arryRow[0]['PaymentPlan'])."',ExpiryDate='".$ExpiryDate."',MaxUser='".$MaxUser."', StorageLimit='".mysql_real_escape_string($StorageLimit)."', StorageLimitUnit='".mysql_real_escape_string($StorageLimitUnit)."' where CmpID='".$CmpID."'";
			//echo $sql; exit;
			$this->query($sql,0);



			$UpgradeMsg = '<br>Plan Type: '.$arryRow[0]['PaymentPlan'];
			$UpgradeMsg .= '<br>Duration: '.$arryRow[0]['PlanDuration'];
			$UpgradeMsg .= '<br>Total Amount Paid: $'.$arryRow[0]['TotalAmount'];
			$UpgradeMsg .= '<br>Plan Expiry Date: '.date("d/m/Y",strtotime($ExpiryDate));
			$UpgradeMsg .= '<br>Number Of Users: '.$arryRow[0]['MaxUser'];
			$UpgradeMsg .= '<br>Free Space: '.$arryRow[0]['FreeSpace'].' '.$arryRow[0]['FreeSpaceUnit'];
			if($arryRow[0]['AdditionalSpace']>0){
				$UpgradeMsg .= '<br>Additional Space: '.$arryRow[0]['AdditionalSpace'].' '.$arryRow[0]['AdditionalSpaceUnit'];
			}
				
			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."upgrade.htm");
			$subject  = "Account Upgrade Details";
			$contents = str_replace("[URL]",$Config['WebUrl'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[DisplayName]",$arryRow[0]['DisplayName'], $contents);
			$contents = str_replace("[UPGRADE_MSG]",$UpgradeMsg,$contents);
			$contents = str_replace("[FULLNAME]",$DisplayName, $contents);
			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($arryRow[0]['Email']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);
			$mail->Subject = $Config['SiteName']." - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;
			#echo $arryRow[0]['Email'].$Config['SiteName'].$contents;
			if($Config['Online'] == '1'){
				$mail->Send();
			}
			return true;
		}
	}

	function getCompanyById($CmpID){
		$sql="SELECT * FROM company WHERE CmpID= '".$CmpID."'";
		return $this->query($sql, 1);
	}

	function UpdateProfile($arryDetails,$CmpID){
		extract($arryDetails);

		if(!empty($CmpID)){

			$strSQLQuery = "update company set CompanyName='".addslashes($CompanyName)."', Description='".addslashes($Description)."', Address='".addslashes($Address)."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."'
				,UpdatedDate = '".date('Y-m-d')."'	where CmpID='".mysql_real_escape_string($CmpID)."'";
			$this->query($strSQLQuery, 0);

		}

		return 1;
	}


	function getOrderByCmpId($CmpID){
		$sql="SELECT * FROM orders WHERE CmpID='".$CmpID."' ORDER BY OrderID DESC";
		return $this->query($sql, 1);
	}

	function GetCurrentOrder($CmpID){
		$sql="SELECT o.* FROM orders o WHERE o.CmpID='".$CmpID."' and o.Status='1' ORDER BY OrderID DESC limit 0,1";
		return $this->query($sql, 1);
	}




	function UpdateAdminSubModules($CmpID,$Department,$PaymentPlan,$packageFeatureId)
	{

			
		if(!empty($CmpID) && $Department==5 && !empty($PaymentPlan)){
				
			$sql = "update admin_modules set Status='0' where depID = '".$Department."'";
			$this->query($sql,0);

			/**********************/
			$sql2 = "update admin_modules set Status='0'  where ModuleID in('130', '143', '147','2008','2011','1051') "; //Setting Sub Module: 115
			$this->query($sql2,0);

			//new for territoy,email template,user log,lead form
			$sql3 = "update admin_modules set Status='0'  where ModuleID in('155', '156', '157','158','152','1050','175','1055') "; //Setting Sub Module: 115
			$this->query($sql3,0);
			
			
			/*switch($PaymentPlan){
			 case 'standard':
				//Lead, Opportunity, Document, User, Settings
				$sql1="SELECT id,name,feature from packages WHERE id=7 AND package_type=4 ";
				$packFeature=$this->query($sql1,0);
				print_r($packFeature);

				$sql = "update admin_modules set Status='1' where ModuleID in('102','103','105','115','2001') ";
				$this->query($sql,0);

				break;

				case 'professional':
				//Lead, Opportunity, Document, User, Contact, Quote, Item, Customer, Settings

				$sql = "update admin_modules set Status='1' where ModuleID in('102','103','105','107','108','2015','115','2001','2003') ";
				$this->query($sql,0);


				break;

				case 'enterprise':
				//All
				$sql = "update admin_modules set Status='1' where depID = '".$Department."'";
				$this->query($sql,0);

				$sql2 = "update admin_modules set Status='1'  where ModuleID in('130', '143', '147') "; //Setting Sub Module: 115
				$this->query($sql2,0);

				break;
				}*/
				
			if(!empty($packageFeatureId)){				
				$arryPkg =  explode(",", $packageFeatureId);
				$arryPkg[] = 115;
				if(in_array("155",$arryPkg)){
					$arryPkg[] = 156;
					$arryPkg[] = 157;
					$arryPkg[] = 158;					
				}
				$packageFeatureId = implode(",",$arryPkg);
				
				$sql = "update admin_modules set Status='1' where ModuleID in(".$packageFeatureId.") ";
			
				$this->query($sql,0);

				if(!in_array("182",$arryPkg)){
					$sql2 = "update admin_modules set Status='0' where ModuleID in(1054) ";			
					$this->query($sql2,0);
				}


				
			}
				
				

		}

			
		return true;

	}

	
// Added by shravan 13 feb,2015 for status checking of company
     function IsActive($CmpID){
        $sql="SELECT status from company WHERE CmpID='".$CmpID."'";
        return $this->query($sql, 1);
    }
    
    function getEmailTemplate($CatID){
	$sql="SELECT * FROM email_template WHERE CatID='".$CatID."'";
	return $this->query($sql, 1);
    }



  function TrialExpiryMail(){
	
		global $Config;

		$contentActive = $this->getEmailTemplate('17');
		$DaysBefore = $contentActive[0]['DaysBefore'];
		if(empty($DaysBefore)) $DaysBefore=5;

		$strSQLQuery = "select CmpID, CompanyName, Email, DisplayName, JoiningDate, ExpiryDate, TrialExpiryMailSent, DATEDIFF(ExpiryDate,JoiningDate) as DaysRegister, DATEDIFF(ExpiryDate,now()) as DaysToExpire from company where Department='5' and ExpiryDate>'0' HAVING (DaysRegister<='31' and DaysToExpire>'0' and DaysToExpire<='".$DaysBefore."') ";  //Trial Company Listing		
		$arryRow = $this->query($strSQLQuery, 1);
		//echo '<pre>';print_r($arryRow);exit;
		$num = sizeof($arryRow);

		if($num>0){	
			
			if(!empty($contentActive[0]['FromEmail'])){
				$Config['AdminEmail'] = stripslashes($contentActive[0]['FromEmail']);
			}
		
			foreach($arryRow as $values){
				unset($contents);
				$contents=stripslashes($contentActive[0]['Content']);
				$subject=stripslashes($contentActive[0]['subject']);
				
				
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[NUMDAYS]",$values["DaysToExpire"],$contents);

				$contents = str_replace("[USERNAME]",$values["DisplayName"], $contents);


				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($values["Email"]);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;
				//echo $subject.$values["Email"].$Config['AdminEmail'].$contents;

				$SendMailFlag=1;
				if($contentActive[0]['MailFrequency']=='0' && $values['TrialExpiryMailSent']==1){					$SendMailFlag=0;
				}


				$sqlup="update company set TrialExpiryMailSent='1' where CmpID='".$values['CmpID']."'";
				$this->query($sqlup,0);  

 
				
				if($Config['Online'] == '1' && $SendMailFlag==1){
					$mail->Send();
				}
				
			}


			return true;
		}

	}



function unique_multidim_array($arryRow,$key){
    //echo $key;die('pp');
            $temp_array = array();
            $i = 0;
            $key_array = array();

            foreach($arryRow as $val){
                if(!in_array($val[$key],$key_array)){
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
                $i++;
            }
            return $temp_array;
  }



 function SubscriptionExpiryMail() {
            
            global $Config;

		$contentActive = $this->getEmailTemplate('18');
		$DaysBefore = $contentActive[0]['DaysBefore'];
		if(empty($DaysBefore)) $DaysBefore=5;
                
                
                
                $strSQLQuery="SELECT o.CmpID,o.OrderID,c.Email,c.Email,c.DisplayName, o.PaymentPlan, o.customer_email_id, o.CompanyName, o.customer_first_name, o.customer_last_name, o.PaymentPlan, o.OrderType, o.ExpiryMailSent,o.EndDate,c.ExpiryDate, DATEDIFF(o.EndDate,now()) as DaysToExpire FROM `orders` o INNER JOIN company c on o.CmpID=c.CmpID where c.Status='1' and o.OrderType!='Free' and c.ExpiryDate>'0'  and o.EndDate>'0' and c.ExpiryDate=o.EndDate  HAVING (DaysToExpire>'0' and DaysToExpire<='".$DaysBefore."')   ORDER BY o.OrderID DESC ";
           
		$arryRow = $this->query($strSQLQuery, 1);
		//echo '<pre>';print_r($arryRow);exit;
                
		if(!empty($arryRow)){
                $newSortedArray=  $this->unique_multidim_array($arryRow,'CmpID');
                $num = sizeof($newSortedArray);
                }
		//echo '<pre>';print_r($newSortedArray);exit;               
		$Config['Online']=1;
                if($num>0){	
			
			if(!empty($contentActive[0]['FromEmail'])){
				$Config['AdminEmail'] = stripslashes($contentActive[0]['FromEmail']);
			}
		
			foreach($newSortedArray as $values){
				unset($contents);
				$contents=stripslashes($contentActive[0]['Content']);
				$subject=stripslashes($contentActive[0]['subject']);
				
				                                
                                
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[NUMDAYS]",$values["DaysToExpire"],$contents);

				$contents = str_replace("[USERNAME]",$values["DisplayName"], $contents);
				$contents = str_replace("[PACKAGE_NAME]",$values["PaymentPlan"], $contents);


				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($values["Email"]);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;
				//echo $subject.$values["Email"].$Config['AdminEmail'].$contents;exit;

				$SendMailFlag='1';
				if($contentActive[0]['MailFrequency']=='0' && $values['ExpiryMailSent']=='1'){
                                    $SendMailFlag='0';
				}
				$sqlup="update orders set ExpiryMailSent='1' where OrderID='".$values['OrderID']."'";
                                
				$this->query($sqlup,0);  

 			
				
				if($Config['Online'] == '1' && $SendMailFlag==1){					
					$mail->Send();
				}
				
			}


			return true;
		}
            
            
        }


 function StorageLimitExpireMail() {
            global $Config;
            
            $contentActive = $this->getEmailTemplate('19');
		$DaysBefore = $contentActive[0]['DaysBefore'];
		if(empty($DaysBefore)) $DaysBefore=100;
                $KbRemainStorage=1024*$DaysBefore;
                //echo $KbRemainStorage;die;
                $sql="SELECT `CmpID`,`Email`, DisplayName, `StorageLimitExpireMailSent`,`StorageLimit`,`Storage`,`StorageLimitUnit`, (CASE
                        WHEN `StorageLimitUnit` = 'GB' THEN (StorageLimit * 1048576) 
                        ELSE  CASE 
                                        WHEN `StorageLimitUnit` = 'TB'
                                        THEN (StorageLimit * 1073741824)
                                        ELSE '0'END
                        END) - `Storage` as diff_storage FROM `company` WHERE Status='1' and StorageLimit!='' having diff_storage<='".$KbRemainStorage."'";
            $arryRow = $this->query($sql, 1);
            //echo '<pre>';print_r($arryRow);die;//5239954
            $num = sizeof($arryRow);
            if($num>0){	
			
			if(!empty($contentActive[0]['FromEmail'])){
				$Config['AdminEmail'] = stripslashes($contentActive[0]['FromEmail']);
			}
		
			foreach($arryRow as $values){

				$STORAGE_LEFT = round($values["diff_storage"]/1024,2);
				unset($contents);
				$contents=stripslashes($contentActive[0]['Content']);
				$subject=stripslashes($contentActive[0]['subject']);
				
				
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[STORAGE_LEFT]",$STORAGE_LEFT,$contents);

				$contents = str_replace("[USERNAME]",$values["DisplayName"], $contents);


				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($values["Email"]);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;
				

				$SendMailFlag=1;
				if($contentActive[0]['MailFrequency']=='0' && $values['StorageLimitExpireMailSent']==1){
                                    $SendMailFlag=0;
				}
				$sqlup="update company set StorageLimitExpireMailSent='1' where CmpID='".$values['CmpID']."'";
				$this->query($sqlup,0);  

				 
				
				if($Config['Online'] == '1' && $SendMailFlag==1){
                               		$mail->Send();
				}
				
			}


			return true;
		}
            
            
        }
        
        function CreditCardExpireMail() {
            
            global $Config;

		$contentActive = $this->getEmailTemplate('20');
		$DaysBefore = $contentActive[0]['DaysBefore'];
		if(empty($DaysBefore)) $DaysBefore=5;
            
                $sql="SELECT o.CmpID,o.OrderID,c.Email,c.DisplayName,o.customer_email_id,o.CompanyName,o.customer_first_name,o.customer_last_name,o.PaymentPlan,o.OrderType,o.CreditCardExpireMailSent,DATEDIFF((CASE WHEN o.`OrderType`!='Free' THEN CONCAT(o.`cc_expiration_year`,'-',o.`cc_expiration_month`,'-',1) ELSE '0' END),now()) as DaysToExpire FROM `orders` o  INNER JOIN company c on o.CmpID=c.CmpID WHERE c.Status='1' and OrderType!='Free' and c.ExpiryDate>'0'  and o.customer_credit_card_number!='' having (DaysToExpire>'0' and DaysToExpire<='".$DaysBefore."') ORDER BY o.OrderID DESC";
               // echo $sql;die;
                
                $arryRow = $this->query($sql, 1);
		 //echo '<pre>'; print_r($arryRow);die;
                
		if(!empty($arryRow)){
                $newSortedArray=  $this->unique_multidim_array($arryRow,'CmpID');
               // echo '<pre>'; print_r($newSortedArray);die;
                $num = sizeof($newSortedArray);
                }
               
                if($num>0){	
			
			if(!empty($contentActive[0]['FromEmail'])){
				$Config['AdminEmail'] = stripslashes($contentActive[0]['FromEmail']);
			}
		
			foreach($newSortedArray as $values){
				unset($contents);
				$contents=stripslashes($contentActive[0]['Content']);
				$subject=stripslashes($contentActive[0]['subject']);
				
				
                                
                                
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[NUMDAYS]",$values["DaysToExpire"],$contents);

				$contents = str_replace("[USERNAME]",$values["DisplayName"], $contents);


				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($values["Email"]);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;
				//echo $subject.$values["Email"].$Config['AdminEmail'].$contents;

				$SendMailFlag='1';
				if($contentActive[0]['MailFrequency']=='0' && $values['CreditCardExpireMailSent']=='1'){
                                    $SendMailFlag='0';
                                   
                         
				}
				$sqlup="update orders set CreditCardExpireMailSent='1' where CmpID='".$values['CmpID']."'";
                                
				$this->query($sqlup,0);  
 
				if($Config['Online'] == '1' && $SendMailFlag==1){
					$mail->Send();
				}
				
			}


			return true;
		}
            
        }







}

?>
