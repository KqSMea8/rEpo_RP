<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();

	$arryPayPeriod=$objTax->getPayPeriod('','');
	$num=$objTax->numRows();

	require_once("../includes/footer.php");
?>


