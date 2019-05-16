<?php
/**************************************************/

/**************************************************/

include_once("../includes/settings.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/sales.quote.order.class.php");

require_once($strPath.'ANSI_X_12/ANSI_X12_601_Class.php');

$objShipment = new shipment();
$objSale = new sale();

if(!empty($_GET['ShippedID'])){

	$arryShipping = $objShipment->listingShipmentDetail($_GET['ShippedID']);
	$MultipleOrderID =  $arryShipping[0]['MultipleOrderID'];
	$Multiple =  $arryShipping[0]['Multiple'];

	/************************/
	if($Multiple==1 && !empty($MultipleOrderID)){ //Parent
		//echo $MultipleOrderID;
	}else{ //child or individual
		$ShippedID = $objShipment->GetShipmentParent($_GET['ShippedID']);
		if($ShippedID>0){
			unset($arryShipping);
			$_GET['ShippedID'] = $ShippedID;
			$arryShipping = $objShipment->listingShipmentDetail($_GET['ShippedID']);
			$MultipleOrderID =  $arryShipping[0]['MultipleOrderID'];
			$Multiple =  $arryShipping[0]['Multiple'];
		}
	}
	/************************/
	$shipperCountry = $objShipment->getCountryNameByCode($arryShipping[0]['CountryFrom']);
	$recipientCountry = $objShipment->getCountryNameByCode($arryShipping[0]['CountryTo']);
	$arrySale = $objShipment->GetShipment($_GET['ShippedID'],'','Shipment');
	$OrderID   = $arrySale[0]['OrderID'];
	if($Multiple==1 && !empty($MultipleOrderID)){
		$OrderID = $OrderID.','.$MultipleOrderID;
	}

	$arrySaleItem = $objSale->GetSaleItemIN($OrderID);
	$NumLine = sizeof($arrySaleItem);


}else{
	echo $ErrorMSG = NOT_EXIST_DATA;exit;
}


/**************************Sep 2017****************************/

$TodayDate=date("Y-m-d");
$TodayDateArray= explode(" ",$TodayDate);
//echo $Date = str_replace("-","", $TodayDateArray[0]);

$X12info['USPPI']='462653406';
$X12info['Version']='00405';
$X12info['SESTTransactionSet']='0001';
$X12info['InterchangeControlNumber']='000000650';
$X12info['GroupControl']='1';
$X12info['Date'] = str_replace("-","", $TodayDateArray[0]);

/** Y M D **/
$DateAllVal= explode("-",$TodayDateArray[0]);
$year= substr($DateAllVal[0], -2);
$month=$DateAllVal[1];
$day=$DateAllVal[2];
$X12info['InterchangeDate'] = $year.$month.$day;
/**  end **/

/************************Data From Shipping********************/
$X12info['ShipmentDate']=$arryShipping[0]['ShipmentDate'];

$X12info['CompanyFrom']=$arryShipping[0]['CompanyFrom'];
$X12info['FirstnameFrom']=$arryShipping[0]['FirstnameFrom'];
$X12info['LastnameFrom']=$arryShipping[0]['LastnameFrom'];
$X12info['Contactname']=$arryShipping[0]['Contactname'];
$X12info['Address1From']=$arryShipping[0]['Address1From'];
$X12info['Address2From']=$arryShipping[0]['Address2From'];
$X12info['ZipFrom']=$arryShipping[0]['ZipFrom'];
$X12info['CityFrom']=$arryShipping[0]['CityFrom'];
$X12info['StateFrom']=$arryShipping[0]['StateFrom'];
$X12info['CountryFrom']=$arryShipping[0]['CountryCgFrom'];

$X12info['CompanyTo']=$arryShipping[0]['CompanyTo'];
$X12info['FirstnameTo']=$arryShipping[0]['FirstnameTo'];
$X12info['LastnameTo']=$arryShipping[0]['LastnameTo'];
$X12info['ContactNameTo']=$arryShipping[0]['ContactNameTo'];
$X12info['Address1To']=$arryShipping[0]['Address1To'];
$X12info['Address2To']=$arryShipping[0]['Address2To'];
$X12info['ZipTo']=$arryShipping[0]['ZipTo'];
$X12info['CityTo']=$arryShipping[0]['CityTo'];
$X12info['StateTo']=$arryShipping[0]['StateTo'];
$X12info['CountryTo']=$arryShipping[0]['CountryCgTo'];
/***********************************************************/

//BA1
$X12info['CompanyIndication']='Y'; // Y N
$X12info['ActionCode']='1'; //  1 ADD 2 CHANGE , C CANCEL ,RX REPLACE
$X12info['TransportationMethod'] = "40"; //Transportation Method/Type Code 40 - AIR
$X12info['CountryDestinationCode']='GB'; // COUNTRY OF ULTIMATE DESTINATION CODE
$X12info['ShipmentReferenceNo']='SO97583'; // SHIPMENT REFERENCE NO Reference Identification
$X12info['ZipCodeOfOrigin']='32746'; // zip code for United States
$X12info['CountryCodeOfOrigin']='NO'; //DATA ENTRY CENTER INDICATOR
$X12info['StateCodeOfOrigin']='FL'; //U.S. STATE OF ORIGIN CODE
$X12info['Authority']=''; // Name or code of authority for authorizing action or reservation
$X12info['CarrierAlphaCode']='99U'; // Careet identification code
$X12info['LocationIdentifier']=''; // Location Identifier
$X12info['ExportingCareer']='FedEx'; //Vessel Name

//YNQ
$X12info['HAZMAT1']='RZ'; //HAZARDOUS MATERIAL INDICATOR (HAZMAT) RZ QQ RX R3P R3F B
$X12info['HAZMATResponseCode1']='N'; //Yes/No Condition or Response Code
$X12info['HAZMAT2']='QQ'; //HAZARDOUS MATERIAL INDICATOR (HAZMAT) RZ QQ RX R3P R3F B
$X12info['HAZMATResponseCode2']='N'; //Yes/No Condition or Response Code

//DTM
$X12info['RequestedDepartureDate']='274';//274 Requested Departure Date
//P5
$X12info['PortFunctionCode']='L';//Port or Terminal Function Code
$X12info['LocationQualifie']='D';//Location Qualifier
$X12info['LocationIdentifierCode']='2304';//LocationIdentifierCode dentification of right to payment and expedited claim  2304

//REF
$X12info['ReferenceIdQualifier']='BN';//BN F8 //Original ITN Code
$X12info['ReferenceIdentifier']='25039614';//Original ITN number
$X12info['ReferenceDescription']='TEST SHIPMENT';//Description


//M12
$X12info['CBPEntryType']='70';//Merchandise NOT shipped inbond
$X12info['CBPEntryNumber']='';//	Customs and Border Protection (CBP) Entry Number
$X12info['LocationIdentifierM']='';//Customs and Border Protection (CBP) Entry Number
$X12info['ROUTEDEXPORTRANSACTION']='N';//ROUTED EXPORT TRANSACTION


//US Principle Party in Interest (USPPI) start
//N1
$X12info['UltimateConsignee']='EX';//Ultimate Consignee 25039614  CN EX FW IC
$X12info['UltimateConsigneeName']='OTEP TECHNOLOGIES';//USPPI NAME
$X12info['EIN']='24';//Employer's Identification Number (EIN) 24
$X12info['UltimateConsigneeAddress']='OAKDALE HOUSE, CALE LANE, ASPULL, WIGAN,GB';//Ultimate consignee name and address

//N2
$X12info['CompanyFrom']="MKB TECHNOLOGY/OTEP";//Title and/or First Name - Maximum size, 13 bytes, left justified.
$X12info['PhoneFrom']= "4072605026";//For-mat: NNNNNNNNNNxxx whereN = area code + 7-digit number and x = 3 spaces.
//N3
$X12info['Address1From'] ="650 TECHNOLOGY PARK";
//N4
$X12info['ZipFrom']="32746";
$X12info['CityFrom']="LAKE MARY";
$X12info['StateFrom']="FL";
$X12info['CountryFrom']="US";
//end here


//Ultimate Consignee//
//N1
$X12info['UlConsignee']='CN';//Ultimate Consignee   CN EX FW IC
$X12info['UlConsigneeName']='OTEP TECHNOLOGIES LTD';//USPPI NAME
$X12info['UlConsigneeType']='XT';// R Reseller

//N3
$X12info['UlConsigneeAddress'] ="OAKDALE HOUSE";
//N4

$X12info['UlConsigneeCity']="SANTIAGO, TIANGIUSTENCO";
$X12info['UlConsigneeState']="MX";
$X12info['UlConsigneeZip']="52600";
$X12info['UlConsigneeCountry']="MX";

//Ultimate Consignee END//

//Intermediate Consignee//
//N1
$X12info['InConsignee']='IC';//Ultimate Consignee   CN EX FW IC
$X12info['InConsigneeName']='OTEP TECHNOLOGIES LTD';//USPPI NAME
$X12info['InConsigneeType']='DU';//Reseller

//N3
$X12info['InConsigneeAddress'] ="OAKDALE HOUSE";

//N4
$X12info['InConsigneeCity']="SANTIAGO, TIANGIUSTENCO";
$X12info['InConsigneeState']="MX";
$X12info['InConsigneeZip']= "52600";
$X12info['InConsigneeCountry']="MX";

// L13
$X12info['HTSCode']='A'; //U.S. Census Bureau, Schedule B number
$X12info['HTSNumber']= '3907200000';//'8473300002'; //HTS Number
$X12info['Unit']='KG'; //Unit or Basis for Measurement Code
$X12info['Quantity']='17600'; //Unit or Basis for Measurement Code
$X12info['ShippingAmount']='10'; //Shipment Value in U.S. Dollars
$X12info['ShippingMonetaryAmount']='26518'; //Monetary Amount
$X12info['LINENUMBER']='1'; //LINE NUMBER
$X12info['WeightUnitCode']='K'; //Kilograms
$X12info['Weight']='18924'; //SHIPPING WEIGHT
$X12info['COMMODITYDESCRIPTION']='HP 2GB P-SERIES SMART ARRAY FLASH BACKED WRIT';//EXPORT INFORMATION CODE
$X12info['EXPORTINFORMATIONCODE']='OS';//EXPORT INFORMATION CODE
$X12info['LINEITEMACTION']='1';//EXPORT INFORMATION CODE ADD CHANGE 3 DELETE A, C, OR D

//Intermediate Consignee END//

/*************************************************************/


$MainDir = "upload/AES/".$_SESSION['CmpID']."/";

if (!is_dir($MainDir)) {
	mkdir($MainDir);
	chmod($MainDir,0777);
}

//$content = create_ISA($X12info);

$content = print_elig($X12info,$arrySaleItem);

//$content = "hello this is a testing";
$file_name = 'AES601_'.$OrderID.'.txt';
//$file_name = $arryShipping[0]['AesNumber'].'.doc';

$fp = fopen($MainDir.$file_name, 'wb');
fwrite($fp, $content);

fclose($fp);

$file_path = $MainDir.$file_name;

if (file_exists($file_path)){
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");

	header("Content-Disposition: attachment; filename=".basename($file_path).";");


	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($file_path));

	readfile("$file_path");
	exit;

}



?>
