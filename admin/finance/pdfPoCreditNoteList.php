<?php

require_once($Prefix . "classes/purchase.class.php");
require_once($Prefix . "classes/finance.account.class.php");
$objBankAccount = new BankAccount();

$objPurchase = new purchase();
$ModuleName = "Credit Memo";

if (!empty($_GET['o'])) {
    $arryPurchase = $objPurchase->GetPurchase($_GET['o'], '', 'Credit');
    $OrderID = $arryPurchase[0]['OrderID'];
    if ($OrderID > 0) {
        $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $NumLine = sizeof($arryPurchaseItem);
    } else {
        $ErrorMSG = $NotExist;
    }
} else {
    $ErrorMSG = NOT_EXIST_CREDIT;
}

if (!empty($ErrorMSG)) {
    echo $ErrorMSG;
    exit;
}


/* * **************************************** */
/* * **************************************** */

//echo '<pre>'; print_r($arryPurchase);die;
$ModulePDFID = $arryPurchase[0]["CreditID"];
$CreditMemoID = $arryPurchase[0]["CreditID"];
$Title = 'AP '.$ModuleName;

if (empty($ModuleID)) {
    $ModuleIDTitle = "PO Number";
    $ModuleID = "PurchaseID";
}

$GLAccount = NOT_SPECIFIED;
if (!empty($arryPurchase[0]['AccountID'])) {
    $arryBankAccount = $objBankAccount->getBankAccountById($arryPurchase[0]['AccountID']);
    $GLAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
}
/* * **infodata start*** */
$PostedDate = ($arryPurchase[0]['PostedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))) : (NOT_MENTIONED);
$Approved = ($arryPurchase[0]['Approved'] == 1) ? ('Yes') : ('No');
$ClosedDate = ($arryPurchase[0]['ClosedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['ClosedDate']))) : (NOT_MENTIONED);
$Comment = (!empty($arryPurchase[0]['Comment'])) ? (stripslashes($arryPurchase[0]['Comment'])) : (NOT_MENTIONED);
$CreditID = (!empty($arryPurchase[0]['CreditID'])) ? (stripslashes($arryPurchase[0]['CreditID'])) : (NOT_MENTIONED);
$Status = (!empty($arryPurchase[0]['Status'])) ? (stripslashes($arryPurchase[0]['Status'])) : (NOT_MENTIONED);
$SuppCompany = (!empty($arryPurchase[0]['SuppCompany'])) ? (stripslashes($arryPurchase[0]['SuppCompany'])) : (NOT_MENTIONED);

$Currency='';
if (empty($arryPurchase[0]['AccountID'])) {

	$ReSt=($arryPurchase[0]['Restocking']==1)?('Yes'):('No');

    $Infodata = array('Credit Memo ID' => $CreditMemoID,  'Vendor' => $SuppCompany, 'Posted Date' => $PostedDate, 'Approved' => $Approved, 'Status' => $Status , 'Comments' => $Comment );
    $specialNotesArry = array('Comments' => $Comment ,'Re-Stocking'=>$ReSt);
    /*     * **infodata End*** */


    /*     * ***start vendor addresss*** */
   
    $Address = (!empty($arryPurchase[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['Address']))) : (NOT_MENTIONED);
    $addlength1 = strlen($Address);
    $Address = wordwrap($Address, 45, "<br />", true);
    $wAddress = (!empty($arryPurchase[0]['wAddress'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['wAddress']))) : (NOT_MENTIONED);
    $addlength2 = strlen($wAddress);
    $wAddress = wordwrap($wAddress, 45, "<br />", true);
    $City = (!empty($arryPurchase[0]['City'])) ? (stripslashes($arryPurchase[0]['City'])) : (NOT_MENTIONED);
    $State = (!empty($arryPurchase[0]['State'])) ? (stripslashes($arryPurchase[0]['State'])) : (NOT_MENTIONED);
    $Country = (!empty($arryPurchase[0]['Country'])) ? (stripslashes($arryPurchase[0]['Country'])) : (NOT_MENTIONED);
    $ZipCode = (!empty($arryPurchase[0]['ZipCode'])) ? (stripslashes($arryPurchase[0]['ZipCode'])) : (NOT_MENTIONED);
    $SuppContact = (!empty($arryPurchase[0]['SuppContact'])) ? (stripslashes($arryPurchase[0]['SuppContact'])) : (NOT_MENTIONED);
    //Mobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : (NOT_MENTIONED);
 //added by Nisha for phone no
if(!empty($arryPurchase[0]['Mobile'])) {
   $arryPurchase[0]['Mobile'] = PhoneNumberFormat($arryPurchase[0]['Mobile']);
 }

//**********end of phone no
    $Mobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : (NOT_MENTIONED);
    //added by Nisha for phone no
if(!empty($arryPurchase[0]['Landline'])) {
    $arryPurchase[0]['Landline'] = PhoneNumberFormat($arryPurchase[0]['Landline']);
 }

//**********end of phone no
    $Landline = (!empty($arryPurchase[0]['Landline'])) ? (stripslashes($arryPurchase[0]['Landline'])) : (NOT_MENTIONED);
    $Email = (!empty($arryPurchase[0]['Email'])) ? (stripslashes($arryPurchase[0]['Email'])) : (NOT_MENTIONED);
    $SuppCurrency = (!empty($arryPurchase[0]['SuppCurrency'])) ? (stripslashes($arryPurchase[0]['SuppCurrency'])) : (NOT_MENTIONED);
    /*     * ***End vendor addresss*** */


    /*     * ***Start shipp-to-address**** */
    $ShippCompany = (!empty($arryPurchase[0]['wName'])) ? (stripslashes($arryPurchase[0]['wName'])) : (NOT_MENTIONED);
    $ShippwCity = (!empty($arryPurchase[0]['wCity'])) ? (stripslashes($arryPurchase[0]['wCity'])) : (NOT_MENTIONED);
    $ShippwState = (!empty($arryPurchase[0]['wState'])) ? (stripslashes($arryPurchase[0]['wState'])) : (NOT_MENTIONED);
    $ShippwCountry = (!empty($arryPurchase[0]['wCountry'])) ? (stripslashes($arryPurchase[0]['wCountry'])) : (NOT_MENTIONED);
    $ShippwZipCode = (!empty($arryPurchase[0]['wZipCode'])) ? (stripslashes($arryPurchase[0]['wZipCode'])) : (NOT_MENTIONED);
    $ShippwContact = (!empty($arryPurchase[0]['wContact'])) ? (stripslashes($arryPurchase[0]['wContact'])) : (NOT_MENTIONED);
    //$ShippwMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : (NOT_MENTIONED);
 //added by Nisha for phone no pattern
if(!empty($arryPurchase[0]['wMobile'])) {
   $arryPurchase[0]['wMobile'] = PhoneNumberFormat($arryPurchase[0]['wMobile']);
 }

//**********end of phone no pattern
    $ShippwMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : (NOT_MENTIONED);
     //added by Nisha for phone no pattern
if(!empty($arryPurchase[0]['wLandline'])) {
    $arryPurchase[0]['wLandline'] = PhoneNumberFormat($arryPurchase[0]['wLandline']);
}
//**********end of phone no pattern
    $ShippwLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : (NOT_MENTIONED);
    $ShippwEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : (NOT_MENTIONED);
    $Currency = (!empty($arryPurchase[0]['Currency'])) ? (stripslashes($arryPurchase[0]['Currency'])) : ('');
    /*     * ***End shipp-to-address**** */


    /*     * ***Array for show Address**** */
    $SuppCompany=(!empty($SuppCompany)) ? ($SuppCompany.',<br>') : ('');
   $Address=(!empty($Address)) ? ($Address.',<br>') : ('&nbsp;<br>');
   $Country=(!empty($Country)) ? ($Country.',<br>') : ('&nbsp;<br>');
   $Mobile=(!empty($Mobile)) ? ($Mobile.',<br>'.$Landline) : ($Landline.'<br>&nbsp;');
   $City=(!empty($City)) ? ($City.',') : ('');
   $State=(!empty($State)) ? ($State.'-') : ('');


    $AddressHead1 = "Vendor Address";
    if ($addlength2 > 45 && $addlength1 < 45) {

        $Address1 = array('' => $SuppCompany.$Address.'&nbsp;<br>'.$City.$State.$ZipCode.'<br>'.$Country.$Mobile);

        //$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline, '' => '');
    } else {

        $Address1 = array('' => $SuppCompany.$Address.$City.$State.$ZipCode.'<br>'.$Country.$Mobile);
        //$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
    }

    $AddressHead2 = "Ship-To Address";


   $ShippCompany=(!empty($ShippCompany)) ? ($ShippCompany.',<br>') : ('');
   $wAddress=(!empty($wAddress)) ? ($wAddress.',<br>') : ('&nbsp;<br>');
   $ShippwCountry=(!empty($ShippwCountry)) ? ($ShippwCountry.',<br>') : ('&nbsp;<br>');
   $ShippwMobile=(!empty($ShippwMobile)) ? ($ShippwMobile.',<br>'.$ShippwLandline) : ($ShippwLandline.'<br>&nbsp;');
   $ShippwCity=(!empty($ShippwCity)) ? ($ShippwCity.',') : ('');
   $ShippwState=(!empty($ShippwState)) ? ($ShippwState.'-') : ('');

    if ($addlength2 < 45 && $addlength1 > 45) {
        $Address2 = array('' => $ShippCompany.$wAddress.'&nbsp;<br>'.$ShippwCity.$ShippwState.$ShippwZipCode.'<br>'.$ShippwCountry.$ShippwMobile);
        //$Address2 = array('Company Name' => $ShippCompany, 'Address' => $wAddress, 'City' => $ShippwCity, 'State' => $ShippwState, 'Country' => $ShippwCountry, 'Zip Code' => $ShippwZipCode, 'Contact Name' => $ShippwContact, 'Email' => $ShippwEmail, 'Mobile' => $ShippwMobile, 'Landline' => $ShippwLandline, '' => '');
    } else {

        $Address2 = array('' => $ShippCompany.$wAddress.$ShippwCity.$ShippwState.$ShippwZipCode.'<br>'.$ShippwCountry.$ShippwMobile);
        //$Address2 = array('Company Name' => $ShippCompany, 'Address' => $wAddress, 'City' => $ShippwCity, 'State' => $ShippwState, 'Country' => $ShippwCountry, 'Zip Code' => $ShippwZipCode, 'Contact Name' => $ShippwContact, 'Email' => $ShippwEmail, 'Mobile' => $ShippwMobile, 'Landline' => $ShippwLandline);
    }
    /*     * ****Array for Show Address*** */

    $Taxable = ($arryPurchase[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
    $arrRate = explode(":", $arryPurchase[0]['TaxRate']);
    if (!empty($arrRate[0])) {
        $TaxVal = $arrRate[2] . ' %';
        $TaxName = '[' . $arrRate[1] . ']';
    } else {
        $TaxVal = 'None';
    }
} else {
    $Infodata = array('Credit Memo ID' => $CreditMemoID,  'Vendor' => $SuppCompany, 'Posted Date' => $PostedDate, 'Approved' => $Approved, 'Status' => $Status ,  'Comments' => $Comment); //, 'GL Account' => $GLAccount
}
?>
