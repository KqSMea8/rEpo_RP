<?php 

	$RedirectLoginUrl = '../admin/index.php';
	header('location: '.$RedirectLoginUrl);
	exit;

ini_set('display_errors',1);

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
	require_once("../classes/dbfunction.class.php");
	require_once("../classes/customer.supplier.class.php");	
	require_once("../classes/customer.supplier.class.php");	
	require_once("../classes/sales.customer.class.php");
	require_once("../classes/supplier.class.php");


	$objSupplier=new supplier();
	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();
	$objConfig = new admin();
	$objCustomerSupplier = new CustomerSupplier();
	CleanGet();
	$objCustomer=new Customer();  
	$arryCustomer = array()	;
	unset($_SESSION['CmpLogin']);
	/***********************/
	if(!empty($_POST['LoginEmail'])) { 
		CleanPost();
		if(empty($_POST['LoginEmail'])) {
			$mess = INVALID_EMAIL_PASSWORD;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		}else{ 
			
			$LoginEmail = mysql_real_escape_string($_POST['LoginEmail']); 
			$LoginPassword = mysql_real_escape_string($_POST['LoginPassword']);			
			$ArryUserEmail = $objCustomerSupplier->UserLogin($LoginEmail,$LoginPassword);					
			/*****************/		
		 if(!empty($ArryUserEmail)){ // User Login Check			
				$UserType = $ArryUserEmail->user_type;	
				$displayname=$objCompany->GetCompanyDisplayName($ArryUserEmail->comId);		
				$DbName2 = $Config['DbName']."_".$displayname[0]['DisplayName'];
				$Config['DbName2'] = $DbName2;					
					if($ArryUserEmail->id>0){	
						$Config['DbName'] = $DbName2;
		 				$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();
						if($UserType=='customer')
						$arryCustomer = $objCustomer->GetCustomer($ArryUserEmail->ref_id,'','');
						elseif($UserType=='vendor')	
						$arryCustomer = $objSupplier->GetSupplier($ArryUserEmail->ref_id,'','');														
								session_regenerate_id(true); 							
								$_SESSION['UserID'] = $ArryUserEmail->id; 								
								$_SESSION['UserType'] = $UserType; 
								$_SESSION['DisplayName'] = $_GET["c"];
								$_SESSION['UserName'] = $ArryUserEmail->user_name;
								$_SESSION['UserEmail'] = $ArryUserEmail->user_name;					
								$_SESSION['UserPassword'] = $ArryUserEmail->password;
								$_SESSION['UserGender'] = $ArryUserEmail->gender;
								$_SESSION['CmpID'] = $ArryUserEmail->comId;	
								$_SESSION['ref_id'] = $ArryUserEmail->ref_id;	 // This Customer_ID
								$_SESSION['CmpDatabase'] = $DbName2;
								$_SESSION['UserData'] = $arryCustomer[0];			
								if(!empty($ArryUserEmail->permission))
									$_SESSION['permission'] = unserialize($ArryUserEmail->permission);															
								$ValidLogin = 1;
					}
			}
			/********************/  

			if($ValidLogin==1 && $_SESSION['UserID']>0){
				
				$_SESSION['CmpLogin'] = $_GET["crm"];

				$objConfig->RemoveBlock();
				setcookie("DisplayNameCookie", $_SESSION['DisplayName'], time()+(24*30*3600));

				//$objUser->AddUserLogin($_SESSION['UserID'],$UserType);
				
				$objConfigure=new configure();	


				if(!empty($_POST['ContinueUrl'])){
					$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
				
					echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
					exit;
				}else{				
					echo '<script>location.href="dashboard.php";</script>';
					exit;
				}
			}else{
				if(empty($mess))
					$mess = INVALID_EMAIL_PASSWORD;
				$_SESSION['login_attempt']++;
				if($_SESSION['login_attempt']>=5){
					//$objConfig->AddBlockLogin();
				}

			}
			/********************/
			
		}

	}else{
		session_destroy();	
		ob_end_flush();		
	}

	/***********************
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	if(!empty($_GET["c"])){
		$arryCompany = $objCompany->GetCompanyByDisplay($_GET["c"]);
		if(empty($arryCompany[0]["CmpID"])){
			$ErrorMsg = ERROR_INACTIVE_ADMIN;
		}else{

			if($arryCompany[0]['ExpiryDate']>0){				
				if($arryCompany[0]['ExpiryDate']<date('Y-m-d')){
					$ErrorMsg = ERROR_PCKG_EXP;
				}
			}

			$Config['DbName2'] = $Config['DbName']."_".$arryCompany[0]["DisplayName"];
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}
		}
	}else{
		$ErrorMsg = ERROR_INACTIVE_PAGE;
	}
	/***********************/

	if(empty($ErrorMsg)){
		if($objConfig->CheckBlockLogin()){
			$ErrorMsg = BLOCKED_MSG;
			unset($_SESSION['login_attempt']);
		}
	}
	

	

	require_once("includes/footer.php");
 ?>
