<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");	
	require_once($Prefix . "classes/finance.class.php");
	require_once($Prefix . "classes/finance.account.class.php");
	$objCommon = new common();
	$objBankAccount = new BankAccount();
	$_GET['batch']=(int)$_GET['batch'];

	$RedirectURL = "vBatch.php?view=".$_GET['batch'];
	/**************************/
	if (!empty($_POST['MoveToBatch']) && !empty($_POST['TransactionID'])) { 
		CleanPost();
		$objCommon->CheckToBatch($_GET['batch'],$_POST['TransactionID']); 		
		$_SESSION['mess_batch'] = BATCH_MOVED;
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;
	}
	/********END CODE**************/

	if(!empty($_GET['batch'])) {
	    	$arryBatch = $objCommon->GetBatch($_GET['batch'], '');	
		if(empty($arryBatch[0]['BatchName'])){
			$ErrorMSG = INVALID_REQUEST;
		}	   
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}

	$_GET['Method'] = 'Check';
	$_GET['PostToGL'] = 'No';
	$arryPaymentInvoice = $objBankAccount->ListVendorPayment($_GET);
	$num = $objBankAccount->numRows();

	require_once("../includes/footer.php"); 	 
?>
