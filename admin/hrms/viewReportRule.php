<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/report.rule.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objReport=new report();
	$objEmployee=new employee();

	$arryReport=$objReport->ListReportRule($_GET['d'],$_GET['key'],$_GET['sortby'],$_GET['FromDate'],$_GET['ToDate'],$_GET['asc']);
	$num=sizeof($arryReport);


	$pagerLink=$objPager->getPager($arryReport,$RecordsPerPage,$_GET['curP']);
	(count($arryReport)>0)?($arryReport=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php");
?>

