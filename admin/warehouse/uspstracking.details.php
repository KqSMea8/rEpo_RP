<?php
$HideNavigation = 1;
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

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('USPS');

$username = $arryApiACDetails[0]['api_key'];
$trackId=$_GET['view'];

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

//pr($arrayDetail);exit;

 
$StatusCode = $arrayDetail['TrackInfo']['TrackSummary']['EventCode']; 
/*******************************/
if($_GET['action']=="TrackStatus"){	
	if(!empty($StatusCode)){			  
		$Status = $arrayDetail['TrackInfo']['TrackSummary']['Event'];		
		$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'USPS');		 
	}else{
		$ermsg = $arrayDetail['TrackInfo']['Error']['Description'];
		if(empty($ermsg)) $ermsg = 'Invalid tracking number !!';
		$Status = $ermsg;
	}
	echo $Status.'#'.$ImgCode.'#'.$StatusCode;
	exit;
}
/*******************************/


    
require_once("../includes/footer.php");
?>

