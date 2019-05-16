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
		$ViewUrl = "vInvoice.php?&curP=".$_GET['curP'];
	}else{
		 $EditUrl = "editSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
	     $ViewUrl = "vSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
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

	$arrySale=$objSale->ListSale($_GET);
	$num=$objSale->numRows();
    $arryCustomer=$objCustomer->getCustomers('','','active','','');

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


