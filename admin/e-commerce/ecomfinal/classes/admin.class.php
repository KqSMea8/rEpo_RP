<?php
class admin extends dbClass
{

	/******** Add/Edit Admin ***********/
	/***********************************/

	function GetAdmin($id=0){
		$strAddQuery = (!empty($id))?(" where AdminID='".mysql_real_escape_string($id)."'"):("");
		$strSQLQuery ="select * from admin".$strAddQuery;
		return $this->query($strSQLQuery, 1);
	}

	function ValidateAdmin($Email,$Password){
		if(!empty($Email) && !empty($Password)){
			$strSQLQuery ="select * from admin where LCASE(AdminEmail) ='".strtolower(trim($Email))."' and Password='".md5($Password)."' and Status='1' ";
			return $this->query($strSQLQuery, 1);
		}
	}

	function ValidateSecureAdmin($Email,$Password){
		if(!empty($Email)){
			#$strSQLQuery ="select AdminID,AdminEmail from admin where MD5(AdminEmail) ='".$Email."' and MD5(Password)='".$Password."' and Status=1 ";
			$strSQLQuery ="select AdminID,AdminEmail from admin where MD5(AdminEmail) ='".$Email."' and Status='1' ";
			return $this->query($strSQLQuery, 1);
		}
	}

	function ChangePassword($AdminID,$Password)
	{
		global $Config;
		if(!empty($AdminID)){
			$strSQLQuery = "update admin set Password='".md5($Password)."' where AdminID='".mysql_real_escape_string($AdminID)."'";
			$this->query($strSQLQuery, 0);
		}
		return 1;
	}

	function  ListAdmin($AdminID=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($AdminID))?(" and a.AdminID='".$AdminID."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (a.Name like '".$SearchKey."%' or a.UserName  like '".$SearchKey."%')"):("");
		}

		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by a.Name ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

		$strSQLQuery = "select a.* from admin a ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function deleteAdmin($AdminID)
	{
		if(!empty($AdminID)){
			$sql = "delete from admin where AdminID = '".mysql_real_escape_string($AdminID)."'";
			$rs = $this->query($sql,0);

			$sql = "delete from h_permission where AdminID = '".mysql_real_escape_string($AdminID)."'";
			$rs = $this->query($sql,0);
		}

		return true;
	}


	function changeAdminStatus($AdminID)
	{
		if(!empty($AdminID)){
			$sql="select AdminID,Status from admin where AdminID= '".mysql_real_escape_string($AdminID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
				$Status=0;
				else
				$Status=1;

				$sql="update admin set Status='".$Status."' where AdminID= '".$AdminID."'";
				$this->query($sql,0);
			}
		}

		return true;

	}

	function addAdmin($arryDetails)
	{
		@extract($arryDetails);
		$sql = "insert into admin (Name,Username,Password,Status, AdminEmail) values('".addslashes($Name)."','".$AdminUsername."', '".$AdminPassword."','".$Status."', '".$AdminEmail."')";
		$rs = $this->query($sql,0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}

	function UpdateAdmin($arryDetails){
		extract($arryDetails);
		if(!empty($AdminUserID)){
			$strSQL = "update admin set Name='".addslashes($Name)."',Username='".$AdminUsername."', Password='".$AdminPassword."', AdminEmail='".$AdminEmail."', Status='".$Status."' where AdminID='".$AdminUserID."'";
			$this->query($strSQL, 0);
		}

		return 1;
	}


	function isAdminExists($Username,$AdminID)
	{
		$sql ="select * from admin where LCASE(Username) = '".strtolower(trim($Username))."'";
		$sql .= (!empty($AdminID))?(" and AdminID != '".$AdminID."'"):("");

		$arryRow = $this->query($sql, 1);
		if (!empty($arryRow[0]['AdminID'])) {
			return true;
		} else {
			return false;
		}
	}

	/******** Validate Admin Modules ******/
	/**************************************/
	function GetAdminDetail($id=0){
		$strAddQuery = (!empty($id))?(" where EmpID='".mysql_real_escape_string($id)."'"):("");
		$strSQLQuery ="select EmpID, UserName, Email from h_employee ".$strAddQuery;
		return $this->query($strSQLQuery, 1);
	}
	function ValidateAdmin2($Email,$Password){
		$strSQLQuery ="select EmpID,Email, Password, UserName from h_employee where Email='".$Email."' and Password='".md5($Password)."' and Status='1' ";
		return $this->query($strSQLQuery, 1);
	}

	function getModuleID($AdminID,$Link,$depID, $NotEditPage){
		$Link =  mysql_real_escape_string(strip_tags($Link));
		$depID =  mysql_real_escape_string(strip_tags($depID));


		$strSQLQuery ="select m.*,p.Status as ParentStatus, p.Default as DefaultParent from admin_modules m left outer join admin_modules p on m.Parent=p.ModuleID where m.Parent>0";
		$strSQLQuery .= (!empty($Link))?(" and m.Link='".$Link."'"):("");
		//$strSQLQuery .= (!empty($NotEditPage))?(" and m.EditPage!=1"):("");

		//$strSQLQuery .= (!empty($AdminID))?(" and p.AdminID = '".$AdminID."'"):("");

		$strSQLQuery .= (!empty($depID))?(" and p.depID = '".$depID."'"):("");

		return $this->query($strSQLQuery, 1);
	}

	function getMainModules($EmpID,$Parent,$DepID){

		$OuterADD = (!empty($EmpID))?(" and p.EmpID='".$EmpID."'"):("");

		$strSQLQuery ="select m.*,p.EmpID,p.ViewLabel,p.ModifyLabel from admin_modules m left outer join h_permission p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default=0 and m.Status=1 and m.DepID='".$DepID."' group by m.ModuleID order by m.ModuleID asc";

		return $this->query($strSQLQuery, 1);
	}

	function getMainModulesUser($UserID,$Parent,$DepID){

		$OuterADD = (!empty($UserID))?(" and p.UserID='".$UserID."'"):("");

		$strSQLQuery ="select m.*,p.UserID,p.ViewLabel,p.ModifyLabel,p.FullLabel from admin_modules m left outer join permission p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default=0 and m.Status=1 and m.DepID='".$DepID."' group by m.ModuleID order by m.ModuleID asc";

		return $this->query($strSQLQuery, 1);
	}

	function getParentModuleID($ModuleID,$DepID){
		$strSQLQuery ="select * from admin_modules m where m.Status='1' ";
		$strSQLQuery .= ($DepID>0)?(" and m.DepID='".$DepID."'"):(" ");
		$strSQLQuery .= ($ModuleID>0)?(" and m.ModuleID='".$ModuleID."'"):(" ");

		return $this->query($strSQLQuery, 1);
	}

	function isModulePermitted($ModuleID,$EmpID)
	{
		if(!empty($ModuleID) && !empty($EmpID)){
			$sql ="select * from h_permission where ModuleID = '".$ModuleID."' and EmpID = '".$EmpID."'  ";
			return $this->query($sql, 1);
		}

	}

	function isModulePermittedUser($ModuleID,$UserID)
	{
		if(!empty($ModuleID) && !empty($UserID)){
			$sql ="select * from permission where ModuleID = '".$ModuleID."' and UserID = '".$UserID."'  ";
			return $this->query($sql, 1);
		}

	}

	function UpdateAdminModules($arryModules,$EmpID,$Role)
	{
		if(!empty($EmpID)){
			$sql = "delete from h_permission where EmpID ='".$EmpID."'";
			$rs = $this->query($sql,0);
			if($Role=="Admin"){
				if(sizeof($arryModules)>0){
					foreach($arryModules as $ModuleID){
						$sql = "insert into h_permission(EmpID,ModuleID) values('".$EmpID."', '".$ModuleID."')";
						$rs = $this->query($sql,0);
					}
				}
			}
		}

		return 1;

	}


	function GetDefaultMenus(){
		$strSQLQuery = "select ModuleID from admin_modules where (`Default`=1 and Parent=0) or ModuleID=195";
		return $this->query($strSQLQuery, 1);
	}

	function GetHeaderMenus($AdminID=0,$DepID,$Parent,$Level){
		global $Config;


		if($_SESSION['AdminType']!="admin"){
			if($Level==1){
				$strAddQuery = " where (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join h_permission p on m.ModuleID =p.ModuleID where p.EmpID='".$AdminID."'))";
			}else{
				$strAddQuery = " where 1 ";
			}

		}else{
			$strAddQuery = " where 1 ";
		}

		$strAddQuery .= ($Parent>0)?(" and m.Parent='".$Parent."'"):(" and m.Parent=0 ");
		$strAddQuery .= ($DepID>0)?(" and m.DepID='".$DepID."'"):(" and m.DepID=0 ");
		$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Default=0 "):(" ");
		$strSQLQuery ="select m.* from admin_modules m ".$strAddQuery.' and m.Status=1  order by m.ModuleID';

		return $this->query($strSQLQuery, 1);
	}


	function GetHeaderMenusUser($AdminID=0,$DepID,$Parent,$Level){
		global $Config;


		if($_SESSION['AdminType']!="admin"){
			if($Level==1){
				$strAddQuery = " where (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission p on m.ModuleID =p.ModuleID where p.UserID='".$AdminID."'))";
			}else{
				$strAddQuery = " where 1 ";
			}

		}else{
			$strAddQuery = " where 1 ";
		}

		$strAddQuery .= ($Parent>0)?(" and m.Parent='".$Parent."'"):(" and m.Parent=0 ");
		$strAddQuery .= ($DepID>0)?(" and m.DepID='".$DepID."'"):(" and m.DepID=0 ");
		$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Default=0 "):(" ");
		$strSQLQuery ="select m.* from admin_modules m ".$strAddQuery.' and m.Status=1 Order by Case When m.OrderBy>0 Then 0 Else 1 End,m.OrderBy,m.ModuleID';

		return $this->query($strSQLQuery, 1);
	}



	function GetHeaderTopLink($Parent){
		//$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Status=1 "):("");
		$strAddQuery .= " and m.Status=1 ";
		$strSQLQuery = "select m.Link from admin_modules m where  m.Parent='".$Parent."'".$strAddQuery." Order by Case When m.OrderBy>0 Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 ";
		return $this->query($strSQLQuery, 1);
	}

	function GetSiteSettings($ConfigID=1){
		$strAddQuery = (!empty($ConfigID))?(" where ConfigID='".$ConfigID."'"):("");
		$strSQLQuery ="select * from configuration".$strAddQuery;
		return $this->query($strSQLQuery, 1);
	}

	function CheckDet()
	{
		$allow = mysql_real_escape_string(md5(md5($_SERVER['REMOTE_ADDR'])));
		$sql="SELECT ID FROM det WHERE allow='".$allow."' ";
		$rs = $this->query($sql);
		if($rs[0]['ID']>0){
			return true;
		}else{
			return false;
		}
	}

	function GetTutorial($ConfigID=1){
		$strAddQuery = (!empty($ConfigID))?(" where ConfigID='".$ConfigID."'"):("");
		$strSQLQuery ="select tutorial from configuration".$strAddQuery;
		return $this->query($strSQLQuery, 1);
	}


	function GetAllowedDepartment($AdminID=0){
		global $Config;

		$strAddQuery = " where 1 ";

		if(!empty($Config['CmpDepartment'])) $strAddQuery .= " and d.depID in (".$Config['CmpDepartment'].")";

		$strAddQuery .= " and (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join h_permission p on m.ModuleID =p.ModuleID where p.EmpID='".$AdminID."'))";

		$strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery.' and m.Status=1  order by m.ModuleID';

		return $this->query($strSQLQuery, 1);
	}

	function GetAllowedDepartmentUser($AdminID=0){
		global $Config;

		$strAddQuery = " where 1 ";

		if(!empty($Config['CmpDepartment'])) $strAddQuery .= " and d.depID in (".$Config['CmpDepartment'].")";

		$strAddQuery .= " and (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission p on m.ModuleID =p.ModuleID where p.UserID='".$AdminID."'))";

		$strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery.' and m.Status=1  order by m.ModuleID';

		return $this->query($strSQLQuery, 1);
	}

	function GetDateFormat(){
		$strSQLQuery ="select DateFormat from date_format where Status=1";
		return $this->query($strSQLQuery, 1);
	}
	function  GetDepartment()
	{
		$sql = "select * from department where Status=1 order by depID asc ";
		return $this->query($sql, 1);

	}
	function UpdateSiteSettings($arryDetails){
		extract($arryDetails);



		$strSQL = "update configuration set SiteName='".addslashes($SiteName)."', SiteTitle='".addslashes($SiteTitle)."', SiteEmail='".addslashes($SiteEmail)."',FlashWidth='".$FlashWidth."',FlashHeight='".$FlashHeight."', RecordsPerPage='".$RecordsPerPage."', MemberApproval='".$MemberApproval."', RecieveSignEmail='".$RecieveSignEmail."', PostingApproval='".$PostingApproval."', FeaturedStorePrice='".$FeaturedStorePrice."', MaxPartnerLimit='".$MaxPartnerLimit."',   BannerHome='".$BannerHome."', BannerRight='".$BannerRight."',Tax='".addslashes($Tax)."', Shipping='".addslashes($Shipping)."'  where ConfigID='".$ConfigID."'";

		$this->query($strSQL, 0);

		$strSQLQuery = "update configuration set MyGate_Mode='".$MyGate_Mode."', MyGate_MerchantID='".addslashes($MyGate_MerchantID)."', MyGate_ApplicationID='".addslashes($MyGate_ApplicationID)."', AccountHolder='".addslashes($AccountHolder)."', AccountNumber='".addslashes($AccountNumber)."',
			BankName='".addslashes($BankName)."',
			BranchCode='".addslashes($BranchCode)."',
			SwiftNumber='".addslashes($SwiftNumber)."',
			MyGatePayment='".$MyGatePayment."',
			PaypalPayment='".$PaypalPayment."',
			EftPayment='".$EftPayment."',
			DepositPayment = '".$DepositPayment."',
			PaypalID = '".$PaypalID."',
			WebsitePrice = '".$WebsitePrice."',
			StorePrice = '".$StorePrice."',
			WebsiteStorePrice = '".$WebsiteStorePrice."',
			BlogAbuseWords='".addslashes($BlogAbuseWords)."',
			MetaKeywords='".addslashes($MetaKeywords)."',
			MetaDescription='".addslashes($MetaDescription)."'
			where ConfigID='".$ConfigID."' "; 

		$this->query($strSQLQuery, 0);


		return 1;
	}

	function UpdateFlash($HomeFlash,$OldFlash){

		if($OldFlash !='' && file_exists('../flash/'.$OldFlash) ){
			unlink('../flash/'.$OldFlash);
		}
		$strSQL = "update configuration set HomeFlash='".$HomeFlash."' where ConfigID=1";
		$this->query($strSQL, 0);
		return 1;
	}

	function UpdateImage($SiteLogo,$FieldName){
		$strSQL = "update configuration set ".$FieldName."='".$SiteLogo."' where ConfigID=1";
		$this->query($strSQL, 0);
		return 1;
	}



	function UpdateTutorialFile($tutorial,$OldTutorial){

		if($OldTutorial !='' && file_exists('../includes/'.$OldTutorial) ){
			unlink('../includes/'.$OldTutorial);
		}

		$strSQL = "update configuration set tutorial='".$tutorial."' where ConfigID=1";
		$this->query($strSQL, 0);
		return 1;
	}

	function GetNumUsers(){
		$strSQLQuery = "select count(*) as NumRegisteredUsers from members where deleted=0";
		return $this->query($strSQLQuery, 1);
	}

	function GetPaymentGateways(){
		$strSQLQuery = "select *  from payment_gateway";
		return $this->query($strSQLQuery, 1);
	}

	function GetSignature($PageID=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($PageID))?(" and PageID = '".mysql_real_escape_string($PageID)."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from contents ".$sql." order by PageID asc" ;
		return $this->query($sql, 1);
	}

	function  GetFonts()
	{
		$sql = "select * from fonts ";
		return $this->query($sql, 1);

	}

	function  GetFontSize()
	{
		$sql = "select * from font_size ";
		return $this->query($sql, 1);

	}

	/*******************************************/
	/*******************************************/

	function isCmpEmailExists($Email,$CmpID=0)
	{
		$CheckDuplicay = 1; //Add Case
		/**********Company/Employee Check****************/
		if(!empty($CmpID)){
			$sql = "select Email from user_email where CmpID='".$CmpID."' and RefID=0";			$arryEmail = $this->query($sql, 1);

			if($arryEmail[0]['Email']==$Email){
				$CheckDuplicay = 0;
			}
		}
			
		if($CheckDuplicay==1){
			$strSQLQuery = "select ID from user_email where LCASE(Email)='".strtolower(trim($Email))."'";


			$arryRow = $this->query($strSQLQuery, 1);
			$IdExist = $arryRow[0]['ID'];
		}
		/***********************************************/
		/**********Customer/Vendor Check****************/
		if(empty($IdExist)){
			if($CheckDuplicay==1){
				$strSQLQuery2 = "select id from company_user where LCASE(user_name)='".strtolower(trim($Email))."'";
				$arryRow = $this->query($strSQLQuery2, 1);
				$IdExist = $arryRow[0]['id'];
			}

		}
		/***********************************************/
		if(!empty($IdExist)){
			return true;
		} else {
			return false;
		}
	}

	function isUserEmailDuplicate($arryDetails)
	{
		//print_r($arryDetails);exit;
		extract($arryDetails);
			
		$CheckDuplicay = 1; //Add Case
			
		/**********Company/Employee Check****************/
		if(!empty($RefID) && !empty($CmpID)){
			$sql = "select Email from user_email where CmpID='".$CmpID."' and RefID='".$RefID."' ";				$arryEmail = $this->query($sql, 1);
			if($arryEmail[0]['Email']==$Email){
				$CheckDuplicay = 0;
			}
		}
		if($CheckDuplicay==1){
			$strSQLQuery = "select ID from user_email where LCASE(Email)='".strtolower(trim($Email))."'";

			$arryRow = $this->query($strSQLQuery, 1);
			$IdExist = $arryRow[0]['ID'];
		}
		/***********************************************/
		/**********Customer/Vendor Check****************/
		if(empty($IdExist)){
			$user_type = strtolower($user_type);
			if(!empty($ref_id) && !empty($CmpID)){ //not verified
				$sql2 = "select user_name from company_user where comId='".$CmpID."' and ref_id='".$ref_id."' and user_type='".$user_type."'  ";
				$arryEmail = $this->query($sql2, 1);

				if($arryEmail[0]['user_name']==$Email){
					$CheckDuplicay = 0;
				}
			}
			if($CheckDuplicay==1){
				$strSQLQuery2 = "select id from company_user where LCASE(user_name)='".strtolower(trim($Email))."'";
				if(!empty($user_type)){$strSQLQuery2.= " and user_type='".$user_type."'"; }

				$arryRow = $this->query($strSQLQuery2, 1);
				$IdExist = $arryRow[0]['id'];
			}

		}
		/***********************************************/

		if(!empty($IdExist)){
			return true;
		} else {
			return false;
		}
	}

	function isUserEmailExists($Email,$RefID=0,$CmpID)
	{
		$CheckDuplicay = 1; //Add Case
		if(!empty($RefID) && !empty($CmpID)){
			$sql = "select Email from user_email where CmpID='".$CmpID."' and RefID='".$RefID."' ";		$arryEmail = $this->query($sql, 1);
			if($arryEmail[0]['Email']==$Email){
				$CheckDuplicay = 0;
			}
		}
			
		if($CheckDuplicay==1){
			$strSQLQuery = "select ID from user_email where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);
		}


		if (!empty($arryRow[0]['ID'])) {
			return true;
		} else {
			return false;
		}
	}


	function addUserEmail($CmpID,$RefID,$Email)
	{
		$sql = "insert ignore into user_email (CmpID, RefID, Email) values('".$CmpID."', '".$RefID."', '".addslashes($Email)."')";
		$rs = $this->query($sql,0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;
	}

	function UpdateCmpEmail($CmpID,$Email){
		if(!empty($CmpID) && !empty($Email)){
			$strSQLQuery = "update user_email set Email='".addslashes($Email)."' where CmpID='".$CmpID."' and RefID='0'";
			$this->query($strSQLQuery, 0);
		}
		return 1;
	}


	function UpdateUserEmail($CmpID,$RefID,$Email){
		if(!empty($CmpID) && !empty($RefID) && !empty($Email)){
			$strSQLQuery = "update user_email set Email='".addslashes($Email)."' where CmpID='".$CmpID."' and RefID='".$RefID."'";
			$this->query($strSQLQuery, 0);
		}
		return 1;
	}


	function RemoveUserEmail($Email)
	{
		if(!empty($Email)){
			$strSQLQuery = "delete from user_email where LCASE(Email)='".strtolower(trim($Email))."'";
			$this->query($strSQLQuery, 0);
		}
		return 1;
	}

	function CheckUserEmail($Email){
		if(!empty($Email)){
			$strSQLQuery = "select u.*,c.DisplayName, c.Department, c.ExpiryDate,c.LicenseKey,c.LoginBlock,LoginIP from user_email u inner join company c on u.CmpID=c.CmpID where MD5(LCASE(u.Email))='".md5(strtolower(trim($Email)))."'";
			return $this->query($strSQLQuery, 1);
		}
	}



	/************Block Login****************/
	/*******************************************/
	function AddBlockLogin($LoginType)
	{
		$strSQLQuery = "select blockID from user_block where LoginType='".$LoginType."'";
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]["blockID"])){
			$strSQL = "update user_block set LoginTime='".time()."' where blockID='".$arryRow[0]["blockID"]."'";
			$this->query($strSQL, 0);
		}else{
			$strSQLQuery = "insert into user_block (LoginTime, LoginIP, LoginType) values( '".time()."', '".$_SERVER["REMOTE_ADDR"]."', '".$LoginType."')";
			$this->query($strSQLQuery, 0);
		}

		return true;
	}

	function CheckBlockLogin($LoginType)
	{
		$strSQLQuery = "select LoginTime from user_block where LoginType='".$LoginType."' and LoginIP='".$_SERVER["REMOTE_ADDR"]."'";
		$arryRow = $this->query($strSQLQuery, 1);

		if((time() - $arryRow[0]['LoginTime']) > 3600) {
			return false; //allow
		} else {
			return true;
		}

			
	}

	function RemoveBlock($LoginType)
	{
		$strSQLQuery = "delete from user_block where LoginType='".$LoginType."' and LoginIP='".$_SERVER["REMOTE_ADDR"]."'";
		$this->query($strSQLQuery, 0);
			
		return 1;
	}




	function  GetBlockIP($key)
	{
		$strSQLQuery = "select * from user_block where 1 ";
		$strSQLQuery .= (!empty($key))?(" and LoginIP like '%".$key."%' "):("");
		$strSQLQuery .= " order by  blockID desc";
		return $this->query($strSQLQuery, 1);
	}

	function RemoveBlockIP($blockID)
	{
		$strSQLQuery = "delete from user_block where blockID='".$blockID."'";
		$this->query($strSQLQuery, 0);
			
		return 1;
	}

	function GetCompanyBySecuredID($Cmp){
		if(!empty($Cmp)){
			$strSQLQuery ="select * from company where MD5(CmpID) ='".$Cmp."' and Status=1 ";
			return $this->query($strSQLQuery, 1);
		}
	}


	function getEmployeeRoleID($EmpID){
		if($EmpID>0){
			$strSQLQuery ="SELECT h.GroupID,g.group_name FROM h_employee h inner join h_role_group g on h.GroupID=g.GroupID WHERE h.EmpID= '".$EmpID."' and g.Status=1";
			return $this->query($strSQLQuery, 1);
		}
	}

	function GetAllowedDepartmentGroup($GroupID=0){
		global $Config;

		$strAddQuery = " where 1 ";

		if(!empty($Config['CmpDepartment'])) $strAddQuery .= " and d.depID in (".$Config['CmpDepartment'].")";

		$strAddQuery .= " and (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission_group p on m.ModuleID =p.ModuleID where p.GroupID='".$GroupID."'))";

		$strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery.' and m.Status=1  order by m.ModuleID';

		return $this->query($strSQLQuery, 1);
	}



	function GetHeaderMenusUserGroup($GroupID=0,$DepID,$Parent,$Level){
		global $Config;


		if($_SESSION['AdminType']!="admin"){
			if($Level==1){
				$strAddQuery = " where (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission_group p on m.ModuleID =p.ModuleID where p.GroupID='".$GroupID."'))";
			}else{
				$strAddQuery = " where 1 ";
			}

		}else{
			$strAddQuery = " where 1 ";
		}

		$strAddQuery .= ($Parent>0)?(" and m.Parent='".$Parent."'"):(" and m.Parent=0 ");
		$strAddQuery .= ($DepID>0)?(" and m.DepID='".$DepID."'"):(" and m.DepID=0 ");
		$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Default=0 "):(" ");
		$strSQLQuery ="select m.* from admin_modules m ".$strAddQuery.' and m.Status=1 Order by Case When m.OrderBy>0 Then 0 Else 1 End,m.OrderBy,m.ModuleID';

		return $this->query($strSQLQuery, 1);
	}

	function isModulePermittedRoleGroup($ModuleID,$GroupID)
	{
			
		if(!empty($ModuleID) && !empty($GroupID)){
			$sql ="select * from permission_group where ModuleID = '".$ModuleID."' and GroupID = '".$GroupID."'  ";
			return $this->query($sql, 1);
		}

	}


	/**********************************************/
	/**************Start Email ************/
	//function added for creating inbox,draft count in left menu email section

	function CountTotalFolderEmails($FolderID)
	{
		$strSQLQuery = "select count(autoId) as totalEmail from importedemails where FolderId='".$FolderID."' and Status=1 ";
		$arryRow=$this->query($strSQLQuery, 1);
			
		if($arryRow[0]['totalEmail'] > 0) {
			return $arryRow[0]['totalEmail'];
		}else {
			return 0;
		}
	}



	function updateSendMailStatus($id) {
		if($id>0){
			$sql = "update importedemails set Status = 0 where autoId='".$id."' ";
			return $this->query($sql, 1);
		}
	}

	function GetEmailListId($adminId, $compId) {

		$sel_query = "select id,EmailId from importemaillist where AdminID='".$adminId."' and CompID='".$compId."' and status=1 and DefalultEmail=1";
		return $this->query($sel_query, 1);
	}

	function ListUnReadInboxEmails($ownerId)
	{

		$GetEmailID_qry = "select EmailId from importemaillist where id='" . $ownerId . "'";
		$GetEmailID = $this->query($GetEmailID_qry, 1);
		$strSQLQuery = "select COUNT(autoId) as totalEmail from importedemails where To_Email='" . $GetEmailID[0][EmailId] . "' and MailType='Inbox' and Status=1 order by composedDate desc";


		$arryRow = $this->query($strSQLQuery, 1);

		if($arryRow[0]['totalEmail'] > 0) {
			return $arryRow[0]['totalEmail'];
		}else {
			return 0;
		}
	}


	function draftItems($AdminEmail, $ItemId, $activeEmailId) {

		$strQry = '';
		if (!empty($ItemId)) {
			$strQry = " and autoId='" . $ItemId . "'";
		}
		$select_qry = "select COUNT(autoId) as totalEmail from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strQry . " order by composedDate desc";
			
		$arryRow = $this->query($select_qry, 1);

		if($arryRow[0]['totalEmail'] > 0) {
			return $arryRow[0]['totalEmail'];
		}else {
			return 0;
		}
	}

	function ListFolderName($FolderId,$AdminId,$CompId) {

		$strQry = '';
		if (!empty($FolderId)) {
			$strQry = " and FolderId='" . $FolderId . "'";
		}
		$strSQLQuery = "select FolderId,FolderName from importedemailfolder where AdminID='".$AdminId."' and CompID='".$CompId."'" . $strQry . " order by FolderName asc";
			
		return $this->query($strSQLQuery, 1);


	}


	function ListImportEmailsBott($limit=5) {
		$strSQLQuery = "select autoId,Subject from importedemails  e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status=1 and l.DefalultEmail=1) where e.MailType='Inbox' and e.Status=1 order by e.composedDate desc limit 0,".$limit;

		return $this->query($strSQLQuery, 1);
	}

	function CountImportEmailsBott() {
		$strSQLQuery = "select COUNT(e.autoId) as totalEmail from importedemails e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status=1 and l.DefalultEmail=1) where e.MailType='Inbox' and e.Status=1";
		$arryRow = $this->query($strSQLQuery, 1);
		return $arryRow[0]['totalEmail'];
	}


	function ListImportEmailsDash() {
		$strSQLQuery = "select e.autoId,e.Subject,e.Status from importedemails  e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status=1 and l.DefalultEmail=1) where e.MailType='Inbox' order by e.composedDate desc limit 0, 50";

		return $this->query($strSQLQuery, 1);
	}


	function GetWorkspaceEmail($campType) {
		$arryDate = explode(" ",$_SESSION['TodayDate']);

		$strSQLQuery = "select e.autoId,e.Subject,e.Status from importedemails  e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status=1 and l.DefalultEmail=1) where e.MailType='Inbox' ";


		switch($campType){
			case 'Top':
				break;
			case 'Daily':
				$strSQLQuery .= " and DATE_FORMAT(composedDate, '%Y-%m-%d')='".$arryDate[0]."' ";
				break;
			case 'Weekly':
				$strSQLQuery .= " and WEEKOFYEAR(DATE_FORMAT(composedDate, '%Y-%m-%d'))=WEEKOFYEAR('".$arryDate[0]."') ";
				break;
			case 'Monthly':
				$strSQLQuery .= " and month(DATE_FORMAT(composedDate, '%Y-%m-%d'))=month('".$arryDate[0]."') ";
				break;
			case 'Yearly':
				$strSQLQuery .= " and year(DATE_FORMAT(composedDate, '%Y-%m-%d'))=year('".$arryDate[0]."') ";
				break;
		}

		$strSQLQuery .= " order by e.composedDate desc limit 0, 50";
		//echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}




	/**************End Email ************/
	/**********************************************/
	function countBlockRows(){
		global $Config;
			
		$strSQLQuery = "SELECT COUNT(v.id) as totalID FROM `blocks_view` v inner join `blocks` b on v.BlockID=b.BlockID where v.AdminID = '".$_SESSION['AdminID']."' and v.AdminType='".$_SESSION['AdminType']."' and b.Status=1 and v.Status=1 and b.depID='".$Config['CurrentDepID']."' ORDER BY v.`OrderBy` ASC";

		$arryRow = $this->query($strSQLQuery, 1);
		if($arryRow[0]['totalID'] > 0) {
			return $arryRow[0]['totalID'];
		}else {
			return 0;
		}
	}



	function moveDefaultBlocks(){
		global $Config;
		$strSQLQuery = "SELECT * FROM `blocks` where depID='".$Config['CurrentDepID']."' ";
		$arryRow = $this->query($strSQLQuery, 1);
		foreach($arryRow as $keyBlock=>$valueBlock){
			$sql = "insert into `blocks_view`(BlockID, OrderBy, UpdatedDate, AdminID, AdminType, Status) values('".addslashes($valueBlock['BlockID'])."', '".addslashes($valueBlock['OrderBy'])."', '".date('Y-m-d H:i:s')."','".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".addslashes($valueBlock['Status'])."')";
			$rs = $this->query($sql,0);
		}
		return true;
	}


	function getBlockRows($Status){
		global $Config;
		$strSQLQuery = "SELECT v.id,v.BlockID,v.OrderBy,v.Width,v.Height,v.Left,v.Top,b.Block, b.BlockHeading FROM `blocks_view` v inner join `blocks` b on v.BlockID=b.BlockID where v.AdminID = '".$_SESSION['AdminID']."' and v.AdminType='".$_SESSION['AdminType']."' and b.Status=1 and v.Status='".$Status."' and b.depID='".$Config['CurrentDepID']."' ORDER BY v.`OrderBy` ASC";
		return $this->query($strSQLQuery, 1);
	}

	function updateBlockOrder($id_array){
		global $Config;
		$count = 1;
		foreach ($id_array as $id){
			$strSQLQuery = "UPDATE `blocks_view` SET OrderBy = '".$count."', UpdatedDate = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
			$this->query($strSQLQuery, 0);
			$count ++;
		}
		return true;
	}

	function updateBlockStatus($id,$Status){
		$strSQLQuery = "UPDATE `blocks_view` SET Status = '".$Status."' WHERE id in (".$id.") ";
		$this->query($strSQLQuery, 0);
		return true;
	}

	function updateBlockSize($id,$Width,$Height){
		$strSQLQuery = "UPDATE `blocks_view` SET Width = '".$Width."',Height = '".$Height."' WHERE id = '".$id."' ";
		$this->query($strSQLQuery, 0);
		return true;
	}
	function updateBlockPosition($id,$Top,$Left){
		$strSQLQuery = "UPDATE `blocks_view` SET `Top` = '".$Top."', `Left` = '".$Left."' WHERE id = '".$id."' ";
		$this->query($strSQLQuery, 0);
		return true;
	}

	function updateScreeStatus(){
		$arryRow = $this->getDefaultScreen();
		$count=sizeof($arryRow);
		if($count>0){
			if($arryRow[0]['Status']==1) $Status=0;
			else $Status=1;
			$strSQLQuery = "UPDATE `default_screen` SET Status ='".$Status."' where AdminID = '".$_SESSION['AdminID']."' and AdminType='".$_SESSION['AdminType']."'";
			$this->query($strSQLQuery, 0);
		}else{
			$Status=1;
			$sql = "insert into `default_screen`(ScreenID, OrderBy, UpdatedDate, AdminID, AdminType, Status) values('1', '', '".date('Y-m-d H:i:s')."','".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '1')";
			$rs = $this->query($sql,0);
		}
		return $Status;

	}


	function getDefaultScreen(){
		$strSQLQuery = "SELECT * FROM `default_screen`  where AdminID = '".$_SESSION['AdminID']."' and AdminType='".$_SESSION['AdminType']."' ";
		return $this->query($strSQLQuery, 1);
	}



	function isChatActive(){
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `ModuleID` = 182 and Status=1 ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}

	}
	function isEmailActive(){
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `ModuleID` = '2025' and Status=1 ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}

	}

	// Added by karishma for editable field on 2 feb 2016
	function getField($tblName,$fieldName,$ID,$IDVal, $fieldType,$selecttbl,$selectfield,$selectfieldType,$relatedField ){
		
		global $Config;
		$save = '<img src="'.$Config['Url'].'admin/images/save.png" border="0"  onMouseover="ddrivetip(\'<center>Save</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
		switch($fieldType){
			case 'text':
				$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
				$field="<div class='editable_inputdiv'><input type='text' name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' value='".$FieldVal."'/></div>
				<div class='editable_savebutdiv'><span class='saveevenbg' id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";
				break;
			case 'number':
				$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
				$field="<div class='editable_inputdiv'><input type='text' onkeypress='return isNumberKey(event)' name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' value='".$FieldVal."'/></div>
				<div class='editable_savebutdiv'><span class='saveevenbg' id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";
				break;
			case 'email':
				$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
				$field="<div class='editable_inputdiv'>
				<input type='text' name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' value='".$FieldVal."'/>
				</div>
				<div class='editable_savebutdiv'><span class='saveevenbg' id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";
				break;
			case 'select':
				$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
				if($selecttbl=='attribute'){
					if($fieldName=='lead_status' || $fieldName=='SalesStage' || $fieldName=='lead_source' || $fieldName=='LeadSource' || strtolower($fieldName)=='status' || $fieldName=='priority' || $fieldName== 'category' || $fieldName== 'activityType' || $fieldName=='campaignstatus' || $fieldName=='campaigntype' || $fieldName=='expectedresponse' || $fieldName=='OpportunityType'){
						$objCommon = new common();
						$arryVal = $objCommon->GetCrmAttribute($selectfield, '');
					}
				 elseif($fieldName == 'CustID')
                                {
                                	$arryVal = $this->GetCustomerList();                                   
                                		
                                }
					elseif($fieldName=='PaymentMethod'){
						$arryVal = $this->GetAttribFinance($fieldName);

					}
					elseif($fieldName=='ShippingMethod'){
						$arryVal = $this->GetShipAttribValue($fieldName);

					}
					elseif($fieldName=='PaymentTerm'){
						$arryVal = $this->GetTerm('','1');

					}
					elseif($fieldName=='country_id'){
						$arryVal = $this->GetCountry();

					}elseif($fieldName=='RelatedType'){
						$arryVal[]['attribute_value']= 'Lead';
						$arryVal[]['attribute_value']= 'Opportunity';
						$arryVal[]['attribute_value']= 'Campaign';
						$arryVal[]['attribute_value']= 'Ticket';
						$arryVal[]['attribute_value']= 'Quote';

					}elseif($fieldName=='product'){
						$arryVal = $this->GetItems();

					}elseif($fieldName=='CustType'){	
						$arryVal[]=array('ID'=>'o','attribute_value'=>'Opportunity'); 	
						$arryVal[]=array('ID'=>'c','attribute_value'=>'Customer'); 				
						
						

					}else{
						$arryVal = $this->GetCustomFieldById($selectfield);

					}
					$field="<div class='editable_inputdiv'><select name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' >
					<option value=''>--Select---</option>";

					if($selectfieldType=='int'){

						for ($i = 0; $i < sizeof($arryVal); $i++)
						{
							$select ='';
							if($FieldVal== $arryVal[$i]['ID']) { $select = "selected=selected";}
							$field .= '<option value="'.$arryVal[$i]['ID'].'" '.$select.'>'.$arryVal[$i]['attribute_value'].'</option>';
						}

					}else{
						for ($i = 0; $i < sizeof($arryVal); $i++)
						{
							$select ='';
							if($FieldVal== $arryVal[$i]['attribute_value']) { $select = "selected=selected";}
							$field .= '<option value="'.$arryVal[$i]['attribute_value'].'" '.$select.'>'.$arryVal[$i]['attribute_value'].'</option>';
						}
					}




					$field .="</select></div>
				<div class='editable_savebutdiv'>
				<span class='saveevenbg' id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";

				}
				elseif($selecttbl=='Currency'){

					if($Config['AdditionalCurrency']!=''){
					$arryVal = explode(",",$Config['AdditionalCurrency']);
					}else{
					$arryVal = explode(",",$Config['Currency']);
					}


					$field="<div class='editable_inputdiv'><select name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' >
					<option value=''>--Select---</option>";

					for ($i = 0; $i < sizeof($arryVal); $i++)
					{
						$select ='';
						if($FieldVal== $arryVal[$i]) { $select = "selected=selected";}
						$field .= '<option value="'.$arryVal[$i].'" '.$select.'>'.$arryVal[$i].'</option>';
					}
					$field .="</select></div>
				<div class='editable_savebutdiv'>
				<span class='saveevenbg' id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";

				}


				break;
			case 'multiselect':
				$is_multiple='multiple';
				if($fieldName=='AssignTo' || strtolower($fieldName)=='assignedto'){
					if($tblName=='s_address_book' || $tblName=='c_campaign'){
						$AssignTypeVal='Indivisual';
					}else {
						$AssignTypeVal=$this->getFieldVal($tblName,'AssignType',$ID,$IDVal);
					}

					if($AssignTypeVal=='Group'){
						$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
						//$GroupFieldVal=$this->getFieldVal($tblName,'GroupID',$ID,$IDVal);
						//echo $FieldVal=$FieldVal.':'.$GroupFieldVal;
						$is_multiple='';
						$objGroup = new group();
						$arryGroup = $objGroup->getGroup("", 1);
						$arryVal=array();

						for($i=0;$i<count($arryGroup);$i++){
							$arryVal[$i]['EmpID']=$arryGroup[$i]['group_user'] ;
							$arryVal[$i]['UserName']=$arryGroup[$i]['group_name'];
						}


						$field="<div class='editable_inputdiv'><select name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' ".$is_multiple." >
					<option value=''>--Select---</option>";

						for ($i = 0; $i < sizeof($arryVal); $i++)
						{
							$select ='';
							if($FieldVal==$arryVal[$i]['EmpID']) { $select = "selected=selected";}
							$field .= '<option value="'.$arryVal[$i]['EmpID'].'" '.$select.'>'.$arryVal[$i]['UserName'].'</option>';
						}
						$field .="</select></div>
				<div class='editable_savebutdiv'>
					<span class='saveevenbg' id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";

					}else{
						$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
						$arryVal = $this->AssignToUsersList();

						$FieldVal=explode(',',$FieldVal);


						$field="<div class='editable_inputdiv'><select name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' ".$is_multiple." >
					<option value=''>--Select Status---</option>";

						for ($i = 0; $i < sizeof($arryVal); $i++)
						{
							$select ='';
							if(in_array($arryVal[$i]['EmpID'],$FieldVal)) { $select = "selected=selected";}
							$field .= '<option value="'.$arryVal[$i]['EmpID'].'" '.$select.'>'.$arryVal[$i]['UserName'].'</option>';
						}
						$field .="</select></div>
				<div class='editable_savebutdiv'>
					<span class='saveevenbg' id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";

					}


				}



				break;
			case 'textarea':
				$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
				$field="<div class='editable_inputdiv'><textarea name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' >".$FieldVal."</textarea>
				</div>
				<div class='editable_savebutdiv'><span id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";
				break;
			case 'date':
				$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
				$class="class='editable_calender'";
				$field="<div class='editable_inputdiv'>
				<input name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='datebox' readonly=''  value='".$FieldVal."' />";
				if($relatedField!='' && $relatedField!='undefined'){
					$class="";
					$saveclass="savebtn";
					$FieldVal=$this->getFieldVal($tblName,$relatedField,$ID,$IDVal);
					$field .="&nbsp;&nbsp;&nbsp;<input name='".$relatedField.$IDVal."' id='input_".$relatedField.$IDVal."'  style='width:100px;'  class='inputbox' value='".$FieldVal."' />";	
				}
				$field .="</div>
				<div class='editable_savebutdiv ".$saveclass."'><span ".$class." id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\",\"$relatedField\");'>".$save."</span></div>";
				break;
			default:
				$FieldVal=$this->getFieldVal($tblName,$fieldName,$ID,$IDVal);
				$field="<div class='editable_inputdiv'><input type='text' name='".$fieldName.$IDVal."' id='input_".$fieldName.$IDVal."' class='inputbox' value='".$FieldVal."'/>
				</div>
				<div class='editable_savebutdiv'><span id='save_".$fieldName.$IDVal."' style='cursor: pointer;' onclick='saveField(\"$tblName\",\"$fieldName\",\"$ID\",\"$IDVal\",\"$fieldType\");'>".$save."</span></div>";
				break;

		}
		return $field;

	}

	function getFieldVal($tblName,$fieldName,$ID,$IDVal){
		global $Config;
		if($fieldName=='forecast_amount' || $fieldName=='Amount' || $fieldName=='AnnualRevenue') {			
			$strSQLQuery = "SELECT DECODE($fieldName,'". $Config['EncryptKey']."') as $fieldName FROM $tblName WHERE $ID = '".addslashes($IDVal)."'  ";
		}else{
			$strSQLQuery = "SELECT $fieldName FROM $tblName WHERE $ID = '".addslashes($IDVal)."'  ";
		}
		
		$arryRow = $this->query($strSQLQuery, 1);
		return $arryRow[0][$fieldName];
	}

	function saveField($tblName,$fieldName,$ID,$IDVal, $fieldType,$fieldNameVal,$relatedField,$relatedFieldVal){
		global $Config;
		
		if($fieldName=='forecast_amount' || $fieldName=='Amount' || $fieldName=='AnnualRevenue') {			
			$strSQLQuery = "UPDATE $tblName SET $fieldName =ENCODE('" .addslashes($fieldNameVal) . "','".$Config['EncryptKey']."')  where $ID = '".addslashes($IDVal)."' ";
		}else{
		$strSQLQuery = "UPDATE $tblName SET $fieldName ='".addslashes($fieldNameVal)."' where $ID = '".addslashes($IDVal)."' ";
		}
		if($this->query($strSQLQuery, 0)==0){
			if($relatedField!='' && $relatedField!='undefined'){
				$relatedSQLQuery = "UPDATE $tblName SET $relatedField ='".addslashes($relatedFieldVal)."' where $ID = '".addslashes($IDVal)."' ";
				$this->query($relatedSQLQuery, 0);
			}
			return true;
		}

		return false;

	}

	function AssignToUsersList(){
		$strSQLQuery = "SELECT EmpID,UserName from h_employee e
		left outer join  h_department d on e.Department=d.depID  
		WHERE e.Status=1 and  e.locationID=".$_SESSION['locationID'] ."  
		ORDER BY e.UserName DESC ";
		$arryRow = $this->query($strSQLQuery, 1);
		return $arryRow;
	}
	function GetCustomFieldById($selectfield){
		$strSQLQuery = "SELECT dropvalue from c_field	WHERE fieldid='".addslashes($selectfield)."' ";
		$arryRow = $this->query($strSQLQuery, 1);
		$arryVal=explode(',', $arryRow[0]['dropvalue']);
		foreach($arryVal as $key=>$val){
			$dropvalue[]['attribute_value']=$val;
		}
		return $dropvalue;
	}

	function GetCountry($country_id=''){
		$sql  = " where 1";
		$sql .= (!empty($country_id))?(" and country_id='".$country_id."'"):("");
		$strSQLQuery = "select name,country_id from erp.country ".$sql." ";
		$arryCountry= $this->query($strSQLQuery, 1);
		for($i=0;$i<count($arryCountry);$i++){
			$arryVal[$i]['ID']=$arryCountry[$i]['country_id'] ;
			$arryVal[$i]['attribute_value']=$arryCountry[$i]['name'];
		}
		return $arryVal;
	}
	function GetItems(){

		$strSQLQuery = "select p1.ItemID,p1.description,p1.Sku from inv_items p1
		left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID and p1.Status='1' 
		and c1.Status='1' where 1 order by p1.description  ";
		$arryProduct= $this->query($strSQLQuery, 1);
		for($i=0;$i<count($arryProduct);$i++){
			$arryVal[$i]['ID']=$arryProduct[$i]['ItemID'] ;
			$arryVal[$i]['attribute_value']=stripslashes($arryProduct[$i]['description']).'[Sku: '.stripslashes($arryProduct[$i]['Sku']).']';

		}
		return $arryVal;
	}

	function  GetAttribFinance($attribute_name,$OrderBy)
	{
			
		$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 "):("");

		$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

		$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

		return $this->query($strSQLQuery, 1);

	}

	function  GetTerm($termID,$Status)
	{

		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($termID))?(" and termID=".$termID):("");
		$strAddQuery .= ($Status>0)?(" and Status=".$Status):("");

		$strSQLQuery = "select * from f_term  ".$strAddQuery." order by termID Asc";

		$arryVal= $this->query($strSQLQuery, 1);
		foreach($arryVal as $key=>$val){
			$PaymentTerm = stripslashes($val['termName']).' - '.$val['Day'];
			$dropvalue[]['attribute_value']=$PaymentTerm;
		}
		return $dropvalue;
	}

	function  GetShipAttribValue($attribute_name,$OrderBy)
	{
			
		$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 "):("");

		$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

		$strSQLQuery = "select v.* from w_attribute_value v inner join w_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

		return $this->query($strSQLQuery, 1);
	}
	
function GetCustomerList($Cid){
	
		$strWhere = (!empty($Cid))?(" and Cid='".$Cid."'  "):("");
		$SqlCustomer = "SELECT Cid,CustCode,IF(CustomerType = 'Company' and Company!='', Company, FullName) as FullName FROM s_customers 
		where Status = 'Yes' ".$strWhere." having FullName!='' order by FullName";
	
		$arryCustomer= $this->query($SqlCustomer, 1);
		for($i=0;$i<count($arryCustomer);$i++){
			$arryVal[$i]['ID']=$arryCustomer[$i]['Cid'] ;
			$arryVal[$i]['attribute_value']=stripslashes($arryCustomer[$i]['FullName']);

		}
		return $arryVal;
	}
	// end by karishma for editable field on updated 2 feb 2016


}

?>
