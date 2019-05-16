<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	
	$objSupplier=new supplier();


	/*************************/
	$arrySupplier=$objSupplier->ListSupplier('',$_GET['key'],'','',1);
	$num=$objSupplier->numRows();

	$pagerLink=$objPager->getPager($arrySupplier,$RecordsPerPage,$_GET['curP']);
	(count($arrySupplier)>0)?($arrySupplier=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


