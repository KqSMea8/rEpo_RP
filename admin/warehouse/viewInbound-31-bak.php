<?php   

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();

	$RedirectURL = "viewInbound.php";
	$ModuleName = "Inbound List";
	if(!empty($_GET['po'])){
		$MainModuleName = "StockIn for PO Number : ".$_GET['po'];
		$RedirectURL = "viewInbound.php?po=".$_GET['po'];
	}


	/*************************/
	$arryReturn=$objPurchase->ListReturn($_GET);
	
	$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
	(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
	/*************************/
	require_once("../includes/footer.php"); 	 
?>




