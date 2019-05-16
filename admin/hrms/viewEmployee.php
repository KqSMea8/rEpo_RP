<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/user.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Employee";
	$objEmployee=new employee();
	$objUser=new user();


	//$objEmployee->UpdateEmpEmail();


	/******Get Employee Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryEmployee=$objEmployee->ListEmployee($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objEmployee->ListEmployee($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	


	require_once("../includes/footer.php"); 	
?>


