<?php
 
$HideNavigation = 1;  $EditPage = 1;
/* * *********************************************** */
$ThisPageName = 'viewInvoice.php';
/* * *********************************************** */

include_once("../includes/header.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/sales.customer.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix."classes/finance.report.class.php");
require_once($Prefix."classes/finance.transaction.class.php");
require_once($Prefix."classes/finance.journal.class.php");
require_once($Prefix."classes/card.class.php");
$objSale = new sale();
$objBankAccount = new BankAccount();
$objTransaction=new transaction();
$objReport = new report();
$objCard = new card();
$objCustomer=new Customer();
$RedirectURL = "viewInvoice.php" ;

echo '<script>RestrictIframe();</script>';	
if(!empty($_POST)){   
	CleanPost();

	$arryCard[0]['CardType'] = $_POST['CreditCardType'];
	$arryCard[0]["CardNumber"] = $_POST['CreditCardNumber'];
	$arryCard[0]['ExpiryMonth'] = $_POST['CreditExpiryMonth'];
	$arryCard[0]["ExpiryYear"] = $_POST['CreditExpiryYear'];
	$arryCard[0]['SecurityCode'] = $_POST['CreditSecurityCode'];
	$arryCard[0]["CardHolderName"] = $_POST['CreditCardHolderName'];
	$arryCard[0]['Address'] = $_POST['CreditAddress'];
	$arryCard[0]["Country"] = $_POST['CreditCountry'];
	$arryCard[0]['State'] = $_POST['CreditState'];
	$arryCard[0]["City"] = $_POST['CreditCity'];
	$arryCard[0]["ZipCode"] = $_POST['CreditZipCode'];

	$arryCard[0]['country_id'] = $_POST['country_id'];
	$arryCard[0]['state_id'] = $_POST['main_state_id'];
	$arryCard[0]['OtherState'] = $_POST['OtherState'];
	$arryCard[0]['city_id'] = $_POST['main_city_id'];
	$arryCard[0]['OtherCity'] = $_POST['OtherCity'];
	 
	if(empty($_POST['CreditCardID'])){
		$CardID = $objCustomer->GetCardIDExist($_POST['CreditCardNumber'], $_POST['CustID']);
		if($CardID>0){
			$_POST['CardID'] = $CardID;
			$objCustomer->UpdateCard($_POST);
		}else{
			$CardID = $objCustomer->addCard($_POST);
		}
	}

	$Config['PaymentTerm'] ='Credit Card';
	$_POST['PaymentTerm'] = $Config['PaymentTerm'];
	$OrderID = $_POST['OrderID'];
	$objSale->AddUpdateCreditCard($OrderID, $_POST); 


 
	/**********************/
	$AmountToCharge = (!empty($_POST['AmountToCharge']))?($_POST['AmountToCharge']):('');
	$receivedAmnt = (!empty($_POST['receivedAmnt']))?($_POST['receivedAmnt']):('0');


 	$objCard->ProcessSaleCreditCard($OrderID,'',$AmountToCharge);
	 
 
	if(!empty($_SESSION['mess_Sale'])){
		$ResposeMSG = $_SESSION['mess_Sale'];
		unset($_SESSION['mess_Sale']); 
		$arryLastTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$Config['PaymentTerm']);	 
		if(!empty($arryLastTransaction[0]["TotalAmount"])){
			/**********/
			$arryStatus = $objSale->GetSalesBrief($OrderID, '', '');	
			$arrStatusMsg = explode("#",$arryStatus[0]['StatusMsg']);
			$Status = $arrStatusMsg[0];
			if($Status==1){
				$TotalInvoiceAmount = $arryStatus[0]['TotalInvoiceAmount'];
				$BalanceAmount = $TotalInvoiceAmount - ($AmountToCharge + $receivedAmnt);

				$arryPostData['PostToGLDate'] = $Config['TodayDate'];
				$arryPostData['AmountToCharge'] = $AmountToCharge;
				$arryPostData['Fee'] = $arryLastTransaction[0]["Fee"];
				$arryPostData['BalanceAmount'] = $BalanceAmount;
				$objReport->SoInvoiceAlreadyPostToGL($OrderID,$arryPostData);	
			}
			/**********/


		}
	}

	/**********************/
}





if(!empty($_GET['view'])) {
	$arrySale = $objSale->GetInvoice($_GET['view'], '', '');
	$OrderID = $arrySale[0]['OrderID'];
	$CustID = $arrySale[0]['CustID'];
	$TotalInvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];
	if($OrderID > 0){
		/**************/
		/*if($arrySale[0]['InvoiceEntry']>1){		
			$ErrorMSG = NOT_EXIST_INVOICE;            	
		}*/	 	
		if($arrySale[0]['PostToGL'] != "1") { 
			$ErrorMSG = NOT_FOR_PAYMENT;
		}else if(empty($_POST['OrderID']) && ($arrySale[0]['InvoicePaid'] == 'Paid' || $arrySale[0]['OrderPaid'] == "1")) {
			$ErrorMSG = ALREADY_PAID_INVOICE;			
		}
		/**************/
	
		$arrySaleItem = $objSale->GetSaleItem($OrderID);
		$NumLine = sizeof($arrySaleItem);


		$AmountToCharge = $TotalInvoiceAmount; 
		/*****Paid Cash Receipt********/
		$receivedAmnt = 0;

		if($arrySale[0]['InvoicePaid'] == 'Paid'){ //for post
			$AmountToCharge=0;
		}

		if($arrySale[0]['PostToGL'] == "1" && $arrySale[0]['InvoicePaid'] != 'Paid') { 
			$_GET['custID'] = $arrySale[0]['CustID'];
			$_GET['OrderID'] =  $arrySale[0]['OrderID'];
			$arryCashReceipt = $objBankAccount->ListUnPaidInvoice($_GET);	
	 		if(!empty($arryCashReceipt[0]['OrderID'])){
				if($arryCashReceipt[0]['CustomerCurrency']!=$Config['Currency']){
					$receivedAmnt = $arryCashReceipt[0]['receivedAmntTr'];	
				}else{
				   	$receivedAmnt = $arryCashReceipt[0]['receivedAmnt'];		
				}
			}
			if($receivedAmnt > 0){
			     $AmountToCharge =  $AmountToCharge-$receivedAmnt; 		     		
			}
		}			
		/****************************/
		$AmountToCharge = round($AmountToCharge,2);
		
		if($AmountToCharge<=0 && empty($ResposeMSG)){	
			$ErrorMSG = NOT_FOR_PAYMENT;
		}

	} else {
		$ErrorMSG = NOT_EXIST_INVOICE;
	}
} else {
    $ErrorMSG = NOT_EXIST_INVOICE;
}
 
$HideRow = 'Style="display:none"';

require_once("../includes/footer.php");
?>


