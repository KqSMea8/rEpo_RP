<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase = new purchase();
	$objSupplier=new supplier();
	/*************************/
	$ShowData = '';
	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){

		$arryPurchase=$objPurchase->PurchaseReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['y'],$_GET['s'],$_GET['st']);
		$num=$objPurchase->numRows();

		$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
		(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");

		$ShowData = 1;
	}
	/*************************/
	$arrySupplier = $objSupplier->GetSupplierBrief('');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrderStatus','');		

	require_once("../includes/footer.php"); 	
?>


