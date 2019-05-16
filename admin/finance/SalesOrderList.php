<?php 
	$HideNavigation = 1;
	/**************************************************/
	//$ThisPageName = 'viewSalesQuoteOrde.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	
	(!$_GET['module'])?($_GET['module']='Order'):(""); 
	$module = $_GET['module'];

	$ModuleName = "Sales";
	$objSale = new sale();

	$RedirectURL = "viewSalesQuoteOrde.php?module=Order";



	/*********Get Sales*************/
	$_GET['Status'] = 'Open';	
	$_GET['Approved'] = '1';
	$_GET['module'] = 'Order';

	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySale=$objSale->ListSale($_GET);
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListSale($_GET);
	$num=$arryCount[0]['NumCount'];	
	if($Config['batchmgmt']==1){
		$num=count($arryCount);
	}
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	/******************************/

	
 
	require_once("../includes/footer.php"); 	
?>


