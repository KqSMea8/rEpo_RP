<?php

	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	
	$objCustomer = new Customer(); 
	$objSale = new sale();
	$objBankAccount= new BankAccount();	

	$module = 'Invoice';
	
	$ModuleIDTitle = "Invoice Number";
	$ModuleID = "InvoiceID";
	$PrefixSO = "IN";
	$NotExist = "Invalid Invoice";
	$ModuleName = $module;

/******************************************/
$arrySale = $objSale->GetSale($_GET['o'],'',$module);
$_GET['IncomeID'] = $arrySale[0]['IncomeID'];	
$ModulePDFID = $arrySale[0][$ModuleID];
$Title = 'AR '.$ModuleName;

if($_GET['IncomeID']>0){		 
	$arryOtherIncome=$objBankAccount->getOtherIncomeGL($_GET);
	if($arryOtherIncome[0]['GlEntryType']=="Multiple"){
  		$arryMultiAccount=$objBankAccount->getMultiAccountgl($_GET['IncomeID']);
	} 
}	

/* single */
 $InvoiceID = (!empty($arryOtherIncome[0]['InvoiceID'])) ? (stripslashes($arryOtherIncome[0]['InvoiceID'])) : (NOT_MENTIONED);
 $CustomerName = (!empty($arrySale[0]['CustomerName'])) ? (stripslashes($arrySale[0]['CustomerName'])) : (NOT_MENTIONED);
 $InvoiceAmount = (!empty($arryOtherIncome[0]['Amount'])) ? (stripslashes(number_format($arryOtherIncome[0]['Amount'],2))) : (NOT_MENTIONED);
 $Currency = (!empty($arryOtherIncome[0]['Currency'])) ? (stripslashes($arryOtherIncome[0]['Currency'])) : (NOT_MENTIONED);
 $GlEntryType = (!empty($arryOtherIncome[0]['GlEntryType'])) ? (stripslashes($arryOtherIncome[0]['GlEntryType'])) : (NOT_MENTIONED);
if($arryOtherIncome[0]["IncomeTypeID"]>0){
$arryAccountName = $objBankAccount->getAccountNameByID($arryOtherIncome[0]["IncomeTypeID"]);
$GlAccount = $arryAccountName[0]['AccountName'].' ['.$arryAccountName[0]['AccountNumber'].']';
}
$InvoiceDate = ($arryOtherIncome[0]['PaymentDate'] > 0) ? (date($arryCompany[0]['DateFormat'], strtotime($arryOtherIncome[0]['PaymentDate']))) : (NOT_MENTIONED);
$InvoiceComment = (!empty($arrySale[0]['InvoiceComment'])) ? (stripslashes($arrySale[0]['InvoiceComment'])) : (NOT_MENTIONED);

$SalesPerson = (!empty($arrySale[0]['SalesPerson'])) ? (stripslashes($arrySale[0]['SalesPerson'])) : (NOT_MENTIONED);
$CreatedBy=(!empty($arrySale[0]['CreatedBy'])) ? (stripslashes($arrySale[0]['CreatedBy'])) : ('');
if(strlen($CreatedBy)>20){
	$arrCreated = explode(" ",$CreatedBy);
	$CreatedBy = $arrCreated[0]." ".$arrCreated[1];
}

$customerPO=(!empty($arrySale[0]['CustomerPO'])) ? (stripslashes($arrySale[0]['CustomerPO'])) : (NOT_MENTIONED);


$InvoiceStatus = $arrySale[0]['InvoicePaid'];


/*
 if ($arryOtherIncome[0]['GlEntryType']=="Multiple") {
	$Infodata = array('Invoice Number' => $InvoiceID, 'Customer' => $CustomerName, 'Invoice Amount' => $InvoiceAmount.' '.$Currency, 'GL Entry Type' => $GlEntryType,  'Invoice Date' => $InvoiceDate, 'Invoice Comment' => $InvoiceComment);
}else{
	$Infodata = array('Invoice Number' => $InvoiceID, 'Customer' => $CustomerName, 'Invoice Amount' => $InvoiceAmount.' '.$Currency, 'GL Entry Type' => $GlEntryType, 'GL Account' => $GlAccount,  'Invoice Date' => $InvoiceDate, 'Invoice Comment' => $InvoiceComment);
}*/

$Infodata = array('Invoice Date' => $InvoiceDate, 'Inv No. &nbsp;' => $ModulePDFID,'Sales Person'=>$SalesPerson,'CreatedBy'=>$CreatedBy);

//$PaydataArry = array('Customer PO#' => $customerPO);

/***************************/
if(!empty($arrySale[0]['CustCode'])){
	$arryCustomer = $objCustomer->GetCustomerAllInformation('',$arrySale[0]['CustCode'],'');
	
	if(!empty($arryCustomer[0]['Cid'])){		
		$arryContact = $objCustomer->GetCustomerShippingContact($arryCustomer[0]['Cid']);
 	}
	//pr($arryCustomer);	pr($arryContact);	die;
	$arrySale[0]["CustomerCompany"]=$arryCustomer[0]["CustomerCompany"];
	$arrySale[0]["BillingName"]=$arryCustomer[0]["Name"];
	$arrySale[0]["Address"]=$arryCustomer[0]["Address"];
	$arrySale[0]["City"]=$arryCustomer[0]["CityName"];
	$arrySale[0]["State"]=$arryCustomer[0]["StateName"];
	$arrySale[0]["Country"]=$arryCustomer[0]["CountryName"];
	$arrySale[0]["ZipCode"]=$arryCustomer[0]["ZipCode"];
	$arrySale[0]["Mobile"]=$arryCustomer[0]["Mobile"];
	$arrySale[0]["Landline"]=$arryCustomer[0]["Landline"];
	$arrySale[0]["Fax"]=$arryCustomer[0]["Fax"];
	$arrySale[0]["Email"]=$arryCustomer[0]["Email"];
 	$arrySale[0]["ShippingCompany"]=$arryCustomer[0]["CustomerCompany"];

	if(!empty($arryContact[0]['CustID'])){		
		
		$arrySale[0]["ShippingName"]=$arryContact[0]["FullName"];
		$arrySale[0]["ShippingAddress"]=$arryContact[0]["Address"];
		$arrySale[0]["ShippingCity"]=$arryContact[0]["CityName"];
		$arrySale[0]["ShippingState"]=$arryContact[0]["StateName"];
		$arrySale[0]["ShippingCountry"]=$arryContact[0]["CountryName"];
		$arrySale[0]["ShippingZipCode"]=$arryContact[0]["ZipCode"];
		$arrySale[0]["ShippingMobile"]=$arryContact[0]["Mobile"];
		$arrySale[0]["ShippingLandline"]=$arryContact[0]["Landline"];
		$arrySale[0]["ShippingFax"]=$arryContact[0]["Fax"];
		$arrySale[0]["ShippingEmail"]=$arryContact[0]["Email"];
	}

}
/***************************/


/* * ******* Billing******* */
$Address = (!empty($arrySale[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address']))) : ('');
//$Address2 = (!empty($arrySale[0]['$Address2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['Address2']))) : ('');
$CompanyName = (!empty($arrySale[0]['CustomerCompany'])) ? (stripslashes($arrySale[0]['CustomerCompany'])) : ('');
$City = (!empty($arrySale[0]['City'])) ? (stripslashes($arrySale[0]['City'])) : ('');
$State = (!empty($arrySale[0]['State'])) ? (stripslashes($arrySale[0]['State'])) : ('');
$Country = (!empty($arrySale[0]['Country'])) ? (stripslashes($arrySale[0]['Country'])) : ('');
$ZipCode = (!empty($arrySale[0]['ZipCode'])) ? (stripslashes($arrySale[0]['ZipCode'])) : ('');
$ContactName = (!empty($arrySale[0]['Contact'])) ? (stripslashes($arrySale[0]['Contact'])) : ('');
$Mobile = (!empty($arrySale[0]['Mobile'])) ? (stripslashes($arrySale[0]['Mobile'])) : ('');
$Landline = (!empty($arrySale[0]['Landline'])) ? (stripslashes($arrySale[0]['Landline'])) : ('&nbsp;');
$Email = (!empty($arrySale[0]['Email'])) ? (stripslashes($arrySale[0]['Email'])) : ('');
$CustomerCurrency = (!empty($arrySale[0]['CustomerCurrency'])) ? (stripslashes($arrySale[0]['CustomerCurrency'])) : ('');
$AddressHead1 = "BILLING";
//$Address1 = array('Company Name' => $CompanyName, 'Address' => $Address . $Address2, 'City' => $City, 'State' => $State, 'Country' => $Country, 'Zip Code' => $ZipCode, 'Email' => $Email, 'Mobile' => $Mobile, 'Landline' => $Landline);
/* * ******* Billing******* */
if($arryCurrentLocation[0]['country_id']==106){
			if(!empty($arrySale[0]['VAT']) || ($arrySale[0]['CST']) || ($arrySale[0]['PAN'])){
				$VAT= $arrySale[0]['VAT'];
				$CST= $arrySale[0]['CST'];
				$PAN= $arrySale[0]['PAN'];
			}else{
				$VAT = NOT_MENTIONED;
				$CST = NOT_MENTIONED;
				$PAN = NOT_MENTIONED;
			}
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
$Country=(!empty($Country)) ? ($Country.',<br>') : ('');
$Mobile=(!empty($Mobile)) ? ($Mobile.',<br>') : ('');


/**code for vat field***/
$CustomerVAT='';
 if($_SESSION['CmpID']=='612'){
$CustomerVAT = (!empty($arrySale[0]['ebcf1c'])) ? ('<br>VAT-'.stripslashes($arrySale[0]['ebcf1c'])) : ('');
}

/**code for vat field***/

$Address1 = array('' => $CompanyName.$Address.$City.','.$State.'-'.$ZipCode.'<br>'.$Country.$Mobile.$Landline.$CustomerVAT.'<br><br><br><br><br><br><br>');
/* * *******Shipping******* */
$ShippingAddress = (!empty($arrySale[0]['ShippingAddress'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress']))) : ('');
//$ShippingAddress2 = (!empty($arrySale[0]['ShippingAddress2'])) ? (str_replace("\n", " ", stripslashes($arrySale[0]['ShippingAddress2']))) : ('');
$ShippingCompany = (!empty($arrySale[0]['ShippingCompany'])) ? (stripslashes($arrySale[0]['ShippingCompany'])) : ('');
$ShippingCity = (!empty($arrySale[0]['ShippingCity'])) ? (stripslashes($arrySale[0]['ShippingCity'])) : ('');
$ShippingState = (!empty($arrySale[0]['ShippingState'])) ? (stripslashes($arrySale[0]['ShippingState'])) : ('');
$ShippingCountry = (!empty($arrySale[0]['ShippingCountry'])) ? (stripslashes($arrySale[0]['ShippingCountry'])) : ('');
$ShippingZipCode = (!empty($arrySale[0]['ShippingZipCode'])) ? (stripslashes($arrySale[0]['ShippingZipCode'])) : ('');
$ShippingMobile = (!empty($arrySale[0]['ShippingMobile'])) ? (stripslashes($arrySale[0]['ShippingMobile'])) : ('');
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


 /* close single */	

/* multiple */

/* end multiple */



?>
		
		
