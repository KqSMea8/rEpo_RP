<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	include_once("includes/FieldArray.php");
	$objPerformance=new performance();
	

	$ModuleName = "KRA";

	$arryKra=$objPerformance->ListKra('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objPerformance->numRows();

	require_once("../includes/footer.php"); 
	 
?>



