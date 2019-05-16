<?php 


	include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	include_once("includes/FieldArray.php");
	$objShipment = new shipment();
$objSale = new sale();


	$RedirectURL = "viewPicking.php";
	$ModuleName = "Picking";
	if(!empty($_GET['so'])){
		$MainModuleName = "Picking for SO Number : ".$_GET['SaleID'];
		$RedirectURL = "viewPicking.php?so=".$_GET['SaleID'];
	}
$_GET['ShipmentStatus'] = 'Picked';
	/******Get Shipment Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryShipment=$objShipment->ListShipment($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objShipment->ListShipment($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	

  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


