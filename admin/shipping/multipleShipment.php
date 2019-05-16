<?
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");

	$objShipment = new shipment();
	$CustCode = $_GET['CustCode'];
	$batchId = $_GET['batchId'];
 	$OrderID = $_GET['OrderID'];
	$arryDetail = $objShipment->GetCutomerShipment($CustCode,$batchId,'',$OrderID);
	
	require_once("../includes/footer.php");  

?>
