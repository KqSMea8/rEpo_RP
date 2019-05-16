<?php 
	include_once("../includes/header.php");
	require_once($Prefix . "classes/item.class.php");
	
	
	$objItem = new items();

	$ModuleName = "Valuation Reports";
	$ViewUrl = "viewValuationReport.php";
	$RedirectURL = "viewValuationReport.php";

	$arrySale=$objItem->GetValuationReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c']);
	$num=$objItem->numRows();

	$totalOrderAmnt = $objItem->getValuationTotAmount($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y']);

	
	
	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


