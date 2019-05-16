<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrde.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();

	$RedirectURL = "viewSalesQuoteOrde.php?module=Order";

	/*************************/
	
	//$_GET['Status'] = 'Open';
	$_GET['Approved'] = '1';
	$_GET['InvoiceID'] = '1';
	$arrySale=$objSale->ListSale($_GET);
	$num=$objSale->numRows();

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


