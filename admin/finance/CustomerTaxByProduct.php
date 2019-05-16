<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	$objCustomer = new Customer();
  	$objBankAccount = new BankAccount();
        $objReport = new report();
	if(empty($_GET['rtype'])){ $_GET['rtype'] = 'S';}
        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
        	

	/*******Tax Rate***********/
	$arryTaxRate=$objReport->GetSalesTaxRate('Tax');
	foreach($arryTaxRate as $tax){
		$TaxRateValue = trim(stripslashes($tax['TaxRateValue']));
		$arrTx = explode(":",$TaxRateValue);
		if(!empty($arrTx[2])){
			$TaxVale = $arrTx[1].' : '.$arrTx[2].'%';
			$arryTax[] = $TaxVale;
		}
	}
	$arryTax = array_unique($arryTax);	 
	/***************************************/



	/*************************/
	$Module = 'Sales';
	if(empty($_GET['rby'])){ $_GET['rby'] = 'C'; }
	
	 
	/*******Get Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;	
	$arryData=$objCustomer->CustomerTaxByProduct($_GET);        
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCustomer->CustomerTaxByProduct($_GET);      
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/



	$arryCustomer=$objBankAccount->getCustomerList();

	/*************************/
	
	 	



	/*************************
	foreach($arryTaxRate as $tax){
		$TaxRateValue = trim(stripslashes($tax['TaxRateValue']));
		$arrTx = explode(":",$TaxRateValue);
		if(!empty($arrTx[2])){
			$TaxVale = $arrTx[1].' : '.$arrTx[2].'%';
			$arryTax[] = $TaxVale;
		}
	}
	$arryTax = array_unique($arryTax);		
	/*************************/


	require_once("../includes/footer.php"); 	
?>


