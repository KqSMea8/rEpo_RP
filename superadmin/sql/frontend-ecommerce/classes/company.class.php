<?
class company extends dbClass
{
		//constructor
		function company()
		{
			$this->dbClass();
		} 
		
		function  ListCompany($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where c.CmpID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			if($SearchKey=='active' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=0";
			}else if($SortBy != ''){

				if($SortBy=='c.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");

				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c.CompanyName like '%".$SearchKey."%' or c.DisplayName like '%".$SearchKey."%' or c.Email like '%".$SearchKey."%' or c.CmpID like '%".$SearchKey."%' or c.PaymentPlan like '%".$SearchKey."%'  ) " ):("");			}


			if($_SESSION['AdminType']=="user"){
				$userSql =  " left outer join permission_cmp p on (c.CmpID=p.CmpID and p.UserID='".$_SESSION['AdminID']."') ";		$strAddQuery .= " and p.CmpID IS NULL";



				#$strAddQuery .=  " and c.CmpID not in (select p.CmpID from permission_cmp p where p.UserID='".$_SESSION['AdminID']."') ";
			}

			//echo $SortBy;exit;


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c.CompanyName ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select c.CmpID,c.Status,c.DisplayName,c.CompanyName,c.Email,c.Image,c.ExpiryDate,c.PaymentPlan,c.DefaultCompany from company c ".$userSql.$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function  CheckUserCmp($UserID,$CmpID)
		{
			$strSQLQuery = "select id from permission_cmp where CmpID='".mysql_real_escape_string($CmpID)."' and UserID='".mysql_real_escape_string($UserID)."' ";

			return $this->query($strSQLQuery, 1);
		}

		function  GetCompanyImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where CmpID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strSQLQuery = "select e.Image  from company e ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

		function  GetCompanyDisplayName($CmpID)
		{
			if(!empty($CmpID)){			
				$strSQLQuery = "select DisplayName from company where CmpID='".mysql_real_escape_string($CmpID)."'";

				return $this->query($strSQLQuery, 1);
			}
		}

		function  GetCompany($CmpID,$Status)
		{
			$strSQLQuery = "select e.* from company e ";

			$strSQLQuery .= (!empty($CmpID))?(" where e.CmpID='".mysql_real_escape_string($CmpID)."'"):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and e.Status='".mysql_real_escape_string($Status)."'"):("");
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetCompanyBrief($CmpID)
		{
			$strAddQuery .= (!empty($CmpID))?(" and c.CmpID='".mysql_real_escape_string($CmpID)."'"):("");
			$strSQLQuery = "select c.CmpID, c.CompanyName, c.DisplayName, c.Email, c.Image, c.Timezone, c.DateFormat, c.TimeFormat, c.SessionTimeout, c.Department, c.currency_id, c.MaxUser,c.RecordsPerPage, c.StorageLimit , c.StorageLimitUnit,c.Storage,c.TrackInventory,c.ExpiryDate,c.AdditionalCurrency,c.PunchingBlock,c.PunchingIP,c.PaymentPlan from company c where c.Status=1 ".$strAddQuery." order by c.CmpID asc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetCompanyByDisplay($DisplayName)
		{
			if(!empty($DisplayName)){
				$strSQLQuery = "select CmpID,DisplayName,Email,Image,Banner,CompanyName,Timezone,DateFormat,TimeFormat,country_id,currency_id, Department,ExpiryDate from company  where Status=1 and DisplayName='".mysql_real_escape_string($DisplayName)."'";
				return $this->query($strSQLQuery, 1);
			}
		}

		function  GetCompanyByEmail($Email)
		{
			if(!empty($Email)){
				$strSQLQuery = "select CmpID,DisplayName,Email,Department,StorageLimit, StorageLimitUnit,Storage from company where Email='".mysql_real_escape_string($Email)."' ";
				return $this->query($strSQLQuery, 1);
			}
		}


		
		function  GetCompanyDetailDisplay($DisplayName)
		{
			if(!empty($DisplayName)){
				$strSQLQuery = "select cm.CmpID ,cm.DisplayName ,cm.Email ,cm.Address, cm.currency_id, cm.country_id ,cm.state_id ,cm.city_id ,cm.ZipCode  ,c.name as Country, if(cm.state_id>0,s.name,cm.OtherState) as State, if(cm.city_id>0,ct.name,cm.OtherCity) as City,cm.Timezone,cm.DateFormat,cm.TimeFormat,cm.Department from company cm left outer join country c on cm.country_id=c.country_id left outer join state s on cm.state_id=s.state_id left outer join city ct on cm.city_id=ct.city_id where cm.Status=1 and cm.DisplayName='".mysql_real_escape_string($DisplayName)."'";
				return $this->query($strSQLQuery, 1);
			}
		}

		function  GetCompanyDisplay($DisplayName)
		{
			if(!empty($DisplayName)){
				$strSQLQuery = "select c.CmpID,c.CompanyName,c.DisplayName,c.Email,c.Image,c.Timezone,c.DateFormat,c.TimeFormat,c.currency_id  from company c where c.Status=1 and c.DisplayName='".mysql_real_escape_string($DisplayName)."' ";
				return $this->query($strSQLQuery, 1);
			}
		}	
		
		function  AllCompanys($Status)
		{
			$strSQLQuery = "select CmpID,DisplayName,Email from company where 1 ";

			$strSQLQuery .= ($Status>0)?(" and Status='".mysql_real_escape_string($Status)."'"):("");

			$strSQLQuery .= " order by DisplayName,Email Asc";

			return $this->query($strSQLQuery, 1);
		}


		function  GetCompanyDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where e.CmpID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strAddQuery .= " order by e.JoiningDate Desc ";

			$strSQLQuery = "select e.*,c.name as Country , if(e.city_id>0,ct.name,e.OtherCity) as City, if(e.state_id>0,s.name,e.OtherState) as State from company e left outer join country c on e.country_id=c.country_id left outer join state s on e.state_id=s.state_id left outer join city ct on e.city_id=ct.city_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddCompany($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			#if(empty($Status)) $Status=1;
			
			if(!empty($Timezone)) $Timezone = $TimezonePlusMinus.$Timezone;
			/*if(sizeof($Department)>0){
				$Department = implode(",",$Department);
			}else{
				$Department = '';
			}
			
			 
			*/


			$ipaddress = $_SERVER["REMOTE_ADDR"];
			if($JoiningDate<=0) $JoiningDate = date('Y-m-d');

			$strSQLQuery = "insert into company ( DisplayName,Email,Password,CompanyName,Description, ContactPerson ,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber, AlternateEmail,  Status, JoiningDate, ExpiryDate, OtherState, OtherCity,TempPass,ipaddress, UpdatedDate, Fax, Website, MaxUser, Department, Timezone, DateFormat, TimeFormat, currency_id, PaymentPlan, StorageLimit, StorageLimitUnit, TrackInventory) values(  '".addslashes($DisplayName)."', '".addslashes($Email)."', '".md5($Password)."', '".addslashes($CompanyName)."', '".addslashes($Description)."', '".addslashes($ContactPerson)."',  '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."', '".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."', '".addslashes($LandlineNumber)."', '".addslashes($AlternateEmail)."', '".$Status."', '".$JoiningDate."', '".$ExpiryDate."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."',  '".$Password."', '".$ipaddress."', '".date('Y-m-d')."', '".addslashes($Fax)."', '".addslashes($Website)."', '".addslashes($MaxUser)."', '".addslashes($Department)."', '".addslashes($Timezone)."', '".addslashes($DateFormat)."','".addslashes($TimeFormat)."', '".$currency_id."', '".addslashes($PaymentPlan)."', '".addslashes($StorageLimit)."', '".addslashes($StorageLimitUnit)."', '".addslashes($TrackInventory)."')";
			//echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);

			$CmpID = $this->lastInsertId();

			$objConfig=new admin();
			$objConfig->addUserEmail($CmpID,0,$Email);


			$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../".$Config['EmailTemplateFolder']):($Config['EmailTemplateFolder']);

			$_SESSION['mess_account'] = SUCCESSFULLY_REGISTERED;
			$contents = file_get_contents($htmlPrefix."logindetails.htm");
			$subject  = "Account Details";
			
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

			$contents = str_replace("[FULLNAME]",$CompanyName, $contents);
			$contents = str_replace("[CompanyName]",$CompanyName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[FULLNAME]",$DisplayName, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Company - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['Online'] == '5555555'){
				 $mail->Send();	
			}

			//echo $CompanyApproval.$Email.$Config['AdminEmail'].$contents; 



			if($Config['RecieveSignEmail']=='y'){
					//Send Acknowledgment Email to admin
					$contents = file_get_contents($htmlPrefix."admin_signup.htm");

					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

					$contents = str_replace("[FULLNAME]",$CompanyName, $contents);
					$contents = str_replace("[CompanyName]",$CompanyName, $contents);
					$contents = str_replace("[EMAIL]",$Email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[USERNAME]",$DisplayName,$contents);
					$contents = str_replace("[ReferenceNo]",$CmpID,$contents);

					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Config['AdminEmail']);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Company - ".$subject;
					$mail->IsHTML(true);
					//echo $Config['AdminEmail'].$contents; exit;
					$mail->Body = $contents;    
					if($Config['Online'] == '5555555'){
						$mail->Send();	
					}

			}


			return $CmpID;

		}


		function UpdateCompany($arryDetails){   
			extract($arryDetails);

			if(!empty($CmpID)){
			
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';
				if(empty($Status)) $Status=1;


				$strSQLQuery = "update company set DisplayName='".addslashes($DisplayName)."', Email='".addslashes($Email)."',  CompanyName='".addslashes($CompanyName)."', DisplayName='".addslashes($DisplayName)."', ContactPerson='".addslashes($ContactPerson)."', Description='".addslashes($Description)."', 
				Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."', AlternateEmail='".addslashes($AlternateEmail)."', Status='".$Status."'
				,OtherState='".addslashes($OtherState)."',OtherCity='".addslashes($OtherCity)."'			 
				,UpdatedDate = '".date('Y-m-d')."'
				where CmpID='".$CmpID."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}


		function UpdateCompanyProfile($arryDetails){   
			extract($arryDetails);

			if(!empty($CmpID)){

				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';

				 $strSQLQuery = "update company set CompanyName='".addslashes($CompanyName)."', Description='".addslashes($Description)."',  ContactPerson='".addslashes($ContactPerson)."', Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."', AlternateEmail='".addslashes($AlternateEmail)."', OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."' 
				,UpdatedDate = '".date('Y-m-d')."', Fax='".addslashes($Fax)."', Website='".addslashes($Website)."', TrackInventory='".mysql_real_escape_string($TrackInventory)."'	where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$this->query($strSQLQuery, 0);

			}

			return 1;
		}

		function UpdatePermission($arryDetails){   
			extract($arryDetails);
			if(!empty($CmpID)){
				/*if(sizeof($Department)>0){
					$Department = implode(",",$Department);
				}else{
					$Department = '';
				}*/
				$strSQLQuery = "update company set MaxUser='".mysql_real_escape_string($MaxUser)."', 
				StorageLimit='".mysql_real_escape_string($StorageLimit)."', 
				StorageLimitUnit='".mysql_real_escape_string($StorageLimitUnit)."', 
				TrackInventory='".mysql_real_escape_string($TrackInventory)."', 
				Department='".mysql_real_escape_string($Department)."', 
				ErpDomain='".mysql_real_escape_string($ErpDomain)."',
				WebDomain='".mysql_real_escape_string($WebDomain)."'
				where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}

		function UpdateDateTime($arryDetails){   
			extract($arryDetails);
			if(!empty($CmpID)){
				if(!empty($Timezone)) $Timezone = $TimezonePlusMinus.$Timezone;

				$strSQLQuery = "update company set Timezone='".mysql_real_escape_string($Timezone)."', DateFormat='".mysql_real_escape_string($DateFormat)."', TimeFormat='".mysql_real_escape_string($TimeFormat)."', SessionTimeout='".mysql_real_escape_string($SessionTimeout)."'	where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}


		function UpdateLocationDateTime($arryDetails){   
			extract($arryDetails);

			if(empty($locationID)) $locationID=1; // For Primary Location

			if(!empty($locationID) && !empty($Timezone)){				

				if(!empty($Timezone)) $Timezone = $TimezonePlusMinus.$Timezone;

				$strSQLQuery = "update location set Timezone='".addslashes($Timezone)."' where locationID=".$locationID; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}


		function UpdateCurrency($arryDetails){   
			extract($arryDetails);
			if(!empty($CmpID) && !empty($currency_id)){

				$AdditionalCurrencyVal = implode(",",$AdditionalCurrency);
				$strSQLQuery = "update company set currency_id='".mysql_real_escape_string($currency_id)."', AdditionalCurrency='".mysql_real_escape_string($AdditionalCurrencyVal)."'  where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}

		function UpdateGlobalOther($arryDetails){   
			extract($arryDetails);
			if(!empty($CmpID) && !empty($RecordsPerPage)){
				$strSQLQuery = "update company set RecordsPerPage='".$RecordsPerPage."', TrackInventory='".mysql_real_escape_string($TrackInventory)."' where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}


		function UpdateAccount($arryDetails){   
			extract($arryDetails);

			if(!empty($CmpID)){
				$AddSql = '';
				
				$sql = "select CmpID,DisplayName,Email from company where CmpID='".mysql_real_escape_string($CmpID)."'";
				$arryRow = $this->query($sql, 1);
				$OldDisplayName = $arryRow[0]["DisplayName"];
				if(!empty($DisplayName) && $DisplayName != $OldDisplayName){
					//$AddSql .= ", DisplayName='".addslashes($DisplayName)."'" ;
					$Rename = 1;
				}

				#if(empty($Status)) $Status=1;
				if(!empty($Password)) $AddSql .= ", Password='".md5($Password)."'" ;

				if(!is_null($ExpiryDate)) $AddSql .= ", ExpiryDate='".$ExpiryDate."'" ;
				

				$strSQLQuery = "update company set Email='".addslashes($Email)."', Status='".$Status."' ".$AddSql." where CmpID='".$CmpID."'"; 
				$this->query($strSQLQuery, 0);



				$objConfig=new admin();
				$objConfig->UpdateCmpEmail($CmpID,$Email);


				/******************
				if($Rename == 1){
					global $Config;
					$DbName = $Config['DbName']."_".$DisplayName;
					$this->RenameDatabse($DbName);
				}
				/******************/

			}

			return 1;
		}		
		

		function ChangePassword($CmpID,$Password)
		{
			
			if(!empty($CmpID) && !empty($Password)){
				global $Config;				
			
				$strSQLQuery = "update company set Password='".mysql_real_escape_string(md5($Password))."' where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$this->query($strSQLQuery, 0);

				$sql = "select CmpID,DisplayName,Email from company where CmpID='".mysql_real_escape_string($CmpID)."'";
				$arryRow = $this->query($sql, 1);

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."password.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[DisplayName]",$arryRow[0]['DisplayName'],$contents);
				$contents = str_replace("[EMAIL]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Your login details have been reset.";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents;exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}		
		
		function IsActivatedCompany($CmpID,$verification_code)
		{
			$sql = "select * from company where CmpID='".mysql_real_escape_string($CmpID)."' and verification_code='".$verification_code."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['CmpID']>0) {
				if ($arryRow[0]['Status']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}

		

		
		function ForgotPassword($Email,$CmpID){
			
			global $Config;

			if(!empty($Email)){
				$sql = "select * from company where Email='".mysql_real_escape_string($Email)."' and CmpID='".mysql_real_escape_string($CmpID)."' and Status=1"; 
				$arryRow = $this->query($sql, 1);
				$DisplayName = $arryRow[0]['DisplayName'];

				if(sizeof($arryRow)>0)
				{

					$Password = substr(md5(rand(100,10000)),0,8);
					
					$sql_u = "update company set Password='".md5($Password)."'
					where Email='".$Email."'";
					$this->query($sql_u, 0);

					$htmlPrefix = $Config['EmailTemplateFolder'];

					$contents = file_get_contents($htmlPrefix."forgot.htm");
					
					$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
					$contents = str_replace("[COMPNAY_URL]",$CompanyUrl,$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[DisplayName]",$arryRow[0]['DisplayName'],$contents);
					$contents = str_replace("[EMAIL]",$Email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
							
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Email);
					$mail->AddBCC('parwez.khan@sakshay.in');
					$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Administrator - New Password";
					$mail->IsHTML(true);
					$mail->Body = $contents;  

					//echo $Email.$Config['AdminEmail'].$contents; exit;

					if($Config['Online'] == '1'){
						$mail->Send();	
					}
					return 1;
				}else{
					return 0;
				}
			}

		}				
		
		function RemoveCompany($CmpID)
		{
			if(!empty($CmpID)){
				$strSQLQuery = "select Email,Image,DisplayName from company where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

				if($Front > 0){
					$ImgDirPrefix = '';
				}else{
					$ImgDirPrefix = '../';
				}

				$ImgDir = $ImgDirPrefix.'upload/company/';

			
				if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							
					unlink($ImgDir.$arryRow[0]['Image']);	
				}	
				
				$strSQLQuery = "delete from company where CmpID='".mysql_real_escape_string($CmpID)."'"; 
				$this->query($strSQLQuery, 0);			

				$objConfig=new admin();
				$objConfig->RemoveUserEmail($arryRow[0]['Email']);


				global $Config;
				$DbName = $Config['DbName']."_".$arryRow[0]["DisplayName"];
				$this->RemoveDatabse($DbName);
			}

			return 1;

		}

		function UpdateImage($Image,$CmpID)
		{
			if(!empty($Image) && !empty($CmpID)){
				$strSQLQuery = "update company set Image='".mysql_real_escape_string($Image)."' where CmpID='".mysql_real_escape_string($CmpID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}

		
		function changeCompanyStatus($CmpID)
		{
			if(!empty($CmpID)){
				$sql="select CmpID,Status from company where CmpID='".mysql_real_escape_string($CmpID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update company set Status='$Status' where CmpID='".mysql_real_escape_string($CmpID)."'";
					$this->query($sql,0);					
				}	
			}

			return true;

		}
		

		function ActivateCompany($arryDet)
		{
			global $Config;
			extract($arryDet);
			if(!empty($Email)){
				$sql="select CmpID,Status,DisplayName from company where Email='".$Email."'";
				$arryCmp = $this->query($sql);
				if(sizeof($arryCmp))
				{
					$Status=1;						
					$sql2="update company set Status='".$Status."',Password='".md5($Password)."' where CmpID='".$arryCmp[0]['CmpID']."'";
					$this->query($sql2,0);	

					/************************/
					//mail to user
		
				$htmlPrefix = 'superadmin/'.$Config['EmailTemplateFolder'];

				//$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$CompanyUrl = $Config['Url'].'crm/';	
				$contents = file_get_contents($htmlPrefix."logindetails.htm");
				
				$contents = str_replace("[URL]",$CompanyUrl,$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$contents = str_replace("[DisplayName]",$arryCmp[0]['DisplayName'], $contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FULLNAME]",$DisplayName, $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Email);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']. " :: Account Activated";
				$mail->IsHTML(true);
				$mail->Body = $contents;   
				if($Config['Online'] == '1'){
					 $mail->Send();	
				}

				//echo $Email.$Config['AdminEmail'].$contents; 


					/************************/

				
				}	
			}

			return true;

		}

		function UpgradeCompany($arryDet)
		{
			extract($arryDet);
			if(!empty($Email)){
				$sql="select CmpID,PaymentPlan from company where Email='".$Email."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					$Status=1;
					if($PaymentPlan != $rs[0]['PaymentPlan']){
						$addSql = ",PaymentPlan='".mysql_real_escape_string($PaymentPlan)."'";
					}
						
					$sql="update company set Status='".$Status."',ExpiryDate='".$ExpiryDate."',MaxUser='".$MaxUser."', StorageLimit='".mysql_real_escape_string($StorageLimit)."', StorageLimitUnit='".mysql_real_escape_string($StorageLimitUnit)."' ".$addSql." where CmpID='".$rs[0]['CmpID']."'";
					
					$this->query($sql,0);					
				}	
			}

			return $rs[0]['CmpID'];

		}



		function MultipleCompanyStatus($CmpIDs,$Status)
		{
			$sql="select CmpID from company where CmpID in (".$CmpIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update company set Status=".$Status." where CmpID in (".$CmpIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function ValidateCompany($Email,$Password,$CmpID){
			if(!empty($Email) && !empty($Password)){
				$strSQLQuery = "select * from company where MD5(Email)='".md5($Email)."' and Password='".md5($Password)."' and CmpID='".$CmpID."' and Status=1"; 
				return $this->query($strSQLQuery, 1);
			}
		}

		function isEmailExists($Email,$CmpID=0)
		{
			$strSQLQuery = (!empty($CmpID))?(" and CmpID != '".mysql_real_escape_string($CmpID)."'"):("");
			$strSQLQuery = "select CmpID from company where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['CmpID'])) {
				return true;
			} else {
				return false;
			}
		}
	
		function isDisplayNameExists($DisplayName,$CmpID=0)
		{
			$strSQLQuery = (!empty($CmpID))?(" and CmpID != '".mysql_real_escape_string($CmpID)."'"):("");
			$strSQLQuery = "select CmpID from company where LCASE(DisplayName)='".strtolower(trim($DisplayName))."'".$strSQLQuery;
			//echo $strSQLQuery;exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['CmpID'])) {
				return true;
			} else {
				return false;
			}
		}
		
		function UpdatePasswordEncrypted($CmpID,$Password)
		{
			if(!empty($CmpID) && !empty($Password)){
				$sql = "update company set Password='".md5($Password)."', PasswordUpdated='1'  where CmpID = '".mysql_real_escape_string($CmpID)."'";
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function UpdateAdminModules($CmpID,$Department)
		{
			
			if(empty($Department)){
				$C_EmpStatus=0;
				$I_EmpStatus=0;
				$ItemStatus=0;
				$CustStatus=0;
				$C_SpiffStatus=0;
			}else{
				 if(substr_count($Department,1)==0){ // Employee
					$C_EmpStatus=1;	 $I_EmpStatus=1;				
					if(substr_count($Department,5)==1 && substr_count($Department,6)==1){						$I_EmpStatus=0;	 $C_SpiffStatus=1;
					}
					

				 }
				 if(substr_count($Department,6)==0){  // Item
					$ItemStatus=1; $CustStatus=1;
				 }
			}

			#echo $C_EmpStatus.':'.$I_EmpStatus.':'.$ItemStatus.':'.$CustStatus;
			//echo $C_SpiffStatus; exit;
			
			if(!empty($CmpID)){
				$sql = "update admin_modules set Status='".$C_EmpStatus."' where ModuleID in('2001') ";
				$this->query($sql,0);

				$sql1 = "update admin_modules set Status='".$I_EmpStatus."' where ModuleID in('2005','2009','2012') ";
				$this->query($sql1,0);


				$sql2 = "update admin_modules set Status='".$ItemStatus."' where ModuleID in('2003') ";
				$this->query($sql2,0);

				/*$sql3 = "update admin_modules set Status='".$CustStatus."' where ModuleID in('2015') ";
				$this->query($sql3,0);*/


				$sql4 = "update admin_modules set Status='".$C_SpiffStatus."' where ModuleID in('2008','2011') ";
				$this->query($sql4,0);


			}
				
			return true;

		}





		function UpdateAdminSubModules($CmpID,$Department,$PaymentPlan)
		{			
			//$PaymentPlan = 'enterprise';

			if(!empty($CmpID) && $Department==5 && !empty($PaymentPlan)){		
			
			$sql = "update admin_modules set Status='0' where depID = '".$Department."'";
			$this->query($sql,0);

			/**********************/
			$sql2 = "update admin_modules set Status='0'  where ModuleID in('130', '143', '147','2008','2011') "; //Setting Sub Module: 115
			$this->query($sql2,0);


			switch($PaymentPlan){
			case 'standard':
				//Lead, Opportunity, Document, User, Settings
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
				/**********************/
				$sql2 = "update admin_modules set Status='1'  where ModuleID in('130', '143', '147') "; //Setting Sub Module: 115
				$this->query($sql2,0);

				break;				
			}

			}
				
			
			return true;

		}






	function UpdateInventoryModules($CmpID,$TrackInventory)
		{
			
			if(empty($TrackInventory)){
				$MenuStatus=0;				
			}else{
				$MenuStatus=1;		
			}			
			if(!empty($CmpID)){
				$sql = "update admin_modules set Status='".$MenuStatus."' where ModuleID in('602', '603','604', '605', '643','644', '654','636',' 637','639', '642','648', '649', '650', '651', '652','653') ";
				$this->query($sql,0);	

				/***********************/

				$sql2 = "update dashboard_icon set Status='".$MenuStatus."' where IconID in('605','612') ";
				$this->query($sql2,0);

	

			}				
			return true;

		}








		/*****************************/
		function AddDatabse($DisplayName)
		{
			if(!empty($DisplayName)){
				global $Config;
				$DbName = $Config['DbName']."_".$DisplayName;
				$sql = 'CREATE Database IF NOT EXISTS '.$DbName;
				mysql_query($sql) or die (mysql_error());
				return $DbName;
			}
		}

		function RemoveDatabse($DbName)
		{
			if(!empty($DbName)){
				$sql = 'DROP Database IF EXISTS '.$DbName; 
				mysql_query($sql) or die (mysql_error());

			}
			return true;
		}

		function RenameDatabse($DbName)
		{	
			if(!empty($DbName)){
				$sql = 'RENAME Database '.$DbName; // Not Working
				mysql_query($sql) or die (mysql_error());
			}
			return true;
		}

		function ImportDatabase55555($DbName)
		{
			if(!empty($DbName)){
				global $Config;
	
				$Command = 'mysql -u root '.$DbName.' < "E:\agrinde_erp.sql" '; 

				exec($Command);
			}

			return true;
		}

		/*********** License Key Start **********/
		function UpdateCompanyLicense($CmpID,$LicenseKey)
		{
			if(!empty($LicenseKey) && !empty($CmpID)){
				$strSQLQuery = "update company set LicenseKey='".mysql_real_escape_string($LicenseKey)."' where CmpID='".mysql_real_escape_string($CmpID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}


		function isLicenseKey($DomainName,$ValidateLicense,$LicenseKey)
		{
			$strSQLQuery = "select LicenseID,MaxUser from z_iocube_license_key where LCASE(DomainName)='".strtolower(trim($DomainName))."' and Status=1 and ExpiryDate>='".date('Y-m-d')."'";

			if($ValidateLicense==1){ //validate key
				if(!empty($LicenseKey)){
					$strSQLQuery .= " and LicenseKey='".$LicenseKey."'";
					$arryRow = $this->query($strSQLQuery, 1);			
					if(!empty($arryRow[0]['LicenseID'])) {
						$returnValue = '2#'.$arryRow[0]['MaxUser'];
						return $returnValue; //true
					} else {
						return 3;
					}
				
				}else{
					return 3;
				}
			}else{ //check exist
				
				$arryRow = $this->query($strSQLQuery, 1);			
				if(!empty($arryRow[0]['LicenseID'])) {
					return 1; //true
				} else {
					return 0;
				}


			}
		
			
			
		}
		

		/*********** License Key End **********/

		function defaultCompanyUpdate($CmpID,$DefaultCompany)
		{
			if(!empty($CmpID)){
				$sql="update company set DefaultCompany='".$DefaultCompany."' where CmpID='".mysql_real_escape_string($CmpID)."'";
				$this->query($sql,0);
				if($DefaultCompany==1){                
				     $sql="update company set DefaultCompany='0' where CmpID!='".mysql_real_escape_string($CmpID)."'";
				     $this->query($sql,0);                    
				}
			}
		}

		function UpdateIpDetail($arryDetails,$CmpID)
		{
			global $Config;
			extract($arryDetails);		
			if($CmpID>0){
				/********** For Punching IP *************/
				if(!empty($PunchingIP)){			
					$NewArrayPunnching =  explode(',',$PunchingIP);				
					foreach ($NewArrayPunnching as $value){
						$PunchingIPval .= trim($value).',';
					}
					$PunchingIPval = rtrim($PunchingIPval, ',');
				}			
				/********** For Login IP *************/		
				if(!empty($LoginIP)){		
					$NewArrayLogin = explode(',', $LoginIP);			
					foreach ($NewArrayLogin as $value1){
						$LoginIPval .= trim($value1).',';
					}
					$LoginIPval = rtrim($LoginIPval, ',');
				}						
			
				$strSQLQuery = "UPDATE company SET PunchingBlock = '".mysql_real_escape_string($PunchingBlock)."', PunchingIP = '".mysql_real_escape_string($PunchingIPval)."', LoginBlock = '".mysql_real_escape_string($LoginBlock)."', LoginIP = '".mysql_real_escape_string($LoginIPval)."' WHERE CmpID='".mysql_real_escape_string($CmpID)."' "; 
				$this->query($strSQLQuery, 0);

			}

			return 1;				
				
		}
		
		
		function  getComanySlider()
		{
			
				$strSQLQuery = "select * from e_slider_banner  where Status=1 order by Priority ASC  ";
				return $this->query($strSQLQuery, 1);
			
		}	
		



}
?>
