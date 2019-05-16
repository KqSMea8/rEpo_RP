<?php
/**************************************************/
$ThisPageName = 'viewShipmentProfile.php'; $EditPage=1;
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
$objShipment = new shipment();

$RedirectURL = "viewShipmentProfile.php";



	if($_GET['del_id'] && !empty($_GET['del_id'])){
		
		$_SESSION['mess_shipment_profile'] = SHIPMENT_PROFILE_REMOVE;
		$objShipment->RemoveProfileShipment($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
		
	}
	

	if(!empty($_GET['edit']) && !empty($_POST['profileID'])){
		$_SESSION['mess_shipment_profile'] = SHIPMENT_PROFILE_UPDATE;
		$objShipment->UpdateProfileShipment($_POST,$_POST['profileID']);
		header("Location:".$RedirectURL);
		exit;
		
		}


	if (!empty($_POST)) {
		CleanPost();
		if (!empty($_POST['Submit'])) {
			$_SESSION['mess_shipment_profile'] = SHIPMENT_PROFILE_ADD;
			$objShipment->addProfileShipment($_POST);
		}
		header("location:".$RedirectURL);
		exit;
	}


	if(!empty($_GET['edit'])){
		$arryShipmentProfile = $objShipment->ListShipmentProfileByID($_GET['edit']);
	}else{
		$arryShipmentProfile = $objConfigure->GetDefaultArrayValue('w_shipment_profile');
	}

	require_once("../includes/footer.php");


?>
