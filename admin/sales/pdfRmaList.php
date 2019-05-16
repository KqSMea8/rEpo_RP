<?php

require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/rma.sales.class.php");
$objSale = new sale();
$objrmasale = new rmasale();

$ModuleIDTitle = "RMA Number";
$ModuleID = "ReturnID";
$PrefixSO = "RTN";
$NotExist = "RMA not exist";

if (!empty($_GET['o'])) {
    $arrySale = $objSale->GetSale($_GET['o'], '', '');
    $OrderID = $arrySale[0]['OrderID'];
    $ModuleName = $arrySale[0]['Module'];
    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);

        //get payment history
        //$arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
    } else {
        $ErrorMSG = $NotExist;
    }
} else {
    $ErrorMSG = "Data not exist";
}

if (!empty($ErrorMSG)) {
    echo $ErrorMSG;
    exit;
}

/* * **************************************** */
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
if($_GET['t']==1){
    echo '<pre>'; print_r($arrySale);die;
}
#FooterTextBox($pdf);
//TitlePage($arry, $pdf);
//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);
$ModulePDFID = $arrySale[0][$ModuleID];
$Title = 'Sales '.$ModuleName;
//echo $Title;die;
if (empty($ModuleID)) {
    $ModuleIDTitle = "Return Number";
    $ModuleID = "ReturnID";
}

 
$OrderDate = ($arrySale[0]['OrderDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arrySale[0]['Approved'] == 1) ? ('Yes') : ('No');

$ReturnDate = ($arrySale[0]['ReturnDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['ReturnDate']))) : (NOT_MENTIONED);
$ShippedDate = ($arrySale[0]['ShippedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['ShippedDate']))) : (NOT_MENTIONED);
#$ReturnPaidDate = ($arrySale[0]['ReturnPaidDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['ReturnPaidDate']))) : (NOT_MENTIONED);
$ReturnComment = (!empty($arrySale[0]['ReturnComment'])) ? (stripslashes($arrySale[0]['ReturnComment'])) : (NOT_MENTIONED);
$InvoiceNumber = (!empty($arrySale[0]['InvoiceID'])) ? (stripslashes($arrySale[0]['InvoiceID'])) : (NOT_MENTIONED);
$Customer = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$restoring=($arrySale[0]['ReSt']==1)?('Yes'):('No');
$RmaNUmber=(!empty($arrySale[0][$ModuleID])) ? (stripslashes($arrySale[0][$ModuleID])) : (NOT_MENTIONED);
/* * **************************************** */

//echo '<pre>'; print_r($arrySale);die;
/* * *Information data for Purchase** */
//$Infodata = array('Return Date' => $ReturnDate, 'Invoice Number' => $InvoiceNumber, 'Customer' => $Customer, 'Comments' => $ReturnComment);
$Infodata = array('Return Date' => $ReturnDate, 'INV No' => $InvoiceNumber,'Rma No'=>$RmaNUmber);
/* * *Information data for Purchase** */
//$PaydataArry = array('Required Date' => $ReceivedDate, 'Ship VIA' => $ShippingMethod, 'TERMS' => $PaymentTerm);




/* * ***Billing Address**** */
$AddressHead1 = "BILLING";
$Address = str_replace("\n", " ", stripslashes($arrySale[0]['Address']));
#$BillAddress = str_replace("\n", " ", stripslashes($arrySale[0]['Address2']));
$CustomerCompany = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : ('');
$BCity = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : ('');
$BState = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : ('');
$BCountry = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : ('');
$BZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : ('');
$BContact = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact'])) : ('');

//added by Nisha for phone no pattern
if(!empty($arrySale[0]['Mobile'])) {
   $arrySale[0]['Mobile'] = PhoneNumberFormat($arrySale[0]['Mobile']);
 }

//********** end of phone no pattern
$BMobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
//added by nisha for phone no pattern
if(!empty($arrySale[0]['Landline'])) {
    $arrySale[0]['Landline'] = PhoneNumberFormat($arrySale[0]['Landline']);
}


//$BMobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
$BLandline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : ('');
$BEmail = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : ('');
$BCustomerCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');
//$Address1 = array('Company Name' => $CustomerCompany, 'Address' => $Address . $BillAddress, 'City' => $BCity, 'State' => $BState, 'Country' => $BCountry, 'Zip Code' => $BZipCode, 'Mobile' => $BMobile, 'Landline' => $BLandline, 'Email' => $BEmail);

$CustomerCompany=(!empty($CustomerCompany)) ? ($CustomerCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('');
$BCountry=(!empty($BCountry)) ? ($BCountry.',<br>') : ('');
$BMobile=(!empty($BMobile)) ? ($BMobile.',<br>'.$BLandline) : ($BLandline.'<br>&nbsp;');
$BCity=(!empty($BCity)) ? ($BCity.',') : ('');
$BState=(!empty($BState)) ? ($BState.'-') : ('');

/**code for vat field***/
$CustomerVAT='';
if($_SESSION['CmpID']=='612'){
$CustomerVAT = (!empty($arrySale[0]['ebcf1c'])) ? ('<br>VAT-'.stripslashes($arrySale[0]['ebcf1c'])) : ('');
}
if($_SESSION['CmpID']=='31'){
$CustomerVAT = (!empty($arrySale[0]['6dcf6d'])) ? ('<br>VAT-'.stripslashes($arrySale[0]['6dcf6d'])) : ('');
}

/**code for vat field***/
$Address1 = array('' => $CustomerCompany.$Address.$BCity.$BState.$BZipCode.'<br>'.$BCountry.$BMobile.$CustomerVAT);
/*****Billing Address*****/

/* * ***Shipping Address**** */
$AddressHead2 = "SHIPPING";
$ShippingAddress = str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress']));
#$ShippingAddress2 = str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress2']));
$ShippingCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : ('');
$ShippingCity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : ('');
$ShippingState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : ('');
$ShippingCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : ('');
$ShippingZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : ('');
if(!empty($arrySale[0]['ShippingMobile'])) {
    $arrySale[0]['ShippingMobile'] = PhoneNumberFormat($arrySale[0]['ShippingMobile']);
 }
$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : ('');
if(!empty($arrySale[0]['ShippingLandline'])) {
    $arrySale[0]['ShippingLandline'] = PhoneNumberFormat($arrySale[0]['ShippingLandline']);
 }
$ShippingLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : ('');
$ShippingEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : ('');

//$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail);
$ShippingCompany=(!empty($ShippingCompany)) ? ($ShippingCompany.',<br>') : ('');
$ShippingAddress=(!empty($ShippingAddress)) ? ($ShippingAddress.',<br>') : ('');
$ShippingCountry=(!empty($ShippingCountry)) ? ($ShippingCountry.',<br>') : ('');
$ShippingMobile=(!empty($ShippingMobile)) ? ($ShippingMobile.',<br>'.$ShippingLandline) : ($ShippingLandline.'<br>&nbsp;');
$ShippingCity=(!empty($ShippingCity)) ? ($ShippingCity.',') : ('');
$ShippingState=(!empty($ShippingState)) ? ($ShippingState.'-') : ('');

$Address2 = array('' => $ShippingCompany.$ShippingAddress.$ShippingCity.$ShippingState.$ShippingZipCode.'<br>'.$ShippingCountry.$ShippingMobile);
/* * ***Shipping Address**** */

$Taxable = ($arrySale[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arrySale[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
}

/* * *Specail Notes** */
#$specialNotesArry = array('Order Date' => $OrderDate, 'Approved' => $Approved, 'Shipped Date' => $ShippedDate, 'Return Paid Date' => $ReturnPaidDate, 'Taxable' => $Taxable, 'Tax Rate' => $TaxVal,'Re-Stocking'=>$restoring);

$specialNotesArry = array('Order Date' => $OrderDate, 'Approved' => $Approved, 'Shipped Date' => $ShippedDate,   'Taxable' => $Taxable, 'Tax Rate' => $TaxVal,'Re-Stocking'=>$restoring);
/* * *Special Notes** */
?>
