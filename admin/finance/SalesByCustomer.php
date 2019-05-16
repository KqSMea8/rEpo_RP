<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/finance.account.class.php"); 
	$objCustomer = new Customer();
  	$objBankAccount = new BankAccount(); 
 
        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
      	 
	/*******Get Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;	
	$arryData=$objCustomer->GetSalesByCustomer($_GET);	 
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;       
	$arryCount=$objCustomer->GetSalesByCustomer($_GET);  
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/
	$arryCustomer=$objBankAccount->getCustomerList();
	/*************************/

	require_once("../includes/footer.php"); 	
?>


