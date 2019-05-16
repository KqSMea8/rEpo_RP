<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();

	$ModuleName = "Salary Detail";	

	(empty($_GET['sc']))?($_GET['sc']=""):("");

	/******Get Employee's Salary***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySalary=$objPayroll->ListSalary($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPayroll->ListSalary($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	



	$PayMethod = $arryCurrentLocation[0]['PayMethod'];

	require_once("../includes/footer.php");
?>
