<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.purchase.class.php");
	$ModuleName = "Purchase";
	$objPurchase = new purchase();

	$RedirectURL = "viewPO.php?module=RMA";

	/*************************/
	$_GET['module']='RMA'; 
	$_GET['Status'] = 'Open';
	$_GET['InvoicePaid'] = '';
       
	if($_GET['link']=='editPoRma.php'){ $_GET['Status'] = ''; $_GET['Approved'] = '1';}
	 
	$objPurchase->AutoCloseExpiry();

	/*********Get Purchase RMA*********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryPurchase=$objPurchase->WarehouseListPurchasePoRmaList($_GET);	
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPurchase->WarehouseListPurchasePoRmaList($_GET);	
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);        
	/******************************/


 
	require_once("../includes/footer.php"); 	
?>
