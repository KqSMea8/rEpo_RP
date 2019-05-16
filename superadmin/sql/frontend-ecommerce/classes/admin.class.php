<?
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
				$strSQLQuery ="select * from admin where AdminEmail ='".$Email."' and Password='".md5($Password)."' and Status='1' ";
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
				$strSQLQuery = "select ModuleID from admin_modules where `Default`=1 and Parent=0";
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
			$strSQLQuery = "select m.Link from admin_modules m where  m.Parent=".$Parent.$strAddQuery.' Order by Case When m.OrderBy>0 Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 '; 
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



			$strSQL = "update configuration set SiteName='".addslashes($SiteName)."', SiteTitle='".addslashes($SiteTitle)."',FlashWidth='".$FlashWidth."',FlashHeight='".$FlashHeight."', RecordsPerPage='".$RecordsPerPage."', MemberApproval='".$MemberApproval."', RecieveSignEmail='".$RecieveSignEmail."', PostingApproval='".$PostingApproval."', FeaturedStorePrice='".$FeaturedStorePrice."', MaxPartnerLimit='".$MaxPartnerLimit."',   BannerHome='".$BannerHome."', BannerRight='".$BannerRight."',Tax='".addslashes($Tax)."', Shipping='".addslashes($Shipping)."'  where ConfigID='".$ConfigID."'";

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
			where ConfigID=".$ConfigID; 

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
				$strSQLQuery = "select u.*,c.DisplayName, c.Department, c.ExpiryDate,c.LicenseKey,c.LoginBlock,LoginIP from user_email u inner join company c on u.CmpID=c.CmpID where MD5(u.Email)='".md5($Email)."'"; 
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

}

?>
