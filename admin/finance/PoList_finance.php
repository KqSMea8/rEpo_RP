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

	/*************************/
	$_GET['module']='Order'; 
	$_GET['InvoicePaid'] = '0';
	$arryPurchase=$objPurchase->ListPurchase($_GET);
	$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
	(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


