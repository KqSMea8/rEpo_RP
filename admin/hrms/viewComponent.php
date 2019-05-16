<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	$objPerformance=new performance();

	$arryComponent=$objPerformance->ListComponent('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objPerformance->numRows();

	require_once("../includes/footer.php"); 
	 
?>



