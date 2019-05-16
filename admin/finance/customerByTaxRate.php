<?php 
	 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	$objCustomer = new Customer();
 	$objReport = new report();
	
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

	/*******Get Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;	
	$arryRecord=$objCustomer->GetCustomerByTax($_GET);        
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCustomer->GetCustomerByTax($_GET);      
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/


	require_once("../includes/footer.php"); 	
?>


