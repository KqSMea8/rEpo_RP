<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	$ModuleName = "BOM";
	$objBom=new bom();


	/*************************/
	$_GET['Status'] =1;
	$arryBOM=$objBom->ListBOM('',$_GET['key'],$_GET['sortby'],$_GET['asc'],1);
	$num=$objBom->numRows();

	$pagerLink=$objPager->getPager($arryBOM,$RecordsPerPage,$_GET['curP']);
	(count($arryBOM)>0)?($arryBOM=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


