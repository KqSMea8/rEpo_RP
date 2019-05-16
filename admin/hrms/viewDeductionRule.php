<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	
	$objTax=new tax();
	$arryDeductionRule=$objTax->getDeductionRule('','');
	$num=$objTax->numRows();

	require_once("../includes/footer.php"); 
	 
?>



