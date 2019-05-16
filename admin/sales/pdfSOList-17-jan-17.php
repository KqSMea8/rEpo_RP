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
    echo '<pre>';print_r($arrySale);
    echo $arrySale[0]['ShippingMethodVal'];
    echo $arrySale[0]['ShippingMethod'];
    print_r($objConfigure);

    if(!empty($arrySale[0]['ShippingMethodVal'])){      
    $arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'],$arrySale[0]['ShippingMethodVal']);
       }
       print_r($arryShipMethodName);
       echo '<pre>';print_r($arrySaleItem);die;
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
//$Title = (!empty($arrySale[0][$ModuleID])) ? ($ModuleName . " # " . $arrySale[0][$ModuleID]) : ('Demo Title');
$Title = (!empty($arrySale[0][$ModuleID])) ? ($ModuleName) : ('Demo Title');
//$Title = $ModuleName." # ".$arrySale[0][$ModuleID];


/* * *Start Data for Order InFormation** */
$OrderDate = ($arrySale[0]['OrderDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arrySale[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arrySale[0]['Approved'] == 1) ? ('Yes') : ('No');

$DeliveryDate = ($arrySale[0]['DeliveryDate'] > 0) ? (date($_SESSION['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))) : (NOT_MENTIONED);

$PaymentTerm = (!empty($arrySale[0]['PaymentTerm'])) ? (stripslashes($arrySale[0]['PaymentTerm'])) : (NOT_MENTIONED);
$PaymentMethod = (!empty($arrySale[0]['PaymentMethod'])) ? (stripslashes($arrySale[0]['PaymentMethod'])) : (NOT_MENTIONED);
$ShippingMethod = (!empty($arrySale[0]['ShippingMethod'])) ? (stripslashes($arrySale[0]['ShippingMethod'])) : (NOT_MENTIONED);
$ShippingMethodval = (!empty($arrySale[0]['ShippingMethodVal'])) ? (stripslashes($arrySale[0]['ShippingMethodVal'])) : (NOT_MENTIONED);

if(!empty($arrySale[0]['ShippingMethodVal'])){      
    $arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'],$arrySale[0]['ShippingMethodVal']);
       }

//ShippingMethodVal
$Comment = (!empty($arrySale[0]['Comment'])) ? (stripslashes($arrySale[0]['Comment'])) : (NOT_MENTIONED);
$ModuleID = (!empty($arrySale[0][$ModuleID])) ? (stripslashes($arrySale[0][$ModuleID])) : (NOT_MENTIONED);
$Status = (!empty($arrySale[0]['Status'])) ? (stripslashes($arrySale[0]['Status'])) : (NOT_MENTIONED);
$CustomerName = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);
$ModulePDFID = $ModuleID;
/* * *Information data for sale** */
//$Infodata = array('Order Date' => $OrderDate, $ModuleIDTitle => $ModuleID, 'Customer' => $CustomerName, 'Order Status' => $Status, 'Sales Person' => $SalesPerson, 'Approved' => $Approved);
$Infodata = array('Order Date' => $OrderDate, $ModuleIDTitle => $ModuleID);
/* * *Information data for sale** */
$PaydataArry = array('Required Date' => $DeliveryDate, 'Ship VIA' => $arryShipMethodName[0]['service_type'], 'TERMS' => $PaymentTerm);

/* * start sales Pdf content* */

//billing address
$Address = (!empty($arrySale[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address']))) : ('');
$addlength1 = strlen($Address);
$Address = wordwrap($Address, 45, "<br />", true);
$BillCustomerCompany = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : ('');
$Billcity = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : ('');
$BillState = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : ('');
$BillCountry = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : ('');
$BillZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : ('');
$BillMobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
$BillLandline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : ('&nbsp;');
$BillEmail = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : ('');
$BillCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');
/* * *Billing Address for sale** */
$AddressHead1 = "BILLING";
$AddressHead2 = "SHIPPING";
//$Address1 = array('Company Name' => $BillCustomerCompany, 'Address' => $Address, 'City' => $Billcity, 'State' => $BillState, 'Country' => $BillCountry, 'Zip Code' => $BillZipCode, 'Email' => $BillEmail, 'Mobile' => $BillMobile, 'Landline' => $BillLandline);

/* * *Billing Address for sale** */

//shipping address
$ShippingAddress = (!empty($arrySale[0]['ShippingAddress'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress']))) : ('');
$addlength2 = strlen($ShippingAddress);
$ShippingAddress = wordwrap($ShippingAddress, 45, "<br />", true);
$ShippCustomerCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : ('');
$Shippcity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : ('');
$ShippState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : ('');
$ShippCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : ('');
$ShippZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : ('');
$ShippMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : ('');
$ShippLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : ('&nbsp;');
$ShippEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : ('');
$ShippCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');


/* * *Shipping Address for sale** */

$BillCustomerCompany=(!empty($BillCustomerCompany)) ? ($BillCustomerCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('&nbsp;<br>');
$BillCountry=(!empty($BillCountry)) ? ($BillCountry.',<br>') : ('&nbsp;<br>');
$BillMobile=(!empty($BillMobile)) ? ($BillMobile.',<br>'.$BillLandline) : ($BillLandline.'<br>&nbsp;');
$Billcity=(!empty($Billcity)) ? ($Billcity.',') : ('');
$BillState=(!empty($BillState)) ? ($BillState.'-') : ('');
//$BillMobile=(!empty($BillMobile)) ? ($BillMobile.',<br>')) : ('');
if ($addlength2 > 45 && $addlength1 < 45) {$Address1 = array('' => $BillCustomerCompany.$Address.'&nbsp;<br>'.$Billcity.$BillState.$BillZipCode.'<br>'.$BillCountry.$BillMobile);}
else{$Address1 = array('' => $BillCustomerCompany.$Address.$Billcity.$BillState.$BillZipCode.'<br>'.$BillCountry.$BillMobile);}



$ShippCustomerCompany=(!empty($ShippCustomerCompany)) ? ($ShippCustomerCompany.',<br>') : ('');
$ShippingAddress=(!empty($ShippingAddress)) ? ($ShippingAddress.',<br>') : ('&nbsp;<br>');
$ShippCountry=(!empty($ShippCountry)) ? ($ShippCountry.',<br>') : ('&nbsp;<br>');
$ShippMobile=(!empty($ShippMobile)) ? ($ShippMobile.',<br>'.$ShippLandline) : ($ShippLandline.'<br>&nbsp;');
$Shippcity=(!empty($Shippcity)) ? ($Shippcity.',') : ('');
$ShippState=(!empty($ShippState)) ? ($ShippState.'-') : ('');
if ($addlength2 < 45 && $addlength1 > 45) {$Address2 = array('' => $ShippCustomerCompany.$ShippingAddress.'<br>&nbsp;<br>'.$Shippcity.$ShippState.$ShippZipCode.'<br>'.$ShippCountry.$ShippMobile);
}
$Address2 = array('' => $ShippCustomerCompany.$ShippingAddress.$Shippcity.$ShippState.$ShippZipCode.'<br>'.$ShippCountry.$ShippMobile);



/*
$AddressHead2 = "SHIPPING";
if ($addlength2 > 45 && $addlength1 < 45) {
    //$Address1 = array('Company Name' => $BillCustomerCompany, 'Address' => $Address, 'City' => $Billcity, 'State' => $BillState, 'Country' => $BillCountry, 'Zip Code' => $BillZipCode, 'Email' => $BillEmail, 'Mobile' => $BillMobile, 'Landline' => $BillLandline,''=>'');
    
    
    $Address1 = array('' => $BillCustomerCompany.',<br>'.$Address.'<br>'.$Billcity.','.$BillState.'-'.$BillZipCode.'<br>'.$BillCountry.'<br>'.$BillMobile.'<br>'.$BillLandline);
}
else{
    //$Address1 = array('Company Name' => $BillCustomerCompany, 'Address' => $Address, 'City' => $Billcity, 'State' => $BillState, 'Country' => $BillCountry, 'Zip Code' => $BillZipCode, 'Email' => $BillEmail, 'Mobile' => $BillMobile, 'Landline' => $BillLandline);
    $Address1 = array('' => $BillCustomerCompany.',<br>'.$Address.'<br>'.$Billcity.','.$BillState.'-'.$BillZipCode.'<br>'.$BillCountry.'<br>'.$BillMobile.'<br>'.$BillLandline);
}
if ($addlength2 < 45 && $addlength1 > 45) {
    //$Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $ShippingAddress, 'City' => $Shippcity, 'State' => $ShippState, 'Country' => $ShippCountry, 'Zip Code' => $ShippZipCode, 'Email' => $ShippEmail, 'Mobile' => $ShippMobile, 'Landline' => $ShippLandline,''=>'');
    $Address2 = array('' => $ShippCustomerCompany.'<br>'.$ShippingAddress.'<br>'.$Shippcity.','.$ShippState.'-'.$ShippZipCode.'<br>'.$ShippCountry.'<br>'.$ShippMobile.'<br>'.$ShippLandline);
}else{
    //$Address2 = array('Company Name' => $ShippCustomerCompany, 'Address' => $ShippingAddress, 'City' => $Shippcity, 'State' => $ShippState, 'Country' => $ShippCountry, 'Zip Code' => $ShippZipCode, 'Email' => $ShippEmail, 'Mobile' => $ShippMobile, 'Landline' => $ShippLandline);
    $Address2 = array('' => $ShippCustomerCompany.'<br>'.$ShippingAddress.'<br>'.$Shippcity.','.$ShippState.'-'.$ShippZipCode.'<br>'.$ShippCountry.'<br>'.$ShippMobile.'<br>'.$ShippLandline);
}*/

/* * *Shipping Address for sale** */

/* * end sales Pdf content* */


/* * *Specail Notes** */
//$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Payment Term' => $PaymentTerm , 'Shipping Carrier' => $ShippingMethod, 'Comments' => $Comment);
//$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Comments' => $Comment);
$specialNotesArry = array('Comments' => $Comment);
/* * *Special NOtes** */
?>

