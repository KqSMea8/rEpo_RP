<?php  $FancyBox=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");
	include_once("language/english.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Warehouse";
	$objWarehouse=new warehouse();


	/******Get Warehouse Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objWarehouse->ListWarehouse('',$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	



	require_once("../includes/footer.php"); 	 
?>


