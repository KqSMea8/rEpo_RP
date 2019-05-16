<?php 
	include_once("includes/header.php");
	require_once("../classes/help.class.php");
	include_once("includes/FieldArray.php");
	
	$ModuleName = "Help";
	$objHelp=new help();

	(empty($_GET['depID']))?($_GET['depID']=''):(""); 

 
	$arrayDepartment=$objHelp->GetDepartmentName('');

	/*******Get Help Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryHelp=$objHelp->ListHelp($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objHelp->ListHelp($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/

	require_once("includes/footer.php"); 	 
?>
