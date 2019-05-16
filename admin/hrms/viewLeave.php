<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objLeave=new leave();
	$objEmployee=new employee();
	


	if(!empty($_GET['Department'])) $_GET['d'] = $_GET['Department'];


	

	/******Get Leave Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryLeave=$objLeave->ListLeave($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objLeave->ListLeave($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/
	require_once("../includes/footer.php");
?>

