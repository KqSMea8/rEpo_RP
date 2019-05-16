<?
class rs extends dbClass
{
	//constructor
	function rs()
	{
		$this->dbClass();
	}

	function SendActivationMail($RsID)
	{

		global $Config;
		if(!empty($RsID)){
			$strSQLQuery = "select * from reseller where RsID='".mysql_real_escape_string($RsID)."'";
			$arryRow = $this->query($strSQLQuery, 1);
		    $htmlPrefix = $Config['EmailTemplateFolder'];

			$contents = file_get_contents($htmlPrefix."verify.htm");

			$subject  = "Verify Account";
			$VerifyUrl = $Config['WebUrl']."reseller/index.php?email=".base64_encode($arryRow[0]["Email"]);
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[VERIFY_URL]",$VerifyUrl,$contents);

			$contents = str_replace("[DisplayName]",$arryRow[0]["FullName"], $contents);


			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($arryRow[0]["Email"]);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);
			$mail->Subject = $Config['SiteName']." - Reseller -".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;
		   #echo $arryRow[0]["Email"].$Config['AdminEmail'].$contents; exit;
			
			if($Config['Online'] == '1'){
				$mail->Send();
			}


			return true;
		}

	}


	function ActiveReseller($Email,$Password)
	{
		global $Config;
		//extract($arryDet);
		
		if(!empty($Email)){
			$sql="select RsID,Status,FullName from reseller where Email='".$Email."'";
			$arryCmp = $this->query($sql);
			if(sizeof($arryCmp))
			{
				$Status=1;
				$sql2="update reseller set Status='".$Status."' ,Password='".md5($Password)."' where RsID='".$arryCmp[0]['RsID']."'";
		
				$this->query($sql2,0);

				/************************/
				//mail to user
				$htmlPrefix = $Config['EmailTemplateFolder'];

				//$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$CompanyUrl = $Config['WebUrl'].'reseller/index.php';

				if($BuyNow==1) $emailtemplate = 'logindetails_buy.htm'; 
				else $emailtemplate = 'logindetails.htm';
				
				$contents = file_get_contents($htmlPrefix.$emailtemplate);

				$contents = str_replace("[URL]",$CompanyUrl,$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$contents = str_replace("[FullName]",$arryCmp[0]['DisplayName'], $contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);
				$contents = str_replace("[FULLNAME]",$arryCmp[0]['DisplayName'], $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();
				$mail->AddAddress($Email);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);
				$mail->Subject = " Thanks for Signing up as reseller for EZnetCRM";
				$mail->IsHTML(true);
				$mail->Body = $contents;
				#echo $Email.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();
				}

				/************************/


			}
		}

		return true;

	}
	
	function getDefaultCompany()
	{
		$strSQLQuery = "select CmpID from company where DefaultCompany='1' ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (count($arryRow)>0) {
			return $arryRow[0]['CmpID'];
		} else {  
			return 0;
		}
	}

	
	function InsertSeller($data){
		
		extract($data);
		if(!empty($Email) && !empty($CmpID)){
			$ipaddress = GetIPAddress();
			$CreatedDate= date('Y-m-d H:i:s');
			$Status=0;
			$FullName = $FirstName.'  '.$LastName ;
			$strSQLQuery = "INSERT INTO reseller (FirstName, LastName, FullName, CompanyName, Email, Password, CmpID, country_id, Status, JoiningDate,UpdatedDate,ipaddress,CreatedDate) VALUES ('".mysql_real_escape_string(addslashes($FirstName))."', '".mysql_real_escape_string(addslashes($LastName))."', '".mysql_real_escape_string(addslashes($FullName))."', '".mysql_real_escape_string(addslashes($CompanyName))."', '".mysql_real_escape_string(addslashes($Email))."', '".mysql_real_escape_string(md5($Password))."', '".mysql_real_escape_string($CmpID)."', '".mysql_real_escape_string($country_id)."', '".$Status."' ,'".$JoiningDate."','".$UpdatedDate."','".$ipaddress."','".$CreatedDate."') "; 
			
			 $this->query($strSQLQuery, 1);
			 
			 $RsID = $this->lastInsertId();
			 return $RsID;
		}
	}
	

	function ValidateSeller($Email,$Password,$CmpID){
		if(!empty($Email) && !empty($Password)){
			$strSQLQuery = "select * from reseller where MD5(LCASE(Email))='".md5(strtolower(trim($Email)))."' and Password='".md5($Password)."'  and Status='1'"; 
			return $this->query($strSQLQuery, 1);
		}
	}

	function isEmailExists($Email,$RsID=0)
		{
			$strSQLQuery = (!empty($RsID))?(" and RsID != '".mysql_real_escape_string($RsID)."'"):("");
			$strSQLQuery = "select RsID from reseller where LCASE(Email)='".mysql_real_escape_string(strtolower(trim($Email)))."'".$strSQLQuery;

		
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['RsID'])) {
				return true;
			} else {
				return false;
			}
		}
	
	function getCompanyById($RsID){
		$sql="SELECT * FROM reseller WHERE RsID= '".$RsID."'";
		return $this->query($sql, 1);
	}

	function UpdateProfile($arryDetails,$RsID){
		extract($arryDetails);

		if(!empty($RsID)){
			$FullName = $FirstName.'  '.$LastName ;
			$strSQLQuery = "update reseller set FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', FullName='".addslashes($FullName)."', CompanyName='".addslashes($CompanyName)."', Address='".addslashes($Address)."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."'
				,UpdatedDate = '".date('Y-m-d')."'	where RsID='".mysql_real_escape_string($RsID)."'";
			$this->query($strSQLQuery, 0);

		}

		return 1;
	}
	
	
	
	function ChangePassword($RsID,$Password){
			
			if(!empty($RsID) && !empty($Password)){
				global $Config;				
			
				$strSQLQuery = "update reseller set Password='".mysql_real_escape_string(md5($Password))."' where RsID='".mysql_real_escape_string($RsID)."'"; 
				$this->query($strSQLQuery, 0);

				$sql = "select RsID, FullName, Email from reseller where RsID='".mysql_real_escape_string($RsID)."'";
				$arryRow = $this->query($sql, 1);

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."password.htm");
				
				$CompanyUrl = $Config['WebUrl'].'reseller/index.php';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[DisplayName]",$arryRow[0]['FullName'],$contents);
				$contents = str_replace("[EMAIL]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Reseller login details have been reset.";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents;exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
	}
	
	
	
	function ForgotPassword($Email,$RsID){
			
		global $Config;

		if(!empty($Email)){
			$sql = "select * from reseller where Email='".mysql_real_escape_string($Email)."' and RsID='".mysql_real_escape_string($RsID)."' and Status='1'"; 
			$arryRow = $this->query($sql, 1);
			$DisplayName = $arryRow[0]['FullName'];

			if(sizeof($arryRow)>0)
			{

			     $Password = substr(rand(100,10000),0,8);

				 $sql_u = "update reseller set Password='".md5($Password)."'
				where Email='".$Email."'";
				
				$this->query($sql_u, 0);

				 $htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."forgot.htm");
				
				$CompanyUrl = $Config['WebUrl'].'reseller/index.php';
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl,$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[DisplayName]",$arryRow[0]['FullName'],$contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
						
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Email);
				$mail->AddBCC('parwez.khan@sakshay.in');
				$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Reseller - New Password";
				$mail->IsHTML(true);
				$mail->Body = $contents;  

				#echo  $Email.$Config['AdminEmail'].$contents; exit;

				if($Config['Online'] == '1'){
					$mail->Send();	
				}
				return 1;
			}else{
				return 0;
			}
		}

	}
	
// Added by shravan 13 feb,2015 for status checking of company
        function IsActive($RsID){
        $sql="SELECT status from reseller WHERE RsID='".$RsID."'";
        return $this->query($sql, 1);
    }
    
	function CheckResellerEmail($Email){
			if(!empty($Email)){
				$strSQLQuery = "select RsID from reseller where MD5(Email)='".md5($Email)."'"; 
				return $this->query($strSQLQuery, 1);
			}
		}
		

	function addEmail(){
			$sql="select * from user where name ='madhurendra' and email='madhurendra.yadav@gmail.com'";
	}

	
	function resellerAccountLimit($RsID){
		
			if(!empty($RsID)){
			 $strSQLQuery = "select RsID,AccountLimit,PaymentMethod from reseller where RsID='".$RsID."'"; 
			 return $this->query($strSQLQuery, 1);

		}
		
	}
	
	function resellerOrderAmount($RsID){
		
			if(!empty($RsID)){
			 $strSQLQuery = "select SUM(TotalAmount) as TotalAmount from orders where RsID='".$RsID."'"; 
			 return $this->query($strSQLQuery, 1);

		}
		
	}
	
	
	function resellerDiscount($RsID){
		
			if(!empty($RsID)){
			 $strSQLQuery = "select RsID,DiscountS,DiscountP,DiscountE,DiscountPC from reseller where RsID='".$RsID."'"; 
			 return $this->query($strSQLQuery, 1);

		}
		
	}
	
	
	
		/*function addPaymentReseller($arryDetails){
			
		 extract($arryDetails);
		 $sqlCustCheck = "select Cid,CustCode from s_customers where Email='".$Email."'";
		 $arryCustCheck = $this->query($sqlCustCheck, 1);
		$ipaddress = $_SERVER["REMOTE_ADDR"];
		$Date=date("Y-m-d");
		$CustCode=$arryCustCheck[0]['CustCode'];
			
			$strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$OrderID."', CustCode = '".$CustCode."',Method = 'Electronic Transfer',EntryType = 'Invoice',PaymentDate = '".$Date."', PaymentType = 'Sales',Flag= '1', Currency = '". $Config['Currency']."', IPAddress='".$ipaddress."'";
            $this->query($strSQLQuery, 0);
            
		}
		*/

	
}

?>
