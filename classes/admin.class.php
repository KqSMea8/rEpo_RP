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


			$strSQLQuery ="select m.*,p.Status as ParentStatus, p.Default as Restricted,p.depID,p.Restricted as RestrictedParent from admin_modules m left outer join admin_modules p on m.Parent=p.ModuleID where m.Parent>'0' and m.Status='1'";
			$strSQLQuery .= (!empty($Link))?(" and m.Link='".$Link."'"):("");
			//$strSQLQuery .= (!empty($NotEditPage))?(" and m.EditPage!='1'"):("");

			//$strSQLQuery .= (!empty($AdminID))?(" and p.AdminID = '".$AdminID."'"):("");

			$strSQLQuery .= (!empty($depID))?(" and p.depID = '".$depID."'"):("");

			return $this->query($strSQLQuery, 1);
		}

		function getMainModules($EmpID,$Parent,$DepID){

			$OuterADD = (!empty($EmpID))?(" and p.EmpID='".$EmpID."'"):("");

			$strSQLQuery ="select m.*,p.EmpID,p.ViewLabel,p.ModifyLabel from admin_modules m left outer join h_permission p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default='0' and m.Status='1' and m.DepID='".$DepID."' group by m.ModuleID order by m.ModuleID asc";

			return $this->query($strSQLQuery, 1);
		}

		function getMainModulesUser($UserID,$Parent,$DepID){

			$OuterADD = (!empty($UserID))?(" and p.UserID='".$UserID."'"):("");

			$strSQLQuery ="select m.*,p.UserID,p.ViewLabel,p.ModifyLabel,p.FullLabel from admin_modules m left outer join permission p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default='0' and m.Status='1' and m.DepID='".$DepID."' group by m.ModuleID order by m.ModuleID asc";

			return $this->query($strSQLQuery, 1);
		}
	

		function getMainModulesUserNew($UserID,$Parent,$DepID){

			$OuterADD = (!empty($UserID))?(" and p.UserID='".$UserID."'"):("");

			$strSQLQuery ="select m.*,p.UserID,p.ViewLabel,p.ModifyLabel,p.FullLabel,p.AddLabel,p.EditLabel,p.DeleteLabel,p.ApproveLabel from admin_modules m left outer join permission p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default='0' and m.Status='1' and m.DepID='".$DepID."' group by m.ModuleID order by m.ModuleID asc";

			return $this->query($strSQLQuery, 1);
		}

		function getParentModuleIDVal($UserID,$ModuleID){
        	
        		$OuterADD = (!empty($UserID))?(" and pm.UserID='".$UserID."'"):("");
			$strSQLQuery = "select am.*,pm.UserID, pm.ViewLabel,pm.ViewAllLabel, pm.ModifyLabel, pm.FullLabel, pm.AddLabel, pm.EditLabel, pm.DeleteLabel, pm.AssignLabel, pm.ApproveLabel from admin_modules am left outer join permission pm on (am.ModuleID=pm.ModuleID ".$OuterADD.") where am.Status='1' and am.Parent = '".$ModuleID."'  Order by Case When am.OrderBy>'0' Then 0 Else 1 End,am.OrderBy,am.ModuleID";
 
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
				global $Config;
				 
				$strSQLQuery = "select ModuleID from admin_modules where ((`Default`='1' and Parent='0')) "; 
				if(!empty($Config['CurrentDepID'])) 
					$strSQLQuery .= "and depID='".$Config['CurrentDepID']."'";

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

			$strAddQuery .= ($Parent>0)?(" and m.Parent='".$Parent."'"):(" and m.Parent='0' ");
			$strAddQuery .= ($DepID>0)?(" and m.DepID='".$DepID."'"):(" and m.DepID='0' ");
		 	$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Default='0' "):(" ");
			$strSQLQuery ="select m.* from admin_modules m ".$strAddQuery." and m.Status='1'  order by m.ModuleID"; 

			return $this->query($strSQLQuery, 1);
		 }


		 function GetHeaderMenusUser($AdminID=0,$DepID,$Parent,$Level){
			global $Config;

			$strAddsql00 = '';
			if($_SESSION['AdminType']!="admin"){
				if($Level==1){ 
					if($Config['CurrentDepID']==1 || $Config['CurrentDepID']==5){
						$strAddsql00 = "m.ModuleID in(".$Config['DefaultMenu'].") or " ;
					}

					$strAddQuery = " where ( ".$strAddsql00." m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission p on m.ModuleID =p.ModuleID where p.UserID='".$AdminID."'))";
				}else{
					$strAddQuery = " where 1 ";
				}
				
			}else{
				$strAddQuery = " where 1 ";
			}

			$strAddQuery .= ($Parent>0)?(" and m.Parent='".$Parent."'"):(" and m.Parent='0' ");
			$strAddQuery .= ($DepID>0)?(" and m.DepID='".$DepID."'"):(" and m.DepID='0' ");
		 	$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Default='0' "):(" ");
			$strSQLQuery ="select m.* from admin_modules m ".$strAddQuery." and m.Status='1' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID"; 

			return $this->query($strSQLQuery, 1);
		 }

		function GetHeaderMenusUserNew($AdminID=0,$DepID,$Parent,$Level){
			global $Config;
			if(empty($DepID)) $DepID=0;	
			$strAddsql00 = '';
			if($Level==1){  //Header Menu				
				if($_SESSION['AdminType']=="admin"){ //admin
					if($Config['CurrentDepID']==5){
						$strAddsql00 = " m.ModuleID in(".$Config['DefaultMenu'].") or ";
					}
										 
					$strSQLQuery ="select m.* from admin_modules m where ".$strAddsql00." ( m.Status='1' and m.Default='0' and m.DepID='".$DepID."' and Parent='0' ) Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID"; 						
				}else{ //User
					if($Config['CurrentDepID']==1 || $Config['CurrentDepID']==5){
						$strAddsql00 = " m.ModuleID in(".$Config['DefaultMenu'].") or ";
					} 
					$strSQLQuery ="select m.* from admin_modules m where ".$strAddsql00." m.ModuleID in (select distinct(m.Parent) from admin_modules m where m.ModuleID in (select distinct(m.ModuleID) from admin_modules m inner join permission p on m.ModuleID =p.ModuleID where p.UserID='".$AdminID."')) and m.Status='1' and m.DepID='".$DepID."' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID"; 
				}	
				
				
			}else{ //Left Menu
				
				if($_SESSION['AdminType']=="admin"){ //admin
					$strSQLQuery ="select distinct m.* from admin_modules m where m.Status='1' and m.DepID='0' and m.Default='0' and m.Parent='".$Parent."'  Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID";

				}else{//User
					$strSQLQuery ="select distinct m.* from admin_modules m left outer join admin_modules m2 on m.Parent=m2.ModuleID left outer join permission pm on (m.ModuleID=pm.ModuleID and pm.UserID='".$AdminID."') where m.Status='1' and m.Parent='".$Parent."'  and m.DepID='0' and (pm.UserID>'0' or m2.Default='1' ) Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID";
				}
			}		

			return $this->query($strSQLQuery, 1);
		 }


		function GetHeaderMenusUserGroupNew($GroupID=0,$DepID,$Parent,$Level){
			global $Config;
			if(empty($DepID)) $DepID=0;

			$strAddsql00 ='';
	
			if($Level==1){  //Header Menu				
				if($_SESSION['AdminType']=="admin"){ //admin
					if($Config['CurrentDepID']==5){
						$strAddsql00 = " m.ModuleID in(".$Config['DefaultMenu'].") or ";
					}
									 
					$strSQLQuery ="select m.* from admin_modules m where ".$strAddsql00." ( m.Status='1' and m.Default='0' and m.DepID='".$DepID."' and Parent='0' ) Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID"; 				
				}else{ //User
					if($Config['CurrentDepID']==1 || $Config['CurrentDepID']==5){
						$strAddsql00 = " m.ModuleID in(".$Config['DefaultMenu'].") or ";
					} 
					$strSQLQuery ="select m.* from admin_modules m where ".$strAddsql00." m.ModuleID in (select distinct(m.Parent) from admin_modules m where m.ModuleID in (select distinct(m.ModuleID) from admin_modules m inner join permission_group p on m.ModuleID =p.ModuleID where p.GroupID='".$GroupID."')) and m.Status='1' and m.DepID='".$DepID."' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID"; 

				}		
				 
				
			}else{ //Left Menu
				
				if($_SESSION['AdminType']=="admin"){ //admin
					$strSQLQuery ="select distinct m.* from admin_modules m where m.Status='1' and m.DepID='0' and m.Default='0' and m.Parent='".$Parent."'  Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID";

				}else{//User
					$strSQLQuery ="select distinct m.* from admin_modules m left outer join admin_modules m2 on m.Parent=m2.ModuleID left outer join permission_group pm on (m.ModuleID=pm.ModuleID and pm.GroupID='".$GroupID."') where m.Status='1' and m.Parent='".$Parent."'  and m.DepID='0' and (pm.GroupID>'0' or m2.Default='1' ) Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID";
				}
			}		

			return $this->query($strSQLQuery, 1);
		 }


		function GetHeaderTopLink($Parent){
		 	//$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Status='1' "):("");
		 	$strAddQuery .= " and m.Status='1' ";
			$strSQLQuery = "select m.Link from admin_modules m where  m.Parent='".$Parent."'".$strAddQuery." Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 "; 
			return $this->query($strSQLQuery, 1);
		 }

		function GetHeaderTopLinkNew($Parent,$Default=0,$GroupID=0){
			global $Config;
 
		 	if($_SESSION['AdminType']=="admin" || $Default==1){		 	
				$strSQLQuery = "select m.Link from admin_modules m where  m.Parent='".$Parent."'  and m.Status='1' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 "; 
			}else if($GroupID>0){
				$strSQLQuery = " select m.Link from admin_modules m inner join permission_group p on (m.ModuleID=p.ModuleID and p.GroupID='".$GroupID."' ) where  m.Parent='".$Parent."' and  m.Status='1' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 "; 
			}else{
				$strSQLQuery = " select m.Link from admin_modules m inner join permission p on (m.ModuleID=p.ModuleID and p.UserID='".$_SESSION['UserID']."' ) where  m.Parent='".$Parent."' and  m.Status='1' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 "; 
			}

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
		 	
			$strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery." and m.Status='1'  order by m.ModuleID"; 

			return $this->query($strSQLQuery, 1);
		 }

		function GetAllowedDepartmentUser($AdminID=0){
			global $Config;

			$strAddQuery = " where 1 ";

			if(!empty($Config['CmpDepartment'])) $strAddQuery .= " and d.depID in (".$Config['CmpDepartment'].")";

			$strAddQuery .= " and (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission p on m.ModuleID =p.ModuleID where p.UserID='".$AdminID."'))";
		 	
			$strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery." and m.Status='1'  order by m.ModuleID"; 

			return $this->query($strSQLQuery, 1);
		 }

		function GetAllowedDepartmentUserNew($AdminID=0){
			global $Config;
            //echo "<pre>";print_r($Config);
			$strAddQuery = " where 1 ";

			if(!empty($Config['CmpDepartment'])) $strAddQuery .= " and d.depID in (".$Config['CmpDepartment'].")";
           
			//$strAddQuery .= " and (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission p on m.ModuleID =p.ModuleID where p.UserID='".$AdminID."'))";
		 	 $strAddQuery .= " and m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in (select distinct(m.Parent) from admin_modules m where m.ModuleID in (select distinct(m.ModuleID) from admin_modules m inner join permission p on m.ModuleID =p.ModuleID where p.UserID='".$AdminID."'))";
			 $strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery." and m.Status='1'  order by d.Status desc, d.depID asc"; 

			return $this->query($strSQLQuery, 1);
		 }



		function GetDateFormat(){
			$strSQLQuery ="select DateFormat from date_format where Status='1'";
			return $this->query($strSQLQuery, 1);
		}

		function GetDateFormatValue($DateFormat){ 
			 $strSQLQuery ="select * from date_format where DateFormat ='".$DateFormat."'";
			return $this->query($strSQLQuery, 1);					
		}

		function GetIndustryType(){
			$strSQLQuery ="select IndustryID, IndustryName from industry_type where Status='1' order by IndustryName asc";
			return $this->query($strSQLQuery, 1);
		}
		function  GetDepartment()
		{
			$sql = "select * from department where Status='1' order by depID asc ";
			return $this->query($sql, 1);

		}
		function UpdateSiteSettings($arryDetails){
			extract($arryDetails);

			$strSQL = "update configuration set SiteName='".addslashes($SiteName)."', SiteTitle='".addslashes($SiteTitle)."', SiteEmail='".addslashes($SiteEmail)."',FlashWidth='".$FlashWidth."',FlashHeight='".$FlashHeight."', RecordsPerPage='".$RecordsPerPage."', MemberApproval='".$MemberApproval."', RecieveSignEmail='".$RecieveSignEmail."', PostingApproval='".$PostingApproval."', FeaturedStorePrice='".$FeaturedStorePrice."', MaxPartnerLimit='".$MaxPartnerLimit."',   BannerHome='".$BannerHome."', BannerRight='".$BannerRight."',Tax='".addslashes($Tax)."', Shipping='".addslashes($Shipping)."', SessionTimeout='".addslashes($SessionTimeout)."'  where ConfigID='".$ConfigID."'";

			$this->query($strSQL, 0);


			/*$strSQLQuery = "update configuration set MyGate_Mode='".$MyGate_Mode."', MyGate_MerchantID='".addslashes($MyGate_MerchantID)."', MyGate_ApplicationID='".addslashes($MyGate_ApplicationID)."', AccountHolder='".addslashes($AccountHolder)."', AccountNumber='".addslashes($AccountNumber)."', 
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

			$this->query($strSQLQuery, 0);*/


			return 1; 
		}

		function UpdateFlash($HomeFlash,$OldFlash){

			if($OldFlash !='' && file_exists('../flash/'.$OldFlash) ){								
				unlink('../flash/'.$OldFlash);	
			}
			$strSQL = "update configuration set HomeFlash='".$HomeFlash."' where ConfigID='1'";
			$this->query($strSQL, 0);
			return 1;
		}

		function UpdateImage($SiteLogo,$FieldName){
			$strSQL = "update configuration set ".$FieldName."='".$SiteLogo."' where ConfigID='1'";
			$this->query($strSQL, 0);
			return 1;
		}



		function UpdateTutorialFile($tutorial,$OldTutorial){

			if($OldTutorial !='' && file_exists('../includes/'.$OldTutorial) ){								
				unlink('../includes/'.$OldTutorial);	
			}

			$strSQL = "update configuration set tutorial='".$tutorial."' where ConfigID='1'";
			$this->query($strSQL, 0);
			return 1;
		}

		function GetNumUsers(){
			$strSQLQuery = "select count(*) as NumRegisteredUsers from members where deleted='0'";
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
				$sql = "select Email from user_email where CmpID='".$CmpID."' and RefID='0'";			$arryEmail = $this->query($sql, 1);
				
				if($arryEmail[0]['Email']==$Email){
					$CheckDuplicay = 0;	
				}
			}
			
			if($CheckDuplicay==1){
			$strSQLQuery = "select ID from user_email where LCASE(Email)='".strtolower(trim($Email))."'";		
		
			
			$arryRow = $this->query($strSQLQuery, 1);
			if(!empty($arryRow[0]['ID']))$IdExist = $arryRow[0]['ID'];		
			}
			
			/***********************************************/
			/**********Customer/Vendor Check****************/
			if(empty($IdExist)){
				if($CheckDuplicay==1){
					$strSQLQuery2 = "select id from company_user where LCASE(user_name)='".strtolower(trim($Email))."'"; 
					$arryRow = $this->query($strSQLQuery2, 1);
					if(!empty($arryRow[0]['id']))$IdExist = $arryRow[0]['id'];				
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
			(empty($user_type))?($user_type=""):("");
			$IdExist='';	

			$user_type = strtolower($user_type);
			$CheckDuplicay = 1; //Add Case
			
			/**********Company/Employee Check****************/
			if(!empty($Email)){
			  if(!empty($RefID) && !empty($CmpID)){
				$sql = "select Email from user_email where CmpID='".$CmpID."' and RefID='".$RefID."' ";				
				$arryEmail = $this->query($sql, 1);
				if(!empty($arryEmail[0]['Email'])){
					if(strtolower($arryEmail[0]['Email'])==strtolower($Email)){
						$CheckDuplicay = 0;	
					}
				}
			  }			
			if($CheckDuplicay==1){
				$strSQLQuery = "select ID from user_email where LCASE(Email)='".strtolower(trim($Email))."'";
				if($user_type=='customer' || $user_type=='customercontact'){$strSQLQuery.= "  and CmpID='".$CmpID."'"; }
				
				$arryRow = $this->query($strSQLQuery, 1);
				if(!empty($arryRow[0]['ID'])){
					$IdExist = $arryRow[0]['ID'];	
				}	
			}
			
			/***********************************************/
			/**********Customer/Vendor Check****************/
			if(empty($IdExist)){
				
				if(!empty($ref_id) && !empty($CmpID)){ //not verified
					$sql2 = "select user_name from company_user where comId='".$CmpID."' and ref_id='".$ref_id."' and user_type='".$user_type."'  ";				
					$arryEmail = $this->query($sql2, 1);
					if(!empty($arryEmail[0]['user_name'])){
						if($arryEmail[0]['user_name']==$Email){
							$CheckDuplicay = 0;	
						}
					}
				}			
				if($CheckDuplicay==1){
					$strSQLQuery2 = "select id from company_user where LCASE(user_name)='".strtolower(trim($Email))."'"; 
					#if(!empty($user_type)){$strSQLQuery2.= " and user_type='".$user_type."'"; }
					if($user_type=='customer' || $user_type=='customercontact'){$strSQLQuery2.= "  and comId='".$CmpID."'"; }
					
					$arryRow = $this->query($strSQLQuery2, 1);
					if(!empty($arryRow[0]['id'])){
						$IdExist = $arryRow[0]['id'];		
					}
								
				}

			 }
			}
			/***********************************************/
			//echo $IdExist.'#'.$strSQLQuery2;exit;
			if(!empty($IdExist)){
				return true;
			} else {
				return false;
			}
		}


	       function isCustEmailDuplicate55555($arryDetails)
		{
			extract($arryDetails);
			
			$CheckDuplicay = 1; //Add Case
			 
			/**********Company/Employee Check****************/
			if(!empty($RefID) && !empty($CmpID)){
				$sql = "select Email from user_email where CmpID='".$CmpID."' and RefID='".$RefID."' ";	
  				$arryEmail = $this->query($sql, 1);
				if(strtolower($arryEmail[0]['Email'])==strtolower($Email)){
					$CheckDuplicay = 0;	
				}
			}			
			if($CheckDuplicay==1){
				$strSQLQuery = "select ID from user_email where LCASE(Email)='".strtolower(trim($Email))."' and CmpID='".$CmpID."'"; //new CmpID
				
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
					 $strSQLQuery2 = "select id from company_user where LCASE(user_name)='".strtolower(trim($Email))."' and comId='".$CmpID."'"; //new CmpID
					if(!empty($user_type)){$strSQLQuery2.= " and user_type='".$user_type."'"; }

					$arryRow = $this->query($strSQLQuery2, 1);
					//pr($arryRow);die;
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
				if(strtolower($arryEmail[0]['Email'])==strtolower($Email)){
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
				global $Config;
				$strSQLQuery = "delete from ".$Config['DbMain'].".user_email where LCASE(Email)='".strtolower(trim($Email))."'"; 
				$this->query($strSQLQuery, 0);	
			}
			return 1;
		}

		function CheckUserEmail($Email){
			if(!empty($Email)){
				$strSQLQuery = "select u.*,c.DisplayName, c.Department, c.ExpiryDate,c.LicenseKey,c.LoginBlock,LoginIP,c.Timezone,c.SessionTimeout, c.LiveMode,c.MaxUser from user_email u inner join company c on u.CmpID=c.CmpID where MD5(LCASE(u.Email))='".md5(strtolower(trim($Email)))."'"; 
				return $this->query($strSQLQuery, 1);
			}
		}
	


		/************Block Login****************/
		/*******************************************/
		function AddBlockLogin($LoginType)
		{  
			$ipaddress = GetIPAddress();

			$strSQLQuery = "select blockID from user_block where LoginType='".$LoginType."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if(!empty($arryRow[0]["blockID"])){
				$strSQL = "update user_block set LoginTime='".time()."' where blockID='".$arryRow[0]["blockID"]."'"; 
				$this->query($strSQL, 0);
			}else{
				$strSQLQuery = "insert into user_block (LoginTime, LoginIP, LoginType) values( '".time()."', '".$ipaddress."', '".$LoginType."')";
				$this->query($strSQLQuery, 0);
			}

			return true;
		}

		function CheckBlockLogin($LoginType)
		{   
			$ipaddress = GetIPAddress();
			$strSQLQuery = "select LoginTime from user_block where LoginType='".$LoginType."' and LoginIP='".$ipaddress."'";
			$arryRow = $this->query($strSQLQuery, 1);
			$LoginTime = '';
			if(!empty($arryRow[0]['LoginTime'])){
				$LoginTime = $arryRow[0]['LoginTime'];			
			}

			if((time() - $LoginTime) > 3600) {
				return false; //allow
			} else {
				return true;
			}

			
		}

		function RemoveBlock($LoginType)
		{	
			$ipaddress = GetIPAddress();		
			$strSQLQuery = "delete from user_block where LoginType='".$LoginType."' and LoginIP='".$ipaddress."'";
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
				$strSQLQuery ="SELECT h.GroupID,g.group_name FROM h_employee h inner join h_role_group g on h.GroupID=g.GroupID WHERE h.EmpID= '".$EmpID."' and g.Status='1'";
				return $this->query($strSQLQuery, 1);
			}
		}

		function GetEmployeeBasic($EmpID){
			if($EmpID>0){			 
				$strSQLQuery = "select e.EmpCode, e.UserName, e.Email, e.ExistingEmployee,u.UserSecurity,u.AllowSecurityUser,u.AuthSecretKey from h_employee e left outer join user u on e.UserID=u.UserID where e.EmpID='".mysql_real_escape_string($EmpID)."' ";
				return $this->query($strSQLQuery, 1);
			}			
		}

		function GetAllowedDepartmentGroup($GroupID=0){
			global $Config;

			$strAddQuery = " where 1 ";

			if(!empty($Config['CmpDepartment'])) $strAddQuery .= " and d.depID in (".$Config['CmpDepartment'].")";

			$strAddQuery .= " and (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission_group p on m.ModuleID =p.ModuleID where p.GroupID='".$GroupID."'))";
		 	
			$strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery." and m.Status='1'  order by m.ModuleID"; 

			return $this->query($strSQLQuery, 1);
		 }

		function GetAllowedDepartmentGroupNew($GroupID=0){
			global $Config;

			$strAddQuery = " where 1 ";

			if(!empty($Config['CmpDepartment'])) $strAddQuery .= " and d.depID in (".$Config['CmpDepartment'].")";

			//$strAddQuery .= " and (m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in( select distinct(m.ModuleID) from admin_modules m inner join permission_group p on m.ModuleID =p.ModuleID where p.GroupID='".$GroupID."'))";
		 	$strAddQuery .= " and m.ModuleID in(".$Config['DefaultMenu'].") or m.ModuleID in (select distinct(m.Parent) from admin_modules m where m.ModuleID in (select distinct(m.ModuleID) from admin_modules m inner join permission_group p on m.ModuleID =p.ModuleID where p.GroupID='".$GroupID."'))";
			 $strSQLQuery ="select distinct(d.depID),d.Department from admin_modules m inner join department d on m.depID=d.depID ".$strAddQuery." and m.Status='1'  order by d.Status desc,d.depID Asc"; 

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

			$strAddQuery .= ($Parent>0)?(" and m.Parent='".$Parent."'"):(" and m.Parent='0' ");
			$strAddQuery .= ($DepID>0)?(" and m.DepID='".$DepID."'"):(" and m.DepID='0' ");
		 	$strAddQuery .= ($_SESSION['AdminType']=="admin")?(" and m.Default='0' "):(" ");
			$strSQLQuery ="select m.* from admin_modules m ".$strAddQuery." and m.Status='1' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID"; 

			return $this->query($strSQLQuery, 1);
		 }

		



		function isModulePermittedRoleGroup($ModuleID,$GroupID)
		{
			
			if(!empty($ModuleID) && !empty($GroupID)){
				$sql ="select * from permission_group where ModuleID = '".$ModuleID."' and GroupID = '".$GroupID."'  ";
				return $this->query($sql, 1);
			}

		}
		

		function GetModulePermission($MainModuleID,$AllowedModules,$RoleGroupUserId)
		{			
			$vAllRecord='';
			if($_SESSION['AdminType']=="employee" && !in_array($MainModuleID,$AllowedModules)){
				if(!empty($RoleGroupUserId)){
					$arryPermitted = $this->isModulePermittedRoleGroup($MainModuleID,$RoleGroupUserId);			 
				}else{
					$arryPermitted = $this->isModulePermittedUser($MainModuleID,$_SESSION['UserID']);	 
				}  
 
				if(!empty($arryPermitted[0]['FullLabel']) || !empty($arryPermitted[0]['ViewAllLabel'])){
					$vAllRecord = 1;
				}
			}
			return $vAllRecord;
		}

		/**********************************************/
		/**************Start Email ************/
		 //function added for creating inbox,draft count in left menu email section
		 
		       function CountTotalFolderEmails($FolderID)
                {
                   $strSQLQuery = "select count(autoId) as totalEmail from importedemails where FolderId='".$FolderID."' and Status='1' ";
                   $arryRow=$this->query($strSQLQuery, 1);
                   
                    if($arryRow[0]['totalEmail'] > 0) {
                        return $arryRow[0]['totalEmail'];
                    }else {
                        return 0;
                    }
                }
		 
		 
		 
		    function updateSendMailStatus($id) {
			if($id>0){
				$sql = "update importedemails set Status = '0' where autoId='".$id."' ";
				return $this->query($sql, 1);
			}
		    }

                 function GetEmailListId($adminId, $compId) {

                        $sel_query = "select id,EmailId from importemaillist where AdminID='".$adminId."' and CompID='".$compId."' and status='1' and DefalultEmail='1' ";
                        return $this->query($sel_query, 1);
                    }
                    
                function ListUnReadInboxEmails($ownerId)
                {

                    $GetEmailID_qry = "select EmailId from importemaillist where id='" . $ownerId . "'";
                    $GetEmailID = $this->query($GetEmailID_qry, 1);
                    $strSQLQuery = "select COUNT(autoId) as totalEmail from importedemails where To_Email='" . $GetEmailID[0][EmailId] . "' and MailType='Inbox' and Status='1' order by composedDate desc";


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
			$strSQLQuery = "select autoId,Subject from importedemails  e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status='1' and l.DefalultEmail='1') where e.MailType='Inbox' and e.Status='1' order by e.composedDate desc limit 0,".$limit;

			return $this->query($strSQLQuery, 1);
		}

		function CountImportEmailsBott() {
			$strSQLQuery = "select COUNT(e.autoId) as totalEmail from importedemails e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status='1' and l.DefalultEmail='1') where e.MailType='Inbox' and e.Status='1' ";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['totalEmail'];
		}


		function ListImportEmailsDash() {	
			$strSQLQuery = "select e.autoId,e.Subject,e.Status from importedemails  e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status='1' and l.DefalultEmail='1') where e.MailType='Inbox' order by e.composedDate desc limit 0, 50";

			return $this->query($strSQLQuery, 1);
		}

		
	function GetWorkspaceEmail($campType) {
		$arryDate = explode(" ",$_SESSION['TodayDate']);

		$strSQLQuery = "select e.autoId,e.Subject,e.Status from importedemails  e inner join importemaillist l on (e.To_Email = l.EmailId and l.AdminID='".$_SESSION['AdminID']."' and l.CompID='".$_SESSION['CmpID']."' and l.status='1' and l.DefalultEmail='1') where e.MailType='Inbox' ";
	

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
			
			$strSQLQuery = "SELECT COUNT(v.id) as totalID FROM `blocks_view` v inner join `blocks` b on v.BlockID=b.BlockID where v.AdminID = '".$_SESSION['AdminID']."' and v.AdminType='".$_SESSION['AdminType']."' and b.Status='1' and v.Status='1' and b.depID='".$Config['CurrentDepID']."' ORDER BY v.`OrderBy` ASC";

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
			$strSQLQuery = "SELECT v.id,v.BlockID,v.OrderBy,v.Width,v.Height,v.Left,v.Top,b.Block, b.BlockHeading FROM `blocks_view` v inner join `blocks` b on v.BlockID=b.BlockID where v.AdminID = '".$_SESSION['AdminID']."' and v.AdminType='".$_SESSION['AdminType']."' and b.Status='1' and v.Status='".$Status."' and b.depID='".$Config['CurrentDepID']."' ORDER BY v.`OrderBy` ASC";
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
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `ModuleID` = '182' and Status='1' ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}

	}

	function isZoomMeetngActive(){
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `ModuleID` = '184' and Status='1'";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}
	
	}


	function isHostbillActive(){
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `Link` = 'hostbillsetting.php' and Status='1' ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}

	}

	function isEmailActive(){
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `ModuleID` = '2025' and Status='1' ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}

	}

	function isPhoneActive(){
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `ModuleID` = '176' and Status='1' ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}

	}

/*----------------------Added by Sanjiv For Dynamic Folder ------------------------------------------------*/
		function getFolderList($FolderId,$AdminId,$CompId,$moduleId) {
             $strQry = '';
             if (!empty($FolderId)) {
                $strQry = " and FolderId='" . $FolderId . "'";
             }
             if($_SESSION['AdminType']=='admin'){
             	$strSQLQuery = "select FolderId,FolderName,AdminID,CompID from c_folder where CompID='".$CompId."' and ModuleID='".$moduleId."' " . $strQry . " order by FolderName asc";
             }else{
             	$strSQLQuery = "select FolderId,FolderName,AdminID,CompID from c_folder where (AdminID='".$AdminId."' or IsPublic='1' ) and CompID='".$CompId."' and ModuleID='".$moduleId."' " . $strQry . " order by FolderName asc";
             }
             return $this->query($strSQLQuery, 1);
    }
    
	function AddFolderName($arryDetails)
    {
      extract($arryDetails); 
       $strSQLQuery = "insert into c_folder(FolderName,AdminID,AdminType,Status,CompID,ModuleID,IsPublic) values ('".mysql_real_escape_string($Name)."','".$AdminID."','".$AdminType."', '1' ,'".$_SESSION['CmpID']."','".$_SESSION['ModuleParentID']."','".mysql_real_escape_string($IsPublic)."')";
      return $this->query($strSQLQuery, 1);
    }
    
    function UpdateFolderName($arryDetails)
    {
      extract($arryDetails); 
      $strSQLQuery = "update c_folder set FolderName='".mysql_real_escape_string($Name)."',IsPublic='".mysql_real_escape_string($IsPublic)."' where FolderId='".$FolderID."'";
      return $this->query($strSQLQuery, 1);        
    }
    
    
    function CheckDynamicFolderName($FolderName,$FolderID,$AdminId,$CompId,$ModuleID)
    {
      if(empty($FolderID))
      {
        $strSQLQuery = "select count(FolderId) as FolderCount from c_folder where FolderName='".mysql_real_escape_string($FolderName)."' and CompID='".$CompId."' and ModuleID='".$ModuleID."' ";
        $FolderData=$this->query($strSQLQuery, 1);
        return $FolderData[0]['FolderCount']; exit;
      }
      if(!empty($FolderID) && ($FolderID > 0))
      {
        $strSQLQuery = "select count(FolderId) as FolderCount from c_folder where FolderId!='".$FolderID."' and FolderName='".mysql_real_escape_string($FolderName)."' and CompID='".$CompId."' and ModuleID='".$ModuleID."'";
        $FolderData=$this->query($strSQLQuery, 1);
        return $FolderData[0]['FolderCount']; exit;
      }
    }
    
    
     function GetFolderDetails($FolderId)
     {
          $strSQLQuery = "select * from c_folder where FolderId='".$FolderId."' order by FolderName asc";                      
          return $this->query($strSQLQuery, 1);                      
     }   

     
	function DeleteFolder($FolderID)
     {
        $delete_folderqry="delete from c_folder where FolderId='".$FolderID."'"; 
        $this->query($delete_folderqry, 0);
        
        $lead_qry = "delete from c_lead where FolderId='".$FolderID."'";
        $this->query($lead_qry,0);
     }
    
	    	
     /*--------------------------------- END ----------------------------------------------*/
	
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
					$field .="&nbsp;&nbsp;&nbsp;<input name='".$relatedField.$IDVal."' id='input_".$relatedField.$IDVal."'  style='width:100px;' class='inputbox' value='".$FieldVal."' />";	
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
		WHERE e.Status='1' and  e.locationID='".$_SESSION['locationID'] ."' 
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
			
		$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

		$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

		$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

		return $this->query($strSQLQuery, 1);

	}

	function  GetTerm($termID,$Status)
	{

		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($termID))?(" and termID='".$termID."'"):("");
		$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

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
			
		$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

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

/*     * ***start code by sachin 17-11-2015  for dynamic pdf*** */

   function SaveSalesPdfTempalte($arryDetails) {
        global $Config;
        extract($arryDetails);
        $strSQLQuery = "INSERT INTO dynamic_pdf_template SET ModuleName = '" . $ModuleName . "', ModuleId='" . $ModuleId . "',TemplateName='" . addslashes($TemplateName) . "',Module='" . $Module . "', InformationFieldFontSize = '" . $InformationFieldFontSize . "', InformationFieldAlign = '" . $InformationFieldAlign . "',InformationColor='" . addslashes($InformationColor) . "', BillAddHeading = '" . $BillAddHeading . "',BillAdd_Heading_FieldFontSize='" . $BillAdd_Heading_FieldFontSize . "',BillAdd_Heading_FieldAlign='" . $BillAdd_Heading_FieldAlign . "',BillAddColor='" . $BillAddColor . "',BillHeadColor='" . $BillHeadColor . "',BillHeadbackgroundColor='" . $BillHeadbackgroundColor . "',ShippAddColor='" . $ShippAddColor . "',ShippAddHeading='" . $ShippAddHeading . "',ShippAdd_Heading_FieldFontSize='" . $ShippAdd_Heading_FieldFontSize . "',ShippAdd_Heading_FieldAlign='" . $ShippAdd_Heading_FieldAlign . "',ShippHeadColor='" . $ShippHeadColor . "',ShippHeadbackgroundColor='" . $ShippHeadbackgroundColor . "',LineItemHeadingFontSize='" . $LineItemHeadingFontSize . "',LineColor='" . $LineColor . "',LineHeadColor='" . $LineHeadColor . "',LineHeadbackgroundColor='" . $LineHeadbackgroundColor . "',LineHeading='" . $LineHeading . "',CompanyFieldFontSize='" . $CompanyFieldFontSize . "',CompanyFieldAlign='" . $CompanyFieldAlign . "',CompanyColor='" . $CompanyColor . "',CompanyHeadingFontSize='" . $CompanyHeadingFontSize . "',CompanyHeadColor='" . $CompanyHeadColor . "',TitleFontSize='" . $TitleFontSize . "',Title='" . $Title . "',TitleColor='" . $TitleColor . "',LogoSize='" . $LogoSize . "',SpecialHeadColor='" . $SpecialHeadColor . "',SpecialHeadbackgroundColor='" . $SpecialHeadbackgroundColor . "',SpecialHeadingFontSize='" . $SpecialHeadingFontSize . "',SpecialFieldColor='" . $SpecialFieldColor . "',SpecialHeading='" . $SpecialHeading . "',SpecialSigned='" . $SpecialSigned . "',FooterContent='" . $FooterContent . "',ConditionDisplay='".$ConditionDisplay."',DiscountDisplay='".$DiscountDisplay."',setDefautTem='".$setDefautTem."',PublicPvt='".$PublicPvt."',AdminID='".$_SESSION['AdminID']."',UserType='".$_SESSION['AdminType']."',defaultFor='".$_SESSION['AdminID']."',LogoDisplay='".$LogoDisplay."',AddressDisplay='".$AddressDisplay."',SalesPersonD='".$SalesPersonD."',CreatedByD='".$CreatedByD."'";
        //echo $strSQLQuery; die;
		if($setDefautTem==1){ //$this->UpdateSetDefaultVal($ModuleId,'');
		                     $this->UpdateSetDefaultVal($Module,'');
                             //$this->RemoveMultipleIdfordefulttemp($ModuleId,'');
	                          }
        return $this->query($strSQLQuery, 1);
    }
    function GetSalesPdfTemplate($arryDetails) {
        global $Config;
        extract($arryDetails);
        //PR($arryDetails);
        $sqlqury =" Where 1 ";
        $sqlqury .=(!empty($ModuleId)) ? (" and ModuleId='" . $ModuleId . "'") : ('');
        $sqlqury .=(!empty($id)) ? (" and id='" . $id . "'") : ('');
        $sqlqury .=(!empty($ModuleName)) ? (" and ModuleName='" . $ModuleName . "'") : ('');
        $sqlqury .=(!empty($Module)) ? (" and Module='" . $Module . "'") : ('');
        $sqlqury .=(!empty($setDefautTem)) ? (" and setDefautTem='" . $setDefautTem . "'") : ('');
        if(!empty($listview)){
        	 
        	if(!empty($_SESSION['AdminID'])){
        		$sqlqury .=" and (AdminID='" . $_SESSION['AdminID'] . "' || `PublicPvt`='0')";
        	}
    
        }
        else  if(!empty($setDefautTem)){  
        	//$sqlqury .=" and FIND_IN_SET('".$_SESSION['AdminID']."', defaultFor)";
        }
        else{
        	//echo 'lll';
        	//$sqlqury .=(!empty($_SESSION['AdminID'])) ? (" and AdminID='" . $_SESSION['AdminID'] . "'") : ('');
        }
        $sql = "Select * From dynamic_pdf_template" . $sqlqury;
        
       //echo $sql;die;
        return $this->query($sql, 1);
    }

      function UpdateSalesPdfTempalte($arryDetails) {
        global $Config;
        //echo 'fff';die;
        extract($arryDetails);
        if($Deftformult==1){
         
           if($setDefautTem==1){
        	//$sql = "Update dynamic_pdf_template SET setDefautTem='".$setDefautTem."',defaultFor='".$defaultFor."' where ModuleId='" . $ModuleId . "' and id='" . $id . "' and Module='" . $Module . "' and ModuleName='" . $ModuleName . "' and AdminID='".$createdBy."'";

        	$sql = "Update dynamic_pdf_template SET setDefautTem='".$setDefautTem."',defaultFor='".$defaultFor."' where ModuleId='" . $ModuleId . "' and id='" . $id . "' and Module='" . $Module . "' and ModuleName='" . $ModuleName . "'";
        	$this->UpdateSetDefaultVal($Module,$id);
        	//$this->RemoveMultipleIdfordefulttemp($ModuleId,$id);
        	//RemoveMultipleIdfordefulttemp
        	
        	//echo $sql;die;
        	return $this->query($sql, 1);
          }
          else{
          	$sqlqury .=(!empty($id)) ? (" and id='" . $id . "'") : ('');
          	$sql="Update dynamic_pdf_template SET setDefautTem = 0, defaultFor = REPLACE(defaultFor, ',".$_SESSION['AdminID']."', '') where ModuleId='" . $ModuleId . "'".$sqlqury;

		//echo $sql;die;
			return $this->query($sql, 1);
          } 
        }
        	else{
        $sql = "Update dynamic_pdf_template SET TemplateName='" . addslashes($TemplateName) . "', InformationFieldFontSize = '" . $InformationFieldFontSize . "', InformationFieldAlign = '" . $InformationFieldAlign . "',InformationColor='" . addslashes($InformationColor) . "', BillAddHeading = '" . $BillAddHeading . "',BillAdd_Heading_FieldFontSize='" . $BillAdd_Heading_FieldFontSize . "',BillAdd_Heading_FieldAlign='" . $BillAdd_Heading_FieldAlign . "',BillAddColor='" . $BillAddColor . "',BillHeadColor='" . $BillHeadColor . "',BillHeadbackgroundColor='" . $BillHeadbackgroundColor . "',ShippAddColor='" . $ShippAddColor . "',ShippAddHeading='" . $ShippAddHeading . "',ShippAdd_Heading_FieldFontSize='" . $ShippAdd_Heading_FieldFontSize . "',ShippAdd_Heading_FieldAlign='" . $ShippAdd_Heading_FieldAlign . "',ShippHeadColor='" . $ShippHeadColor . "',ShippHeadbackgroundColor='" . $ShippHeadbackgroundColor . "',LineItemHeadingFontSize='" . $LineItemHeadingFontSize . "',LineColor='" . $LineColor . "',LineHeadColor='" . $LineHeadColor . "',LineHeadbackgroundColor='" . $LineHeadbackgroundColor . "',LineHeading='" . $LineHeading . "',CompanyFieldFontSize='" . $CompanyFieldFontSize . "',CompanyFieldAlign='" . $CompanyFieldAlign . "',CompanyColor='" . $CompanyColor . "',CompanyHeadingFontSize='" . $CompanyHeadingFontSize . "',CompanyHeadColor='" . $CompanyHeadColor . "',TitleFontSize='" . $TitleFontSize . "',Title='" . $Title . "',TitleColor='" . $TitleColor . "',LogoSize='" . $LogoSize . "',SpecialHeadColor='" . $SpecialHeadColor . "',SpecialHeadbackgroundColor='" . $SpecialHeadbackgroundColor . "',SpecialHeadingFontSize='" . $SpecialHeadingFontSize . "',SpecialFieldColor='" . $SpecialFieldColor . "',SpecialHeading='" . $SpecialHeading . "',SpecialSigned='" . $SpecialSigned . "',FooterContent='" . $FooterContent . "',ConditionDisplay='".$ConditionDisplay."',DiscountDisplay='".$DiscountDisplay."',setDefautTem='".$setDefautTem."',PublicPvt='".$PublicPvt."',LogoDisplay='".$LogoDisplay."',AddressDisplay='".$AddressDisplay."',SalesPersonD='".$SalesPersonD."',CreatedByD='".$CreatedByD."' where ModuleId='" . $ModuleId . "' and id='" . $id . "' and Module='" . $Module . "' and ModuleName='" . $ModuleName . "'";
		if($setDefautTem==1){$this->UpdateSetDefaultVal($Module,$id);
			//$this->RemoveMultipleIdfordefulttemp($ModuleId,$id);
		}
		return $this->query($sql, 1);

		}
        
    }
	
	function UpdateSetDefaultVal($Module,$id){
		$sqlqury .=(!empty($id)) ? (" and id!='" . $id . "'") : ('');
		//$sqlqury .=(!empty($_SESSION['AdminID'])) ? (" and AdminID='" . $_SESSION['AdminID'] . "'") : ('');
		//$sql="Update dynamic_pdf_template SET setDefautTem='0' where ModuleId='" . $ModuleId . "'".$sqlqury;
		$sql="Update dynamic_pdf_template SET setDefautTem='0' where Module='" . $Module . "'".$sqlqury;
		//echo $sql;die;
		return $this->query($sql, 1);
	}

	function RemoveMultipleIdfordefulttemp($ModuleId,$id){
		$sqlqury .=(!empty($id)) ? (" and id!='" . $id . "'") : ('');
		//$sqlqury .=(!empty($_SESSION['AdminID'])) ? (" and AdminID='" . $_SESSION['AdminID'] . "'") : ('');
		$sql="Update dynamic_pdf_template SET defaultFor = REPLACE(defaultFor, ',".$_SESSION['AdminID']."', '') where ModuleId='" . $ModuleId . "'".$sqlqury;

		//echo $sql;die;
		return $this->query($sql, 1);
	}

    function DeleteTemplateName($arryDetails) {
        global $Config;
	$objFunction=new functions();
        extract($arryDetails);
	
	if(!empty($id)){

		/******Delete PDF**********/
		if(!empty($ModuleDepName) && !empty($PdfDir) && !empty($TableName) && !empty($OrderID)){
			$sql = "select ".$ModuleID." as ModuleID from ".$TableName."  where ".$OrderColumn."='".$OrderID."'";
			$rs = $this->query($sql);
			if(!empty($rs[0]['ModuleID'])){				 
				$temp = '-temp'.$id;
				$PdfFile = $ModuleDepName . '-' . $rs[0]['ModuleID'] .$temp. '.pdf';
				$objFunction->DeleteFileStorage($PdfDir,$PdfFile);
			}	
		}	
		/**************************/
       		$sql_del = "Delete from dynamic_pdf_template where  id='" . $id . "' ";
		$this->query($sql_del, 0);

		#echo $sql.'<br>'.$PdfFile.'<br>'.$sql_del;die;	
	}
	


        return true;
    }

    /*     * ***End code by sachin 17-11-2015 for dynamic pdf*** */


	function DeleteAllPdfTemplate($arryDetails){
		global $Config;
		$objFunction=new functions(); 
		extract($arryDetails);

		if(!empty($ModuleDepName) && !empty($PdfDir) && !empty($TableName) && !empty($OrderID)){
			$sql = "select id, TemplateName from dynamic_pdf_template where ModuleId = '".$OrderID."' and ModuleName='".$ModuleDepName."' ";
			$arryPdfData =  $this->query($sql, 1); 


			if($ModuleDepName == 'Quote') {
				$OrderColumn =  "quoteid"; 
			}else{
				$OrderColumn  =  "OrderID";
			}

			$sqlM = "select ".$ModuleID." as ModuleID from ".$TableName."  where ".$OrderColumn."='".$OrderID."'";
			$rs = $this->query($sqlM, 1);
 
			/******Delete Template PDF**********/
			foreach($arryPdfData as $values){
				$id = $values['id'];
				$strSQLQuery="delete from dynamic_pdf_template where  id ='".$id."' ";	 		
				$this->query($strSQLQuery, 0);
				if(!empty($rs[0]['ModuleID'])){		
					$temp = '-temp'.$id;
					$PdfFile = $ModuleDepName . '-' . $rs[0]['ModuleID'] .$temp. '.pdf';
					$objFunction->DeleteFileStorage($PdfDir,$PdfFile);
				}
			}
			/**************************/
		} 
 
		return true;

	}


	/******************************************/
	/******************************************/
	function UpdateUserRolePermission(){
		$sqlQuery = "SELECT p.* from permission p inner join admin_modules m on p.ModuleID=m.ModuleID where p.ModuleID>'0' and m.Status='1' and m.Parent='0' order by p.UserID asc,p.ModuleID asc";	
		$arryRow = $this->query($sqlQuery, 1);
		//echo sizeof($arryRow); echo '<pre>';print_r($arryRow);exit;
		foreach($arryRow as $key => $values){
			$sqlQ = "SELECT ModuleID from admin_modules where Parent='".$values['ModuleID']."' and Status='1' order by ModuleID asc";	
			$arryModule = $this->query($sqlQ, 1);
			
			foreach($arryModule as $keym => $valuemod){
				if($values['FullLabel']=='1'){
					$sql = "insert ignore into permission(UserID,ModuleID,FullLabel) values('".$values['UserID']."', '".$valuemod['ModuleID']."', '1')";
					$this->query($sql,0);
				}else if($values['ViewLabel']=='1' || $values['ModifyLabel']=='1'){
					$sql = "insert ignore into permission(UserID,ModuleID, ViewLabel, AddLabel, EditLabel, DeleteLabel, ApproveLabel) values('".$values['UserID']."', '".$valuemod['ModuleID']."', '".$values['ViewLabel']."', '".$values['ModifyLabel']."', '".$values['ModifyLabel']."', '".$values['ModifyLabel']."', '".$values['ModifyLabel']."')";
					$this->query($sql,0);
				}
				
				//echo $sql;exit;
			}

			$delSql="delete from permission where UserID='".$values['UserID']."' and ModuleID='".$values['ModuleID']."' "; 
        		$this->query($delSql, 0);
			//echo $delSql;exit;
		}
	}
	/******************************************/
	/******************************************/
	function UpdateGroupRolePermission(){
		$sqlQuery = "SELECT p.* from permission_group p inner join admin_modules m on p.ModuleID=m.ModuleID where p.ModuleID>'0' and m.Status='1' and m.Parent='0' order by p.GroupID asc,p.ModuleID asc";	
		$arryRow = $this->query($sqlQuery, 1);
		//echo sizeof($arryRow); echo '<pre>';print_r($arryRow);exit;
		foreach($arryRow as $key => $values){
			$sqlQ = "SELECT ModuleID from admin_modules where Parent='".$values['ModuleID']."' and Status='1' order by ModuleID asc";	
			$arryModule = $this->query($sqlQ, 1);
			
			foreach($arryModule as $keym => $valuemod){
				if($values['FullLabel']=='1'){
					$sql = "insert ignore into permission_group(GroupID,ModuleID,FullLabel) values('".$values['GroupID']."', '".$valuemod['ModuleID']."', '1')";
					$this->query($sql,0);
				}else if($values['ViewLabel']=='1' || $values['ModifyLabel']=='1'){
					$sql = "insert ignore into permission_group(GroupID,ModuleID, ViewLabel, AddLabel, EditLabel, DeleteLabel, ApproveLabel) values('".$values['GroupID']."', '".$valuemod['ModuleID']."', '".$values['ViewLabel']."', '".$values['ModifyLabel']."', '".$values['ModifyLabel']."', '".$values['ModifyLabel']."', '".$values['ModifyLabel']."')";
					$this->query($sql,0);
				}
				
				//echo $sql;exit;
			}

			$delSql="delete from permission_group where GroupID='".$values['GroupID']."' and ModuleID='".$values['ModuleID']."' "; 
        		$this->query($delSql, 0);
			//echo $delSql;exit;
		}
	}
	/******************************************/
	/******************************************/

    	function GetDeptSettingSecurity(){
		 global $Config;
		 $addsql='';
		 if (!empty($Config['CmpDepartment']))
           		 $addsql = " and depID in (" . $Config['CmpDepartment'] . ")";
		$sql = "select * from department where ( Status='1' ".$addsql." ) OR depID in (10,11) order by Status desc, depID asc";
		return $this->query($sql, 1);
	}
	
    	function GetHeaderTopLinkDash($depID,$GroupID){    
		if($_SESSION['AdminType']=="admin"){ //admin	   
	 		$strSQLQuery ="select m.Link from admin_modules m inner join admin_modules m2 on m.Parent=m2.ModuleID where m2.depID='".$depID."' and m.Status='1' and m.Parent>'0' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 ";
		}else{ //User
			if($GroupID>0){
				$strSQLQuery ="select m.Link from admin_modules m inner join admin_modules m2 on m.Parent=m2.ModuleID inner join permission_group p on (m.ModuleID=p.ModuleID and p.GroupID='".$GroupID."')  where m2.depID='".$depID."' and m.Status='1' and m.Parent>'0' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 ";
			}else{
				 $strSQLQuery ="select m.Link from admin_modules m inner join admin_modules m2 on m.Parent=m2.ModuleID inner join permission p on (m.ModuleID=p.ModuleID and p.UserID='".$_SESSION['UserID']."')  where m2.depID='".$depID."' and m.Status='1' and m.Parent>'0' Order by Case When m.OrderBy>'0' Then 0 Else 1 End,m.OrderBy,m.ModuleID limit 0,1 ";
			}

			
		}




		return $this->query($strSQLQuery, 1);
    	}


/*------------- Background process by sanjiv----------------------------*/		        
		function setPID($Module, $Task, $PID){
			if(!empty($Module) && !empty($Task) && !empty($PID)){
				$sql = "insert into processList(Module,Task,PID)values('".addslashes($Module)."','".addslashes($Task)."','".addslashes($PID)."')";
				$this->query($sql);
				return true;
			}else{
				return false;
			}
		}
		
		function getPID($Module, $Task){
			if(!empty($Module) && !empty($Task)){
				$sql = "select * from processList where Module = '".mysql_real_escape_string($Module)."' and Task = '".mysql_real_escape_string($Task)."' ";
				return $this->query($sql,1);
			}
		}
		
		function removePID($Module, $Task, $PID){
			if(!empty($Module) && !empty($Task)){
				
				if($PID)
				$PID = " and PID = '".mysql_real_escape_string($PID)."'";
				
				$sql = "delete from processList where Module = '".mysql_real_escape_string($Module)."' and Task = '".mysql_real_escape_string($Task)."' $PID";
				$this->query($sql,0);
				return true;
			}else{
				return false;
			}
		}
		
		function isRunning($pid){
			try{
				$result = shell_exec(sprintf("ps %d", $pid));
				if( count(preg_split("/\n/", $result)) > 2){
					return 1;
				}
			}catch(Exception $e){}
		
			return 0;
		}
		
		function updatePID($Module, $Task,$PID,$LastUpdatedID){
			if(!empty($Module) && !empty($Task)){
				$sql = "update processList set PID='".mysql_real_escape_string($PID)."', LastUpdatedID='".mysql_real_escape_string($LastUpdatedID)."' where Module = '".mysql_real_escape_string($Module)."' and Task = '".mysql_real_escape_string($Task)."' ";
				return $this->query($sql);
			}
		}
/*------------- Background process by sanjiv----------------------------*/


	function UpdateDatabaseCronSetting($arryDetails){ 
                   global $Config;
		   extract($arryDetails);
            
                   if($EntryInterval == 'daily'){$EntryMonth='';$EntryWeekly = '';$EntryDate = '0';} 
                   if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';} 
                   if($EntryInterval == 'biweekly'){$EntryMonth='';$EntryDate = '0';}  
                   if($EntryInterval == 'semi_monthly'){$EntryMonth='';$EntryWeekly = '';$EntryDate = '0';}   
                   if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                   if($EntryInterval == 'quaterly'){$EntryMonth='';$EntryWeekly = '';}
                   if($EntryInterval == 'half-yearly'){$EntryMonth='';$EntryWeekly = '';}
                   if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                     

		$strSQLQuery = "UPDATE configuration SET  EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', 
		EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."' where ConfigID='".$ConfigID."' ";

		$this->query($strSQLQuery, 0);
		return 1; 
	}


	function UpdateLastRecurringEntry($ConfigID){ 
	  
		$strSQLQuery = "UPDATE configuration SET  LastRecurringEntry='".date("Y-m-d")."' where ConfigID='".$ConfigID."' ";

		$this->query($strSQLQuery, 0);
		return 1; 
	}


	function CheckDbCronSetting(){                	
                $date= date("Y-m-d");
		//$date = '2016-09-15';
		$arryDate = explode(" ", $date);

		$strSQLQuery = "select * from configuration where EntryFrom<='".$arryDate[0]."' and EntryTo>='".$arryDate[0]."'";
		$arryCronSetting = $this->myquery($strSQLQuery, 1);
		$EntryInterval = $arryCronSetting[0]['EntryInterval'];
		if(empty($EntryInterval)){
			return false;
		}else{
		 
			$arryDay = explode("-", $arryDate[0]);	
			$Year	= (int)$arryDay[0];
			$Month = (int)$arryDay[1];
			$Day = $arryDay[2];			
			$Din = date("l",strtotime($arryDate[0]));	
				     
			
			       
		  switch($EntryInterval){
                      case 'daily':                             
                       	      $OrderFlag=1;
                              break;  
		       case 'weekly':
                              if($Din == $arryCronSetting[0]['EntryWeekly']){
				  $OrderFlag=1;
			      }
                              break;                          
                      case 'biweekly':
				$NumDay = 0;
				if($arryCronSetting[0]['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($arryCronSetting[0]['LastRecurringEntry']))/(24*3600);	
				}
				if($Din == $arryCronSetting[0]['EntryWeekly'] && ($NumDay==0 || $NumDay>10) ){
					 $OrderFlag=1;				
				}
				break; 							
                     
		      case 'semi_monthly':  					 
			      if($Day=="01" || $Day=="15"){
				 $OrderFlag=1;
			      }
			      break;
		      case 'monthly': 			     
			      if($arryCronSetting[0]['EntryDate']==$Day){ 
			      	$OrderFlag=1;
			      }
			      break;							
		      case 'quaterly': 
			      if(($Month == 1 || $Month==4 || $Month==7 || $Month==10) && ($arryCronSetting[0]['EntryDate']==$Day)){			
				      $OrderFlag=1;
			      } 		         
			      break; 		       						                                              
                      case 'half-yearly':   	                                            
                              if(($Month == 1 || $Month==7) && ($arryCronSetting[0]['EntryDate']==$Day)){			
				      $OrderFlag=1;
			      } 	          
                              break;
                              
		     case 'yearly':			   
			     if($arryCronSetting[0]['EntryDate']==$Day && $arryCronSetting[0]['EntryMonth']==$Month){	
			    	 $OrderFlag=1;
			     }
			    break;	
						
			}
					 
		
		  }


       	  	return $OrderFlag;


   	}



/********************Update Order Logs *************************/
   	
   function AddUpdateLogs($Order_ID,$arryDetails){
   		if(empty($_GET['edit'])) return;
   		global $Config;
   		extract($arryDetails);
   		$checkUserLog = json_decode((stripslashes($USER_LOG)), true);
   		if(!empty($checkUserLog)){
   		$ipAdd=$this->getIP();
   		$sql = "insert into update_log SET updID = '" . $Order_ID . "',ModuleType = '".addslashes($ModuleType)."',AdminID = '".addslashes($_SESSION['AdminID'])."',AdminType = '".addslashes($_SESSION['AdminType'])."',
				UserName = '" .addslashes($_SESSION['UserName']) . "',IpAdd = '" .addslashes($ipAdd) . "',UpdateDate = '".$Config['TodayDate']."' ,Changes = '".$USER_LOG."',ChangesNew = '".$USER_LOG_NEW."'";
   		$this->query($sql, 0);
   		}
   	}
   	
   	
   	function GetLogs ($Order, $orderID){
   	
   		global $Config;
		$strAddQuery ='';
   		$where = " where ModuleType = '" . $Order . "' ";
   		if(!empty($orderID)) $where .=" and updID='".addslashes($orderID)."' ";
   	
   		if($Config['GetNumRecords']==1){
   			$Columns = " count(id) as NumCount ";
   		}else{
   			$Columns = "  * ";
   			if($Config['RecordsPerPage']>0){
   				$strAddQuery .= " Order by UpdateDate DESC limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
   			}
   				
   		}
   	
   		$strSQLQuery = "select ".$Columns." from update_log $where ".$strAddQuery;
   		return $this->query($strSQLQuery, 1);
   	
   	}
   	
   	function deleteLogs($arryDetails){
   	
   	
   		$count=count($arryDetails);
   		for($i=0;$i<$count;$i++){
   			$logID=$arryDetails[$i];
   			$strSQLQuery="DELETE FROM update_log WHERE id='".$logID."'";
   			$this->query($strSQLQuery, 0);
   	
   		}
   	
   	}
   	
   	function getIP(){
   		$client  = @$_SERVER['HTTP_CLIENT_IP'];
   		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
   		$remote  = $_SERVER['REMOTE_ADDR'];
   	
   		if(filter_var($client, FILTER_VALIDATE_IP))
   		{
   			$ip = $client;
   		}
   		elseif(filter_var($forward, FILTER_VALIDATE_IP))
   		{
   			$ip = $forward;
   		}
   		else
   		{
   			$ip = $remote;
   		}
   		return $ip;
   	}
/********************End Order Logs *************************/

function isHavingComment(){						
		$queryCommnet ="SELECT GROUP_CONCAT(DISTINCT(`parentId`)) as commentedIds FROM `c_all_comments` "; 		
 		return $this->query($queryCommnet, 1);
 		  	
		}	

 function IsItemSku($Sku) {
	
       $strSQLQuery = "select p1.*,cat.valuationType as evaluationType from inv_items  p1 left join inv_categories cat on cat.CategoryID=p1.CategoryID  where LOWER(p1.Sku) = '" .strtolower($Sku). "' ";
		
        return $this->query($strSQLQuery, 1);
    }

 function IsItemAliasSku($Sku) {
	$strSQLQuery = "select c.valuationType as evaluationType, ia.ItemAliasCode,ia.AliasID,ia.sku,ia.description,i.ItemID from inv_item_alias ia left join inv_items i on ia.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID where LOWER(ia.ItemAliasCode) = '" . strtolower($Sku) . "'";

        return $this->query($strSQLQuery, 1);
    }
/********code for add signature by sachin********/
    function AddEmailSignature($arryDetails)
        {  
            global $Config;
            extract($arryDetails);
            if($setDefautTem==1){
                //$UPsql="UPDATE h_users_signature SET setDefautTem='0' where UserId='".$_SESSION['AdminID']."' and ModuleId='".$_GET['ModuleId']."' and ModuleName='".$_GET['ModuleName']."' and Module='".$_GET['Module']."'";
                $UPsql="UPDATE h_users_signature SET setDefautTem='0' where UserId='".$_SESSION['AdminID']."'";
                //echo $UPsql;
                $this->query($UPsql, 0);
            }
            //$strSQLQuery = "INSERT INTO h_users_signature SET UserId = '".$_SESSION['AdminID']."',Title='".$Title."',Content='".$empSignature."',AdminType='".$_SESSION['AdminType']."',setDefautTem='".$setDefautTem."',ModuleId='".$_GET['ModuleId']."',ModuleName='".$_GET['ModuleName']."',Module='".$_GET['Module']."'";
            $strSQLQuery = "INSERT INTO h_users_signature SET UserId = '".$_SESSION['AdminID']."',Title='".$Title."',Content='".addslashes($empSignature)."',AdminType='".$_SESSION['AdminType']."',setDefautTem='".$setDefautTem."'";
            //echo $strSQLQuery;die;
            
            return $this->query($strSQLQuery, 0);;
        }
      function GetEmailSignature(){                
	  $sql="select * from h_users_signature where setDefautTem!='1' and UserId = '".$_SESSION['AdminID']."'";
           
           return $this->query($sql, 1);
            
        }
    function UpdateEmailSignature($arryDetails){
        global $Config;
        extract($arryDetails);
        $sql="UPDATE h_users_signature SET Title='".$Title."',Content='".addslashes($empSignature)."' where id='".$id."'";
        return $this->query($sql, 1);
    }
    /********code for add signature by sachin********/
/******upload document Code in order by sachin************/
function UpdateDoc($arryDetails) {
	global $Config;
	extract($arryDetails);
         $strSQLQuery = "insert into order_document set FileName='" . addslashes($FileName) . "', OrderID='".$OrderID."',ModuleName='".$ModuleName."',Module='".$Module."'";
         //echo $strSQLQuery;die;
        $this->query($strSQLQuery, 0);
        return true;
    }
function GetOrderDocument($arryDetails){
	global $Config;
	extract($arryDetails);
    $strSQLQuery="select FileName,id from order_document where  OrderID='".$OrderID."' and ModuleName='".$ModuleName."' and Module='".$Module."'";
    //echo $strSQLQuery;
    return $this->query($strSQLQuery, 1);
    
}
function DeleteOrderDocument($arryDetails){
	global $Config;
	extract($arryDetails);
    $strSQLQuery="delete from order_document where  id='".$id."' and ModuleName='".$ModuleName."' and Module='".$Module."'";
    //echo $strSQLQuery;
    $this->query($strSQLQuery, 0);
    return $id;
    
}

function DeleteAllOrderDocument($arryDetails){
	global $Config;
	extract($arryDetails);
    $strSQLQuery="delete from order_document where  OrderID='".$OrderID."' and ModuleName='".$ModuleName."' and Module='".$Module."'";
    //echo $strSQLQuery;
    $this->query($strSQLQuery, 0);
    return $id;
    
}
/******upload document Code in order by sachin************/

	function GetAllNotification() { 
		global $Config;
		 $strSQLQuery = "select NotificationId,Heading,Date,Image from ".$Config['DbMain'].".notifications where Status='1' ORDER BY `latest_update` DESC,Date DESC LIMIT 0,10";
		return $this->query($strSQLQuery, 1);

	}


	
/******************** standalone Shipment *************************/
   	function QueryStrStandAloneShipment(){
   	
		global $Config;
		$ipaddress = GetIPAddress();

		$FromAddress =	array(
		'CompanyFrom'=>$_SESSION['Shipping']['CompanyFrom'],
		'FirstnameFrom'=>$_SESSION['Shipping']['FirstnameFrom'],
		'LastnameFrom'=>$_SESSION['Shipping']['LastnameFrom'],
		'Address1From'=>$_SESSION['Shipping']['Address1From'],
		'Address2From'=>$_SESSION['Shipping']['Address2From'],
		'StateFrom'=>$_SESSION['Shipping']['StateFrom'],
		'CityFrom'=>$_SESSION['Shipping']['CityFrom'],
		'CountryFrom'=>$_SESSION['Shipping']['CountryFrom'],
		'ZipFrom'=>$_SESSION['Shipping']['ZipFrom'],
		'PhonenoFrom'=>$_SESSION['Shipping']['PhonenoFrom'],
		'DepartmentFrom'=>$_SESSION['Shipping']['DepartmentFrom'],
		'FaxnoFrom'=>$_SESSION['Shipping']['FaxnoFrom'],
		'Contactname'=>$_SESSION['Shipping']['Contactname']
		);	

		$ToAddress =	array(
		'CompanyTo'=>$_SESSION['Shipping']['CompanyTo'],
		'FirstnameTo'=>$_SESSION['Shipping']['FirstnameTo'],
		'LastnameTo'=>$_SESSION['Shipping']['LastnameTo'],
		'Address1To'=>$_SESSION['Shipping']['Address1To'],
		'Address2To'=>$_SESSION['Shipping']['Address2To'],
		'StateTo'=>$_SESSION['Shipping']['StateTo'],
		'CityTo'=>$_SESSION['Shipping']['CityTo'],
		'CountryTo'=>$_SESSION['Shipping']['CountryTo'],
		'ZipTo'=>$_SESSION['Shipping']['ZipTo'],
		'PhoneNoTo'=>$_SESSION['Shipping']['PhoneNoTo'],
		'DepartmentTo'=>$_SESSION['Shipping']['DepartmentTo'],
		'FaxNoTo'=>$_SESSION['Shipping']['FaxNoTo'],
		'ContactNameTo'=>$_SESSION['Shipping']['ContactNameTo']
		);

		$OtherDetails =	array(
		'AccountType'=>$_SESSION['Shipping']['AccountType'],
		'AccountNumber'=>$_SESSION['Shipping']['AccountNumber'],
		'ShipAccountNumber'=>$_SESSION['Shipping']['ShipAccountNumber'],
		'AesNumber'=>$_SESSION['Shipping']['AesNumber'],
		'FreightCurrency'=>$_SESSION['Shipping']['freightCurrency'],
		'DestinationZipcode'=>$_SESSION['Shipping']['DestinationZipcode'],
		'CustomValue'=>$_SESSION['Shipping']['CustomValue'],
		'DeliverySignature'=>$_SESSION['Shipping']['DeliverySignature'],
		);

		$strSQLQuery = " AdminID='".$_SESSION['AdminID']."',
		AdminType='".$_SESSION['AdminType']."',
		Label = '".$_SESSION['Shipping']['file_name']."',
		TrackingID ='".$_SESSION['Shipping']['tracking_id']."',
		TotalFreight='".$_SESSION['Shipping']['TotalFreight']."',
		COD ='".$_SESSION['Shipping']['COD']."',
		SendingLabel ='".$_SESSION['Shipping']['sendingLabel']."',
		ShippingCarrier ='".$_SESSION['Shipping']['ShipType']."',
		createdDate ='".$Config['TodayDate']."' ,
		ipaddress ='".$ipaddress."' ,
		InsureAmount = '". $_SESSION['Shipping']['InsureAmount']."',
		InsureValue = '". $_SESSION['Shipping']['InsureValue']."'
		,FromAddress ='".json_encode($FromAddress)."'
		,ToAddress ='".json_encode($ToAddress)."'
		,OtherDetails ='".json_encode($OtherDetails)."'
		,ShippingMethod ='".addslashes($_SESSION['Shipping']['ShippingMethod'])."'
		,PackageType ='".addslashes($_SESSION['Shipping']['PackageType'])."'
		,NoOfPackages ='".addslashes($_SESSION['Shipping']['NoOfPackages'])."'
		,Weight ='".addslashes($_SESSION['Shipping']['Weight'])."'
		,WeightUnit ='".addslashes($_SESSION['Shipping']['WeightUnit'])."'
		,LineItem ='".addslashes($_SESSION['Shipping']['LineItem'])."'
		,LabelChild ='".addslashes($_SESSION['Shipping']['LabelChild'])."'
		,Deleted ='0'
		,DeliveryDate ='".addslashes($_SESSION['Shipping']['DeliveryDate'])."'
		";
		return $strSQLQuery;
   			
   	}
   	
   	function AddUpdateStandAloneShipment($RefID, $ModuleType){
   		if(empty($_SESSION['Shipping']) || empty($RefID) || empty($ModuleType)) return ;
   		
   		$qry ="SELECT count(*) count FROM standalone_shipment where ModuleType = '".addslashes($ModuleType)."' and RefID = '".addslashes($RefID)."' ";
   		$data = $this->query($qry, 1);
   		
   		if(!empty($data[0]['count'])){ 
			/********Delete Old Pdfs***********/
			$this->RemoveStandAloneShipment($RefID, $ModuleType, 1);

			/**********************************/
   			$strSQLQuery = "update standalone_shipment SET ".$this->QueryStrStandAloneShipment()." where ModuleType = '".addslashes($ModuleType)."' and RefID = '".addslashes($RefID)."' ";
   			$this->query($strSQLQuery, 0);
   			$id = $ShipmentID;
   		}else{ 
	   		$strSQLQuery = "INSERT INTO standalone_shipment SET ModuleType = '".addslashes($ModuleType)."', RefID = '".addslashes($RefID)."', ".$this->QueryStrStandAloneShipment()."	";
	   		$this->query($strSQLQuery, 0);
	   		$id = $this->lastInsertId();
   		}
   		unset($_SESSION['Shipping']);
   		return $id;
   	}
   	
   	function RemoveStandAloneShipment($RefID, $ModuleType, $PdfOnly=0){
   		
   		if(!empty($RefID) && !empty($ModuleType)){
			global $Config;
			$objFunction=new functions();

   			$strQuery="SELECT * from standalone_shipment WHERE RefID='".$RefID."' and ModuleType='".$ModuleType."' ";
   			$arryShippInfo=$this->query($strQuery,1);
   	
			if(!empty($arryShippInfo[0]['ShipmentID'])){

				$LabelFolder = strtolower($arryShippInfo[0]["ShippingCarrier"])."/";
	   			$LabelPath = "../shipping/upload/".$LabelFolder.$_SESSION['CmpID']."/";
	   	
				if($arryShippInfo[0]['Label'] !=''){				
					$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['Label']);
				} 			 
	   			 
	   			if($arryShippInfo[0]['SendingLabel'] !=''){
	   				$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['SendingLabel']);
	   			}
	   	
				if($arryShippInfo[0]['LabelChild'] !='' ){ 
					$LabelChildArry = explode("#",$arryShippInfo[0]['LabelChild']);
					foreach($LabelChildArry as $childlabel){
						if($childlabel !='' ){ 
							$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$childlabel);
						}
					}
				}

				if(empty($PdfOnly)){
					$strSQLQuery = "delete from standalone_shipment where ShipmentID = '".$arryShippInfo[0]['ShipmentID']."'";
		   			$this->query($strSQLQuery);
				}

			}
   		}
   	
   		return 1;
   	
   	}
   	
   	function getStandaloneShipmentByID($ModuleType, $value){
   		if(empty($ModuleType)) return ;
   		  $qry ="SELECT * FROM standalone_shipment where ModuleType = '".addslashes($ModuleType)."' and RefID = '".addslashes($value)."' and  Deleted='0' ";

   		return $this->query($qry, 1);
   	}

	function GetStateCodeByCountryName($state_name, $country_name){
		global $Config;
		 $strSQLQuery = "select s.code as StateCode from ".$Config['DbMain'].".state s inner join ".$Config['DbMain'].".country c on s.country_id=c.country_id where LCASE(c.name)='".strtolower(trim($country_name))."' and  LCASE(s.name)='".strtolower(trim($state_name))."' ";
		$results=$this->query($strSQLQuery,1);
		if(!empty($results[0]["StateCode"])) return $results[0]["StateCode"];
			
	}

	function VoidStandAloneShipment($RefID, $ModuleType){
   	
   		if(!empty($RefID) && !empty($ModuleType)){
			global $Config;
			$objFunction=new functions();

   			$strQuery="SELECT * from standalone_shipment WHERE RefID='".$RefID."' and ModuleType='".$ModuleType."' ";
   			$arryShippInfo=$this->query($strQuery,1);
   	
			if(!empty($arryShippInfo[0]['ShipmentID'])){

				$LabelFolder = strtolower($arryShippInfo[0]["ShippingCarrier"])."/";
	   			$LabelPath = "../shipping/upload/".$LabelFolder.$_SESSION['CmpID']."/";
	   	
	   			if($arryShippInfo[0]['Label'] !=''){				
					$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['Label']);
				} 			 
	   			 
	   			if($arryShippInfo[0]['SendingLabel'] !=''){
	   				$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['SendingLabel']);
	   			}
	   	
				if($arryShippInfo[0]['LabelChild'] !='' ){ 
					$LabelChildArry = explode("#",$arryShippInfo[0]['LabelChild']);
					foreach($LabelChildArry as $childlabel){
						if($childlabel !='' ){ 
							$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$childlabel);
						}
					}
				}
		
	   	 
				$strSQLQuery = "update  standalone_shipment set label ='',TrackingID='',TotalFreight='',COD='',SendingLabel='',ShippingCarrier='',LabelChild='' where ShipmentID = '".$arryShippInfo[0]['ShipmentID']."'";
	   			$this->query($strSQLQuery);

			}
   		}
   	
   		return 1;
   	
   	}

	function getTotalShippingAmount($ModuleType, $RefID){
		global $Config;
   		if(!empty($ModuleType) && !empty($RefID)){	
			$TotalShippingAmount=0;		 
			switch($ModuleType){
				case 'SalesRMA': 
					$sql ="SELECT TotalAmount FROM s_order where Module = 'RMA' and OrderID = '".$RefID."' ";
					$arryAmount = $this->query($sql,1);
					break;

				case 'PurchaseRMA': 
					$sql ="SELECT TotalAmount FROM p_order where Module = 'RMA' and OrderID = '".$RefID."' ";
					$arryAmount = $this->query($sql,1);
					break;

				case 'VendorPayment': 
					$sql ="SELECT DECODE(TotalAmount,'". $Config['EncryptKey']."') as TotalAmount FROM f_transaction where TransactionID = '".$RefID."' ";
					$arryAmount = $this->query($sql,1);
					break;
			}
			if(!empty($arryAmount[0]["TotalAmount"])){
				$TotalShippingAmount = $arryAmount[0]["TotalAmount"];
			}

			return $TotalShippingAmount;
		}
   	}

	function CreateAPInvoiceForStandAloneFreight($RefID, $ModuleType, $Date){
		global $Config;
   		if(!empty($ModuleType) && !empty($RefID)){
			$CreateAPInvoiceFlag = 0;
			switch($ModuleType){
				case 'SalesRMA': 
					$sql ="SELECT Status,ConversionRate,ReturnID FROM s_order where Module = 'RMA' and OrderID = '".$RefID."' ";
					$arryCheck = $this->query($sql,1);
					if($arryCheck[0]["Status"]=="Completed"){
						$CreateAPInvoiceFlag = 1;
						$ReferenceNo = $arryCheck[0]["ReturnID"];
					}
					break;

				case 'PurchaseRMA': 
					$sql ="SELECT Status,ConversionRate,ReturnID  FROM p_order where Module = 'RMA' and OrderID = '".$RefID."' ";
					$arryCheck = $this->query($sql,1);
					if($arryCheck[0]["Status"]=="Completed"){
						$CreateAPInvoiceFlag = 1;
						$ReferenceNo = $arryCheck[0]["ReturnID"];
					}
					break;

				case 'VendorPayment': 
					$sql ="SELECT ReceiptID,PostToGL FROM f_transaction where TransactionID = '".$RefID."' ";
					$arryCheck = $this->query($sql,1);
					if($arryCheck[0]['PostToGL'] == "Yes"){
						$CreateAPInvoiceFlag = 1;
						$ReferenceNo = $arryCheck[0]["ReceiptID"];
					
					 }
					break;
			}

			/***********************/
			if($CreateAPInvoiceFlag=="1"){	
				 $strSQL = "select * from standalone_shipment  WHERE RefID = '".$RefID."' and ModuleType='".$ModuleType."' order by ShipmentID asc";
				$arryRow = $this->query($strSQL, 1);		
				if(!empty($arryRow[0]['TotalFreight'])){					$arryRow[0]['ShippingMethod'] = $arryRow[0]['ShippingCarrier'];
					$arryRow[0]['ActualFreight'] = $arryRow[0]['TotalFreight'];
					$arryRow[0]['ConversionRate'] = (!empty($arryCheck[0]['ConversionRate'])?($arryCheck[0]['ConversionRate']):('1'));

					$jsonArray = json_decode($arryRow[0]['OtherDetails'], true); 
					$arryRow[0]['ShipAccountNumber'] = $jsonArray['ShipAccountNumber'];
					$arryRow[0]['PostToGLDate'] = $Date;
					$arryRow[0]['SaleID'] = $ReferenceNo;	 
					$arryRow[0]['InvoiceComment'] = $ModuleType." Actual Freight";	 

					if(!empty($arryRow[0]['ShippingMethod'])  && !empty($arryRow[0]['ShipAccountNumber']) && $arryRow[0]['ActualFreight']>0){  
						$objReport = new report();
						$objReport->CreateAPInvoiceForActualFreight($arryRow[0]);
					}	
				} 
			}
			/***********************/
			return true;
		}
   	}
/********************End standalone Shipment *************************/

	function GetDefaultArray($TableName){
		if(!empty($TableName)){	
			$arryTable = explode(",",$TableName);	
			if(!empty($arryTable[0])){
				foreach($arryTable as $Table){
					if(!empty($Table)){
						$ArrayFieldName = $this->GetFieldName($Table);
						foreach($ArrayFieldName as $key=>$values){
							$arryCommanField[0][$values['Field']] = "";
						}
					}
				}
				return $arryCommanField;
			}
		}
	}
// added by nisha for sales person links
function createSalesPersonLink($salesPersonId="",$vendorSalesPersonId="")
{
	
	  $salesPersonIds = $vendorSalesPersonIds = array();
	if(!empty($salesPersonId)){
		$salesPersonIds   =  explode(",", $salesPersonId); 	
	}
    if(!empty($vendorSalesPersonId)){
		$vendorSalesPersonIds   =  explode(",", $vendorSalesPersonId); 	
	}

	$countEmpLength = count($salesPersonIds); 
	$countVenLength = count($vendorSalesPersonIds); 
    $salesPersonArr = array();
    //for employee type salesperson
    for($i=0; $i<$countEmpLength; $i++)
        { 
           $salesPersonName = $this->getSalesPersonName($salesPersonIds[$i],0);
       
                $salesPersonLink  ='<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$salesPersonIds[$i].'">'. $salesPersonName.'</a>';
        
                                          
                $salesPersonArr[] = $salesPersonLink;
       }
       //for vendor type salesperson
        for($j=0; $j<$countVenLength; $j++)
        { 
                $salesPersonName = $this->getSalesPersonName($vendorSalesPersonIds[$j],1);

                $salesPersonLink = '<a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID='.$vendorSalesPersonIds[$j].'">'. $salesPersonName.'</a>';


                                          
                $salesPersonArr[] = $salesPersonLink;
       }
                     
        if(!empty($salesPersonArr[0])){
            $salesPersoToDisplay = implode(", ",$salesPersonArr);
        }
   return $salesPersoToDisplay;
}
//added by nisha on 19 sept to get sales person name
function getSalesPersonName($SalesID,$SalesPersonType,$DB='')
{
 global $Config;

 if($SalesPersonType=='0'){
 	$dbTable = "h_employee";
    $column = "GROUP_CONCAT(UserName SEPARATOR ',') as UserName";
    $condi = "EmpID ";
 } elseif ($SalesPersonType=='1') {
 	$dbTable = "p_supplier";
 	$column = "GROUP_CONCAT(IF(SuppType = 'Individual' and UserName!='', UserName, CompanyName)   SEPARATOR ',') as UserName";
 	$condi = "SuppID";
 	
 }	 
    $strSqlQuery = "SELECT ".$column." FROM ".$DB."".$dbTable."  where ".$condi." IN (".$SalesID.")"; 
  $userName = $this->query($strSqlQuery, 1);
  return $userName[0]['UserName'];
}

	function UpdateLastCronEntrySetting($EntryType){ 
	  	if(!empty($EntryType)){	
			$strSQLQuery = "UPDATE f_cron_setting  SET  LastRecurringEntry='".date("Y-m-d")."' where EntryType='".$EntryType."' ";

			$this->query($strSQLQuery, 0);
			return 1; 
		}
	}

	function CheckCronEntrySetting($EntryType){                	
               	if(!empty($EntryType)){	
			 $date= date("Y-m-d");
			//$date = '2016-09-15';
			$arryDate = explode(" ", $date);

			$strSQLQuery = "select * from f_cron_setting where EntryFrom<='".$arryDate[0]."' and EntryTo>='".$arryDate[0]."' and EntryType='".$EntryType."' and Status='1' and EntryInterval!='' ";
			$arryCronSetting = $this->myquery($strSQLQuery, 1);	
				
			$EntryInterval = $arryCronSetting[0]['EntryInterval'];
		}

		if(empty($EntryInterval)){
			return false;
		}else{
		 
			$arryDay = explode("-", $arryDate[0]);	
			$Year	= (int)$arryDay[0];
			$Month = (int)$arryDay[1];
			$Day = $arryDay[2];			
			$Din = date("l",strtotime($arryDate[0]));	
				     
			
			       
		  switch($EntryInterval){
                      case 'daily':                             
                       	      $OrderFlag=1;
                              break;  
		       case 'weekly':
                              if($Din == $arryCronSetting[0]['EntryWeekly']){
				  $OrderFlag=1;
			      }
                              break;                          
                      case 'biweekly':
				$NumDay = 0;
				if($arryCronSetting[0]['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($arryCronSetting[0]['LastRecurringEntry']))/(24*3600);	
				}
				if($Din == $arryCronSetting[0]['EntryWeekly'] && ($NumDay==0 || $NumDay>10) ){
					 $OrderFlag=1;				
				}
				break; 							
                     
		      case 'semi_monthly':  					 
			      if($Day=="01" || $Day=="15"){
				 $OrderFlag=1;
			      }
			      break;
		      case 'monthly': 			     
			      if($arryCronSetting[0]['EntryDate']==$Day){ 
			      	$OrderFlag=1;
			      }
			      break;							
		      case 'quaterly': 
			      if(($Month == "1" || $Month=="4" || $Month=="7" || $Month=="10") && ($arryCronSetting[0]['EntryDate']==$Day)){			
				      $OrderFlag=1;
			      } 		         
			      break; 		       						                                              
                      case 'half-yearly':   	                                            
                              if(($Month == "1" || $Month=="7") && ($arryCronSetting[0]['EntryDate']==$Day)){			
				      $OrderFlag=1;
			      } 	          
                              break;
                              
		     case 'yearly':	   
			     if($arryCronSetting[0]['EntryDate']==$Day && $arryCronSetting[0]['EntryMonth']==$Month){	
			    	 $OrderFlag=1;
			     }
			    break;				
			}
		  }
       	  	return $OrderFlag;
   	}



}

?>
