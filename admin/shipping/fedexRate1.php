<?php
	$HideNavigation = 1;
	/**************************************************/
	/**************************************************/
/*292261063
HCK0eqlTS0LSS9o7  left
FedEx

i0WrmarsrGXOrsMORMWsazrul right
109505681
32746*/

	include_once("../includes/header.php");

	require_once($Prefix."classes/warehouse.shipment.class.php");

	$objShipment = new shipment();
 


	$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('FedEx');

	$Config['Fedex_account_number'] = $arryApiACDetails[0]['api_account_number'];
	$Config['Fedex_meter_number'] = $arryApiACDetails[0]['api_meter_number'];
	$Config['Fedex_key'] = $arryApiACDetails[0]['api_key'];
	$Config['Fedex_password'] = $arryApiACDetails[0]['api_password'];
	$Config['live'] = $arryApiACDetails[0]['live'];

    require_once 'fedex.settings.php';
    require_once 'classes/class.fedex.php';
    require_once 'classes/class.fedex.track.php';
    require_once('classes/rateFedex-common.php');
    $path_to_wsdl = "wsdl-live/RateService_v16.wsdl";


if($_POST['track']){
	//$trackId='779378602795';
	$trackId=$_POST['track'];
	$PostalCodeS=$_POST['PostalCodeS'];
	$PostalCodeD=$_POST['PostalCodeD'];

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
	    #echo "<pre>";print_r($response);exit;
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


    	/*******************************/
    if(!empty($response->TrackDetails->CarrierCode)){	
		$ServiceType=$response->TrackDetails->ServiceType;

		if(!empty($response->TrackDetails->ShipmentWeight->Value)){
		$PackageWeightVal =$response->TrackDetails->ShipmentWeight->Value;
		$PackageWeightUnit =$response->TrackDetails->ShipmentWeight->Units;
		}else{
		$PackageWeightVal =$response->TrackDetails->PackageWeight->Value;
		$PackageWeightUnit =$response->TrackDetails->PackageWeight->Units;
		}

		$PackagingType = $response->TrackDetails->PackagingType;
		$pkDLength =$response->TrackDetails->PackageDimensions->Length;
		$pkDWidth =$response->TrackDetails->PackageDimensions->Width;
		$pkDHeight =$response->TrackDetails->PackageDimensions->Height;
		$pkDUnits =$response->TrackDetails->PackageDimensions->Units;
		$ShipperCountryCode = $response->TrackDetails->ShipperAddress->CountryCode;
		$ShipperState = $response->TrackDetails->ShipperAddress->StateOrProvinceCode;
		$ShipperCity = $response->TrackDetails->ShipperAddress->City;
		$DestinationCountry = $response->TrackDetails->DestinationAddress->CountryCode;
		$DestinationState = $response->TrackDetails->DestinationAddress->StateOrProvinceCode;
		$DestinationCity = $response->TrackDetails->DestinationAddress->City;
    }

	
	/*******************************/

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information


$request['WebAuthenticationDetail'] = array(
    'UserCredential' =>array(
        'Key' => $Config['Fedex_key'], 
        'Password' => $Config['Fedex_password']
    )
); 
$request['ClientDetail'] = array(
    'AccountNumber' => $Config['Fedex_account_number'], 
    'MeterNumber' => $Config['Fedex_meter_number']
);
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v13 using PHP ***');
$request['Version'] = array(
    'ServiceId' => 'crs', 
    'Major' => '16', 
    'Intermediate' => '0', 
    'Minor' => '0'
);
$request['ReturnTransitAndCommit'] = true;
$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
$request['RequestedShipment']['ShipTimestamp'] = date('c');
$request['RequestedShipment']['ServiceType'] = $ServiceType; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
$request['RequestedShipment']['PackagingType'] = $PackagingType; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
$request['RequestedShipment']['TotalInsuredValue']=array('Ammount'=>100,'Currency'=>'USD');

    
		
$request['RequestedShipment']['Shipper'] =  array(
        'Contact' => array(
            'PersonName' => 'Sender Name',
            'CompanyName' => 'Sender Company Name',
            'PhoneNumber' => '9012638716'),
        'Address' => array(
            'StreetLines' => array('Address Line 1'),
            'City' => $ShipperCity,
            'StateOrProvinceCode' => $ShipperState,
            'PostalCode' => $PostalCodeS,
            'CountryCode' => $ShipperCountryCode)
    );


$request['RequestedShipment']['Recipient'] = array(
        'Contact' => array(
            'PersonName' => 'Recipient Name',
            'CompanyName' => 'Company Name',
            'PhoneNumber' => '9012637906'
        ),
        'Address' => array(
            'StreetLines' => array('Address Line 1'),
            'City' => $DestinationCity,
            'StateOrProvinceCode' => $DestinationState,
            'PostalCode' => $PostalCodeD,
            'CountryCode' => $DestinationCountry,
            'Residential' => false)
    );



$request['RequestedShipment']['ShippingChargesPayment'] = array(
        'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
        'Payor' => array(
            'ResponsibleParty' => array(
            'AccountNumber' => $Config['Fedex_account_number'],
            'CountryCode' => 'US')
        )
    );

$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
$request['RequestedShipment']['PackageCount'] = '1';
$request['RequestedShipment']['RequestedPackageLineItems'] =  array(
        'SequenceNumber'=>1,
        'GroupPackageCount'=>1,
        'Weight' => array(
            'Value' => $PackageWeightVal,
            'Units' => $PackageWeightUnit
        ),
        'Dimensions' => array(
            'Length' => $pkDLength,
            'Width' => $pkDWidth,
            'Height' => $pkDHeight,
            'Units' => $pkDUnits
        )
    );


#echo "<pre>";print_r($request);exit;
try 
{
    if(setEndpoint('changeEndpoint'))
    {
        $newLocation = $client->__setLocation(setEndpoint('endpoint'));
    }

    $response = $client ->getRates($request);

    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR')
    {   
        $rateReply = $response -> RateReplyDetails;
        echo '<table border="1">';
        echo '<tr><td>Amount</td></tr><tr>';
       // $serviceType = '<td>'.$rateReply -> ServiceType . '</td>';
        $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
       
        echo $amount;
        echo '</tr>';
        echo '</table>';

       //printSuccess($client, $response);
    }
    else
    {
        printError($client, $response);
    } 

    //writeToLog($client);    // Write to log file   

} catch (SoapFault $exception) {
   printFault($exception, $client);        
}



function addLabelSpecification(){
    $labelSpecification = array(
        'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
        'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
        'LabelStockType' => 'PAPER_7X4.75');
    return $labelSpecification;
}


}

require_once("../includes/footer.php");
?>

<div style="margin-top:21px;text-align:center">
 <form method="post" action="">
        <fieldset>

<label>Tracking Number: <input type="text" class="inputbox" name="track"></label><br><br>
<label>Source ZipCode: <input type="text" class="inputbox" name="PostalCodeS"></label><br><br>
<label>Destination ZipCode: <input type="text" class="inputbox" name="PostalCodeD"></label><br><br>
<input type="submit" value="Submit" class="button">

        </fieldset>

    </form>
</div>

