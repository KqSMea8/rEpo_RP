<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewWarehouse.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");
	$ModuleName = "Warehouse";
	$objWarehouse=new warehouse();


	/******Get Warehouse Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	
 
	require_once("../includes/footer.php"); 	
?>


