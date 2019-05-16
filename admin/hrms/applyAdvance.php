<?php
	/**************************************************/
	$ThisPageName = 'myAdvance.php'; $EditPage=1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="myAdvance.php?curP=".$_GET['curP'];
	$ModuleName = "Advance";	

	if($_POST) {
		/********************************/
		CleanPost();
		/********************************/

		$_POST['EmpID'] = $_SESSION["AdminID"];
		$AdvID = $objPayroll->addAdvance($_POST);
		$objPayroll->sendAdvanceEmail($AdvID); 

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
