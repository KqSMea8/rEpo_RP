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
			$strAddQuery .= (!empty($id))?(" where u.UserID=".$id):(" where u.locationID=".$_SESSION['locationID']);

			if($SearchKey=='active' && ($SortBy=='u.Status' || $SortBy=='') ){
				$strAddQuery .= " and u.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='u.Status' || $SortBy=='') ){
				$strAddQuery .= " and u.Status=0";
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
			$strSQLQuery = "select count(UserID) as TotalUser from user where locationID=".$_SESSION['locationID'];
			$strSQLQuery .= (!empty($UserType))?(" and u.UserType='".$UserType."'"):("");

			return $this->query($strSQLQuery, 1);		
		}	
		
		function GetUserList($arryDetails)
		{
			extract($arryDetails);

			$strSQLQuery = "select u.* from user u where 1 ";
			$strSQLQuery .= (!empty($UserID))?(" and u.UserID=".$UserID):(" and u.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= ($Status>0)?(" and u.Status=".$Status):("");
			$strSQLQuery .= (!empty($UserType))?(" and u.UserType='".$UserType."'"):("");

			return $this->query($strSQLQuery, 1);
		}

		function  GetUser($UserID,$UserType,$Status)
		{
			$strSQLQuery = "select u.* from user u ";

			$strSQLQuery .= (!empty($UserID))?(" where u.UserID=".$UserID):(" and u.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= ($Status>0)?(" and u.Status=".$Status):("");
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
			$strSQLQuery = "update user set UserName='".addslashes($UserName)."', Email='".addslashes($Email)."',   Status='".$Status."', Role='".addslashes($Role)."', UpdatedDate = '".$Config['TodayDate']."' where UserID=".$UserID; 

			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdatePersonal($arryDetails){ 
			global $Config;
			extract($arryDetails);	
			$UserName = trim($FirstName.' '.$LastName);
			$strSQLQuery = "update user set UserName='".addslashes($UserName)."', UpdatedDate = '".$Config['TodayDate']."' where UserID=".$UserID; 

			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdateAccount($arryDetails){   
			extract($arryDetails);
			if($Status=='') $Status=1;
			if(!empty($Password)) $PasswordSql = ", Password='".md5($Password)."'" ;

			$strSQLQuery = "update user set Email='".addslashes($Email)."', Status='".$Status."' ".$PasswordSql." where UserID=".$UserID; 

			$this->query($strSQLQuery, 0);
			return 1;
		}

		function UpdateRolePermission($arryDetails)
		{
			global $Config;	
			extract($arryDetails);
			$strSQLQuery = "update user set Role='".$Role."' where UserID=".$UserID; 
			$this->query($strSQLQuery, 0);
			
			$sql = "delete from permission where UserID =".$UserID;
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


		function ChangePassword($UserID,$Password)
		{
			global $Config;				
		
			$strSQLQuery = "update user set Password='".mysql_real_escape_string(md5($Password))."', UpdatedDate = '".$Config['TodayDate']."' where UserID='".mysql_real_escape_string($UserID)."'";
			$this->query($strSQLQuery, 0);

			return 1;
		}		
				
		function ForgotPassword($Email,$UserType){
			
			global $Config;
			$sql = "select * from user where Email='".mysql_real_escape_string($Email)."' and UserType='".mysql_real_escape_string($UserType)."' and Status=1"; 
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
			$strSQLQuery = "delete from user where UserID=".$UserID; 
			$this->query($strSQLQuery, 0);		
			
			$strSQLQuery = "delete from user_login where UserID=".$UserID; 
			$this->query($strSQLQuery, 0);			

			$strSQLQuery = "delete from permission where UserID = ".$UserID;
			$this->query($strSQLQuery, 0);			

			return 1;
		}
				
		function changeUserStatus($UserID)
		{
			$sql="select * from user where UserID=".$UserID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update user set Status='$Status' where UserID=".$UserID;
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function ValidateUser($Email,$Password,$UserType){
			$strSQLQuery = "select * from user where MD5(Email)='".md5($Email)."' and Password='".md5($Password)."' and UserType='".$UserType."' and Status=1"; 
			return $this->query($strSQLQuery, 1);
		}

		function isEmailExists($Email,$UserID=0,$UserType)
		{
			$strSQLQuery = (!empty($UserID))?(" and UserID != ".$UserID):("");
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
			/*global $Config;  
			$LoginTime = (!empty($Config['TodayDate']))?($Config['TodayDate']):(date("Y-m-d H:i:s"));*/

			$LoginTime = date("Y-m-d H:i:s");

			$LoginIP = $_SERVER["REMOTE_ADDR"];

			$strSQLQuery = "insert into user_login (UserID, UserType, LoginTime, LoginIP) values(  '".$UserID."', '".$UserType."', '".$LoginTime."', '".addslashes($LoginIP)."')";
			$this->query($strSQLQuery, 0);

			return true;
		}

		function UserLogout($UserID,$UserType)
		{  
			/*global $Config;  
			$LogoutTime = (!empty($Config['TodayDate']))?($Config['TodayDate']):(date("Y-m-d H:i:s"));*/

			$LogoutTime = date("Y-m-d H:i:s");

			$strSQLQuery = "select loginID from user_login where UserID=".$UserID." and UserType='".$UserType."' order by loginID desc limit 0,1" ;
			$arryRow = $this->query($strSQLQuery, 1);
		
			if($arryRow[0]["loginID"]>0){
				$strSQLQuery = "update user_login set LogoutTime='".$LogoutTime."' where loginID=".$arryRow[0]["loginID"];
				$this->query($strSQLQuery, 0);
			}
			return true;
		}

		function GetLastLogin($UserID,$UserType)
		{  
			global $Config;
			$strSQLQuery = "select LoginTime from user_login where UserID='".$UserID."' and UserType='".$UserType."' order by loginID desc limit 1,1";
			$arryRow = $this->query($strSQLQuery, 1);

			return $arryRow[0]['LoginTime'];
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
					$strSQL = "update ".$FromTable." set UserID=".$UserID." where ".$FromID."=".$values[$FromID]; 
					$this->query($strSQL, 0);
				}
			}
			return true;
		}

		





}
?>
