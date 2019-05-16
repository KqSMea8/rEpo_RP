<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/finance.account.class.php");

	 
	$objSale = new sale();
	$objBankAccount = new BankAccount();

	$ModuleName = "Sales Statistics";
	$ViewUrl = "viewSalesStatistics.php";
	$RedirectURL = "viewSalesStatistics.php";
	
	$arrySale=$objSale->SalesReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$_GET['s'],$_GET['st']);
	$num=$objSale->numRows();
	
	//get order total amnt by customer
	$totalOrderAmnt = $objSale->getCustomerOrderedAmount($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);;
	
    	$arryCustomer=$objBankAccount->getCustomerList();
	
	

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


