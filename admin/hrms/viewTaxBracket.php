<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();

	if(empty($_GET['y'])) $_GET['y'] = date('Y');


	$arryBracket=$objTax->getTaxBracket('',$_GET['y']);
	$num=$objTax->numRows();

	$arryFiling=$objTax->getFiling('','1');
	require_once("../includes/footer.php");
?>


