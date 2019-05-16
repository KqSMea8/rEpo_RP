<?php 
	/**************************************************/
	$ThisPageName = 'viewShippingAccount.php';
	/**************************************************/
	
	include_once("../includes/header.php");
	
   require_once($Prefix."classes/warehouse.shipment.class.php");
	$objShipment = new shipment();
	
	$Type=$_GET['type'];
	
	$ListShipAccount=$objShipment->ListShipAccount($Type);
	$num=$objShipment->numRows();

	$pagerLink=$objPager->getPager($ListShipAccount,$RecordsPerPage,$_GET['curP']);
	(count($ListShipAccount)>0)?($ListShipAccount=$objPager->getPageRecords()):("");
	

	require_once("../includes/footer.php"); 	
?>

