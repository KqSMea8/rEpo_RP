<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();

	$ModuleName = "Credit Note";


	$AddUrl = "editPoCreditNote.php";
	$EditUrl = "editPoCreditNote.php?curP=".$_GET['curP'];
	$ViewUrl = "vPoCreditNote.php?curP=".$_GET['curP'];

	/*************************/
	$arryPurchase=$objPurchase->ListCreditNote($_GET);
	$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
	(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");
	/*************************/
 
	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


