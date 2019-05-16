<?php

require_once($Prefix . "classes/purchase.class.php");
require_once($Prefix . "classes/finance.account.class.php");

define("NOT_EXIST_QUOTE","This purchase quote no longer exist in the database.");
define("NOT_EXIST_ORDER","This purchase order no longer exist in the database.");

$objPurchase = new purchase();
$objBankAccount=new BankAccount();
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

    $arryPurchase = $objPurchase->GetPurchase($_GET['o'], '', '');
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
 
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */


//$Title = $ModuleName . " # " . $arryPurchase[0][$ModuleID];
$Title = $ModuleName;
//$Title ='Purchase Order';

/* * *Start Data for Order InFormation** */
$OrderDate = ($arryPurchase[0]['OrderDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arryPurchase[0]['Approved'] == 1) ? ('Yes') : ('No');

$DeliveryDate = ($arryPurchase[0]['DeliveryDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))) : (NOT_MENTIONED);

$PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm'])) ? (stripslashes($arryPurchase[0]['PaymentTerm'])) : (NOT_MENTIONED);
$PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod'])) ? (stripslashes($arryPurchase[0]['PaymentMethod'])) : (NOT_MENTIONED);
//$ShippingMethod = (!empty($arryPurchase[0]['ShippingMethod'])) ? (stripslashes($arryPurchase[0]['ShippingMethod'])) : (NOT_MENTIONED);
$ShippingMethod = (!empty($arryPurchase[0]['ShippingMethodVal'])) ? (stripslashes($arryPurchase[0]['ShippingMethodVal'])) : (NOT_MENTIONED);
$ShippingMethodVal = (!empty($arryPurchase[0]['ShippingMethodVal'])) ? (stripslashes($arryPurchase[0]['ShippingMethodVal'])) : (NOT_MENTIONED);
$PrepaidFreight = ($arryPurchase[0]['PrepaidFreight'] == 1) ? ("Yes") : ("No");
// $Comment = (!empty($arryPurchase[0]['Comment'])) ? (stripslashes($arryPurchase[0]['Comment'])) : (NOT_MENTIONED);

$MultiComment = explode("##",$arryPurchase[0]['Comment']);

if(empty($MultiComment[1]) && !empty($MultiComment[0])){
    $Comment = stripslashes($arryPurchase[0]['Comment']);
}else{
	$Comment= '';
    if(!empty($arryPurchase[0]['Comment'])){
        $cmtIDS = array_filter($MultiComment);
          $cmtIDS = implode(',', $cmtIDS);
          $CommentData = $objBankAccount->getComment($cmtIDS, true);
          foreach ($CommentData as $cmt){
            $Comment .= $cmt['comment'].'<br/>';
          }
      }else{
        $Comment = NOT_MENTIONED;
      }
}


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


if(!empty($arryPurchase[0]['ShippingMethodVal'])){      
    $arryShipMethodName = $objConfigure->GetShipMethodName($arryPurchase[0]['ShippingMethod'],$arryPurchase[0]['ShippingMethodVal']);
}

	$service_type = (!empty($arryShipMethodName[0]['service_type']))?($arryShipMethodName[0]['service_type']):('');

//$SalesOrder = 'Sales Order';
/* * *Information data for Purchase** */
//$Infodata = array('Order Date' => $OrderDate, $ModuleIDTitle => $ModuleID, 'Order Status' => $Status, 'Approved' => $Approved, 'Order Type' => $OrderType, 'Sales Order' => $SalesOrder);
$PaydataArry = array('Required Date' => $DeliveryDate, 'Ship VIA' => $service_type, 'TERMS' => $PaymentTerm);
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
//added by Nisha for phone number pattern
if(!empty($arryPurchase[0]['Mobile'])) {
    $arryPurchase[0]['Mobile'] = PhoneNumberFormat($arryPurchase[0]['Mobile']);
 }

$VendorMobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : ('');
//added by Nisha for phone no  pattern
if(!empty($arryPurchase[0]['Landline'])) {
    $arryPurchase[0]['Landline'] = PhoneNumberFormat($arryPurchase[0]['Landline']);
 }
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
if(!empty($arryPurchase[0]['wMobile'])) {
    $arryPurchase[0]['wMobile'] = PhoneNumberFormat($arryPurchase[0]['wMobile']);
 }
$wMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : ('');
if(!empty($arryPurchase[0]['wLandline'])) {
    $arryPurchase[0]['wLandline'] = PhoneNumberFormat($arryPurchase[0]['wLandline']);
 }
$wLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : ('&nbsp;');
$wEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : ('');


$VendorCustomerCompany=(!empty($VendorCustomerCompany)) ? ($VendorCustomerCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('&nbsp;<br>');
$VendorCountry=(!empty($VendorCountry)) ? ($VendorCountry.',<br>') : ('&nbsp;<br>');
$VendorMobile=(!empty($VendorMobile)) ? ($VendorMobile.',<br>'.$VendorLandline) : ($VendorLandline.'<br>&nbsp;');
$Vendorcity=(!empty($Vendorcity)) ? ($Vendorcity.',') : ('');
$VendorState=(!empty($VendorState)) ? ($VendorState.'-') : ('');


$Address1 = array('' => $VendorCustomerCompany.$Address.$Vendorcity.$VendorState.$VendorZipCode.'<br>'.$VendorCountry.$VendorMobile);


$wCustomerCompany=(!empty($wCustomerCompany)) ? ($wCustomerCompany.',<br>') : ('');
$wAddress=(!empty($wAddress)) ? ($wAddress.',<br>') : ('&nbsp;<br>');
$wCountry=(!empty($wCountry)) ? ($wCountry.',<br>') : ('&nbsp;<br>');
$wMobile=(!empty($wMobile)) ? ($wMobile.',<br>'.$wLandline) : ($wLandline.'<br>&nbsp;');
$wcity=(!empty($wcity)) ? ($wcity.',') : ('');
$wState=(!empty($wState)) ? ($wState.'-') : ('');

$Address2 = array('' => $wCustomerCompany.$wAddress.$wcity.$wState.$wZipCode.'<br>'.$wCountry.$wMobile);
/*
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

$Address2 = array('' => $wCustomerCompany.'<br>'.$wAddress.'<br>'.$wcity.','.$wState.'-'.$wZipCode.'<br>'.$wCountry.'<br>'.$wLandline);*/
/* * *Ship-To Address*** */

/* * *Specail Notes** */
$Comment = wordwrap($Comment, 60, "<br />", true);
//$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Payment Term' => $PaymentTerm,  'Shipping Carrier' => $ShippingMethod, 'Comments' => $Comment, 'Prepaid Freight' => $PrepaidFreight);
//$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Comments' => $Comment, 'Prepaid Freight' => $PrepaidFreight);
$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Comments' => $Comment);
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

