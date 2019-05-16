<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'requestEDI.php';
	/**************************************************/

	include_once("../includes/header.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/supplier.class.php");
	//$ModuleName = "Customer";
	$objCustomer = new Customer();
	$objSupplier = new supplier();

if($_GET['name']!=''){
 //$_GET['key'] = $_SESSION['DisplayName'];
 
 $key = substr($_SESSION['DisplayName'],0,5);
 $_GET['key'] = $key;
 $DB = 'erp_'.$_GET['name'].'.';
		$arryCustRequest = $objCustomer->ListCustomer($_GET,$DB);
		
		$arryVenRequest = $objSupplier->ListSupplier($_GET,$DB);
		
 }
 
	require_once("../includes/footer.php"); 	

?>


