<?php

require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix . "classes/item.class.php");//sachin-3-feb

$objSale = new sale();
$objBankAccount=new BankAccount();
$objItem = new items();//sachin-3-feb
(!$_GET['module']) ? ($_GET['module'] = 'Quote') : ("");
$module = $_GET['module'];
/****************/
 
(empty($_GET['sop']))?($_GET['sop']=""):("");
(empty($_GET['o']))?($_GET['o']=""):("");

/****************/
if ($module == 'Quote') {
    $ModuleIDTitle = "Quote Number";
    $ModuleID = "QuoteID";
    $PrefixSO = "QT";
    $NotExist = "This sales quote no longer exist in the database.";
} else {
    $ModuleIDTitle = "SO Number";
    $ModuleID = "SaleID";
    $PrefixSO = "SO";
    $NotExist = "This sales order no longer exist in the database.";
}
if(empty($_GET['PickingSheet']))$_GET['PickingSheet']='';
//$ModuleName = "Sales " . $module;

$ModuleName=($_GET['PickingSheet']=='PickingSheet')?("PickingSheet "):("Sales " . $module);
$recordpdftemp = array();
if ((!empty($_GET['o'])) || (!empty($_GET['sop']))) {
    
    $arrySale = $objSale->GetSale($_GET['o'], $_GET['sop'], $module);

    $OrderID = $arrySale[0]['OrderID'];
    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);

        $BankAccount='';
            if($arrySale[0]['PaymentTerm']=='Credit Card'){
                $arryCard = $objSale->GetSaleCreditCard($OrderID);
                if(sizeof($arryCard)>0){
                    $CreditCardFlag = 1;
                }
                 
            }else if(strtolower(trim($arrySale[0]['PaymentTerm']))=='prepayment' && !empty($arrySale[0]['AccountID'])){
                $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
                $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
            }
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

if(empty($arryCard[0]['CardType']) && empty($arryCard[0]["CardNumber"])){
		$arryCard = $objConfigure->GetDefaultArrayValue('s_order_card');
	}


if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */
//echo '<pre>'; print_r($arrySale);die;
//$Title = (!empty($arrySale[0][$ModuleID])) ? ($ModuleName . " # " . $arrySale[0][$ModuleID]) : ('Demo Title');
$Title = (!empty($arrySale[0][$ModuleID])) ? ($ModuleName) : ('Demo Title');
//$Title = $ModuleName." # ".$arrySale[0][$ModuleID];


/* * *Start Data for Order InFormation** */
$OrderDate = ($arrySale[0]['OrderDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arrySale[0]['Approved'] == 1) ? ('Yes') : ('No');

$DeliveryDate = ($arrySale[0]['DeliveryDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))) : (NOT_MENTIONED);

$PaymentTerm = (!empty($arrySale[0]['PaymentTerm'])) ? (stripslashes($arrySale[0]['PaymentTerm'])) : (NOT_MENTIONED);
$OrderPaid=(!empty($arrySale[0]['OrderPaid'])) ? (stripslashes($arrySale[0]['OrderPaid'])) : (NOT_MENTIONED);
$PaymentMethod = (!empty($arrySale[0]['PaymentMethod'])) ? (stripslashes($arrySale[0]['PaymentMethod'])) : (NOT_MENTIONED);
$ShippingMethod = (!empty($arrySale[0]['ShippingMethod'])) ? (stripslashes($arrySale[0]['ShippingMethod'])) : (NOT_MENTIONED);
$ShippingMethodval = (!empty($arrySale[0]['ShippingMethodVal'])) ? (stripslashes($arrySale[0]['ShippingMethodVal'])) : (NOT_MENTIONED);

if(!empty($arrySale[0]['ShippingMethodVal'])){      
    $arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'],$arrySale[0]['ShippingMethodVal']);
       }
$Comment ='';
//ShippingMethodVal
//$Comment = (!empty($arrySale[0]['Comment'])) ? (stripslashes($arrySale[0]['Comment'])) : (NOT_MENTIONED);
$MultiComment = explode("##",$arrySale[0]['Comment']);

if(empty($MultiComment[1]) && !empty($MultiComment[0])){
    $Comment = stripslashes($arrySale[0]['Comment']);
}else{
    if(!empty($arrySale[0]['Comment'])){
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

$ModuleID = (!empty($arrySale[0][$ModuleID])) ? (stripslashes($arrySale[0][$ModuleID])) : (NOT_MENTIONED);
$Status = (!empty($arrySale[0]['Status'])) ? (stripslashes($arrySale[0]['Status'])) : (NOT_MENTIONED);
$CustomerName = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);

$customerPO=(!empty($arrySale[0]['CustomerPO'])) ? (stripslashes($arrySale[0]['CustomerPO'])) : (NOT_MENTIONED);
$ModulePDFID = $ModuleID;
$CreatedBy=(!empty($arrySale[0]['CreatedBy'])) ? (stripslashes($arrySale[0]['CreatedBy'])) : (NOT_MENTIONED);
/* * *Information data for sale** */
//$Infodata = array('Order Date' => $OrderDate, $ModuleIDTitle => $ModuleID, 'Customer' => $CustomerName, 'Order Status' => $Status, 'Sales Person' => $SalesPerson, 'Approved' => $Approved);
$Infodata = array('Order Date' => $OrderDate, $ModuleIDTitle => $ModuleID,'Sales Person'=>$SalesPerson,'CreatedBy'=>$CreatedBy);
/* * *Information data for sale** */
//$PaydataArry = array('Required Date' => $DeliveryDate, 'Ship VIA' => $arryShipMethodName[0]['service_type'], 'TERMS' => $PaymentTerm);
if(empty($arryShipMethodName[0]['service_type'])) $arryShipMethodName[0]['service_type']='';
$PaydataArry = array('Customer PO#' => $customerPO, 'Ship VIA' => $arryShipMethodName[0]['service_type'], 'TERMS' => $PaymentTerm);

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
if(!empty($arrySale[0]['Mobile'])) {
   $arrySale[0]['Mobile'] = PhoneNumberFormat($arrySale[0]['Mobile']);
 }
$BillMobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
if(!empty($arrySale[0]['Landline'])) {
    $arrySale[0]['Landline'] = PhoneNumberFormat($arrySale[0]['Landline']);
}
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

if(!empty($arrySale[0]['ShippingMobile'])) {
    $arrySale[0]['ShippingMobile'] = PhoneNumberFormat($arrySale[0]['ShippingMobile']);
 }
 $ShippMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : ('');
 
 if(!empty($arrySale[0]['ShippingLandline'])) {
   $arrySale[0]['ShippingLandline'] = PhoneNumberFormat($arrySale[0]['ShippingLandline']);
 }
$ShippLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : ('&nbsp;');
$ShippEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : ('');
$ShippCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');


/**code for vat field***/
$CustomerVAT = (!empty($arrySale[0]['VAT'])) ? ('VAT: '.stripslashes($arrySale[0]['VAT']).'<br>') : ('');
 

/**code for vat field***/

/* * *Shipping Address for sale** */

$BillCustomerCompany=(!empty($BillCustomerCompany)) ? ($BillCustomerCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('&nbsp;<br>');
$BillCountry=(!empty($BillCountry)) ? ($BillCountry.',<br>') : ('&nbsp;<br>');
$BillMobile=(!empty($BillMobile)) ? ($BillMobile.',<br>'.$BillLandline) : ($BillLandline.'<br>&nbsp;');
$Billcity=(!empty($Billcity)) ? ($Billcity.',') : ('');
$BillState=(!empty($BillState)) ? ($BillState.'-') : ('');
//$BillMobile=(!empty($BillMobile)) ? ($BillMobile.',<br>')) : ('');

 

if ($addlength2 > 45 && $addlength1 < 45) {
	$Address1 = array('' => $BillCustomerCompany.$Address.'&nbsp;<br>'.$Billcity.$BillState.$BillZipCode.'<br>'.$BillCountry.$BillMobile.$CustomerVAT);
}
else{
	$Address1 = array('' => $BillCustomerCompany.$Address.$Billcity.$BillState.$BillZipCode.'<br>'.$BillCountry.$BillMobile.$CustomerVAT);
}



$ShippCustomerCompany=(!empty($ShippCustomerCompany)) ? ($ShippCustomerCompany.',<br>') : ('');
$ShippingAddress=(!empty($ShippingAddress)) ? ($ShippingAddress.',<br>') : ('&nbsp;<br>');
$ShippCountry=(!empty($ShippCountry)) ? ($ShippCountry.',<br>') : ('&nbsp;<br>');
$ShippMobile=(!empty($ShippMobile)) ? ($ShippMobile.',<br>'.$ShippLandline) : ($ShippLandline.'<br>&nbsp;');
$Shippcity=(!empty($Shippcity)) ? ($Shippcity.',') : ('');
$ShippState=(!empty($ShippState)) ? ($ShippState.'-') : ('');
if ($addlength2 < 45 && $addlength1 > 45) {
    $Address2 = array('' => $ShippCustomerCompany.$ShippingAddress.'<br>&nbsp;<br>'.$Shippcity.$ShippState.$ShippZipCode.'<br>'.$ShippCountry.$ShippMobile);
} else {
$Address2 = array('' => $ShippCustomerCompany.$ShippingAddress.$Shippcity.$ShippState.$ShippZipCode.'<br>'.$ShippCountry.$ShippMobile);
}



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

/***Card Number Transaton **/
$CreditCardNumber='';
if(!empty($arryCard[0]["CardNumber"])){
	$arryCardNumber = explode("-",$arryCard[0]["CardNumber"]);

	if($arryCard[0]['CardType']=="Amex"){
	    $CreditCardNumber = $arryCardNumber[2];
	}else{
	    $CreditCardNumber = $arryCardNumber[3];
	}
}
$CardType=stripslashes($arryCard[0]['CardType']);
$CardExpiry=stripslashes($arryCard[0]['ExpiryMonth']).'-'.stripslashes($arryCard[0]['ExpiryYear']);
$TransatonData='';

if($OrderID>0 && $arrySale[0]['PaymentTerm']=='Credit Card'){

        if(!empty($SaleID)){
            $arryCardTransaction = $objSale->GetTransactionBySaleID($SaleID,$arrySale[0]['PaymentTerm']);
        }else{
            $arryCardTransaction = $objSale->GetSalesTransaction($OrderID,$arrySale[0]['PaymentTerm']);
        }




        }
/***Card Number Transaton **/
/* * *Specail Notes** */
//$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Payment Term' => $PaymentTerm , 'Shipping Carrier' => $ShippingMethod, 'Comments' => $Comment);
//$specialNotesArry = array('Delivery Date' => $DeliveryDate, 'Comments' => $Comment);
$Comment = wordwrap($Comment, 60, "<br />", true);
//$specialNotesArry = array('Comments' => $Comment,'Card Type'=>$CardType, 'CreditCard Number'=>$CreditCardNumber,'Card Expiry'=>$CardExpiry);
$specialNotesArry = array('Comments' => $Comment);
/* * *Special NOtes** */



?>

