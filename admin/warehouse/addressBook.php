<?php 
	/**************************************************/
	$ThisPageName = 'addressBook.php';
	/**************************************************/
	
	include_once("../includes/header.php");
	
   require_once($Prefix."classes/warehouse.shipment.class.php");
	$objShipment = new shipment();
	
	$Type=$_GET['type'];
	
	$arryAddressBook=$objShipment->ListShipmentAddressBook($Type);
	$num=$objShipment->numRows();

	$pagerLink=$objPager->getPager($arryAddressBook,$RecordsPerPage,$_GET['curP']);
	(count($arryAddressBook)>0)?($arryAddressBook=$objPager->getPageRecords()):("");
	

	require_once("../includes/footer.php"); 	
?>

