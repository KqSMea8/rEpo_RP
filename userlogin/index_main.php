<?php $LoginPage=1;
	require_once("includes/header.php");	
	require_once("../classes/company.class.php");
	require_once("../classes/employee.class.php");
	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");


	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();

	$objConfig = new admin();

	/***********************/
	if ($_POST['LoginEmail']!='') { 
		if (empty($_POST['LoginEmail'])) {
			$mess = INVALID_EMAIL_PASSWORD;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		}else{ 
			
			$arryMain = $objCompany->GetCompanyDetailDisplay($_GET["c"]);
			
			$DbName2 = $Config['DbName']."_".$arryMain[0]['DisplayName'];
			$CmpID = $arryMain[0]['CmpID'];

			$ArryCompany = $objCompany->ValidateCompany($_POST['LoginEmail'], $_POST['LoginPassword'], $_POST['CmpID']);
			
			if($ArryCompany[0]['CmpID']>0){ // Company Login Check
				$_SESSION['AdminID'] = $ArryCompany[0]['CmpID']; 
				$_SESSION['UserID'] = $ArryCompany[0]['CmpID']; 
				$_SESSION['CmpID'] = $CmpID; 
				$_SESSION['AdminType'] = "admin"; 
				$_SESSION['DisplayName'] = $ArryCompany[0]['DisplayName'];
				$_SESSION['UserName'] = $ArryCompany[0]['DisplayName'];
				$_SESSION['AdminEmail'] = $ArryCompany[0]['Email'];					
				$_SESSION['AdminPassword'] = $ArryCompany[0]['Password'];			
				$_SESSION['CmpDatabase'] = $DbName2;
				$_SESSION['CmpDepartment'] = $arryMain[0]['Department'];
				$ValidLogin = 1;
			}else{ // User Login Check
				$Config['DbName'] = $DbName2;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();  
				
				/*
				$UserType = 'Employee'; //$_POST['UserType']; 
				$ArryUser = $objUser->ValidateUser($_POST['LoginEmail'], $_POST['LoginPassword'], $UserType);
				echo '<pre>'; print_r($ArryUser); exit;
				*/
				
				$ArryEmployee = $objEmployee->ValidateEmployee($_POST['LoginEmail'], $_POST['LoginPassword']);

				if($ArryEmployee[0]['EmpID']>0){
					$_SESSION['AdminID'] = $ArryEmployee[0]['EmpID']; 
					$_SESSION['UserID'] = $ArryEmployee[0]['UserID']; 
					$_SESSION['CmpID'] = $CmpID; 
					$_SESSION['AdminType'] = "employee"; 
					$_SESSION['DisplayName'] = $_GET["c"];
					$_SESSION['UserName'] = $ArryEmployee[0]['UserName'];
					$_SESSION['AdminEmail'] = $ArryEmployee[0]['Email'];					
					$_SESSION['AdminPassword'] = $ArryEmployee[0]['Password'];			
					$_SESSION['CmpDatabase'] = $DbName2;
					$_SESSION['locationID'] = $ArryEmployee[0]['locationID'];	
					$_SESSION['CmpDepartment'] = $arryMain[0]['Department'];
					$ValidLogin = 1;
					
				}
			}
			
			/********************/  
			if($ValidLogin==1){
				setcookie("DisplayNameCookie", $_SESSION['DisplayName'], time()+(24*30*3600));

				if($_SESSION['AdminType']=="admin"){
					$Config['DbName'] = $DbName2;
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();  
				}
				$objConfigure=new configure();				
				$objConfigure->UpdatePrimaryLocation($arryMain[0]); // Update Primary Location of Company
	

				if(!empty($_POST['ContinueUrl'])){
					$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
					echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
					exit;
				}else{
					echo '<script>location.href="dashboard.php";</script>';
					exit;
				}
			}else{
				$mess = INVALID_EMAIL_PASSWORD;
			}
			/********************/
			
		}

	}else{
		session_destroy();	
		ob_end_flush();
	}

	/***********************/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	if(!empty($_GET["c"])){
		$arryCompany = $objCompany->GetCompanyByDisplay($_GET["c"]);
		if(empty($arryCompany[0]["CmpID"])){
			$ErrorMsg = ERROR_INACTIVE_ADMIN;
		}else{
			$Config['DbName2'] = $Config['DbName']."_".$arryCompany[0]["DisplayName"];
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}
		}
	}else{
		$ErrorMsg = ERROR_INACTIVE_PAGE;
	}

	/***********************/
	require_once("includes/footer.php");
 ?>
