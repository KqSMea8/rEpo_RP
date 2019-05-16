<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	include_once("includes/FieldArray.php");
	$objPerformance=new performance();

	$ModuleName = "Review";

	$arryReview=$objPerformance->ListReview('',$_GET['key'],$_GET['sortby'],$_GET['FromDate'],$_GET['ToDate'],$_GET['asc']);
	$num=$objPerformance->numRows();

	require_once("../includes/footer.php"); 
?>
