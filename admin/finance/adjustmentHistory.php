<?php 
	/**************************************************/
	$ThisPageName = 'viewPoInvoice.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");                   
        $objBankAccount=new BankAccount();	

	if(!empty($_GET['inv'])){
		$InvoiceID = $_GET['inv'];
		$arryInvoice = $objBankAccount->GetPoInvoice($InvoiceID);

		$arryAdjustment = $objBankAccount->GetAdjustmentList($InvoiceID);
		$num=$objBankAccount->numRows(); 
      
		if($num>0 && $arryInvoice[0]['OrderID']>0){
			/*$RecordsPerPage = 1000;
			$pagerLink=$objPager->getPager($arryAdjustment,$RecordsPerPage,$_GET['curP']);
			(count($arryAdjustment)>0)?($arryAdjustment=$objPager->getPageRecords()):("");*/ 
		}else{
			header("location:".$ThisPageName);
			exit;
		}
	}else{
		header("location:".$ThisPageName);
		exit;
	}
 
	require_once("../includes/footer.php"); 	
?>


