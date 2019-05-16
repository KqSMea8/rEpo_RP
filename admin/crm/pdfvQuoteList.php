<?php

CleanGet();
if($AttachFlag!=1){
    require_once($Prefix."classes/quote.class.php");
    
}

require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/sales.customer.class.php");

$objQuote=new quote();
$objLead=new lead();
$objCustomer=new Customer(); 

//(!$_GET['module'])?($_GET['module']='Quote'):("");
$module = $_GET['module'];
$ModuleIDTitle = "Quote Number";
$ModuleID = "quoteid";
$PrefixSO = "QT";
$NotExist = "Data Not Exist";
$ModuleName = "Quote ";


if(!empty($_GET['o'])){
    $arryQuote = $objQuote->GetQuote($_GET['o'],'','');
    
    if($arryQuote[0]['OpportunityID']>0){
        $arryOpp = $objLead->GetOpportunity($arryQuote[0]['OpportunityID'],'');
    }
    
    $OpportunityName = (!empty($arryOpp[0]['OpportunityName']))?(stripslashes($arryOpp[0]['OpportunityName'])):(stripslashes($arryQuote[0]['opportunityName']));
    if($arryQuote[0]['CustID']>0){
        $arryCustomer = $objCustomer->GetCustomer($arryQuote[0]['CustID'],'','');
    }
    $CustomerName = (!empty($arryCustomer[0]['FullName']))?(stripslashes($arryCustomer[0]['FullName'])):(stripslashes($arryQuote[0]['CustomerName']));
    
    
    
    $arryQuoteAdd = $objQuote->GetQuoteAddress($arryQuote[0]['quoteid'],'');
    
    $OrderID   = $arryQuote[0]['quoteid'];
    if($OrderID>0){
        $arryQuoteItem = $objQuote->GetQuoteItem($OrderID);
        
        
        $NumLine = sizeof($arryQuoteItem);
    }else{
        $ErrorMSG = NOT_EXIST_RETURN;
    }
}else{
    $ErrorMSG = NOT_EXIST_DATA;
}

if(!empty($ErrorMSG)) {
    echo $ErrorMSG; exit;
}

/* * **************************************** */
if(!empty($arryQuote[0]['CreatedByEmail'])){
    $arryCompany[0]['Email']=$arryQuote[0]['CreatedByEmail'];
}




#FooterTextBox($pdf);
//TitlePage($arry, $pdf);
//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);
 $ModulePDFID = $arryQuote[0][$ModuleID];
 $Title = $ModuleName." # ".$arryQuote[0][$ModuleID];

//$Address = str_replace("\n"," ",stripslashes($arryQuoteAdd[0]['bill_street']));


//$ShippingAddress = str_replace("\n"," ",stripslashes($arryQuoteAdd[0]['ship_street']));

 
  
 //$Approved = (!empty($arryQuote[0]['Approved'])) ? ('Yes') : ('No');
 
 
  $ReturnDate = ($arryQuote[0]['PostedDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryQuote[0]['PostedDate']))) : (NOT_MENTIONED);
  #$ShippedDate = ($arryQuoteAdd[0]['ShippedDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryQuoteAdd[0]['ShippedDate']))) : (NOT_MENTIONED);
 
#$ReturnPaidDate = ($arryQuote[0]['ReturnPaidDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryQuote[0]['ReturnPaidDate']))) : (NOT_MENTIONED);
$InvoiceNumber = (!empty($arryQuote[0]['validtill'])) ? (stripslashes($arryQuote[0]['validtill'])) : (NOT_MENTIONED);
$Customer = (!empty($arryQuote[0]['CustomerName'])) ? (stripslashes($arryQuote[0]['CustomerName'])) : (NOT_MENTIONED);
$RmaNUmber=(!empty($arryQuote[0]['quoteid'])) ? (stripslashes($arryQuote[0]['quoteid'])) : (NOT_MENTIONED);
/* * **************************************** */


$Infodata = array('Date' => $ReturnDate, 'Valid Until' => $InvoiceNumber,'Quote#'=>$RmaNUmber,'Customer ID'=>$arryQuote[0]['CustID']);





/* * ***Billing Address**** */
$AddressHead1 = "BILLING";
$Address='';
if(!empty($arryQuoteAdd[0]['bill_street'])){
	$Address .= str_replace("\n"," ",stripslashes($arryQuoteAdd[0]['bill_street']));
}

$CustomerCompany = (!empty($arryQuote[0]['CustomerCompany'])) ? (stripslashes($arryQuote[0]['CustomerCompany'])) : ('');
$BCity = (!empty($arryQuoteAdd[0]['bill_city'])) ? (stripslashes($arryQuoteAdd[0]['bill_city'])) : ('');
$BState = (!empty($arryQuoteAdd[0]['bill_state'])) ? (stripslashes($arryQuoteAdd[0]['bill_state'])) : ('');
$BCountry = (!empty($arryQuoteAdd[0]['bill_country'])) ? (stripslashes($arryQuoteAdd[0]['bill_country'])) : ('');
$BZipCode = (!empty($arryQuoteAdd[0]['bill_code'])) ? (stripslashes($arryQuoteAdd[0]['bill_code'])) : ('');
$BContact = (!empty($arryQuoteAdd[0]['Contact'])) ? (stripslashes($arryQuoteAdd[0]['Contact'])) : ('');
$BCustomerCurrency = (!empty($arryQuote[0]['CustomerCurrency'])) ? (stripslashes($arryQuote[0]['CustomerCurrency'])) : ('');

$CustomerCompany=(!empty($CustomerCompany)) ? ($CustomerCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('');
$BCountry=(!empty($BCountry)) ? ($BCountry.',<br>') : ('');
$BCity=(!empty($BCity)) ? ($BCity.',') : ('');
$BState=(!empty($BState)) ? ($BState.'-') : ('');

/**code for vat field***/


/**code for vat field***/
$Address1 = array('' => $CustomerCompany.$Address.$BCity.$BState.$BZipCode.'<br>'.$BCountry);
/*****Billing Address*****/

/* * ***Shipping Address**** */
$AddressHead2 = "SHIPPING";
$ShippingAddress = '';
if(!empty($arryQuote[0]['ship_street'])){
	$ShippingAddress = str_replace("\n", " ", stripslashes($arryQuote[0]['ship_street']));
}
$ShippingCompany = (!empty($arryQuote[0]['ShippingCompany'])) ? (stripslashes($arryQuote[0]['ShippingCompany'])) : ('');
$ShippingCity = (!empty($arryQuoteAdd[0]['ship_city'])) ? (stripslashes($arryQuoteAdd[0]['ship_city'])) : ('');
$ShippingState = (!empty($arryQuoteAdd[0]['ship_state'])) ? (stripslashes($arryQuoteAdd[0]['ship_state'])) : ('');
$ShippingCountry = (!empty($arryQuoteAdd[0]['ship_country'])) ? (stripslashes($arryQuoteAdd[0]['ship_country'])) : ('');
$ShippingZipCode = (!empty($arryQuoteAdd[0]['ship_code'])) ? (stripslashes($arryQuoteAdd[0]['ship_code'])) : ('');


//$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, 'Email' => $ShippingEmail);
$ShippingCompany=(!empty($ShippingCompany)) ? ($ShippingCompany.',<br>') : ('');
$ShippingAddress=(!empty($ShippingAddress)) ? ($ShippingAddress.',<br>') : ('');
$ShippingCountry=(!empty($ShippingCountry)) ? ($ShippingCountry.',<br>') : ('');
$ShippingCity=(!empty($ShippingCity)) ? ($ShippingCity.',') : ('');
$ShippingState=(!empty($ShippingState)) ? ($ShippingState.'-') : ('');

$Address2 = array('' => $ShippingCompany.$ShippingAddress.$ShippingCity.$ShippingState.$ShippingZipCode.'<br>'.$ShippingCountry);
/* * ***Shipping Address**** */

$Taxable = ($arryQuote[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arryQuote[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
}

/* * *Specail Notes** */
$specialNotesArry = array('Subject' => stripslashes($arryQuote[0]['subject']), 'Opportunity' => stripslashes($arryQuote[0]['validtill']), 'Quote Stage' => stripslashes($arryQuote[0]['quotestage']), 'Valid till' => stripslashes($arryQuote[0]['validtill']), 'PaymentType' => stripslashes($arryQuote[0]["PaymentMethod"]));
/* * *Special Notes** */

//echo $Title;die;
/* if (empty($ModuleID)) {
    $ModuleIDTitle = "Return Number";
    $ModuleID = "ReturnID";
}*/


 

?>
