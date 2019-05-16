<?php

	include_once("../includes/header.php");
	require_once($Prefix . "classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/function.class.php");
	include_once("includes/FieldArray.php");
	 
	$objBankAccount = new BankAccount();
	$objReport = new report();
	$objTransaction=new transaction();
	$objFunction=new functions();

	$ViewUrl = "viewVendorPayment.php";
	$RedirectURL = "viewVendorPayment.php?curP=". $_GET['curP'];
	(empty($_GET['SuppCode']))?($_GET['SuppCode']=""):("");
	(empty($_GET['InvoiceGL']))?($_GET['InvoiceGL']=""):("");

	/*if($_GET['ptpt']=='3716'){
		$objBankAccount->TransactionPostToGL($_GET['ptpt'],'2016-10-03'); 
		exit;
	}*/


	/************************
	if(!empty($_GET['trans_id']) && !empty($_GET['check_no'])) {
		$_SESSION['mess_payment'] = VENDOR_PAYMENT_VOIDED;	
		$objTransaction->VoidCheckVendorPayment($_GET['trans_id'],$_GET['check_no']);
		header("location:" . $RedirectURL);
		exit;
	}
	/***********************/

	/************************/
	if(!empty($_GET['void_id'])) {
		$_SESSION['mess_payment'] = VENDOR_PAYMENT_VOIDED;	
		$objConfig->RemoveStandAloneShipment($_GET['void_id'], 'VendorPayment'); 
		$objTransaction->VoidTransactionVendorPayment($_GET['void_id']);
		header("location:" . $RedirectURL);
		exit;
	}

	/****************************/
	if(!empty($_GET['del_id'])) {
		$_SESSION['mess_payment'] = PAYMENT_REMOVED;
		$objConfig->RemoveStandAloneShipment($_GET['del_id'], 'VendorPayment'); 
		$objReport->RemoveVendorTransaction($_GET['del_id']);
		header("location:" . $RedirectURL);
		exit;
	}

	 


	/******CODE FOR POST TO GL******************************/
	if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) { 
		CleanPost();
		$ContraTransactionID='';
		foreach($_POST['posttogl'] as $TransactionID){
			/*****************
			$ContraTransactionID = $objBankAccount->GetContraID($TransactionID);
			if(empty($ContraTransactionID)){
				$ContraTransactionID = $objBankAccount->GetContraIDReverse($TransactionID);
			}
			if($TransactionID>0 && $ContraTransactionID>0){
				$TransactionID = $TransactionID.','.$ContraTransactionID;
			}
			/*****************/	
			

			$objBankAccount->TransactionPostToGL($TransactionID,$_POST['PostToGLDate']); 
		
			$objTransaction->PostToGainLoss($TransactionID,$_POST['PostToGLDate'],'AP');	

			$objConfig->CreateAPInvoiceForStandAloneFreight($TransactionID, 'VendorPayment', $_POST['PostToGLDate']); 
  			
		}
		$_SESSION['mess_payment'] = AP_POSTED_TO_GL_AACOUNT;
		header("Location:" . $RedirectURL);
		exit;
	}
	/********END CODE********************************/


	/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryVendorPayment=$objBankAccount->ListVendorPayment($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
	$arryCount=$objBankAccount->ListVendorPayment($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);

	
 	$arryVendorList=$objBankAccount->getVendorList();
	

	require_once("../includes/footer.php");
?>


