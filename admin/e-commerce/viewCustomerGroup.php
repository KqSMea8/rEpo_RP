<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/customer.class.php");
	
	$objCustomer = new Customer();	  
	
 	$arryCustomerGroups =$objCustomer->getCustomerGroups();
	$num=$objCustomer->numRows();
	
  

  require_once("../includes/footer.php");
  
?>
