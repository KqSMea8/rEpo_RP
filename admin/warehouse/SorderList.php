<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewShipment.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();

	$RedirectURL = "viewShipment.php";
 
	(empty($_GET['CREDIT_APP']))?($_GET['CREDIT_APP']=""):("");
	(empty($_GET['Droplist']))?($_GET['Droplist']=""):("");
	/*************************
	//$_GET['Status'] = 'Open';
	$_GET['Approved'] = '1';
	$_GET['InvoiceID'] = '1';	
	$arrySale=$objSale->ListSale($_GET);
	$num=$objSale->numRows();
	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	/*********Get Sales*************/
	$_GET['Status'] = 'Open';
	$_GET['module'] = '1';
	//$_GET['InvoiceID'] = 'Order';	
	$_GET['module'] = 'Order';
	$_GET['Pick'] = '1';


	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySale=$objSale->ListSalePick($_GET);
	/*******Count Records**********/
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListSalePick($_GET);
	$num=$arryCount[0]['NumCount'];	
	 
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	/******************************/

	require_once("../includes/footer.php"); 	
?>


