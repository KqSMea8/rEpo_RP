<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewInternalBinOrder.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/bom.class.php");
		/*************************/
		$ModuleName = "Internal Bin Order";
		$objWarehouse = new warehouse();
		$objBOM = new bom();
		
		/*************************/
		$_GET['module']='Order'; 
		$_GET['Status'] = 2;
			
		$arryInternalBinOrder = $objWarehouse->ListBinProduction('',$_GET['key'],'','',$_GET['Status']);
			
		$num=$objWarehouse->numRows();
		$pagerLink=$objPager->getPager($arryInternalBinOrder,$RecordsPerPage,$_GET['curP']);
		(count($arryInternalBinOrder)>0)?($arryInternalBinOrder=$objPager->getPageRecords()):("");
		/*************************/
	 
	require_once("../includes/footer.php"); 
	/**************************************************/	
?>
