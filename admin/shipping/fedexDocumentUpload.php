<?php

require_once('classes/fedex-common.php');

$path_to_wsdl = "Fedex-MPS/wsdl/UploadDocumentService_v8.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$requestDocument['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
		'Key' => getProperty('parentkey'), 
		'Password' => getProperty('parentpassword')
	),
	'UserCredential' => array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
);


$requestDocument['ClientDetail'] = array(
	'AccountNumber' => getProperty('billaccount'), 
	'MeterNumber' => getProperty('meter')
);

$requestDocument['TransactionDetail'] = array('CustomerTransactionId' => '*** Upload Documents Request using PHP ***');
$requestDocument['Version'] = array(
	'ServiceId' => 'cdus', 
	'Major' => '8', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$requestDocument['OriginCountryCode'] = 'US';  
$requestDocument['DestinationCountryCode'] = 'CA';  
$requestDocument['Documents'] = array(
	'0' => array (
		'LineNumber' => '1', 
		'CustomerReference' => 'refId-1',
		'DocumentType' => 'COMMERCIAL_INVOICE', 
		'FileName' => 'commercial.pdf',
		'DocumentContent' => stream_get_contents(fopen("commercial.pdf", "r"))
	),
	'1' => array (
		'LineNumber' => '2', 
		'CustomerReference' => 'refId-2',
		'DocumentType' => 'COMMERCIAL_INVOICE', 
		'FileName' => 'commercial.pdf',
		'DocumentContent' => stream_get_contents(fopen("commercial.pdf", "r"))
	)
);                                            

//pr($requestDocument);die;

try {
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client ->uploadDocuments($requestDocument);

    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
    	foreach($response -> DocumentStatuses as $documentStatuses){
            echo $documentStatuses -> FileName. ' (';
            echo $documentStatuses -> Status.') - Document ID ';
            echo $documentStatuses -> DocumentId.Newline; 
            
		}
        printSuccess($client, $response);
    }else{
        printError($client, $response);
    } 
    
    writeToLog($client);    // Write to log file   
} catch (SoapFault $exception) {
    printFault($exception, $client);
}
?>
