<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewCargo.php?module=Order'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "Customer";
	$objCustomer = new Customer();


	/*************************/
	$arryCustomer = $objCustomer->ListCustomer($_GET);
	//print_r($arryCustomer);
	//exit;
	$num=$objCustomer->numRows();

	$pagerLink=$objPager->getPager($arryCustomer,$RecordsPerPage,$_GET['curP']);
	(count($arryCustomer)>0)?($arryCustomer=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


