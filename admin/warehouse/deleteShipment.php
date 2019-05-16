<?php
// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 12.0.0
	$HideNavigation = 1;
	/**************************************************/
	if($_GET['batch']>0){
		$ThisPageName = "viewbatchmgmt.php";	
	}else{
		$ThisPageName = "viewShipment.php";	
	}
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	require_once($Prefix."classes/function.class.php");
	$objShipment = new shipment();
	$objFunction=new functions();
	$ApiPath = '../shipping/';

    	$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('FedEx');

	$Config['Fedex_account_number'] = $arryApiACDetails[0]['api_account_number'];
	$Config['Fedex_meter_number'] = $arryApiACDetails[0]['api_meter_number'];
	$Config['Fedex_key'] = $arryApiACDetails[0]['api_key'];
	$Config['Fedex_password'] = $arryApiACDetails[0]['api_password'];
	$Config['live'] = $arryApiACDetails[0]['live'];
	$Config['tracking_number'] = $_GET['trackingId'];
	
	 //$trackingId=$_GET['trackingId'];
	 
	 //$trackingId='783520343080';
		 
	 $RedirectURL='vShipment.php?view='.$_GET['view'].'&ship='.$_GET['ship'].'&batch='.$_GET['batch'];
 
   require_once($ApiPath."classes/fedex-common.php");
 

//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = $ApiPath."wsdl-live/ShipService_v10.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
		'Key' => getProperty('parentkey'), 
		'Password' => getProperty('parentpassword')
	),
	'UserCredential' => array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
);

$request['ClientDetail'] = array(
	'AccountNumber' => getProperty('shipaccount'), 
	'MeterNumber' => getProperty('meter')
);
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Cancel Shipment Request using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'ship', 
	'Major' => '10', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$request['ShipTimestamp'] = date('c');
$request['TrackingId'] = array(
	'TrackingIdType' =>'EXPRESS', // valid values EXPRESS, GROUND, USPS, etc
   	'TrackingNumber'=>getProperty('trackingnumber')
);  
$request['DeletionControl'] = 'DELETE_ONE_PACKAGE'; // Package/Shipment



try {
	
	
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}

	$response = $client ->deleteShipment($request);
	
  // echo "<pre>"; print_r($response);die;
    
    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
    	
    	
    	
    	$RemMsg = "<div class='greenmsg' align='center'>".$response->Notifications->Message."</div>"; 

    	//printSuccess($client, $response);
    	 //$arryApiACDetails=$objShipment->DeleteFedexShip($Config['tracking_number']);
    	
    }else{
       // printError($client, $response);
   
        $RemMsg = "<div class='redmsg' align='center'>".$response->Notifications->Message."</div>"; 
    	
    } 

if(!empty($Config['tracking_number'])){

$arryApiACDetails=$objShipment->DeleteFedexShip($Config['tracking_number']);

}
	
     $_SESSION['mess_shiment_delete'] = $RemMsg;
    
   
    header("Location:".$RedirectURL);
    exit;
	

    writeToLog($client);    // Write to log file   
} catch (SoapFault $exception) {
    printFault($exception, $client);
}
  


require_once("../includes/footer.php"); 	
?>
