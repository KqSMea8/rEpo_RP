<?php 
	/**************************************************/

	$ThisPageName = "editAES.php";	

	/**************************************************/

	include_once("../includes/header.php");
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

	
	
	
	
		/*************Other Information*****************/
		$X12info['SenderId']='123456789';//INTERCHANGE SENDER ID
		$X12info['RecevierId']='USCSAESTEST';//INTERCHANGE RECEIVER ID
		/**********************************************/
		

		$X12info['ShipType']=$arryShipping[0]['ShipType'];
		
		
		//N1
		$X12info['UltimateConsignee ']='CN';//Ultimate Consignee   CN EX FW IC
		$X12info['UltimateConsigneeName']='OTEP TECHNOLOGIES LTD';//USPPI NAME
		$X12info['EIN']='61144154700';//Employer's Identification Number (EIN)
		$X12info['USPPIID']='02';//PARTY ID and USPPI ID
		$X12info['UltimateConsigneeAddress']='OAKDALE HOUSE, CALE LANE, ASPULL, WIGAN,GB';//Ultimate consignee name and address
		$X12info['UltimateConsigneeType']='R';//Reseller
		
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
		
		
		
		//BA1 Export Shipment Identifying Information
		$X12info['CompanyIndication']='Y'; // Y N
		$X12info['ActionCode']='1'; //  1 ADD 2 CHANGE , C CANCEL ,RX REPLACE
		$X12info['TransportationMethod'] = "AIR"; //Transportation Method/Type Code 40 - AIR
		$X12info['CountryDestinationCode']='GB'; // COUNTRY OF ULTIMATE DESTINATION CODE
		$X12info['ShipmentReferenceNo']='SO97583'; // SHIPMENT REFERENCE NO Reference Identification
		$X12info['ZipCodeOfOrigin']='32746'; // zip code for United States
		$X12info['CountryCodeOfOrigin']='US'; //DATA ENTRY CENTER INDICATOR
		$X12info['StateCodeOfOrigin']='FL'; //U.S. STATE OF ORIGIN CODE
		$X12info['Authority']='1'; // Name or code of authority for authorizing action or reservation
		$X12info['CarrierAlphaCode']='99U'; // Careet identification code
		$X12info['LocationIdentifier']='61144154700'; // Location Identifier
		$X12info['ExportingCareer']='FedEx'; //Vessel Name
		
		//YNQ1
		$X12info['HAZMAT']='B'; //HAZARDOUS MATERIAL INDICATOR (HAZMAT) RZ QQ RX R3P R3F B
		$X12info['HAZMATResponseCode']='N'; //Yes/No Condition or Response Code
		
		//M12
		$X12info['RequestedDepartureDate']='274';//274 Requested Departure Date

		
		//P5
		$X12info['Portofunlading']='D';//Port or Terminal Function Code
		$X12info['CensusSchedule']='D';//Location Qualifier
		
		//REF
		$X12info['ReferenceIdQualifier']='BN';//BN F8 //Reference Identification Qualifier
		$X12info['ReferenceIdentifier']='X20170814318229';//Reference Identification
		
		//M12
		$X12info['CBPEntryType']='70';//Merchandise NOT shipped inbond
		$X12info['CBPEntryNumber']='N';//Customs and Border Protection (CBP) Entry Number
		$X12info['ROUTEDEXPORTRANSACTION']='N';//ROUTED EXPORT TRANSACTION
		
		//VID
		
		$X12info['EquipmentDescriptionCode']='CN';//Equipment Description Code
    	$X12info['EquipmentNumber']='SKU123456'; //Equipment Number
    	$X12info['SealNumber']='SL32567'; //Seal Number
    	
    	
    	/******************Line Item***********************/

    	// L13
    	$X12info['HTSCode']='B'; //U.S. Census Bureau, Schedule B number
    	$X12info['HTSNumber']='8473.30.0002'; //HTS Number
    	$X12info['Unit']='K'; //Unit or Basis for Measurement Code
    	$X12info['Quantity']='3'; //Unit or Basis for Measurement Code
    	$X12info['ShippingAmount']='1000'; //Shipment Value in U.S. Dollars
    	$X12info['ShippingMonetaryAmount']='1000'; //Monetary Amount
    	$X12info['LINENUMBER']='SKU123456'; //LINE NUMBER
    	$X12info['WeightUnitCode']='K'; //Kilograms
    	$X12info['Weight']='10'; //SHIPPING WEIGHT
    	$X12info['COMMODITYDESCRIPTION']='HP 2GB P-SERIES SMART ARRAY FLASH BACKED WRIT';//EXPORT INFORMATION CODE
    	$X12info['EXPORTINFORMATIONCODE']='OS';//EXPORT INFORMATION CODE
    	
    	//MAN
    	$X12info['PGA']='ZZ'; //Marks and Numbers Qualifier
    	$X12info['PGAID']='EP1'; //TTB.always enter the 3 character PGA ID
    	
    	//X1
    	$X12info['ExportLicenseNumber']='NLR'; //Export License Number
    	$X12info['LICENSECODE']='C33'; //Export License code
    	$X12info['ORIGININDICATOR']='D'; //International/Domestic Code
    	
    	//VEH
    	$X12info['VIN']='ZZ'; //Marks and Numbers Qualifier
    	$X12info['VEHICLEIDQUALIFIER']='VEH02'; //TTB.always enter the 3 character PGA ID
    	$X12info['VEHICLETITLENUMBER']='VEH05'; //Reference Identification
		/************************************************/

	
    $MainDir = "upload/AES/".$_SESSION['CmpID']."/";
			
	if (!is_dir($MainDir)) {
		mkdir($MainDir);
		chmod($MainDir,0777);
	}	
		
	//$content = create_ISA($X12info);
	
	$content = print_elig($X12info,$arrySaleItem);
	
		//$content = "hello this is a testing";
	$file_name = 'AES601_'.$OrderID.'.docx';
    $fp = fopen($MainDir.$file_name, 'wb'); 
    fwrite($fp, $content);
 
    fclose($fp);
    
	$file_path = $MainDir.$file_name;
    
    if (file_exists($file_path)){
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file_path));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    ob_clean();
    flush();
    readfile($file_path);
    exit;
    
    }
  
require_once("../includes/footer.php"); 	 

?>
