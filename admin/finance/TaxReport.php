<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	
	$objReport = new report();
  	$objBankAccount = new BankAccount();
        
	 
	(empty($_GET['rby']))?($_GET['rby']=""):(""); 

	if(empty($_GET['rtype'])){ $_GET['rtype'] = 'S';}
        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
        

	/*************************/
	if($_GET['rtype']=='P'){  //Purchase Tax Report
		/*************************/
		$Module = 'Purchase';
		if(empty($_GET['rby'])){ $_GET['rby'] = 'V'; }
		$arryData=$objReport->PurchaseTaxReportLocation($_GET);
		$num=$objReport->numRows();

	 	//$GrossSale = $objReport->GrossPurchaseTaxLocation($_GET,'Gross','Invoice');
		//$ExemptSale = $objReport->GrossPurchaseTaxLocation($_GET,'Exempt','Invoice');
		$TaxabaleAmount = $objReport->GrossPurchaseTaxLocation($_GET,'Taxabale','Invoice');
		$TaxCol = $objReport->GrossPurchaseTaxLocation($_GET,'TaxCol','Invoice');	

		/***Credit***/
		//$GrossSaleCredit = $objReport->GrossPurchaseTaxLocation($_GET,'Gross','Credit');
		//$ExemptSaleCredit = $objReport->GrossPurchaseTaxLocation($_GET,'Exempt','Credit');
		$TaxabaleAmountCredit = $objReport->GrossPurchaseTaxLocation($_GET,'Taxabale','Credit');
		$TaxColCredit = $objReport->GrossPurchaseTaxLocation($_GET,'TaxCol','Credit');	
		/*********/
		//$GrossSale = $GrossSale - $GrossSaleCredit;
		//$ExemptSale = $ExemptSale - $ExemptSaleCredit;
		$TaxabaleAmount = $TaxabaleAmount - $TaxabaleAmountCredit;
		$TaxCol = $TaxCol - $TaxColCredit;
		/********/


		$arryVendorList=$objBankAccount->getVendorList();
		$arryTaxRate=$objReport->GetPurchaseTaxRate('Tax');
		/*************************/


	}else{  //Sales Tax Report

		/*************************/
		$Module = 'Sales';
		if(empty($_GET['rby'])){ $_GET['rby'] = 'C'; }
		
		$arryData=$objReport->SalesTaxReportLocation($_GET);
		$num=$objReport->numRows();	
 
	 	//$GrossSale = $objReport->GrossSalesTaxLocation($_GET,'Gross','Invoice');
		//$ExemptSale = $objReport->GrossSalesTaxLocation($_GET,'Exempt','Invoice');
		$TaxabaleAmount = $objReport->GrossSalesTaxLocation($_GET,'Taxabale','Invoice');
		$TaxCol = $objReport->GrossSalesTaxLocation($_GET,'TaxCol','Invoice');	
		/***Credit***/
		//$GrossSaleCredit = $objReport->GrossSalesTaxLocation($_GET,'Gross','Credit');
		//$ExemptSaleCredit = $objReport->GrossSalesTaxLocation($_GET,'Exempt','Credit');
		$TaxabaleAmountCredit = $objReport->GrossSalesTaxLocation($_GET,'Taxabale','Credit');
		$TaxColCredit = $objReport->GrossSalesTaxLocation($_GET,'TaxCol','Credit');	
		/*********/
		//$GrossSale = $GrossSale - $GrossSaleCredit;
		//$ExemptSale = $ExemptSale - $ExemptSaleCredit;
		$TaxabaleAmount = $TaxabaleAmount - $TaxabaleAmountCredit;
		$TaxCol = $TaxCol - $TaxColCredit;
		/********/
		



		$arryCustomer=$objBankAccount->getCustomerList();
		$arryTaxRate=$objReport->GetSalesTaxRate('Tax');
		/*************************/
	} 
	 	



	/*************************/
	$arryTax = array();
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


