<?php 	
	/**************************************************/
	$ThisPageName = 'viewVendorPayment.php';$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
        require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/function.class.php");

	$objFunction=new functions();
        $objReport = new report();  	
        $objCommon = new common();
        $objBankAccount=new BankAccount();
        $objSale = new sale();
	$objTransaction=new transaction();

	$ModuleName = "Purchases";
	$RedirectURL = "payVendor.php";
        $ViewUrl = "viewVendorPayment.php?curP=".$_GET['curP'];


	/****************************/
	if(!empty($_GET['del_id'])) {
		$_SESSION['mess_payment'] = PAYMENT_REMOVED;
		$objConfig->RemoveStandAloneShipment($_GET['del_id'], 'VendorPayment'); 
		$objReport->RemoveVendorTransaction($_GET['del_id']);
		header("location:" . $RedirectURL);
		exit;
	}

	/**********************************/
	$FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
	$FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');
	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');
	$AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');
	$ArContraAccount = $objCommon->getSettingVariable('ArContraAccount');
	$ApContraAccount = $objCommon->getSettingVariable('ApContraAccount');

	$currentDate = date('Y-m-d');
	$CurrentPeriodDate = $objReport->getCurrentPeriodDate('AP');
	$APCurrentPeriod = 'Current Period : '.date("F Y",strtotime($CurrentPeriodDate));

	$arryBackMonth = $objReport->getBackOpenMonth('AP');
	
	$strBackDate = '';
	for($i=0;$i<count($arryBackMonth);$i++){            
		$strBackDate .= $arryBackMonth[$i]['PeriodYear'].'-'.$arryBackMonth[$i]['PeriodMonth'].',';
	}        
        $strBackDate = rtrim($strBackDate,",");

	$arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();
	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	/**********************************/
        /**********************************/

	 
	 if(!empty($_POST['PaidFrom'])) {
		CleanPost();
		
		$_POST['AccountReceivable'] =  $AccountReceivable;
		$_POST['AccountPayable'] =  $AccountPayable;
		$_POST['AccountPayable'] =  $AccountPayable;
		if($_POST['Method']!='Check') unset($_POST['CheckNumber']);
		 
 

		/***************/  
		$ValidateErrorMsg = '';
		$PaidAmount = round(trim($_POST['PaidAmount']),2);	
		$TotalOriginalAmount = round(trim($_POST['TotalOriginalAmount']),2);		
		if(trim($_POST['PaidAmount'])=='') {
			$ValidateErrorMsg .= BLANK_PAYMENT_AMOUNT;
		}
		if($PaidAmount != $TotalOriginalAmount) {
			$ValidateErrorMsg .= PAYMENT_AMOUNT_UNMATCHED;
		}
		if(empty($_POST['PaidFrom'])) {
			$ValidateErrorMsg .= BLANK_PAYMENT_ACCOUNT;
		}
		if(empty($_POST['Method'])) {
			$ValidateErrorMsg .= BLANK_TERM;
		}
		/***************/
 		 
		if(!empty($ValidateErrorMsg)){
			$_SESSION['mess_payment'] = ERROR_IN_PAYMENT.$ValidateErrorMsg;

			/*****Set Post In Session in Add**********/
			if(empty($_POST['TransactionID'])){
				$_SESSION['PaymentErrorFlagV'] = 1;
				
				$_SESSION['PaymentDataV']['OriginalAmount'] = $_POST['PaidAmount'];
				$_SESSION['PaymentDataV']['SuppCode'] = $_POST['SuppCode'];
				$_SESSION['PaymentDataV']['ConfirmContra'] = $_POST['ConfirmContra'];
				$_SESSION['PaymentDataV']['AccountID'] = $_POST['PaidFrom'];
				$_SESSION['PaymentDataV']['PaymentDate'] = $_POST['Date'];
				$_SESSION['PaymentDataV']['ModuleCurrency'] =  $_POST['BankCurrency'];
				$_SESSION['PaymentDataV']['Method'] =  $_POST['Method'];
				$_SESSION['PaymentDataV']['CheckBankName'] =  $_POST['CheckBankName'];
				$_SESSION['PaymentDataV']['CheckNumber'] =  $_POST['CheckNumber'];
				$_SESSION['PaymentDataV']['CheckFormat'] =  $_POST['CheckFormat'];
				$_SESSION['PaymentDataV']['ReferenceNo'] =  $_POST['ReferenceNo'];
				$_SESSION['PaymentDataV']['Comment'] =  $_POST['Comment'];
				 
			}
			/************************/


			header("Location:".$RedirectURL);
			exit;
		}else{	

		
			/*******Invoice********/		
			if($_POST['TransactionID']>0){
				$objReport->RemovePaymentTransaction($_POST['TransactionID']);
			}     
	             
			$TransactionID = $objTransaction->addPayVendorTransaction($_POST);	
				
			/********Credit*********/ 
			$objTransaction->addCreditPaymentInformation($TransactionID,$_POST);
			/********Credit Amount*********/ 
			#$objTransaction->addAPCreditAmountTransaction($TransactionID,$_POST);
			/********GL*********/ 
			$objTransaction->addGlAPTransaction($TransactionID,$_POST);
			/*********Contra********/ 
			if($_POST['ContraTransactionID']>0){
				$objReport->RemoveRecieptTransaction($_POST['ContraTransactionID']);
			} 
 
			if($_POST['ContraFlag']=="Yes"){		
				$_POST['ArContraAccount'] = $ArContraAccount;		
				$ReferenceTFNo = rand ( 1 , 999999);
				$_POST['ReferenceTFNo'] = "TF".$ReferenceTFNo;
				$_POST['ContraID'] = $TransactionID;
				$CustCode = $objCommon->getCustomerCode($_POST['CustomerName']);	
				$_POST['CustCode'] = $CustCode; 
				$objTransaction->addPayVendorContraTransaction($_POST);					 
 			}	
			/*****************/      

			$objTransaction->RemoveSessionTransaction('AP');                                   
			$_SESSION['mess_payment'] = ADD_PAYMENT_INFORMATION;



			/*************** Standalone Shipment ***************/
			if(!empty($TransactionID)){ 			
				$objConfig->AddUpdateStandAloneShipment($TransactionID, 'VendorPayment'); 
				unset($_SESSION["Shipping"]);
			}
			/*******************************************/


			header("Location:".$RedirectURL);
			exit;

		}                               
                               
	   
	}	
        /**********************************/       
        /**********************************/
       
	if(empty($AccountPayable)){
		$ErrorMsg  = SELECT_GL_AP;
	}else  if ($FiscalYearStartDate == "" && $FiscalYearEndDate == "") {
		$ErrorMsg  = SETUP_FISCAL_YEAR;
	}        
	$Config['NormalAccount']=1;
        $arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();
	unset($Config['NormalAccount']);
	$arryVendorList=$objBankAccount->getVendorList();
	
	/*****************/
	$TransactionID=$ContraTransactionID=$ModuleCurrency=$ContraFlag='';
	$confirmContra=0;$ContraTransactionID='';
	if($_GET['edit']>0){
		$ContraFlag = 'No';
		
		$_GET['TransactionID'] = (int)$_GET['edit'];
		$_GET['PaymentType'] = 'Purchase';
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
			/*$_GET['PaymentType'] = 'Sales';			
			$arryContraTr = $objReport->getPaymentTransaction($_GET);
			if(!empty($arryContraTr[0]['TransactionID'])){
				$ContraTransactionID = $arryContraTr[0]['TransactionID'];
				$confirmContra=1;
				$ContraFlag = 'Yes';
				$SuppCodeForContra = $arryTransaction[0]['SuppCode'];
			}*/
		}
		$PageHeading = 'Edit Vendor Payment';

		$ClassName = 'inputbox';
		$ClassDate = 'datebox';	
		$Disabled = '';
	}else{
		$PageHeading = 'Pay Vendor';
		
		$ClassName = 'disabled_inputbox';
		$ClassDate = 'datebox disabled';	
		$Disabled = 'disabled';
	}
	/*****************/  
	
	if(empty($arryContraTr[0]['TransactionID'])){ 
		$arryContraTr = $objConfigure->GetDefaultArrayValue('f_transaction');
	}

	/*****************************/ 
	/*****************************/ 
	if(!empty($_SESSION['PaymentErrorFlagV'])){		
		if(!empty($_SESSION['PaymentDataV'])){
			$PaymentErrorFlag=1;
			foreach($_SESSION['PaymentDataV'] as $key => $values){
				$arryTransaction[0][$key] = $values;
			}			 
			$ModuleCurrency =  $arryTransaction[0]['ModuleCurrency'];
			unset($_SESSION['PaymentDataV']);
		}
		unset($_SESSION['PaymentErrorFlagV']);
	}else{
		$objTransaction->RemoveSessionTransaction('AP');	
		 
	}
	/*****************************/ 
	/*****************************/ 

	 
	require_once("../includes/footer.php"); 	
?>


