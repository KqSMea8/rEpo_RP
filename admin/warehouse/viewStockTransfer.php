<?php 

	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.recieve.order.class.php");
	$objWrecieve = new wrecieve();

	$RedirectURL = "viewStockTransfer.php";
	$ModuleName = "Stock Transfer";
	if(!empty($_GET['po'])){
		$MainModuleName = "Recieve for Transfer Number : ".$_GET['SaleID'];
		$RedirectURL = "viewStockTransfer.php?Po=".$_GET['SaleID'];
	}

	/*************************/
	$arryTransfer=$objWrecieve->ListTransferRecieve($_GET);
	
	$num=$objWrecieve->numRows();

	$pagerLink=$objPager->getPager($arryTransfer,$RecordsPerPage,$_GET['curP']);
	(count($arryTransfer)>0)?($arryTransfer=$objPager->getPageRecords()):("");
	/*************************/
 
  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


