<?php 
	include_once("includes/header.php");
	require_once("../classes/reseller.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Reseller";
	$objReseller=new reseller();

	/*******Get User Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryReseller=$objReseller->ListReseller($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objReseller->ListReseller($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/

	
	require_once("includes/footer.php"); 	 
?>


