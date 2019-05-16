<?php 
	include_once("../includes/header.php");
	include_once("includes/FieldArray.php");
	require_once($Prefix."classes/payroll.class.php");
	
	$objPayroll=new payroll();

	$ModuleName = "Declaration";

	(empty($_GET['yr']))?($_GET['yr']=""):("");
	/******Get Employee Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryDeclaration=$objPayroll->ListDeclaration($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPayroll->ListDeclaration($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/

	require_once("../includes/footer.php");
?>
