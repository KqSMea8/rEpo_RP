<?php
require_once($Prefix."classes/warehouse.shipment.class.php");

// Require the main ups class and upsRate
require('classes/class.ups.php');
require('classes/class.upsShipValidation.php');

$objShipment = new shipment();

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('UPS');
//echo '<pre>'; print_r($arryApiACDetails); echo '</pre>';exit;
$Config['ups_account_number']= $arryApiACDetails[0]['api_account_number'];
$Config['ups_key']= $arryApiACDetails[0]['api_key'];
$Config['ups_password']= $arryApiACDetails[0]['api_password'];
$Config['ups_ShipperNumber'] = $arryApiACDetails[0]['api_meter_number'];
// Get credentials from a form

// If the form is filled out go get a rate from UPS 
$upsConnect = new ups($Config['ups_account_number'],$Config['ups_key'],$Config['ups_password']);
$upsConnect->setTemplatePath('xml/');
$upsConnect->setTestingMode(0); // Change this to 0 for production// Change this to 0 for production

$upsShipValidation = new upsShipValidation($upsConnect);

$upsShipValidation->buildRequestXML();
$responseArray = $upsShipValidation->responseArray();

//echo "<pre>";print_r($responseArray);exit;

$error = $responseArray['ShipmentConfirmResponse']['Response']['Error']['ErrorDescription']['VALUE'];

if(empty($error)){
	$ShipmentDigest = $responseArray['ShipmentConfirmResponse']['ShipmentDigest']['VALUE'];
	////////echo $upsShip->buildShipmentAcceptXML($ShipmentDigest);
	$upsShipValidation->buildShipmentAcceptXML($ShipmentDigest);
	// echo $upsShip->responseXML;
	$responseArray = $upsShipValidation->responseArray();
        $_SESSION['mess_ship']=1;
       // echo "<br><br><br><br><hr><hr> Ups Shipping<hr><hr><br><br><br><br>";
        //echo "<pre>";print_r($responseArray);exit;
} else {
        $_SESSION['mess_ship_error']= $error;
	echo '<pre>'; print_r($upsShipValidation->buildRequestXML()); echo '</pre>';
	$responseArray = $upsShipValidation->responseArray();
        
}


?>
