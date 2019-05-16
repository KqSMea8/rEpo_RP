<?php
require_once('classes/fedex-common.php');
$path_to_wsdl = "Fedex-MPS/wsdl/ShipService_v17.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");

/*$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('FedEx');
$Config['Fedex_account_number'] = $arryApiACDetails[0]['api_account_number'];
$Config['Fedex_meter_number'] = $arryApiACDetails[0]['api_meter_number'];
$Config['Fedex_key'] = $arryApiACDetails[0]['api_key'];
$Config['Fedex_password'] = $arryApiACDetails[0]['api_password'];*/

$Config['Fedex_account_number'] = $_POST['api_account_number'];
$Config['Fedex_meter_number'] = $_POST['api_meter_number'];
$Config['Fedex_key'] = $_POST['api_key'];
$Config['Fedex_password'] = $_POST['api_password'];


$client = new SoapClient($path_to_wsdl, array('trace' => 1));

$request['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
		'Key' => $Config['Fedex_key'], 
		'Password' => $Config['Fedex_password']
	),
	'UserCredential' => array(
		'Key' => $Config['Fedex_key'], 
		'Password' => $Config['Fedex_password']
	)
);

$request['ClientDetail'] = array(
	'AccountNumber' => $Config['Fedex_account_number'], 
	'MeterNumber' => $Config['Fedex_meter_number']
);
$request['TransactionDetail'] = array('CustomerTransactionId' => '*** Express Domestic Shipping Request using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'ship', 
	'Major' => '17', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$request['RequestedShipment'] = array(
	'ShipTimestamp' => date('c'),
	'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
	'ServiceType' => 'PRIORITY_OVERNIGHT', // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
	'PackagingType' => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
	'TotalWeight' => array(
		'Value' => 50.0, 
		'Units' => 'LB' // valid values LB and KG
	), 
	'Shipper' => addShipper(),
	'Recipient' => addRecipient(),
	'ShippingChargesPayment' => addShippingChargesPayment(),
	'SpecialServicesRequested' => addSpecialServices(),
	'LabelSpecification' => addLabelSpecification(), 
	'PackageCount' => 1,
	'RequestedPackageLineItems' => array(
		'0' => addPackageLineItem1()
	)
);

try {
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client->processShipment($request);  // FedEx web service invocation\
 //echo '<h2>Response</h2>' . "<br>\n";  
 //echo "<pre>";print_r($response); 
    if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){    	
    	//printSuccess($client, $response);
        $_SESSION['mess_ship']=1;
    }else{
        //$_SESSION['mess_ship_error']= $error;
       // printError($client, $response);
	$_SESSION['mess_ship']=0;
        
    }
 
 
  //  writeToLog($client);    // Write to log file
	
} catch (SoapFault $exception) {
    printFault($exception, $client);
}


 
function addShipper(){
	$shipper = array(
		'Contact' => array(
			'PersonName' => 'Sender Name',
			'CompanyName' => 'Sender Company Name',
			'PhoneNumber' => '1234567890'
		),
		'Address' => array(
			'StreetLines' => array('Address Line 1'),
			'City' => 'Austin',
			'StateOrProvinceCode' => 'TX',
			'PostalCode' => '73301',
			'CountryCode' => 'US'
		)
	);
	return $shipper;
}
function addRecipient(){
	$recipient = array(
		'Contact' => array(
			'PersonName' => 'Recipient Name',
			'CompanyName' => 'Recipient Company Name',
			'PhoneNumber' => '1234567890'
		),
		'Address' => array(
			'StreetLines' => array('Address Line 1'),
			'City' => 'Herndon',
			'StateOrProvinceCode' => 'VA',
			'PostalCode' => '20171',
			'CountryCode' => 'US',
			'Residential' => true
		)
	);
	return $recipient;	                                    
}
function addShippingChargesPayment(){
	$shippingChargesPayment = array('PaymentType' => 'SENDER',
        'Payor' => array(
		'ResponsibleParty' => array(
			'AccountNumber' => getProperty('billaccount'),
			'Contact' => null,
			'Address' => array(
				'CountryCode' => 'US')
			)
		)
	);
	return $shippingChargesPayment;
}
function addLabelSpecification(){
	$labelSpecification = array(
		'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
		'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
		'LabelStockType' => 'PAPER_7X4.75'
	);
	return $labelSpecification;
}
function addSpecialServices(){
	$specialServices = array(
		'SpecialServiceTypes' => array('COD'),
		'CodDetail' => array(
			'CodCollectionAmount' => array(
				'Currency' => 'USD', 
				'Amount' => 150
			),
			'CollectionType' => 'ANY' // ANY, GUARANTEED_FUNDS
		)
	);
	return $specialServices; 
}
function addPackageLineItem1(){
	$packageLineItem = array(
		'SequenceNumber'=>1,
		'GroupPackageCount'=>1,
		'Weight' => array(
			'Value' => 5.0,
			'Units' => 'LB'
		),
		'Dimensions' => array(
			'Length' => 20,
			'Width' => 20,
			'Height' => 10,
			'Units' => 'IN'
		)
	);
	return $packageLineItem;
}
?>
