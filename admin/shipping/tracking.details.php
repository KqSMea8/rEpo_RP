<?php
	$HideNavigation = 1;
	(empty($_GET['action']))?($_GET['action']=""):("");

	/**************************************************/
	/**************************************************/
if($_GET['action']=="TrackStatus"){
	include_once("../includes/settings.php");
}else{
	include_once("../includes/header.php");
}
	require_once($Prefix."classes/warehouse.shipment.class.php");

	$objShipment = new shipment();

	(empty($_GET['acc']))?($_GET['acc']=""):("");
       (empty($strPath))?($strPath=""):("");

	$trackId = $_GET['view'];
	$ShipAccountNumber = $_GET['acc'];
	#$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('FedEx');
	$arryApiACDetails=$objShipment->ShipAccountByDeault('fedex');

	if(!empty($ShipAccountNumber)){
		$ShipAccountDetail=$objShipment->ShipAccountByACNumber($ShipAccountNumber,'fedex');
		$Config['Fedex_account_number'] = $ShipAccountDetail[0]['api_account_number'];
		$Config['Fedex_meter_number'] = $ShipAccountDetail[0]['api_meter_number'];
		$Config['Fedex_key'] = $ShipAccountDetail[0]['api_key'];
		$Config['Fedex_password'] = $ShipAccountDetail[0]['api_password'];
	}else{
		$Config['Fedex_account_number'] = $arryApiACDetails[0]['api_account_number'];
		$Config['Fedex_meter_number'] = $arryApiACDetails[0]['api_meter_number'];
		$Config['Fedex_key'] = $arryApiACDetails[0]['api_key'];
		$Config['Fedex_password'] = $arryApiACDetails[0]['api_password'];
	}

	 
	$Config['live'] = $arryApiACDetails[0]['live'];

    require_once 'fedex.settings.php';
    require_once 'classes/class.fedex.php';
    require_once 'classes/class.fedex.track.php';
    
    $objTrack = new fedexTrack();
    $objTrack->requestType("track");
	if($Config['live']==1){  
		$objTrack->wsdl_root_path = $strPath."wsdl-live/";
	}else{
		$objTrack->wsdl_root_path = $strPath."wsdl-test/";
	}    
    $client = new SoapClient($objTrack->wsdl_root_path.$objTrack->wsdl_path, array('trace' => 1));
    $request = $objTrack->trackRequest($trackId);

    try 
    {
        if($objTrack->setEndpoint('changeEndpoint'))
        {
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }

        $response = $client->track($request);

        if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') 
        {
            //success
            
           // echo $response->TrackDetails->StatusDescription;
            
        } 
        else 
        {
            $ermsg = $objTrack->showResponseMessage($response);
            
            
        }

    } 
    catch (SoapFault $exception) 
    {
       $ermsg = $objTrack->requestError($exception, $client);
 
    }

if(!empty($_GET['pk'])){
	pr($response,1);
}
	/*******************************/
	if($_GET['action']=="TrackStatus"){		 
		if(!empty($response->TrackDetails->CarrierCode)){			  
			$Status = $response->TrackDetails->StatusDescription;
			$StatusCode = $response->TrackDetails->StatusCode; 
			$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'FedEx');

			$EstimatedDelivery = $response->TrackDetails->EstimatedDeliveryTimestamp;
			if(!empty($EstimatedDelivery)){
				$EstimatedDelivery = substr($EstimatedDelivery,0,10);
				$EstimatedDelivery = date($Config['DateFormat'], strtotime($EstimatedDelivery));
			}		 
		}else{
			 $Status = $ermsg;
		}
		echo $Status.'#'.$ImgCode.'#'.$StatusCode.'#'.$EstimatedDelivery;
		exit;
	}
	/*******************************/

 
require_once("../includes/footer.php");
?>

