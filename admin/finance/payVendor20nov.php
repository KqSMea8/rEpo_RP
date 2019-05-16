<?php 	
	/**************************************************/
	$ThisPageName = 'viewPurchasePayments.php';$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
        require_once($Prefix."classes/finance.report.class.php");
		 
        $objReport = new report();  	
        $objCommon = new common();
        $objBankAccount=new BankAccount();
        $objSale = new sale();

	$ModuleName = "Purchases";
	$RedirectURL = "payVendor.php";
        $ViewUrl = "viewPurchasePayments.php?curP=".$_GET['curP'];

	/**********************************/
	$FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
	$FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');
	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');
	$AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');
	$ArContraAccount = $objCommon->getSettingVariable('ArContraAccount');
	$ApContraAccount = $objCommon->getSettingVariable('ApContraAccount');

	$APCurrentPeriod =  $objReport->getCurrentPeriod('AP');
	$currentDate = date('Y-m-d');
	$CurrentPeriodDate = $objReport->getCurrentPeriodDate('AP');

	$arryBackMonth = $objReport->getBackOpenMonth('AP');
	
	$strBackDate = '';
	for($i=0;$i<count($arryBackMonth);$i++){            
		$strBackDate .= $arryBackMonth[$i]['PeriodYear'].'-'.$arryBackMonth[$i]['PeriodMonth'].',';
	}        
        $strBackDate = rtrim($strBackDate,",");

	$arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();
	$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');         
	/**********************************/
        /**********************************/
	if($_POST) {		
		CleanPost();
		$_POST['AccountReceivable'] =  $AccountReceivable;
		$_POST['AccountPayable'] =  $AccountPayable;
		$_POST['AccountPayable'] =  $AccountPayable;
		if($_POST['Method']!='Check') unset($_POST['CheckNumber']);

		if(!empty($_POST['savePaymentInfo'])){
			if(empty($_POST['PaidFrom']) || empty($_POST['Method']) || empty($_POST['PaidAmount']) || ($_POST['PaidAmount'] == '0') || ($_POST['PaidAmount'] != $_POST['total_payment'])
                                || ($_POST['PaidAmount'] > $_POST['totalOpenBalance'])) {
				$_SESSION['mess_payment'] = ERROR_IN_PAY_INVOICE;
				header("Location:".$RedirectURL);
				exit;
			}else{	 
				/*****************/                                       
        			$TransactionID = $objBankAccount->addPurchasePaymentInformation($_POST);
                                $paidAmnt = 0; $paidOrderAmnt = 0;$TotalOrderedAmount=0;$InvoiceAmount=0;
                                for($i=1;$i<=$_POST['totalInvoice'];$i++){   
                                    if($_POST['invoice_check_'.$i] == 'on' && $_POST['payment_amnt_'.$i] > 0){
                                                   
                                        $paidAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForInvoice($_POST['InvoiceID_'.$i]);    
				        if($_POST['InvoiceEntry_'.$i] == 1){                                        
		                           	$paidOrderAmnt = $_POST['payment_amnt_'.$i];
		                           	$TotalOrderedAmount  = $_POST['TotalInvoiceAmount_'.$i];
                                 	}else{
						$paidOrderAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForOrder($_POST['PurchaseID_'.$i]);
						$TotalOrderedAmount  = $_POST['TotalAmount_'.$i];
                                        }
                                        $InvoiceAmount  = $_POST['TotalInvoiceAmount_'.$i];      
                                        if(intval($paidAmnt) > 0){
                                          $objBankAccount->updatePurchaseInvoiceStatus($_POST['InvoiceID_'.$i],1);
                                        } 
                                        if(intval($paidAmnt) >= intval($InvoiceAmount)){
                                             $objBankAccount->updatePurchaseInvoiceStatus($_POST['InvoiceID_'.$i],2);
                                        }
                                        if(intval($paidOrderAmnt) >= intval($TotalOrderedAmount) && intval($TotalOrderedAmount) > 0){       
						$objBankAccount->updateOrderStatus($_POST['PurchaseID_'.$i]);
                                        }
                                                        
                                    }   
                                    /*****************/   
                                }
                        //end Ar Payment


	if($_POST['ContraAcnt'] ==1){
		$_POST['ArContraAccount'] = $ArContraAccount;		
		$ReferenceTFNo = rand ( 1 , 999999);
		$_POST['ReferenceTFNo'] = "TF".$ReferenceTFNo;
		$CustCode = $objCommon->getCustomerCode($_POST['CustomerName']);	
		$_POST['CustCode'] = $CustCode;
		$_POST['ContraID'] = $TransactionID;
		$objBankAccount->addArPaymentInfo($_POST);
		$ArpaidAmnt=0;$ArpaidOrderAmnt=0;$ArInvoiceAmount=0;$ArTotalOrderedAmount=0;
		/*****************/   
	    	for($i=1;$i<=$_POST['ArtotalInvoice'];$i++){	        
		  	if($_POST['Arinvoice_check_'.$i] == 'on' && $_POST['Arpayment_amnt_'.$i] > 0){          
				$paidAmnt = $objBankAccount->GetSalesTotalPaymentAmntForInvoice($_POST['ArInvoiceID_'.$i]);         
				$paidOrderAmnt = $objBankAccount->GetSalesTotalPaymentAmntForOrder($_POST['SaleID_'.$i]);

				$InvoiceAmount  = $_POST['ArTotalInvoiceAmount_'.$i];
				$TotalOrderedAmount  = $_POST['ArTotalAmount_'.$i];
				
				if(intval($paidAmnt) > 0){
					$objSale->updateInvoiceStatus($_POST['ArOrderID_'.$i],1);
				}
				if(intval($paidAmnt) >= intval($InvoiceAmount)){
					$objSale->updateInvoiceStatus($_POST['ArOrderID_'.$i],2);
				}
				if(intval($paidOrderAmnt) >= intval($TotalOrderedAmount)){
					$objSale->updateOrderStatus($_POST['SaleID_'.$i]);
				}



			    }
				    
		}  
		/*****************/   
         }
         //end contra
                                        
		$_SESSION['mess_payment'] = ADD_PAYMENT_INFORMATION;
		header("Location:".$RedirectURL);
		exit;

		}                               
                               
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
	$arryVendorList=$objBankAccount->getVendorList($_GET);

	/***************** 
	if($_GET['edit']>0){
		$_GET['TransactionID'] = (int)$_GET['edit'];
		$arryTransaction = $objReport->getPaymentTransaction($_GET);
		if(empty($arryTransaction[0]['TransactionID'])){
			$ErrorMsg = INVALID_REQUEST;
		}
	}
	/*****************/   
	require_once("../includes/footer.php"); 	
?>


