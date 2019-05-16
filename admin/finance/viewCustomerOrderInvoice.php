<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	
	$objCustomer=new Customer();
	$ModuleName = "Sales";
	$objSale = new sale();

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];

	$ModuleName = "Sales ".$_GET['module'];


	$ViewUrl = "viewCustomerOrderInvoice.php?module=".$module;
	//$AddUrl = "editSalesQuoteOrder.php?module=".$module;
	if($module == "Invoice"){
		$EditUrl = "editInvoice.php?curP=".$_GET['curP'];
		$ViewUrl = "vInvoice.php?&curP=".$_GET['curP']."&pop=1";
	}else{
		 $EditUrl = "editSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
	     $ViewUrl = "../sales/vSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP']."&pop=1";
	}

	$RedirectURL = "viewCustomerOrderInvoice.php?module=".$module;

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";
	}elseif($_GET['module']=='Invoice'){	
		$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	}else{
		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
	}
	/*************************/
	if(!empty($_GET['CustCode'])){
		$arrySale=$objSale->ListSale($_GET);
		$num=$objSale->numRows();
	    	
		$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
		(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	}
	/*************************/

 	$arryCustomer = $objCustomer->GetCustomerList();

	require_once("../includes/footer.php"); 	
?>


