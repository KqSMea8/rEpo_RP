<?php
include_once("../includes/header.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix."classes/finance.report.class.php");
require_once($Prefix."classes/finance.transaction.class.php");
require_once($Prefix."classes/product.class.php");
include_once("includes/FieldArray.php");


$objBankAccount = new BankAccount();
$objReport = new report();
$objTransaction=new transaction();

$SendUrl = "sendcashreceipt.php?curP=".$_GET['curP'];

$ViewUrl = "viewCashReceipt.php";  
$RedirectURL = "viewCashReceipt.php?curP=" . $_GET['curP']; 

(empty($_GET['CustID']))?($_GET['CustID']=""):("");
(empty($_GET['InvoiceGL']))?($_GET['InvoiceGL']=""):("");

/************************
if($_GET['PK_to_GL']=='5555666666666'){
	$objReport->TransactionPostForVendorCommission('893','2018-04-30');
	exit;	
}
/************************/
if(!empty($_GET['void_id'])) {
	$_SESSION['mess_Invoice'] = CASH_RECEIPT_VOIDED;	
	$objTransaction->VoidTransactionCashReceipt($_GET['void_id']);
	header("location:" . $RedirectURL);
	exit;
}
/************************/
if(!empty($_GET['del_id'])) {
	$_SESSION['mess_Invoice'] = CASH_RECEIPT_REMOVED;	
	$objReport->RemoveTransaction($_GET['del_id']);
	header("location:" . $RedirectURL);
	exit;
}

/************************/
if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$EcomFlag=1;
	}
}





/******CODE FOR POST TO GL******************************/
if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) { 
	CleanPost();
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
 
		if($EcomFlag==1){ 
			$objTransaction->RefundOnAmazonEbay($Prefix,$TransactionID,$_POST['gldate']);		 
		}
		
		
		$objBankAccount->TransactionPostToGL($TransactionID,$_POST['gldate']); 	

		$objTransaction->PostToGainLoss($TransactionID,$_POST['gldate'],'AR');	

		$objReport->TransactionPostForVendorCommission($TransactionID,$_POST['gldate']); 		
		  
	}
	$_SESSION['mess_Invoice'] = AR_POSTED_TO_GL_AACOUNT;
	header("Location:" . $RedirectURL);
	exit;
}
/********END CODE********************************/

 



$_GET["customview"] = 'All';
/*************************/	
$Config['RecordsPerPage'] = $RecordsPerPage;
$arryCash=$objBankAccount->ListCashReceipt($_GET);

/*******Count Records**********/	
$Config['GetNumRecords'] = 1;
$arryCount=$objBankAccount->ListCashReceipt($_GET);
$num=$arryCount[0]['NumCount'];	

$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
 

 

	$arryCustomerList=$objBankAccount->getCustomerList();






require_once("../includes/footer.php");
?>


