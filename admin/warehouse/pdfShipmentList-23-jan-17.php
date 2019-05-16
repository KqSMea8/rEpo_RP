<?php

$module = 'Shipment';

$ModuleIDTitle = "Shipment Number";
$ModuleID = "ShippedID";
$PrefixSO = "SHIP";
$NotExist = NOT_EXIST_Return;
$ModuleName = $module;

//echo $_GET['SHIP'];

if (!empty($_GET['SHIP'])) {
    $arrySale = $objShipment->GetShipment($_GET['SHIP'], '', 'Shipment');


    #$arrySale = $objSale->GetSale($_GET['SHIP'],'',$module);
    $OrderID = $arrySale[0]['OrderID'];
    $arryShip = $objShipment->GetWarehouseShip('', $_GET['SHIP']);


    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);

        //get payment history
        //$arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
    } else {
        $ErrorMSG = $NotExist;
    }
} else {
    $ErrorMSG = NOT_EXIST_DATA;
}

if (!empty($ErrorMSG)) {
    echo $ErrorMSG;
    exit;
}
//echo '<pre>'; print_r($arryShip);
//echo '<pre>'; print_r($arrySaleItem);
/* * **************************************** */
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */
$ModulePDFID = $arrySale[0][$ModuleID];
$Title = $ModuleName . " Number# " . $ModulePDFID;


/* * ******* Order Detail ************* */
/* * ********************************** */
if (empty($ModuleID)) {
    $ModuleIDTitle = "Shipment Number";
    $ModuleID = "ReturnID";
}


$OrderDate = ($arrySale[0]['OrderDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arrySale[0]['OrderDate']))) : (NOT_MENTIONED);

$ShippedDate = ($arryShip[0]['ShipmentDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryShip[0]['ShipmentDate']))) : (NOT_MENTIONED);

if (empty($arrySale[0]['InvoiceID'])) {
    $InvoiceID = $arryShip[0]['RefID'];
}
$InvoiceID = (!empty($InvoiceID)) ? ($InvoiceID) : (NOT_MENTIONED);
$shipmentComment = (!empty($arryShip[0]['ShipComment'])) ? (stripslashes($arryShip[0]['ShipComment'])) : (NOT_MENTIONED);
$SONumber = (!empty($arrySale[0]['SaleID'])) ? (stripslashes($arrySale[0]['SaleID'])) : (NOT_MENTIONED);
$CustomerName = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);
$WarehouseCode = (!empty($arryShip[0]['WarehouseCode'])) ? (stripslashes($arryShip[0]['WarehouseCode'])) : (NOT_MENTIONED);
$WarehouseName = (!empty($arryShip[0]['WarehouseName'])) ? (stripslashes($arryShip[0]['WarehouseName'])) : (NOT_MENTIONED);
$ShipmentStatus = (!empty($arryShip[0]['ShipmentStatus'])) ? (stripslashes($arryShip[0]['ShipmentStatus'])) : (NOT_MENTIONED);

/* * *Information data for Purchase** */
$Infodata = array('Shipment Date' => $ShippedDate, 'SO Number#' => $SONumber, 'Customer' => $CustomerName, 'Sales Person' => $SalesPerson, 'Ship From#' => $WarehouseCode,'Invoice Number' => $InvoiceID);
/* * *Information data for Purchase** */
/* * *Specail Notes** */
$specialNotesArry = array('Ship From (Warehouse)' => $WarehouseName, 'Status' => $ShipmentStatus, 'Shipment  Comment' => $shipmentComment);
/* * *Special Notes** */

/* * ***Billing Address**** */
$Address = (!empty($arrySale[0]['Address1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address1']))) : (NOT_MENTIONED);
$Address22 = (!empty($arrySale[0]['Address2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address2']))) : (NOT_MENTIONED);
$billAddress=$Address.$Address22;
$addlength1 = strlen($billAddress);
$billAddress = wordwrap($billAddress, 45, "<br />", true);
$CustomerCompany = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : (NOT_MENTIONED);
$City = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : (NOT_MENTIONED);
$State = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : (NOT_MENTIONED);
$Country = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : (NOT_MENTIONED);
$ZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : (NOT_MENTIONED);
$Contact = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact'])) : (NOT_MENTIONED);
$Mobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : (NOT_MENTIONED);
$Landline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : (NOT_MENTIONED);
$Email = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : (NOT_MENTIONED);
$CustomerCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : (NOT_MENTIONED);
/* * ***Billing Address**** */


/* * ***Shipping Address**** */
$ShippingAddress = (!empty($arrySale[0]['ShippingAddress1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress1']))) : (NOT_MENTIONED);
$ShippingAddress2 = (!empty($arrySale[0]['ShippingAddress2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress2']))) : (NOT_MENTIONED);
$shippaddss=$ShippingAddress.$ShippingAddress2;
$addlength2 = strlen($shippaddss);
$shippaddss = wordwrap($shippaddss, 45, "<br />", true);
$ShippCustomerCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : (NOT_MENTIONED);
$ShippCity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : (NOT_MENTIONED);
$ShippState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : (NOT_MENTIONED);
$ShippingCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : (NOT_MENTIONED);
$ShippingZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : (NOT_MENTIONED);
//$Contact = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact'])) : (NOT_MENTIONED);
$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : (NOT_MENTIONED);
$ShippingLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : (NOT_MENTIONED);
$ShippingEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : (NOT_MENTIONED);
/* * ***Shipping Address**** */





$AddressHead1 = "Billing Address";
$AddressHead2 = "Shipping Address";
if ($addlength2 > 45 && $addlength1 < 45) {
    $Address1 = array('Company Name' => $CustomerCompany, 'Address' => $billAddress, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Mobile' => $Mobile, 'Landline' => $Landline, 'Email' => $Email,''=>'');
}
else{
    $Address1 = array('Company Name' => $CustomerCompany, 'Address' => $billAddress, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Mobile' => $Mobile, 'Landline' => $Landline, 'Email' => $Email);
}
if ($addlength2 < 45 && $addlength1 > 45) {
    $Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $shippaddss, 'City' => $ShippCity, 'State' => $ShippState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail,''=>'');
}else{
    $Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $shippaddss, 'City' => $ShippCity, 'State' => $ShippState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail);
}
$Taxable = ($arrySale[0]['tax_auths']=="Yes")?("Yes"):("No");
	$arrRate = explode(":",$arrySale[0]['TaxRate']);
	if(!empty($arrRate[0])){
		$TaxVal = $arrRate[2].' %';
		$TaxName = '['.$arrRate[1].']';
	}else{
		$TaxVal = 'None';
	}
/* * **************************************** */
/* * **************************************** */
?>
