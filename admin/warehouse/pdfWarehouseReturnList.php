<?php

//require_once("../includes/pdf_comman.php");
require_once($Prefix . "classes/rma.sales.class.php");
require_once($Prefix . "classes/warehouse.rma.class.php");

$warehouserma = new warehouserma();
$objrmasale = new rmasale();
$module = 'Receipt';

$ModuleIDTitle = "Receipt Number";
$ModuleID = "ReceiptNo";
$PrefixSO = "RCPT";
$NotExist = 'Receipt not exist';
$ModuleName = $module;
$_GET['RTN'] = $_GET['o'];
if (!empty($_GET['RTN'])) {
    $arrySale = $warehouserma->GetReceiptRmaListing($_GET['RTN'], '', $module);
 
    $OrderID = $arrySale[0]['ReceiptID'];

    $ModulePDFID = $arrySale[0]["ReceiptNo"];


    if ($OrderID > 0) {
        $arrySaleItem = $warehouserma->GetSaleReceiptItem($OrderID,'');
        $NumLine = sizeof($arrySaleItem);

 
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

/* * **************************************** */
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */

//$Title = " Receipt Number# " . $arrySale[0][$ModuleID];
$Title="Customer RMA";


/* * *****infomation tab****** */
if (empty($ModuleID)) {
    $ModuleIDReceipt = "Receipt Number";
    $ModuleReceiptID = "ReceiptNo";
}


$ReceiptDate = ($arrySale[0]['ReceiptDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arrySale[0]['ReceiptDate']))) : (NOT_MENTIONED);
$ReceiptComment = (!empty($arrySale[0]['ReceiptComment'])) ? (stripslashes($arrySale[0]['ReceiptComment'])) : (NOT_MENTIONED);
$Warehouse = (!empty($arrySale[0]['wCode'])) ? (stripslashes($arrySale[0]['wCode'])) : (NOT_MENTIONED);
$transport = (!empty($arrySale[0]['transport'])) ? (stripslashes($arrySale[0]['transport'])) : (NOT_MENTIONED);
$packageCount = (!empty($arrySale[0]['packageCount'])) ? (stripslashes($arrySale[0]['packageCount'])) : (NOT_MENTIONED);
$ReceiptStatus = (!empty($arrySale[0]['ReceiptStatus'])) ? (stripslashes($arrySale[0]['ReceiptStatus'])) : (NOT_MENTIONED);
$PackageType = (!empty($arrySale[0]['PackageType'])) ? (stripslashes($arrySale[0]['PackageType'])) : (NOT_MENTIONED);
$Weight = (!empty($arrySale[0]['Weight'])) ? (stripslashes($arrySale[0]['Weight'])) : (NOT_MENTIONED);
/* * *****infomation tab***** */


if (empty($ModuleID)) {
    $ModuleIDTitle = "Return Number";
    $ModuleID = "ReturnID";
}


 
 


 

$ReturnComment = (!empty($arrySale[0]['ReturnComment'])) ? (stripslashes($arrySale[0]['ReturnComment'])) : (NOT_MENTIONED);
$ModuleIDTitleVal = (!empty($arrySale[0][$ModuleID])) ? (stripslashes($arrySale[0][$ModuleID])) : (NOT_MENTIONED);
$InvoiceNumber = (!empty($arrySale[0]['InvoiceID'])) ? (stripslashes($arrySale[0]['InvoiceID'])) : (NOT_MENTIONED);
$Customer = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);



/* * ****Billing Address**** */
$AddressHead1 = "BILLING";
$Address = (!empty($arrySale[0]['Address1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address1']))) : ('');
$arrySale[0]['Address2']='';
$AddressBill = str_replace("\n", " ", stripslashes($arrySale[0]['Address2']));
$billAddress = $Address . $AddressBill;
$addlength1 = strlen($billAddress);
$billAddress = wordwrap($billAddress, 45, "<br />", true);
$BillingName = (!empty($arrySale[0]['BillingName'])) ? (stripslashes($arrySale[0]['BillingName'])) : ('');
$CustomerCompany = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : ('');
$City = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : ('');
$State = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : ('');
$Country = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : ('');
$ZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : ('');
$Contact = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact'])) : ('');
$Mobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
$Landline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : ('');
$Email = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : ('');
$CustomerCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');
/* * ****Billing Address**** */



/* * ***Shipping Address**** */
$AddressHead2 = "SHIPPING";
$ShippingAddress = (!empty($arrySale[0]['ShippingAddress1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress1']))) : ('');
$arrySale[0]['ShippingAddress2']='';
$ShippingAddress2 = str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress2']));
$shippaddss = $ShippingAddress . $ShippingAddress2;
$addlength2 = strlen($shippaddss);
$shippaddss = wordwrap($shippaddss, 45, "<br />", true);
$ShippingName = (!empty($arrySale[0]['ShippingName'])) ? (stripslashes($arrySale[0]['ShippingName'])) : ('');
$ShippCustomerCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : ('');
$ShippCity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : ('');
$ShippState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : ('');
$ShippingCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : ('');
$ShippingZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : ('');
//$ShippingContact = (!empty($arryPurchase[0]['wContact'])) ? (stripslashes($arryPurchase[0]['wContact'])) : (NOT_MENTIONED);
$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : ('');
$ShippingLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : ('');
$ShippingEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : ('');
/* * ***Shipping Address**** */


$CustomerCompany=(!empty($CustomerCompany)) ? ($CustomerCompany.',<br>') : ('');
$billAddress=(!empty($billAddress)) ? ($billAddress.',<br>') : ('&nbsp;<br>');
$Country=(!empty($Country)) ? ($Country.',<br>') : ('&nbsp;<br>');
$Mobile=(!empty($Mobile)) ? ($Mobile.',<br>'.$Landline) : ($Landline.'<br>&nbsp;');
$City=(!empty($City)) ? ($City.',') : ('');
$State=(!empty($State)) ? ($State.'-') : ('');


if ($addlength2 > 45 && $addlength1 < 45) {
    //$Address1 = array('Billing Name' => $BillingName, 'Company Name' => $CustomerCompany, 'Address' => $billAddress, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Mobile' => $Mobile, 'Landline' => $Landline, 'Email' => $Email, '' => '');
    $Address1 = array('' => $CustomerCompany.$billAddress.$City.$State.$ZipCode.'<br>'.$Country.$Mobile);
} else {
    //$Address1 = array('Billing Name' => $BillingName, 'Company Name' => $CustomerCompany, 'Address' => $billAddress, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Mobile' => $Mobile, 'Landline' => $Landline, 'Email' => $Email);
    $Address1 = array('' => $CustomerCompany.$billAddress.$City.$State.$ZipCode.'<br>'.$Country.$Mobile);
}

$ShippCustomerCompany=(!empty($ShippCustomerCompany)) ? ($ShippCustomerCompany.',<br>') : ('');
$shippaddss=(!empty($shippaddss)) ? ($shippaddss.',<br>') : ('&nbsp;<br>');
$ShippingCountry=(!empty($ShippingCountry)) ? ($ShippingCountry.',<br>') : ('&nbsp;<br>');
$ShippingMobile=(!empty($ShippingMobile)) ? ($ShippingMobile.',<br>'.$ShippingLandline) : ($ShippingLandline.'<br>&nbsp;');
$ShippCity=(!empty($ShippCity)) ? ($ShippCity.',') : ('');
$ShippState=(!empty($ShippState)) ? ($ShippState.'-') : ('');


if ($addlength2 < 45 && $addlength1 > 45) {
    $Address2 = array('' => $ShippCustomerCompany.$shippaddss.$ShippCity.$ShippState.$ShippingZipCode.'<br>'.$ShippingCountry.$ShippingMobile);
    //$Address2 = array('Shipping Name' => $ShippingName, 'Company Name' => $ShippCustomerCompany, 'Address' => $shippaddss, 'City' => $ShippCity, 'State' => $ShippState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail, '' => '');
} else {
    $Address2 = array('' => $ShippCustomerCompany.$shippaddss.$ShippCity.$ShippState.$ShippingZipCode.'<br>'.$ShippingCountry.$ShippingMobile);
    //$Address2 = array('Shipping Name' => $ShippingName, 'Company Name' => $ShippCustomerCompany, 'Address' => $shippaddss, 'City' => $ShippCity, 'State' => $ShippState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail);
}



$Taxable = ($arrySale[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arrySale[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
    $TaxName ='';
}


/* * *Information data ** */
//$Infodata = array('Receipt Date' => $ReceiptDate, 'Warehouse' => $Warehouse, 'Mode of Transport' => $transport, 'Package Count' => $packageCount, 'Status' => $ReceiptStatus, 'Package Type' => $PackageType, 'Weight' => $Weight, 'Receipt Comment' => $ReceiptComment);
$Infodata = array('Receipt Date' => $ReceiptDate,$ModuleIDTitle=>$ModuleIDTitleVal);
/* * *Information data** */


/* * *Specail Notes** */
//$specialNotesArry = array($ModuleIDTitle => $ModuleIDTitleVal, 'Invoice Number' => $InvoiceNumber, 'Customer' => $Customer, 'Sales Person' => $SalesPerson,'Taxable'=>$Taxable,'Tax Rate' => $TaxName.' '.$TaxVal);
$specialNotesArry = array('Invoice Number' => $InvoiceNumber, 'Customer' => $Customer, 'Sales Person' => $SalesPerson,'Taxable'=>$Taxable,'Tax Rate' => $TaxName.' '.$TaxVal);
/* * *Special Notes** */
?>
