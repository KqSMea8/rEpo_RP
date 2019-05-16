<?php 
	$HideNavigation = 1;
	
	include_once("includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "Customer";
	$objCustomer = new Customer();


	/*************************/
	$arryCustomer = $objCustomer->CustomerListing($_GET);
	$num=$objCustomer->numRows();

	$pagerLink=$objPager->getPager($arryCustomer,$RecordsPerPage,$_GET['curP']);
	(count($arryCustomer)>0)?($arryCustomer=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("includes/footer.php"); 	
?>


