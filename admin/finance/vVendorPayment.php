<?php 

	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewVendorPayment.php';
	/**************************************************/
	include_once("../includes/header.php");	
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix . "classes/finance.account.class.php");
		
	$objTransaction=new transaction();
	$objReport = new report();
	$objBankAccount = new BankAccount();
	if(!empty($_GET["view"])){
		$TransactionID = $_GET['view'];	
		$ContraTransactionID='';
		if($TransactionID>0){
			/******3July PK***********
			$ContraTransactionID = $objBankAccount->GetContraID($TransactionID);
			if(empty($ContraTransactionID)){
				$ContraTransactionID = $objBankAccount->GetContraIDReverse($TransactionID);
			}			
			/***********************/
			 
			
			$_GET['PaymentType'] = 'Purchase';

			if($TransactionID>0 && $ContraTransactionID>0){
				$TransactionID = $TransactionID.','.$ContraTransactionID;
			}	
 
			$_GET['TransactionID'] = $TransactionID;
			$arryVendorPayment = $objBankAccount->ListVendorPayment($_GET);
 			 
			 
			if(empty($arryVendorPayment[0]["PaymentAccount"]) && !empty($arryVendorPayment[0]['AccountID'])){
				$arryBankAccount = $objBankAccount->getBankAccountById($arryVendorPayment[0]['AccountID']);
            			$arryVendorPayment[0]["PaymentAccount"] = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}
			





			$_GET['PaymentType'] = 'Purchase';
			$arryTransaction = $objTransaction->GetTransactionDataByID('',$TransactionID ,''); //'AP'
			 
		
		}
		 
	}

	if(empty($arryTransaction[0]['TransactionID'])){
		$ErrorMSG = NOT_EXIST_DATA;
	}

	require_once("../includes/footer.php"); 	 
?>


