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

		if(empty($_POST['Currency'])) $_POST['Currency']='USD';//temp

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


/// add 18 april
  		/* $ShipmentConfirmRequestXML->push('SoldTo');
		$ShipmentConfirmRequestXML->element('Name', 'ABC Sold'); 
		$ShipmentConfirmRequestXML->element('CompanyName', 'Sold Company');
		$ShipmentConfirmRequestXML->element('AttentionName', 'Attention Sold');
		$ShipmentConfirmRequestXML->element('TaxIdentificationNumber', '987654');
		$ShipmentConfirmRequestXML->element('PhoneNumber', '9876543210');
		$ShipmentConfirmRequestXML->push('Address');
		$ShipmentConfirmRequestXML->element('AddressLine1', 'H 146');
		$ShipmentConfirmRequestXML->element('AddressLine2', 'Sector 63');
		$ShipmentConfirmRequestXML->element('AddressLine3', 'Noida');
		$ShipmentConfirmRequestXML->element('City', 'Noida');
		$ShipmentConfirmRequestXML->element('StateProvinceCode', 'DL');
		$ShipmentConfirmRequestXML->element('PostalCode', '201301');
		$ShipmentConfirmRequestXML->element('CountryCode', 'IN');  
                $ShipmentConfirmRequestXML->pop(); // end Address		      
                $ShipmentConfirmRequestXML->pop(); // end SoldTo*/

		$ShipmentConfirmRequestXML->element('Description', 'UPS Service'); // ADDED

/// end here

		$ShipmentConfirmRequestXML->push('Shipper');

		$ShipmentConfirmRequestXML->element('Name', $_POST['FirstnameFrom'].'-'.$_POST['LastnameFrom']);
		$ShipmentConfirmRequestXML->element('AttentionName', $_POST['FirstnameFrom'].'-'.$_POST['LastnameFrom']);
		$ShipmentConfirmRequestXML->element('PhoneNumber', $_POST['PhonenoFrom']); // ADDED
		$ShipmentConfirmRequestXML->element('ShipperNumber', $Config['ups_ShipperNumber']); //'11YA89';
		$ShipmentConfirmRequestXML->push('Address');
		$ShipmentConfirmRequestXML->element('AddressLine1', $_POST['Address1From'].'-'.$_POST['Address2From']);
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
		$ShipmentConfirmRequestXML->element('AddressLine1', $_POST['Address1To'].'-'.$_POST['Address2To']);
		$ShipmentConfirmRequestXML->element('City', $_POST['CityTo']);
		$ShipmentConfirmRequestXML->element('StateProvinceCode', $_POST['StateTo']);
		$ShipmentConfirmRequestXML->element('CountryCode', $_POST['CountryCgTo']);
		$ShipmentConfirmRequestXML->element('PostalCode', $_POST['ZipTo']);
		$ShipmentConfirmRequestXML->element('ResidentialAddress', '');
		$ShipmentConfirmRequestXML->pop(); // end Address
		$ShipmentConfirmRequestXML->pop(); // end ShipTo
		$ShipmentConfirmRequestXML->push('Service');
		$ShipmentConfirmRequestXML->element('Code', $_POST['ShippingMethod']);
		$ShipmentConfirmRequestXML->element('Description',$_POST['ShippingMName']);
		$ShipmentConfirmRequestXML->pop(); // end Service


		
		/****Invoice Line Total*****/
		if($_POST['CountryCgFrom']=='US' && ($_POST['CountryCgTo']=='CA' || $_POST['CountryCgTo']=='PR')){
			$ShipmentConfirmRequestXML->push('InvoiceLineTotal');
			$ShipmentConfirmRequestXML->element('CurrencyCode', $_POST['Currency']);
			$ShipmentConfirmRequestXML->element('MonetaryValue', $_POST['GrandTotalAmount']);
			$ShipmentConfirmRequestXML->pop(); // end Invoice Line Total

		}
		/*********************/

            /*********Bill Receiver**************/
		if($_POST['AccountType']=='1'){
		  $ShipmentConfirmRequestXML->push('PaymentInformation');
                $ShipmentConfirmRequestXML->push('FreightCollect');
                    $ShipmentConfirmRequestXML->push('BillReceiver');
                            $ShipmentConfirmRequestXML->element('AccountNumber',$_POST['AccountNumber']);
                     
                             $ShipmentConfirmRequestXML->push('Address');
	                               $ShipmentConfirmRequestXML->element('PostalCode', '32746');
	                              $ShipmentConfirmRequestXML->element('CountryCode', 'US');
	                               //$ShipmentConfirmRequestXML->element('ConsigneeBilled', 'US');
                            $ShipmentConfirmRequestXML->pop(); 
                            
                    $ShipmentConfirmRequestXML->pop(); // end Bill Receiver 
                $ShipmentConfirmRequestXML->pop(); // end Freight Collect
            $ShipmentConfirmRequestXML->pop(); // end PaymentInformation
		}
           /*****************End here*********/


         /******************Bill Shipper (Prepaid)***************/
		
		if($_POST['AccountType']=='2'){

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
		}
	   /**********************End here*******************************/


           /**********************Bill Third Party (3rd Party)**********/
		if($_POST['AccountType']=='3'){ 
		$ShipmentConfirmRequestXML->push('PaymentInformation');
                $ShipmentConfirmRequestXML->push('BillThirdParty');
                    $ShipmentConfirmRequestXML->push('BillThirdPartyShipper');
                            $ShipmentConfirmRequestXML->element('AccountNumber',$_POST['AccountNumber']);
                            $ShipmentConfirmRequestXML->push('ThirdParty');
                             $ShipmentConfirmRequestXML->push('Address');
	                               $ShipmentConfirmRequestXML->element('PostalCode', '32746');
	                               $ShipmentConfirmRequestXML->element('CountryCode', 'US');
                            $ShipmentConfirmRequestXML->pop(); 
                            $ShipmentConfirmRequestXML->pop(); 
                    $ShipmentConfirmRequestXML->pop(); // end BillShipper 
                $ShipmentConfirmRequestXML->pop(); // end Prepaid
            $ShipmentConfirmRequestXML->pop(); // end PaymentInformation
		  }
         /****************************************************************/



if(!empty($_POST['PickupEnabled'])){

		if(!empty($_POST['PickupOptionsVal'])){
			$PickupOptionsVal = $_POST['PickupOptionsVal'];
		}else{
			$PickupOptionsVal = 'OnCallAir';
		}


		$ShipmentConfirmRequestXML->push('ShipmentServiceOptions');
		//$ShipmentConfirmRequestXML->push('OnCallAir');

		$ShipmentConfirmRequestXML->push($PickupOptionsVal);


		$ShipmentConfirmRequestXML->push('PickupDetails');

		/******************/
		$TodayDateArray= explode(" ",$Config['TodayDate']);
		$Date = str_replace("-","", $TodayDateArray[0]);
		$Time1 = strtotime($TodayDateArray[1]);// + 60*60*0;
		$Time2 = strtotime($TodayDateArray[1]) + 60*60*1;
		//$EarliestTimeReady = date('Hi', $Time1);
		//$LatestTimeReady = date('Hi', $Time2);
		$EarliestTimeReady = '0900';
		$LatestTimeReady = '1900';
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
		$ShipmentConfirmRequestXML->element('Name', $_POST['FirstnameFrom'].'-'.$_POST['LastnameFrom']);
		$ShipmentConfirmRequestXML->element('PhoneNumber', $_POST['PhonenoFrom']);
		$ShipmentConfirmRequestXML->pop(); // end ContactInfo
		$ShipmentConfirmRequestXML->pop(); // end PickupDetails
		$ShipmentConfirmRequestXML->pop(); // end OnCallAir
		$ShipmentConfirmRequestXML->pop(); // end ShipmentServiceOptions

}


//$WeightXml = $LengthXml = $WidthXml = $HeightXml = '';
for($j=0;$j<$_POST['NoOfPackages'];$j++){
                $counterV = ($counterV + 1);	
		$WeightXml = $_POST['Weight'.$counterV];
		$wtUnitXml = $_POST['wtUnit'.$counterV];
		$LengthXml = $_POST['Length'.$counterV];
		$WidthXml = $_POST['Width'.$counterV];
		$HeightXml = $_POST['Height'.$counterV];
		$htUnitXml = $_POST['htUnit'.$counterV];

		$ShipmentConfirmRequestXML->push('Package');
		$ShipmentConfirmRequestXML->push('PackagingType');
		$ShipmentConfirmRequestXML->element('Code', $_POST['packageType']);
		$ShipmentConfirmRequestXML->pop(); // end PackagingType
		$ShipmentConfirmRequestXML->push('Dimensions');
		$ShipmentConfirmRequestXML->push('UnitOfMeasurement');
		$ShipmentConfirmRequestXML->element('Code',$htUnitXml);
		$ShipmentConfirmRequestXML->pop(); // end UnitOfMeasurement
		$ShipmentConfirmRequestXML->element('Length', $LengthXml);
		$ShipmentConfirmRequestXML->element('Width', $WidthXml);
		$ShipmentConfirmRequestXML->element('Height', $HeightXml);
		$ShipmentConfirmRequestXML->pop(); // end Dimensions
		$ShipmentConfirmRequestXML->push('PackageWeight');
		$ShipmentConfirmRequestXML->element('Weight',$WeightXml);
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
		$ShipmentConfirmRequestXML->element('CurrencyCode', $_POST['Currency']);
		$ShipmentConfirmRequestXML->element('MonetaryValue', $_POST['InsureAmount']);
		$ShipmentConfirmRequestXML->pop(); // End Insured Value

		if($Config['CodFlag']==1){
			
			   $ShipmentConfirmRequestXML->push('COD');
					$ShipmentConfirmRequestXML->element('CODCode', '3');
					$ShipmentConfirmRequestXML->element('CODFundsCode', '0');
					$ShipmentConfirmRequestXML->push('CODAmount');
							$ShipmentConfirmRequestXML->element('CurrencyCode', $_POST['Currency']);
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

}


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
