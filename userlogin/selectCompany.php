<?php 
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
	

	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();

	$objConfig = new admin();
	$objCustomerSupplier = new CustomerSupplier();

	CleanGet();
	
	

	unset($_SESSION['CmpLogin']);
	/***********************/

	/***********************/

	if(empty($ErrorMsg)){
		if($objConfig->CheckBlockLogin()){
			$ErrorMsg = BLOCKED_MSG;
			unset($_SESSION['login_attempt']);
		}
	}


	

	require_once("includes/footer.php");
 ?>
