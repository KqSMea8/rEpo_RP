<?php 
	/**************************************************/
	$ThisPageName = 'viewSalesPayments.php';$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
        require_once($Prefix."classes/finance.report.class.php");
	
	$ModuleName = "Sales"; 
        $objReport = new report();
	$objCommon = new common();
        $objBankAccount = new BankAccount();
        $objSale = new sale();

	$RedirectURL = "receivePayment.php";
	$ViewUrl = "viewSalesPayments.php?curP=".$_GET['curP'];
  
        /**********************************/ 
	$FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
	$FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');
	$AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');
	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');
	$ArContraAccount = $objCommon->getSettingVariable('ArContraAccount');
	$ApContraAccount = $objCommon->getSettingVariable('ApContraAccount');
	$ARCurrentPeriod =  $objReport->getCurrentPeriod('AR');
	$currentDate = date('Y-m-d');
	$CurrentPeriodDate = $objReport->getCurrentPeriodDate('AR');
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
		$CustCode = $objCommon->getCustomerCode($_POST['CustomerName']);	
		$_POST['CustCode'] = $CustCode;	     
  		if(!empty($_POST['savePaymentInfo'])) {
			if(empty($_POST['PaidTo']) || empty($_POST['Method']) || empty($_POST['ReceivedAmount']) || ($_POST['ReceivedAmount'] == '0') || ($_POST['ReceivedAmount'] != $_POST['total_payment'])
		               ) {
				$_SESSION['mess_payment'] = ERROR_IN_PAY_INVOICE;
				header("Location:".$RedirectURL);
				exit;
			}else{
				if($_POST['TransactionID']>0){
					$objReport->RemoveRecieptTransaction($_POST['TransactionID']);
				} 				 
				/*****************/ 
                                $TransactionID = $objBankAccount->addPaymentInformation($_POST);
                            	$paidAmnt=0;$paidOrderAmnt=0;$InvoiceAmount=0;$TotalOrderedAmount=0;
                                for($i=1;$i<=$_POST['totalInvoice'];$i++){
                                     if($_POST['invoice_check_'.$i] == 'on' && $_POST['payment_amnt_'.$i] > 0){     
                                                    
						$paidAmnt = $objBankAccount->GetSalesTotalPaymentAmntForInvoice($_POST['InvoiceID_'.$i]);                                  
						$paidOrderAmnt = $objBankAccount->GetSalesTotalPaymentAmntForOrder($_POST['SaleID_'.$i]);                           
						$InvoiceAmount  = $_POST['TotalInvoiceAmount_'.$i];
						$TotalOrderedAmount  = $_POST['TotalAmount_'.$i];

						if(intval($paidAmnt) > 0){
							$objSale->updateInvoiceStatus($_POST['OrderID_'.$i],1);
						}
						if(intval($paidAmnt) >= intval($InvoiceAmount)){
							$objSale->updateInvoiceStatus($_POST['OrderID_'.$i],2);
						}
						if(intval($paidOrderAmnt) >= intval($TotalOrderedAmount)){
							$objSale->updateOrderStatus($_POST['SaleID_'.$i]);
						}

                                        }
                                                
                     	}    
                        //end

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
			$objBankAccount->addPoPaymentFromAr($_POST);			                     
			$paidVendorAmnt = 0; $paidVendorOrderAmnt = 0;
			$TotalVendorOrderedAmount=0;$InvoiceVendorAmount=0;
                        for($i=1;$i<=$_POST['totalInvoiceVendor'];$i++){        
                            if($_POST['Vendor_invoice_check_'.$i] == 'on' && $_POST['payment_vendor_amnt_'.$i] > 0){
                                                    
                                $paidVendorAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForInvoice($_POST['VendorInvoiceID_'.$i]);                           
				if($_POST['VendorInvoiceEntry_'.$i] == 1){
					$paidVendorOrderAmnt = $_POST['payment_vendor_amnt_'.$i];
					$TotalVendorOrderedAmount  = $_POST['TotalVendorInvoiceAmount_'.$i];
				}else{
					$paidVendorOrderAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForOrder($_POST['PurchaseID_'.$i]);
					$TotalVendorOrderedAmount  = $_POST['VendorTotalAmount_'.$i];
				}
                                                       
                                                        
				$InvoiceVendorAmount  = $_POST['TotalVendorInvoiceAmount_'.$i];
				if(intval($paidVendorAmnt) > 0){
					$objBankAccount->updatePurchaseInvoiceStatus($_POST['VendorInvoiceID_'.$i],1);
				} 
				if(intval($paidVendorAmnt) >= intval($InvoiceVendorAmount)){
					$objBankAccount->updatePurchaseInvoiceStatus($_POST['VendorInvoiceID_'.$i],2);
				}
				if(intval($paidVendorOrderAmnt) >= intval($TotalVendorOrderedAmount) && intval($TotalVendorOrderedAmount) > 0){
					$objBankAccount->updateOrderStatus($_POST['PurchaseID_'.$i]);
				}
                                                        
                            }   
                                                    
                      }
   

		}
               //end
                                        
                                        
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
		$_GET['TransactionID'] = (int)$_GET['edit'];
		$_GET['PaymentType'] = 'Sales';
		$arryTransaction = $objReport->getPaymentTransaction($_GET);
		//print_r($arryTransaction);
		if(empty($arryTransaction[0]['TransactionID'])){
			$ErrorMsg = INVALID_REQUEST;
		}else{
			$TransactionID =  $arryTransaction[0]['TransactionID'];
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
				$confirmContra=1;
			}
		}
		$PageHeading = 'Edit Cash Receipt';
	}else{
		$PageHeading = 'Receive Payment';
	}
	/*****************/ 
	require_once("../includes/footer.php"); 	
?>


