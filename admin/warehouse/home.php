<?php
	require_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");	
	require_once($Prefix."classes/warehouse.shipment.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objWarehouse=new warehouse();
	$objPurchase = new purchase();
	$objSale = new sale();
	$objShipment = new shipment();
	require_once("../includes/footer.php"); 
?>
