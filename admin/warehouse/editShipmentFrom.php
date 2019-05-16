<?php
/**************************************************/
$ThisPageName = 'editShipmentFrom.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
$objShipment = new shipment();

$RedirectURL = "viewShipmentFrom.php";

//echo "<pre>";print_r($_POST);die;

//echo "<pre>";print_r($_POST);die;



CleanPost();

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		
		$_SESSION['mess_shipment_profile'] = SHIPMENT_PROFILE_REMOVE;
		$objShipment->RemoveShipmentFrom($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
		
	}
	

	if(!empty($_GET['edit']) && $_POST['ShippedID']){
		$_SESSION['mess_shipment_profile'] = SHIPMENT_PROFILE_UPDATE;
		$objShipment->UpdateShipmentFrom($_POST,$_POST['ShippedID']);
		header("Location:".$RedirectURL);
		exit;
		
		}


		
if ($_POST) {
	if (!empty($_POST['Submit'])) {
		$_SESSION['mess_shipment_profile'] = SHIPMENT_PROFILE_ADD;
		$objShipment->addShipmentFrom($_POST);
	}
	
	header("location:".$RedirectURL);
	exit;
}



$arryShipmentFrom = $objShipment->ListShipmenFromByID($_GET['edit']);


require_once("../includes/footer.php");


?>