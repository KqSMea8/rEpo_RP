<?php 
	if(!empty($_GET['CustomReport'])){
		$SetFullPage = 1;
	}
	$Payroll=1;
	include_once("../includes/header.php");
	
	include_once("includes/html/box/custom_report_action.php");

	require_once("../includes/footer.php");
?>

