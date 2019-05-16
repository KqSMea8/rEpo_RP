<?php
	/**************************************************/
	$ThisPageName = 'myLoan.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="myLoan.php?curP=".$_GET['curP'];
	$ModuleName = "Loan";	

	if($_POST) {
		/********************************/
		CleanPost();
		/********************************/


		$_POST['EmpID'] = $_SESSION["AdminID"];
		$LoanID = $objPayroll->addLoan($_POST);
		$objPayroll->sendLoanEmail($LoanID); 

		$_SESSION['mess_dec'] = ADVANCE_ADDED;

		header("location:".$RedirectUrl);
		exit;		
	}
	
	$HideAdminPart = 1;
	$OnSubmit = 'onSubmit="return ValidateForm(this);"';

	$arrySalary  = $objPayroll->getSalary('',$_SESSION["AdminID"]);
	if(!empty($arrySalary[0]['NetSalary'])){
		$NetSalary  = $arrySalary[0]['NetSalary'];
	}else{
		$NetSalary = '0';
	}


	require_once("../includes/footer.php"); 
?>
