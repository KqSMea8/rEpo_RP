<?php

require_once($Prefix . "classes/rma.purchase.class.php");
$objPurchase = new purchase();



if (!empty($_GET['o'])) {
    //die('cbh');
    //$arryPurchase = $objPurchase->GetPurchase($_GET['o'],'','');
    $arryPurchase = $objPurchase->GetPurchaserma($_GET['o'], '', '');

    $OrderID = $arryPurchase[0]['OrderID'];
    $ModuleName = $arryPurchase[0]['Module'];
    if ($OrderID > 0) {
        //$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $arryPurchaseItem = $objPurchase->GetPurchaseItemRMA($OrderID);
        //echo '<pre>'; print_r($arryPurchaseItem); die('testdata');
        $NumLine = sizeof($arryPurchaseItem);
    } else {
        $ErrorMSG = NOT_EXIST_RETURN;
    }
} else {
    $ErrorMSG = NOT_EXIST_DATA;
}

if (!empty($ErrorMSG)) {
    echo $ErrorMSG;
    exit;
}
if($_GET['t']==1){
    echo '<pre>'; print_r($arryPurchase);die;
}

/* * **************************************** */
/* * **************************************** */
$ModulePDFID = $arryPurchase[0]["ReturnID"];
$Title = 'Purchase '.$ModuleName;
/* * ******* Return Detail ************* */
$TotalAmount = $arryPurchase[0]['TotalAmount'] . ' ' . $arryPurchase[0]['Currency'];

$ReturnDate = ($arryPurchase[0]['PostedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))) : (NOT_MENTIONED);
$ReceivedDate = ($arryPurchase[0]['ReceivedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))) : (NOT_MENTIONED);
$ExpiryDate = ($arryPurchase[0]['ExpiryDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['ExpiryDate']))) : (NOT_MENTIONED);
$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1) ? ('Yes') : ('No');
$InvoiceComment = (!empty($arryPurchase[0]['InvoiceComment'])) ? (stripslashes($arryPurchase[0]['InvoiceComment'])) : (NOT_MENTIONED);
$PaymentDate = ($arryPurchase[0]['PaymentDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))) : (NOT_MENTIONED);
$InvPaymentMethod = (!empty($arryPurchase[0]['InvPaymentMethod'])) ? (stripslashes($arryPurchase[0]['InvPaymentMethod'])) : (NOT_MENTIONED);
$PaymentRef = (!empty($arryPurchase[0]['PaymentRef'])) ? (stripslashes($arryPurchase[0]['PaymentRef'])) : (NOT_MENTIONED);
$ReStocking = ($arryPurchase[0]['Restocking'] == 1) ? ('Yes') : ('No');

if (empty($ModuleID)) {
    $ModuleIDTitle = "Invoice Number";
    $ModuleID = "InvoiceID";
}

$arryInvoice = $objPurchase->GetPurchaseInvoice('', $arryPurchase[0]["InvoiceID"], 'Invoice');
$PostedDate = ($arryInvoice[0]['PostedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryInvoice[0]['PostedDate']))) : (NOT_MENTIONED);
$InvoiceComment = (!empty($arryInvoice[0]['InvoiceComment'])) ? (stripslashes($arryInvoice[0]['InvoiceComment'])) : (NOT_MENTIONED);
$InvoiceID = (!empty($arryInvoice[0]['InvoiceID'])) ? (stripslashes($arryInvoice[0]['InvoiceID'])) : (NOT_MENTIONED);

/* * *Information data for Purchase** */
//$Infodata = array('RMA Date' => $ReturnDate, 'Item RMA Date' => $ReceivedDate, 'RMA Expiry Date' => $ExpiryDate, 'Comments' => $InvoiceComment);
//$Infodata = array('RMA Date' => $ReturnDate, 'RMA No' => $ModulePDFID);
$Infodata = array('RMA Date' => $ReturnDate,'INV No' => $InvoiceID,'RMA No' => $ModulePDFID);
/* * *Information data for Purchase** */

/* * *Specail Notes** */
$specialNotesArry = array('Total Amount' => $TotalAmount, 'Re-Stocking' => $ReStocking,'InvoiceID'=>$InvoiceID,'Invoice Date'=>$PostedDate,'Comments'=>$InvoiceComment);
/* * *Special NOtes** */


/* * **vender Address*** */
$AddressHead1 = "VENDOR";
$Address = str_replace("\n"," ",stripslashes($arryPurchase[0]['Address']));
$VendorCompany = (!empty($arryPurchase[0]['SuppCompany'])) ? (stripslashes($arryPurchase[0]['SuppCompany'])) : ('');
$VCity = (!empty($arryPurchase[0]['City'])) ? (stripslashes($arryPurchase[0]['City'])) : ('');
$VState = (!empty($arryPurchase[0]['State'])) ? (stripslashes($arryPurchase[0]['State'])) : ('');
$VCountry = (!empty($arryPurchase[0]['Country'])) ? (stripslashes($arryPurchase[0]['Country'])) : ('');
$VZipCode = (!empty($arryPurchase[0]['ZipCode'])) ? (stripslashes($arryPurchase[0]['ZipCode'])) : ('');
$VSuppContact = (!empty($arryPurchase[0]['SuppContact'])) ? (stripslashes($arryPurchase[0]['SuppContact'])) : ('');
//added by Nisha
if(!empty($arryPurchase[0]['Mobile'])) {
   $arryPurchase[0]['Mobile'] = PhoneNumberFormat($arryPurchase[0]['Mobile']);
 }
$VMobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : ('');
//added by Nisha
if(!empty($arryPurchase[0]['Landline'])) {
   $arryPurchase[0]['Landline'] = PhoneNumberFormat($arryPurchase[0]['Landline']);
 }
$VLandline = (!empty($arryPurchase[0]['Landline'])) ? (stripslashes($arryPurchase[0]['Landline'])) : ('');
$VEmail = (!empty($arryPurchase[0]['Email'])) ? (stripslashes($arryPurchase[0]['Email'])) : ('');
$SuppCurrency = (!empty($arryPurchase[0]['SuppCurrency'])) ? (stripslashes($arryPurchase[0]['SuppCurrency'])) : ('');
//$Address1 = array('Company Name' => $VendorCompany, 'Address' => $Address, 'Contact Name'=>$VSuppContact,'City' => $VCity, 'State' => $VState, 'Country' => $VCountry, 'Zip Code' => $VZipCode, 'Mobile' => $VMobile, 'Landline' => $VLandline, 'Email' => $VEmail);
$VendorCompany=(!empty($VendorCompany)) ? ($VendorCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('');
$VCountry=(!empty($VCountry)) ? ($VCountry.',<br>'.$VLandline) : ($VLandline.'<br>&nbsp;');
$VMobile=(!empty($BMobile)) ? ($BMobile.',<br>') : ('');
$VCity=(!empty($VCity)) ? ($VCity.',') : ('');
$VState=(!empty($VState)) ? ($VState.'-') : ('');


$Address1 = array('' => $VendorCompany.$Address.$VCity.$VState.$VZipCode.'<br>'.$VCountry.$VMobile);

/* * **vender Address*** */

/* * **Ship-To Address*** */
$AddressHead2 = "SHIP TO";
$wAddress = str_replace("\n"," ",stripslashes($arryPurchase[0]['wAddress']));
$wCompany = (!empty($arryPurchase[0]['wName'])) ? (stripslashes($arryPurchase[0]['wName'])) : ('');
$wCity = (!empty($arryPurchase[0]['wCity'])) ? (stripslashes($arryPurchase[0]['wCity'])) : ('');
$wState = (!empty($arryPurchase[0]['wState'])) ? (stripslashes($arryPurchase[0]['wState'])) : ('');
$wCountry = (!empty($arryPurchase[0]['wCountry'])) ? (stripslashes($arryPurchase[0]['wCountry'])) : ('');
$wZipCode = (!empty($arryPurchase[0]['wZipCode'])) ? (stripslashes($arryPurchase[0]['wZipCode'])) : ('');
$wSuppContact = (!empty($arryPurchase[0]['wContact'])) ? (stripslashes($arryPurchase[0]['wContact'])) : ('');
//added by Nisha
if(!empty($arryPurchase[0]['wMobile'])) {
   $arryPurchase[0]['wMobile'] = PhoneNumberFormat($arryPurchase[0]['wMobile']);
 }
$wMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : ('');
$wLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : ('');
$wEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : ('');
//$Address2 = array('Company Name' => $wCompany, 'Address' => $wAddress, 'Contact Name'=>$wSuppContact,'City' => $wCity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Mobile' => $wMobile, 'Landline' => $wLandline, 'Email' => $wEmail);
$wCompany=(!empty($wCompany)) ? ($wCompany.',<br>') : ('');
$wAddress=(!empty($wAddress)) ? ($wAddress.',<br>') : ('');
$wCountry=(!empty($wCountry)) ? ($wCountry.',<br>') : ('');
$wMobile=(!empty($wMobile)) ? ($wMobile.',<br>'.$wLandline) : ($wLandline.'<br>&nbsp;');
$wCity=(!empty($wCity)) ? ($wCity.',') : ('');
$wState=(!empty($wState)) ? ($wState.'-') : ('');


$Address2 = array('' => $wCompany.$wAddress.$wCity.$wState.$wZipCode.'<br>'.$wCountry.$wMobile);
/* * **vender Address*** */


$Taxable = ($arryPurchase[0]['tax_auths']=="Yes")?("Yes"):("No");
	$arrRate = explode(":",$arryPurchase[0]['TaxRate']);
	if(!empty($arrRate[0])){
		$TaxVal = $arrRate[2].' %';
		$TaxName = '['.$arrRate[1].']';
	}else{
		$TaxVal = 'None';
	}
?>
