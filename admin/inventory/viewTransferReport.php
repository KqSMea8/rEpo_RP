<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");	
	require_once($Prefix."classes/warehouse.class.php");
	
	$objItem = new items();	
	$objWarehouse=new warehouse();

	$ShowData = 0;
	/*************************/
	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){

		$arryTransfer=$objItem->TransferReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['w1'],$_GET['w2'],$_GET['ast']);

		$num=$objItem->numRows();

		$pagerLink=$objPager->getPager($arryTransfer,$RecordsPerPage,$_GET['curP']);
		(count($arryTransfer)>0)?($arryTransfer=$objPager->getPageRecords()):("");

		$ShowData = 1;
	}
	/*************************/
	
	$arryWarehouse = $objWarehouse->GetWarehouseBrief('');
	require_once("../includes/footer.php"); 	
?>


