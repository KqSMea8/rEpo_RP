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

			$strSQLQuery = "select c.CmpID,c.Status,c.DisplayName,c.CompanyName,c.Email,c.Image,c.ExpiryDate,c.PaymentPlan,c.DefaultCompany,c.DefaultInventoryCompany from company c ".$userSql.$strAddQuery;


			return $this->query($strSQLQuery, 1);

	}


	function  CompanyListing($arryDetails)
	{
		extract($arryDetails);

		$strAddQuery = 'where 1';
		$SearchKey   = strtolower(trim($key));
		$strAddQuery .= (!empty($id))?(" and c.CmpID='".mysql_real_escape_string($id)."'"):("");
		$strAddQuery .= (!empty($RsID))?(" and c.RsID='".mysql_real_escape_string($RsID)."'"):("");
		if($SearchKey=='active' && ($sortby=='c.Status' || $sortby=='') ){
			$strAddQuery .= " and c.Status=1";
		}else if($SearchKey=='inactive' && ($sortby=='c.Status' || $sortby=='') ){
			$strAddQuery .= " and c.Status=0";
		}else if($sortby != ''){

			if($sortby=='c.Status')	$asc = ($asc=="Asc")?("Desc"):("Asc");

			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (c.CompanyName like '%".$SearchKey."%' or c.DisplayName like '%".$SearchKey."%' or c.Email like '%".$SearchKey."%' or c.CmpID like '%".$SearchKey."%' or c.PaymentPlan like '%".$SearchKey."%'  ) " ):("");			}


			if($_SESSION['AdminType']=="user"){
				$userSql =  " left outer join permission_cmp p on (c.CmpID=p.CmpID and p.UserID='".$_SESSION['AdminID']."') ";		$strAddQuery .= " and p.CmpID IS NULL";



				#$strAddQuery .=  " and c.CmpID not in (select p.CmpID from permission_cmp p where p.UserID='".$_SESSION['AdminID']."') ";
			}


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by c.CompanyName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

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

	function  GetDefaultCompany()
	{
		$strSQLQuery = "select * from company where  DefaultCompany=1";

		return $this->query($strSQLQuery, 1);
	}


	function  GetCompanyBrief($CmpID)
	{
		$strAddQuery .= (!empty($CmpID))?(" and c.CmpID='".mysql_real_escape_string($CmpID)."'"):("");
		$strSQLQuery = "select c.CmpID, c.CompanyName, c.DisplayName, c.Email, c.Image, c.Timezone, c.DateFormat, c.TimeFormat, c.SessionTimeout, c.Department, c.currency_id, c.MaxUser,c.RecordsPerPage, c.StorageLimit , c.StorageLimitUnit,c.Storage,c.TrackInventory,c.ExpiryDate,c.AdditionalCurrency,c.PunchingBlock,c.PunchingIP,c.PaymentPlan,c.sync_type,c.sync_type,c.DefaultInventoryCompany,c.SelectOneItem,c.spiffDis,c.ecomType from company c where c.Status=1 ".$strAddQuery." order by c.CmpID asc";
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

		$strSQLQuery = "insert into company ( DisplayName,Email,Password,CompanyName,Description, ContactPerson ,Address, city_id, state_id,
		ZipCode, country_id,Mobile, LandlineNumber, AlternateEmail,  Status, JoiningDate, ExpiryDate, OtherState, OtherCity,
		TempPass,ipaddress, UpdatedDate, Fax, Website, MaxUser, Department, Timezone, DateFormat, TimeFormat, currency_id, PaymentPlan, 
		StorageLimit, StorageLimitUnit, TrackInventory, RsID,MultiSite) values(  '".addslashes($DisplayName)."', '".addslashes($Email)."', 
		'".md5($Password)."', '".addslashes($CompanyName)."', '".addslashes($Description)."', '".addslashes($ContactPerson)."',  
		'".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."', '".addslashes($ZipCode)."', '".$country_id."',
		 '".addslashes($Mobile)."', '".addslashes($LandlineNumber)."', '".addslashes($AlternateEmail)."', '".$Status."', '".$JoiningDate."', 
		 '".$ExpiryDate."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."',  '".$Password."', '".$ipaddress."', 
		 '".date('Y-m-d')."', '".addslashes($Fax)."', '".addslashes($Website)."', '".addslashes($MaxUser)."', '".addslashes($Department)."', 
		 '".addslashes($Timezone)."', '".addslashes($DateFormat)."','".addslashes($TimeFormat)."', '".$currency_id."', 
		 '".addslashes($PaymentPlan)."', '".addslashes($StorageLimit)."', '".addslashes($StorageLimitUnit)."', '".addslashes($TrackInventory)."', 
		 '".addslashes($RsID)."','".addslashes($MultiSite)."')";
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
				,UpdatedDate = '".date('Y-m-d')."', Fax='".addslashes($Fax)."', Website='".addslashes($Website)."', MultiSite='".addslashes($MultiSite)."',TrackInventory='".mysql_real_escape_string($TrackInventory)."', sync_items='".mysql_real_escape_string($sync_items)."', sync_type='".mysql_real_escape_string($sync_type)."'	where CmpID='".mysql_real_escape_string($CmpID)."'"; 
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


			$strSQLQuery = "update company set Email='".addslashes($Email)."', Status='".$Status."', AutomaticSync='".$AutomaticSync."' ".$AddSql." where CmpID='".$CmpID."'";
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
			$sql2 = "update admin_modules set Status='0'  where ModuleID in('130', '143', '147','2008','2011','1051') "; //Setting Sub Module: 115
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

	/*******************Function Sync Items***************************************/

	function checkItemSyncSetting(){
		global $Config;
		$CmpID=$_SESSION['CmpID'];
		// get company setting first
		$objConfig=new admin();

		/********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		$sql = "select sync_items from company where CmpID='".addslashes($CmpID)."' and sync_items!=''";
		$arryRow = $this->query($sql, 1);
			
		$sync_items=$arryRow[0]['sync_items'];
			
		/********Connecting to Cmp database*********/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		return $sync_items;
			
	}

	// Inventory to E-Commerce
	// E-Commerce to Inventory
	// both

	function sync_items($ItemsArray){

		if($ItemsArray['ItemID']){

			if($ItemsArray['synctypeselected']=='all'){
				$strSQLQuery = "select ItemID from inv_items order by ItemID asc";
				$res=$this->query($strSQLQuery, 1);
				foreach($res as $items){
					$SyncItemsArray['ItemID'][]=$items['ItemID'];
				}
			}else{
				foreach($ItemsArray['ItemID'] as $items){
					$SyncItemsArray['ItemID'][]=$items;
				}
			}

		}

		if($ItemsArray['ProductID']){
			if($ItemsArray['synctypeselected']=='all'){
				$strSQLQuery = "select ProductID from e_products order by ProductID asc ";
				$res=$this->query($strSQLQuery, 1);
				foreach($res as $items){
					$SyncItemsArray['ItemID'][]=$items['ProductID'];
				}
			}else{
				foreach($ItemsArray['ProductID'] as $items){
					$SyncItemsArray['ItemID'][]=$items;
				}
			}

		}



		$sync_items=$this->checkItemSyncSetting();

		switch ($sync_items) {
			case I2E:
				// code for Inventory to e-commerce

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Item.* from inv_items as Item
					left join inv_item_images ItemImages on ItemImages.ItemID=Item.ItemID
					where Item.ItemID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					$this->syncFromInventory($ItemsArray);



				}
				/*********end **********/

				break;
			case E2I:
				// code for e-commerce  to Inventory

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Products.* from e_products as Products
					left join e_products_images ProductsImages on ProductsImages.ProductID=Products.ProductID
					where Products.ProductID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					$this->syncFromEcommerce($ItemsArray);



				}
				/*********end **********/

				break;
			case both:
				// code for both
				// code for Inventory to e-commerce

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Item.* from inv_items as Item
					left join inv_item_images ItemImages on ItemImages.ItemID=Item.ItemID
					where Item.ItemID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					if($ItemsArray){
						$this->syncFromInventory($ItemsArray);
					}



				}
				/*********end **********/

				// code for e-commerce  to Inventory

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Products.* from e_products as Products
					left join e_products_images ProductsImages on ProductsImages.ProductID=Products.ProductID
					where Products.ProductID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					if($ItemsArray){
						$this->syncFromEcommerce($ItemsArray);
					}



				}
				/*********end **********/

				break;

		}
			
	}

	function checkSkuExist($Sku,$table,$field,$selectedFieldId){
		$sql = "select count(*) as total,".$selectedFieldId." from ".$table." where  ".$field."= '".addslashes($Sku)."' ";
		$ItemsAvail = $this->query($sql, 1);
		if($ItemsAvail[0]['total']==0){
			return '0';
		}
		return $ItemsAvail[0][$selectedFieldId];
			
	}

	function syncFromInventory($ItemsArray){

		$ItemID=$ItemsArray[0]['ItemID'];
		$Sku=$ItemsArray[0]['Sku'];
		$CategoryID=$ItemsArray[0]['CategoryID'];
		$description=$ItemsArray[0]['description'];
		$long_description=$ItemsArray[0]['long_description'];
		$Manufacture=$ItemsArray[0]['Manufacture'];
		$sell_price=$ItemsArray[0]['sell_price'];
		$Taxable=$ItemsArray[0]['Taxable'];
		$sale_tax_rate=$ItemsArray[0]['sale_tax_rate'];
		$weight=$ItemsArray[0]['weight'];
		$Image=$ItemsArray[0]['Image'];
		$Quantity=$ItemsArray[0]['qty_on_hand'];
		$VariantId=$ItemsArray[0]['variant_id'];
		$IsUpld=$ItemsArray[0]['is_upld'];
		$LabelTxt=$ItemsArray[0]['label_txt'];
		$product_type=$ItemsArray[0]['product_type'];
		$secure_type=$ItemsArray[0]['secure_type'];
		$virtual_file=$ItemsArray[0]['virtual_file'];

		$AddedDate=date('Y-m-d');


		$is_exist=$this->checkSkuExist($Sku,'e_products','ProductSku','ProductID');


		// get manufacturer id by name beacuse inventory has varchar field type
		if($Manufacture!=''){
			$sql = "select * from e_manufacturers where  Mname= '".addslashes($Manufacture)."' limit 1 ";
			$ManufactureRes = $this->query($sql, 1);
			if($ManufactureRes){
				// if manufacturer available
				$Mid=$ManufactureRes[0]['Mid'];
			}else{
				// create new manufacturer
				$sql="insert into e_manufacturers set Mname='".addslashes($Manufacture)."', Status='1' ";
				$this->query($sql,0);
				$Mid=$this->lastInsertId();
				$sql="update e_manufacturers set Mcode='".addslashes($Mid)."' where Mid='".addslashes($Mid)."' ";
				$this->query($sql,0);
			}
		}
			


		/*******************
		 * Check category sync
		 *
		 */
		if($CategoryID!='0'){
			$sql = "select CategoryID from e_categories where item_categoryId= '".addslashes($CategoryID)."' limit 1 ";
			$CategoryRes = $this->query($sql, 1);

			if($CategoryRes){
				// if category already sync
				$CategoryID=$CategoryRes[0]['CategoryID'];
			}else{
				// get parent category id
				if($this->checkCategoryExist($CategoryID,'inv_categories')){
					$MainCategoryId=$this->getParentCategoryId($CategoryID,'inv_categories');

					$catArray['Category']=json_encode(array($MainCategoryId));

					$this->syncCategorytoEcommerce($catArray);

					$sql = "select CategoryID from e_categories where item_categoryId= '".addslashes($CategoryID)."' limit 1 ";
					$CategoryRes = $this->query($sql, 1);
					$CategoryID=$CategoryRes[0]['CategoryID'];
				}else{
					$CategoryID=0;
				}
			}

			// end
		}

		if($is_exist=='0'){

			/***********insert new item************/

			if($virtual_file!=''){
					
				$fromfilepath="../../upload/items/document/".$_SESSION['CmpID']."/".$virtual_file;
				$tofilepath="../../upload/products/document/".$_SESSION['CmpID']."/".$virtual_file;
				$directory="../../upload/products/document/".$_SESSION['CmpID'];

				if (!is_dir($directory)) {

					mkdir($directory, 0777, true);
				}


				if (file_exists($fromfilepath)) {

					copy($fromfilepath, $tofilepath);

				}
			}


			$sql="insert into e_products set Name='".addslashes($description)."' , ProductSku='".addslashes($Sku)."' ,
				Detail='".addslashes($long_description)."' ,ShortDetail='".addslashes($description)."' ,
				Price='".addslashes($sell_price)."' ,InventoryControl='Yes' ,
				IsTaxable='".addslashes($Taxable)."' ,TaxRate='".addslashes($sale_tax_rate)."' ,
				Weight='".addslashes($weight)."' , Image='".addslashes($Image)."' ,
				AddedDate='".addslashes($AddedDate)."'  ,Quantity='".addslashes($Quantity)."' ,
				Status='1',variant_id='".addslashes($VariantId)."' , CategoryID= '".addslashes($CategoryID)."', 
				Mid= '".addslashes($Mid)."',is_upld= '".addslashes($IsUpld)."',label_txt= '".addslashes($LabelTxt)."', product_type= '".addslashes($product_type)."'
				, secure_type= '".addslashes($secure_type)."', virtual_file= '".addslashes($virtual_file)."'				";
			$this->query($sql,0);
			$lastInsertItemId=$this->lastInsertId();


			/***************add multiple image**************/
			$sql = "select * from inv_item_images where  ItemID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];

				$sql="insert into e_products_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ProductID ='".addslashes($lastInsertItemId)."'";
				$this->query($sql,0);
			}

			// end





		}
		else {

			if($virtual_file!=''){
					
				$fromfilepath="../../upload/items/document/".$_SESSION['CmpID']."/".$virtual_file;
				$tofilepath="../../upload/products/document/".$_SESSION['CmpID']."/".$virtual_file;
				$directory="../../upload/products/document/".$_SESSION['CmpID'];

				if (!is_dir($directory)) {

					mkdir($directory, 0777, true);
				}


				if (file_exists($fromfilepath)) {

					copy($fromfilepath, $tofilepath);

				}
			}

			// update old item
			$lastInsertItemId=$is_exist;
			$sql="update e_products set Name='".addslashes($description)."' ,
				Detail='".addslashes($long_description)."' ,ShortDetail='".addslashes($description)."' ,
				Price='".addslashes($sell_price)."' ,InventoryControl='Yes' ,
				IsTaxable='".addslashes($Taxable)."' ,TaxRate='".addslashes($sale_tax_rate)."' ,
				Weight='".addslashes($weight)."' , Image='".addslashes($Image)."' ,
				AddedDate='".addslashes($AddedDate)."'  ,Status='1' , variant_id='".addslashes($VariantId)."' ,
				CategoryID= '".addslashes($CategoryID)."',Mid= '".addslashes($Mid)."',
				is_upld= '".addslashes($IsUpld)."',label_txt= '".addslashes($LabelTxt)."', product_type= '".addslashes($product_type)."'
				, secure_type= '".addslashes($secure_type)."', virtual_file= '".addslashes($virtual_file)."'
				where ProductSku='".addslashes($Sku)."' ";
			$this->query($sql,0);

			/***************add multiple image**************/
			$sql = "select * from inv_item_images where  ItemID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];
				$sql = "select count(*) as total from e_products_images where  ProductID= '".addslashes($lastInsertItemId)."'
				and Image= '".addslashes($Image)."'  ";
				$ExistImageArray = $this->query($sql, 1);
				if($ExistImageArray[0]['total']=='0'){
					$sql="insert into e_products_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ProductID ='".addslashes($lastInsertItemId)."'";
					$this->query($sql,0);
				}

			}

			// end


		}

	}
	function syncFromEcommerce($ItemsArray){

		$ItemID=$ItemsArray[0]['ProductID'];
		$Sku=$ItemsArray[0]['ProductSku'];
		$CategoryID=$ItemsArray[0]['CategoryID'];
		$description=$ItemsArray[0]['Name'];
		$long_description=$ItemsArray[0]['Detail'];
		$Mid=$ItemsArray[0]['Mid'];
		$sell_price=$ItemsArray[0]['Price'];
		$Taxable=$ItemsArray[0]['IsTaxable'];
		$sale_tax_rate=$ItemsArray[0]['TaxRate'];
		$weight=$ItemsArray[0]['Weight'];
		$Image=$ItemsArray[0]['Image'];
		$Quantity=$ItemsArray[0]['Quantity'];
		$VariantId=$ItemsArray[0]['variant_id'];
		$AddedDate=date('Y-m-d');
		$IsUpld=$ItemsArray[0]['is_upld'];
		$LabelTxt=$ItemsArray[0]['label_txt'];
		$product_type=$ItemsArray[0]['product_type'];
		$secure_type=$ItemsArray[0]['secure_type'];
		$virtual_file=$ItemsArray[0]['virtual_file'];

		$is_exist=$this->checkSkuExist($Sku,'inv_items','Sku','ItemID');

		// get manufacturer id by id beacuse product has int field type

		$sql = "select * from e_manufacturers where  Mid= '".addslashes($Mid)."' limit 1 ";
		$ManufactureRes = $this->query($sql, 1);
		$Manufacture=$ManufactureRes[0]['Mname'];


		/*******************
		 * Check category sync
		 *
		 */
		if($CategoryID!='0'){
			$sql = "select CategoryID from inv_categories where e_categoryId= '".addslashes($CategoryID)."' limit 1 ";
			$CategoryRes = $this->query($sql, 1);

			if($CategoryRes){
				// if category already sync
				$CategoryID=$CategoryRes[0]['CategoryID'];
			}else{
				// get parent category id
				if($this->checkCategoryExist($CategoryID,'e_categories')){
					$MainCategoryId=$this->getParentCategoryId($CategoryID,'e_categories');

					$catArray['Category']=json_encode(array($MainCategoryId));

					$this->syncCategorytoInventory($catArray);
					$sql = "select CategoryID from inv_categories where e_categoryId= '".addslashes($CategoryID)."' limit 1 ";
					$CategoryRes = $this->query($sql, 1);
					$CategoryID=$CategoryRes[0]['CategoryID'];
				}else{
					$CategoryID=0;
				}
			}

			// end

		}

		if($is_exist=='0'){

			/***********insert new item************/
			if($virtual_file!=''){
					
				$fromfilepath="../../upload/products/document/".$_SESSION['CmpID']."/".$virtual_file;
				$tofilepath="../../upload/items/document/".$_SESSION['CmpID']."/".$virtual_file;
				$directory="../../upload/items/document/".$_SESSION['CmpID'];

				if (!is_dir($directory)) {

					mkdir($directory, 0777, true);
				}


				if (file_exists($fromfilepath)) {

					copy($fromfilepath, $tofilepath);

				}
			}
			$sql="insert into inv_items set description='".addslashes($description)."' ,
				Sku='".addslashes($Sku)."' ,long_description='".addslashes($long_description)."' ,
				sell_price='".addslashes($sell_price)."' ,Taxable='".addslashes($Taxable)."' ,
				sale_tax_rate='".addslashes($sale_tax_rate)."' ,weight='".addslashes($weight)."' , 
				Image='".addslashes($Image)."' , Manufacture='".addslashes($Manufacture)."' ,
				AddedDate='".addslashes($AddedDate)."' ,qty_on_hand='".addslashes($Quantity)."' ,
				Status='1' ,variant_id='".addslashes($VariantId)."' ,
				CategoryID= '".addslashes($CategoryID)."',is_upld= '".addslashes($IsUpld)."',
				label_txt= '".addslashes($LabelTxt)."', product_type= '".addslashes($product_type)."'
				, secure_type= '".addslashes($secure_type)."', virtual_file= '".addslashes($virtual_file)."'";
			$this->query($sql,0);
			$lastInsertItemId=$this->lastInsertId();

			/***************add multiple image**************/
			$sql = "select * from e_products_images where  ProductID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];

				$sql="insert into inv_item_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ItemID ='".addslashes($lastInsertItemId)."'";
				$this->query($sql,0);
			}

			// end


		}
		else {

			// update old item
			$lastInsertItemId=$is_exist;

			if($virtual_file!=''){
					
				$fromfilepath="../../upload/products/document/".$_SESSION['CmpID']."/".$virtual_file;
				$tofilepath="../../upload/items/document/".$_SESSION['CmpID']."/".$virtual_file;
				$directory="../../upload/items/document/".$_SESSION['CmpID'];

				if (!is_dir($directory)) {

					mkdir($directory, 0777, true);
				}


				if (file_exists($fromfilepath)) {

					copy($fromfilepath, $tofilepath);

				}
			}

			$sql="update inv_items set description='".addslashes($description)."' ,
						long_description='".addslashes($long_description)."' ,
						sell_price='".addslashes($sell_price)."' ,Taxable='".addslashes($Taxable)."' ,
						sale_tax_rate='".addslashes($sale_tax_rate)."' ,weight='".addslashes($weight)."' , 
						Image='".addslashes($Image)."' , Manufacture='".addslashes($Manufacture)."' ,
						AddedDate='".addslashes($AddedDate)."' ,Status='1' ,variant_id='".addslashes($VariantId)."' ,
						CategoryID= '".addslashes($CategoryID)."',is_upld= '".addslashes($IsUpld)."',label_txt= '".addslashes($LabelTxt)."',
						product_type= '".addslashes($product_type)."'	, secure_type= '".addslashes($secure_type)."', 
						virtual_file= '".addslashes($virtual_file)."' where Sku='".addslashes($Sku)."' ";
			$this->query($sql,0);


			/***************add multiple image**************/
			$sql = "select * from e_products_images where  ProductID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];
				$sql = "select count(*) as total from inv_item_images where  ItemID= '".addslashes($lastInsertItemId)."'
				and Image= '".addslashes($Image)."'  ";
				$ExistImageArray = $this->query($sql, 1);
				if($ExistImageArray[0]['total']=='0'){
					$sql="insert into inv_item_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ItemID ='".addslashes($lastInsertItemId)."'";
					$this->query($sql,0);
				}

			}

			// end


		}

	}



	function syncCategorytoEcommerce($get) {
		$catIds = json_decode(stripslashes($get['Category']));

		if(count($catIds))
		{
			$this->insertData = array();
			$this->updateData = array();
			foreach ($catIds as $id)
			{
				$strSQLQuery5 = "select count(*) count from e_categories where item_categoryId =".$id."";
				$res = $this->query($strSQLQuery5, 1);
				if($res[0]['count'] == 1){
					array_push($this->updateData, (array('CategoryID' => $id, 'ParentID' => 0)));
					$this->getAllDataFromInventory($id,2);
				}else{

					array_push($this->insertData, (array('CategoryID' => $id, 'ParentID' => 0)));

					$this->getAllDataFromInventory($id,1);
				}
			}


			for ($i = 0; $i < sizeOf($this->insertData); $i++) {

				$strSQLQuery = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->insertData[$i]['CategoryID'] . "";
				$this->query($strSQLQuery, 1);
				for ($j = 0; $j < sizeOf($this->insertData); $j++) {
					$this->insertData[$j]['ParentID'] = ($this->insertData[$j]['ParentID'] == $this->insertData[$i]['CategoryID']) ? $this->lastInsertId() : $this->insertData[$j]['ParentID'];
				}
			}



			for ($k = 0; $k < sizeOf($this->updateData); $k++)
			{
				if($this->updateData[$k]['ParentID'] == 0)
				{

					$this->updateSynCatDatatoEcommerce($this->updateData[$k]['CategoryID']);

				}else{

					$SQLQuery5 = "select count(*) count from e_categories where item_categoryId =".$this->updateData[$k]['CategoryID']."";
					$res5 = $this->query($SQLQuery5, 1);

					if($res5[0]['count'] == 1)
					{

						$this->updateSynCatDatatoEcommerce($this->updateData[$k]['CategoryID']);

					}else{

						$strSqlQuery3 = "select CategoryID from e_categories where item_categoryId =".$this->updateData[$k]['ParentID']."";
						$resPCatID = $this->query($strSqlQuery3, 1);

						$strSqlQuery4 = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->updateData[$k]['CategoryID'] . "";
						$this->query($strSqlQuery4, 1);

					}


				}

			}

		}
	}


	function syncCategorytoInventory($get) {
		$catIds = json_decode(stripslashes($get['Category']));
		if(count($catIds))
		{
			$this->insertData = array();
			$this->updateData = array();
			foreach ($catIds as $id)
			{
				$strSQLQuery5 = "select count(*) count from inv_categories where e_categoryId =".$id."";
				$res = $this->query($strSQLQuery5, 1);
				if($res[0]['count'] == 1){
					array_push($this->updateData, (array('CategoryID' => $id, 'ParentID' => 0)));
					$this->getAllDataFromEcommerce($id,2);
				}else{
					array_push($this->insertData, (array('CategoryID' => $id, 'ParentID' => 0)));
					$this->getAllDataFromEcommerce($id,1);
				}
			}


			for ($i = 0; $i < sizeOf($this->insertData); $i++) {
				$added = date("Y-m-d");
				$strSQLQuery = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from e_categories WHERE CategoryID = " . $this->insertData[$i]['CategoryID'] . "";
				$this->query($strSQLQuery, 1);
				for ($j = 0; $j < sizeOf($this->insertData); $j++) {
					$this->insertData[$j]['ParentID'] = ($this->insertData[$j]['ParentID'] == $this->insertData[$i]['CategoryID']) ? $this->lastInsertId() : $this->insertData[$j]['ParentID'];
				}
			}

			for ($k = 0; $k < sizeOf($this->updateData); $k++)
			{
				if($this->updateData[$k]['ParentID'] == 0)
				{

					$this->updateSynCatDatatoInventory($this->updateData[$k]['CategoryID']);

				}else{

					$SQLQuery5 = "select count(*) count from inv_categories where e_categoryId =".$this->updateData[$k]['CategoryID']."";
					$res5 = $this->query($SQLQuery5, 1);

					if($res5[0]['count'] == 1)
					{

						$this->updateSynCatDatatoInventory($this->updateData[$k]['CategoryID']);

					}else{

						$strSqlQuery3 = "select CategoryID from inv_categories where e_categoryId =".$this->updateData[$k]['ParentID']."";
						$resPCatID = $this->query($strSqlQuery3, 1);

						$strSqlQuery4 = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from e_categories WHERE CategoryID = " . $this->updateData[$k]['CategoryID'] . "";
						$this->query($strSqlQuery4, 1);

					}


				}

			}
		}
	}

	function getAllDataFromInventory($parentId, $do) {
			
		$query = mysql_query("select CategoryID,ParentID from inv_categories where ParentID In(" . $parentId . ")");
		while ($row = mysql_fetch_assoc($query)) {
			($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
			$this->getAllDataFromInventory($row['CategoryID']);
		}

	}


	function getAllDataFromEcommerce($parentId, $do) {
		$query = mysql_query("select CategoryID,ParentID from e_categories where ParentID In(" . $parentId . ")");
		while ($row = mysql_fetch_assoc($query)) {
			($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
			$this->getAllDataFromEcommerce($row['CategoryID']);
		}
	}

	function updateSynCatDatatoEcommerce($ID)
	{
		$strSqlQuery2 = "update e_categories ecat,(select * from inv_categories where CategoryID = ".$ID.") old
                                        set ecat.Name               = old.Name,
                                            ecat.MetaTitle          = old.MetaTitle,
                                            ecat.MetaKeyword        = old.MetaKeyword,
                                            ecat.MetaDescription    = old.MetaDescription,
                                            ecat.CategoryDescription = old.CategoryDescription,
                                            ecat.Image              = old.Image,
                                            ecat.NumSubcategory     = old.NumSubcategory, 
                                            ecat.NumProducts        = old.NumProducts
                                        where item_categoryId = ".$ID; 
		$result = $this->query($strSqlQuery2, 1);
	}

	function updateSynCatDatatoInventory($ID)
	{
		$strSqlQuery2 = "update inv_categories ecat,(select * from e_categories where CategoryID = ".$ID.") old
                                        set ecat.Name               = old.Name,
                                            ecat.MetaTitle          = old.MetaTitle,
                                            ecat.MetaKeyword        = old.MetaKeyword,
                                            ecat.MetaDescription    = old.MetaDescription,
                                            ecat.CategoryDescription = old.CategoryDescription,
                                            ecat.Image              = old.Image,
                                            ecat.NumSubcategory     = old.NumSubcategory, 
                                            ecat.NumProducts        = old.NumProducts
                                        where e_categoryId = ".$ID; 
		$result = $this->query($strSqlQuery2, 1);
	}


	function getParentCategoryId($catId,$table){
		$sql = "select ParentID,CategoryID from $table where CategoryID= '".addslashes($catId)."' limit 1 ";
		$Res = $this->query($sql, 1);

		if ($Res[0]['ParentID'] =='0') {
			return $Res[0]['CategoryID'];
		} else {
			return $this->getParentCategoryId($Res[0]['ParentID'],$table);
		}
	}



	function checkCategoryExist($catId,$table){
		$sql = "select count(*) as total from $table where CategoryID= '".addslashes($catId)."' limit 1 ";
		$Res = $this->query($sql, 1);

		if ($Res[0]['total'] =='1') {
			return true;
		}
		return false;
	}




	// added by karishma 10 nov 2015 for inventory default Company

	function defaultInventoryCompanyUpdate($CmpID,$DefaultInventoryCompany)
	{
		if(!empty($CmpID)){
			$sql="update company set DefaultInventoryCompany='".$DefaultInventoryCompany."' where CmpID='".mysql_real_escape_string($CmpID)."'";
			$this->query($sql,0);
			if($DefaultInventoryCompany==1){
				$sql="update company set DefaultInventoryCompany='0' where CmpID!='".mysql_real_escape_string($CmpID)."'";
				$this->query($sql,0);
			}
		}
	}

	// update sync Setting

	function UpdatesyncInventorySetting($CmpID,$SyncInventorySetting,$AutomaticSyncAction)
	{
		if(!empty($CmpID)){
			$sql="update company set SyncInventorySetting='".addslashes($SyncInventorySetting)."' ,
			AutomaticSyncAction='".addslashes($AutomaticSyncAction)."' 			
			where CmpID='".mysql_real_escape_string($CmpID)."'";
			$this->query($sql,0);

		}
	}

	/*********************Start Inventory Sync Company to Company*************************/

	function syncInventoryCompany($CmpID,$Id='',$AutoSyncType='',$childSyncType=''){

		if($this->getCompanyDBToExport()){


			// get Inventory Setting

			$sql = "select DefaultInventoryCompany,SyncInventorySetting,DisplayName,AutomaticSyncAction from erp.company where CmpID= '".addslashes($CmpID)."' ";
			$Res = $this->query($sql, 1);


			$CompanyToImportDB='erp_'.$Res[0]['DisplayName'];
			$SyncInventorySetting=json_decode($Res[0]['SyncInventorySetting'],true);
			$AutomaticSyncAction=json_decode($Res[0]['AutomaticSyncAction'],true);



			// get Default Inventory Company Setting

			$sql = "select CmpID,DefaultInventoryCompany,SyncInventorySetting,DisplayName from erp.company where DefaultInventoryCompany= '1' limit 1 ";
			$Res = $this->query($sql, 1);

			$_SESSION['CmpIDToImport']=$CmpID;
			$_SESSION['CmpIDToExport']=$Res[0]['CmpID'];




			if($Res[0]['CmpID']!=$CmpID){

				foreach($SyncInventorySetting as $key=>$val){
					
					if(!empty($AutoSyncType)){

						if(is_array($val)){

							if(key($val)==$AutoSyncType)
							$this->selectSyncType($SyncInventorySetting,$AutomaticSyncAction,$CompanyToImportDB,key($val),$val,$Id,$childSyncType);

						}else{
							if($val==$AutoSyncType)
							$this->selectSyncType($SyncInventorySetting,$AutomaticSyncAction,$CompanyToImportDB,$val,'',$Id,$childSyncType);
						}


					}else{
						
						if(is_array($val)){
							$this->selectSyncType($SyncInventorySetting,$AutomaticSyncAction,$CompanyToImportDB,key($val),$val,$Id);
						}else{
							$this->selectSyncType($SyncInventorySetting,$AutomaticSyncAction,$CompanyToImportDB,$val,'',$Id);
						}

					}


				}
				

			}

			unset($_SESSION['CmpIDToImport']);
			unset($_SESSION['CmpIDToExport']);
		
		}

	}

	// Selection of sync setting

	function selectSyncType($SyncInventorySetting,$AutomaticSyncAction,$CompanyToImportDB,$text,$array,$Id='',$childSyncType=''){
		

		$text=trim(str_replace(' ','',$text) );
		foreach($SyncInventorySetting as $k=>$v){
			if(is_array($v)){

				if(key($v)=='setting'){
					foreach($v as $k1=>$v1 ){
						if(is_array($v1)){
							foreach($v1 as $k2=>$v2){

								if(key($v2)=='manage manufacture'){
									$settingAtrrbuteval=$v2['manage manufacture'];
								}
							}

						}
					}
				}
			}
		}


		
		switch ($text) {  
			case 'category':  			
				$this->selectCategorytoSync($CompanyToImportDB,$AutomaticSyncAction,$Id);
				break;
			case 'items': 	
				$ItemsArray['synctype']='all';
				$ItemsArray['synctypeselected']='all';
				$this->selectItemstoSync($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$Id,$settingAtrrbuteval);
				break;

			case 'dimensions': 
				$ItemsArray['synctype']='all';
				$ItemsArray['synctypeselected']='all';
				$this->selectItemstoSync($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$Id,$settingAtrrbuteval);
				$this->syncDimentions($CompanyToImportDB,$Id);

				break;

			case 'setting': 	
				$this->settingOption($array,$CompanyToImportDB,$AutomaticSyncAction,$Id,$childSyncType);
				break;
			case 'requireditems': 		
				$this->requiredItems($array,$CompanyToImportDB,$AutomaticSyncAction,$Id,$settingAtrrbuteval);
				break;


			case 'aliasitems': 
				$this->aliasItems($array,$CompanyToImportDB,$AutomaticSyncAction,$Id,$settingAtrrbuteval);
				break;

			case 'BOM': 	

				$this->syncbom($CompanyToImportDB,$AutomaticSyncAction,$Id);
				break;

		}
		
		
		
		
	}

	//get Company from Export
	function getCompanyDBToExport(){
		$sql = "select DefaultInventoryCompany,SyncInventorySetting,DisplayName from erp.company where DefaultInventoryCompany= '1' ";
		$Res = $this->query($sql, 1);
		if($Res[0]['DisplayName'])
		return $CompanyToExportDB='erp_'.$Res[0]['DisplayName'];
		else return false;
	}

	/*********Start Function of Sync Items**********/
	function selectItemstoSync($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$Id='',$settingAtrrbuteval=''){


		$CompanyToExportDB=$this->getCompanyDBToExport();

		if($settingAtrrbuteval!=''){
			foreach($settingAtrrbuteval as $k=>$v){
				if(strtolower($v)=='all'){
					$attribute_value_in='';
					break;
				}else{
					$attribute_value_in .="'$v',";
				}

			}
			$attribute_value_in=substr($attribute_value_in,0,-1);
		}


		if($ItemsArray['synctypeselected']=='all'){
			$strSQLQuery = "select ItemID from ".$CompanyToExportDB.".inv_items WHERE 1=1 ";
			$strSQLQuery .= (!empty($Id))? " AND ItemID='".addslashes($Id)."' ":"";
			$strSQLQuery .= (!empty($attribute_value_in))? " AND  Manufacture IN(".$attribute_value_in.") ":"";

			$strSQLQuery .= "order by ItemID asc";

			$res=$this->query($strSQLQuery, 1);
			foreach($res as $items){
				$SyncItemsArray['ItemID'][]=$items['ItemID'];
			}
		}

		$sql = "show COLUMNS  from ".$CompanyToExportDB.".inv_items ";
		$ColumnArray = $this->query($sql, 1);


		foreach($ColumnArray as $array){
			$Columns[]=$array['Field'];

		}

		unset($Columns[array_search( 'Status', $Columns )]);
		unset($Columns[array_search( 'pack_size', $Columns )]);
		unset($Columns[array_search( 'weight', $Columns )]);
		unset($Columns[array_search( 'width', $Columns )]);
		unset($Columns[array_search( 'height', $Columns )]);
		unset($Columns[array_search( 'depth', $Columns )]);
		unset($Columns[array_search( 'wt_Unit', $Columns )]);
		unset($Columns[array_search( 'wd_Unit', $Columns )]);
		unset($Columns[array_search( 'ht_Unit', $Columns )]);
		unset($Columns[array_search( 'ln_Unit', $Columns )]);


		unset($Columns[array_search( 'AdminType', $Columns )]);
		unset($Columns[array_search( 'CreatedBy', $Columns )]);
		unset($Columns[array_search( 'LastAdminType', $Columns )]);
		unset($Columns[array_search( 'LastCreatedBy', $Columns )]);
		unset($Columns[array_search( 'AddedDate', $Columns )]);

		foreach($SyncItemsArray['ItemID'] as $items){
			$sql = "select Item.* from ".$CompanyToExportDB.".inv_items as Item
					left join ".$CompanyToExportDB.".inv_item_images ItemImages on ItemImages.ItemID=Item.ItemID
					where Item.ItemID='".addslashes($items)."'"; 
			$ItemsArray = $this->query($sql, 1);

			$this->syncInventoryItemsCompanyToCompany($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$Columns);



		}
			
	}

	function syncInventoryItemsCompanyToCompany($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$Columns){

		$CompanyToExportDB=$this->getCompanyDBToExport();

		foreach($Columns as $ColumnsField){
			${$ColumnsField}=$ItemsArray[0][$ColumnsField];
		}




		$AddedDate=date('Y-m-d');


		$is_exist=$this->checkSkuExistCompany($Sku,''.$CompanyToImportDB.'.inv_items','Sku','ItemID');




		if($is_exist=='0'){

			$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_items where
			ItemID= '".addslashes($ItemID)."' ";
			$is_Avail = $this->query($sql, 1);
			if($is_Avail[0]['total']==0){

				$fromfilepath="../admin/inventory/upload/items/images/" . $_SESSION['CmpIDToExport'] . "/".$Image;
				$tofilepath="../admin/inventory/upload/items/images/" . $_SESSION['CmpIDToImport'] . "/".$Image;
				$directory="../admin/inventory/upload/items/images/" . $_SESSION['CmpIDToImport'];

				if (!is_dir($directory)) {
					mkdir($directory, 0777, true);
				}
					

				if (file_exists($fromfilepath)) {
					copy($fromfilepath, $tofilepath);

					$sql = "select Storage from erp.company where CmpID='".$_SESSION['CmpIDToImport']."'";
					$arryRow = $this->query($sql, 1);

					$FileSize = (filesize($tofilepath)/1024); //KB

					if($FileSize>0){
						$NewStorage = ($arryRow[0]['Storage'] + $FileSize) ;

						if($NewStorage<0) $NewStorage=0;
						else $NewStorage = round($NewStorage,2);
						$sql = "update erp.company set Storage='".$NewStorage."' where CmpID='".$_SESSION['CmpIDToImport']."'";
						$this->query($sql,0);
					}

				}

				if($virtual_file!=''){

					$fromfilepath="../upload/items/document/".$_SESSION['CmpIDToExport']."/".$virtual_file;
					$tofilepath="../upload/items/document/".$_SESSION['CmpIDToImport']."/".$virtual_file;
					$directory="../upload/items/document/".$_SESSION['CmpIDToImport'];

					if (!is_dir($directory)) {

						mkdir($directory, 0777, true);
					}


					if (file_exists($fromfilepath)) {

						copy($fromfilepath, $tofilepath);

					}
				}
					

				/***********insert new item************/

				$sql="insert into ".$CompanyToImportDB.".inv_items set ";
				foreach($Columns as $ColumnsField){
					${$ColumnsField}=$ItemsArray[0][$ColumnsField];
					$sql .="`".$ColumnsField."`='".addslashes($ItemsArray[0][$ColumnsField])."',";
				}

				$sql .=" Status='1' ,AddedDate='".addslashes($AddedDate)."' ";

				$this->query($sql,0);
				$lastInsertItemId=$this->lastInsertId();


				/***************add multiple image**************/

				$sql = "select * from ".$CompanyToExportDB.".inv_item_images where  ItemID= '".addslashes($ItemID)."' ";
				$AllImageArray = $this->query($sql, 1);

				foreach($AllImageArray as $imageArray){
					$Image=$imageArray['Image'];
					$alt_text=$imageArray['alt_text'];
					$fromfilepath="../admin/inventory/upload/items/images/" . $_SESSION['CmpIDToExport'] . "/".$Image;
					$tofilepath="../admin/inventory/upload/items/images/" . $_SESSION['CmpIDToImport'] . "/".$Image;
					$directory="../admin/inventory/upload/items/images/" . $_SESSION['CmpIDToImport'];

					if (!is_dir($directory)) {
						mkdir($directory, 0777, true);
					}


					if (file_exists($fromfilepath)) {
						copy($fromfilepath, $tofilepath);

						$sql = "select Storage from erp.company where CmpID='".$_SESSION['CmpIDToImport']."'";
						$arryRow = $this->query($sql, 1);

						$FileSize = (filesize($tofilepath)/1024); //KB
							
						if($FileSize>0){
							$NewStorage = ($arryRow[0]['Storage'] + $FileSize) ;

							if($NewStorage<0) $NewStorage=0;
							else $NewStorage = round($NewStorage,2);
							$sql = "update erp.company set Storage='".$NewStorage."' where CmpID='".$_SESSION['CmpIDToImport']."'";
							$this->query($sql,0);
						}
							
					}


					$sql="insert into ".$CompanyToImportDB.".inv_item_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ItemID ='".addslashes($lastInsertItemId)."'";
					$this->query($sql,0);
				}


				// end

			}

		}else{
			if(in_array('update',$AutomaticSyncAction)) {
				$sql="update ".$CompanyToImportDB.".inv_items set ";
				foreach($Columns as $ColumnsField){
					${$ColumnsField}=$ItemsArray[0][$ColumnsField];
					$sql .="`".$ColumnsField."`='".addslashes($ItemsArray[0][$ColumnsField])."',";
				}

				$sql .=" Status='1' ,AddedDate='".addslashes($AddedDate)."' where ItemID= '".addslashes($ItemID)."'";

				$this->query($sql,0);
			}
		}




			







	}

	function checkSkuExistCompany($Sku,$table,$field,$selectedFieldId){
		$sql = "select count(*) as total,".$selectedFieldId." from ".$table." where  ".$field."= '".addslashes($Sku)."' ";
		$ItemsAvail = $this->query($sql, 1);
		if($ItemsAvail[0]['total']==0){
			return '0';
		}
		return $ItemsAvail[0][$selectedFieldId];
			
	}

	/*********End Function of Sync Items**********/

	/*********Start Function of Sync Dimentions**********/
	function syncDimentions($CompanyToImportDB,$Id=''){

		$CompanyToExportDB=$this->getCompanyDBToExport();

		$strSQLQuery = "select Sku,pack_size,weight,width,height,depth,wt_Unit,wd_Unit,ht_Unit,ln_Unit from ".$CompanyToExportDB.".inv_items ";
		$strSQLQuery .= (!empty($Id))? " WHERE ItemID='".addslashes($Id)."' ":"";

		$res=$this->query($strSQLQuery, 1);

		foreach($res as $dimentions){
			$Sku=$dimentions['Sku'];
			$pack_size=$dimentions['pack_size'];
			$weight=$dimentions['weight'];
			$width=$dimentions['width'];
			$height=$dimentions['height'];
			$depth=$dimentions['depth'];
			$wt_Unit=$dimentions['wt_Unit'];
			$wd_Unit=$dimentions['wd_Unit'];
			$ht_Unit=$dimentions['ht_Unit'];
			$ln_Unit=$dimentions['ln_Unit'];

			$is_exist=$this->checkSkuExistCompany($Sku,''.$CompanyToImportDB.'.inv_items','Sku','ItemID');
			if($is_exist!='0'){
				$ItemID=$is_exist;

				$strSQLQuery = "update ".$CompanyToImportDB.".inv_items set pack_size='" . addslashes($pack_size) . "',
				weight='" . addslashes($weight) . "',width='" . addslashes($width) . "',
				height='" . addslashes($height) . "',depth='" . addslashes($depth) . "',
				wt_Unit='".addslashes($wtUnit)."'  ,wd_Unit='" . addslashes($wdUnit). "' ,
				ht_Unit='" . addslashes($htUnit)."' ,ln_Unit='" . addslashes($lnUnit). "' 
				where ItemID='" . $ItemID."'"; 
				$this->query($strSQLQuery, 0);
			}

		}
	}

	/*********End Function of Sync Dimentions**********/

	/*********Start Function of Sync Category**********/
	function selectCategorytoSync($CompanyToImportDB,$AutomaticSyncAction,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_categories ";
		$strSQLQuery .= (!empty($Id))? " WHERE CategoryID='".addslashes($Id)."' ":"";

		$res=$this->query($strSQLQuery, 1);

		foreach($res as $categories){

			$this->syncCategoryCompanyToCompany($categories,$CompanyToImportDB,$AutomaticSyncAction);



		}
		
	}

	function syncCategoryCompanyToCompany($categories,$CompanyToImportDB,$AutomaticSyncAction){


		$CompanyToExportDB=$this->getCompanyDBToExport();

		$CategoryID=$categories['CategoryID'];
		$Name=$categories['Name'];
		$MetaTitle=$categories['MetaTitle'];
		$MetaKeyword=$categories['MetaKeyword'];
		$MetaDescription=$categories['MetaDescription'];
		$CategoryDescription=$categories['CategoryDescription'];
		$Image=$categories['Image'];
		$ParentID=$categories['ParentID'];
		$Level=$categories['Level'];
		$valuationType=$categories['valuationType'];

		$NumSubcategory=$categories['NumSubcategory'];
		$NumProducts=$categories['NumProducts'];
		$sort_order=$categories['sort_order'];
		$AddedDate=date('Y-m-d');
		$code=$categories['code'];

		$is_exist=$this->checkCategoryExistCompany($CategoryID,''.$CompanyToImportDB.'.inv_categories');

		if($is_exist=='0'){

			/***********insert new item************/

			$sql="insert into ".$CompanyToImportDB.".inv_categories set CategoryID='".addslashes($CategoryID)."' ,
				Name='".addslashes($Name)."' ,MetaTitle='".addslashes($MetaTitle)."' ,
				MetaKeyword='".addslashes($MetaKeyword)."' ,MetaDescription='".addslashes($MetaDescription)."' ,
				CategoryDescription='".addslashes($CategoryDescription)."' ,Image='".addslashes($Image)."' , 
				ParentID='".addslashes($ParentID)."' , Level='".addslashes($Level)."' ,
				NumSubcategory='".addslashes($NumSubcategory)."' ,NumProducts='".addslashes($NumProducts)."' ,
				sort_order='".addslashes($sort_order)."' ,	Status='1' ,
				AddedDate= '".addslashes($AddedDate)."',code= '".addslashes($code)."',
				valuationType= '".addslashes($valuationType)."'";
			$this->query($sql,0);


		}else{

			if(in_array('update',$AutomaticSyncAction)) {
				$sql="update ".$CompanyToImportDB.".inv_categories set
				Name='".addslashes($Name)."' ,MetaTitle='".addslashes($MetaTitle)."' ,
				MetaKeyword='".addslashes($MetaKeyword)."' ,MetaDescription='".addslashes($MetaDescription)."' ,
				CategoryDescription='".addslashes($CategoryDescription)."' ,Image='".addslashes($Image)."' , 
				ParentID='".addslashes($ParentID)."' , Level='".addslashes($Level)."' ,
				NumSubcategory='".addslashes($NumSubcategory)."' ,NumProducts='".addslashes($NumProducts)."' ,
				sort_order='".addslashes($sort_order)."' ,	Status='1' ,
				AddedDate= '".addslashes($AddedDate)."',code= '".addslashes($code)."',
				valuationType= '".addslashes($valuationType)."'
				where CategoryID='".addslashes($CategoryID)."' 
				";
				$this->query($sql,0);
			}

		}



	}

	function checkCategoryExistCompany($CategoryID,$table){
		$sql = "select count(*) as total from ".$table." where  CategoryID= '".addslashes($CategoryID)."' ";
		$CategoryAvail = $this->query($sql, 1);
		if($CategoryAvail[0]['total']==0){
			return '0';
		}
		return $CategoryAvail[0]['total'];
			
	}

	/*********End Function of Sync Category**********/

	/*********Start Function of Sync Setting**********/
	function settingOption($array,$CompanyToImportDB,$AutomaticSyncAction,$Id='',$childSyncType=''){


		$array['setting'] = array_values($array['setting']);


		for($count=0;$count<count($array['setting']);$count++){
			if(is_array($array['setting'][$count])){
				foreach($array['setting'][$count] as $settkey=>$settval){

					$settingType=$settkey;
					$settingAtrrbuteval=$settval;

				}
			}else{
				$settingType=$array['setting'][$count];
			}

			if($Id!='' && $settingType==$childSyncType){

				switch ($settingType) {
					case 'global attributes':
						$this->syncGlobalAttributeCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,$Id);

						break;
					case 'procurement':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Procurement',$Id);
						break;
					case 'valuation type':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'EvaluationType',$Id);
						break;
					case 'adjustment reason':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'AdjReason',$Id);
						break;
					case 'manage prefixes':
						$this->syncPrefixesCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction);
						break;
					case 'manage model':
						$this->syncModelCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,$Id);
						break;
					case 'manage generation':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Generation',$Id);
						break;
					case 'manage extended':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Extended',$Id);
						break;
					case 'manage manufacture':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Manufacture',$Id,$settingAtrrbuteval);
						break;

					case 'manage condition':
						$this->syncConditionCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,$Id);
						break;

					case 'reorder method':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Reorder',$Id);
						break;
					case 'manage unit':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Unit',$Id);
						break;
					case 'item type':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'ItemType',$Id);
						break;


				}



			}elseif($Id==''){
					


					

				switch ($settingType) {
					case 'global attributes':
						$this->syncGlobalAttributeCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction);

						break;
					case 'procurement':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Procurement');
						break;
					case 'valuation type':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'EvaluationType');
						break;
					case 'adjustment reason':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'AdjReason');
						break;
					case 'manage prefixes':
						$this->syncPrefixesCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction);
						break;
					case 'manage model':
						$this->syncModelCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction);
						break;
					case 'manage generation':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Generation');
						break;
					case 'manage extended':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Extended');
						break;
					case 'manage manufacture':

						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Manufacture','',$settingAtrrbuteval);
						break;

					case 'manage condition':
						$this->syncConditionCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction);
						break;

					case 'reorder method':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Reorder');
						break;
					case 'manage unit':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'Unit');
						break;
					case 'item type':
						$this->syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,'ItemType');
						break;



				}
			}



		}



	}

	function syncProcurementCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,$attribute_name,$Id='',$settingAtrrbuteval=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();
		if($settingAtrrbuteval!=''){
			foreach($settingAtrrbuteval as $k=>$v){
				if(strtolower($v)=='all'){
					$attribute_value_in='';
					break;
				}else{
					$attribute_value_in .="'$v',";
				}

			}
			$attribute_value_in=substr($attribute_value_in,0,-1);
		}


		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_attribute_value as a
	inner join  ".$CompanyToExportDB.".inv_attribute b on b.attribute_id=a.attribute_id and b.attribute_name='".addslashes($attribute_name)."' WHERE 1=1";
		$strSQLQuery .= (!empty($Id))? " AND  value_id='".addslashes($Id)."' ":"";
		$strSQLQuery .= (!empty($attribute_value_in))? " AND  attribute_value IN(".$attribute_value_in.") ":"";

		$res=$this->query($strSQLQuery, 1);

		foreach($res as $attributes){

			$this->syncAttributeCompanyToCompany($attributes,$CompanyToImportDB,$AutomaticSyncAction);

		}
	}

	function syncAttributeCompanyToCompany($attributes,$CompanyToImportDB,$AutomaticSyncAction){


		$CompanyToExportDB=$this->getCompanyDBToExport();

		$value_id=$attributes['value_id'];
		$attribute_value=$attributes['attribute_value'];
		$attribute_id=$attributes['attribute_id'];
		$editable=$attributes['editable'];
		$locationID=$attributes['locationID'];
		$attribute_name=$attributes['attribute_name'];
		$attribute=$attributes['attribute'];

		// For Insert In attribute table
		$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_attribute where  attribute_name= '".addslashes($attribute_name)."' ";
		$is_Avail = $this->query($sql, 1);
		if($is_Avail[0]['total']==0){
			$sql="insert into ".$CompanyToImportDB.".inv_attribute set attribute_id='".addslashes($attribute_id)."' ,
				attribute_name='".addslashes($attribute_name)."' ,attribute='".addslashes($attribute)."' ";
			$this->query($sql,0);
		}else{
			if(in_array('update',$AutomaticSyncAction)) {
				$sql="update ".$CompanyToImportDB.".inv_attribute set attribute_id='".addslashes($attribute_id)."' ,
				attribute='".addslashes($attribute)."' where  attribute_name= '".addslashes($attribute_name)."' ";
				$this->query($sql,0);
			}
		}

		// For Insert In attribute value table

		$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_attribute_value
		where  (attribute_value= '".addslashes($attribute_value)."' and attribute_id='".addslashes($attribute_id)."') OR value_id ='".addslashes($value_id)."'";  
		$is_exist = $this->query($sql, 1);
		if($is_exist[0]['total']==0){
			$sql="insert into ".$CompanyToImportDB.".inv_attribute_value set value_id='".addslashes($value_id)."' ,
				attribute_value='".addslashes($attribute_value)."' ,attribute_id='".addslashes($attribute_id)."',
				editable='".addslashes($editable)."',Status='1',locationID='".addslashes($locationID)."' ";
			$this->query($sql,0);
		}
		else{
			if(in_array('update',$AutomaticSyncAction)) {
				$sql="update  ".$CompanyToImportDB.".inv_attribute_value set attribute_value= '".addslashes($attribute_value)."' ,
				attribute_id='".addslashes($attribute_id)."',
				editable='".addslashes($editable)."',Status='1',locationID='".addslashes($locationID)."' 
				where value_id='".addslashes($value_id)."'";
				$this->query($sql,0);
			}
		}






	}

	function syncModelCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_ModelGen ";
		$strSQLQuery .= (!empty($Id))? " WHERE id='".addslashes($Id)."' ":"";
		$res=$this->query($strSQLQuery, 1);

		foreach($res as $models){

			$this->syncModelGenerationCompanyToCompany($models,$CompanyToImportDB,$AutomaticSyncAction);

		}
	}

	function syncModelGenerationCompanyToCompany($models,$CompanyToImportDB,$AutomaticSyncAction){


		$CompanyToExportDB=$this->getCompanyDBToExport();

		$id=$models['id'];
		$Model=$models['Model'];
		$item_id=$models['item_id'];
		$Sku=$models['Sku'];
		$Generation=$models['Generation'];
		$Status=$models['Status'];


		// For Insert In Model Gen table
		$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_ModelGen where  id= '".addslashes($id)."' ";
		$is_Avail = $this->query($sql, 1);
		if($is_Avail[0]['total']==0){
			$sql="insert into ".$CompanyToImportDB.".inv_ModelGen set id='".addslashes($id)."' ,
				Model='".addslashes($Model)."' ,item_id='".addslashes($item_id)."',
				Sku='".addslashes($Sku)."',Generation='".addslashes($Generation)."',
				Status='".addslashes($Status)."' ";
			$this->query($sql,0);
		}else{
			if(in_array('update',$AutomaticSyncAction)) {
				$sql="update ".$CompanyToImportDB.".inv_ModelGen set id='".addslashes($id)."' ,
				item_id='".addslashes($item_id)."',	Sku='".addslashes($Sku)."',
				Generation='".addslashes($Generation)."',Model='".addslashes($Model)."' ,
				Status='".addslashes($Status)."' where  id= '".addslashes($id)."' ";
				$this->query($sql,0);
			}
		}







	}

	function syncPrefixesCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$strSQLQuery = "select *,count(*) as total  from ".$CompanyToExportDB.".inv_prefix  ";
		$res=$this->query($strSQLQuery, 1);

		if(count($res)==1){
			$prefixID=$res[0]['prefixID'];
			$adjustmentPrefix=$res[0]['adjustmentPrefix'];
			$adjustPrefixNum=$res[0]['adjustPrefixNum'];
			$ToP=$res[0]['ToP'];
			$ToN=$res[0]['ToN'];
			$bom_prefix=$res[0]['bom_prefix'];
			$bom_number=$res[0]['bom_number'];
			$Status=1;

			$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_prefix ";
			$is_Avail = $this->query($sql, 1);
			if($is_Avail[0]['total']==0){
				$sql="insert into ".$CompanyToImportDB.".inv_prefix set prefixID='".addslashes($prefixID)."' ,
				adjustmentPrefix='".addslashes($adjustmentPrefix)."' ,adjustPrefixNum='".addslashes($adjustPrefixNum)."',
				ToP='".addslashes($ToP)."',ToN='".addslashes($ToN)."',bom_prefix='".addslashes($bom_prefix)."',bom_number='".addslashes($bom_number)."',
				Status='1' ";
				$this->query($sql,0);
			}else{
				if(in_array('update',$AutomaticSyncAction)) {
					$sql="update  ".$CompanyToImportDB.".inv_prefix set
				adjustmentPrefix='".addslashes($adjustmentPrefix)."' ,adjustPrefixNum='".addslashes($adjustPrefixNum)."',
				ToP='".addslashes($ToP)."',ToN='".addslashes($ToN)."',bom_prefix='".addslashes($bom_prefix)."',bom_number='".addslashes($bom_number)."',
				Status='1' where prefixID='".addslashes($prefixID)."' ";
					$this->query($sql,0);
				}
			}




		}

	}

	function syncConditionCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_condition ";
		$strSQLQuery .= (!empty($Id))? " WHERE ConditionID='".addslashes($Id)."' ":"";
		$res=$this->query($strSQLQuery, 1);
		foreach($res as $condition){

			$this->syncManageConditionCompanyToCompany($condition,$CompanyToImportDB,$AutomaticSyncAction);

		}
	}

	function syncManageConditionCompanyToCompany($condition,$CompanyToImportDB,$AutomaticSyncAction){

		$CompanyToExportDB=$this->getCompanyDBToExport();

		$ConditionID=$condition['ConditionID'];
		$Name=$condition['Name'];
		$ConditionDescription=$condition['ConditionDescription'];
		$Image=$condition['Image'];
		$ParentID=$condition['ParentID'];
		$Level=$condition['Level'];
		$NumSubcondition=$condition['NumSubcondition'];
		$NumProducts=$condition['NumProducts'];
		$sort_order=$condition['sort_order'];
		$AddedDate=$condition['AddedDate'];


		// For Insert In Condition table
		$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_condition where
		Name= '".addslashes($Name)."' or ConditionID= '".addslashes($ConditionID)."' ";
		$is_Avail = $this->query($sql, 1);
		if($is_Avail[0]['total']==0){

			$sql="insert into ".$CompanyToImportDB.".inv_condition set ConditionID= '".addslashes($ConditionID)."',
			Name= '".addslashes($Name)."',ConditionDescription= '".addslashes($ConditionDescription)."' ,
			Image= '".addslashes($Image)."', ParentID= '".addslashes($ParentID)."',
			Level= '".addslashes($Level)."', NumSubcondition= '".addslashes($NumSubcondition)."',
			NumProducts= '".addslashes($NumProducts)."', sort_order= '".addslashes($sort_order)."',
			AddedDate= '".addslashes($AddedDate)."' "; 
			$this->query($sql,0);
		}else{
			if(in_array('update',$AutomaticSyncAction)) {
				$sql="update ".$CompanyToImportDB.".inv_condition set Name= '".addslashes($Name)."',
			ConditionDescription= '".addslashes($ConditionDescription)."' ,
			Image= '".addslashes($Image)."', ParentID= '".addslashes($ParentID)."',
			Level= '".addslashes($Level)."', NumSubcondition= '".addslashes($NumSubcondition)."',
			NumProducts= '".addslashes($NumProducts)."', sort_order= '".addslashes($sort_order)."',
			AddedDate= '".addslashes($AddedDate)."'  where
			ConditionID= '".addslashes($ConditionID)."' "; 
				$this->query($sql,0);
			}
		}







	}

	function syncGlobalAttributeCompanyToCompany($CompanyToImportDB,$AutomaticSyncAction,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();



		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_global_attributes ";
		$strSQLQuery .= (!empty($Id))? " WHERE Gaid='".addslashes($Id)."' ":"";

		$res=$this->query($strSQLQuery, 1);
		foreach($res as $attributes){

			$this->syncGAttributeCompanyToCompany($attributes,$CompanyToImportDB,$AutomaticSyncAction);

		}
	}

	function syncGAttributeCompanyToCompany($attributes,$CompanyToImportDB,$AutomaticSyncAction){

		$CompanyToExportDB=$this->getCompanyDBToExport();

		$Gaid=$attributes['Gaid'];
		$AttributeType=$attributes['AttributeType'];
		$IsGlobal=$attributes['IsGlobal'];
		$Priority=$attributes['Priority'];
		$Name=$attributes['Name'];
		$Caption=$attributes['Caption'];
		$TextLength=$attributes['TextLength'];
		$Options=$attributes['Options'];
		$required=$attributes['required'];



		// For Insert In Condition table
		$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_global_attributes where
		Gaid= '".addslashes($Gaid)."' "; 
		$is_Avail = $this->query($sql, 1);
		if($is_Avail[0]['total']==0){

			$sql="insert into ".$CompanyToImportDB.".inv_global_attributes set Gaid= '".addslashes($Gaid)."',
			AttributeType= '".addslashes($AttributeType)."',IsGlobal= '".addslashes($IsGlobal)."' ,
			Priority= '".addslashes($Priority)."', Name= '".addslashes($Name)."',
			Caption= '".addslashes($Caption)."', TextLength= '".addslashes($TextLength)."',
			Options= '".addslashes($Options)."', required= '".addslashes($required)."',
			Status= 'Yes' "; 
			$this->query($sql,0);

			// Insert In global option
			$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_global_optionList WHERE Gaid='".addslashes($Gaid)."'";

			$res=$this->query($strSQLQuery, 1);
			foreach($res as $options){
				$sql="insert into ".$CompanyToImportDB.".inv_global_optionList set
					Gaid= '".addslashes($options['Gaid'])."',title= '".addslashes($options['title'])."' ,
					Price= '".addslashes($options['Price'])."', PriceType= '".addslashes($options['PriceType'])."',
					Weight= '".addslashes($options['Weight'])."', SortOrder= '".addslashes($options['SortOrder'])."'		"; 
				$this->query($sql,0);


					
					
			}




			// Insert In catalog
			$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_catalog_attributes WHERE Gaid='".addslashes($Gaid)."' ";

			$res=$this->query($strSQLQuery, 1);
			foreach($res as $catalog){

				$sql="insert into ".$CompanyToImportDB.".inv_catalog_attributes set Gaid= '".addslashes($catalog['Gaid'])."',
					Cid= '".addslashes($catalog['Cid'])."' "; 
				$this->query($sql,0);


					
					
			}





		}else{
			if(in_array('update',$AutomaticSyncAction)) {
				$sql="update ".$CompanyToImportDB.".inv_global_attributes set
			AttributeType= '".addslashes($AttributeType)."',IsGlobal= '".addslashes($IsGlobal)."' ,
			Priority= '".addslashes($Priority)."', Name= '".addslashes($Name)."',
			Caption= '".addslashes($Caption)."', TextLength= '".addslashes($TextLength)."',
			Options= '".addslashes($Options)."', required= '".addslashes($required)."',
			Status= 'Yes' where		Gaid= '".addslashes($Gaid)."'"; 
				$this->query($sql,0);
			}
			
		// Insert In global option
			$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_global_optionList WHERE Gaid='".addslashes($Gaid)."'";

			$res=$this->query($strSQLQuery, 1);
			foreach($res as $options){
				$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_global_optionList where
				Id= '".addslashes($options['Id'])."' "; 
				$is_Avail = $this->query($sql, 1);
				if($is_Avail[0]['total']==0){
					$sql="insert into ".$CompanyToImportDB.".inv_global_optionList set
					Gaid= '".addslashes($options['Gaid'])."',title= '".addslashes($options['title'])."' ,
					Price= '".addslashes($options['Price'])."', PriceType= '".addslashes($options['PriceType'])."',
					Weight= '".addslashes($options['Weight'])."', SortOrder= '".addslashes($options['SortOrder'])."'		"; 
					$this->query($sql,0);
				}
	
					
			}
			
			
		// Insert In catalog
			$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_catalog_attributes WHERE Gaid='".addslashes($Gaid)."' ";

			$res=$this->query($strSQLQuery, 1);
			foreach($res as $catalog){
				$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_catalog_attributes where
				Gaid= '".addslashes($catalog['Gaid'])."'  and Cid= '".addslashes($catalog['Cid'])."' "; 
				$is_Avail = $this->query($sql, 1);
				if($is_Avail[0]['total']==0){
				$sql="insert into ".$CompanyToImportDB.".inv_catalog_attributes set Gaid= '".addslashes($catalog['Gaid'])."',
					Cid= '".addslashes($catalog['Cid'])."' "; 
				$this->query($sql,0);
				}


					
					
			}
		}

	}
	/*********End Function of Sync Setting**********/

	/*********Start Function of Sync Required**********/
	function requiredItems($array,$CompanyToImportDB,$AutomaticSyncAction,$Id='',$settingAtrrbuteval=''){

		for($count=0;$count<count($array['required items']);$count++){


			switch ($array['required items'][$count]) {
				case 'independent':

					$ItemsArray['synctype']='all';
					$ItemsArray['synctypeselected']='all';
					$this->selectItemstoSync($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$Id,$settingAtrrbuteval);

					break;
				case 'with items':
					$ItemsArray['synctype']='all';
					$ItemsArray['synctypeselected']='all';

					$this->selectItemstoSync($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$Id,$settingAtrrbuteval);
					$this->RequiredItemstoSync($CompanyToImportDB,$AutomaticSyncAction,$Id);

					break;



			}

		}


	}

	function RequiredItemstoSync($CompanyToImportDB,$AutomaticSyncAction,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();
		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_item_required ";
		$strSQLQuery .= (!empty($Id))? " WHERE ItemID='".addslashes($Id)."' ":"";

		$res=$this->query($strSQLQuery, 1);
		foreach($res as $required){


			$ItemID=$required['ItemID'];
			$item_id=$required['item_id'];
			$qty=$required['qty'];
			$Type=$required['Type'];
			$aliasID=$required['aliasID'];


			// For Insert In Condition table
			$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_item_required where
			ItemID= '".addslashes($ItemID)."' and item_id= '".addslashes($item_id)."' ";
			$is_Avail = $this->query($sql, 1);
			if($is_Avail[0]['total']==0){

				$sql="insert into ".$CompanyToImportDB.".inv_item_required set ItemID= '".addslashes($ItemID)."',
			item_id= '".addslashes($item_id)."',qty= '".addslashes($qty)."' ,
			Type= '".addslashes($Type)."', aliasID= '".addslashes($aliasID)."'"; 
				$this->query($sql,0);



			}else{
				if(in_array('update',$AutomaticSyncAction)) {
					$sql="update ".$CompanyToImportDB.".inv_item_required set qty= '".addslashes($qty)."' ,
					Type= '".addslashes($Type)."', aliasID= '".addslashes($aliasID)."'
					where	ItemID= '".addslashes($ItemID)."' and item_id= '".addslashes($item_id)."' "; 
					$this->query($sql,0);
				}
			}

		}
	}
	/*********End Function of Sync Required**********/

	/*********Start Function of Sync Alias**********/
	function aliasItems($array,$CompanyToImportDB,$AutomaticSyncAction,$Id='',$settingAtrrbuteval=''){

		for($count=0;$count<count($array['alias items']);$count++){
			

			switch ($array['alias items'][$count]) {
				case 'independent':

					$this->ImportAliasasMainItem($CompanyToImportDB,$Id);

					break;
				case 'with items':
					$ItemsArray['synctype']='all';
					$ItemsArray['synctypeselected']='all';
					if($Id!=''){
						$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_item_alias WHERE AliasID='".addslashes($Id)."'";
						$res=$this->query($strSQLQuery, 1);
						$item_id=$res[0]['item_id'];
						$this->selectItemstoSync($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,$item_id,$settingAtrrbuteval);
						$this->AliasItemstoSync($CompanyToImportDB,$AutomaticSyncAction,$Id);
					}else{
						$this->selectItemstoSync($ItemsArray,$CompanyToImportDB,$AutomaticSyncAction,'',$settingAtrrbuteval);
						$this->AliasItemstoSync($CompanyToImportDB,$AutomaticSyncAction);
					}


					break;



			}

		}


	}

	function ImportAliasasMainItem($CompanyToImportDB,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();
		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_item_alias ";
		$strSQLQuery .= (!empty($Id))? " WHERE AliasID='".addslashes($Id)."' ":"";

		$res=$this->query($strSQLQuery, 1);
		foreach($res as $required){

			$ItemAliasCode=$required['ItemAliasCode'];
			$item_id=$required['item_id'];
			$description=$required['description'];
			$Manufacture=$required['Manufacture'];

			$sql = "select CategoryID from ".$CompanyToImportDB.".inv_items where
			ItemID= '".addslashes($item_id)."'  ";
			$catDetail=$this->query($sql, 1);
			$CategoryID=$catDetail[0]['CategoryID'];

			// For Insert In Condition table
			$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_items where
			Sku= '".addslashes($ItemAliasCode)."'  ";
			$is_Avail = $this->query($sql, 1);
			if($is_Avail[0]['total']==0){

				$sql="insert into ".$CompanyToImportDB.".inv_items set Sku= '".addslashes($ItemAliasCode)."',
				description= '".addslashes($description)."',Manufacture= '".addslashes($Manufacture)."',
				CategoryID=  '".addslashes($CategoryID)."',Status='1' "; 
				$this->query($sql,0);



			}

		}
	}

	function AliasItemstoSync($CompanyToImportDB,$AutomaticSyncAction,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();
		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_item_alias ";
		$strSQLQuery .= (!empty($Id))? " WHERE AliasID='".addslashes($Id)."' ":"";
		$res=$this->query($strSQLQuery, 1);
		foreach($res as $required){


			$AliasID=$required['AliasID'];
			$ItemAliasCode=$required['ItemAliasCode'];
			$sku=$required['sku'];
			$VendorCode=$required['VendorCode'];
			$item_id=$required['item_id'];
			$description=$required['description'];
			$AliasType=$required['AliasType'];
			$Manufacture=$required['Manufacture'];


			// For Insert In Condition table
			 $sql = "select count(*) as total from ".$CompanyToImportDB.".inv_item_alias where
			  item_id= '".addslashes($item_id)."' and AliasID= '".addslashes($AliasID)."'";
			$is_Avail = $this->query($sql, 1);
			if($is_Avail[0]['total']==0){
				
				$sql="insert into ".$CompanyToImportDB.".inv_item_alias set AliasID= '".addslashes($AliasID)."',
			ItemAliasCode= '".addslashes($ItemAliasCode)."',sku= '".addslashes($sku)."' ,
			VendorCode= '".addslashes($VendorCode)."', item_id= '".addslashes($item_id)."',
			description= '".addslashes($description)."', AliasType= '".addslashes($AliasType)."', 
			Manufacture= '".addslashes($Manufacture)."' "; 
				$this->query($sql,0);



			}else{ 
				if(in_array('update',$AutomaticSyncAction)) {

					$sql="update ".$CompanyToImportDB.".inv_item_alias set AliasID= '".addslashes($AliasID)."',
			ItemAliasCode= '".addslashes($ItemAliasCode)."',sku= '".addslashes($sku)."' ,
			VendorCode= '".addslashes($VendorCode)."', item_id= '".addslashes($item_id)."',
			description= '".addslashes($description)."', AliasType= '".addslashes($AliasType)."', 
			Manufacture= '".addslashes($Manufacture)."'  where
			  item_id= '".addslashes($item_id)."' and AliasID= '".addslashes($AliasID)."' "; 
					$this->query($sql,0);
				}
			}

		}
	}
	/*********End Function of Sync Alias**********/

	/*********Start Function of Sync BOM**********/

	function syncbom($CompanyToImportDB,$AutomaticSyncAction,$Id=''){
		$CompanyToExportDB=$this->getCompanyDBToExport();
		$strSQLQuery = "select * from ".$CompanyToExportDB.".inv_bill_of_material ";
		$strSQLQuery .= (!empty($Id))? " WHERE bomID='".addslashes($Id)."' ":"";
		$res=$this->query($strSQLQuery, 1);
		foreach($res as $required){


			$bomID=$required['bomID'];
			$bom_code=$required['bom_code'];
			$item_id=$required['item_id'];
			$description=$required['description'];
			$bill_option=$required['bill_option'];
			$Sku=$required['Sku'];
			$bomCondition=$required['bomCondition'];
			$unit_cost=$required['unit_cost'];
			$total_cost=$required['total_cost'];
			$on_hand_qty=$required['on_hand_qty'];
			$bomDate=$required['bomDate'];
			$AsmCount=$required['AsmCount'];
			$DsmCount=$required['DsmCount'];
			$UpdatedDate=$required['UpdatedDate'];


			// For Insert In Condition table
			$sql = "select count(*) as total from ".$CompanyToImportDB.".inv_bill_of_material where
			 bomID= '".addslashes($bomID)."' ";
			$is_Avail = $this->query($sql, 1);
			if($is_Avail[0]['total']==0){

				$sql="insert into ".$CompanyToImportDB.".inv_bill_of_material set bomID= '".addslashes($bomID)."',
				bom_code= '".addslashes($bom_code)."',
			item_id= '".addslashes($item_id)."',description= '".addslashes($description)."',
			bill_option= '".addslashes($bill_option)."', Sku= '".addslashes($Sku)."',
			bomCondition= '".addslashes($bomCondition)."', unit_cost= '".addslashes($unit_cost)."', 
			total_cost= '".addslashes($total_cost)."' , on_hand_qty= '".addslashes($on_hand_qty)."',
			 bomDate= '".addslashes($bomDate)."', AsmCount= '".addslashes($AsmCount)."',
			  DsmCount= '".addslashes($DsmCount)."', UpdatedDate= '".addslashes($UpdatedDate)."'"; 
				$this->query($sql,0);
					
				$AddedBomId=$this->lastInsertId();
				$sql="insert into ".$CompanyToImportDB.".inv_item_bom
				(bomID,sku,bom_code,optionID,item_id,`Condition`,description,bom_qty,
				wastageQty,unit_cost,total_bom_cost,req_item) 
				select '".$AddedBomId."' as bomID,sku,bom_code,optionID,item_id,`Condition`,description,
				bom_qty,wastageQty,unit_cost,total_bom_cost,req_item 
				from ".$CompanyToExportDB.".inv_item_bom where bomID='".addslashes($bomID)."'"; 
				$this->query($sql,0);

			}else{
				if(in_array('update',$AutomaticSyncAction)) {
					$sql="update ".$CompanyToImportDB.".inv_bill_of_material set
				bom_code= '".addslashes($bom_code)."',
			item_id= '".addslashes($item_id)."',description= '".addslashes($description)."',
			bill_option= '".addslashes($bill_option)."', Sku= '".addslashes($Sku)."',
			bomCondition= '".addslashes($bomCondition)."', unit_cost= '".addslashes($unit_cost)."', 
			total_cost= '".addslashes($total_cost)."' , on_hand_qty= '".addslashes($on_hand_qty)."',
			 bomDate= '".addslashes($bomDate)."', AsmCount= '".addslashes($AsmCount)."',
			  DsmCount= '".addslashes($DsmCount)."', UpdatedDate= '".addslashes($UpdatedDate)."' 
			  where bomID= '".addslashes($bomID)."' "; 
					$this->query($sql,0);
				}
			}

		}
	}

	/*********End Function of Sync BOM**********/

	/*********************End Inventory Sync Company to Company********************/

	function TotalExportItems(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_items";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function TotalExportCategory(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_categories";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function TotalExportRequiredItems(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_item_required";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function TotalExportAliasItems(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_item_alias";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function TotalExportBOM(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_bill_of_material";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function TotalExportGlobalAttribute(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_global_attributes";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function TotalExportSettingType($attribute_name){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_attribute_value as a
			inner join  ".$CompanyToExportDB.".inv_attribute b on b.attribute_id=a.attribute_id and b.attribute_name='".addslashes($attribute_name)."'";

		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}


	function TotalExportPrefixes(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_prefix";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}
	function TotalExportModel(){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_ModelGen";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}




	function TotalExportCondition(){
		$CompanyToExportDB=$this->getCompanyDBToExport();
		$sql = "select count(*) as total from ".$CompanyToExportDB.".inv_condition";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}


	function SelectAttribute($attribute_name){
		$CompanyToExportDB=$this->getCompanyDBToExport();

		$sql = "select a.attribute_value from ".$CompanyToExportDB.".inv_attribute_value as a
			inner join  ".$CompanyToExportDB.".inv_attribute b on b.attribute_id=a.attribute_id and b.attribute_name='".addslashes($attribute_name)."'";

		$res=$this->query($sql, 1);
		return $res;

	}

	function addcc($CmpID){
		$sql="insert into erp.test set CmpID='".addslashes($CmpID)."' ";
		$this->query($sql,0);

	}

	// function for select companies who have automatic sync

	function SelectAutomaticSyncCompany(){
		$sql = "select CmpID from erp.company where AutomaticSync='Yes'";
		$res=$this->query($sql, 1);
		return $res;
	}

}
?>
