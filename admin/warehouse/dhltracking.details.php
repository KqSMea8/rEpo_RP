<?php

$HideNavigation = 1;
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

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('DHL');

$Config['dhl_account_number'] = $arryApiACDetails[0]['api_account_number'];
$Config['dhl_key'] = $arryApiACDetails[0]['api_key'];
$Config['dhl_password'] = $arryApiACDetails[0]['api_password'];

use DHL\Entity\EA\KnownTrackingRequest as Tracking;
use DHL\Client\Web as WebserviceClient;

require('init.php');



$trackId=$_GET['view'];
//$trackId='8564385550';
// DHL Settings
$dhl = $config['dhl'];


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

$arrayDetail =xml_to_array($xml);
$result = new DHL\Entity\EA\TrackingResponse();
$result->initFromXML($xml);
$result->toXML();


/*******************************/
if($_GET['action']=="TrackStatus"){
	$StatusCode = $arrayDetail['AWBInfo'][0]['ShipmentInfo']['ShipmentEvent']['ServiceEvent']['EventCode']; 
	if(!empty($StatusCode)){			  
		$Status = $arrayDetail['AWBInfo'][0]['ShipmentInfo']['ShipmentEvent']['ServiceEvent']['Description'];
		
		$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'DHL');		 
	}else{
		$ermsg = $arrayDetail['AWBInfo']['Status']['Condition']['ConditionData'];
		if(empty($ermsg)) $ermsg = 'Invalid tracking number !!';
		$Status = $ermsg;
	}
	echo $Status.'#'.$ImgCode.'#'.$StatusCode;
	exit;
}
/*******************************/


require_once("../includes/footer.php");
?>




