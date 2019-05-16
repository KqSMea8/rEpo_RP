<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewTransfer.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/category.class.php");
	$ModuleName = "Stock Transfer";
	$objItem = new items();

	$objItem=new items();
	$objCategory=new category();
	$RedirectURL = "viewTransfer.php".$_GET['curp'];

	/*************************/
	
	$_GET['Status'] = 2;

	$arryTransfer = $objItem->ListingTransfer($_GET);
	
	$num=$objItem->numRows();

	$pagerLink=$objPager->getPager($arryTransfer,$RecordsPerPage,$_GET['curP']);
	(count($arryTransfer)>0)?($arryTransfer=$objPager->getPageRecords()):(""); 
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>



