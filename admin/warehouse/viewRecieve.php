<?php 

	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.recieve.order.class.php");
	$objWrecieve = new wrecieve();

	$RedirectURL = "viewRecieve.php";
	$ModuleName = "Recieve";
	if(!empty($_GET['po'])){
		$MainModuleName = "Ship for PO Number : ".$_GET['SaleID'];
		$RedirectURL = "viewRecieve.php?Po=".$_GET['SaleID'];
	}

	/*************************/
	$arryRecieve=$objWrecieve->ListRecieve($_GET);
	$num=$objWrecieve->numRows();

	$pagerLink=$objPager->getPager($arryRecieve,$RecordsPerPage,$_GET['curP']);
	(count($arryRecieve)>0)?($arryRecieve=$objPager->getPageRecords()):("");
	/*************************/
 
  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


