<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/inbound.class.php");
	$objInbound = new inbound();

	$RedirectURL = "viewInbound.php";
	$ModuleName = "Receive";
        $module = "StockIn";
	if(!empty($_GET['po'])){
		$MainModuleName = "Recieve for PO Number : ".$_GET['po'];
		$RedirectURL = "viewInbound.php?po=".$_GET['po'];
	}
        /*************************/
        
	$arryRecieve=$objInbound->ListWarehouseRecieve($_GET);
	$num=$objInbound->numRows();
	$pagerLink=$objPager->getPager($arryRecieve,$RecordsPerPage,$_GET['curP']);
	(count($arryRecieve)>0)?($arryRecieve=$objPager->getPageRecords()):("");
	/*************************/
 

  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


