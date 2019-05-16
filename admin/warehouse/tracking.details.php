<?php
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'editReturn.php';
	/**************************************************/
if($_GET['action']=="TrackStatus"){
	include_once("../includes/settings.php");
}else{
	include_once("../includes/header.php");
}
	require_once($Prefix."classes/warehouse.shipment.class.php");

	$objShipment = new shipment();

	$trackId=$_GET['view'];

	$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('FedEx');

	$Config['Fedex_account_number'] = $arryApiACDetails[0]['api_account_number'];
	$Config['Fedex_meter_number'] = $arryApiACDetails[0]['api_meter_number'];
	$Config['Fedex_key'] = $arryApiACDetails[0]['api_key'];
	$Config['Fedex_password'] = $arryApiACDetails[0]['api_password'];
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

	
 // echo "<pre>";print_r($response);exit;
    
	/*******************************/
	if($_GET['action']=="TrackStatus"){		 
		if(!empty($response->TrackDetails->CarrierCode)){			  
			$Status = $response->TrackDetails->StatusDescription;
			$StatusCode = $response->TrackDetails->StatusCode; 
			$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'FedEx');		 
		}else{
			 $Status = $ermsg;
		}
		echo $Status.'#'.$ImgCode.'#'.$StatusCode;
		exit;
	}
	/*******************************/

 
require_once("../includes/footer.php");
?>

