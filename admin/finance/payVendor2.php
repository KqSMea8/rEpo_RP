<?php 
	//$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPurchasePayments.php';$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account2.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
        require_once($Prefix."classes/finance.report.class.php");
	
	 
        $objReport = new report();
        
	$ModuleName = "Purchases";
        $objCommon = new common();
        $objBankAccount=new BankAccount();
        $objSale = new sale();

	$RedirectURL = "payVendor2.php";
        
        //Get vendor list
         $arryVendorList=$objBankAccount->getVendorList($_GET);
         
        //end
         
        //GET FISCAL YEAR
         
         $FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
         $FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');
          $AccountPayable = $objCommon->getSettingVariable('AccountPayable');
        //GET CURRENT PERIOD
         $APCurrentPeriod =  $objReport->getCurrentPeriod('AP');
         $currentDate = date('Y-m-d');
         $CurrentPeriodDate = $objReport->getCurrentPeriodDate('AP');
         
         //GET BACK OPEN MONTH
         $arryBackMonth = $objReport->getBackOpenMonth('AP');
         
         $strBackDate = '';
         for($i=0;$i<count($arryBackMonth);$i++)
         {
            
             $strBackDate .= $arryBackMonth[$i]['PeriodYear'].'-'.$arryBackMonth[$i]['PeriodMonth'].',';
         }
        
        $strBackDate = rtrim($strBackDate,",");
       
         //end
         
         //Get Bank Account
         
         $arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();
         $arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
         
         
         if ($_POST) {
				$_POST['AccountPayable'] =  $AccountPayable;
				/******************************/
					CleanPost();
				/******************************/
                                  
			if(!empty($_POST['savePaymentInfo'])) {


				if(empty($_POST['PaidFrom']) || empty($_POST['Method']) || empty($_POST['PaidAmount']) || ($_POST['PaidAmount'] == '0') || ($_POST['PaidAmount'] != $_POST['total_payment'])
                                        || ($_POST['PaidAmount'] > $_POST['totalOpenBalance'])) {

					$_SESSION['mess_payment'] = ERROR_IN_PAY_INVOICE;
					header("Location:".$RedirectURL);
					exit;
				}else{		

					
                                        //$expenseID = $objBankAccount->addExpenseInformation($_POST);
                                        
                                        $objBankAccount->addPurchasePaymentInformation($_POST);
                                        //$objBankAccount->sendSalesPaymentEmail($_POST);
                                         
                                          //update invoice,order status
                                        
                                                //echo "<pre>";
                                                //print_r($_POST);
                                               // exit;
                                        
                                               
                                            $paidAmnt = 0; $paidOrderAmnt = 0;$TotalOrderedAmount=0;$InvoiceAmount=0;
                                                for($i=1;$i<=$_POST['totalInvoice'];$i++){

                                                 
                                                    
                                                    if($_POST['invoice_check_'.$i] == 'on' && $_POST['payment_amnt_'.$i] > 0){
                                                    
                                                        $paidAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForInvoice($_POST['InvoiceID_'.$i]);
                                                        
                                                        
                                                        if($_POST['InvoiceEntry_'.$i] == 1)
                                                        {
                                                        
                                                           $paidOrderAmnt = $_POST['payment_amnt_'.$i];
                                                           $TotalOrderedAmount  = $_POST['TotalInvoiceAmount_'.$i];
                                                           
                                                        }else{
                                                            
                                                             $paidOrderAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForOrder($_POST['PurchaseID_'.$i]);
                                                             $TotalOrderedAmount  = $_POST['TotalAmount_'.$i];
                                                        }
                                                       

                                                        
                                                        $InvoiceAmount  = $_POST['TotalInvoiceAmount_'.$i];
                                                        
                                                        
                                                        //$payment_amnt  = $_POST['payment_amnt_'.$i];
                                                        
                                                    
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
                                                    
                                                }
                                        //end
                                        
                                        
					$_SESSION['mess_payment'] = ADD_PAYMENT_INFORMATION;
					header("Location:".$RedirectURL);
					exit;

				}
                                
                               
			 } 
		}	
                
                
         if(empty($AccountPayable)){
		$ErrorMsg  = SELECT_GL_AP;
	}else  if ($FiscalYearStartDate == "" && $FiscalYearEndDate == "") {
		$ErrorMsg  = SETUP_FISCAL_YEAR;
	}        
 
	require_once("../includes/footer.php"); 	
?>


