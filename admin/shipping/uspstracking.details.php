<?php
$HideNavigation = 1;
(empty($_GET['action']))?($_GET['action']=""):("");
/**************************************************/
if($_GET['action']=="TrackStatus"){
	include_once("../includes/settings.php");
}else{
	include_once("../includes/header.php");
}

// Load the class

//require_once('classes/USPSTrackConfirm.php');
include("classes/usps.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");

$objShipment = new shipment();
$objWarehouse=new warehouse();

(empty($_GET['acc']))?($_GET['acc']=""):("");


$ShipAccountNumber = $_GET['acc'];
$trackId=$_GET['view'];

#$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('USPS');

$arryApiACDetails=$objShipment->ShipAccountByDeault('USPS');

if(!empty($ShipAccountNumber)){
	$ShipAccountDetail=$objShipment->ShipAccountByACNumber($ShipAccountNumber,'USPS');
	$username = $ShipAccountDetail[0]['api_key'];
	 
}else{
	$username = $arryApiACDetails[0]['api_key']; 
}








if(empty($username)){
	$ermsg = SHIPPING_ACCOUNT_NOT_SETUP;
}else{


	/*
	// Initiate and set the username provided from usps
	$tracking = new USPSTrackConfirm($username);
	//echo "<pre>";print_r($tracking);echo "</pre>";exit;
	// During test mode this seems not to always work as expected
	$tracking->setTestMode(true);
	// Add the test package id to the trackconfirm lookup class
	$tracking->addPackage("cf016550990us");
	//echo "<pre>";print_r($tracking);echo "</pre>";
	// Perform the call and print out the results
	//echo "<pre>";print_r($tracking->getTracking());echo "</pre>";
	$tracking->getTracking();
	$tracking->getArrayResponse();
	$datas = $tracking->getArrayResponse();
	*/

	$usps =  new USPS($username);
	$arrayDetail= $usps->TrackPackage($trackId);
}



if(!empty($_GET['pk'])){
	pr($arrayDetail);exit;
}
	 
	$StatusCode = $arrayDetail['TrackInfo']['TrackSummary']['EventCode']; 
	/*******************************/
	if($_GET['action']=="TrackStatus"){	
		if(!empty($StatusCode)){				  
			$Status = $arrayDetail['TrackInfo']['TrackSummary']['Event'];	
			$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'USPS');		 
		}else{
			if(empty($ermsg)) $ermsg = $arrayDetail['TrackInfo']['Error']['Description'];
			if(empty($ermsg)) $ermsg = 'Invalid tracking number !!';
			$Status = $ermsg;
		}
		echo $Status.'#'.$ImgCode.'#'.$StatusCode.'#'.$EstimatedDelivery;;
		exit;
	}
	/*******************************/


    
require_once("../includes/footer.php");
?>

