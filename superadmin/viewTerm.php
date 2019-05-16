<?php 
	include_once("includes/header.php");
	require_once("../classes/commonsuper.class.php");
	$objCommon=new common();

	$ModuleName = "Payment Term";	

	$arryTerm=$objCommon->ListTerm($_GET);
	$num=$objCommon->numRows();

	$pagerLink=$objPager->getPager($arryTerm,$RecordsPerPage,$_GET['curP']);
	(count($arryTerm)>0)?($arryTerm=$objPager->getPageRecords()):("");

	require_once("includes/footer.php"); 	 
?>


