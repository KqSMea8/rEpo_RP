<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewInvoice.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");

	$objSale = new sale();

	
	/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySale=$objSale->ListARInvoice($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListARInvoice($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);  
 
	require_once("../includes/footer.php"); 	
?>


