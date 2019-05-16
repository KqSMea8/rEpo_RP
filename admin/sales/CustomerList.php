<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php?module=Order'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "Customer";
	$objCustomer = new Customer();


	/*******Get Customer Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryCustomer = $objCustomer->CustomerListing($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCustomer->CustomerListing($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/
 
	require_once("../includes/footer.php"); 	
?>


