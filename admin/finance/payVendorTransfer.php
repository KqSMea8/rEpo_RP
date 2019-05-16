<?php 	
	/**************************************************/
	$HideNavigation = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/supplier.class.php");

        $objReport = new report();  	
        $objCommon = new common();
        $objBankAccount=new BankAccount();     
	$objTransaction=new transaction();
	$objSupplier=new supplier();
	$objPurchase=new purchase();

	$SuppID   = (int)$_GET['SuppID'];
	$OrderID   = (int)$_GET['OrderID'];
	$RefNo = $_GET['Ref'];
	$RedirectURL = "payVendorTransfer.php?SuppID=".$SuppID;
        $Config['TransferFund'] = 1; 
   	$ContraTransactionID='';
	/**********************************/
	if(!empty($SuppID)) {
		$arrySupplier = $objSupplier->GetSupplier($SuppID ,'','');			
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMsg = NOT_EXIST_SUPP;
		}else{
			$PaidTo = $arrySupplier[0]['SuppCode'];
			$PaidToVendor = $arrySupplier[0]['VendorName'];
			if($OrderID>0){
				$RedirectURL .= '&OrderID='.$OrderID;

				$_GET['edit'] = $objBankAccount->GetTransferTransactionID($OrderID);
				 
			}else if(!empty($RefNo)){
				$_GET['edit'] = $objBankAccount->GetTransferTransactionIDRef($RefNo);
			}		
		}
	}else{
		$ErrorMsg = INVALID_REQUEST;
	}
        /**********************************/



	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');

	
	 if(!empty($_POST['PaidFrom'])){
		CleanPost();			
		$_POST['AccountPayable'] =  $AccountPayable;
			
		if(!empty($_POST['PoInvoiceIDGL']) && $_POST['AdjustInvoice']!=1){
			if($objPurchase->isInvoiceExists($_POST['PoInvoiceIDGL'],$OrderID)){
				$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
			}
		}
		if(!empty($errMsg)) {
			$_SESSION['mess_transfer'] = $errMsg;			
			header("Location:".$RedirectURL);
               		exit;
		}

		 
		$_POST['InvoiceID'] = $_POST['PoInvoiceIDGL'];                                
                $_POST['InvoiceComment'] = $_POST['Comment'];
		$_POST['Amount'] = $_POST['PaidAmount'];
		$_POST['PaymentDate'] = $_POST['Date'];
		$_POST['EntryType'] = 'one_time';
		$_POST['GlEntryType'] = 'Single';
		$_POST['GLAccountLineItemType'] = "GLAccount";


	
		if(!empty($_POST['PaidAmount'])  || $_POST['PaidAmount']=='0' ){
			/*if(empty($_POST['PaidFrom']) || ($_POST['PaidAmount'] == '') || ($_POST['PaidAmount'] != $_POST['TotalOriginalAmount'])   ) { */

			if(empty($_POST['PaidFrom']) || ($_POST['PaidAmount'] == '') || ($_POST['TotalOriginalAmount']=='')   ) { 
				$_SESSION['mess_transfer'] = ERROR_IN_PAY_INVOICE;
				header("Location:".$RedirectURL);
				exit;
			}else{	

				$_POST['TransferOrderID'] = $OrderID;
				$_POST['TransferSuppCode'] = $arrySupplier[0]['SuppCode'];
				

				/*******Invoice********/		
				if($_POST['TransactionID']>0){					
					$objReport->RemovePaymentTransaction($_POST['TransactionID']);
				}
        			$TransactionID = $objTransaction->addPayVendorTransfer($_POST);	
				/********Credit*********/ 
				$objTransaction->addCreditVendorTransfer($TransactionID,$_POST);			
				/********GL*********/ 
				$objTransaction->addGlAPTransfer($TransactionID,$_POST);		
			   	/*****************/  
			
				
				if($OrderID>0){	
					$_POST['OrderID'] = $OrderID;				 
					$_SESSION['mess_invoice'] = INVOICE_ENT_UPDATED;
					$objBankAccount->updateOtherExpense($_POST);
				}else{			
					$_SESSION['mess_invoice'] = INVOICE_ENT_SAVED;
					$OrderID = $objBankAccount->addOtherExpense($_POST);				 
				}
				if($OrderID>0 && !empty($_POST['ReferenceNo'])){				 
					$objBankAccount->updateOrderIDforTransaction($OrderID,$_POST['ReferenceNo']); //pk
				}

				
				echo '<script>window.parent.location.href="viewPoInvoice.php";</script>';
				exit;
                                       
				/*$TransferFundLink = $RedirectURL."&OrderID=".$OrderID."&Ref=".$_POST['ReferenceNo'];
				echo '<script language="JavaScript1.2" type="text/javascript">
				window.parent.document.getElementById("FundTransferRef").value="'.$_POST['ReferenceNo'].'";
				window.parent.document.getElementById("TransferFundLink").href="'.$TransferFundLink.'";
				parent.jQuery.fancybox.close();
				</script>';*/

		}                               
                               
	   } 
	}	
        /**********************************/       
        /**********************************/       
	if(empty($AccountPayable)){
		$ErrorMsg  = SELECT_GL_AP;
	}

	$arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();
	$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');  
       
	$Config['NormalAccount']=1;
        $arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();
	unset($Config['NormalAccount']);
	$arryVendorList=$objBankAccount->getVendorList();
	
	/*****************/	
	if($_GET['edit']>0){		
		$_GET['TransactionID'] = (int)$_GET['edit'];
		$_GET['PaymentType'] = 'Purchase';
		$arryTransaction = $objReport->getPaymentTransaction($_GET);

		if(empty($arryTransaction[0]['TransactionID'])){
			$ErrorMsg = INVALID_REQUEST;
		}else{
			$ReferenceNo = $arryTransaction[0]['ReferenceNo']; //pk	
			$TransactionID =  $arryTransaction[0]['TransactionID'];
			$ModuleCurrency =  $arryTransaction[0]['ModuleCurrency'];
			$objTransaction->ResetDeletedFlag($TransactionID);
			unset($_GET['TransactionID']);			
		}
		$PageHeading = 'Edit Vendor Transfer';

		$ClassName = 'inputbox';
		$ClassDate = 'datebox';	
		$Disabled='';
	}else{
		$PageHeading = 'Vendor Transfer';
		
		$ClassName = 'disabled_inputbox';
		$ClassDate = 'datebox disabled';	
		$Disabled = 'disabled';

		$TransferPrefix = $objCommon->getSettingVariable('TRANSFER_PAYMENT_PREFIX');	//pk		
		$ReferenceNo = $TransferPrefix.rand(999,9999999999999);

		$arryTransaction = $objConfigure->GetDefaultArrayValue('f_transaction');
	}
	/*****************/   

	$Config['NormalAccount']=1;
        $arryExpenseType = $objBankAccount->getBankAccount('','Yes','','','');	

	/*****************/ 	
	$objTransaction->RemoveSessionTransaction('AP');	
	/*****************/ 

	require_once("../includes/footer.php"); 	
?>


