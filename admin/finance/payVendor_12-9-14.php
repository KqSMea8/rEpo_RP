<?php 
	//$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPurchasePayments.php';$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
        
	$ModuleName = "Purchases";
        $objCommon = new common();
        $objBankAccount=new BankAccount();
        $objSale = new sale();

	$RedirectURL = "payVendor.php";
        
        //Get vendor list
         $arryVendorList=$objBankAccount->getVendorList($_GET);
         
        //end
         
         //Get Bank Account
         
         $arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();
         $arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
         
         
         if ($_POST) {
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

					
                                        $expenseID = $objBankAccount->addExpenseInformation($_POST);
                                        
                                        $objBankAccount->addPurchasePaymentInformation($expenseID,$_POST);
                                        //$objBankAccount->sendSalesPaymentEmail($_POST);
                                         
                                          //update invoice,order status
                                            
                                                for($i=1;$i<=$_POST['totalInvoice'];$i++){

                                                   /*$paidAmnt = $objBankAccount->GetSalesTotalPaymentAmntForInvoice($_POST['InvoiceID_'.$i]);
                                                   $paidOrderAmnt = $objBankAccount->GetSalesTotalPaymentAmntForOrder($_POST['SaleID_'.$i]);
                                                   $InvoiceAmount  = $_POST['TotalInvoiceAmount_'.$i];
                                                   $TotalOrderedAmount  = $_POST['TotalAmount_'.$i];
                                                  // echo "=>".$paidAmnt;exit;
                                                   if($paidAmnt > 0){
                                                             $objSale->updateInvoiceStatus($_POST['OrderID_'.$i],1);
                                                           }
                                                   if($paidAmnt >= $InvoiceAmount){
                                                              $objSale->updateInvoiceStatus($_POST['OrderID_'.$i],2);
                                                           }

                                                   if($paidOrderAmnt >= $TotalOrderedAmount){

                                                              $objSale->updateOrderStatus($_POST['SaleID_'.$i]);
                                                           }*/
                                                    
                                                    
                                                        $paidAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForInvoice($_POST['InvoiceID_'.$i]);

                                                        $paidOrderAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForOrder($_POST['PurchaseID_'.$i]);
                                                        $InvoiceAmount  = $_POST['TotalInvoiceAmount_'.$i];
                                                        $TotalOrderedAmount  = $_POST['TotalAmount_'.$i];
                                                        //echo "==>".$paidOrderAmnt;
                                                        if($paidAmnt > 0){
                                                          $objBankAccount->updatePurchaseInvoiceStatus($_POST['InvoiceID_'.$i],1);
                                                        } 
                                                        if($paidAmnt >= $InvoiceAmount){
                                                             $objBankAccount->updatePurchaseInvoiceStatus($_POST['InvoiceID_'.$i],2);
                                                        }


                                                        if($paidOrderAmnt >= $TotalOrderedAmount){

                                                          $objBankAccount->updateOrderStatus($_POST['PurchaseID_'.$i]);
                                                        }
                                                    
                                                }
                                        //end
                                        
                                        
					$_SESSION['mess_payment'] = ADD_PAYMENT_INFORMATION;
					header("Location:".$RedirectURL);
					exit;

				}
                                
                               
			 } 
		}	
                
                
              
 
	require_once("../includes/footer.php"); 	
?>


