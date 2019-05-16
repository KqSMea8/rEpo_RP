<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/finance.account.class.php");
        $objBankAccount = new BankAccount();
	$objCustomer = new Customer();
	

	if(!empty($_GET['cust'])) {
		$arryCustomer = $objCustomer->GetCustomer('',$_GET['cust'],'');

		if($arryCustomer[0]['Cid']<=0){
			$ErrorExist=1;
			$ErrorMSG =  CUSTOMER_NOT_EXIST;
		}else{
			$arryInvoice=$objBankAccount->InvoiceReportSales('','',$_GET['cust'],'');
			$num=$objBankAccount->numRows();	
		}
	}else{
		$ErrorExist=1;
		$ErrorMSG = INVALID_REQUEST;
	}



	require_once("../includes/footer.php"); 	
?>


