<?php 
	
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	$objShipment = new shipment();

	$RedirectURL = "apiGlobalSetting.php";

	/*************************/
	$arryReturn=$objShipment->ListShipmentAPIDetail();
	
	//echo "<pre>";print_r($arryReturn);
	
	$num=$objShipment->numRows();

	$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
	(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
	/*************************/

	require_once("../includes/footer.php"); 	
?>
