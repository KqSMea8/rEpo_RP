<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();

	$ModuleName = "Sales Invoice";

	$ViewUrl = "viewInvoice.php";
	$AddUrl = "editInvoice.php";
	$EditUrl = "editInvoice.php?curP=".$_GET['curP'];
	$ViewUrl = "vInvoice.php?curP=".$_GET['curP'];
	$RedirectURL = "viewInvoice.php";
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	/*************************/
	$arrySale=$objSale->ListInvoice($_GET);
	$num=$objSale->numRows();

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


