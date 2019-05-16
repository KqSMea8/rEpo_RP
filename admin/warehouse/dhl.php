<?php
$HideNavigation = 1;
/**************************************************/
$ThisPageName = 'editShipment.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");
// Require the main DHL

$objShipment = new shipment();
$objWarehouse=new warehouse();
$NumLine=$_POST['NumLine'];

$MainDir = "upload/dhl/".$_SESSION['CmpID']."/";
$DocumentDir = _ROOT.'/admin/warehouse/'.$MainDir;

?>

<script language="JavaScript1.2" type="text/javascript">
function SetShippingRate(TotalFrieght,InsureAmount,InsureValue){
	parent.$("#ShippingRateTr").show();
	parent.$("#ShippingRateVal").val(TotalFrieght);
	parent.$("#InsureAmount").val(InsureAmount);
	parent.$("#InsureValue").val(InsureValue);
	parent.jQuery.fancybox.close();	 
}
</script>
<?php 
//////////////////bydefault value //////////////////

$objShipment->saveToandFromData($_POST);

$arryAddBookShFrom=$objShipment->addBookShFrom();

$arryAddBookShTo=$objShipment->addBookShTo();

$arryAddressFrom = $objShipment->defaultAddressBook("ShippingFrom");
$arryAddressTo = $objShipment->defaultAddressBook("ShippingTo");

if(empty($arryAddressFrom[0]['adbID'])){
	$arryListWareh=$objShipment->defaultAddress();
}

#$arrayService=$objShipment->defaultDHLShippingMethod();
$arrayPackage=$objShipment->defaultDHLPack();

#echo "<pre>";print_r($arrayPackage);

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('DHL');
$arraySpecialService=$objShipment->dhlSpecialService();
$arrayService=$objShipment->dhlServiceTypeAll();

$Config['dhl_account_number'] = $arryApiACDetails[0]['api_account_number'];
$Config['dhl_key'] = $arryApiACDetails[0]['api_key'];
$Config['dhl_password'] = $arryApiACDetails[0]['api_password'];


////////////////////////////////////


use DHL\Entity\AM\GetQuote;
use DHL\Datatype\AM\PieceType;
use DHL\Client\Web as WebserviceClient;

use DHL\Entity\GB\ShipmentResponse;
use DHL\Entity\GB\ShipmentRequest;
use DHL\Datatype\GB\Piece;
use DHL\Datatype\GB\SpecialService;


 require('init.php');

 if($_POST['Action']){
//echo "<pre>";print_r($arryCountry);die;
#echo "<pre>";print_r($_POST);die;
$countryNameFrom = $objShipment->getCountryNameByCode($_POST['CountryCgFrom']);
$countryNameTo = $objShipment->getCountryNameByCode($_POST['CountryCgTo']);

if($countryNameFrom[0]['name']=='United States'){
	$countryNameF = 'United States Of America';
}else{
	$countryNameF=$countryNameFrom[0]['name'];
}

 if($countryNameTo[0]['name']=='United States'){
	$countryNameT = 'United States Of America';
}else{
	$countryNameT=$countryNameTo[0]['name'];
}

// DHL Settings
$dhl = $config['dhl'];

// Test a getQuote using DHL XML API
$sample = new GetQuote();
$sample->SiteID = $dhl['id'];
$sample->Password = $dhl['pass'];
//$sample->SiteID =mkbtechnology;
//$sample->Password =84733mkb;


// Set values of the request
$sample->MessageTime = '2001-12-17T09:30:47-05:00';
$sample->MessageReference = '1234567890123456789012345678901';
$sample->BkgDetails->Date = date('Y-m-d');

/*
$InsureAmount = $_POST['InsureAmount'];
$InsureCurrency = $_POST['InsureCurrency'];
$DeclaredCurrency = $_POST['InsureCurrency'];
$numberPack = $_POST['NoOfPackages'];
$DeclaredValue = 0;

if(!empty($InsureAmount)){
	$IV1=$IV2=0;
	if($InsureAmount>100) $IV1 = 2.50;
	if($InsureAmount>300){
		$IV2 = (ceil($InsureAmount/100)-3)*(.70);
	}
	$DeclaredValue = ($IV1 + $IV2)*($numberPack);
	
}else{
$InsureAmount= 150;
$DeclaredValue= 150;
}
*/

$InsureAmount= 100;
$DeclaredValue= 100;
$Currency='USD';
$PaymentCountryCode= 'US';

if($_POST['CountryCgFrom']==$_POST['CountryCgTo']){
	$IsDutiable='N';
}else{
	$IsDutiable='Y';
}

if(empty($_POST['specialService'])){
$specialService='WY';
}else{
$specialService=$_POST['specialService'];
}

/* set the request end here */


/* line item */
for($i=1;$i<=$NumLine;$i++){
/**  line item **/	
$Weight = $_POST['Weight'.$i];
$wtUnit = $_POST['wtUnit'.$i];
$Length = $_POST['Length'.$i];
$Width = $_POST['Width'.$i];
$Height = $_POST['Height'.$i];
$htUnit = $_POST['htUnit'.$i];
/**  line item **/

$piece = new PieceType();
$piece->PieceID = $i;
$piece->Height = $Height;
$piece->Depth = $Length;
$piece->Width = $Width;
$piece->Weight = $Weight;
$sample->BkgDetails->addPiece($piece);

}


$sample->BkgDetails->IsDutiable = $IsDutiable;
$sample->BkgDetails->QtdShp->QtdShpExChrg->SpecialServiceType = $specialService;
$sample->BkgDetails->ReadyTime = 'PT10H21M';
$sample->BkgDetails->ReadyTimeGMTOffset = '+01:00';
$sample->BkgDetails->DimensionUnit = $_POST['htUnit1'];
$sample->BkgDetails->WeightUnit = $_POST['wtUnit1'];
$sample->BkgDetails->PaymentCountryCode = $PaymentCountryCode;
$sample->BkgDetails->IsDutiable = $IsDutiable;

// Request Paperless trade
$sample->BkgDetails->QtdShp->QtdShpExChrg->SpecialServiceType = $specialService;

$sample->From->CountryCode = $_POST['CountryCgFrom'];
$sample->From->Postalcode = $_POST['ZipFrom'];
$sample->From->City = $_POST['CityFrom'];

$sample->To->CountryCode = $_POST['CountryCgTo'];
$sample->To->Postalcode = $_POST['ZipTo'];
$sample->To->City = $_POST['CityTo'];
$sample->Dutiable->DeclaredValue = $DeclaredValue;
$sample->Dutiable->DeclaredCurrency = $Currency;

// Call DHL XML API
$start = microtime(true);
//echo
 $sample->toXML();
$client = new WebserviceClient('staging');
$xml = $client->call($sample);
//echo PHP_EOL . 'Executed in ' . (microtime(true) - $start) . ' seconds.' . PHP_EOL;
// $xml;

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

 $arrrrr =xml_to_array($xml);

//echo "<pre>";print_r($arrrrr);die;

if($NumLine>1){
  $totalFreight = $arrrrr['GetQuoteResponse']['BkgDetails']['QtdShp']['ShippingCharge'];
}else{
$totalFreight = $arrrrr['GetQuoteResponse']['BkgDetails']['QtdShp'][1]['ShippingCharge'];
}

/*if($DeclaredValue>0 && $totalFreight>0){
$totalFreight +=$DeclaredValue;
}
*/
 $error=$arrrrr['GetQuoteResponse']['Note']['Condition']['ConditionData'];


if(empty($error)){
	$error=$arrrrr['Response']['Status']['Condition']['ConditionData'];
}


//echo $arrrrr['GetQuoteResponse']['BkgDetails']['QtdShp'][0]['QtdSInAdCur'][0]['TotalAmount'];


#echo 'hello'.$totalFreight;die;

/* dhl label coading */

    if (strlen($_POST['CompanyFrom'])>30 || strlen($_POST['Contactname'])>30 || strlen($_POST['Address1From'])>30 ||  strlen($_POST['CityFrom'])>30 || strlen($_POST['CompanyTo'])>30 || strlen($_POST['ContactNameTo'])>30 || strlen($_POST['Address1To'])>30 || strlen($_POST['CityTo'])>30){
       $error="Please Enter Input Lenght Max 30 Charectors";
    } 
// Test a ShipmentRequestRequest using DHL XML API

if($totalFreight>0 && $_POST['fedexLabel']=='Yes' && $_POST['Submit'] && empty($error)){



$sample = new ShipmentRequest();

// Set values of the request
$sample->MessageTime = '2001-12-17T09:30:47-05:00';
$sample->MessageReference = '1234567890123456789012345678901';
$sample->SiteID = $dhl['id'];
$sample->Password = $dhl['pass'];
$sample->RegionCode = 'AM';
$sample->RequestedPickupTime = 'Y';
$sample->NewShipper = 'Y';
$sample->LanguageCode = 'en';
$sample->PiecesEnabled = 'Y';
$sample->Billing->ShipperAccountNumber = $dhl['shipperAccountNumber'];
$sample->Billing->ShippingPaymentType = 'S';
$sample->Billing->BillingAccountNumber = $dhl['billingAccountNumber'];
$sample->Billing->DutyPaymentType = 'S';
$sample->Billing->DutyAccountNumber = $dhl['dutyAccountNumber'];

/* To Address */
$sample->Consignee->CompanyName = $_POST['CompanyTo'];
$sample->Consignee->addAddressLine($_POST['Address1To']);
$sample->Consignee->City = $_POST['CityTo'];
$sample->Consignee->PostalCode = $_POST['ZipTo'];
$sample->Consignee->CountryCode = $_POST['CountryCgTo'];
$sample->Consignee->CountryName = $countryNameT;
$sample->Consignee->Contact->PersonName = $_POST['ContactNameTo'];
$sample->Consignee->Contact->PhoneNumber = $_POST['PhoneNoTo'];
$sample->Consignee->Contact->PhoneExtension = '123';
$sample->Consignee->Contact->FaxNumber = $_POST['FaxNoTo'];
$sample->Consignee->Contact->Telex = '506-851-7121';
$sample->Consignee->Contact->Email = 'bashar@alfallouji.com';

/* End To Address */

$sample->Commodity->CommodityCode = 'cc';
$sample->Commodity->CommodityName = 'cn';

$sample->Dutiable->DeclaredValue = $DeclaredValue;
$sample->Dutiable->DeclaredCurrency = $Currency;
$sample->Dutiable->ScheduleB = '3002905110';
$sample->Dutiable->ExportLicense = 'D123456';
$sample->Dutiable->ShipperEIN = '112233445566';
$sample->Dutiable->ShipperIDType = 'S';
$sample->Dutiable->ImportLicense = 'ALFAL';
$sample->Dutiable->ConsigneeEIN = 'ConEIN2123';
$sample->Dutiable->TermsOfTrade = 'DTP';
$sample->Reference->ReferenceID = 'AM international shipment';
$sample->Reference->ReferenceType = 'St';
$sample->ShipmentDetails->NumberOfPieces = $NumLine;

/* line item */
for($j=1;$j<=$NumLine;$j++){
/**  line item **/	
$TotalWeight += $_POST['Weight'.$j];
$Weightp = $_POST['Weight'.$j];
$wtUnitp = $_POST['wtUnit'.$j];
$Lengthp = $_POST['Length'.$j];
$Widthp = $_POST['Width'.$j];
$Heightp = $_POST['Height'.$j];
$htUnitp = $_POST['htUnit'.$j];
/**  line item **/

$piece = new Piece();
$piece->PieceID = $j;
$piece->PackageType = $_POST['packageType'];
$piece->Weight = $Weightp;
$piece->DimWeight = '600.0';
$piece->Width = $Widthp;
$piece->Height = $Heightp;
$piece->Depth = $Lengthp;
$sample->ShipmentDetails->addPiece($piece);
}

if($_POST['wtUnit1']=='LB'){
$wtUnitLabel='L';
}else if($_POST['wtUnit1']=='KG'){
$wtUnitLabel='L';
}

if($_POST['htUnit1']=='IN'){
$DimentionLabel='I';
}else if($_POST['htUnit1']=='CM'){
$DimentionLabel='C';
}


$sample->ShipmentDetails->Weight = $TotalWeight;
$sample->ShipmentDetails->WeightUnit = $wtUnitLabel;

$sample->ShipmentDetails->GlobalProductCode = 'P';
$sample->ShipmentDetails->LocalProductCode = 'P';
$sample->ShipmentDetails->Date = date('Y-m-d');
$sample->ShipmentDetails->Contents = 'AM international shipment contents';
$sample->ShipmentDetails->DoorTo = 'DD';
$sample->ShipmentDetails->DimensionUnit = $DimentionLabel;
$sample->ShipmentDetails->InsuredAmount = $InsureAmount;
$sample->ShipmentDetails->PackageType = $_POST['packageType'];
$sample->ShipmentDetails->IsDutiable = $IsDutiable;
$sample->ShipmentDetails->CurrencyCode = $Currency;
$sample->Shipper->ShipperID = '751008818';

/* from address */

$sample->Shipper->CompanyName = $_POST['CompanyFrom'];
$sample->Shipper->RegisteredAccount = '751008818';
$sample->Shipper->addAddressLine($_POST['Address1From']);
$sample->Shipper->addAddressLine($_POST['StateFrom']);
$sample->Shipper->City = $_POST['CityFrom'];
$sample->Shipper->Division = 'ny';
$sample->Shipper->DivisionCode = 'ny';
$sample->Shipper->PostalCode = $_POST['ZipFrom'];
$sample->Shipper->CountryCode = $_POST['CountryCgFrom'];
$sample->Shipper->CountryName = $countryNameF;
$sample->Shipper->Contact->PersonName = $_POST['Contactname'];
$sample->Shipper->Contact->PhoneNumber = $_POST['PhonenoFrom'];
$sample->Shipper->Contact->PhoneExtension = '3403';
$sample->Shipper->Contact->FaxNumber = $_POST['FaxnoFrom'];
$sample->Shipper->Contact->Telex = '1245';
$sample->Shipper->Contact->Email = 'test@email.com';


/* close from address */

$specialService = new SpecialService();
$specialService->SpecialServiceType = 'A';
$sample->addSpecialService($specialService);

$specialService = new SpecialService();
$specialService->SpecialServiceType = 'I';
$sample->addSpecialService($specialService);

$sample->EProcShip = 'N';

$sample->LabelImageFormat ='PDF';



// Call DHL XML API
$start = microtime(true);
$sample->toXML();
$client = new WebserviceClient('staging');
$xml = $client->call($sample);
//echo PHP_EOL . 'Executed in ' . (microtime(true) - $start) . ' seconds.' . PHP_EOL;

$ArrayResponse = xml2array($xml);

//echo "<pre>";print_r($ArrayResponse);

///echo "<pre>";print_r($ArrayResponse['res:ErrorResponse']['Response']['Status']['ActionStatus']['value']);
 
if($ArrayResponse['res:ErrorResponse']['Response']['Status']['ActionStatus']['value']=='Error'){
  $error=$ArrayResponse['res:ErrorResponse']['Response']['Status']['Condition']['ConditionData']['value'];
}

if(empty($error)){
	// We already built our DHL request object, we can call DHL XML API
	//$client = new WebserviceClient('staging');
	//$xml = $client->call($request);
	$response = new ShipmentResponse();

	$response->initFromXML($xml);



	// Store it as a . PDF file in the filesystem
	//file_put_contents('dhl-label.pdf', base64_decode($response->LabelImage->OutputImage));


	if (!is_dir($MainDir)) {
		mkdir($MainDir);
		chmod($MainDir,0777);
	}
	   $TrackingID = $response->AirwayBillNumber;
	   
	   $file_name = 'DHL000_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.pdf';
					
	 // Store it as a . PDF file in the filesystem
	 	file_put_contents($MainDir.$file_name,base64_decode($response->LabelImage->OutputImage));


		// If you want to display it in the browser
		/*
		$data = base64_decode($response->LabelImage->OutputImage);
		if ($data)
		{
		    header('Content-Type: application/pdf');
		    header('Content-Length: ' . strlen($data));
		    echo $data;exit;
		}
		*/

	}

}




if($_POST['Preview'] && empty($error)){?>
<SCRIPT TYPE="text/javascript">
$.fancybox({
	 'href' :'previewdhl.php?total=<?=$totalFreight;?>',
	 'type' : 'iframe',
	 'width': '500',
	 'height': '200'
	 });
</SCRIPT>

	<? }else if(empty($error)){

		$arr_freigh = (array) $freigh;
		$arr_totalFreight = (array) $totalFreight;
		$_SESSION['Shipping']['ShipType'] = 'DHL';
		$_SESSION['Shipping']['file_name'] = (!empty($file_name)) ? $file_name : 'No Label';
		$_SESSION['Shipping']['tracking_id'] = (!empty($TrackingID)) ? $TrackingID : '';
		$_SESSION['Shipping']['freigh'] = ($arr_freigh[0]>0) ? $arr_freigh[0] : 0;
		$_SESSION['Shipping']['totalFreight'] = ($arr_totalFreight[0]>0) ? $arr_totalFreight[0] : 0;
		$_SESSION['Shipping']['freightCurrency'] = $freightCurrency;

		if($_POST['COD']==1){
			$_SESSION['Shipping']['sendingLabel'] = $file_name1;
			$_SESSION['Shipping']['COD']=1;
		}else{
			$_SESSION['Shipping']['sendingLabel'] = '';
			$_SESSION['Shipping']['COD']=0;
		}

		$freightVal = ($_SESSION['Shipping']['freigh']>0)?($_SESSION['Shipping']['freigh']):($_SESSION['Shipping']['totalFreight']);

		$_SESSION['Shipping']['ZipFrom']=$_POST['ZipFrom'];
		$_SESSION['Shipping']['CityFrom']=$_POST['CityFrom'];
		$_SESSION['Shipping']['StateFrom']=$_POST['StateFrom'];
		$_SESSION['Shipping']['CountryFrom']=$_POST['CountryCgFrom'];
		$_SESSION['Shipping']['ZipTo']=$_POST['ZipTo'];
		$_SESSION['Shipping']['CityTo']=$_POST['CityTo'];
		$_SESSION['Shipping']['StateTo']=$_POST['StateTo'];
		$_SESSION['Shipping']['CountryTo']=$_POST['CountryCgTo'];
		$_SESSION['Shipping']['ShippingMethod']=$_POST['ShippingMethod'];
		$_SESSION['Shipping']['NoOfPackages']=$_POST['NoOfPackages'];
		$_SESSION['Shipping']['Weight']=$_POST['WPK'];
		$_SESSION['Shipping']['WeightUnit']=$_POST['WPK_Unit'];
		$_SESSION['Shipping']['PackageType']=$_POST['packageType'];
		$_SESSION['Shipping']['DeliveryDate']=$DeliveryDate;
		$_SESSION['Shipping']['LineItem'] = $LineItemDetail;
		
		echo "<script>SetShippingRate('".$freightVal."','".$InsureAmount."','".$InsureValue."');</script>";
		exit;

	}else{
		echo "<div class=redmsg align='center'>Please Enter Correct Information : <br>".$error.'</div><br>';
	}
	

  }
  
  
//$arryApiACDetails = $objShipment->getApiAccountDetail();

require_once("../includes/footer.php");
?>


