<?php 
	include_once("includes/header.php");
	require_once("../classes/license.class.php");
	$ModuleName = "License Key";
	$objLicense=new license();

	
	/*******Get License Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryLicense=$objLicense->ListLicense('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objLicense->ListLicense('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/


	require_once("includes/footer.php"); 	 
?>


