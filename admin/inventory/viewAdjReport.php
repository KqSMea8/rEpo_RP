<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	//require_once($Prefix."classes/purchasing.class.php");
		include_once("includes/FieldArray.php");
	//$objCommon=new common();
	$objItem = new items();
	$objSupplier=new supplier();
	$objWarehouse=new warehouse();

	$ShowData = 0;

	/*************************/
	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){

		$arryAdjustment=$objItem->AdjustmentReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['w'],$_GET['ast']);

		$num=$objItem->numRows();

		$pagerLink=$objPager->getPager($arryAdjustment,$RecordsPerPage,$_GET['curP']);
		(count($arryAdjustment)>0)?($arryAdjustment=$objPager->getPageRecords()):("");

		$ShowData = 1;
	}
	/*************************/
	$arrySupplier = $objSupplier->GetSupplierBrief('');
	$arryWarehouse = $objWarehouse->GetWarehouseBrief('');
	//$arryAdjStatus = $objCommon->GetFixedAttribute('OrderStatus','');		
	require_once("../includes/footer.php"); 	
?>


