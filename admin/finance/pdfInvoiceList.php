<?php


//echo $Prefix;
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix . "classes/item.class.php");//sachin-3-feb

$objBankAccount=new BankAccount();
$objItem = new items();//sachin-3-feb


$objSale = new sale();

$module = 'Invoice';

$ModuleIDTitle = "Invoice Number";
$ModuleID = "InvoiceID";
$PrefixSO = "IN";
$NotExist = "Invalid Invoice";
$ModuleName = $module;

if (!empty($_GET['o'])) {
	unset($arrySlNo);
    unset($arrySale);
    unset($arrySaleItem);
    $arrySale = $objSale->GetSale($_GET['o'], '', $module);
    //echo '<pre>'; print_r($arrySale);die('innnnp');
    $OrderID = $arrySale[0]['OrderID'];
    $SaleID   = $arrySale[0]['SaleID'];

    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);

        $NumLine = sizeof($arrySaleItem);

        //get payment history
        $arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);

        $BankAccount='';
           
			if($arrySale[0]['PaymentTerm']=='Credit Card'){
					if($arrySale[0]['InvoiceEntry']=="1"){
						$arryCard = $objSale->GetSaleCreditCard($OrderID);
					}else if($arrySale[0]['InvoiceEntry']=="0" && !empty($SaleID)){
						$arryCard = $objSale->GetSaleCreditCard($OrderID);
						if(empty($arryCard[0]["CardType"])){
							$SaleOrderID = $objSale->getOrderIDBySaleID($SaleID);
							$arryCard = $objSale->GetSaleCreditCard($SaleOrderID);
						}
					}

					if(sizeof($arryCard)>0){
						$CreditCardFlag = 1;

						if($arrySale[0]['InvoicePaid'] == 'Unpaid' && $arrySale[0]['PostToGL'] != "1") {  

							/*********************/
							$TotalInvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];
							$PaymentTerm = $arrySale[0]['PaymentTerm'];
							$CardOrderID = $OrderID;
							//include_once("includes/html/box/edit_invoice_credit.php");
							/*********************/

							if($CreditCardFlag==1 && !empty($ProviderName) && $AmountToCharge>0){
								$HideEdit=0;
							}else{
								$HideEdit=1;
							}
				
						}

					}				 
				}else if(strtolower(trim($arrySale[0]['PaymentTerm']))=='prepayment' && !empty($arrySale[0]['AccountID'])){
						$arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
						$BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
				}



	if(empty($arryCard[0]['CardType']) && empty($arryCard[0]["CardNumber"])){
		$arryCard = $objConfigure->GetDefaultArrayValue('s_order_card');
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

/* * **************************************** */
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */

if($_GET['t']==1){
    echo '<pre>'; print_r($arrySale);die;
}
#FooterTextBox($pdf);
//TitlePage($arry, $pdf);
//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);
$ModulePDFID = $arrySale[0][$ModuleID];
//$Title = $ModuleName . " Number# " . $ModulePDFID;
$Title = 'AR '.$ModuleName;

//echo $Title.'<pre>'; print_r($arrySale);die('oooiop');

/* * *Start Data for Order InFormation** */
$OrderDate = ($arrySale[0]['OrderDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['OrderDate']))) : (NOT_MENTIONED);
$Approved = ($arrySale[0]['Approved'] == 1) ? ('Yes') : ('No');

$InvoiceDate = ($arrySale[0]['InvoiceDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))) : (NOT_MENTIONED);
$ShippedDate = ($arrySale[0]['ShippedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['ShippedDate']))) : (NOT_MENTIONED);
$InvoicePaidDate = (!empty($arrySale[0]['InvoicePaidDate'])) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['InvoicePaidDate']))) : (NOT_MENTIONED);
$PaidComment = (!empty($arrySale[0]['InvoicePaidComment'])) ? (stripslashes($arrySale[0]['InvoicePaidComment'])) : (NOT_MENTIONED);
$ShipFrom = (!empty($arrySale[0]['wName'])) ? (stripslashes($arrySale[0]['wName'])) : (NOT_MENTIONED);
$SONumber = (!empty($arrySale[0]['SaleID'])) ? (stripslashes($arrySale[0]['SaleID'])) : (NOT_MENTIONED);

$Customer = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);
$PaymentTerm = (!empty($arrySale[0]['PaymentTerm'])) ? (stripslashes($arrySale[0]['PaymentTerm'])) : (NOT_MENTIONED);
$PaymentMethod = (!empty($arrySale[0]['PaymentMethod'])) ? (stripslashes($arrySale[0]['PaymentMethod'])) : (NOT_MENTIONED);
$ShippingCarrier = (!empty($arrySale[0]['ShippingMethod'])) ? (stripslashes($arrySale[0]['ShippingMethod'])) : (NOT_MENTIONED);
$InvoiceComment = (!empty($arrySale[0]['InvoiceComment'])) ? (stripslashes($arrySale[0]['InvoiceComment'])) : (NOT_MENTIONED);
$InvoiceStatus = (!empty($arrySale[0]['InvoicePaid'])) ? (stripslashes($arrySale[0]['InvoicePaid'])) : (NOT_MENTIONED);


if($arrySale[0]['InvoicePaid']=='Unpaid' && $arrySale[0]['PaymentTerm']=='Credit Card' && ($arrySale[0]['OrderPaid']==1 || $arrySale[0]['OrderPaid']==4)){
						 $InvoiceStatus = 'Credit Card';
					}
 

$InvoiceOrderSource = (!empty($arrySale[0]['OrderSource'])) ? (stripslashes($arrySale[0]['OrderSource'])) : (NOT_MENTIONED);
$InvoiceFee = (!empty($arrySale[0]['Fee'])) ? (stripslashes($arrySale[0]['Fee'])) : (NOT_MENTIONED);
$TrackingNo = (!empty($arrySale[0]['TrackingNo'])) ? (stripslashes($arrySale[0]['TrackingNo'])) : (NOT_MENTIONED);
$customerPO=(!empty($arrySale[0]['CustomerPO'])) ? (stripslashes($arrySale[0]['CustomerPO'])) : (NOT_MENTIONED);

if (!empty($arrySale[0]['ShippingMethodVal'])) {
        $arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'], $arrySale[0]['ShippingMethodVal']);
    }

    $ShippingMethod=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):(NOT_SPECIFIED);
$CreatedBy=(!empty($arrySale[0]['CreatedBy'])) ? (stripslashes($arrySale[0]['CreatedBy'])) : ('');
 
if(strlen($CreatedBy)>20){
	$arrCreated = explode(" ",$CreatedBy);
	$CreatedBy = $arrCreated[0]." ".$arrCreated[1];
}

//$Infodata = array('Invoice Date' => $InvoiceDate, 'Ship Date' => $ShippedDate, 'Ship From' => $ShipFrom, 'SO Number' => $SONumber, 'Customer' => $Customer, 'Sales Person' => $SalesPerson , 'Fees' => $InvoiceFee);
$Infodata = array('Invoice Date' => $InvoiceDate, 'Inv No. &nbsp;' => $ModulePDFID,'Sales Person'=>$SalesPerson,'CreatedBy'=>$CreatedBy);
/* * *Start Data for Order InFormation** */
//$PaydataArry = array('Required Date' => $InvoicePaidDate, 'Ship VIA' => $ShippingMethod, 'TERMS' => $PaymentTerm);
$PaydataArry = array('Customer PO#' => $customerPO, 'Ship VIA' => $ShippingMethod, 'TERMS' => $PaymentTerm);


/* * ******* Billing******* */
$Address = (!empty($arrySale[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address']))) : ('');
//$Address2 = (!empty($arrySale[0]['$Address2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address2']))) : ('');
$CompanyName = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : ('');
$City = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : ('');
$State = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : ('');
$Country = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : ('');
$ZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : ('');
$ContactName = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact'])) : ('');
//$Mobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
//added by Nisha for phone number pattern
if(!empty($arrySale[0]['Mobile'])) {
   $arrySale[0]['Mobile'] = PhoneNumberFormat($arrySale[0]['Mobile']);
 }
//********** end of phone no pattern
$Mobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
//added by nisha for phone no pattern
if(!empty($arrySale[0]['Landline'])) {
    $arrySale[0]['Landline'] = PhoneNumberFormat($arrySale[0]['Landline']);
}

//****end of phone no pattern
$Landline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : ('&nbsp;');
$Email = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : ('');
$CustomerCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');
$AddressHead1 = "BILLING";
//$Address1 = array('Company Name' => $CompanyName, 'Address' => $Address . $Address2, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
/* * ******* Billing******* */

$VATNAME=$CSTNAME=$TRNNAME='';
if($arryCurrentLocation[0]['country_id']=='106' || $arryCurrentLocation[0]['country_id']=='234'){
	//$VATNAME=(!empty($arrySale[0]['VAT']))?('VAT No : '.$arrySale[0]['VAT'].'<br/>'):('');
	$CSTNAME=(!empty($arrySale[0]['CST']))?('CST No : '.$arrySale[0]['CST'].'<br/>'):('');
	$TRNNAME=(!empty($arrySale[0]['TRN']))?('TRN No : '.$arrySale[0]['TRN'].'<br/>'):('');
}

/*edit by sachin -2 jan-17
if($arryCurrentLocation[0]['country_id']==106){
$Address1 = array('Company Name' => $CompanyName, 'Address' => $Address . $Address2, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline, 'VAT TIN' => $VAT, 'CST No' => $CST, 'PAN No' => $PAN);
}else{
$Address1 = array('Company Name' => $CompanyName, 'Address' => $Address . $Address2, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);	
}*/
$Address=wordwrap($Address, 44, "<br />", true);
$CompanyName=(!empty($CompanyName)) ? ($CompanyName.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('');
$Country=(!empty($Country)) ? ($Country.'<br>') : ('');
$Mobile=(!empty($Mobile)) ? ($Mobile.',<br>') : ('');


$CustomerVAT = (!empty($arrySale[0]['VAT'])) ? ('<br>VAT: '.stripslashes($arrySale[0]['VAT']).'<br>') : ('');

/*********/


/*********/

$Address1 = array('' => $CompanyName.$Address.$City.','.$State.'-'.$ZipCode.'<br>'.$Country.$Mobile.$Landline.$CustomerVAT.$VATNAME.$CSTNAME.$TRNNAME );
/* * *******Shipping******* */
$ShippingAddress = (!empty($arrySale[0]['ShippingAddress'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress']))) : ('');
//$ShippingAddress2 = (!empty($arrySale[0]['ShippingAddress2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress2']))) : ('');
$ShippingCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : ('');
$ShippingCity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : ('');
$ShippingState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : ('');
$ShippingCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : ('');
$ShippingZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : ('');
//$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : ('');
//added by Nisha for phone no pattern
if(!empty($arrySale[0]['ShippingMobile'])) {
    $arrySale[0]['ShippingMobile'] = PhoneNumberFormat($arrySale[0]['ShippingMobile']);
 }
//**********end of phone no pattern.
$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : ('');
//added by Nisha for phone no pattern.
if(!empty($arrySale[0]['ShippingLandline'])) {
   $arrySale[0]['ShippingLandline'] = PhoneNumberFormat($arrySale[0]['ShippingLandline']);
 }

//**********end of phone no pattern.
$ShippingLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline'])) : ('&nbsp;');
$ShippingEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail'])) : ('');

$Taxable = ($arrySale[0]['tax_auths'] == "Yes") ? ("Yes") : ("No");
$arrRate = explode(":", $arrySale[0]['TaxRate']);
if (!empty($arrRate[0])) {
    $TaxVal = $arrRate[2] . ' %';
    $TaxName = '[' . $arrRate[1] . ']';
} else {
    $TaxVal = 'None';
}

$AddressHead2 = "SHIPPING";
//$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Email' => $ShippingEmail, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline);
//echo $Taxable.'oooo'.$TaxVal;die('iop')
/* * *******Shipping******* 
if($arryCurrentLocation[0]['country_id']==106){
$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Email' => $ShippingEmail, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline, '&nbsp;' => '', '&nbsp;&nbsp;' => '', '&nbsp;&nbsp;&nbsp;' => '');
}else{
$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Email' => $ShippingEmail, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline);
	
}*/
$ShippingAddress=wordwrap($ShippingAddress, 40, "<br />", true);

$ShippingCompany=(!empty($ShippingCompany)) ? ($ShippingCompany.',<br>') : ('');
$ShippingAddress=(!empty($ShippingAddress)) ? ($ShippingAddress.',<br>') : ('');
$ShippingCountry=(!empty($ShippingCountry)) ? ($ShippingCountry.',<br>') : ('');
$ShippingMobile=(!empty($ShippingMobile)) ? ($ShippingMobile.',<br>') : ('');

$Address2 = array('' => $ShippingCompany.$ShippingAddress.$ShippingCity.','.$ShippingState.'-'.$ShippingZipCode.'<br>'.$ShippingCountry.$ShippingMobile.$ShippingLandline);

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

$numCardTr=0;

if($OrderID>0 && $arrySale[0]['PaymentTerm']=='Credit Card'){

        if(!empty($SaleID)){
            $arryCardTransaction = $objSale->GetTransactionBySaleID($SaleID,$arrySale[0]['PaymentTerm']);
        }else{
            $arryCardTransaction = $objSale->GetSalesTransaction($OrderID,$arrySale[0]['PaymentTerm']);
        }

	$numCardTr = sizeof($arryCardTransaction);


}
/***Card Number Transaton **/
/* * *Specail Notes** */
//$specialNotesArry = array('Tracking No.'=> $TrackingNo,'Payment Term' => $PaymentTerm, 'Shipping Carrier' => $ShippingCarrier,'Shipping Method'=>$ShippingMethod, 'Invoice Comment' => $InvoiceComment, 'Invoice Status' => $InvoiceStatus, 'Tax Rate' => $TaxVal);
//$specialNotesArry = array('Tracking No.'=> $TrackingNo,'Payment Term' => $PaymentTerm, 'Shipping Carrier' => $ShippingCarrier,'Shipping Method'=>$ShippingMethod);
$specialNotesArry = array('Tracking No.'=> $TrackingNo);
//$_GET['o']=$_GET['IN']
/* * *Special NOtes** */

?>
