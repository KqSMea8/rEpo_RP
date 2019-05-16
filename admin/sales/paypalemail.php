<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php?module=Order'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/paypal.invoice.class.php");
	
	$ModuleName = "Paypal Email";
	$objpaypalInvoice = new paypalInvoice();


	/*******Get Customer Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryCustomeremails = $objpaypalInvoice->getCustomerPaypalEmail($_GET['cid']);
	$num=count($arryCustomeremails);
	/***********Count Records****************/	
	//$Config['GetNumRecords'] = 1;
      //  $arryCount=$objCustomer->CustomerListing($_GET);
	//$num=$arryCount[0]['NumCount'];	
	//$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/
 
	require_once("../includes/footer.php"); 	
?>


