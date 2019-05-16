<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	$objCommon=new common();

	$ModuleName = "Batch";	

	$_GET["BatchType"] = "Check";
	$arryBatch=$objCommon->ListBatch($_GET);
	$num=$objCommon->numRows();

	$pagerLink=$objPager->getPager($arryBatch,$RecordsPerPage,$_GET['curP']);
	(count($arryBatch)>0)?($arryBatch=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


