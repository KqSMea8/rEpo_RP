<?php 
	if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPurchasePayments.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
        require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");
       
                
         $objBankAccount = new BankAccount();

	$objCommon = new common();
	$objPurchase=new purchase();

	$ModuleName = "Invoice";

	$RedirectURL = "viewPurchasePayments.php?curP=".$_GET['curP'];
	//$EditUrl = "editInvoice.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfInvoice.php?o=".$_GET["view"]; 


	if(!empty($_GET['po'])){
		$MainModuleName = "Invoices for PO Number# ".$_GET['po'];
		$RedirectURL .= "&po=".$_GET['po'];
		$EditUrl .= "&po=".$_GET['po'];
	}



        $arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();

	if ($_POST) {
		/******************************/
			CleanPost();
		/******************************/
		if(!empty($_POST['savePaymentInfo'])) {

			if(empty($_POST['PaidFrom']) || empty($_POST['Method']) || empty($_POST['PaidAmount']) || ($_POST['PaidAmount'] == '0') || ($_POST['PaidAmount'] > $_POST['TotalPaidAmount'])) {

				$_SESSION['mess_invoice'] = ERROR_IN_PAY_INVOICE;
				header("Location:".$ListUrl);
				exit;
			}
			else{	
				$objBankAccount->addPurchasePaymentInformation($_POST);
				//$objBankAccount->sendSalesPaymentEmail($_POST);
				$_SESSION['mess_invoice'] = ADD_PAYMENT_INFORMATION;
			
				$EditUrl = "payInvoiceHistory.php?view=".$_GET['view']."&po=".$_GET['po'];
				header("Location:".$EditUrl);
				exit;

		    }	
		} 
	}	

	if(!empty($_GET['view'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],'','Invoice');
		
		$OrderID   = $arryPurchase[0]['OrderID'];
		$PurchaseID   = $arryPurchase[0]['PurchaseID'];
		$InvoiceID = $arryPurchase[0]['InvoiceID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			//get payment history

			/*echo "<pre>";
			print_r($arryPurchase);
			exit;*/
			 
			 $arryPaymentInvoice = $objBankAccount->GetPurchasesPaymentInvoice($_GET['view'],$_GET['inv']);
			
			/* $paidAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForInvoice($InvoiceID);
			
			 $paidOrderAmnt = $objBankAccount->GetPurchaseTotalPaymentAmntForOrder($PurchaseID);
			 $InvoiceAmount  = $arryPurchase[0]['TotalAmount'];
			 $TotalOrderedAmount  = $arryPurchase[0]['TotalAmount'];
			 //echo "==>".$paidOrderAmnt;
			 if($paidAmnt > 0){
				   $remainInvoiceAmount = $InvoiceAmount-$paidAmnt;
				   $objBankAccount->updatePurchaseInvoiceStatus($InvoiceID,1);
				 }else{
					 $remainInvoiceAmount = $InvoiceAmount;
				 }
				if($paidAmnt >= $InvoiceAmount){
					$objBankAccount->updatePurchaseInvoiceStatus($InvoiceID,2);
				}
			  
				
			 if($paidOrderAmnt >= $TotalOrderedAmount){
			 
				    $objBankAccount->updateOrderStatus($PurchaseID);
				 }*/
			//end

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			//////////*/
		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
			
	
	if(empty($NumLine)) $NumLine = 1;
	
	$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');

	require_once("../includes/footer.php"); 	 
?>


