<?php

require_once($Prefix . "classes/purchase.class.php");
$objPurchase = new purchase();




$ModuleName = "Invoice";

if (!empty($_GET['o'])) {
    $arryPurchase = $objPurchase->GetPurchase($_GET['o'], '', 'Invoice');
    $OrderID = $arryPurchase[0]['OrderID'];
    if ($OrderID > 0) {
        $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $NumLine = sizeof($arryPurchaseItem);

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
$Title = $ModuleName . " # " . $ModulePDFID;


/* * infodata* */
$InvoiceDate = ($arryPurchase[0]['PostedDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))) : (NOT_MENTIONED);
$ReceivedDate = ($arryPurchase[0]['ReceivedDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))) : (NOT_MENTIONED);
$PaymentDate = ($arryPurchase[0]['PaymentDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))) : (NOT_MENTIONED);
$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1) ? ('Yes') : ('No');
$InvoiceComment = (!empty($arryPurchase[0]['InvoiceComment'])) ? (stripslashes($arryPurchase[0]['InvoiceComment'])) : (NOT_MENTIONED);
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
    $OrderDate = ($arryPurchase[0]['OrderDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))) : (NOT_MENTIONED);
    $Approved = ($arryPurchase[0]['Approved'] == 1) ? ('Yes') : ('No');

    $DeliveryDate = ($arryPurchase[0]['DeliveryDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))) : (NOT_MENTIONED);

    $PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm'])) ? (stripslashes($arryPurchase[0]['PaymentTerm'])) : (NOT_MENTIONED);
    $PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod'])) ? (stripslashes($arryPurchase[0]['PaymentMethod'])) : (NOT_MENTIONED);
    $ShippingCarrier = (!empty($arryPurchase[0]['ShippingMethod'])) ? (stripslashes($arryPurchase[0]['ShippingMethod'])) : (NOT_MENTIONED);
    $Comment = (!empty($arryPurchase[0]['Comment'])) ? (stripslashes($arryPurchase[0]['Comment'])) : (NOT_MENTIONED);
    $AssignedEmp = (!empty($arryPurchase[0]['AssignedEmp'])) ? (stripslashes($arryPurchase[0]['AssignedEmp'])) : (NOT_MENTIONED);
    $Status = (!empty($arryPurchase[0]['Status'])) ? (stripslashes($arryPurchase[0]['Status'])) : (NOT_MENTIONED);
    $OrderType = (!empty($arryPurchase[0]['OrderType'])) ? (stripslashes($arryPurchase[0]['OrderType'])) : (NOT_MENTIONED);
    $SalesOrder = (!empty($arryPurchase[0]['SaleID'])) ? (stripslashes($arryPurchase[0]['SaleID'])) : (NOT_MENTIONED);
    $ModuleIDval = (!empty($arryPurchase[0][$ModuleID])) ? (stripslashes($arryPurchase[0][$ModuleID])) : (NOT_MENTIONED);
    $Infodata = array('Invoice Date' => $InvoiceDate, 'Received Date' => $ReceivedDate, 'Comments' => $InvoiceComment, $key1 => $OrderDate, $key2 => $Approved, $key3 => $Status, 'Prepaid Freight' => $PrepaidFreight);
    /*     * *Specail Notes** */
    $specialNotesArry = array($key11 => $ModuleIDval, $key4 => $OrderType, $key5 => $SalesOrder, $key6 => $DeliveryDate, $key7 => $PaymentTerm,  $key9 => $ShippingMethod, $key10 => $Comment,'Shipping Carrier'=>$ShippingCarrier);

//$key8 => $PaymentMethod,

//$_GET['o']=$_GET['IN']
    /*     * *Special NOtes** */
} else {
    $Infodata = array('Invoice Date' => $InvoiceDate, 'Received Date' => $ReceivedDate, 'Comments' => $InvoiceComment, 'Prepaid Freight' => $PrepaidFreight);
}

/* * info data IE==0* */



/* * **vendor Address*** */
if($arryCurrentLocation[0]['country_id']==106){
			if(!empty($arryPurchase[0]['VAT']) || ($arryPurchase[0]['CST'])){
				$VAT= $arryPurchase[0]['VAT'];
				$CST= $arryPurchase[0]['CST'];
			}else{
				$VAT = NOT_MENTIONED;
				$CST = NOT_MENTIONED;
			}
}
$Address = (!empty($arryPurchase[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['Address']))) : (NOT_MENTIONED);
$SuppCompany = (!empty($arryPurchase[0]['SuppCompany'])) ? (stripslashes($arryPurchase[0]['SuppCompany'])) : (NOT_MENTIONED);
$City = (!empty($arryPurchase[0]['City'])) ? (stripslashes($arryPurchase[0]['City'])) : (NOT_MENTIONED);
$State = (!empty($arryPurchase[0]['State'])) ? (stripslashes($arryPurchase[0]['State'])) : (NOT_MENTIONED);
$Country = (!empty($arryPurchase[0]['Country'])) ? (stripslashes($arryPurchase[0]['Country'])) : (NOT_MENTIONED);
$ZipCode = (!empty($arryPurchase[0]['ZipCode'])) ? (stripslashes($arryPurchase[0]['ZipCode'])) : (NOT_MENTIONED);
$SuppContact = (!empty($arryPurchase[0]['SuppContact'])) ? (stripslashes($arryPurchase[0]['SuppContact'])) : (NOT_MENTIONED);
$Mobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : (NOT_MENTIONED);
$Landline = (!empty($arryPurchase[0]['Landline'])) ? (stripslashes($arryPurchase[0]['Landline'])) : (NOT_MENTIONED);
$Email = (!empty($arryPurchase[0]['Email'])) ? (stripslashes($arryPurchase[0]['Email'])) : (NOT_MENTIONED);
$SuppCurrency = (!empty($arryPurchase[0]['SuppCurrency'])) ? (stripslashes($arryPurchase[0]['SuppCurrency'])) : (NOT_MENTIONED);
$AddressHead1 = "Vendor Address";
//$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
/* * **vendor Address*** */
if($arryCurrentLocation[0]['country_id']==106){
$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline, 'VAT TIN' => $VAT, 'CST No' => $CST);
}else{
$Address1 = array('Company Name' => $SuppCompany, 'Address' => $Address, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Contact Name' => $SuppContact, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
}
/* * **Shipp to Address** */
$wAddress = (!empty($arryPurchase[0]['wAddress'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['wAddress']))) : (NOT_MENTIONED);
$wCompany = (!empty($arryPurchase[0]['wName'])) ? (stripslashes($arryPurchase[0]['wName'])) : (NOT_MENTIONED);
$wCity = (!empty($arryPurchase[0]['wCity'])) ? (stripslashes($arryPurchase[0]['wCity'])) : (NOT_MENTIONED);
$wState = (!empty($arryPurchase[0]['wState'])) ? (stripslashes($arryPurchase[0]['wState'])) : (NOT_MENTIONED);
$wCountry = (!empty($arryPurchase[0]['wCountry'])) ? (stripslashes($arryPurchase[0]['wCountry'])) : (NOT_MENTIONED);
$wZipCode = (!empty($arryPurchase[0]['wZipCode'])) ? (stripslashes($arryPurchase[0]['wZipCode'])) : (NOT_MENTIONED);
$wContact = (!empty($arryPurchase[0]['wContact'])) ? (stripslashes($arryPurchase[0]['wContact'])) : (NOT_MENTIONED);
$wMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : (NOT_MENTIONED);
$wLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : (NOT_MENTIONED);
$wEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : (NOT_MENTIONED);
$AddressHead2 = "Ship-To Address";
if($arryCurrentLocation[0]['country_id']==106){
$Address2 = array('Company Name' => $wCompany, 'Address' => $wAddress, 'City' => $wCity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Contact Name' => $wContact, 'Email' => $wEmail, 'Mobile' => $wMobile, 'Landline' => $wLandline, '&nbsp;' => '', '&nbsp;&nbsp;' => '');
}else{
$Address2 = array('Company Name' => $wCompany, 'Address' => $wAddress, 'City' => $wCity, 'State' => $wState, 'Country' => $wCountry, 'Zip Code' => $wZipCode, 'Contact Name' => $wContact, 'Email' => $wEmail, 'Mobile' => $wMobile, 'Landline' => $wLandline);	
}
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
