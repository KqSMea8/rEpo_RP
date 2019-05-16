<?php 

if(isset($_GET['batch'])){  $_GET['batch'] = $_GET['batch'];    } 

	if(!empty($_GET['batch']) && $_GET['batch']!=''){
	$ThisPageName = "viewbatchmgmt.php";	
	$EditPage = 1; $SetFullPage = 1;
	}
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	include_once("includes/FieldArray.php");
	$objShipment = new shipment();
	$objSale = new sale();

	if(!empty($_SESSION['batchmgmt'])  && $_SESSION['batchmgmt'] ==1){
	header("location:viewbatchmgmt.php");
	exit;
	}


	$RedirectURL = "viewShipment.php";
	$ModuleName = "Shipment";
	if(!empty($_GET['so'])){
		$MainModuleName = "Shipment for SO Number : ".$_GET['SaleID'];
		$RedirectURL = "viewShipment.php?so=".$_GET['SaleID'];
	}

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


