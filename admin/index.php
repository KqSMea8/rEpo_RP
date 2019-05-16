<?php 
	

	/***********************
	if(empty($_POST['LoginEmail'])) { 
		include("includes/license.php");

		if(!file_exists("../includes/config.php")){
			header('location:../install/index.php');
			exit;	
		}		
	}
	/***********************/

	$LoginPage=1;
	require_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/employee.class.php");
	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../includes/browser_detection.php");

	/***********************/
	/*if($Config['Online']=='1'){
		if(substr_count($_SERVER['HTTP_HOST'],"www.")!=1){
			$url_red =  'http://www.eznetcrm.com/erp/admin/';
			Header( "HTTP/1.1 301 Moved Permanently" );
			header("Location: ".$url_red);
			exit;
		}
	}*/
	/***********************/


	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();

	$objConfig = new admin();

	CleanGet();
		

	if(isset($_SESSION['CmpLogin'])) unset($_SESSION['CmpLogin']);

	$mess = $RefID = $DbName2 = $ExpiryDate = $UserType= '';
	$ValidLogin = $LiveMode = $MaxUser = $CmpID = 0;
	if(empty($_SESSION['login_attempt'])) $_SESSION['login_attempt']='';
	(empty($_GET['crm']))?($_GET['crm']=""):(""); 
	 
 
	/***********************/
	if(!empty($_POST['LoginEmail'])) {
		CleanPost();

		if(empty($_POST['LoginEmail'])) {
			$mess = INVALID_EMAIL_PASSWORD;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		}else{ 
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();

			/************
			$arryMain = $objCompany->GetCompanyDetailDisplay($_GET["c"]);
			$DbName2 = $Config['DbName']."_".$arryMain[0]['DisplayName'];
			$CmpID = (int)$arryMain[0]['CmpID'];
			/**********************************/
			//$UserType = mysql_real_escape_string($_POST['UserType']); 
			$LoginEmail = mysql_real_escape_string($_POST['LoginEmail']); 
			$LoginPassword = mysql_real_escape_string($_POST['LoginPassword']);

			$ArryUserEmail = $objConfig->CheckUserEmail($LoginEmail); 
			
			if(!empty($ArryUserEmail[0]['CmpID'])){
				$LiveMode = (int)$ArryUserEmail[0]['LiveMode'];
				$MaxUser = (int)$ArryUserEmail[0]['MaxUser'];
				$CmpID = (int)mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
				$RefID = (int)mysql_real_escape_string($ArryUserEmail[0]['RefID']);
				$DbName2 = $Config['DbName']."_".$ArryUserEmail[0]['DisplayName'];

				$ExpiryDate = $ArryUserEmail[0]['ExpiryDate'];
			}	
			$Config['DbName2'] = $DbName2;
			if(!$objConfig->connect_check()){ 
				$mess = ERROR_NO_DB;
			}else if($ExpiryDate>0){				
				if($ExpiryDate<date('Y-m-d')){
					$mess = ERROR_PCKG_EXP;
				}
			}

			if(!empty($ArryUserEmail[0]['LoginBlock'])){
				$LoginIP = explode(",",$ArryUserEmail[0]['LoginIP']);
				$Ipaddress = GetIPAddress();
				if(!in_array($Ipaddress,$LoginIP)){
					$mess = BLOCKED_MSG;
				}
			}

			/*****************			
			$ValidateLicense=1;  $LicenseKey = $ArryUserEmail[0]['LicenseKey'];
			include("includes/license.php");
			/*****************/



			/**********************************/
			if(empty($mess) && $CmpID>0 && $RefID==0){ // Company Login Check

				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

				$ArryCompany = $objCompany->ValidateCompany($LoginEmail, $LoginPassword, $CmpID);	

				


				if(!empty($ArryCompany[0]['CmpID'])){ // Company Login Check
					session_regenerate_id(true); 
					
					$_SESSION['AdminID'] = (int)$ArryCompany[0]['CmpID']; 
					$_SESSION['UserID'] = (int)$ArryCompany[0]['CmpID']; 
					$_SESSION['CmpID'] = (int)$CmpID; 
					$_SESSION['AdminType'] = "admin"; 
					$_SESSION['DisplayName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['UserName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['AdminEmail'] = $ArryCompany[0]['Email'];					
					$_SESSION['AdminPassword'] = $ArryCompany[0]['Password'];			
					$_SESSION['CmpDatabase'] = $DbName2;
					$_SESSION['CmpDepartment'] = $ArryUserEmail[0]['Department'];
					$UserType = "admin";
					$ValidLogin = 1;
					$arryMain = $objCompany->GetCompanyDetailDisplay($ArryCompany[0]['DisplayName']);
	
					
				}

			}else if(empty($mess) && $CmpID>0 && $RefID>0){ // User Login Check

				if($ValidLogin!=1){
				$UserType = "employee";


				$Config['DbName'] = $DbName2;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();  
				$ArryUser = $objUser->ValidateUser($LoginEmail, $LoginPassword, $UserType);
				if(!empty($ArryUser[0]['UserID'])){


					
					if($UserType=="employee"){  /************ Employee *************/
						$ArryEmployee = $objEmployee->GetEmployeeUser($ArryUser[0]['UserID'], 1);
 
						if(!empty($ArryEmployee[0]['EmpID'])){
							session_regenerate_id(true); 
							$_SESSION['AdminID'] = (int)$ArryEmployee[0]['EmpID']; 
							$_SESSION['UserID'] = (int)$ArryEmployee[0]['UserID']; 
							$_SESSION['CmpID'] = (int)$CmpID; 
							$_SESSION['AdminType'] = "employee"; 
							$_SESSION['DisplayName'] = $ArryUserEmail[0]['DisplayName'];
							$_SESSION['UserName'] = $ArryEmployee[0]['UserName'];
							$_SESSION['AdminEmail'] = $ArryEmployee[0]['Email'];					
							$_SESSION['AdminPassword'] = $ArryEmployee[0]['Password'];			
							$_SESSION['EmpEmail'] = $ArryEmployee[0]['Email'];					
							$_SESSION['CmpDatabase'] = $DbName2;
							$_SESSION['locationID'] = $ArryEmployee[0]['locationID'];	
							$_SESSION['CmpDepartment'] = $ArryUserEmail[0]['Department'];
							$ValidLogin = 1;


							
							
						}
					}else if($UserType=="supplier"){  /************ Supplier *************/
						#$ArrySupplier = $objSupplier->GetSupplierUser($ArryUser[0]['UserID'], 1);
						#$UserType = "supplier";
					}


					




				}else{
					/*******/
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();  
					require_once("includes/customer_vendor_login.php");
					/*******/
				}
				
			    }



			}else{ // User Login Check

				/******Start Customer/Supplier*************/
				require_once("includes/customer_vendor_login.php");
				/******End Customer/Supplier***************/
				
			}




			/********************/  

			if($ValidLogin==1 && !empty($_SESSION['UserID'])){
				
				$_SESSION['CmpLogin'] = $_GET["crm"];

				
				setcookie("DisplayNameCookie", $_SESSION['DisplayName'], time()+(24*30*3600));

				if(!empty($_SESSION['AdminType'])){
					if($_SESSION['AdminType']=="admin"){
						$Config['DbName'] = $DbName2;
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();  
					}
				}

				 
				$Config['TodayDate'] = getLocalTime($ArryUserEmail[0]['Timezone']);
				$SessionTimeout = ($ArryUserEmail[0]['SessionTimeout']>0)?($ArryUserEmail[0]['SessionTimeout']):(7200);
				 
				
				/***** Is User Already Logged In ************/
				 


				if($LiveMode=='1'){
					$arryUserLogin = $objUser->GetUserLoginByID($_SESSION['UserID'],$UserType);
 
					if(!empty($arryUserLogin[0]['loginID'])){
						$arryUserLogin[0]['SessionTimeout'] = $SessionTimeout; 
						$arryUserLogin[0]['CurrentCmpTime'] = $Config['TodayDate']; 
						$arryStatusDetail = CheckLoginStatus($arryUserLogin[0]); 						if($arryStatusDetail[0]=='Online'){
							$_SESSION['login_msg'] = ALREADY_LOGIN;	
							header("location:index.php");
							exit;
						}else if(!empty($MaxUser)){ //Check Allowed Number Of Users
							$NumUserLogin = $objUser->GetUserLoginMultiple($_SESSION['UserID'],$UserType,$SessionTimeout);	
							 

							if($NumUserLogin>=$MaxUser){
								$_SESSION['login_msg'] = MAX_USER_LOGIN;	
								header("location:index.php");
								exit;	
							}
						}
					}
				}
				/***********************************/

				$_SESSION['loginID'] = $objUser->AddUserLogin($_SESSION['UserID'],$UserType);
				
				if(empty($arryMain[0])) $arryMain[0]='';

				$objConfigure=new configure();				
				$objConfigure->UpdatePrimaryLocation($arryMain[0]); // Update Primary Location of Company
	

				if($ArryUserEmail[0]['Department']==5){
					$arryDefaultScreen = $objConfig->getDefaultScreen();		
				}






				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				$objConfig->RemoveBlock(0);


							
				// if($_SESSION['CmpID']==37){pr($arryMain);exit;}
				 
				if(!empty($_POST['ContinueUrl'])){ 
					
					$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
					 
					echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
					exit;
				}else if(@$arryDefaultScreen[0]['Status']=='1'){
					 
					echo '<script>location.href="crm/workspace.php";</script>';
					exit;
				}else{
					 
					echo '<script>location.href="dashboard.php";</script>';
					exit;
				}

			}else{
				if(empty($mess))
					$mess = INVALID_EMAIL_PASSWORD;

				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

				$_SESSION['login_attempt']++;
				if($_SESSION['login_attempt']>=5){
					$objConfig->AddBlockLogin(0);
				}

			}
			/********************/
			
		}

	}else{

		if(!empty($_SESSION['login_msg'])){
			$mess = $_SESSION['login_msg'];
			unset($_SESSION['login_msg']);
		}

		if(!empty($_SESSION['UserID']) && !empty($_SESSION['AdminType'])){
			$objUser->UserLogout($_SESSION['UserID'],$_SESSION['AdminType']);
		}

		unset($_SESSION);
		session_destroy();	
		ob_end_flush();		
	}

	/********************/
	
	if(empty($ErrorMsg)){
		if($objConfig->CheckBlockLogin(0)){
			$ErrorMsg = BLOCKED_MSG;
			unset($_SESSION['login_attempt']);
		}
	}

	require_once("includes/footer.php");
 ?>
