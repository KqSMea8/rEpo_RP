<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();

	$ModuleName = "Credit Note";

	$AddUrl = "editCreditNote.php";
	$EditUrl = "editCreditNote.php?curP=".$_GET['curP'];
	$ViewUrl = "vCreditNote.php?curP=".$_GET['curP'];

	/*************************/
	$arrySale=$objSale->ListCreditNote($_GET);
	$num=$objSale->numRows();

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly
 
	require_once("../includes/footer.php"); 	
?>


