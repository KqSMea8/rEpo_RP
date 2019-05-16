<?php

//require_once("../includes/pdf_comman.php");
require_once($Prefix . "classes/rma.purchase.class.php");
require_once($Prefix . "classes/warehouse.purchase.rma.class.php");

$objWarehouse = new warehouse();
$objPurchase = new purchase();
$module = 'Receipt';

$ModuleIDTitle = "Receipt Number";
$ModuleID = "ReceiptNo";
$PrefixSO = "RCPT";
$NotExist = "Not Exist";
$ModuleName = $module;
$_GET['RCPT']=$_GET['o'];
if (!empty($_GET['RCPT'])) {

    $arryPurchase = $objWarehouse->GetPurchaseReceipt($_GET['RCPT'], '', '');
    
    $ReturnID = $arryPurchase[0]['ReturnID'];
    $InvoiceID = $arryPurchase[0]["InvoiceID"];
    $ModulePDFID = $arryPurchase[0]["ReceiptNo"];
     

    if ($ReturnID != '') {
        $arryRMA = $objWarehouse->GetPORma('', $ReturnID, 'RMA');
        
    }
    $OrderID = $arryPurchase[0]['ReceiptID'];
    if ($OrderID > 0) {
        
        $arryPurchaseItem = $objWarehouse->GetPurchaseReceiptItem($OrderID, '');
        $NumLine = sizeof($arryPurchaseItem);

        //$ValReciept = $objWarehouse->GetPurchaseSumQtyReceipt($arryPurchaseItem[0]["OrderID"],$arryPurchaseItem[0]["item_id"]);
        //get payment history
        //$arryPaymentInvoice = $objPurchase->GetPaymentInvoice($OrderID);
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
if (!empty($arryPurchase[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arryPurchase[0]['CreatedByEmail'];
}
//$Title = " Receipt Number# " . $arryPurchase[0][$ModuleID];
$Title="Vendor RMA";

if (empty($ModuleID)) {
    $ModuleIDTitle = "Invoice Number";
    $ModuleID = "InvoiceID";
}

$arryInvoice = $objPurchase->GetPurchaseInvoice('', $arryPurchase[0]["InvoiceID"], 'Invoice');

$PostedDate = ($arryInvoice[0]['PostedDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryInvoice[0]['PostedDate']))) : (NOT_MENTIONED);


$InvoiceComment = (!empty($arryInvoice[0]['InvoiceComment'])) ? (stripslashes($arryInvoice[0]['InvoiceComment'])) : (NOT_MENTIONED);
$Invoice = (!empty($arryInvoice[0]["InvoiceID"])) ? (stripslashes($arryInvoice[0]["InvoiceID"])) : (NOT_MENTIONED);


$ReturnDate = ($arryPurchase[0]['PostedDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))) : (NOT_MENTIONED);
$ReceivedDate = ($arryPurchase[0]['ReceiptDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ReceiptDate']))) : (NOT_MENTIONED);
$InvoicePaid = (!empty($arryPurchase[0]['InvoicePaid'])) ? ('Yes') : ('No');
$InvoiceComment = (!empty($arryPurchase[0]['ReceiptComment'])) ? (stripslashes($arryPurchase[0]['ReceiptComment'])) : (NOT_MENTIONED);
$ReceiptStatus = (!empty($arryPurchase[0]['ReceiptStatus']))?(stripslashes($arryPurchase[0]['ReceiptStatus'])):(NOT_MENTIONED);
$ReStocking = (!empty($arryRMA[0]['Restocking'])) ? ('Yes') : ('No');
$RmaNumber = (!empty($arryPurchase[0]["ReturnID"]))?(stripslashes($arryPurchase[0]["ReturnID"])):(NOT_MENTIONED);

/* * *Information data for Purchase***/
//$Infodata = array('RMA No#'=>$RmaNumber,'RMA Date'=>$ReturnDate,'Item RMA Date'=>$ReceivedDate,'Comments'=>$InvoiceComment,'Receipt Status'=>$ReceiptStatus,'Re-Stocking'=>$ReStocking);
$Infodata = array('RMA No'=>$RmaNumber,'Invoice' => $Invoice);
//
/* * *Information data for Purchase** */


/* * ***Billing Address**** */
$Address = (!empty($arryPurchase[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['Address']))) : ('');
$billAddress = $Address;
$addlength1 = strlen($billAddress);
$billAddress = wordwrap($billAddress, 45, "<br />", true);
$CustomerCompany = (!empty($arryPurchase[0]['SuppCompany'])) ? (stripslashes($arryPurchase[0]['SuppCompany'])) : ('');
$City = (!empty($arryPurchase[0]['City'])) ? (stripslashes($arryPurchase[0]['City'])) : ('');
$State = (!empty($arryPurchase[0]['State'])) ? (stripslashes($arryPurchase[0]['State'])) : ('');
$Country = (!empty($arryPurchase[0]['Country'])) ? (stripslashes($arryPurchase[0]['Country'])) : ('');
$ZipCode = (!empty($arryPurchase[0]['ZipCode'])) ? (stripslashes($arryPurchase[0]['ZipCode'])) : ('');
$Contact = (!empty($arryPurchase[0]['SuppContact'])) ? (stripslashes($arryPurchase[0]['SuppContact'])) : ('');
$Mobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : ('');
$Landline = (!empty($arryPurchase[0]['Landline'])) ? (stripslashes($arryPurchase[0]['Landline'])) : ('');
$Email = (!empty($arryPurchase[0]['Email'])) ? (stripslashes($arryPurchase[0]['Email'])) : ('');
$CustomerCurrency = (!empty($arryPurchase[0]['SuppCurrency'])) ? (stripslashes($arryPurchase[0]['SuppCurrency'])) : ('');
/* * ***Billing Address**** */


/* * ***Shipping Address**** */
$ShippingAddress = (!empty($arryPurchase[0]['wAddress'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['wAddress']))) : ('');
$shippaddss = $ShippingAddress;
$addlength2 = strlen($shippaddss);
$shippaddss = wordwrap($shippaddss, 45, "<br />", true);
$ShippCustomerCompany = (!empty($arryPurchase[0]['wName'])) ? (stripslashes($arryPurchase[0]['wName'])) : ('');
$ShippCity = (!empty($arryPurchase[0]['wCity'])) ? (stripslashes($arryPurchase[0]['wCity'])) : ('');
$ShippState = (!empty($arryPurchase[0]['wState'])) ? (stripslashes($arryPurchase[0]['wState'])) : ('');
$ShippingCountry = (!empty($arryPurchase[0]['wCountry'])) ? (stripslashes($arryPurchase[0]['wCountry'])) : ('');
$ShippingZipCode = (!empty($arryPurchase[0]['wZipCode'])) ? (stripslashes($arryPurchase[0]['wZipCode'])) : ('');
$ShippingContact = (!empty($arryPurchase[0]['wContact'])) ? (stripslashes($arryPurchase[0]['wContact'])) : ('');
$ShippingMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : ('');
$ShippingLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : ('');
$ShippingEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : ('');
/* * ***Shipping Address**** */


$AddressHead1 = "Vendor Address";
$AddressHead2 = "Ship-To Address";

$CustomerCompany=(!empty($CustomerCompany)) ? ($CustomerCompany.',<br>') : ('');
$billAddress=(!empty($billAddress)) ? ($billAddress.',<br>') : ('&nbsp;<br>');
$Country=(!empty($Country)) ? ($Country.',<br>') : ('&nbsp;<br>');
$Mobile=(!empty($Mobile)) ? ($Mobile.',<br>'.$Landline) : ($Landline.'<br>&nbsp;');
$City=(!empty($City)) ? ($City.',') : ('');
$State=(!empty($State)) ? ($State.'-') : ('');

if ($addlength2 > 45 && $addlength1 < 45) {
   /* $Address1 = array('Company Name' => $CustomerCompany, 'Address' => $billAddress, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Contact Name' => $Contact, 'Zip Code' => $ZipCode, 'Mobile' => $Mobile, 'Landline' => $Landline, 'Email' => $Email, '' => '');*/

    $Address1 = array('' => $CustomerCompany.$billAddress.'&nbsp;<br>'.$City.$State.$ZipCode.'<br>'.$Country.$Mobile);
} else {
    $Address1 = array('' => $CustomerCompany.$billAddress.$City.$State.$ZipCode.'<br>'.$Country.$Mobile);
    //$Address1 = array('Company Name' => $CustomerCompany, 'Address' => $billAddress, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Contact Name' => $Contact, 'Zip Code' => $ZipCode, 'Mobile' => $Mobile, 'Landline' => $Landline, 'Email' => $Email);
}


$ShippCustomerCompany=(!empty($ShippCustomerCompany)) ? ($ShippCustomerCompany.',<br>') : ('');
$shippaddss=(!empty($shippaddss)) ? ($shippaddss.',<br>') : ('&nbsp;<br>');
$ShippingCountry=(!empty($ShippingCountry)) ? ($ShippingCountry.',<br>') : ('&nbsp;<br>');
$ShippingMobile=(!empty($ShippingMobile)) ? ($ShippingMobile.',<br>'.$ShippingLandline) : ($ShippingLandline.'<br>&nbsp;');
$ShippCity=(!empty($ShippCity)) ? ($ShippCity.',') : ('');
$ShippState=(!empty($ShippState)) ? ($ShippState.'-') : ('');

if ($addlength2 < 45 && $addlength1 > 45) {
    $Address2 = array('' => $ShippCustomerCompany.$shippaddss.'&nbsp;<br>'.$ShippCity.$ShippState.$ShippingZipCode.'<br>'.$ShippingCountry.$ShippingMobile);
    //$Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $shippaddss, 'City' => $ShippCity, 'State' => $ShippState, 'Country' => $ShippingCountry, 'Contact Name' => $ShippingContact, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail, '' => '');
} else {
    $Address2 = array('' => $ShippCustomerCompany.$shippaddss.$ShippCity.$ShippState.$ShippingZipCode.'<br>'.$ShippingCountry.$ShippingMobile);
    //$Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $shippaddss, 'City' => $ShippCity, 'State' => $ShippState, 'Country' => $ShippingCountry, 'Contact Name' => $ShippingContact, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail);
}


$Taxable = ($arryPurchase[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arryPurchase[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
	$TaxName='';
}

/* * *Specail Notes** */
//$specialNotesArry = array('Invoice#' => $Invoice, 'Invoice Date' => $PostedDate, 'Comments' => $InvoiceComment, 'Tax Rate' => $TaxName.' '.$TaxVal);
$specialNotesArry = array('Invoice Date' => $PostedDate, 'Comments' => $InvoiceComment, 'Tax Rate' => $TaxName.' '.$TaxVal);
/* * *Special Notes** */
?>
