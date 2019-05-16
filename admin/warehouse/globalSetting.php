<?php
/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
$objShipment = new shipment();

$RedirectURL = "globalSetting.php";

CleanPost();

if ($_POST) {
	if (!empty($_POST['SourceZipcode'])) {
		$objShipment->updateApiAccountDetail($_POST);
		$_SESSION['mess_warehouse_global_setting'] = mess_warehouse_global_setting;
	}
	header("location:".$RedirectURL);
	exit;
}

$arryApiACDetail=$objShipment->getApiAccountDetail();


require_once("../includes/footer.php");


?>
