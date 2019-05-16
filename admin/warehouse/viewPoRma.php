<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.purchase.rma.class.php");
	include_once("includes/FieldArray.php");
	$objWarehouse = new warehouse();

	$RedirectURL = "viewPoRma.php";
	$ModDepName='WhouseVendorRMA';
	$ModuleName = "RMA";
	if(!empty($_GET['po'])){
		$MainModuleName = "Returns for PO Number : ".$_GET['po'];
		$RedirectURL = "viewPoRma.php?po=".$_GET['po'];
	}

	/******Get Warehouse Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryReturn=$objWarehouse->ListPurchaseReceipt($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objWarehouse->ListPurchaseReceipt($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	


  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


