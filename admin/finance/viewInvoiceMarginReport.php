<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");

	
	$objSale = new sale();	 
	$objReport = new report();

		       
        
        if($_GET['t']>0){ $ToDate = $_GET['t'];}else{$ToDate = date('Y-m-d');}
        if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-01');}
        
	$arrySale=$objReport->InvoiceMarginReport($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);
	$num=$objReport->numRows();
	
	

	/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>



