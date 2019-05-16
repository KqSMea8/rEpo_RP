<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$ModuleName = "Purchase";
	$objPurchase = new purchase();

	if(!empty($_GET['module'])) $module = $_GET['module'];else $module = 'Order';
        $RedirectURL = "viewPO.php?module=".$module;
        
        $EditURL = "editSalesQuoteOrder.php?module=".$module;
	if(!empty($_GET['o'])) $EditURL .= "&edit=".$_GET['o'];


	/*********Get Purchases*********/	
	$_GET['module']='Order'; 
	$_GET['Status'] = 'Open';
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryPurchase=$objPurchase->ListPurchase($_GET);
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPurchase->ListPurchase($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);        
	/******************************/


	require_once("../includes/footer.php"); 	
?>


