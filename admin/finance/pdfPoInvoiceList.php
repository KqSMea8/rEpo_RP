<?php

require_once($Prefix . "classes/purchase.class.php");
require_once($Prefix . "classes/supplier.class.php");
require_once($Prefix . "classes/finance.account.class.php");
$objPurchase = new purchase();
$objBankAccount=new BankAccount();
$objSupplier = new supplier();


$ModuleName = "Invoice";

if (!empty($_GET['o'])) {
    $arryPurchase = $objPurchase->GetPurchase($_GET['o'], '', 'Invoice');
    $OrderID = $arryPurchase[0]['OrderID'];
    if ($OrderID > 0) {
        $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $NumLine = sizeof($arryPurchaseItem);


	

	if(!empty($arryPurchase[0]['ExpenseID'])){	
		$_GET['ExpenseID'] = $arryPurchase[0]['ExpenseID'];		 
		$arryOtherExpense=$objBankAccount->getOtherExpense($_GET);
	
		if($arryOtherExpense[0]['GlEntryType']=="Multiple"){
	  		$arryMultiAccount=$objBankAccount->getMultiAccount($_GET['ExpenseID']);

		} 
	}


        /*         * **************************
          $arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
          $arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
          ///////// */
    } else {
        $ErrorMSG = NOT_EXIST_INVOICE;
    }
} else {
    $ErrorMSG = NOT_EXIST_DATA;
}

if (!empty($ErrorMSG)) {
    echo $ErrorMSG;
    exit;
}
if (empty($ModuleID)) {
    $ModuleIDTitle = "PO Number";
    $ModuleID = "PurchaseID";
}
$ModulePDFID = $arryPurchase[0]["InvoiceID"];
//$Title = $ModuleName . " # " . $ModulePDFID;
$Title = 'AP '.$ModuleName;

$ShippingMethod=$PaymentTerm='';
$ordered_qty=$Comment='';

/* * infodata* */
$InvoiceDate = ($arryPurchase[0]['PostedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))) : (NOT_MENTIONED);
$ReceivedDate = ($arryPurchase[0]['ReceivedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))) : (NOT_MENTIONED);
$PaymentDate = ($arryPurchase[0]['PaymentDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))) : (NOT_MENTIONED);
$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1) ? ('Yes') : ('No');
//$InvoiceComment = (!empty($arryPurchase[0]['InvoiceComment'])) ? (stripslashes($arryPurchase[0]['InvoiceComment'])) : (NOT_MENTIONED);
$MultiComment = explode("##",$arryPurchase[0]['InvoiceComment']);

if(empty($MultiComment[1]) && !empty($MultiComment[0])){
    $InvoiceComment = stripslashes($arryPurchase[0]['InvoiceComment']);
}else{
    if(!empty($arryPurchase[0]['InvoiceComment'])){
        $cmtIDS = array_filter($MultiComment);
          $cmtIDS = implode(',', $cmtIDS);
          $CommentData = $objBankAccount->getComment($cmtIDS, true);
          foreach ($CommentData as $cmt){
            $InvoiceComment .= $cmt['comment'].'<br/>';
          }
      }else{
        $InvoiceComment = '';
      }
}


$InvPaymentMethod = (!empty($arryPurchase[0]['InvPaymentMethod'])) ? (stripslashes($arryPurchase[0]['InvPaymentMethod'])) : (NOT_MENTIONED);
$PaymentRef = (!empty($arryPurchase[0]['PaymentRef'])) ? (stripslashes($arryPurchase[0]['PaymentRef'])) : (NOT_MENTIONED);
$PrepaidFreight = ($arryPurchase[0]['PrepaidFreight'] == 1) ? ('Yes') : ('No');
/* * infodata* */

/* * info data IE==0* */

if ($arryPurchase[0]['InvoiceEntry'] == 0) {
    //die('pp');
    $key1 = 'Order Date';
    $key2 = 'Approved';
    $key3 = 'Order Status';
    $key4 = 'Order Type';
    $key5 = 'Sales Order';
    $key6 = 'Delivery Date';
    $key7 = 'Payment Term';
    $key8 = 'Payment Method';
    $key9 = 'Shipping Method';
    $key10 = 'Comments';
    $key11 = $ModuleIDTitle;

    if (!empty($arrySale[0]['ShippingMethodVal'])) {
        $arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'], $arrySale[0]['ShippingMethodVal']);
    }

    $ShippingMethod=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):(NOT_SPECIFIED);
    $OrderDate = ($arryPurchase[0]['OrderDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))) : (NOT_MENTIONED);
    $Approved = ($arryPurchase[0]['Approved'] == 1) ? ('Yes') : ('No');

    $DeliveryDate = ($arryPurchase[0]['DeliveryDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))) : (NOT_MENTIONED);

    $PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm'])) ? (stripslashes($arryPurchase[0]['PaymentTerm'])) : (NOT_MENTIONED);
    $PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod'])) ? (stripslashes($arryPurchase[0]['PaymentMethod'])) : (NOT_MENTIONED);
    $ShippingCarrier = (!empty($arryPurchase[0]['ShippingMethod'])) ? (stripslashes($arryPurchase[0]['ShippingMethod'])) : (NOT_MENTIONED);
    //$Comment = (!empty($arryPurchase[0]['Comment'])) ? (stripslashes($arryPurchase[0]['Comment'])) : (NOT_MENTIONED);
$MultiComment = explode("##",$arryPurchase[0]['Comment']);

if(empty($MultiComment[1]) && !empty($MultiComment[0])){
    $Comment = stripslashes($arryPurchase[0]['Comment']);
}else{
	
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
//$Comment = (!empty($InvoiceComment)) ? $InvoiceComment
    $AssignedEmp = (!empty($arryPurchase[0]['AssignedEmp'])) ? (stripslashes($arryPurchase[0]['AssignedEmp'])) : (NOT_MENTIONED);
    $Status = (!empty($arryPurchase[0]['Status'])) ? (stripslashes($arryPurchase[0]['Status'])) : (NOT_MENTIONED);
    $OrderType = (!empty($arryPurchase[0]['OrderType'])) ? (stripslashes($arryPurchase[0]['OrderType'])) : (NOT_MENTIONED);
    $SalesOrder = (!empty($arryPurchase[0]['SaleID'])) ? (stripslashes($arryPurchase[0]['SaleID'])) : (NOT_MENTIONED);
    $ModuleIDval = (!empty($arryPurchase[0][$ModuleID])) ? (stripslashes($arryPurchase[0][$ModuleID])) : (NOT_MENTIONED);
    //$Infodata = array('Invoice Date' => $InvoiceDate, 'Received Date' => $ReceivedDate, 'Comments' => $InvoiceComment, $key1 => $OrderDate, $key2 => $Approved, $key3 => $Status, 'Prepaid Freight' => $PrepaidFreight);
    
    $Infodata = array('Invoice Date' => $InvoiceDate, 'Invoice Number' => $ModulePDFID);
    /*     * *Specail Notes** */
    //$specialNotesArry = array($key11 => $ModuleIDval, $key4 => $OrderType, $key5 => $SalesOrder, $key6 => $DeliveryDate, $key7 => $PaymentTerm,  $key9 => $ShippingMethod, $key10 => $Comment,'Shipping Carrier'=>$ShippingCarrier);

    $specialNotesArry = array($key11 => $ModuleIDval, $key4 => $OrderType, $key5 => $SalesOrder, $key6 => $DeliveryDate, $key10 => $InvoiceComment);

//$key8 => $PaymentMethod,

//$_GET['o']=$_GET['IN']
    /*     * *Special NOtes** */
} else {
    //$Infodata = array('Invoice Date' => $InvoiceDate, 'Received Date' => $ReceivedDate, 'Comments' => $InvoiceComment, 'Prepaid Freight' => $PrepaidFreight);
    $Infodata = array('Invoice Date' => $InvoiceDate, 'Invoice Number' => $ModulePDFID);
}

/* * info data IE==0* */
if($arryPurchase[0]['InvoiceEntry']==0 || $arryPurchase[0]['InvoiceEntry']==1){ //Line Item
	$PaydataArry = array('Required Date' => $ReceivedDate, 'Ship VIA' => $ShippingMethod, 'TERMS' => $PaymentTerm);
}else{ //GL
	
	if(!empty($arryPurchase[0]['SuppCode'])){
		$arrySupplier = $objSupplier->GetSupplier('',$arryPurchase[0]['SuppCode'],'');	
		$arryPurchase[0]['Address'] = $arrySupplier[0]['Address'];
		$arryPurchase[0]['SuppCompany'] = $arrySupplier[0]['CompanyName'];
		$arryPurchase[0]['City'] = $arrySupplier[0]['City'];
		$arryPurchase[0]['State'] = $arrySupplier[0]['State'];
		$arryPurchase[0]['Country'] = $arrySupplier[0]['Country'];
		$arryPurchase[0]['ZipCode'] = $arrySupplier[0]['ZipCode'];
		$arryPurchase[0]['SuppContact'] = $arrySupplier[0]['UserName'];
		$arryPurchase[0]['Mobile'] = $arrySupplier[0]['Mobile'];
		$arryPurchase[0]['Landline'] = $arrySupplier[0]['Landline'];
		$arryPurchase[0]['Email'] = $arrySupplier[0]['Email'];

	}
}

/* * **vendor Address*** */
$VATNAME=$CSTNAME=$TRNNAME='';
if($arryCurrentLocation[0]['country_id']=='106' || $arryCurrentLocation[0]['country_id']=='234'){
	$VATNAME=(!empty($arryPurchase[0]['VAT']))?('<br/>VAT No : '.$arryPurchase[0]['VAT']):('');
	$CSTNAME=(!empty($arryPurchase[0]['CST']))?('<br/>CST No : '.$arryPurchase[0]['CST']):('');
	$TRNNAME=(!empty($arryPurchase[0]['TRN']))?('<br/>TRN No : '.$arryPurchase[0]['TRN']):('');	 
}
$Address = (!empty($arryPurchase[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['Address']))) : ('');
$SuppCompany = (!empty($arryPurchase[0]['SuppCompany'])) ? (stripslashes($arryPurchase[0]['SuppCompany'])) : ('');
$City = (!empty($arryPurchase[0]['City'])) ? (stripslashes($arryPurchase[0]['City'])) : ('');
$State = (!empty($arryPurchase[0]['State'])) ? (stripslashes($arryPurchase[0]['State'])) : ('');
$Country = (!empty($arryPurchase[0]['Country'])) ? (stripslashes($arryPurchase[0]['Country'])) : ('');
$ZipCode = (!empty($arryPurchase[0]['ZipCode'])) ? (stripslashes($arryPurchase[0]['ZipCode'])) : ('');
$SuppContact = (!empty($arryPurchase[0]['SuppContact'])) ? (stripslashes($arryPurchase[0]['SuppContact'])) : ('');
//$Mobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : ('');
//added by Nisha for phone no pattern.
if(!empty($arryPurchase[0]['Mobile'])) {
    $arryPurchase[0]['Mobile'] = PhoneNumberFormat($arryPurchase[0]['Mobile']);
 }

//********** end of phone no pattern.
$Mobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : ('');
//added by Nisha for phone no pattern
if(!empty($arryPurchase[0]['Landline'])) {
   $arryPurchase[0]['Landline'] = PhoneNumberFormat($arryPurchase[0]['Landline']);
 }
$Landline = (!empty($arryPurchase[0]['Landline'])) ? (stripslashes($arryPurchase[0]['Landline'])) : ('&nbsp;');
$Email = (!empty($arryPurchase[0]['Email'])) ? (stripslashes($arryPurchase[0]['Email'])) : (NOT_MENTIONED);
$SuppCurrency = (!empty($arryPurchase[0]['SuppCurrency'])) ? (stripslashes($arryPurchase[0]['SuppCurrency'])) : ('');
$AddressHead1 = "VENDOR";
//$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
/* * **vendor Address*** 
if($arryCurrentLocation[0]['country_id']==106){
$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline, 'VAT TIN' => $VAT, 'CST No' => $CST);
}else{
$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
}*/
$Address=wordwrap($Address, 40, "<br />", true);

$SuppCompany=(!empty($SuppCompany)) ? ($SuppCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('');
$Country=(!empty($Country)) ? ($Country.'<br>') : ('');
$Mobile=(!empty($Mobile)) ? ($Mobile.',<br>') : ('');

$Address1 = array('' => $SuppCompany.$Address.$City.','.$State.'-'.$ZipCode.'<br>'.$Country.$Mobile.$Landline.$VATNAME.$CSTNAME.$TRNNAME);
/* * **Shipp to Address** */
$wAddress = (!empty($arryPurchase[0]['wAddress'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['wAddress']))) : ('');
$wCompany = (!empty($arryPurchase[0]['wName'])) ? (stripslashes($arryPurchase[0]['wName'])) : ('');
$wCity = (!empty($arryPurchase[0]['wCity'])) ? (stripslashes($arryPurchase[0]['wCity'])) : ('');
$wState = (!empty($arryPurchase[0]['wState'])) ? (stripslashes($arryPurchase[0]['wState'])) : ('');
$wCountry = (!empty($arryPurchase[0]['wCountry'])) ? (stripslashes($arryPurchase[0]['wCountry'])) : ('');
$wZipCode = (!empty($arryPurchase[0]['wZipCode'])) ? (stripslashes($arryPurchase[0]['wZipCode'])) : ('');
$wContact = (!empty($arryPurchase[0]['wContact'])) ? (stripslashes($arryPurchase[0]['wContact'])) : ('');
//$wMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : ('');
//added by Nisha for phone no pattern
if(!empty($arryPurchase[0]['wMobile'])) {
    $arryPurchase[0]['wMobile'] = PhoneNumberFormat($arryPurchase[0]['wMobile']);
 }

//**********end of phone no pattern
$wMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : ('');
//added by Nisha for phone no pattern
if(!empty($arryPurchase[0]['wLandline'])) {
    $arryPurchase[0]['wLandline'] = PhoneNumberFormat($arryPurchase[0]['wLandline']);
 }
//**********end of phone no pattern
$wLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : ('&nbsp;');
$wEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : ('');
$AddressHead2 = "SHIP TO";

/*
if($arryCurrentLocation[0]['country_id']==106){
$Address2 = array('Company Name' => $wCompany, 'Address' => $wAddress, 'City' => $wCity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Contact Name' => $wContact, 'Email' => $wEmail, 'Mobile' => $wMobile, 'Landline' => $wLandline, '&nbsp;' => '', '&nbsp;&nbsp;' => '');
}else{
$Address2 = array('Company Name' => $wCompany, 'Address' => $wAddress, 'City' => $wCity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Contact Name' => $wContact, 'Email' => $wEmail, 'Mobile' => $wMobile, 'Landline' => $wLandline);	
}*/
$wAddress=wordwrap($wAddress, 40, "<br />", true);

$wCompany=(!empty($wCompany)) ? ($wCompany.',<br>') : ('');
$wAddress=(!empty($wAddress)) ? ($wAddress.',<br>') : ('');
$wCountry=(!empty($wCountry)) ? ($wCountry.',<br>') : ('');
$wMobile=(!empty($wMobile)) ? ($wMobile.',<br>') : ('');

$Address2 = array('' => $wCompany.$wAddress.$wCity.','.$wState.'-'.$wZipCode.'<br>'.$wCountry.$wMobile.$wLandline);
//$Address2 = array('Company Name' => $wCompany, 'Address' => $wAddress, 'City' => $wCity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Contact Name' => $wContact, 'Email' => $wEmail, 'Mobile' => $wMobile, 'Landline' => $wLandline);
/* * **Shipp to Address** */


/* * *Taxable code** */
$Taxable = ($arryPurchase[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arryPurchase[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
}
/* * **Taxable code* */
?>
