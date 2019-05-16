<?php 

	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();

	$ModuleName = "Appraisal";	

	$arryAppraisal=$objPayroll->ListAppraisal($_GET);
	$num = sizeof($arryAppraisal);

	$pagerLink=$objPager->getPager($arryAppraisal,$RecordsPerPage,$_GET['curP']);
	(count($arryAppraisal)>0)?($arryAppraisal=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php");
?>
