<?php
	/**************************************************/
	$ThisPageName = 'myComp.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objLeave=new leave();
	$objEmployee=new employee();

	$RedirectUrl ="myComp.php?curP=".$_GET['curP'];
	$ModuleName = "Compensatory-Off";	

	if($_POST) {
		/********************************/
		CleanPost();
		/********************************/


		$_POST['EmpID'] = $_SESSION["AdminID"];
		$CompID = $objLeave->addComp($_POST);
		$objLeave->sendCompEmail($CompID); 

		$_SESSION['mess_dec'] = COMP_ADDED;

		header("location:".$RedirectUrl);
		exit;		
	}
	
	$HideAdminPart = 1;
	$OnSubmit = 'onSubmit="return ValidateForm(this);"';

	require_once("../includes/footer.php"); 
?>
