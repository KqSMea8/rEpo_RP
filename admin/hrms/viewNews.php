<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();

	/******Get News Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryNews=$objCommon->ListNews($_GET);

	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCommon->ListNews($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	
	
	require_once("../includes/footer.php");
?>


