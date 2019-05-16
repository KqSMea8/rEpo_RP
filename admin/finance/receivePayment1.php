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
	$ModuleName = "Sales"; 
        $objReport = new report();
	$objCommon = new common();
        $objBankAccount = new BankAccount();
	$objTransaction=new transaction();
        $objSale = new sale();

	$RedirectURL = "receivePayment1.php";
	$ViewUrl = "viewCashReceipt.php?curP=".$_GET['curP'];
  


	








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
	$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
        /**********************************/
        /**********************************/ 
        if($_POST){
		CleanPost();  

		$_POST['AccountReceivable'] =  $AccountReceivable;
		$_POST['AccountPayable'] =  $AccountPayable;
		//$CustCode = $objCommon->getCustomerCode($_POST['CustomerName']);	
		//$_POST['CustCode'] = $CustCode;
		    
  		if(!empty($_POST['ReceivedAmount'])) {
			if(empty($_POST['PaidTo']) || empty($_POST['Method']) || empty($_POST['ReceivedAmount']) || ($_POST['ReceivedAmount'] == '0') || ($_POST['ReceivedAmount'] != $_POST['total_saved_payment'])
		               ) {
				$_SESSION['mess_payment'] = ERROR_IN_PAY_INVOICE;
				header("Location:".$RedirectURL);
				exit;
			}else{
				
				/*******Invoice********/
				if($_POST['TransactionID']>0){
					$objReport->RemoveRecieptTransaction($_POST['TransactionID']);
				}			
                                $TransactionID = $objTransaction->addReceiptTransaction($_POST);  
				/********Credit*********/ 
				if($TransactionID>0)$objTransaction->addCreditTransaction($TransactionID,$_POST);
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
				
				$_SESSION['mess_payment'] = ADD_PAYMENT_INFORMATION;
				header("Location:".$RedirectURL);
				exit;

			}
                                
                               
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

 	$arryCustomerList=$objBankAccount->getCustomerList($_GET);


	/*****************/
	$confirmContra=0;
	if($_GET['edit']>0){
		$ContraFlag = 'No';
		$_GET['TransactionID'] = (int)$_GET['edit'];
		$_GET['PaymentType'] = 'Sales';
		$arryTransaction = $objReport->getPaymentTransaction($_GET);
		//print_r($arryTransaction);
		if(empty($arryTransaction[0]['TransactionID'])){
			$ErrorMsg = INVALID_REQUEST;
		}else{
			$TransactionID =  $arryTransaction[0]['TransactionID'];
			$objTransaction->ResetDeletedFlag($TransactionID);
			unset($_GET['TransactionID']);
			if(!empty($arryTransaction[0]['ContraID'])){
				$_GET['TransactionID'] = $arryTransaction[0]['ContraID'];
			}else{
				$_GET['ContraID'] = $TransactionID;				
			}
			$_GET['PaymentType'] = 'Purchase';			
			$arryContraTr = $objReport->getPaymentTransaction($_GET);
			if(!empty($arryContraTr[0]['TransactionID'])){
				$ContraTransactionID = $arryContraTr[0]['TransactionID'];
				$confirmContra = 1;
				$ContraFlag = 'Yes';
				$CustIDForContra = $arryTransaction[0]['CustID'];
			}
		}
		$PageHeading = 'Edit Cash Receipt';
		$ClassName = 'inputbox';
		$ClassDate = 'datebox';	
	}else{
		$PageHeading = 'Receive Payment';
		
		$ClassName = 'disabled_inputbox';
		$ClassDate = 'datebox disabled';	
		$Disabled = 'disabled';
	}


	/*****************/ 
	$objTransaction->RemoveSessionTransaction('AR');	
	/*****************/ 

	require_once("../includes/footer.php"); 	
?>


