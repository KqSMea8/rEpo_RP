<?php  	
	include_once("../includes/settings.php"); 
	require_once($Prefix."classes/sales.customer.class.php");	 
	 
	$objCustomer = new Customer(); 
		 
	$arryRecord=$objCustomer->GetCustomerByTax($_GET);        
	$num=$objCustomer->numRows();


	$fileName = 'CustomerByTaxRate';

	$ExportFile=$fileName."_".date('d-m-Y').".xls";

	include_once("includes/html/box/cust_bytax.php");
?>
