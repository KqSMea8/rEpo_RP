<?php 
	//$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesPayments.php';$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
        
	$ModuleName = "Sales";
        $objCommon = new common();
        $objBankAccount=new BankAccount();
        $objSale = new sale();

	$RedirectURL = "receivePayment.php";
        
        //Get customer list
         $arryCustomerList=$objBankAccount->getCustomerList($_GET);
         
        //end
         
         //Get Bank Account
         
         $arryBankAccount=$objBankAccount->getBankAccountForReceivePayment();
         $arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
         
         
         if ($_POST) {
				/******************************/
					CleanPost();
				/******************************/
                                   $CustCode = $objCommon->getCustomerCode($_POST['CustomerName']);	
			           $_POST['CustCode'] = $CustCode;	     
                                        //echo "<pre>";
                                        //print_r($_POST);
                                        //exit;
			if(!empty($_POST['savePaymentInfo'])) {


				if(empty($_POST['PaidTo']) || empty($_POST['Method']) || empty($_POST['ReceivedAmount']) || ($_POST['ReceivedAmount'] == '0') || ($_POST['ReceivedAmount'] != $_POST['total_payment'])
                                        || ($_POST['ReceivedAmount'] > $_POST['totalOpenBalance'])) {

					$_SESSION['mess_payment'] = ERROR_IN_PAY_INVOICE;
					header("Location:".$RedirectURL);
					exit;
				}else{		

					$incomeID = $objBankAccount->addIncomeInformation($_POST);
					//$objBankAccount->sendSalesPaymentEmail($_POST);
                                        $objBankAccount->addPaymentInformation($incomeID,$_POST);
                                        
                                        
                                          //update invoice,order status
                                            
                                                for($i=1;$i<=$_POST['totalInvoice'];$i++){

                                                   $paidAmnt = $objBankAccount->GetSalesTotalPaymentAmntForInvoice($_POST['InvoiceID_'.$i]);
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


