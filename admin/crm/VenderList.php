<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'VenderList.php?module=Venderlist'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	$ModuleName = "VenderList";
	//$objCustomer = new supplier();
	$objVenderList = new supplier();


	/*************************/
	$Config['addTp'] = 'billing';
	$arryVenderList = $objVenderList->ListSupplier($_GET);
	$num=$objVenderList->numRows();

	$pagerLink=$objPager->getPager($arryVenderList,$RecordsPerPage,$_GET['curP']);
	(count($arryVenderList)>0)?($arryVenderList=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>

