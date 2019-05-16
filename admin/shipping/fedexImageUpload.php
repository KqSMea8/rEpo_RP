<?php
require_once('classes/fedex-common.php');

$path_to_wsdl = "Fedex-MPS/wsdl/UploadDocumentService_v8.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$requestImage['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
		'Key' => getProperty('parentkey'), 
		'Password' => getProperty('parentpassword')
	),
	'UserCredential' => array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
);

$requestImage['ClientDetail'] = array(
	'AccountNumber' => getProperty('billaccount'), 
	'MeterNumber' => getProperty('meter')
);
$requestImage['TransactionDetail'] = array('CustomerTransactionId' => '*** Upload Images Request using PHP ***');
$requestImage['Version'] = array(
	'ServiceId' => 'cdus', 
	'Major' => '8', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$requestImage['OriginCountryCode'] = 'US';  
$requestImage['DestinationCountryCode'] = 'CA';  
$requestImage['Images'] = array(
	'0' => array (
		'Id' => 'IMAGE_1', 
  		'Image' => stream_get_contents(fopen("FedexImage.png", "r"))
  	),
   	'1' => array (
   		'Id' => 'IMAGE_2', 
		'Image' => stream_get_contents(fopen("FedexImage.png", "r"))
	)
);                                            



try {
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client ->uploadImages($requestImage);

    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
        foreach($response -> ImageStatuses as $imageStatus){
        	if($imageStatus -> Status == 'SUCCESS')
            {
         	    echo $imageStatus -> Id. ' (';
                echo $imageStatus -> Status.')'.Newline;           	
            }else{
            	echo $imageStatus -> Id. ' (';
                echo $imageStatus -> Status.') - Reason: ';
                echo $imageStatus -> StatusInfo .Newline;
                echo $imageStatus -> Message.Newline;
            }
        }
        printSuccess($client, $response);
    }else{
        printError($client, $response); 
    } 
    
    writeToLog($client);    // Write to log file   
} catch (SoapFault $exception) {
	echo '<pre>' . htmlspecialchars($client->__getLastResponse()). '</pre>';  
  	echo "\n";
    printFault($exception, $client);
}
?>
