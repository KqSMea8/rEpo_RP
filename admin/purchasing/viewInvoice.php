<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();

	$ModuleName = "Invoice";
	$RedirectURL = "viewInvoice.php";


	if(!empty($_GET['po'])){
		$MainModuleName = "Invoices for PO Number : ".$_GET['po'];
		$RedirectURL = "viewInvoice.php?po=".$_GET['po'];
	}



	/*************************/
	$arryInvoice=$objPurchase->ListInvoice($_GET);
	$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryInvoice,$RecordsPerPage,$_GET['curP']);
	(count($arryInvoice)>0)?($arryInvoice=$objPager->getPageRecords()):("");
	/*************************/
 
 	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


