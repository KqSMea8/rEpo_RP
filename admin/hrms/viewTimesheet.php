<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objTime=new time();
	$objEmployee=new employee();

	$RedirectUrl ="viewAttendence.php?s=1";
	$RedirectUrl .= (!empty($_GET['tmID']))?("&tmID=".$_GET['tmID']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");


	if(!empty($_GET['tmID']) && $_GET['emp']>0){
		$arryTimesheet=$objTime->getTimesheet('', $_GET['emp'], $_GET['tmID']);
		$num=sizeof($arryTimesheet);
		$ShowList = 1;


		$arryPeriodDetail = $objTime->getTimesheetPeriod($_GET['tmID'], $_GET['emp']);
		$FromDate = $arryPeriodDetail[0]['FromDate'];
	}

	if($_GET['emp']>0){
		$arryPeriod=$objTime->getTimesheetPeriod('', $_GET['emp']);
	}



	#$arryEmployee = $objEmployee->GetEmployeeBrief('');

	

	require_once("../includes/footer.php");
?>

