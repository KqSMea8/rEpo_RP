<?
class user extends dbClass
{
		//constructor
		function user()
		{
			$this->dbClass();
		} 
		
		function  ListUser($id=0,$UserType,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where u.UserID='".$id."'"):(" where u.locationID='".$_SESSION['locationID']."'");

			if($SearchKey=='active' && ($SortBy=='u.Status' || $SortBy=='') ){
				$strAddQuery .= " and u.Status='1'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='u.Status' || $SortBy=='') ){
				$strAddQuery .= " and u.Status='0'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (u.UserName like '%".$SearchKey."%'  or u.Email like '%".$SearchKey."%' or u.UserID like '%".$SearchKey."%'  or u.UserType like '%".$SearchKey."%') " ):("");
			}

			$strSQLQuery .= (!empty($UserType))?(" and u.UserType='".$UserType."'"):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by u.UserID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			$strSQLQuery = "select u.* from user u ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function  CountUser($UserType)
		{
			$strSQLQuery = "select count(UserID) as TotalUser from user where locationID='".$_SESSION['locationID']."'";
			$strSQLQuery .= (!empty($UserType))?(" and u.UserType='".$UserType."'"):("");

			return $this->query($strSQLQuery, 1);		
		}	
		
		function GetUserList($arryDetails)
		{
			extract($arryDetails);

			$strSQLQuery = "select u.* from user u where 1 ";
			$strSQLQuery .= (!empty($UserID))?(" and u.UserID='".$UserID."'"):(" and u.locationID='".$_SESSION['locationID']."'");
			$strSQLQuery .= ($Status>0)?(" and u.Status='".$Status."'"):("");
			$strSQLQuery .= (!empty($UserType))?(" and u.UserType='".$UserType."'"):("");

			return $this->query($strSQLQuery, 1);
		}

		function  GetUser($UserID,$UserType,$Status)
		{
			$strSQLQuery = "select u.* from user u ";

			$strSQLQuery .= (!empty($UserID))?(" where u.UserID='".$UserID."'"):(" and u.locationID='".$_SESSION['locationID']."'");
			$strSQLQuery .= ($Status>0)?(" and u.Status='".$Status."'"):("");
			$strSQLQuery .= (!empty($UserType))?(" and u.UserType='".$UserType."'"):("");

			return $this->query($strSQLQuery, 1);
		}		
		
		function AddUser($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into user (locationID, UserType, UserName, Email, Password, Status, Role, UpdatedDate) values(  '".$_SESSION['locationID']."', '".addslashes($UserType)."', '".addslashes($UserName)."', '".addslashes($Email)."', '".md5($Password)."', '".$Status."', '".addslashes($Role)."', '".$Config['TodayDate']."')";
			$this->query($strSQLQuery, 0);
			$UserID = $this->lastInsertId();

			return $UserID;
		}

		function AddUserTemp($arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$strSQLQuery = "insert ignore into user (locationID, UserType, UserName, Email, Password, Status, Role, UpdatedDate) values(  '".$locationID."', '".addslashes($UserType)."', '".addslashes($UserName)."', '".addslashes($Email)."', '".$Password."', '".$Status."', '".addslashes($Role)."', '".$Config['TodayDate']."')";
			$this->query($strSQLQuery, 0);
			$UserID = $this->lastInsertId();

			return $UserID;
		}


		function UpdateUser($arryDetails){ 
			global $Config;
			extract($arryDetails);	
			$UserName = trim($FirstName.' '.$LastName);
			$strSQLQuery = "update user set UserName='".addslashes($UserName)."', Email='".addslashes($Email)."',   Status='".$Status."', Role='".addslashes($Role)."', UpdatedDate = '".$Config['TodayDate']."' where UserID='".$UserID."'"; 

			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdatePersonal($arryDetails){ 
			global $Config;
			extract($arryDetails);	
			$UserName = trim($FirstName.' '.$LastName);
			$strSQLQuery = "update user set UserName='".addslashes($UserName)."', UpdatedDate = '".$Config['TodayDate']."' where UserID='".$UserID."'"; 

			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdateAccount($arryDetails){   
			extract($arryDetails);
			if($Status=='') $Status=1;
			if(!empty($Password)) $PasswordSql = ", Password='".md5($Password)."'" ;

			$strSQLQuery = "update user set Email='".addslashes($Email)."', Status='".$Status."' ".$PasswordSql." where UserID='".$UserID."'"; 

			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdateRolePermission($arryDetails)
		{
			global $Config;	
			extract($arryDetails);
			$Role = "Admin";
			$strSQLQuery = "update user set Role='".$Role."' where UserID='".$UserID."' "; 
			$this->query($strSQLQuery, 0);
			
			$sql = "delete from permission where UserID='".$UserID."' "; 
			$rs = $this->query($sql,0);
			
			if($Role=="Admin"){

				if($Line>0){
					for($i=1;$i<=$Line; $i++){
						$ViewFlag = 0; $ModifyFlag = 0; $FullFlag = 0; 							$ModuleID=0;
						$ViewLabel = $arryDetails["ViewLabel".$i];
						$ModifyLabel = $arryDetails["ModifyLabel".$i];
						$FullLabel = $arryDetails["FullLabel".$i];

						if($ModifyLabel>0){
							$ModuleID = $ModifyLabel;
							$ModifyFlag = 1;
						}
						if($ViewLabel>0){
							$ModuleID = $ViewLabel;
							$ViewFlag = 1;
						}
						if($FullLabel>0){
							$ModuleID = $FullLabel;
							$FullFlag = 1;
						}
						
						if($ModuleID>0){
							$sql = "insert ignore into permission(UserID,ModuleID,ViewLabel,ModifyLabel,FullLabel) values('".$UserID."', '".$ModuleID."', '".$ViewFlag."', '".$ModifyFlag."', '".$FullFlag."')";
							$rs = $this->query($sql,0);
							$PermissionGiven = 1;
						}

					}
				}
			}
		
			/*******************************/
			if($PermissionGiven==1){
				$objEmployee=new employee();
				$arryRow = $objEmployee->GetEmployeeBrief($EmpID);
			
				
				$htmlPrefix = $Config['EmailTemplateFolder'];
				$contents = file_get_contents($htmlPrefix."role_admin.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[Role]","Admin",$contents);				
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[JobTitle]",$arryRow[0]['JobTitle'],$contents);
				$contents = str_replace("[Date]",$Config['TodayDate'],$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				//$mail->AddCC('parwez.khan@sakshay.in');
				/*if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}
				if(!empty($arrySupervisor[0]['Email'])){
					$mail->AddCC($arrySupervisor[0]['Email']);
				}*/		
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Role/Permissions Assigned";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}


			}

			/*******************************/
			return 1;

		}



		function UpdateRolePermissionNew($arryDetails)
		{
			//echo "<pre>";print_r($arryDetails);die;
			global $Config;	
			extract($arryDetails);
			$Role = "Admin";
			$strSQLQuery = "update user set Role='".$Role."' where UserID='".$UserID."' "; 
			$this->query($strSQLQuery, 0);
			
			$sql = "delete from permission where UserID='".$UserID."' "; 
			$rs = $this->query($sql,0);
			
			if($Role=="Admin"){

				if($Line>0){
					for($i=1;$i<=$Line; $i++){
						$AddFlag = 0;$EditFlag = 0;$DeleteFlag = 0;
						$ApproveFlag = 0;$ViewFlag = 0; $ViewAllFlag = 0;  $AssignFlag = 0; $FullFlag = 0; 					
						$ModuleID=0;
						$AddLabel = $arryDetails["AddLabel".$i];
						$EditLabel = $arryDetails["EditLabel".$i];
						$DeleteLabel = $arryDetails["DeleteLabel".$i];
						$ApproveLabel = $arryDetails["ApproveLabel".$i];
						$ViewLabel = $arryDetails["ViewLabel".$i];
						$ViewAllLabel = $arryDetails["ViewAllLabel".$i];
						$AssignLabel = $arryDetails["AssignLabel".$i];
						$FullLabel = $arryDetails["FullLabel".$i];

					        if($AddLabel>0){
							$ModuleID = $AddLabel;
							$AddFlag = 1;
						}
						if($EditLabel>0){
							$ModuleID = $EditLabel;
							$EditFlag = 1;
						}
						if($DeleteLabel>0){
							$ModuleID = $DeleteLabel;
							$DeleteFlag = 1;
						}
						if($ApproveLabel>0){
							$ModuleID = $ApproveLabel;
							$ApproveFlag = 1;
						}
						if($ViewLabel>0){
							$ModuleID = $ViewLabel;
							$ViewFlag = 1;
						}
						if($ViewAllLabel>0){
							$ModuleID = $ViewAllLabel;
							$ViewAllFlag = 1;
						}
						if($AssignLabel>0){
							$ModuleID = $AssignLabel;
							$AssignFlag = 1;
						}
						if($FullLabel>0){
							$ModuleID = $FullLabel;
							$FullFlag = 1;
						}
						
						if($ModuleID>0){
						    $sql = "insert ignore into permission(UserID, ModuleID, AddLabel, EditLabel, DeleteLabel, ApproveLabel, ViewLabel, ViewAllLabel, AssignLabel, FullLabel) values('".$UserID."', '".$ModuleID."', '".$AddFlag."', '".$EditFlag."', '".$DeleteFlag."', '".$ApproveFlag."', '".$ViewFlag."', '".$ViewAllFlag."', '".$AssignFlag."', '".$FullFlag."')";
							$rs = $this->query($sql,0);
							$PermissionGiven = 1;
						}

					}
				}
			}

		}

		function ChangePassword($UserID,$Password)
		{
			global $Config;				
		
			$strSQLQuery = "update user set Password='".mysql_real_escape_string(md5($Password))."', UpdatedDate = '".$Config['TodayDate']."' where UserID='".mysql_real_escape_string($UserID)."'";
			$this->query($strSQLQuery, 0);

			return 1;
		}		
				
		function ForgotPassword($Email,$UserType){
			
			global $Config;
			$sql = "select * from user where Email='".mysql_real_escape_string($Email)."' and UserType='".mysql_real_escape_string($UserType)."' and Status='1'"; 
			$arryRow = $this->query($sql, 1);
			$UserName = $arryRow[0]['UserName'];
			$UserID = $arryRow[0]['UserID'];

			if(sizeof($arryRow)>0)
			{
				$Password = substr(md5(rand(100,10000)),0,8);
				
				$sql_u = "update user set Password='".md5($Password)."'
				where UserID='".$UserID."'";
				$this->query($sql_u, 0);				
				return 1;
			}else{
				return 0;
			}
		}		
		

		function RemoveUser($UserID)
		{			
			$strSQLQuery = "delete from user where UserID='".$UserID."'"; 
			$this->query($strSQLQuery, 0);		
			
			$strSQLQuery = "delete from user_login where UserID='".$UserID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from user_login_page where UserID='".$UserID."'"; 
			$this->query($strSQLQuery, 0);				

			$strSQLQuery = "delete from permission where UserID = '".$UserID."'";
			$this->query($strSQLQuery, 0);	


			$strSQLQuery = "delete from user_secure where RefID='".$UserID."' and UserType='employee' "; 
			$this->query($strSQLQuery, 0);		

			return 1;
		}
				
		function changeUserStatus($UserID)
		{
			$sql="select * from user where UserID='".$UserID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update user set Status='$Status' where UserID='".$UserID."'";
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function ValidateUser($Email,$Password,$UserType){
			$strSQLQuery = "select * from user where MD5(LCASE(Email))='".md5(strtolower(trim($Email)))."' and Password='".md5($Password)."' and UserType='".$UserType."' and Status='1'"; 
			return $this->query($strSQLQuery, 1);
		}

		function isEmailExists($Email,$UserID=0,$UserType)
		{
			$strSQLQuery = (!empty($UserID))?(" and UserID != '".$UserID."'"):("");
			$strSQLQuery = "select UserID from user where LCASE(Email)='".strtolower(trim($Email))."' and UserType='".$UserType."' ".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['UserID'])) {
				return true;
			} else {
				return false;
			}
		}

		/************User Login Data****************/
		/*******************************************/
		function AddUserLogin($UserID,$UserType)
		{  
			global $Config;  
			 
			$LoginTime = $Config['TodayDate'];

			$LoginIP = GetIPAddress(); 
			$SessionID = session_id();

			$strSQLQuery = "insert into user_login (UserID, UserType, LoginTime, LoginIP, Browser,SessionID) values(  '".$UserID."', '".$UserType."', '".$LoginTime."', '".addslashes($LoginIP)."', '".$Config['Browser']."', '".$SessionID."')";
			$this->query($strSQLQuery, 0);
			
			/****************/
			$strSQLQuery = "select max(loginID) as CurrloginID from user_login where UserID='".$UserID."' and UserType='".$UserType."' order by loginID desc limit 0,1" ;
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]["CurrloginID"];
		}

		function UserLogoutOld($UserID,$UserType)
		{  
			global $Config;  
			 

			$LogoutTime = $Config['TodayDate'];

			$strSQLQuery = "select loginID from user_login where UserID='".$UserID."' and UserType='".$UserType."' order by loginID desc limit 0,1" ;
			$arryRow = $this->query($strSQLQuery, 1);
		
			if($arryRow[0]["loginID"]>0){
				$strSQLQuery = "update user_login set LogoutTime='".$LogoutTime."' where loginID='".$arryRow[0]["loginID"]."'";
				$this->query($strSQLQuery, 0);
			}
			return true;
		}

		function UserLogout($UserID,$UserType)
		{  
			global $Config;  
			if($_SESSION['loginID']>0){
				$LogoutTime = $Config['TodayDate'];

				$strSQLQuery = "select loginID from user_login where UserID='".$UserID."' and UserType='".$UserType."' and loginID='".$_SESSION['loginID']."' order by loginID desc limit 0,1" ;
				$arryRow = $this->query($strSQLQuery, 1);
		 
				if($arryRow[0]["loginID"]>0){
					$strSQLQuery = "update user_login set LogoutTime='".$LogoutTime."' where loginID='".$arryRow[0]["loginID"]."'";
					$this->query($strSQLQuery, 0);
				}
			}
			return true;
		}



		function GetLastLogin($UserID,$UserType)
		{  
			global $Config;
			$strSQLQuery = "select LoginTime from user_login where UserID='".$UserID."' and UserType='".$UserType."' order by loginID desc limit 1,1";
			$arryRow = $this->query($strSQLQuery, 1);
			if(!empty($arryRow[0]['LoginTime'])){
				return $arryRow[0]['LoginTime'];
			}
		}

		/******New User Log Functions*******/

		function GetUserLog($arryDetails)
		{  		
			extract($arryDetails);
			global $Config;
			$Today= date("Y-m-d");
			$strAddQuery = "";
			$SearchKey   = strtolower(trim($key));

			if(empty($Config['CurrentCmpTime'])) $Config['CurrentCmpTime']=date('Y-m-d H:i:s');
			if(empty($Config['SessionTimeout'])) $Config['SessionTimeout']=7200;
 
			if($SearchKey=='administrator' && ($sortby=='' || $sortby=='e.UserName' )){
				$strAddQuery .= " and u.UserType='admin' ";
			}else if($SearchKey != '' && $sortby=='e.UserName'){
				$strAddQuery .= " and (e.UserName like '%".$SearchKey."%' or c.Company like '%".$SearchKey."%' or c.FullName like '%".$SearchKey."%' or  s.UserName like '%".$SearchKey."%'  or  s.CompanyName like '%".$SearchKey."%'   or  sa.FullName like '%".$SearchKey."%' ) ";
			}else if($SearchKey != '' && $sortby=='e.Email'){
				$strAddQuery .= " and (e.Email like '%".$SearchKey."%' or c.Email like '%".$SearchKey."%' or s.Email like '%".$SearchKey."%' or sa.Email like '%".$SearchKey."%'  ) ";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%' or e.Email like '%".$SearchKey."%' or u.LoginIP like '%".$SearchKey."%' or c.Company like '%".$SearchKey."%' or c.FullName like '%".$SearchKey."%' or c.Email like '%".$SearchKey."%' or  s.UserName like '%".$SearchKey."%'  or  s.CompanyName like '%".$SearchKey."%'  or s.Email like '%".$SearchKey."%' or  sa.FullName like '%".$SearchKey."%' or sa.Email like '%".$SearchKey."%'  ) " ):("");			
			}
			$strAddQuery .= (!empty($loginID))?(" and u.loginID='".$loginID."'"):("");
			$strAddQuery .= ($mode=="online")?(" and u.Kicked!='1' and u.LogoutTime<=0 and u.LoginTime>='".$Today."'  and (u.LastViewTime>'0'  and TIME_TO_SEC(TIMEDIFF('".$Config['CurrentCmpTime']."', u.LastViewTime))<=".$Config['SessionTimeout']." )      "):("");
			
			$strAddQuery .= ($mode=="offline")?(" and (u.Kicked='1' or u.LogoutTime>'0' or u.LoginTime<'".$Today."' or (u.LastViewTime>'0' and TIME_TO_SEC(TIMEDIFF('".$Config['CurrentCmpTime']."', u.LastViewTime))>".$Config['SessionTimeout'].") )"):("");
 

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by u.loginID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			if($Config['GetNumRecords']==1){
				$Columns = " count(u.loginID) as NumCount ";				
			}else{				
				$Columns = "  u.*,e.EmpCode,e.EmpID,e.Email,e.UserName,e.JobTitle, s.SuppCode, s.Email as VendorEmail,IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName, IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName,c.Email as CustomerEmail, sa.Email as CustContactEmail, sa.FullName as  CustContactName ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			 $strSQLQuery = "select ".$Columns." from user_login u left outer join h_employee e on (u.UserID=e.UserID and u.UserType='employee' ) left outer join p_supplier s on (u.UserID=s.SuppID and u.UserType='vendor' ) left outer join s_customers c on (u.UserID=c.Cid and u.UserType='customer' )  left outer join s_address_book sa on (u.UserID=sa.AddID and u.UserType='customerContact' )   where 1 ".$strAddQuery; 
			return $this->query($strSQLQuery, 1);
		}

		function GetUserLogPage($arryDetails)
		{  		
			extract($arryDetails);
			$strAddQuery = " ";
			$SearchKey   = strtolower(trim($key));

			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (p.PageName like '%".$SearchKey."%' or p.PageUrl like '%".$SearchKey."%'   ) " ):("");			
			}
			$strAddQuery .= (!empty($loginID))?(" and p.loginID='".$loginID."'"):("");
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by p.pageID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select p.*,u.UserType from user_login_page p inner join user_login u on p.loginID=u.loginID where 1 ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		function AddUserLoginPage($arryDetails)
		{  
			global $Config;  

			extract($arryDetails);
	
			if(!empty($PageName)){
				$strSQLQuery = "select pageID from user_login_page where loginID='".$_SESSION['loginID']."' and PageUrl='".$PageUrl."' and PageName='".$PageName."' order by pageID desc limit 0,1" ;
				$arryRow = $this->query($strSQLQuery, 1);
				if(!empty($arryRow[0]["pageID"])){
					$strSQLQuery = "update user_login_page set ViewTime='".$_SESSION['TodayDate']."' where pageID='".$arryRow[0]["pageID"]."'";
					$this->query($strSQLQuery, 0);
				}else{			
					$strSQLQuery = "insert into user_login_page (loginID, UserID, PageUrl, PageName,PageHeading, ViewTime) values(  '".$_SESSION['loginID']."', '".$_SESSION['UserID']."', '".$PageUrl."', '".trim($PageName)."', '".mysql_real_escape_string(strip_tags($PageHeading))."', '".$_SESSION['TodayDate']."')";			
					$this->query($strSQLQuery, 0);
				}
			}
	

			return true;
		}

		function KickUser($loginIDs){
			if(!empty($loginIDs)){
				$sql="update user_login set Kicked='1' where loginID in ( ".mysql_real_escape_string($loginIDs).") and Kicked!='1'";
				$this->query($sql,0);				
			}
			return true;
		}
		

		function RemoveUserLog($arryDetails)
		{		
			extract($arryDetails);			
							
			if(!empty($DeleteBefore)){

				if($KeepNumRecord>0){
					#$DeleteBefore = '2015-02-10';$KeepNumRecord=2;

					$strSQLQuery = "select distinct(UserID),count(loginID) as TotalLog from user_login where LoginTime<'".$DeleteBefore."'  group by UserID"; 	
					$arryRow = $this->query($strSQLQuery, 1);
					if(sizeof($arryRow)>0){						
						foreach($arryRow as $key=>$values){
						if($values['TotalLog']>$KeepNumRecord){
						$RecordExist=1;
						$Limit = $values['TotalLog']-$KeepNumRecord;

						//echo $values['UserID'].':'.$values['TotalLog'].':'.$Limit.'<br>';
						
						$sql = "select loginID from user_login where UserID='".$values['UserID']."' and LoginTime<'".$DeleteBefore."' order by loginID asc limit 0, $Limit"; 				
						$arryR = $this->query($sql, 1);
						foreach($arryR as $keysub=>$valuessub){
					$strSQLQuery = "delete from user_login where loginID='".$valuessub['loginID']."' "; 
					$this->query($strSQLQuery, 0);

					$strSQLQuery2 = "delete from user_login_page where loginID='".$valuessub['loginID']."' "; 
					$this->query($strSQLQuery2, 0);

//echo $strSQLQuery.'<br>';
						}

		



						}
						}				

					}

				}else{
					$strSQLQuery = "delete from user_login where LoginTime<'".$DeleteBefore."' "; 
					$this->query($strSQLQuery, 0);

					$strSQLQuery2 = "delete from user_login_page where ViewTime<'".$DeleteBefore."' "; 
					$this->query($strSQLQuery2, 0);
					$RecordExist=1;
					
				}
			}

			if($RecordExist==1){
				$_SESSION['mess_log'] = USER_LOG_DELETED;
			}else{
				$_SESSION['mess_log'] = USER_LOG_NOT_DELETED;
			}					
			
			return 1;
		}


		function GetUserLoginByID($UserID,$UserType){  			 
			$strSQLQuery = "select * from user_login where UserID='".$UserID."' and UserType='".$UserType."' and Kicked!='1' order by loginID desc limit 0,1";
			return $this->query($strSQLQuery, 1);
  
		}

		function GetUserLoginMultiple($UserID,$UserType,$SessionTimeout){ 
			global $Config;
			$Today= date("Y-m-d"); 					 
			$strSQLQuery = "select  * from user_login where   Kicked!='1' and FLOOR(LogoutTime)<='0' and LoginTime>='".$Today."'  and LastViewTime>'0'   ";
			$arryRow = $this->query($strSQLQuery, 1);
			$NumUserLogin=0;
			
			foreach($arryRow as $key=>$values){
				$values['CurrentCmpTime'] = $Config['TodayDate']; 
				$values['SessionTimeout'] = $SessionTimeout; 

				$arryStatusDetail = CheckLoginStatus($values);
				if($arryStatusDetail[0]=='Online'){
					$NumUserLogin++;
				}
				/*if(!empty($_GET['abc'])){
					pr($values,0);
					pr($arryStatusDetail,0);
				}*/
			}
			
			/*if(!empty($_GET['abc'])){
				#echo $NumUserLogin; die;
			}*/

			return $NumUserLogin;  
		}

		/************User Move Data****************/
		/*******************************************/
		function MoveToUser($FromTable,$UserType,$FromID)
		{  
			$strSQLQuery = "select * from ".$FromTable." ";
			$arryRow = $this->query($strSQLQuery, 1);
			foreach($arryRow as $key=>$values){
				$values["UserType"] = $UserType;
				$UserID = $this->AddUserTemp($values);
				if($UserID>0){
					$strSQL = "update ".$FromTable." set UserID='".$UserID."' where ".$FromID."=".$values[$FromID]; 
					$this->query($strSQL, 0);
				}
			}
			return true;
		}

		

		function GetProfileLog($arryDetails)
		{          
		    extract($arryDetails);
		    global $Config;
		    $Today= date("Y-m-d");
			$strAddQuery='';
			if($Config['GetNumRecords']==1){
				$Columns = " count(u.logID) as NumCount ";				
			}else{				
				$Columns = "   u.*,e.EmpCode,e.EmpID,e.Email,e.UserName,e.JobTitle ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
			
			}

		    $strSQLQuery = "select ".$Columns." from h_employee_log_history u left outer join h_employee e on (u.empID=e.EmpID)  order by logID desc ".$strAddQuery;
		    
		    
		    return $this->query($strSQLQuery, 1);
		}
		
		
		function deleteProfileLog($arryDetails)
		{  		
		
		 $count=count($arryDetails);
		 for($i=0;$i<$count;$i++){
		 	$logID=$arryDetails[$i];
		 	$strSQLQuery="DELETE FROM h_employee_log_history WHERE logID='".$logID."'";
		    $this->query($strSQLQuery, 1);

		 }

		 
		}

	
	function UpdateSecurityLevel($arryDetails){ 
		global $Config;
		extract($arryDetails);
		/*if($EnableSecurity == '1'){
			$UserSecurity = 0; 
		}else{
			$UserSecurity = 1;
		}*/

		$AllowSecurityUser = rtrim($AllowSecurityUser,',');		

		if($_SESSION['AdminType'] == "admin"){	
			$strSQLQuery = "update ".$Config['DbMain'].".company set UserSecurity='".$UserSecurity."',AllowSecurityUser='".$AllowSecurityUser."' where CmpID='".$_SESSION['CmpID']."'";
		}else{
			$strSQLQuery = "update user set UserSecurity='".$UserSecurity."',AllowSecurityUser='".$AllowSecurityUser."' where UserID='".$_SESSION['UserID']."'";
		}
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function UpdateEmpSecurityLevel($arryDetails){ 
		global $Config;
		extract($arryDetails);
	 

		$AllowSecurityEmp = rtrim($AllowSecurityEmp,',');		
 
		$strSQLQuery = "update user set UserSecurity='".$UserSecurity."',AllowSecurityUser='".$AllowSecurityEmp."' where UserID='".$UserID."'";
		 
		$this->query($strSQLQuery, 0);
		return 1;
	}
	
	function UpdateAuthSecretKey($AuthSecretKey){ 
		global $Config;	 
		if($_SESSION['AdminType'] == "admin"){	
			$strSQLQuery = "update ".$Config['DbMain'].".company set AuthSecretKey='".$AuthSecretKey."'  where CmpID='".$_SESSION['CmpID']."'";
		}else{
			$strSQLQuery = "update user set AuthSecretKey='".$AuthSecretKey."' where UserID='".$_SESSION['UserID']."'";
		}
		$this->query($strSQLQuery, 0);
		return 1;
	}

}
?>
