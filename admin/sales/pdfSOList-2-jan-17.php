<?php

require_once($Prefix . "classes/sales.quote.order.class.php");

$objSale = new sale();
(!$_GET['module']) ? ($_GET['module'] = 'Quote') : ("");
$module = $_GET['module'];


if ($module == 'Quote') {
    $ModuleIDTitle = "Quote Number";
    $ModuleID = "QuoteID";
    $PrefixSO = "QT";
    $NotExist = NOT_EXIST_QUOTE;
} else {
    $ModuleIDTitle = "SO Number";
    $ModuleID = "SaleID";
    $PrefixSO = "SO";
    $NotExist = NOT_EXIST_ORDER;
}
if(empty($_GET['PickingSheet']))$_GET['PickingSheet']='';
//$ModuleName = "Sales " . $module;

$ModuleName=($_GET['PickingSheet']=='PickingSheet')?("PickingSheet " . $module):("Sales " . $module);
$recordpdftemp = array();
if ((!empty($_GET['o'])) || (!empty($_GET['sop']))) {
    
    $arrySale = $objSale->GetSale($_GET['o'], $_GET['sop'], $module);

    $OrderID = $arrySale[0]['OrderID'];
    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);
    } else {
        $ErrorMSG = $NotExist;
    }
    if($_GET[t]==1){
    //echo $_GET['sop'].$module;
    //echo '<pre>';print_r($arrySale);
    //echo '<pre>';print_r($arrySaleItem);
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
//echo '<pre>'; print_r($arrySale);die;
$Title = (!empty($arrySale[0][$ModuleID])) ? ($ModuleName . " # " . $arrySale[0][$ModuleID]) : ('Demo Title');
//$Title = $ModuleName." # ".$arrySale[0][$ModuleID];


/* * *Start Data for Order InFormation** */
$OrderDate = ($arrySale[0]['OrderDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arrySale[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arrySale[0]['Approved'] == 1) ? ('Yes') : ('No');

$DeliveryDate = ($arrySale[0]['DeliveryDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))) : (NOT_MENTIONED);

$PaymentTerm = (!empty($arrySale[0]['PaymentTerm'])) ? (stripslashes($arrySale[0]['PaymentTerm'])) : (NOT_MENTIONED);
$PaymentMethod = (!empty($arrySale[0]['PaymentMethod'])) ? (stripslashes($arrySale[0]['PaymentMethod'])) : (NOT_MENTIONED);
$ShippingMethod = (!empty($arrySale[0]['ShippingMethod'])) ? (stripslashes($arrySale[0]['ShippingMethod'])) : (NOT_MENTIONED);
$Comment = (!empty($arrySale[0]['Comment'])) ? (stripslashes($arrySale[0]['Comment'])) : (NOT_MENTIONED);
$ModuleID = (!empty($arrySale[0][$ModuleID])) ? (stripslashes($arrySale[0][$ModuleID])) : (NOT_MENTIONED);
$Status = (!empty($arrySale[0]['Status'])) ? (stripslashes($arrySale[0]['Status'])) : (NOT_MENTIONED);
$CustomerName = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);
$ModulePDFID = $ModuleID;
/* * *Information data for sale** */
$Infodata = array('Order Date' => $OrderDate, $ModuleIDTitle => $ModuleID, 'Customer' => $CustomerName, 'Order Status' => $Status, 'Sales Person' => $SalesPerson, 'Approved' => $Approved);
/* * *Information data for sale** */

/* * start sales Pdf content* */

//billing address
$Address = (!empty($arrySale[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address']))) : (NOT_MENTIONED);
$addlength1 = strlen($Address);
$Address = wordwrap($Address, 45, "<br />", true);
$BillCustomerCompany = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : (NOT_MENTIONED);
$Billcity = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : (NOT_MENTIONED);
$BillState = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : (NOT_MENTIONED);
$BillCountry = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : (NOT_MENTIONED);
$BillZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : (NOT_MENTIONED);
$BillMobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : (NOT_MENTIONED);
$BillLandline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : (NOT_MENTIONED);
$BillEmail = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : (NOT_MENTIONED);
$BillCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : (NOT_MENTIONED);
/* * *Billing Address for sale** */
$AddressHead1 = "Billing Address";
//$Address1 = array('Company Name' => $BillCustomerCompany, 'Address' => $Address, 'City' => $Billcity, 'State' => $BillState, 'Country' => $BillCountry, 'Zip Code' => $BillZipCode, 'Email' => $BillEmail, 'Mobile' => $BillMobile, 'Landline' => $BillLandline);

/* * *Billing Address for sale** */

//shipping address
$ShippingAddress = (!empty($arrySale[0]['ShippingAddress'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress']))) : (NOT_MENTIONED);
$addlength2 = strlen($ShippingAddress);
$ShippingAddress = wordwrap($ShippingAddress, 45, "<br />", true);
$ShippCustomerCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : (NOT_MENTIONED);
$Shippcity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : (NOT_MENTIONED);
$ShippState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : (NOT_MENTIONED);
$ShippCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : (NOT_MENTIONED);
$ShippZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : (NOT_MENTIONED);
$ShippMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : (NOT_MENTIONED);
$ShippLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : (NOT_MENTIONED);
$ShippEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : (NOT_MENTIONED);
$ShippCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : (NOT_MENTIONED);

/* * *Shipping Address for sale** */
$AddressHead2 = "Shipping Address";
if ($addlength2 > 45 && $addlength1 < 45) {
    $Address1 = array('Company Name' => $BillCustomerCompany, 'Address' => $Address, 'City' => $Billcity, 'State' => $BillState, 'Country' => $BillCountry, 'Zip Code' => $BillZipCode, 'Email' => $BillEmail, 'Mobile' => $BillMobile, 'Landline' => $BillLandline,''=>'');
}
else{
    $Address1 = array('Company Name' => $BillCustomerCompany, 'Address' => $Address, 'City' => $Billcity, 'State' => $BillState, 'Country' => $BillCountry, 'Zip Code' => $BillZipCode, 'Email' => $BillEmail, 'Mobile' => $BillMobile, 'Landline' => $BillLandline);
}
if ($addlength2 < 45 && $addlength1 > 45) {
    $Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $ShippingAddress, 'City' => $Shippcity, 'State' => $ShippState, 'Country' => $ShippCountry, 'Zip Code' => $ShippZipCode, 'Email' => $ShippEmail, 'Mobile' => $ShippMobile, 'Landline' => $ShippLandline,''=>'');
}else{
    $Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $ShippingAddress, 'City' => $Shippcity, 'State' => $ShippState, 'Country' => $ShippCountry, 'Zip Code' => $ShippZipCode, 'Email' => $ShippEmail, 'Mobile' => $ShippMobile, 'Landline' => $ShippLandline);
}

/* * *Shipping Address for sale** */

/* * end sales Pdf content* */


/* * *Specail Notes** */
$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Payment Term' => $PaymentTerm , 'Shipping Carrier' => $ShippingMethod, 'Comments' => $Comment);
/* * *Special NOtes** */
?>

