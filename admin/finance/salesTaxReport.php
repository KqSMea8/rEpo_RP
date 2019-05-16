<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/finance.account.class.php");

	$objCustomer=new Customer();
	$objReport = new report();
  	$objBankAccount = new BankAccount();
        
        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
        if(empty($_GET['rby'])){ $_GET['rby'] = 'C'; }

 	if($_GET['rby']=='C'){ $TaxDisplay = 'style="display:none"'; }


        /*************************/
	$arrySale=$objReport->SalesTaxReportLocation($_GET);
	$num=$objReport->numRows();	
  	/*************************/
 	$GrossSale = $objReport->GrossSalesTaxLocation($_GET,'Gross','Invoice');
	$ExemptSale = $objReport->GrossSalesTaxLocation($_GET,'Exempt','Invoice');

	$TaxabaleAmount = $objReport->GrossSalesTaxLocation($_GET,'Taxabale','Invoice');
	$TaxCol = $objReport->GrossSalesTaxLocation($_GET,'TaxCol','Invoice');
	/*************************/

	$arryCustomer=$objBankAccount->getCustomerList();
	$arrySalesLocation=$objReport->GetSalesLocation('Tax');

	
	foreach($arrySalesLocation as $tax){
		$TaxRateValue = trim(stripslashes($tax['TaxRateValue']));
		$arrTx = explode(":",$TaxRateValue);
		if(!empty($arrTx[2])){
			$TaxVale = $arrTx[1].' : '.$arrTx[2].'%';
			$arryTax[] = $TaxVale;
		}
	}
	$arryTax = array_unique($arryTax);		
	//sort($arryTax);
	require_once("../includes/footer.php"); 	
?>


