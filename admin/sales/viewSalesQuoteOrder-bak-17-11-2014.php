<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];

	$ModuleName = "Sales ".$_GET['module'];


	$ViewUrl = "viewSalesQuoteOrder.php?module=".$module;
	$AddUrl = "editSalesQuoteOrder.php?module=".$module;
	$EditUrl = "editSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
	$ViewUrl = "vSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
	$SendUrl = "sendSO.php?module=".$module."&curP=".$_GET['curP'];

	$RedirectURL = "viewSalesQuoteOrder.php?module=".$module;

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

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


