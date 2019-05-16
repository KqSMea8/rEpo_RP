<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	
	$objCustomer=new Customer();
	$ModuleName = "Sales";
	$objSale = new sale();

	$module = 'Return';

	$ModuleName = "Sales ".$_GET['module'];


	$ViewUrl = "viewCustomerReturn.php?module=".$module;
	//$AddUrl = "editSalesQuoteOrder.php?module=".$module;
	$EditUrl = "editReturn.php?curP=".$_GET['curP'];
	$ViewUrl = "../sales/vReturn.php?curP=".$_GET['curP']."&pop=1";
	$RedirectURL = "viewCustomerReturn.php?module=".$module;

	$ModuleIDTitle = "Return Number"; $ModuleID = "ReturnID";
	/*************************/
	if(!empty($_GET['CustCode'])){
		$arrySale=$objSale->ListReturn($_GET);
		$num=$objSale->numRows();

		$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
		(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	}
	/*************************/

 	$arryCustomer = $objCustomer->GetCustomerList();
	require_once("../includes/footer.php"); 	
?>


