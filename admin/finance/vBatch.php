<?php 
	/**************************************************/
	$ThisPageName = 'viewBatch.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");	
	require_once($Prefix . "classes/finance.class.php");
	require_once($Prefix . "classes/finance.account.class.php");
	$objCommon = new common();
	$objBankAccount = new BankAccount();
	$ModuleName = "Batch";	
	$_GET["BatchType"] = "Check";
	$RedirectURL = "viewBatch.php?curP=".$_GET['curP'];
	
	(empty($_GET['batch']))?($_GET['batch']=""):("");
	(empty($CheckBox))?($CheckBox=""):("");
		
	$_GET['view']=(int)$_GET['view'];

	/**************************/
	if (!empty($_POST['RemoveFromBatch']) && !empty($_POST['TransactionID'])) { 
		CleanPost();
		$objCommon->RemoveFromBatch($_GET['view'],$_POST['TransactionID']); 		
		$_SESSION['mess_batch'] = BATCH_CHECK_REMOVED;
		$RedirectURL = "vBatch.php?view=".$_GET['view'];
		header("Location:" . $RedirectURL);
		exit;
	}
	/********END CODE**************/





	if(!empty($_GET['view'])) {
	    	$arryBatch = $objCommon->GetBatch($_GET['view'], '');	
		if(empty($arryBatch[0]['BatchName'])){
			$ErrorMSG = INVALID_REQUEST;
		}else{
			$_GET['Method'] = 'Check';
			$_GET['BatchID'] = $_GET['view'];
			$arryPaymentInvoice = $objBankAccount->ListVendorPayment($_GET);
			$num = $objBankAccount->numRows();
		}	   
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}

	require_once("../includes/footer.php"); 	 
?>
