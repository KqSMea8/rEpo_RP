<?php

require_once($Prefix . "classes/purchase.class.php");


$objPurchase = new purchase();
(!$_GET['module']) ? ($_GET['module'] = 'Quote') : ("");
$module = $_GET['module'];


if ($module == 'Quote') {
    $ModuleIDTitle = "Quote Number";
    $ModuleID = "QuoteID";
    $PrefixPO = "QT";
    $NotExist = NOT_EXIST_QUOTE;
} else {
    $ModuleIDTitle = "P.O.NUMBER";
    $ModuleID = "PurchaseID";
    $PrefixPO = "PO";
    $NotExist = NOT_EXIST_ORDER;
}
$ModuleName = "Purchase " . $module;
$recordpdftemp = array();
if (!empty($_GET['o'])) {

    $arryPurchase = $objPurchase->GetPurchase($_GET['o'], '', $module);
    $OrderID = $arryPurchase[0]['OrderID'];
    if ($OrderID > 0) {
        $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $NumLine = sizeof($arryPurchaseItem);
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
//echo '<pre>'; print_r($arryCompany);die;
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */


//$Title = $ModuleName . " # " . $arryPurchase[0][$ModuleID];
$Title ='';

/* * *Start Data for Order InFormation** */
$OrderDate = ($arryPurchase[0]['OrderDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arryPurchase[0]['Approved'] == 1) ? ('Yes') : ('No');

$DeliveryDate = ($arryPurchase[0]['DeliveryDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))) : (NOT_MENTIONED);

$PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm'])) ? (stripslashes($arryPurchase[0]['PaymentTerm'])) : (NOT_MENTIONED);
$PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod'])) ? (stripslashes($arryPurchase[0]['PaymentMethod'])) : (NOT_MENTIONED);
$ShippingMethod = (!empty($arryPurchase[0]['ShippingMethod'])) ? (stripslashes($arryPurchase[0]['ShippingMethod'])) : (NOT_MENTIONED);
$ShippingMethodVal = (!empty($arryPurchase[0]['ShippingMethodVal'])) ? (stripslashes($arryPurchase[0]['ShippingMethodVal'])) : (NOT_MENTIONED);
$PrepaidFreight = ($arryPurchase[0]['PrepaidFreight'] == 1) ? ("Yes") : ("No");
$Comment = (!empty($arryPurchase[0]['Comment'])) ? (stripslashes($arryPurchase[0]['Comment'])) : (NOT_MENTIONED);
$AssignedEmp = (!empty($arryPurchase[0]['AssignedEmp'])) ? (stripslashes($arryPurchase[0]['AssignedEmp'])) : (NOT_MENTIONED);
$ModuleID = (!empty($arryPurchase[0][$ModuleID])) ? (stripslashes($arryPurchase[0][$ModuleID])) : (NOT_MENTIONED);
$Status = (!empty($arryPurchase[0]['Status'])) ? (stripslashes($arryPurchase[0]['Status'])) : (NOT_MENTIONED);
$OrderType = (!empty($arryPurchase[0]['OrderType'])) ? (stripslashes($arryPurchase[0]['OrderType'])) : (NOT_MENTIONED);
$SalesOrder = (!empty($arryPurchase[0]['SaleID'])) ? (stripslashes($arryPurchase[0]['SaleID'])) : (NOT_MENTIONED);
$ModulePDFID = $ModuleID;
if($OrderType =='Dropship'){
$Infodata = array('ORDER DATE' => $OrderDate, $ModuleIDTitle => $ModuleID,'S.O.NUMBER' => $SalesOrder);
}else{
$Infodata = array('ORDER DATE' => $OrderDate, $ModuleIDTitle => $ModuleID);

}
//$SalesOrder = 'Sales Order';
/* * *Information data for Purchase** */
//$Infodata = array('Order Date' => $OrderDate, $ModuleIDTitle => $ModuleID, 'Order Status' => $Status, 'Approved' => $Approved, 'Order Type' => $OrderType, 'Sales Order' => $SalesOrder);
$PaydataArry = array('Required Date' => $DeliveryDate, 'Ship VIA' => $ShippingMethod, 'TERMS' => $PaymentTerm);
/* * *Information data for Purchase** */
/* * *End Data for Order InFormation** */


/* * *Vendor Address*** */
$AddressHead1 = "VENDOR";
$Address = (!empty($arryPurchase[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['Address']))) : ('');
$addlength1 = strlen($Address);
$Address = wordwrap($Address, 45, "<br />", true);
$VendorCustomerCompany = (!empty($arryPurchase[0]['SuppCompany'])) ? (stripslashes($arryPurchase[0]['SuppCompany'])) : ('');
$Vendorcity = (!empty($arryPurchase[0]['City'])) ? (stripslashes($arryPurchase[0]['City'])) : ('');
$VendorState = (!empty($arryPurchase[0]['State'])) ? (stripslashes($arryPurchase[0]['State'])) : ('');
$VendorCountry = (!empty($arryPurchase[0]['Country'])) ? (stripslashes($arryPurchase[0]['Country'])) : ('');
$VendorZipCode = (!empty($arryPurchase[0]['ZipCode'])) ? (stripslashes($arryPurchase[0]['ZipCode'])) : ('');
$VendorContact = (!empty($arryPurchase[0]['SuppContact'])) ? (stripslashes($arryPurchase[0]['SuppContact'])) : ('');
$VendorMobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : ('&nbsp;');
$VendorLandline = (!empty($arryPurchase[0]['Landline'])) ? (stripslashes($arryPurchase[0]['Landline'])) : ('&nbsp;');
$VendorEmail = (!empty($arryPurchase[0]['Email'])) ? (stripslashes($arryPurchase[0]['Email'])) : ('');
$VendorCurrency = (!empty($arryPurchase[0]['SuppCurrency'])) ? (stripslashes($arryPurchase[0]['SuppCurrency'])) : ('');
//$Address1 = array('Company Name' => $VendorCustomerCompany, 'Address' => $Address, 'City' => $Vendorcity, 'State' => $VendorState, 'Country' => $VendorCountry, 'Zip Code' => $VendorZipCode, 'Contact Name' => $VendorContact, 'Mobile' => $VendorMobile, 'Landline' => $VendorLandline, 'Email' => $VendorEmail,'test1'=>'test1reer');
/* * *Vendor Address*** */


/* * *Ship-To Address*** */
$AddressHead2 = "SHIP TO";
$wAddress = (!empty($arryPurchase[0]['wAddress'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['wAddress']))) : ('');
$addlength2 = strlen($wAddress);
$wAddress = wordwrap($wAddress, 45, "<br />", true);
//$wAddress="$wAddress<br />";
$wCustomerCompany = (!empty($arryPurchase[0]['wName'])) ? (stripslashes($arryPurchase[0]['wName'])) : ('');
$wcity = (!empty($arryPurchase[0]['wCity'])) ? (stripslashes($arryPurchase[0]['wCity'])) : ('');
$wState = (!empty($arryPurchase[0]['wState'])) ? (stripslashes($arryPurchase[0]['wState'])) : ('');
$wCountry = (!empty($arryPurchase[0]['wCountry'])) ? (stripslashes($arryPurchase[0]['wCountry'])) : ('');
$wZipCode = (!empty($arryPurchase[0]['wZipCode'])) ? (stripslashes($arryPurchase[0]['wZipCode'])) : ('');
$wContact = (!empty($arryPurchase[0]['wContact'])) ? (stripslashes($arryPurchase[0]['wContact'])) : ('');
$wMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : ('&nbsp;');
$wLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : ('&nbsp;');
$wEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : ('');
if ($addlength2 > 45 && $addlength1 < 45) {
   // $Address1 = array('Company Name' => $VendorCustomerCompany, 'Address' => $Address, 'City' => $Vendorcity, 'State' => $VendorState, 'Country' => $VendorCountry, 'Zip Code' => $VendorZipCode, 'Contact Name' => $VendorContact, 'Mobile' => $VendorMobile, 'Landline' => $VendorLandline, 'Email' => $VendorEmail, '' => '');
$Address1 = array('' => $VendorCustomerCompany.',<br>'.$Address.'<br>'.$Vendorcity.','.$VendorState.'-'.$VendorZipCode.'<br>'.$VendorCountry.'<br>'.$VendorLandline);
 //$Address1 = array('Address' => $Address, 'City' => $Vendorcity, 'State' => $VendorState, 'Country' => $VendorCountry, 'Zip Code' => $VendorZipCode, 'Contact Name' => $VendorContact, 'Mobile' => $VendorMobile, 'Landline' => $VendorLandline, 'Email' => $VendorEmail, '' => '');

} 
else {
    $Address1 = array('' => $VendorCustomerCompany.',<br>'.$Address.'<br>'.$Vendorcity.','.$VendorState.'-'.$VendorZipCode.'<br>'.$VendorCountry.'<br>'.$VendorLandline);
}
if ($addlength2 < 45 && $addlength1 > 45) {
    //$Address2 = array('Company Name' => $wCustomerCompany, 'Address' => $wAddress, 'City' => $wcity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Contact Name' => $wContact, 'Mobile' => $wMobile, 'Landline' => $wLandline, 'Email' => $wEmail,'' => '');
$Address2 = array('' => $wCustomerCompany.'<br>'.$wAddress.'<br>'.$wcity.','.$wState.'-'.$wZipCode.'<br>'.$wCountry.'<br>'.$wMobile.'<br>'.$wLandline);
}
//$Address2 = array('Company Name' => $wCustomerCompany, 'Address' => $wAddress, 'City' => $wcity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Contact Name' => $wContact, 'Mobile' => $wMobile, 'Landline' => $wLandline, 'Email' => $wEmail);

$Address2 = array('' => $wCustomerCompany.'<br>'.$wAddress.'<br>'.$wcity.','.$wState.'-'.$wZipCode.'<br>'.$wCountry.'<br>'.$wLandline);
/* * *Ship-To Address*** */

/* * *Specail Notes** */
$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Payment Term' => $PaymentTerm,  'Shipping Carrier' => $ShippingMethod, 'Comments' => $Comment, 'Prepaid Freight' => $PrepaidFreight);
/* * *Special NOtes** */



/* * *Tax Rate*** */
$Taxable = ($arryPurchase[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arryPurchase[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
}
$CurrencyInfo = (!empty($arryPurchase[0]['Currency'])) ? (stripslashes($arryPurchase[0]['Currency'])) : (NOT_MENTIONED);
//echo $CurrencyInfo.'other'.$VendorCurrency;die;
/* * **Tax Rate** */
?>

