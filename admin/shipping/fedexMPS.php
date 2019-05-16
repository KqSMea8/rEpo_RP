<?php
// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 12.0.0


//echo "<pre>";print_r($_POST);die;

require_once('classes/fedex-common.php');

//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = "Fedex-MPS/wsdl/ShipService_v17.wsdl";

unset($_SESSION['Shipping']['LabelChild']);

/*
define('SHIP_MASTERLABEL', 'shipmasterlabel.pdf');    // PNG label file. Change to file-extension .pdf for creating a PDF label (e.g. shiplabel.pdf)
define('SHIP_CODLABEL', 'shipcodlabel.pdf');
define('SHIP_CHILDLABEL_1', 'shipchildlabel_1.pdf');  // PNG label file. Change to file-extension .pdf for creating a PDF label (e.g. shiplabel.pdf)
define('SHIP_CHILDLABEL_2', 'shipchildlabel_2.pdf');  // PNG label file. Change to file-extension .pdf for creating a PDF label (e.g. shiplabel.pdf)
*/
ini_set("soap.wsdl_cache_enabled", "0");


if($_POST['packageType'] == 'YOUR_PACKAGING'){
	$WeightMaster = $_POST['Weight1'];
	$wtUnitMaster = $_POST['wtUnit1'];
	$htUnitMaster = $_POST['htUnit1'];
	$LengthMaster = $_POST['Length1'];
	$WidthMaster =  $_POST['Width1'];
	$HeightMaster = $_POST['Height1'];
	if(empty($LengthMaster)) $Length=1;
	if(empty($WidthMaster)) $Width=1;
	if(empty($HeightMaster)) $Height=1;
}else{
	$WeightMaster=$_POST['WPK'];
	$wtUnitMaster = $_POST['WPK_Unit'];
	$LengthMaster="";
	$WidthMaster="";
	$HeightMaster="";
	$htUnitMaster="IN";
}

	if(empty($totalWeight)){
		
		$totalWeight=$_POST['WPK'];
		$wtUnit = $_POST['WPK_Unit'];
		
	}
	
	

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

try {
	$masterRequest['WebAuthenticationDetail'] = array(
			'ParentCredential' => array(
					'Key' => getProperty('parentkey'),
					'Password' => getProperty('parentpassword')
			),
			'UserCredential' => array(
					'Key' => getProperty('key'),
					'Password' => getProperty('password')
			)
	);
	
	$masterRequest['ClientDetail'] = array(
		'AccountNumber' => getProperty('shipaccount'), 
		'MeterNumber' => getProperty('meter')
	);
	$masterRequest['TransactionDetail'] = array('CustomerTransactionId' => '*** Express Domestic Shipping Request - Master using PHP ***');
	$masterRequest['Version'] = array(
		'ServiceId' => 'ship', 
		'Major' => '17', 
		'Intermediate' => '0', 
		'Minor' => '0'
	);




	if($_POST['COD']=='1' && $_POST['CODAmount']>0){
			$masterRequest['RequestedShipment'] = array(
				'ShipTimestamp' => date('c'),
				'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
				'ServiceType' => $_POST['ShippingMethod'], // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...s
				'PackagingType' => $_POST['packageType'], // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
				'TotalWeight' => array('Value' => $totalWeight, 'Units' => $wtUnit), // valid values LB and KG
				'Shipper' => addShipper(),
				'Recipient' => addRecipient(),
				'ShippingChargesPayment' => addShippingChargesPayment(),
				'SpecialServicesRequested' => addSpecialServices(),
				'LabelSpecification' => addLabelSpecification(), 
				'PackageCount' => $_POST['NoOfPackages'],              
				'RequestedPackageLineItems' => array(
	
					'0' => array(
					'SequenceNumber' => '1',
							'Weight' => array(
							'Value' => $WeightMaster,
							'Units' => $wtUnitMaster
					),
					'Dimensions' => array(
					'Length' => $LengthMaster,
						      'Width' => $WidthMaster,
						      'Height' => $HeightMaster,
							'Units' => $htUnitMaster
					),
					 
					    'CustomerReferences' => array(
					'0' => array(
					'CustomerReferenceType' => 'CUSTOMER_REFERENCE',   // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
					'Value' => $_POST['CUSTOMERREFERENCE']
					),
					'1' => array(
					'CustomerReferenceType' => 'INVOICE_NUMBER', 
					'Value' => $_POST['INVOICENO']
					),
					'2' => array(
					'CustomerReferenceType' => 'P_O_NUMBER', 
					'Value' => $_POST['PONUMBER']
					)
					)
			
					)	
	
			)
			);

	}else{ //else
		
		$masterRequest['RequestedShipment'] = array(
				'ShipTimestamp' => date('c'),
				'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
				'ServiceType' => $_POST['ShippingMethod'], // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...s
				'PackagingType' => $_POST['packageType'], // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
				'TotalWeight' => array('Value' => $totalWeight, 'Units' => $wtUnit), // valid values LB and KG
				'Shipper' => addShipper(),
				'Recipient' => addRecipient(),
				'ShippingChargesPayment' => addShippingChargesPayment(),

  				'CustomsClearanceDetail' => addCustomClearanceDetail(),
				//'SpecialServicesRequested' => addSpecialServices(),
				'LabelSpecification' => addLabelSpecification(), 
				'PackageCount' => $_POST['NoOfPackages'],              
				'RequestedPackageLineItems' => array(
	
					'0' => array(
					'SequenceNumber' => '1',
							'Weight' => array(
							'Value' => $WeightMaster,
							'Units' => $wtUnitMaster
					),
					'Dimensions' => array(
					'Length' => $LengthMaster,
						      'Width' => $WidthMaster,
						      'Height' => $HeightMaster,
							'Units' => $htUnitMaster
					),
					 
					    'CustomerReferences' => array(
					'0' => array(
					'CustomerReferenceType' => 'CUSTOMER_REFERENCE',   // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
					'Value' => $_POST['CUSTOMERREFERENCE']
					),
					'1' => array(
					'CustomerReferenceType' => 'INVOICE_NUMBER', 
					'Value' => $_POST['INVOICENO']
					),
					'2' => array(
					'CustomerReferenceType' => 'P_O_NUMBER', 
					'Value' => $_POST['PONUMBER']
					)
					)
			
					)	
	
			)
			);


	
	}


/**********Delivery Signature********/

   if($_POST['DeliverySignature']==1){
	
	$arrSignature = array('SpecialServiceTypes' => 'SIGNATURE_OPTION',
                    'SignatureOptionDetail' => array(
                        'OptionType' => $_POST['DSOptionsType']
                         )
                    );
                    
     $masterRequest['RequestedShipment']['RequestedPackageLineItems'][0]['SpecialServicesRequested'] = $arrSignature;
     

    }

/*************************************/


                                                                                        
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}

	$masterResponse = $client->processShipment($masterRequest);  // FedEx web service invocation for master label
	


	//writeToLog($client);    // Write to log file

	if ($masterResponse->HighestSeverity != 'FAILURE' && $masterResponse->HighestSeverity != 'ERROR' && $masterResponse->HighestSeverity != 'WARNING'){
	    //printSuccess($client, $masterResponse);
	    
	   // echo 'Generating label ...'. Newline;
	    // Create PNG or PDF label
	    // Set LabelSpecification.ImageType to 'PDF' for generating a PDF label
	    
		$TrackingID = $masterResponse->CompletedShipmentDetail->MasterTrackingId->TrackingNumber;

 		//echo '<pre>';  print_r($masterResponse);exit;
		//  $file_name = 'FedEX000_MASTERLABEL'.rand(1,1000).'.pdf';
		$file_name = 'FedEX000_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.pdf';

	    $fp = fopen($MainDir.$file_name, 'wb');
	    
	    //$fp = fopen(SHIP_MASTERLABEL, 'wb');   
	    fwrite($fp, $masterResponse->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image);
	    fclose($fp);


/*****************/
if($Config['ObjectStorage']=="1"){
 $ResponseArray = $objFunction->MoveObjStorage($MainDir, $PdfFolder, $file_name);
	if($ResponseArray['Success']=="1"){
		unlink($MainDir.$file_name);  	
	}
}
/*****************/


	   // echo 'Label <a href="./'.SHIP_MASTERLABEL.'">'.SHIP_MASTERLABEL.'</a> was generated. Processing package#1 ...';
	 

	    


	    /* child loop start from here */
	    
	    
	    for($l=1;$l<=$_POST['NoOfPackages'];$l++){
	    	
	    	
		      if($_POST['packageType'] == 'YOUR_PACKAGING'){
				    $Weight = $_POST['Weight'.$l];
				    $wtUnit = $_POST['wtUnit'.$l];
				    $htUnit = $_POST['htUnit'.$l];
				    $Length = $_POST['Length'.$l];
				    $Width =  $_POST['Width'.$l];
				    $Height = $_POST['Height'.$l];
				    if(empty($Length)) $Length=1;
				    if(empty($Width)) $Width=1;
				    if(empty($Height)) $Height=1;
		    }else{
				    $Weight=$_POST['WPK'];
				    $wtUnit = $_POST['WPK_Unit'];
				    $Length="";
				    $Width="";
				    $Height="";
				    $htUnit="IN";
		    }
	    	
	    	
	    	
	     $childRequest['WebAuthenticationDetail'] = array(
			'ParentCredential' => array(
				'Key' => getProperty('parentkey'), 
				'Password' => getProperty('parentpassword')
			),
			'UserCredential' => array(
				'Key' => getProperty('key'), 
				'Password' => getProperty('password')
			)
		);
	    		
	    $childRequest['ClientDetail'] = array(
	    	'AccountNumber' => getProperty('shipaccount'), 
	    	'MeterNumber' => getProperty('meter')
	    );
	    $childRequest['TransactionDetail'] = array('CustomerTransactionId' => '*** Express Domestic Shipping Request - Child 2 using PHP ***');

	    $childRequest['Version'] = array(
	    	'ServiceId' => 'ship', 
	    	'Major' => '17', 
	    	'Intermediate' => '0', 
	    	'Minor' => '0'
	    );
	    $childRequest['RequestedShipment'] = array(
	    	'ShipTimestamp' => date('c'),
			'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
			'ServiceType' => 'PRIORITY_OVERNIGHT', // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...s
			'PackagingType' => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
			'TotalWeight' => array('Value' => $totalWeight, 'Units' => $wtUnit), 
			'Shipper' => addShipper(),
			'Recipient' => addRecipient(),
			'ShippingChargesPayment' => addShippingChargesPayment(),
			'LabelSpecification' => addLabelSpecification(), 
			'RateRequestTypes' => array('ACCOUNT'), // valid values ACCOUNT and LIST
			'PackageCount' => $_POST['NoOfPackages'],
			'MasterTrackingId' => $masterResponse->CompletedShipmentDetail->MasterTrackingId,                   
			'PackageDetail' => 'INDIVIDUAL_PACKAGES',
			'RequestedPackageLineItems' => array(
			
			
				'0' => array(
					'SequenceNumber' => $l,
	                'Weight' => array(
	                	'Value' => $Weight,
	                	'Units' => $wtUnit
	    	),
					'Dimensions' => array(
						'Length' => $Length,
		              	'Width' => $Width,
		              	'Height' => $Height,
		                'Units' => $htUnit
	    	),
	    	 
	    	 
		      'CustomerReferences' => array(
			'0' => array(
				'CustomerReferenceType' => 'CUSTOMER_REFERENCE',   // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
				'Value' => $_POST['CUSTOMERREFERENCE']
				),
			'1' => array(
				'CustomerReferenceType' => 'INVOICE_NUMBER', 
				'Value' => $_POST['INVOICENO']
				),
			'2' => array(
				'CustomerReferenceType' => 'P_O_NUMBER', 
				'Value' => $_POST['PONUMBER']
				)
				)

				)
				
			
			)
		);
	
	    $childResponse = $client->processShipment($childRequest);  // FedEx web service invocation for child label #2
	    
	    //writeToLog($client);    // Write to log file
	    
	    if ($childResponse->HighestSeverity != 'FAILURE' && $childResponse->HighestSeverity != 'ERROR'){
	      //  printSuccess($client, $childResponse);
	        
	        // Create PNG or PDF label
	        // Set LabelSpecification.ImageType to 'PDF' for generating a PDF label
	        

		 $childTrackingNumber = $childResponse->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber;

        	//$file_name_child = 'FedEX000_CHILDLABEL'.rand(1,1000).'.pdf';
		$file_name_child = 'FedEX000_'.$_POST['ShippingMethod'].'_'.$childTrackingNumber.'.pdf';
		$fp = fopen($MainDir.$file_name_child, 'wb');
		$_SESSION['Shipping']['LabelChild'] .= 	$file_name_child.'#';		
			
	       // $fp = fopen(SHIP_CHILDLABEL_2, 'wb');   
	        fwrite($fp, $childResponse->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image);
	        fclose($fp);



/*****************/
if($Config['ObjectStorage']=="1"){
$ResponseArray = $objFunction->MoveObjStorage($MainDir, $PdfFolder, $file_name_child);
	if($ResponseArray['Success']=="1"){
		unlink($MainDir.$file_name_child);  	
	}
}
/*****************/

	        //echo 'Label <a href="./'.SHIP_CHILDLABEL_2.'">'.SHIP_CHILDLABEL_2.'</a> was generated.' . Newline;
	        
	        //Printing COD label from last child shipment
	        
	        
	      if(empty($file_name1) && $_POST['COD']=='1' && $_POST['CODAmount']>0 && !empty($childResponse->CompletedShipmentDetail->AssociatedShipments->Label->Parts->Image)){
	        	
	       $file_name1 = 'FedEX000_COD_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.pdf';
	        $fp = fopen($MainDir. $file_name1, 'wb'); 
	          
	    	fwrite($fp, $childResponse->CompletedShipmentDetail->AssociatedShipments->Label->Parts->Image); //Create COD Return PNG or PDF file
	    	fclose($fp);
	    	//echo '<a href="./'.SHIP_CODLABEL.'">'.SHIP_CODLABEL.'</a> was generated.'.Newline;
	    	


/*****************/
if($Config['ObjectStorage']=="1"){
$ResponseArray = $objFunction->MoveObjStorage($MainDir, $PdfFolder, $file_name1);
	if($ResponseArray['Success']=="1"){
		unlink($MainDir.$file_name1);  	
	}
}
/*****************/


	        	
	        }

	    	
	    }else{
	        //echo 'Processing child shipment 2' . Newline;
			//printError($client, $masterResponse);

			/*$error .= $masterResponse->Notifications->Message;
			if(empty($error)){
				$error .= $masterResponse->Notifications[0]->Message;
			}*/
	    }

	    
	 }
	    

	    

	    	    /* child loop end from here */
	    
	    
	}else{
	    //echo 'Processing Master shipment' . Newline;
		//printError($client, $masterResponse);

 		

		$error .= $masterResponse->Notifications->Message; 
		if(empty($error)){
			$error = $masterResponse->Notifications[0]->Message;
		}
		

	}
	
	// writeToLog($client);    // Write to log file
} catch (SoapFault $exception) {
	//printFault($exception, $client);
       //echo 'exception' ;
	$error .= $exception->faultstring;
}



    function addShipper()
    {
        $shipper = array
        (
              'Contact' => array(
                'PersonName' => $_POST['Contactname'],
                'CompanyName' => $_POST['CompanyFrom'],
                'PhoneNumber' => $_POST['PhonenoFrom']),
            'Address' => array(
                'StreetLines' => array($_POST['Address1From'],$_POST['Address2From']),
                'City' => $_POST['CityFrom'],
                'StateOrProvinceCode' => $_POST['StateFrom'],
                'PostalCode' => $_POST['ZipFrom'],
                'CountryCode' => $_POST['CountryCgFrom'])
           );

        return $shipper;
    }
    
    
    
function addRecipient(){

	if($_POST['ShippingMethod'] == 'GROUND_HOME_DELIVERY'){
		$Res = '1';
	}else{
		$Res = '0';
	}


   $recipient = array(
			'Contact' => array(
				'PersonName' => $_POST['ContactNameTo'],
				'CompanyName' => $_POST['CompanyTo'],
				'PhoneNumber' => $_POST['PhoneNoTo']
				),
			'Address' => array(
				'StreetLines' => array($_POST['Address1To'],$_POST['Address2To']),
				'City' => $_POST['CityTo'],
				'StateOrProvinceCode' => $_POST['StateTo'],
				'PostalCode' =>  $_POST['ZipTo'],
				'CountryCode' => $_POST['CountryCgTo'],
				'Residential' => $Res)
                );
	

			return $recipient;
                                   
}

function addShippingChargesPaymentbackup(){
	$shippingChargesPayment = array('PaymentType' => 'SENDER',
        'Payor' => array(
			'ResponsibleParty' => array(
				'AccountNumber' => getProperty('billaccount'),
				'Contact' => null,
				'Address' => array(
					'CountryCode' => 'US'
				)
			)
		)
	);
	return $shippingChargesPayment;
}

function addShippingChargesPayment(){

	 $AccountTypeMps = $_POST['AccountType'];
    	 $AccountNumberMps = $_POST['AccountNumber'];
    	 
         if($AccountTypeMps==1){
    		$PaymentTypeMps = 'RECIPIENT';
    		$CountryCodeMps = $_POST['CountryCgTo'];
    		
    	}else if($AccountTypeMps==2){
    		$PaymentTypeMps = 'SENDER';
    		$CountryCodeMps = $_POST['CountryCgFrom'];
    	}else if($AccountTypeMps==4){
		$PaymentTypeMps = 'COLLECT';
		$CountryCodeMps = 'US';
    	}else{
    		$PaymentTypeMps = 'THIRD_PARTY';
    		$CountryCodeMps = 'US';
    	} 

	//getProperty('billaccount')

	$shippingChargesPayment = array('PaymentType' => $PaymentTypeMps,
        'Payor' => array(
			'ResponsibleParty' => array(
				'AccountNumber' => $AccountNumberMps,
				'Contact' => null,
				'Address' => array(
					'CountryCode' => $CountryCodeMps
				)
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
				'Currency' => $_POST['Currency'],
				 'Amount' => $_POST['CODAmount']
			),
			 'CollectionType' => $_POST['CollectionType']  // ANY, GUARANTEED_FUNDS
		)
	);
	return $specialServices; 
}



function addCustomClearanceDetail(){

/***************International******************/
  
 if(!empty($_POST['BillDutiesTaxOpt'])){ 	
 	$cusAccountType = $_POST['BillDutiesTaxOpt'];	
	
	$array = array();

	if(!empty($_POST['BillDutiesTaxAccount'])){ 
	          $array = array(
	                'ResponsibleParty' => array(
	                    'AccountNumber' => $_POST['BillDutiesTaxAccount'],
	                    'Contact' => null,
	                    'Address' => array(
	                        'CountryCode' => 'US'
	                    )
	                )
	            );
	}else{
		$array = array();
	}
 	/***************end******************/
 }else{
 	
 	    $cusAccountType = $_POST['AccountType'];
 	    
 	if($_POST['AccountType']==1){
        	 $cusAccountType='RECIPIENT';
        }elseif ($_POST['AccountType']==2){
        	 $cusAccountType='SENDER';
        }elseif ($_POST['AccountType']==3){
        	 $cusAccountType='THIRD_PARTY';
        }elseif ($_POST['AccountType']==4){
        	 $cusAccountType = 'COLLECT';

        }else{
        	 $cusAccountType='';
        }

		        
           if(empty($_POST['AccountNumber'])){ 
			 
			        $array = array();
			}
			else 
			{
			        $array = array(
			                'ResponsibleParty' => array(
			                    'AccountNumber' => $_POST['AccountNumber'],
			                    'Contact' => null,
			                    'Address' => array(
			                        'CountryCode' => 'US'
			                    )
			                )
			            );
			}
		 	

 }
 

/* end */

/*********************************/


    $customerClearanceDetail = array(
        'DutiesPayment' => array(
             'PaymentType' => $cusAccountType, // valid values RECIPIENT, SENDER and THIRD_PARTY
             'Payor' => $array
        ),
        'DocumentContent' => 'NON_DOCUMENTS',                                                                                            
        'CustomsValue' => array(
                 'Currency' => $_POST['CustomValueCurrency'],
                'Amount' => $_POST['CustomValue']
        ),
        'Commodities' => array(
            '0' => array(
                'NumberOfPieces' => 1,
                'Description' => 'Computer Parts',
                'CountryOfManufacture' => 'US',
                'Weight' => array(
                    'Units' => 'LB',
                    'Value' => 1.0
                ),
                'Quantity' => 4,
                'QuantityUnits' => 'EA',
                'UnitPrice' => array(
                    'Currency' => 'USD',
                    'Amount' => 100.000000
                ),
                'CustomsValue' => array(
                    'Currency' => $_POST['CustomValueCurrency'],
                    'Amount' => $_POST['CustomValue']
                )
            )
        ),
        'ExportDetail' => array(
            'B13AFilingOption' => 'NOT_REQUIRED',
	    'ExportComplianceStatement' => $_POST['AES_NUMBER'] //XYYYYMMDDNNNNNN20170329
        )
    );

	#echo '<pre>';print_r($customerClearanceDetail); die;

    return $customerClearanceDetail;
}
 



?>
