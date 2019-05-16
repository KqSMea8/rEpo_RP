<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesReturn.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.rma.class.php");
	
	$ModuleName = "Sales";
	$objwarehouserma = new warehouserma();

	$RedirectURL = "viewSalesQuoteOrde.php?module=Order";

	//$objwarehouserma->AutoCloseExpiry();

	/*********Get RMA*********/		
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySale=$objwarehouserma->warehouseRmaList($_GET);
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objwarehouserma->warehouseRmaList($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);        
	/******************************/


 
	require_once("../includes/footer.php"); 	
?>


