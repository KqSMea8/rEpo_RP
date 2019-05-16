<?php 
	/**************************************************/
	$ThisPageName = 'viewCashReceipt.php';$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
        require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/product.class.php");
	require_once($Prefix."classes/card.class.php");
	$ModuleName = "Sales"; 
        $objReport = new report();
	$objCommon = new common();
        $objBankAccount = new BankAccount();
	$objTransaction=new transaction();
        $objSale = new sale();
	$objCard = new card();
	$RedirectURL = "receivePayment.php";
	$ViewUrl = "viewCashReceipt.php?curP=".$_GET['curP'];
  


	/****************************/
	if(!empty($_GET['del_id'])) {
		$_SESSION['mess_payment'] = CASH_RECEIPT_REMOVED;	
		$objReport->RemoveTransaction($_GET['del_id']);
		header("location:" . $RedirectURL);
		exit;
	}
	/**********************************/
	if(!empty($_GET['void_cc_id']) && $_GET['Action']=='VCard'){		 
		$objCard->VoidTransactionCreditCard($_GET['void_cc_id'],'');
		$_SESSION['mess_Invoice'] = $_SESSION['mess_card'];
		unset($_SESSION['mess_card']);					
		header("Location:".$ViewUrl);
		exit;
	}

        /**********************************/ 
	$FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
	$FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');
	$AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');
	

	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');
	$ArContraAccount = $objCommon->getSettingVariable('ArContraAccount');
	$ApContraAccount = $objCommon->getSettingVariable('ApContraAccount');
	$currentDate = date('Y-m-d');
	$CurrentPeriodDate = $objReport->getCurrentPeriodDate('AR');
	$ARCurrentPeriod = 'Current Period : '.date("F Y",strtotime($CurrentPeriodDate));

	$arryBackMonth = $objReport->getBackOpenMonth('AR');
	$strBackDate = '';
	for($i=0;$i<count($arryBackMonth);$i++){
		$strBackDate .= $arryBackMonth[$i]['PeriodYear'].'-'.$arryBackMonth[$i]['PeriodMonth'].',';
	}
	$strBackDate = rtrim($strBackDate,",");      
	$arryBankAccount=$objBankAccount->getBankAccountForReceivePayment();
	$arryPaymentTerm = $objConfigure->GetTerm('','1');
        /**********************************/

	 
	
	 

        /**********************************/ 
       if(!empty($_POST['PaidTo'])) {
		CleanPost();   

	 	$_POST['AccountReceivable'] =  $AccountReceivable;
		$_POST['AccountPayable'] =  $AccountPayable;
		//$CustCode = $objCommon->getCustomerCode($_POST['CustomerName']);	
		//$_POST['CustCode'] = $CustCode;
		    

		/***************/  
		$ValidateErrorMsg = '';
		$ReceivedAmount = round(trim($_POST['ReceivedAmount']),2);	
		$TotalOriginalAmount = round(trim($_POST['TotalOriginalAmount']),2);		
		if(trim($_POST['ReceivedAmount'])=='') {
			$ValidateErrorMsg .= BLANK_DEPOSIT_AMOUNT;
		}
		if($ReceivedAmount != $TotalOriginalAmount) {
			$ValidateErrorMsg .= DEPOSIT_AMOUNT_UNMATCHED;
		}
		if(empty($_POST['PaidTo'])) {
			$ValidateErrorMsg .= BLANK_DEPOSIT_ACCOUNT;
		}
		if(empty($_POST['Method'])) {
			$ValidateErrorMsg .= BLANK_TERM;
		}
		/***************/


		if(!empty($ValidateErrorMsg)){
			 
			$_SESSION['mess_payment'] = ERROR_IN_PAYMENT.$ValidateErrorMsg;

			/*****Set Post In Session in Add**********/
			if(empty($_POST['TransactionID'])){
				$_SESSION['PaymentErrorFlag'] = 1;
				
				$_SESSION['PaymentData']['OriginalAmount'] = $_POST['ReceivedAmount'];
				$_SESSION['PaymentData']['CustID'] = $_POST['CustomerName'];
				$_SESSION['PaymentData']['ConfirmContra'] = $_POST['ConfirmContra'];
				$_SESSION['PaymentData']['AccountID'] = $_POST['PaidTo'];
				$_SESSION['PaymentData']['PaymentDate'] = $_POST['Date'];
				$_SESSION['PaymentData']['ModuleCurrency'] =  $_POST['BankCurrency'];
				$_SESSION['PaymentData']['Method'] =  $_POST['Method'];
				$_SESSION['PaymentData']['CheckBankName'] =  $_POST['CheckBankName'];
				$_SESSION['PaymentData']['CheckNumber'] =  $_POST['CheckNumber'];
				$_SESSION['PaymentData']['ReferenceNo'] =  $_POST['ReferenceNo'];
				$_SESSION['PaymentData']['Comment'] =  $_POST['Comment'];
				 
			}
			/************************/

			header("Location:".$RedirectURL);
			exit;
		}else{
			 
			/*******Invoice********/
			if($_POST['TransactionID']>0){
				$objReport->RemoveRecieptTransaction($_POST['TransactionID']);
			}			
                        $TransactionID = $objTransaction->addReceiptTransaction($_POST);  
			/********Credit*********/ 
			$objTransaction->addCreditTransaction($TransactionID,$_POST);
			/********Credit Amount*********/ 
			#$objTransaction->addCreditAmountTransaction($TransactionID,$_POST);
			/********GL*********/ 
			$objTransaction->addGlTransaction($TransactionID,$_POST);
			/********Contra******/ 				
			if($_POST['ContraTransactionID']>0){
				$objReport->RemovePaymentTransaction($_POST['ContraTransactionID']);
			}
			if($_POST['ContraAcnt'] ==1){
				$_POST['ApContraAccount'] = $ApContraAccount;
				/************AP Payment Ref*****************/
				$ReferenceCoNo = rand ( 1 , 999999);
				$_POST['ReferenceCoNo'] = "CO".$ReferenceCoNo;
				/*****************************/
				$_POST['ContraID'] = $TransactionID;
				$objTransaction->addReceiptContraTransaction($_POST);
			}
		        /*****************/ 
			
			/*****************/
			unset($_SESSION['mess_card']);				 		 
			$objTransaction->SaveTransactionCreditCard($TransactionID, $_POST);
			if($_POST['CardCharge']=='1'){
				$objCard->ProcessTransactionCreditCard($TransactionID);
			}	
			/*****************/ 


			$_SESSION['mess_payment'] = ADD_PAYMENT_INFORMATION;
			$_SESSION['mess_payment'] .= '<br>'.$_SESSION['mess_card'];

			$objTransaction->RemoveSessionTransaction('AR');

			header("Location:".$RedirectURL);
			exit;

		}                                
                               
		 
	}	
	/**********************************/        
	/**********************************/
        
        if(empty($AccountReceivable)){
		$ErrorMsg  = SELECT_GL_AR;
	}else  if ($FiscalYearStartDate == "" && $FiscalYearEndDate == "") {
		$ErrorMsg  = SETUP_FISCAL_YEAR;
	}  
 	$Config['NormalAccount']=1;
        $arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();
	unset($Config['NormalAccount']);

 	$arryCustomerList=$objBankAccount->getCustomerList();


	/*****************/
	$confirmContra=0;
	$CustIDForContra='';
	$ModuleCurrency=$TransactionID=$ContraTransactionID=$ContraFlag='';
	if($_GET['edit']>0){
		$ContraFlag = 'No';
		$_GET['TransactionID'] = (int)$_GET['edit'];
		$_GET['PaymentType'] = 'Sales';
		$arryTransaction = $objReport->getPaymentTransaction($_GET);
	 
		if(empty($arryTransaction[0]['TransactionID'])){
			$ErrorMsg = INVALID_REQUEST;
		}else{
			$TransactionID =  $arryTransaction[0]['TransactionID'];
			$ModuleCurrency =  $arryTransaction[0]['ModuleCurrency'];
			$objTransaction->ResetDeletedFlag($TransactionID);
			unset($_GET['TransactionID']);
			if(!empty($arryTransaction[0]['ContraID'])){
				$_GET['TransactionID'] = $arryTransaction[0]['ContraID'];
			}else{
				$_GET['ContraID'] = $TransactionID;				
			}
			/*$_GET['PaymentType'] = 'Purchase';			
			$arryContraTr = $objReport->getPaymentTransaction($_GET);
			if(!empty($arryContraTr[0]['TransactionID'])){
				$ContraTransactionID = $arryContraTr[0]['TransactionID'];
				$confirmContra = 1;
				$ContraFlag = 'Yes';
				$CustIDForContra = $arryTransaction[0]['CustID'];
			}*/

			$arryCard = $objTransaction->GetTransactionCreditCard($TransactionID);


		}
		$PageHeading = 'Edit Cash Receipt';
		$ClassName = 'inputbox';
		$ClassDate = 'datebox';	
		$Disabled = '';
	}else{
		$PageHeading = 'Receive Payment';
		
		$ClassName = 'disabled_inputbox';
		$ClassDate = 'datebox disabled';	
		$Disabled = 'disabled';
	}


	if(empty($arryCard[0]['CardNumber'])){
		$arryCard = $objConfigure->GetDefaultArrayValue('s_order_card');
	}

 
	/*****************************/ 
	/*****************************/ 
	if(!empty($_SESSION['PaymentErrorFlag'])){		
		if(!empty($_SESSION['PaymentData'])){
			$PaymentErrorFlag=1;
			foreach($_SESSION['PaymentData'] as $key => $values){
				$arryTransaction[0][$key] = $values;
			}			 
			$ModuleCurrency =  $arryTransaction[0]['ModuleCurrency'];
			unset($_SESSION['PaymentData']);
		}
		unset($_SESSION['PaymentErrorFlag']);
	}else{
		$objTransaction->RemoveSessionTransaction('AR');
	}
	/*****************************/ 
	/*****************************/ 


	require_once("../includes/footer.php"); 	
?>


