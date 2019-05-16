<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php?module=Order'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix . "classes/item.class.php");
	$ModuleName = "Customer";
	
	/*************************/
	$objItem = new items();
	$ItemID=$_GET['ItemID'];
	(empty($CustomerID))?($CustomerID=""):("");        


	$CustomersArray = $objItem->getCustomers($ItemID);
//echo "<pre>";
//print_r($CustomersArray);
	$SelectedCustomersArray = $objItem->getSelectedCustomers($ItemID);
	
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


