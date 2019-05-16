<?
class contact extends dbClass
{
		//constructor
		function contact()
		{
			$this->dbClass();
		} 
		
		function  ListContact($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where c.ContactID=".$id):(" where c.locationID=".$_SESSION['locationID']);

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and c.AssignTo='".$_SESSION['AdminID']."'  "):("");

			if($SearchKey=='active' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FirstName like '%".$SearchKey."%' or c.LastName like '%".$SearchKey."%'  or c.Email like '%".$SearchKey."%' or c.ContactID like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c.FirstName ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			$strSQLQuery = "select c.ContactID,c.Status,c.LastName,c.title,c.Email,c.FirstName,c.Image,d.Department,e.Role,e.EmpID,e.UserName as AssignTo from c_contact c left outer join  h_employee e on e.EmpID=c.AssignTo left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
	
		



		function  GetContactImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where c.ContactID=".$id):(" where 1 ");

			$strSQLQuery = "select c.Image  from c_contact c ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

	
		function  GetContact($ContactID,$Status)
		{
			$strSQLQuery = "select * from c_contact   ";

			$strSQLQuery .= (!empty($ContactID))?(" where ContactID=".$ContactID):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and Status=".$Status):("");

			return $this->query($strSQLQuery, 1);
		}

				
		
		function GetContactBrief($ContactID)
		{
			$strAddQuery .= (!empty($ContactID))?(" and c.ContactID=".$ContactID):(" and locationID=".$_SESSION['locationID']);
			$strSQLQuery = "select c.ContactID,c.Email from c_contact c  where c.Status=1 ".$strAddQuery." order by c.ContactID asc";
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllContacts($Status)
		{
			$strSQLQuery = "select ContactID,UserName,Email from c_contact where 1 ";

			$strSQLQuery .= ($Status>0)?(" and Status=".$Status.""):("");

			$strSQLQuery .= " order by UserName,Email Asc";

			return $this->query($strSQLQuery, 1);
		}


		function  GetContactDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where c.ContactID=".$id):(" where 1 ");

			$strAddQuery .= " order by c.JoiningDate Desc ";

			$strSQLQuery = "select c.*,c.name as Country , if(c.city_id>0,ct.name,c.OtherCity) as City, if(c.state_id>0,s.name,c.OtherState) as State from c_contact e left outer join country c on c.country_id=c.country_id left outer join state s on c.state_id=s.state_id left outer join city ct on c.city_id=ct.city_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddContact($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status=1;
			$FullName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];

			 $strSQLQuery = "insert into c_contact (LeadID,locationID,Email,FirstName,LastName,FullName,date_of_birth,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber, PersonalEmail,  Status, OtherState, OtherCity,title, lead_source, Organization,ReportsTo,AssignTo, reference, Department, do_not_call, notify_owner, email_opt_out, PortalUser, Supp_start_date,Supp_end_date,ipaddress ,description, UpdatedDate,CustID ) values( '".$LeadID."','".$_SESSION['locationID']."', '".addslashes($Email)."', '".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($FullName)."', '".$date_of_birth."', '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($LandlineNumber)."', '".addslashes($PersonalEmail)."', '".$Status."','".addslashes($OtherState)."', '".addslashes($OtherCity)."',  '".addslashes($title)."', '".addslashes($lead_source)."',  '".addslashes($Organization)."', '".addslashes($ReportsTo)."', '".addslashes($AssignTo)."', '".$reference."', '".addslashes($Department)."', '".addslashes($do_not_call)."',  '".addslashes($notify_owner)."' ,  '".$email_opt_out."', '".$PortalUser."','".addslashes($Supp_start_date)."', '".addslashes($Supp_end_date)."', '".addslashes($ipaddress)."', '".addslashes($description)."',  '".$Config['TodayDate']."', '".addslashes($CustID)."')";
			
			

			$this->query($strSQLQuery, 0);

			$ContactID = $this->lastInsertId();

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."Contactdetails.htm");
			$subject  = "New Contact Details";
			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
				
			
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Contact - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			/*if($Config['DbUser'] != 'root'){
				 $mail->Send();	
			}*/

			
			//Send Acknowledgment Email to admin
			$contents = file_get_contents($htmlPrefix."admin_Contact.htm");

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			

			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Contact - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			/*if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}*/
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $ContactID;

		}


	/*	function UpdateContact($arryDetails){   
			extract($arryDetails);

			$UserName = trim($FirstName.' '.$LastName);
	
			
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
			
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			if(empty($Status)) $Status=1;


			$strSQLQuery = "update c_contact set UserName='".addslashes($UserName)."', Email='".addslashes($Email)."',  FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', Gender='".addslashes($Gender)."',date_of_birth='".$date_of_birth."', 
			Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."', PersonalEmail='".addslashes($PersonalEmail)."', Status='".$Status."', OtherGraduation='".addslashes($OtherGraduation)."', OtherPostGraduation='".addslashes($OtherPostGraduation)."' 
			,OtherState='".addslashes($OtherState)."',OtherCity='".addslashes($OtherCity)."'			 
			,ExperienceYear='".addslashes($ExperienceYear)."'
			,ExperienceMonth='".addslashes($ExperienceMonth)."'
			,Skill='".addslashes($Skill)."'
			,Doctorate='".addslashes($Doctorate)."'
			,OtherDoctorate='".addslashes($OtherDoctorate)."'
			,Graduation='".$Graduation."'
			,PostGraduation='".addslashes($PostGraduation)."'
			,Certification='".addslashes($Certification)."'
			,UpdatedDate = '".date('Y-m-d')."'
			,Nationality='".addslashes($Nationality)."'
			,MaritalStatus='".addslashes($MaritalStatus)."'
			,Department='".addslashes($Department)."'
			,JobTitle='".addslashes($JobTitle)."'
			,JobType='".addslashes($JobType)."'
			,Salary='".addslashes($Salary)."'
			,SalaryFrequency='".addslashes($SalaryFrequency)."'
			,Role='".addslashes($Role)."'
			where ContactID=".$ContactID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}*/

		function UpdateDepartmentHead($ContactID,$depID,$DeptHead){  
			/*
			$sql = "select ContactID,depID from department where depID=".$depID;
			$arryRow = $this->query($sql, 1);
			if(!empty($arryRow[0]["ContactID"])){
				$strSQLQuery = "update department set ContactID='0' where depID=".$arryRow[0]["depID"]; 
				$this->query($strSQLQuery, 0);
			}	*/		
			
			$strSQLQuery = "update  h_department set ContactID='0' where ContactID=".$ContactID; 
			$this->query($strSQLQuery, 0);	


			if($DeptHead==1){
				$strSQLQuery = "update  h_department set ContactID='".$ContactID."' where depID=".$depID; 
				$this->query($strSQLQuery, 0);
			}else{
				$strSQLQuery = "update  h_department set ContactID='0' where depID=".$depID; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

		function UpdatePersonal($arryDetails){ 
			 global $Config;
		   
			extract($arryDetails);
			$FullName = trim($FirstName.' '.$LastName);
			$strSQLQuery = "update c_contact set FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', FullName='".addslashes($FullName)."',date_of_birth='".$date_of_birth."',Email='".$Email."',PersonalEmail='".$PersonalEmail."',title='".addslashes($title)."',Department='".addslashes($Department)."',reference='".$reference."',ReportsTo='".addslashes($ReportsTo)."',lead_source='".addslashes($lead_source)."',AssignTo='".addslashes($AssignTo)."',do_not_call='".$do_not_call."',notify_owner='".$notify_owner."',email_opt_out='".$email_opt_out."',UpdatedDate = '".$Config['TodayDate']."'	where ContactID=".$ContactID; 
			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdateContact($arryDetails){ 
			

			extract($arryDetails);		
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);			
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';

			$strSQLQuery = "update c_contact set Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."',  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."' 
			where ContactID=".$ContactID;
			$this->query($strSQLQuery, 0);
			return 1;
		}


		function UpdatePortal($arryDetails){ 
			
			global $Config;
		  
			extract($arryDetails);

			$strSQLQuery = "update c_contact set  PortalUser='".addslashes($PortalUser)."', Supp_start_date='".addslashes($Supp_start_date)."' 
			,Supp_end_date='".addslashes($Supp_end_date)."'
			,UpdatedDate = '".$Config['TodayDate']."',CustID='".addslashes($CustID)."'			
			where ContactID=".$ContactID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

		function UpdateJobDetail($arryDetails){
			global $Config;

		  
			extract($arryDetails);

			$strSQLQuery = "update c_contact set ExperienceYear='".addslashes($ExperienceYear)."'		,ExperienceMonth='".addslashes($ExperienceMonth)."'	,JoiningDate = '".$JoiningDate."'
			,ExpiryDate = '".$ExpiryDate."'	,UpdatedDate = '".$Config['TodayDate']."'
			,Department='".addslashes($Department)."',JobTitle='".addslashes($JobTitle)."'
			,JobType='".addslashes($JobType)."'	,Skill='".addslashes($Skill)."', Salary='".addslashes($Salary)."'
			,SalaryFrequency='".addslashes($SalaryFrequency)."'
			where ContactID=".$ContactID; 

			$this->query($strSQLQuery, 0);

			$this->UpdateDepartmentHead($ContactID,$Department,$DeptHead);

			return 1;
		}


		/*function UpdateAccount($arryDetails){   
			extract($arryDetails);
			if(empty($Status)) $Status=1;

			if(!empty($Password)) $PasswordSql = ", Password='".md5($Password)."'" ;

			$strSQLQuery = "update c_contact set Email='".addslashes($Email)."', Role='".addslashes($Role)."', Status='".$Status."' ".$PasswordSql." where ContactID=".$ContactID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

		function UpdateSupervisor($arryDetails){   
			extract($arryDetails);
			$strSQLQuery = "update c_contact set Supervisor='".addslashes($Supervisor)."', ReportingMethod='".addslashes($ReportingMethod)."' where ContactID=".$ContactID; 
			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdateImmigration($arryDetails){   
			extract($arryDetails);
			
			$strSQLQuery = "update c_contact set ImmigrationType='".addslashes($ImmigrationType)."', ImmigrationNo='".addslashes($ImmigrationNo)."', ImmigrationExp='".addslashes($ImmigrationExp)."' where ContactID=".$ContactID; 
			$this->query($strSQLQuery, 0);
			return 1;
		}
		
		function UpdateContactResume($arryDetails){   
			extract($arryDetails);

			$strSQLQuery = "update c_contact set UpdatedDate = '".date('Y-m-d')."'	where ContactID=".$ContactID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

		function ChangePassword($ContactID,$Password)
		{
			global $Config;				
		
			$strSQLQuery = "update c_contact set Password='".md5($Password)."' where ContactID=".$ContactID;
			$this->query($strSQLQuery, 0);

			$sql = "select ContactID,UserName,Email from c_contact where ContactID='".$ContactID."'";
			$arryRow = $this->query($sql, 1);

			$htmlPrefix = 'hrms/'.$Config['EmailTemplateFolder'];

			$contents = file_get_contents($htmlPrefix."password.htm");
			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[EMAIL]",$arryRow[0]['Email'],$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($arryRow[0]['Email']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Contact - Your login details have been reset";
			$mail->IsHTML(true);
			$mail->Body = $contents;  
			//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}

			return 1;
		}		
		

		function IsActivatedContact($ContactID,$verification_code)
		{
			$sql = "select * from c_contact where ContactID='".$ContactID."' and verification_code='".$verification_code."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['ContactID']>0) {
				if ($arryRow[0]['Status']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}

		

		
		function ForgotPassword($Email){
			
			global $Config;
			$sql = "select * from c_contact where Email='".$Email."' and Status=1"; 
			$arryRow = $this->query($sql, 1);
			$UserName = $arryRow[0]['UserName'];

			if(sizeof($arryRow)>0)
			{
				$Password = substr(md5(rand(100,10000)),0,8);
				
				$sql_u = "update c_contact set Password='".md5($Password)."'
				where Email='".$Email."'";
				$this->query($sql_u, 0);

				$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../".$Config['EmailTemplateFolder']):($Config['EmailTemplateFolder']);

				$contents = file_get_contents($htmlPrefix."forgot.htm");
				
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
				$mail->Subject = $Config['SiteName']." - Contact - New Password";
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
		
		*/


		function RemoveContact($ContactID)
		{

		
			$strSQLQuery = "delete from c_contact where ContactID=".$ContactID; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function UpdateImage($Image,$ContactID)
		{
			$strSQLQuery = "update c_contact set Image='".$Image."' where ContactID=".$ContactID;
			return $this->query($strSQLQuery, 0);
		}
		
		

		
		function changeContactStatus($ContactID)
		{
			$sql="select * from c_contact where ContactID=".$ContactID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_contact set Status='$Status' where ContactID=".$ContactID;
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleContactStatus($ContactIDs,$Status)
		{
			$sql="select ContactID from c_contact where ContactID in (".$ContactIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update c_contact set Status=".$Status." where ContactID in (".$ContactIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function ValidateContact($Email,$Password){
			$strSQLQuery = "select * from c_contact where Email='".$Email."' and Password='".md5($Password)."' and Status=1";
			return $this->query($strSQLQuery, 1);
		}

		function isEmailExists($Email,$ContactID=0)
		{
			$strSQLQuery = (!empty($ContactID))?(" and ContactID != ".$ContactID):("");
			$strSQLQuery = "select ContactID from c_contact where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['ContactID'])) {
				return true;
			} else {
				return false;
			}
		}
	
		
		function UpdatePasswordEncrypted($ContactID,$Password)
		{
				 $sql = "update c_contact set Password='".md5($Password)."', PasswordUpdated='1'  where ContactID = ".$ContactID;
				$rs = $this->query($sql,0);
				
				return true;

		}
	/*****************************/

}
?>
