<?php

$HideNavigation = 1;
(empty($_GET['action']))?($_GET['action']=""):("");
/**************************************************/
if($_GET['action']=="TrackStatus"){
	include_once("../includes/settings.php");
}else{
	include_once("../includes/header.php");
}

require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");

$objShipment = new shipment();
$objWarehouse=new warehouse();

(empty($_GET['acc']))?($_GET['acc']=""):("");


$ShipAccountNumber = $_GET['acc'];


#$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('DHL');
$arryApiACDetails=$objShipment->ShipAccountByDeault('DHL');

if(!empty($ShipAccountNumber)){
	$ShipAccountDetail=$objShipment->ShipAccountByACNumber($ShipAccountNumber,'DHL');
	$Config['dhl_account_number'] = $ShipAccountDetail[0]['api_account_number'];
	$Config['dhl_key'] = $ShipAccountDetail[0]['api_key'];
	$Config['dhl_password'] = $ShipAccountDetail[0]['api_password'];
}else{
	$Config['dhl_account_number'] = $arryApiACDetails[0]['api_account_number'];
	$Config['dhl_key'] = $arryApiACDetails[0]['api_key'];
	$Config['dhl_password'] = $arryApiACDetails[0]['api_password'];
}

 


use DHL\Entity\EA\KnownTrackingRequest as Tracking;
use DHL\Client\Web as WebserviceClient;

require('init.php');

 function xml_to_array($xml,$main_heading = '') 
{
    $deXml = simplexml_load_string($xml);
    $deJson = json_encode($deXml);
    $xml_array = json_decode($deJson,TRUE);
    if (! empty($main_heading)) {
        $returned = $xml_array[$main_heading];
        return $returned;
    } else {
        return $xml_array;
    }
}

$trackId= $_GET['view'];
//$trackId='8564385550';
// DHL Settings
$dhl = $config['dhl'];

if(empty($Config['dhl_account_number']) || empty($Config['dhl_key']) || empty($Config['dhl_password'])){
	$ermsg = SHIPPING_ACCOUNT_NOT_SETUP;
}else{

	$request = new Tracking();  
	$request->SiteID = $dhl['id'];
	$request->Password = $dhl['pass'];
	$request->MessageReference = '1234567890123456789012345678';
	$request->MessageTime = '2002-06-25T11:28:55-08:00';   
	$request->LanguageCode = 'en'; 
	$request->AWBNumber = $trackId;  
	$request->LevelOfDetails = 'ALL_CHECK_POINTS';
	$request->PiecesEnabled = 'S';

	$request->toXML();
	$client = new WebserviceClient();
	$xml = $client->call($request);

	$arrayDetail =xml_to_array($xml);
	$result = new DHL\Entity\EA\TrackingResponse();
	$result->initFromXML($xml);
	$result->toXML();
}

  
if(!empty($_GET['pk'])){
	pr($arrayDetail);exit;
}

/*******************************/
if($_GET['action']=="TrackStatus"){
	$StatusCode = $arrayDetail['AWBInfo'][0]['ShipmentInfo']['ShipmentEvent']['ServiceEvent']['EventCode']; 
	if(!empty($StatusCode)){			  
		$Status = $arrayDetail['AWBInfo'][0]['ShipmentInfo']['ShipmentEvent']['ServiceEvent']['Description'];
		
		$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'DHL');	

		foreach($arrayDetail['AWBInfo'] as $arry){
			$EstimatedDelivery = $arry['ShipmentInfo']['ShipmentDate']; 
		}

		if(!empty($EstimatedDelivery)){
			$EstimatedDelivery = substr($EstimatedDelivery,0,10);
			$EstimatedDelivery = date($Config['DateFormat'], strtotime($EstimatedDelivery));
		}	 
	}else{ 
		if(empty($ermsg)) $ermsg = $arrayDetail['AWBInfo']['Status']['Condition']['ConditionData'];
		if(empty($ermsg)) $ermsg = 'Invalid tracking number !!';
		$Status = $ermsg;
	}
	echo $Status.'#'.$ImgCode.'#'.$StatusCode.'#'.$EstimatedDelivery;
	exit;
}
/*******************************/


require_once("../includes/footer.php");
?>




