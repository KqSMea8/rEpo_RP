<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	$objPerformance=new performance();

	$RedirectURL = "viewWeightage.php";

	$arryComponent=$objPerformance->getComponent('',1);
	$num=$objPerformance->numRows();

	$arryWeightage=$objPerformance->GetComponentWeightage('',1);

	require_once("../includes/footer.php"); 
	 
?>



