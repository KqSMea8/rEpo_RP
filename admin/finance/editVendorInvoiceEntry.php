<?php 
	/**************************************************/
	$ThisPageName = 'viewPoInvoice.php'; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/supplier.class.php");
        require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/inv.condition.class.php");
 	require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	$objFunction=new functions();
        $objTransaction=new transaction();
	$objReport = new report();
        $objBankAccount= new BankAccount();
        $objSupplier = new supplier();
	$objPurchase=new purchase();
	$objTax=new tax();
        $objCondition=new condition();
	$objCommon = new common();

	$ModuleName = "Invoice Entry";
	$RedirectURL = "viewPoInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editVendorInvoiceEntry.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 
        
 	(empty($_GET['del_adj']))?($_GET['del_adj']=""):("");
 	(empty($OrderID))?($OrderID=""):("");
	(empty($PrefixPO))?($PrefixPO=""):("");
	(empty($TransactionID))?($TransactionID=""):("");

	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');

	if($_GET['del_adj'] && !empty($_GET['del_adj'])){
		$_SESSION['mess_invoice'] = INVOICE_ADJ_REMOVED;
		$objBankAccount->RemovePOAdjustment($_GET['del_adj']);
		header("Location:".$RedirectURL);
		exit;
	}

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$TransactionID = $objBankAccount->GetTransferTransactionID($_GET['del_id']);
		if($TransactionID>0){
			$objReport->RemoveVendorTransaction($TransactionID);
		}
		
		$_SESSION['mess_invoice'] = INVOICE_REMOVED;
		$objBankAccount->RemovePOInvoice($_GET['del_id'],$_GET['exp']);
		header("Location:".$RedirectURL);
		exit;
	}


	if(!empty($_POST['ReceiveOrderID']) && $_POST['GLAccountLineItemType'] == "LineItem"){
                CleanPost();   
		 
		if($_POST['TotalAmount']<=0){
			 $errMsg = "Grand Total must be greater than 0.";
		}


		if(!empty($_POST['PoInvoiceID'])){
			if($objPurchase->isInvoiceExists($_POST['PoInvoiceID'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['PoInvoiceID'] = $objConfigure->GetNextModuleID('p_order','Invoice');
			}
		}
		if(!empty($errMsg)) {
			$_SESSION['mess_purchase'] = $errMsg;			
			header("Location:".$EditUrl);
               		exit;
		}




		$_POST['InvoiceID'] = $_POST['PoInvoiceID'];
 
		/*****************/ 
		if(strtolower(trim($_POST['PaymentTerm']))=='prepayment'){
	          $_POST["AccountID"] = $_POST["BankAccount"] ;
		}		
		/***************/

		if($_POST['OrderID']>0){
			$objPurchase->UpdateOrderInvoiceEntry($_POST);
                	$objPurchase->AddItemForInvoiceEntry($_POST['OrderID'], $_POST); 
			$OrderID = $_POST['OrderID'];
			$_SESSION['mess_invoice'] = INVOICE_ENT_UPDATED.$OtherMsg;
		}else{
			$OrderID = $objPurchase->ReceiveOrderInvoiceEntry($_POST);
                	$objPurchase->AddItemForInvoiceEntry($OrderID, $_POST); 
			$_SESSION['mess_invoice'] = INVOICE_ENT_SAVED.$OtherMsg;
			$PostedOrderID = $OrderID;
		}

		/***********************Upload documents *******************************/
		if($_FILES['UploadDocuments']['name'] != ''){  




			$imageName = "Document_".$OrderID;			

			$FileInfoArray['FileType'] = "Scan";
			$FileInfoArray['FileDir'] = $Config['P_DocomentDir'];
			$FileInfoArray['FileID'] =  $imageName;
			$FileInfoArray['OldFile'] = $_POST['OldUploadDocuments'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['UploadDocuments'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){  
				$objPurchase->UpdateUploadDocuments($ResponseArray['FileName'],$OrderID);
			 
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}


				
				
					if(!empty($ErrorMsg)){
					       $_SESSION['mess_Invoice'] .= '<br><br>'.$ErrorMsg;
					}
		}
	
/***************log by sanjiv********************/
		$_POST['ModuleType'] ='PurchasesVInvoiceEntry';
		$objConfig->AddUpdateLogs($OrderID, $_POST);
		/***********************************/

		/*****AutoPostToGl**********
		include_once("../includes/AutoPostToGlApInvoice.php");
		/**************************/	


		/*******Generate PDF************/			
		$PdfArray['ModuleDepName'] = "PurchaseInvoice";
		$PdfArray['Module'] = 'Invoice';
		$PdfArray['ModuleID'] = 'InvoiceID';
		$PdfArray['TableName'] =  "p_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $OrderID;		 	
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/ 
		

		header("Location:".$RedirectURL);
		exit;
	 } 
         
         if(!empty($_POST['ReceiveOrderID']) && $_POST['GLAccountLineItemType'] == "GLAccount"){  
		$_POST['BankAccount'] =  $AccountPayable;
              	CleanPost();   
		
		

		if(!empty($_POST['PoInvoiceIDGL']) && $_POST['AdjustInvoice']!=1){
			if($objPurchase->isInvoiceExists($_POST['PoInvoiceIDGL'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['PoInvoiceIDGL'] = $objConfigure->GetNextModuleID('p_order','Invoice');
			}
		}
		if(!empty($errMsg)) {
			$_SESSION['mess_purchase'] = $errMsg;			
			header("Location:".$EditUrl);
               		exit;
		}



		/******************************/
		 if($_POST['GlEntryType'] == "Multiple"){   
			$TotGlAmount=0;
			 for($i=1;$i<=$_POST['NumLine1'];$i++){
                        	if( $_POST['invoice_check_'.$i] ==1 && ($_POST['GlAmnt'.$i] > 0 || $_POST['GlAmnt'.$i] < 0) && !empty($_POST['AccountID'.$i])){  
					$TotGlAmount += $_POST['GlAmnt'.$i];
				} 
			}

   
			if(round($TotGlAmount,2) != round($_POST['Amount'],2)){
				$_SESSION['mess_purchase'] = INVOICE_ENT_MULTIPLE_ERROR;
				$RedirectURL = "editVendorInvoiceEntry.php?edit=".$_GET['edit']; 
				 header("Location:".$RedirectURL);
               			 exit;
			}
				    
		 }  
		/******************************/


		$_POST['InvoiceID'] = $_POST['PoInvoiceIDGL'];
                $_POST['EntryType'] = $_POST['EntryTypeGL'];
                $_POST['EntryDate'] = $_POST['EntryDateGL'];
                $_POST['EntryFrom'] = $_POST['EntryFromGL'];
                $_POST['EntryTo'] = $_POST['EntryToGL'];
                
                $_POST['EntryInterval'] = $_POST['EntryIntervalGL'];
                $_POST['EntryMonth'] = $_POST['EntryMonthGL'];
                $_POST['EntryWeekly'] = $_POST['EntryWeeklyGL'];
                
                $_POST['PaymentMethod'] = $_POST['PaymentMethodGL'];
                $_POST['InvoiceComment'] = $_POST['InvoiceCommentGL'];
		$_POST['VendorInvoiceDate'] = $_POST['VendorInvoiceDateGL'];
		$_POST['ReferenceNo'] = $_POST['PurchaseIDGL'];
		$_POST['Currency'] = $_POST['CurrencyGL'];  
		$_POST['ConversionRate'] = $_POST['ConversionRateGL'];


		 if(empty($_POST['ConversionRate']) && !empty($_POST['Currency']) && $_POST['Currency']!=$Config['Currency']){
			$_POST['ConversionRate'] = CurrencyConvertor(1,$_POST['Currency'],$Config['Currency'],'AP',$_POST['PaymentDate']);
		}
		if(empty($_POST['ConversionRate'])) $_POST['ConversionRate']=1; 
		/***************/
		if($_POST['AdjustInvoice']==1){
			$_SESSION['mess_invoice'] = ADJUST_SAVED;
			$objBankAccount->addAdjustmentPO($_POST);
		}else if($_POST['OrderID']>0){
			$OrderID = $_POST['OrderID'];
			$_SESSION['mess_invoice'] = INVOICE_ENT_UPDATED.$OtherMsg;
		        $objBankAccount->updateOtherExpense($_POST);
		}else{			
			$_SESSION['mess_invoice'] = INVOICE_ENT_SAVED.$OtherMsg;
		        $OrderID = $objBankAccount->addOtherExpense($_POST);
			$PostedOrderID = $OrderID;
		}
		if($OrderID>0 && !empty($_POST['FundTransferRef'])){
			//$objBankAccount->updateOrderIDforTransfer($OrderID,$_POST['FundTransferRef']); //will be commented
			$objBankAccount->updateOrderIDforTransaction($OrderID,$_POST['FundTransferRef']); //pk
		}

/***************log by sanjiv********************/
		$_POST['ModuleType'] ='PurchasesVInvoiceEntry';
		$objConfig->AddUpdateLogs($OrderID, $_POST);
		/***********************************/

		/*****AutoPostToGl**********
		include_once("../includes/AutoPostToGlApInvoice.php");
		/**************************/	

		/*******Generate PDF************/			
		$PdfArray['ModuleDepName'] = "PurchaseInvoice";
		$PdfArray['Module'] = 'Invoice';
		$PdfArray['ModuleID'] = 'InvoiceID';
		$PdfArray['TableName'] =  "p_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $OrderID;		 	
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/ 


                header("Location:".$RedirectURL);
                exit;
	 } 
		
			
	$_GET['edit'] = (int)$_GET['edit'];
	$GLAccountLineItemType = 'GLAccount';
	if(!empty($_GET['edit'])){
		//$ErrorMSG = UNDER_MAINT;
		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Invoice');
		$OrderID   = $arryPurchase[0]['OrderID'];
		$ExpenseID   = $arryPurchase[0]['ExpenseID'];	

		if($OrderID>0){
			 
			if($arryPurchase[0]['InvoiceEntry']==1){
				$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
				$NumLine = sizeof($arryPurchaseItem);
				$arryOtherExpense = $objConfigure->GetDefaultArrayValue('f_expense');
				$GLAccountLineItem = 'Line Item';
				$GLAccountLineItemType = 'LineItem';

				$arryMultiAccount = $objConfigure->GetDefaultArrayValue('f_multi_account_payment');
			}else{
				//unset($ErrorMSG);
				$GLAccountLineItem = 'GL Account';
				$_GET['ExpenseID'] = $ExpenseID;
				$arryOtherExpense=$objBankAccount->getOtherExpense($_GET);

				if($arryOtherExpense[0]['GlEntryType']=="Multiple"){
					$arryMultiAccount=$objBankAccount->getMultiAccount($ExpenseID);
                   			$NumLine = sizeof($arryMultiAccount);
					$amntChecked = "checked";
				}else{
					$arryMultiAccount = $objConfigure->GetDefaultArrayValue('f_multi_account');
					}

				$TransactionID = $objBankAccount->GetTransferTransactionID($OrderID);
				 
				$arryPurchaseItem = $objConfigure->GetDefaultArrayValue('p_order_item');

			}

			$GlLine = str_replace(" ","",$GLAccountLineItem);
		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		$NextModuleID = $objConfigure->GetNextModuleID('p_order','Invoice');
	}



	

	if(empty($NumLine)) $NumLine = 1;	
	$arryPurchaseTax = $objTax->GetTaxRate('2');
        
        $arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
        
        
        //FOR GL ENTRY
        
        $ConditionDrop  =$objCondition-> GetConditionDropValue('');
         $WarehouseDrop  =$objCondition-> GetWarehouseDropValue('');

	$arryVendorList=$objBankAccount->getVendorList();

	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	$Config['NormalAccount']=1;
        $arryExpenseType = $objBankAccount->getBankAccount('','Yes','','','');	
	$arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();	
	unset($Config['NormalAccount']);

	$_GET['CreditCard'] = '1';
	$arryCreditCardVendor = $objSupplier->GetSupplierList($_GET);

        $arryBankAccount=$objBankAccount->getBankAccountForPaidPayment(); 
	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly
        $arryTax = $objTax->GetTaxAll('2');
       

	$objBankAccount->RemoveBlankTransfer();

	if(empty($AccountPayable)){
		 $ErrorMSG = SELECT_GL_AP_ALL; 
	}
	require_once("../includes/footer.php"); 	 
?>


