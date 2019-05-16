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
			$VerifyUrl = $Config['Url']."eznetcrm/reseller/index.php?email=".base64_encode($arryRow[0]["Email"]);
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


	function ActiveReseller($Email)
	{
		global $Config;
		//extract($arryDet);
		if(!empty($Email)){
			echo $sql="select RsID,Status,FullName from reseller where Email='".$Email."'";
			$arryCmp = $this->query($sql);
			if(sizeof($arryCmp))
			{
				$Status=1;
				$sql2="update reseller set Status='".$Status."' where RsID='".$arryCmp[0]['RsID']."'";
				$this->query($sql2,0);

				/************************/
				//mail to user
				$htmlPrefix = $Config['EmailTemplateFolder'];

				//$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$CompanyUrl = $Config['Url'].'crm/';

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
				if($Config['Online'] == '1'){
					$mail->Send();
				}

				//echo $Email.$Config['AdminEmail'].$contents; exit;


				/************************/


			}
		}

		return true;

	}
	
	function getDefaultCompany()
	{
		$strSQLQuery = "select CmpID from company where DefaultCompany=1 ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (count($arryRow)>0) {
			return $arryRow[0]['CmpID'];
		} else {  
			return 0;
		}
	}

	
	function InsertSeller($data){
		
		extract($data);
		if(!empty($Email) && !empty($Password) && !empty($CmpID)){
			$FullName = $FirstName.'  '.$LastName ;
			$strSQLQuery = "INSERT INTO reseller (FirstName, LastName, FullName, Email, Password, CmpID, country_id, JoiningDate,UpdatedDate) VALUES ('".mysql_real_escape_string(addslashes($FirstName))."', '".mysql_real_escape_string(addslashes($LastName))."', '".mysql_real_escape_string(addslashes($FullName))."', '".mysql_real_escape_string(addslashes($Email))."', '".mysql_real_escape_string(md5($Password))."', '".mysql_real_escape_string($CmpID)."', '".mysql_real_escape_string($country_id)."','".$JoiningDate."','".$UpdatedDate."') "; 
			
			 $this->query($strSQLQuery, 1);
			 
			 return 1;
		}
	}
	

	function ValidateSeller($Email,$Password,$CmpID){
		if(!empty($Email) && !empty($Password)){
			$strSQLQuery = "select * from reseller where MD5(Email)='".md5($Email)."' and Password='".md5($Password)."' and CmpID='".$CmpID."' and Status=1"; 
			return $this->query($strSQLQuery, 1);
		}
	}

	function isEmailExists($Email,$CmpID=0)
	{
		$strSQLQuery = (!empty($CmpID))?(" and CmpID = '".mysql_real_escape_string($CmpID)."'"):("");
		$strSQLQuery = "select CmpID from reseller where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
		$arryRow = $this->query($strSQLQuery, 1);
		if (count($arryRow)>0) {
			return 1;
		} else {  
			return 0;
		}
		
	}
	
	function getCompanyById($RsID){
		$sql="SELECT * FROM reseller WHERE RsID= $RsID";
		return $this->query($sql, 1);
	}

	function UpdateProfile($arryDetails,$RsID){
		extract($arryDetails);

		if(!empty($RsID)){

			$strSQLQuery = "update reseller set FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', Description='".addslashes($Description)."', Address='".addslashes($Address)."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."'
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

				$sql = "select CmpID, FullName, Email from reseller where RsID='".mysql_real_escape_string($RsID)."'";
				$arryRow = $this->query($sql, 1);

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."password.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
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
			$sql = "select * from reseller where Email='".mysql_real_escape_string($Email)."' and RsID='".mysql_real_escape_string($RsID)."' and Status=1"; 
			$arryRow = $this->query($sql, 1);
			$DisplayName = $arryRow[0]['FullName'];

			if(sizeof($arryRow)>0)
			{

				$Password = substr(md5(rand(100,10000)),0,8);
				
				$sql_u = "update reseller set Password='".md5($Password)."'
				where Email='".$Email."'";
				$this->query($sql_u, 0);

				 $htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."forgot.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
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


	
}

?>
