<?php

//die('rt');
//echo $Prefix;
require_once($Prefix . "classes/sales.quote.order.class.php");


$objSale = new sale();

$module = 'Invoice';

$ModuleIDTitle = "Invoice Number";
$ModuleID = "InvoiceID";
$PrefixSO = "IN";
$NotExist = NOT_EXIST_INVOICE;
$ModuleName = $module;

if (!empty($_GET['o'])) {
	unset($arrySlNo);
    unset($arrySale);
    unset($arrySaleItem);
    $arrySale = $objSale->GetSale($_GET['o'], '', $module);
    //echo '<pre>'; print_r($arrySale);die('innnnp');
    $OrderID = $arrySale[0]['OrderID'];

    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);

        $NumLine = sizeof($arrySaleItem);

        //get payment history
        $arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
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

/* * **************************************** */
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */

if($_GET['t']==1){
    echo '<pre>'; print_r($arrySale);die;
}
#FooterTextBox($pdf);
//TitlePage($arry, $pdf);
//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);
$ModulePDFID = $arrySale[0][$ModuleID];
$Title = $ModuleName . " Number# " . $ModulePDFID;
//echo $Title.'<pre>'; print_r($arrySale);die('oooiop');

/* * *Start Data for Order InFormation** */
$OrderDate = ($arrySale[0]['OrderDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arrySale[0]['Approved'] == 1) ? ('Yes') : ('No');

$InvoiceDate = ($arrySale[0]['InvoiceDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))) : (NOT_MENTIONED);
$ShippedDate = ($arrySale[0]['ShippedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['ShippedDate']))) : (NOT_MENTIONED);
$InvoicePaidDate = ($arrySale[0]['InvoicePaidDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['InvoicePaidDate']))) : (NOT_MENTIONED);
$PaidComment = (!empty($arrySale[0]['InvoicePaidComment'])) ? (stripslashes($arrySale[0]['InvoicePaidComment'])) : (NOT_MENTIONED);
$ShipFrom = (!empty($arrySale[0]['wName'])) ? (stripslashes($arrySale[0]['wName'])) : (NOT_MENTIONED);
$SONumber = (!empty($arrySale[0]['SaleID'])) ? (stripslashes($arrySale[0]['SaleID'])) : (NOT_MENTIONED);

$Customer = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);
$PaymentTerm = (!empty($arrySale[0]['PaymentTerm'])) ? (stripslashes($arrySale[0]['PaymentTerm'])) : (NOT_MENTIONED);
$PaymentMethod = (!empty($arrySale[0]['PaymentMethod'])) ? (stripslashes($arrySale[0]['PaymentMethod'])) : (NOT_MENTIONED);
$ShippingCarrier = (!empty($arrySale[0]['ShippingMethod'])) ? (stripslashes($arrySale[0]['ShippingMethod'])) : (NOT_MENTIONED);
$InvoiceComment = (!empty($arrySale[0]['InvoiceComment'])) ? (stripslashes($arrySale[0]['InvoiceComment'])) : (NOT_MENTIONED);
$InvoiceStatus = (!empty($arrySale[0]['InvoicePaid'])) ? (stripslashes($arrySale[0]['InvoicePaid'])) : (NOT_MENTIONED);
$InvoiceOrderSource = (!empty($arrySale[0]['OrderSource'])) ? (stripslashes($arrySale[0]['OrderSource'])) : (NOT_MENTIONED);
$InvoiceFee = (!empty($arrySale[0]['Fee'])) ? (stripslashes($arrySale[0]['Fee'])) : (NOT_MENTIONED);
$TrackingNo = (!empty($arrySale[0]['TrackingNo'])) ? (stripslashes($arrySale[0]['TrackingNo'])) : (NOT_MENTIONED);

if (!empty($arrySale[0]['ShippingMethodVal'])) {
        $arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'], $arrySale[0]['ShippingMethodVal']);
    }

    $ShippingMethod=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):(NOT_SPECIFIED);

$Infodata = array('Invoice Date' => $InvoiceDate, 'Ship Date' => $ShippedDate, 'Ship From' => $ShipFrom, 'SO Number' => $SONumber, 'Customer' => $Customer, 'Sales Person' => $SalesPerson , 'Fees' => $InvoiceFee);
/* * *Start Data for Order InFormation** */

/* * ******* Billing******* */
$Address = (!empty($arrySale[0]['Address1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address1']))) : (NOT_MENTIONED);
$Address2 = (!empty($arrySale[0]['$Address2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address2']))) : (NOT_MENTIONED);
$CompanyName = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : (NOT_MENTIONED);
$City = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : (NOT_MENTIONED);
$State = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : (NOT_MENTIONED);
$Country = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : (NOT_MENTIONED);
$ZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : (NOT_MENTIONED);
$ContactName = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact'])) : (NOT_MENTIONED);
$Mobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : (NOT_MENTIONED);
$Landline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : (NOT_MENTIONED);
$Email = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : (NOT_MENTIONED);
$CustomerCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : (NOT_MENTIONED);
$AddressHead1 = "Billing Address";
//$Address1 = array('Company Name' => $CompanyName, 'Address' => $Address . $Address2, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
/* * ******* Billing******* */
if($arryCurrentLocation[0]['country_id']==106){
			if(!empty($arrySale[0]['VAT']) || ($arrySale[0]['CST']) || ($arrySale[0]['PAN'])){
				$VAT= $arrySale[0]['VAT'];
				$CST= $arrySale[0]['CST'];
				$PAN= $arrySale[0]['PAN'];
			}else{
				$VAT = NOT_MENTIONED;
				$CST = NOT_MENTIONED;
				$PAN = NOT_MENTIONED;
			}
}


if($arryCurrentLocation[0]['country_id']==106){
$Address1 = array('Company Name' => $CompanyName, 'Address' => $Address . $Address2, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline, 'VAT TIN' => $VAT, 'CST No' => $CST, 'PAN No' => $PAN);
}else{
$Address1 = array('Company Name' => $CompanyName, 'Address' => $Address . $Address2, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);	
}
/* * *******Shipping******* */
$ShippingAddress = (!empty($arrySale[0]['ShippingAddress1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress1']))) : (NOT_MENTIONED);
$ShippingAddress2 = (!empty($arrySale[0]['ShippingAddress2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress2']))) : (NOT_MENTIONED);
$ShippingCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : (NOT_MENTIONED);
$ShippingCity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : (NOT_MENTIONED);
$ShippingState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : (NOT_MENTIONED);
$ShippingCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : (NOT_MENTIONED);
$ShippingZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : (NOT_MENTIONED);
$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : (NOT_MENTIONED);
$ShippingLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : (NOT_MENTIONED);
$ShippingEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : (NOT_MENTIONED);

$Taxable = ($arrySale[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arrySale[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
}

$AddressHead2 = "Shipping Address";
//$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Email' => $ShippingEmail, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline);
//echo $Taxable.'oooo'.$TaxVal;die('iop')
/* * *******Shipping******* */
if($arryCurrentLocation[0]['country_id']==106){
$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Email' => $ShippingEmail, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, '&nbsp;' => '', '&nbsp;&nbsp;' => '', '&nbsp;&nbsp;&nbsp;' => '');
}else{
$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Email' => $ShippingEmail, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline);
	
}


/* * *Specail Notes** */
//$specialNotesArry = array('Tracking No.'=> $TrackingNo,'Payment Term' => $PaymentTerm, 'Shipping Carrier' => $ShippingCarrier,'Shipping Method'=>$ShippingMethod, 'Invoice Comment' => $InvoiceComment, 'Invoice Status' => $InvoiceStatus, 'Tax Rate' => $TaxVal);
$specialNotesArry = array('Tracking No.'=> $TrackingNo,'Payment Term' => $PaymentTerm, 'Shipping Carrier' => $ShippingCarrier,'Shipping Method'=>$ShippingMethod);
//$_GET['o']=$_GET['IN']
/* * *Special NOtes** */
?>
