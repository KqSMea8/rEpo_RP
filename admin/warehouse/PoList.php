<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$ModuleName = "Purchase";
	$objPurchase = new purchase();

	$RedirectURL = "viewPO.php?module=Order";


	/*********Get Purchase Order*********/	
	$_GET['module']='Order'; 
	//$_GET['Status'] = 'Open';
	$_GET['Order_Type'] = 'Standard';
	$_GET['close_status'] == 0;

	if($_GET['link']=='editReturn.php'){ $_GET['Status'] = ''; $_GET['Approved'] = '1';}
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
