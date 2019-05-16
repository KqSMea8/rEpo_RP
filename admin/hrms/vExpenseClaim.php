<?php
	session_start();
	/**************************************************/
	if($_SESSION['AdminType'] == "admin") { 
		$ThisPageName = 'viewExpenseClaim.php';
		$EmpID = '';
	}else{
		$ThisPageName = 'myExpenseClaim.php';
		$EmpID = $_SESSION["AdminID"];
	}
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();

	CleanGet();
	$RedirectUrl = $ThisPageName."?curP=".$_GET['curP'];
	$ModuleName = "Expense Claim";	

		
	if(isset($_GET['view']) && $_GET['view'] >0){

		$arryExpenseClaim = $objPayroll->getExpenseClaim($_GET['view'],$EmpID);
		if(empty($arryExpenseClaim[0]['ClaimID'])){
			$ErrorMSG = RECORD_NOT_EXIST;
		}
	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
