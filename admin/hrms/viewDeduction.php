<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();

	$arryDeduction=$objTax->getDeduction('','');
	$num=$objTax->numRows();

	require_once("../includes/footer.php"); 
	 
?>



