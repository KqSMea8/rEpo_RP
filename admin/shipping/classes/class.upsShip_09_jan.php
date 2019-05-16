<?php

class upsShip {
	var $buildRequestXML;
	var $xmlSent;
	var $responseXML;
	var $ShipmentDigest;

	function upsShip($upsObj) {
		// Must pass the UPS object to this class for it to work
		$this->ups = $upsObj;
	}

	function buildRequestXML() {
		global $Config;
		$xml = $this->ups->access();

		$ShipmentConfirmRequestXML = new xmlBuilder();
		$ShipmentConfirmRequestXML->push('ShipmentConfirmRequest');
		$ShipmentConfirmRequestXML->push('Request');
		$ShipmentConfirmRequestXML->push('TransactionReference');
		$ShipmentConfirmRequestXML->element('CustomerContext', 'ups-php');
		$ShipmentConfirmRequestXML->element('XpciVersion', '1.0001');
		$ShipmentConfirmRequestXML->pop();
		$ShipmentConfirmRequestXML->element('RequestAction', 'ShipConfirm');
		$ShipmentConfirmRequestXML->element('RequestOption', 'nonvalidate');
		$ShipmentConfirmRequestXML->pop(); // end Request
		$ShipmentConfirmRequestXML->push('Shipment');
		$ShipmentConfirmRequestXML->push('Shipper');

		$ShipmentConfirmRequestXML->element('Name', $_POST['FirstnameFrom'].'-'.$_POST['LastnameFrom']);
		$ShipmentConfirmRequestXML->element('AttentionName', $_POST['FirstnameFrom'].'-'.$_POST['LastnameFrom']);
		$ShipmentConfirmRequestXML->element('ShipperNumber', $Config['ups_ShipperNumber']); //'11YA89';
		$ShipmentConfirmRequestXML->push('Address');
		$ShipmentConfirmRequestXML->element('AddressLine1', $_POST['Address1From']);
		$ShipmentConfirmRequestXML->element('City', $_POST['CityFrom']);
		$ShipmentConfirmRequestXML->element('StateProvinceCode', $_POST['StateFrom']);
		$ShipmentConfirmRequestXML->element('PostalCode', $_POST['ZipFrom']);
		$ShipmentConfirmRequestXML->pop(); // end Address
		$ShipmentConfirmRequestXML->pop(); // end Shipper
		$ShipmentConfirmRequestXML->push('ShipTo');
		$ShipmentConfirmRequestXML->element('CompanyName', $_POST['CompanyTo']);
		$ShipmentConfirmRequestXML->element('AttentionName', $_POST['FirstnameTo'].'-'.$_POST['LastnameTo']);
		$ShipmentConfirmRequestXML->push('PhoneNumber');
		$ShipmentConfirmRequestXML->push('StructuredPhoneNumber');
		$ShipmentConfirmRequestXML->element('PhoneDialPlanNumber', '410');
		$ShipmentConfirmRequestXML->element('PhoneLineNumber', '5551212');
		$ShipmentConfirmRequestXML->element('PhoneExtension', '1234');
		$ShipmentConfirmRequestXML->pop(); // end StrurcturedPhoneNumber
		$ShipmentConfirmRequestXML->pop(); // end PhoneNumber
		$ShipmentConfirmRequestXML->push('Address');
		$ShipmentConfirmRequestXML->element('AddressLine1', $_POST['Address1To']);
		$ShipmentConfirmRequestXML->element('City', $_POST['CityTo']);
		$ShipmentConfirmRequestXML->element('StateProvinceCode', $_POST['StateTo']);
		$ShipmentConfirmRequestXML->element('CountryCode', $_POST['CountryCgTo']);
		$ShipmentConfirmRequestXML->element('PostalCode', $_POST['ZipTo']);
		$ShipmentConfirmRequestXML->element('ResidentialAddress', '');
		$ShipmentConfirmRequestXML->pop(); // end Address
		$ShipmentConfirmRequestXML->pop(); // end ShipTo
		$ShipmentConfirmRequestXML->push('Service');
		$ShipmentConfirmRequestXML->element('Code', $_POST['ShippingMethod']);
		$ShipmentConfirmRequestXML->element('Description','UPS Shipment');
		$ShipmentConfirmRequestXML->pop(); // end Service
		$ShipmentConfirmRequestXML->push('PaymentInformation');
		$ShipmentConfirmRequestXML->push('Prepaid');
		$ShipmentConfirmRequestXML->push('BillShipper');

		 
		$ShipmentConfirmRequestXML->element('AccountNumber', $Config['ups_ShipperNumber']);		
		 

		/*$ShipmentConfirmRequestXML->push('CreditCard');
		$ShipmentConfirmRequestXML->element('Type', '06');
		$ShipmentConfirmRequestXML->element('Number', '4111111111111111');
		$ShipmentConfirmRequestXML->element('ExpirationDate', '0119');
		$ShipmentConfirmRequestXML->pop(); // end CreditCard
		*/



		$ShipmentConfirmRequestXML->pop(); // end BillShipper
		$ShipmentConfirmRequestXML->pop(); // end Prepaid
		$ShipmentConfirmRequestXML->pop(); // end PaymentInformation
		$ShipmentConfirmRequestXML->push('ShipmentServiceOptions');
		$ShipmentConfirmRequestXML->push('OnCallAir');
		$ShipmentConfirmRequestXML->push('PickupDetails');

		/******************/
		$TodayDateArray= explode(" ",$Config['TodayDate']);
		$Date = str_replace("-","", $TodayDateArray[0]);
		$Time1 = strtotime($TodayDateArray[1]);// + 60*60*0;
		$Time2 = strtotime($TodayDateArray[1]) + 60*60*1;
		$EarliestTimeReady = date('Hi', $Time1);
		$LatestTimeReady = date('Hi', $Time2);
 
		//$Date = '20161117';
		/*$EarliestTimeReady = '2016';
		$LatestTimeReady = '2116';
		/******************/
		//echo $Date.'#'.$EarliestTimeReady.'#'.$LatestTimeReady;exit;
		//$x=date("Ymd");
		$ShipmentConfirmRequestXML->element('PickupDate', $Date);
		$ShipmentConfirmRequestXML->element('EarliestTimeReady', $EarliestTimeReady);
		$ShipmentConfirmRequestXML->element('LatestTimeReady', $LatestTimeReady);
		$ShipmentConfirmRequestXML->push('ContactInfo');
		$ShipmentConfirmRequestXML->element('Name', 'JaneSmith');
		$ShipmentConfirmRequestXML->element('PhoneNumber', '9725551234');
		$ShipmentConfirmRequestXML->pop(); // end ContactInfo
		$ShipmentConfirmRequestXML->pop(); // end PickupDetails
		$ShipmentConfirmRequestXML->pop(); // end OnCallAir
		$ShipmentConfirmRequestXML->pop(); // end ShipmentServiceOptions
		$ShipmentConfirmRequestXML->push('Package');
		$ShipmentConfirmRequestXML->push('PackagingType');
		$ShipmentConfirmRequestXML->element('Code', $_POST['packageType']);
		$ShipmentConfirmRequestXML->pop(); // end PackagingType
		$ShipmentConfirmRequestXML->push('Dimensions');
		$ShipmentConfirmRequestXML->push('UnitOfMeasurement');
		$ShipmentConfirmRequestXML->element('Code',$_POST['htUnit1']);
		$ShipmentConfirmRequestXML->pop(); // end UnitOfMeasurement
		$ShipmentConfirmRequestXML->element('Length', $_POST['LengthLabel']);
		$ShipmentConfirmRequestXML->element('Width', $_POST['WidthLabel']);
		$ShipmentConfirmRequestXML->element('Height', $_POST['HeightLabel']);
		$ShipmentConfirmRequestXML->pop(); // end Dimensions
		$ShipmentConfirmRequestXML->push('PackageWeight');
		$ShipmentConfirmRequestXML->element('Weight',$_POST['WeightLabel']);
		$ShipmentConfirmRequestXML->pop(); // end PackageWeight
		$ShipmentConfirmRequestXML->push('ReferenceNumber');
		$ShipmentConfirmRequestXML->element('Code', '02');
		$ShipmentConfirmRequestXML->element('Value', $_POST['PONUMBER']);
		$ShipmentConfirmRequestXML->pop(); // end ReferenceNumber
		$ShipmentConfirmRequestXML->push('PackageServiceOptions');

		if($Config['DSFlag']==1){
		$ShipmentConfirmRequestXML->push('DeliveryConfirmation');
		$ShipmentConfirmRequestXML->element('DCISType',$_POST['DSOptionsType']);
		$ShipmentConfirmRequestXML->pop(); // End Delivry
		}

		$ShipmentConfirmRequestXML->push('InsuredValue');
		$ShipmentConfirmRequestXML->element('CurrencyCode', 'USD');
		$ShipmentConfirmRequestXML->element('MonetaryValue', $_POST['InsureAmount']);
		$ShipmentConfirmRequestXML->pop(); // End Insured Value

		if($Config['CodFlag']==1){
			
			   $ShipmentConfirmRequestXML->push('COD');
					$ShipmentConfirmRequestXML->element('CODCode', '3');
					$ShipmentConfirmRequestXML->element('CODFundsCode', '0');
					$ShipmentConfirmRequestXML->push('CODAmount');
							$ShipmentConfirmRequestXML->element('CurrencyCode', 'USD');
							$ShipmentConfirmRequestXML->element('MonetaryValue',$_POST['CODAmount']);
					$ShipmentConfirmRequestXML->pop(); // End COD Value
         		$ShipmentConfirmRequestXML->pop(); // End COD Value
		}


		// $ShipmentConfirmRequestXML->push('VerbalConfirmation');
		// 	$ShipmentConfirmRequestXML->element('Name', 'SidneySmith');
		// 	$ShipmentConfirmRequestXML->element('PhoneNumber', '4105551234');
		// $ShipmentConfirmRequestXML->pop(); // end VerbalConfirmation
		$ShipmentConfirmRequestXML->pop(); // end PackageServiceOptions
		$ShipmentConfirmRequestXML->pop(); // end Package
		$ShipmentConfirmRequestXML->pop(); // end Shipment
		$ShipmentConfirmRequestXML->push('LabelSpecification');
		$ShipmentConfirmRequestXML->push('LabelPrintMethod');
		$ShipmentConfirmRequestXML->element('Code', 'GIF');
		$ShipmentConfirmRequestXML->pop(); // end LabelPrintMethod
		$ShipmentConfirmRequestXML->element('HTTPUserAgent', 'Mozilla/4.5');
		$ShipmentConfirmRequestXML->push('LabelImageFormat');
		$ShipmentConfirmRequestXML->element('Code', 'GIF');
		$ShipmentConfirmRequestXML->pop(); // end LabelImageFormat
		$ShipmentConfirmRequestXML->pop(); // end LabelSpecification
		$ShipmentConfirmRequestXML->pop(); // ShipmentConfirmRequest

		$xml .= $ShipmentConfirmRequestXML->getXml();

		$responseXML = $this->ups->request('ShipConfirm', $xml);

		$this->xmlSent = $xml;
		$this->responseXML = $responseXML;
		return $responseXML;
	}

	function buildShipmentAcceptXML($ShipmentDigest) {

		$xml = new xmlBuilder();
		$xml->push('ShipmentAcceptRequest');
		$xml->push('Request');
		$xml->push('TransactionReference');
		$xml->element('CustomerContext', 'guidlikesubstance');
		$xml->element('XpciVersion', '1.0001');
		$xml->pop(); // end TransactionReference
		$xml->element('RequestAction', 'ShipAccept');
		$xml->pop(); // end Request
		$xml->element('ShipmentDigest', $ShipmentDigest);
		$xml->pop(); // end ShipmentAcceptRequest


		$ShipmentAcceptXML = $this->ups->access();
		$ShipmentAcceptXML .= $xml->getXml();

		$responseXML = $this->ups->request('ShipAccept', $ShipmentAcceptXML);
		$this->responseXML = $responseXML;

		return $ShipmentAcceptXML;
	}

	function responseArray() {
		$xmlParser = new upsxmlParser();
		$responseArray = $xmlParser->xmlParser($this->responseXML);
		$responseArray = $xmlParser->getData();
		return $responseArray;
	}



}

?>
