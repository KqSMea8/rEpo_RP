<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/training.class.php");
	include_once("includes/FieldArray.php");
	$objTraining=new training();

	$ModuleName = "Training";	
	(empty($_GET['sc']))?($_GET['sc']=""):("");
	/******Get Training Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryTraining=$objTraining->ListTraining($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objTraining->ListTraining($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	

	require_once("../includes/footer.php"); 	 
?>


