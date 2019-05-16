<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	
	 
	$objReport = new report();
	$objBankAccount = new BankAccount();
	$ModuleName = "Customer Tax Report";
	 
        (empty($_GET['c']))?($_GET['c']=""):(""); 
	(empty($_GET['st']))?($_GET['st']=""):("");
	 

        
        if($_GET['t']>0){ $ToDate = $_GET['t'];}else{$ToDate = date('Y-m-d');}
        if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-1');}
        
	$arrySale=$objReport->SalesTaxReport($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);
	$num=$objReport->numRows();
	
	//get total tax amnt by customer
	#$totalTaxAmnt = $objReport->getCustomerTaxAmount($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);
	
        
	
	$arryCustomer=$objBankAccount->getCustomerList();

	/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


