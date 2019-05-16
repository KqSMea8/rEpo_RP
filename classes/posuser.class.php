<?
class posuser extends dbClass
{
		//constructor
		function posuser()
		{
			$this->dbClass();
		} 
		
		function  ListUser($id=0,$UserType,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where u.UserID='".$id."'"):(" where u.locationID='".$_SESSION['locationID']."'");

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

//Update shift Notification By Niraj
function GetNotification()
		{
			$strSQLQuery = "select * from pos_shiftNotification where id='1'";
			return $this->query($strSQLQuery, 1);
		}	

function addUpdateNotification($arryDetails){  #echo "<pre>";print_r($_SESSION); print_r($arryDetails);die('database');
			global $Config;
			extract($arryDetails);	
			$strSQLQuery = "update pos_shiftNotification set vendor_id = '".addslashes($_SESSION['vendorId'])."',requestingShift='".addslashes($requestingShift)."',acceptingShift = '".addslashes($requestingShift)."',revokingShift = '".addslashes($revokingShift)."',mailNotification = '".addslashes($mailNotification)."' where id='1'"; 

			$this->query($strSQLQuery, 0);
			return 1;
		}
//End Update Notification By Niraj


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
			$strSQLQuery = "delete from user where UserID='".$UserID."'"; 
			$this->query($strSQLQuery, 0);		
			
			$strSQLQuery = "delete from user_login where UserID='".$UserID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from user_login_page where UserID='".$UserID."'"; 
			$this->query($strSQLQuery, 0);				

			$strSQLQuery = "delete from permission where UserID = '".$UserID."'";
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
			$strSQLQuery = "select * from user where MD5(LCASE(Email))='".md5(strtolower(trim($Email)))."' and Password='".md5($Password)."' and UserType='".$UserType."' and Status=1"; 
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
			/*$LoginTime = (!empty($Config['TodayDate']))?($Config['TodayDate']):(date("Y-m-d H:i:s"));*/

			$LoginTime = date("Y-m-d H:i:s");

			$LoginIP = $_SERVER["REMOTE_ADDR"];
			
			$strSQLQuery = "insert into user_login (UserID, UserType, LoginTime, LoginIP, Browser) values(  '".$UserID."', '".$UserType."', '".$LoginTime."', '".addslashes($LoginIP)."', '".$Config['Browser']."')";
			$this->query($strSQLQuery, 0);
			
			/****************/
			$strSQLQuery = "select max(loginID) as CurrloginID from user_login where UserID='".$UserID."' and UserType='".$UserType."' order by loginID desc limit 0,1" ;
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]["CurrloginID"];
		}

		function UserLogout($UserID,$UserType)
		{  
			/*global $Config;  
			$LogoutTime = (!empty($Config['TodayDate']))?($Config['TodayDate']):(date("Y-m-d H:i:s"));*/

			$LogoutTime = date("Y-m-d H:i:s");

			$strSQLQuery = "select loginID from user_login where UserID='".$UserID."' and UserType='".$UserType."' order by loginID desc limit 0,1" ;
			$arryRow = $this->query($strSQLQuery, 1);
		
			if($arryRow[0]["loginID"]>0){
				$strSQLQuery = "update user_login set LogoutTime='".$LogoutTime."' where loginID='".$arryRow[0]["loginID"]."'";
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

		/******New User Log Functions*******/

		function GetUserLog($arryDetails)
		{  		
			extract($arryDetails);
			$Today= date("Y-m-d");
			//$strAddQuery = " and u.UserType='employee' ";
			$SearchKey   = strtolower(trim($key));

			if($SearchKey=='administrator' && ($sortby=='' || $sortby=='e.UserName' )){
				$strAddQuery .= " and u.UserType='admin' ";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%' or e.Email like '%".$SearchKey."%' or u.LoginIP like '%".$SearchKey."%'   ) " ):("");			
			}
			$strAddQuery .= (!empty($loginID))?(" and u.loginID='".$loginID."'"):("");
			$strAddQuery .= ($mode=="online")?(" and u.Kicked!=1 and u.LogoutTime<=0 and u.LoginTime>='".$Today."'"):("");
			
			$strAddQuery .= ($mode=="offline")?(" and (u.Kicked=1 or u.LogoutTime>0 or u.LoginTime<'".$Today."' )"):("");
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by u.loginID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select u.*,e.EmpCode,e.EmpID,e.Email,e.UserName,e.JobTitle from user_login u left outer join h_employee e on (u.UserID=e.UserID and u.UserType='employee' ) where 1 ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		function GetUserLogPage($arryDetails)
		{  		
			extract($arryDetails);
			//$strAddQuery = " and u.UserType='employee' ";
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
				if($arryRow[0]["pageID"]>0){
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
		    $Today= date("Y-m-d");
		    $strSQLQuery = "select u.*,e.EmpCode,e.EmpID,e.Email,e.UserName,e.JobTitle from h_employee_log_history u left outer join h_employee e on (u.empID=e.EmpID)  order by logID desc";
		    
		    
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
		
		/*
		Created By : Pankaj Kumar
		Date:  02-06-16
		Return : array
		param : email
		*/		
		
		function checkEmail($email=""){
			 global $Config;
			$strSQLQuery =  "select * from ".$Config['DbMain'].".company_user_pos where user_name='".$email."'";
			
			return $this->query($strSQLQuery, 1);
			
		}
		
		function getUserInfo($id){
			$strSQLQuery =  "select * from e_customers where Cid='".$id."'";
			return $this->query($strSQLQuery, 1);
		}
		
		function isUserLogin(){
			
			if(empty($_SESSION)){
				 session_destroy();
			     header("location:index.php");
			     exit();
			}
			
			if(empty($_SESSION['UserData']['custType'])){
				 session_destroy();
			     header("location:index.php");
			     exit();
				
			}
		}
		
        function getScheduleByUserId($date,$userId){
			$strSQLQuery =  "select * from pos_schedule where user_id='".$userId."' and DATE(start_date)='".$date."'";
			$resutl =  $this->query($strSQLQuery, 1);
			if(count($resutl)>0){
				$stringDate ="";
				foreach($resutl as $val){
						$startTime =  date('h:i a',strtotime($val['start_date']));
						$end_date =   date('h:i a',strtotime($val['end_date']));
						
						$stringDate .=  "<a href='javascript:void(0);' data-id='".$val['id']."' data-startdate='".$val['start_date']."' data-enddate='".$val['end_date']."' id='editschedule'>".$startTime." - ".$end_date."</a><br>";
				}
				return $stringDate;
			}
		}
		
		function getServerUserList($vendorId){
			
			$strSQLQuery =  "select * from e_customers where Parent='".$vendorId."' and custType in('server','seniorserver') and status='Yes'";
			$resutl =  $this->query($strSQLQuery, 1);
			return $resutl;
		}
		
		function getCustomerUserList($vendorId){
			
			$strSQLQuery =  "select * from e_customers where Parent='".$vendorId."' and custType = 'poscustomer' and status='Yes'";
			$resutl =  $this->query($strSQLQuery, 1);
			return $resutl;
		}
		function getResult($tableName,$data=array()){
			$where =  "1";
			 if(count($data)){
				 foreach($data as $key=>$val){
					 $where .= " and `$key` = '{$val}'";
					 
				 }
				  $strSQLQuery = "select * from $tableName where $where";
				  return $this->query($strSQLQuery, 1);
				 
			 }
			
		}
		
		
	/************Get Vendor Profile by karishma*****************/
	function  getVendorProfile($VendorId)
	{
		$sql = "select * from e_customers where Cid ='".addslashes($VendorId)."'  ";
		return $this->query($sql, 1);

	}
	/************End Vendor Profile by karishma*****************/	
	function isPosUser($LoginEmail){	
		$sql = "select * from company_user_pos where user_name ='".addslashes($LoginEmail)."'";
		return $this->query($sql, 1);
	}
	
	
	function getUserPermission($where){
		 $whereData ="where 1";
		 $whereData  .= " and user.user_id='".$where['user_id']."'";
		 $whereData  .= " order by module.order_module ASC";
		
		$strSQLQuery = "select module.* from pos_module_user as user 
		              left join pos_module as module on user.module_id=module.id ".$whereData."";
		
		$result =  $this->query($strSQLQuery, 1);
		return $result;
		
	}
	
	function getUserActionPermission($where){
		 $whereData ="where 1";
		 $whereData  .= " and user.user_id='".$where['user_id']."'";
		 $whereData  .= " and action.action_page='".$where['action_page']."'";
		 
		
		 $strSQLQuery = "select action.* from pos_module_user as user 
		              left join pos_module_action as action on user.module_id=action.module_id ".$whereData."";
		
		$result =  $this->query($strSQLQuery, 1);
		if(count($result)>0){
			return false;
		}
		
		return true;
		
	}
	
	// accept request revoke shift by karishma
	
	function  getUserSchedule($UserId)
	{
		$sql = "select *,(case when `status`='Accept Shifts' then 'Worked Shifts' else 'Worked Shifts' end) `status` 
from pos_schedule where user_id ='".addslashes($UserId)."'
and (`status`='Worked Shifts' or `status`='Accept Shifts') ";
		return $this->query($sql, 1);

	}

	function  getOtherUserSchedule($UserId,$status)
	{
		$sql = "select a.*,b.id as acceptId from pos_schedule as a
	left join pos_schedule b on b.parentId=a.parentId and b.`status`='Accept Shifts'
where a.user_id!='".addslashes($UserId)."' and a.`status`='".addslashes($status)."' having acceptId is null"; 
		return $this->query($sql, 1);

	}

	function  getUserScheduleById($Id)
	{
		$sql = "select ps.*,concat(ec.FirstName,' ',ec.LastName) as Name from pos_schedule  ps
		inner join e_customers ec on ec.Cid=ps.user_id
		where ps.id ='".addslashes($Id)."'  ";
		return $this->query($sql, 1);

	}

	function  getUserScheduleByRequestAccept($UserId)
	{
		$sql = "select b.* from pos_schedule as a
	inner join pos_schedule b on b.parentId=a.id 
	where a.user_id='".addslashes($UserId)."' 
	and a.`status`='Worked Shifts';";
		return $this->query($sql, 1);

	}
	
	function getAcceptedScheduleById($Id){
		$sql = "select ps.*,concat(ec.FirstName,' ',ec.LastName) as AcceptName ,
		concat(ec1.FirstName,' ',ec1.LastName) as AssignName
		from pos_schedule ps 
		inner join e_customers ec on ec.Cid=ps.user_id 
		inner join pos_schedule b on b.id=ps.parentId
		inner join e_customers ec1 on ec1.Cid=b.user_id
		where ps.id = '".addslashes($Id)."'  ";
		return $this->query($sql, 1);
	}
	
function  getCheckhasShift($UserId,$start,$end)
	{
		$date=date('Y-m-d',strtotime($start));
		 $sql = "select *,(case WHEN '".addslashes($start)."' BETWEEN start_date AND end_date then '1'
		ELSE '0'
		END ) as startdiff, (case WHEN '".addslashes($end)."' BETWEEN start_date AND end_date then '1'
		ELSE '0'
		END ) as enddiff,
		(case WHEN start_date BETWEEN '".addslashes($start)."' AND '".addslashes($end)."' then '1'
		ELSE '0'
		END ) as startdiff1, (case WHEN end_date BETWEEN '".addslashes($start)."' AND '".addslashes($end)."' then '1'
		ELSE '0'
		END ) as enddiff1 
		from
		    pos_schedule
		where
    user_id = '".addslashes($UserId)."'
 	and date_format(start_date,'%Y-%m-%d')='".addslashes($date)."'
        and (`status` = 'Worked Shifts'
        or `status` = 'Accept Shifts')"; 
		return $this->query($sql, 1);

	}
	
	function scheduleEmail($loginId,$VendorId,$notifications,$scheduleData){
		global $Config;
		
		$htmlPrefix = $Config['EmailTemplateFolder'];

		// get login User profile
		$loginUser=$this->getVendorProfile($loginId);
		foreach($loginUser as $list){
			if($scheduleData['type']=='request'){
				$contents = file_get_contents($htmlPrefix."requestscheduleUserEmail.htm");
			}else{
				$contents = file_get_contents($htmlPrefix."scheduleUserEmail.htm");
			}
			
				
			$FullName = ucfirst($list['FirstName'])." ".ucfirst($list['LastName']);
			$LoginUserName = $FullName;
			$ContentMsg = "You have successfully ".$scheduleData['type']." a shift trade";
				
			$contents = str_replace("[FULLNAME]",$FullName,$contents);
			$contents = str_replace("[SiteUrl]",$Config['SiteUrl'],$contents);
			$contents = str_replace("[ContentMsg]",$ContentMsg,$contents);
			$contents = str_replace("[START]",date('d,M Y h:i:s A',strtotime($scheduleData['start_date'])),$contents);
			$contents = str_replace("[END]",date('d,M Y h:i:s A',strtotime($scheduleData['end_date'])),$contents);
			$contents = str_replace("[REASON]",$scheduleData['reason'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$Email=$list['Email'];

			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($Email);
			$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);
			$mail->Subject = $Config['StoreName']." - Request Shift Trade";
			$mail->IsHTML(true);
			$mail->Body = $contents;
			$mail->Send();
		}
		// get other User profile as per notification setting
		$NotifyUserList=$this->getNotifyUserProfile($loginId,$VendorId,$notifications);
		foreach($NotifyUserList as $list){
			if($scheduleData['type']=='request'){
				$contents = file_get_contents($htmlPrefix."requestscheduleUserEmail.htm");
			}else{
				$contents = file_get_contents($htmlPrefix."scheduleUserEmail.htm");
			}
							
			$FullName = ucfirst($list['FirstName'])." ".ucfirst($list['LastName']);			
			$ContentMsg = $LoginUserName. " ".$scheduleData['type']." a shift trade";				
			$contents = str_replace("[FULLNAME]",$FullName,$contents);
			$contents = str_replace("[SiteUrl]",$Config['SiteUrl'],$contents);
			$contents = str_replace("[ContentMsg]",$ContentMsg,$contents);
			$contents = str_replace("[START]",date('d,M Y h:i:s A',strtotime($scheduleData['start_date'])),$contents);
			$contents = str_replace("[END]",date('d,M Y h:i:s A',strtotime($scheduleData['end_date'])),$contents);
			$contents = str_replace("[REASON]",$scheduleData['reason'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$Email=$list['Email'];

			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($Email);
			$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);
			$mail->Subject = $Config['StoreName']." - Request Shift Trade";
			$mail->IsHTML(true);
			$mail->Body = $contents;
			$mail->Send();
		}
		

	}

	function getNotifyUserProfile($loginId,$VendorId,$notifications){

		// all type of user
		if(strtolower($notifications)=='everyone'){
			$sql = "select * from e_customers where Cid !='".addslashes($loginId)."'
			and  (Cid ='".addslashes($VendorId)."' or Parent='".addslashes($VendorId)."') 
			and custType!='poscustomer' ";
			return $this->query($sql, 1);
		}
		// only super admin
		elseif(strtolower($notifications)=='managers'){
			$sql = "select * from e_customers where Cid !='".addslashes($loginId)."'
			and  Cid ='".addslashes($VendorId)."' ";
			return $this->query($sql, 1);
		}
		// only server
		elseif(strtolower($notifications)=='1'){
			$sql = "select * from e_customers where Cid !='".addslashes($loginId)."'
			and  Parent ='".addslashes($VendorId)."' and custType='server'";
			return $this->query($sql, 1);
		}
		// only seniorserver
		elseif(strtolower($notifications)=='2'){
			$sql = "select * from e_customers where Cid !='".addslashes($loginId)."'
			and  Parent ='".addslashes($VendorId)."' and custType='seniorserver' ";
			return $this->query($sql, 1);
		}
		// only vendorpos
		elseif(strtolower($notifications)=='3'){
			$sql = "select * from e_customers where Cid !='".addslashes($loginId)."'
			and  Parent ='".addslashes($VendorId)."' and custType='vendorpos' ";
			return $this->query($sql, 1);
		}


	}
	
	// accept request revoke shift by karishma
	
	function getServerDateTime(){
		$sql ="select date_format(now(),'%a %b %d %Y %H:%i:%s') as currentDate";
		$ServerDateTime=$this->query($sql, 1);
		return $ServerDateTime[0]['currentDate'];
	}
	
	
	function getProductItem($orderId){
		
		$sql ="select posItem.*,erpItem.ItemID,erpItem.Sku from pos_order_item as posItem left join inv_items as erpItem  on erpItem.ref_id=posItem.product_id and erpItem.product_source='pos' where posItem.order_id='".$orderId."'";
		
		return $this->query($sql, 1);
	}
	
	function getProductModiItem($orderId){
		
		$sql ="select posItem.*,erpItem.ItemID,erpItem.Sku from pos_order_item_modifiers as posItem left join inv_items as erpItem  on erpItem.ref_id=posItem.modifiers_product_id and erpItem.product_source='pos' where posItem.order_item_id='".$orderId."'";
		
		return $this->query($sql, 1);
	}
	
	
	function getInvoiceCompleteOrder(){
		$sql ="select orders.*, setting.data as LocationName from pos_order as orders left join pos_settings as setting on setting.id=orders.location_id and setting.action='basic_location_sttings' where orders.is_invoice_created='No' and orders.order_status='completed'";
		
		return $this->query($sql, 1);
		
	}
	
	
}
?>
