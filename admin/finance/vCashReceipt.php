<?php 

	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewCashReceipt.php';
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
		$ShowCardInfo='';
		if($TransactionID>0){
			/*******3July PK********
			$ContraTransactionID = $objBankAccount->GetContraID($TransactionID);
			if(empty($ContraTransactionID)){
				$ContraTransactionID = $objBankAccount->GetContraIDReverse($TransactionID);
			}
			/*****************/

			$_GET['PaymentType'] = 'Sales';

			if($TransactionID>0 && $ContraTransactionID>0){
				$TransactionID = $TransactionID.','.$ContraTransactionID;
			}	

			$_GET['TransactionID'] = $TransactionID;
			$arryCash = $objBankAccount->ListCashReceipt($_GET);
			
			if(empty($arryCash[0]["PaidToAccount"]) && !empty($arryCash[0]['AccountID'])){
				$arryBankAccount = $objBankAccount->getBankAccountById($arryCash[0]['AccountID']);
            			$arryCash[0]["PaidToAccount"] = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}
			

			 
			 
			$_GET['PaymentType'] = 'Sales';
			$arryTransaction = $objTransaction->GetTransactionDataByID('',$TransactionID ,'');  //'AR'
		
			
			/*************/
			if($arryCash[0]["Method"]=="Credit Card"){
				 if($objTransaction->isCardTransactionExist($TransactionID, $arryCash[0]["Method"])){

				$ShowCardInfo=1;
				$arryCard = $objTransaction->GetTransactionCreditCard($TransactionID);
				$arryCardTransaction = $objTransaction->GetCardTransaction($TransactionID,$arryCash[0]['Method']);
					 
				}
			}
			 
			/*************/


			  
		}
		 
	}

	if(empty($arryTransaction[0]['TransactionID'])){
		$ErrorMSG = NOT_EXIST_DATA;
	}

	require_once("../includes/footer.php"); 	 
?>


