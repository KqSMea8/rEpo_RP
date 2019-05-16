<?php
	$HideNavigation = 1;	
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();

 
	$RedirectUrl = $ThisPageName."?curP=".$_GET['curP'];
	$ModuleName = "Loan";	
	$EmpID = '';
		
	if(isset($_GET['view']) && $_GET['view'] >0){

		$arryLoan = $objPayroll->getLoan($_GET['view'],$EmpID);
		if(empty($arryLoan[0]['LoanID'])){
			$ErrorMSG = RECORD_NOT_EXIST;
		}else{
			$arryLoanReturn = $objPayroll->getLoanReturn($_GET['view']);
		}

	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
