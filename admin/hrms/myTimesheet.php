<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/leave.class.php");
	include_once("includes/FieldArray.php");
	$objLeave=new leave();
	$objTime=new time();

	//$Today = "2013-08-22"; //Current date
	//$arryWeek = GetWeek($Today,"D, d F, Y");	$arryWeek = GetWeek($Today,"Y-m-d");



	if(!empty($_GET['tmID'])){
		$arryTimesheet=$objTime->getTimesheet('', $_SESSION['AdminID'], $_GET['tmID']);
		$num=sizeof($arryTimesheet);
		$ShowList = 1;


		$arryPeriodDetail = $objTime->getTimesheetPeriod($_GET['tmID'], $_SESSION['AdminID']);
		$FromDate = $arryPeriodDetail[0]['FromDate'];
	}

	$arryPeriod=$objTime->getTimesheetPeriod('', $_SESSION['AdminID']);

	require_once("../includes/footer.php");
?>

