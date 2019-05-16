<?php

require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/finance.account.class.php");

$objBankAccount = new BankAccount();
$objSale = new sale();
$ModuleName = "Credit Memo";

if (!empty($_GET['o'])) {
    $arrySale = $objSale->GetSale($_GET['o'], '', 'Credit');
    $OrderID = $arrySale[0]['OrderID'];
    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);
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
if (!empty($arrySale[0]['CreatedByEmail'])) {
    $arryCompany[0]['Email'] = $arrySale[0]['CreatedByEmail'];
}
/* * **************************************** */
$ModulePDFID = $arrySale[0]["CreditID"];
$Title = 'AR Credit Memo';

if (empty($ModuleID)) {
    $ModuleIDTitle = "SO Number";
    $ModuleID = "SaleID";
}

(empty($SuppContact))?($SuppContact=""):(""); 

$PostedDate = ($arrySale[0]['PostedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['PostedDate']))) : ('');
$Approved = ($arrySale[0]['Approved'] == 1) ? ('Yes') : ('No');
$OrderPaid = $arrySale[0]['OrderPaid'];
#$ClosedDate = ($arrySale[0]['ClosedDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arrySale[0]['ClosedDate']))) : ('');

$Comment = (!empty($arrySale[0]['Comment'])) ? (stripslashes($arrySale[0]['Comment'])) : ('');
$CreditMemoID = (!empty($arrySale[0]["CreditID"])) ? (stripslashes($arrySale[0]["CreditID"])) : ('');
$CustomerName = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (''); //Status
$Status = (!empty($arrySale[0]["Status"])) ? (stripslashes($arrySale[0]["Status"])) : ('');
$BillCustomerCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');

$GLAccount = NOT_SPECIFIED;
        if (!empty($arrySale[0]['AccountID'])) {
            $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
            $GLAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
        }
/*        
if($_GET['rt']==1){
  echo '<pre>'; print_r($arrySale);die;  
}*/



if(!empty($arrySale[0]['InvoiceID'])) { 

$arryInvoice = $objSale->GetInvoice('',$arrySale[0]['InvoiceID'],"Invoice");
$InvOrderID = (!empty($arryInvoice[0]['OrderID']))?($arryInvoice[0]['OrderID']):("");
$PaymentTermInvoice = (!empty($arryInvoice[0]['PaymentTerm']))?($arryInvoice[0]['PaymentTerm']):(""); 

if($PaymentTermInvoice=="Credit Card"){
	$Config["CreditOrderID"] = $OrderID;
	$OrderID = $InvOrderID;
	$arrySale[0]['PaymentTerm'] = $arryInvoice[0]['PaymentTerm'];
	$arrySale[0]['SaleID'] = $arryInvoice[0]['SaleID'];

	$NumCardTransaction=0;

	if($OrderID>0 && $arrySale[0]['PaymentTerm']=='Credit Card'){
		if(!empty($SaleID)){
			$arryCardTransaction = $objSale->GetTransactionBySaleID($SaleID,$arrySale[0]['PaymentTerm']);
		}else{
			$arryCardTransaction = $objSale->GetSalesTransaction($OrderID,$arrySale[0]['PaymentTerm']);
		}
		$NumCardTransaction = sizeof($arryCardTransaction);
	} 




   }


}



if (empty($arrySale[0]['AccountID'])) {



   $ReSt=($arrySale[0]['ReSt']==1)?('Yes'):('No');


    $Infodata = array('Credit Memo ID' => $CreditMemoID, 'Customer' => $CustomerName, 'Posted Date' => $PostedDate, 'Approved' => $Approved, 'Status' => $Status );
    $specialNotesArry = array('Comments' => $Comment ,'Re-Stocking'=>$ReSt);
    /*     * **Billing Address*** */
    $Address = (!empty($arrySale[0]['Address1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address1']))) : ('');
    $BillAddress = (!empty($arrySale[0]['Address2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address2']))) : ('');
    $BillCompany = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany']).',<br>') : ('');
    $BillCity = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City']).',<br>') : ('');
    $BillState = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : ('');
    $BillCountry = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country']).',<br>') : ('');
    $BillZipcode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : ('');
    $BillContact = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact']).',<br>') : ('');
   // $BillMobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile']).',<br>') : ('');
				//added by Nisha for  phone no pattern
			if(!empty($arrySale[0]['Mobile'])) {
					$arrySale[0]['Mobile'] = PhoneNumberFormat($arrySale[0]['Mobile']);
			 }

			//**********end of phone no pattern
					$BillMobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile']).',<br>') : ('');
					//added by nisha for phone no pattern
			if(!empty($arrySale[0]['Landline'])) {
				 $arrySale[0]['Landline'] = PhoneNumberFormat($arrySale[0]['Landline']);
			}

//****end of phone no pattern
    $BillLandline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline']).',<br>') : ('');
    $BillEmail = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email']).',<br>') : ('');
    
$CustomerVAT = (!empty($arrySale[0]['VAT'])) ? ('VAT: '.stripslashes($arrySale[0]['VAT']).'<br>') : ('');


    $AddressHead1 = "Billing Address";

    #$Address1 = array('Company Name' => $BillCompany, 'Address' => $Address . $BillAddress, 'City' => $BillCity, 'State' => $BillState, 'Country' => $BillCountry, 'Zip Code' => $BillZipcode, 'Contact Name' => $BillContact, 'Email' => $BillEmail, 'Mobile' => $BillMobile, 'Landline' => $BillLandline);

   $Address1 = array('' => $BillCompany.$Address . $BillAddress.$BillCity.$BillState.'-'.$BillZipcode.'<br>'.$BillCountry.$BillMobile.$BillLandline.$CustomerVAT );


    /*     * **Billing Address*** */


    /*     * **Shipping Address*** */
    $ShippingAddress = (!empty($arrySale[0]['ShippingAddress1'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress1'])).',<br>') : ('');
    $ShippingAddress2 = (!empty($arrySale[0]['ShippingAddress2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress2'])).',<br>') : ('');
    $ShippingCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany']).',<br>') : ('');
    $ShippingCity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity']).',<br>') : ('');
    $ShippingState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : ('');
    $ShippingCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry']).',<br>') : ('');
    $ShippingZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : ('');
 
//$ShippingContact = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact']).',<br>') : ('');
    //$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile']).',<br>') : ('');
  //added by Nisha for phone no pattern
if(!empty($arrySale[0]['ShippingMobile'])) {
   $arrySale[0]['ShippingMobile'] = PhoneNumberFormat($arrySale[0]['ShippingMobile']);
 }

//**********end of phone no pattern
    $ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile']).',<br>') : ('');
    //added by Nisha for phone no pattern
if(!empty($arrySale[0]['ShippingLandline'])) {
   $arrySale[0]['ShippingLandline'] =PhoneNumberFormat($arrySale[0]['ShippingLandline']);
 }

//**********end of phone no
    $ShippingLandline = (!empty($arrySale[0]['ShippingLandline'])) ? (stripslashes($arrySale[0]['ShippingLandline']).',<br>') : ('');
    $ShippingEmail = (!empty($arrySale[0]['ShippingEmail'])) ? (stripslashes($arrySale[0]['ShippingEmail']).',<br>') : ('');
    $AddressHead2 = "Shipping Address";

    #$Address2 = array('Company Name' => $ShippingCompany, 'Address' => $ShippingAddress . $ShippingAddress2, 'City' => $ShippingCity, 'State' => $ShippingState, 'Country' => $ShippingCountry, 'Zip Code' => $ShippingZipCode, 'Contact Name' => $SuppContact, 'Email' => $ShippingEmail, 'Mobile' => $ShippingMobile, 'Landline' => $ShippingLandline);

	$Address2 = array('' => $ShippingCompany.$ShippingAddress.$ShippingAddress2.$ShippingCity.$ShippingState.'-'.$ShippingZipCode.'<br>'.$ShippingCountry.$ShippingMobile.$ShippingLandline);
 
    /*     * **Billing Address*** */
} else {
    $Infodata = array('Credit Memo ID' => $CreditMemoID, 'Customer' => $CustomerName, 'Posted Date' => $PostedDate, 'Approved' => $Approved, 'Status' => $Status , 'Comments' => $Comment); //,'GL Account'=>$GLAccount
}
?>
