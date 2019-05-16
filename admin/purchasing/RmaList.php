<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.purchase.class.php");
	$ModuleName = "Purchase";
	$objPurchase = new purchase();

	$RedirectURL = "viewPO.php?module=Invoice";

	$arryVendorList=$objPurchase->getVendorList();

	if(!empty($_GET['SuppCompany'])){
		/*************************/
		 
		$_GET['InvoicePaid']=''; 
		$_GET['module']='Invoice'; 
		$_GET['Status'] = 'Open';
		if($_GET['link']=='editRma.php'){ $_GET['Status'] = ''; $_GET['Approved'] = '1';}
		
		/*********Get Purchases*********/	
		$Config['RecordsPerPage'] = $RecordsPerPage;
		$arryPurchase=$objPurchase->ListPurchaseRma($_GET);

		/*******Count Records**********/	
		$Config['GetNumRecords'] = 1;
		$arryCount=$objPurchase->ListPurchaseRma($_GET);
		$num=$arryCount[0]['NumCount'];	
		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);        
		/******************************/
	}
		
	require_once("../includes/footer.php"); 	
?>
