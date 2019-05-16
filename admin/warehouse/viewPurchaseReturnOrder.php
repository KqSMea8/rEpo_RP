<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();

	$RedirectURL = "viewPurchaseReturnOrder.php";
	$ModuleName = "Return";
	if(!empty($_GET['po'])){
		$MainModuleName = "Returns for PO Number : ".$_GET['po'];
		$RedirectURL = "viewPurchaseReturnOrder.php?po=".$_GET['po'];
	}


	/*************************/
	//$arryReturn=$objPurchase->ListReturn($_GET);
	//$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
	(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
	/*************************/
 

  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


