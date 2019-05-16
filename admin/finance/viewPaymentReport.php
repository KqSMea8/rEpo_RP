<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase = new purchase();
	$objSupplier=new supplier();
	/*************************/
	if(!empty($_GET['f']) && !empty($_GET['t'])){
		$arryPayment=$objPurchase->PaymentReport($_GET['f'],$_GET['t'],$_GET['s']);
		$num=$objPurchase->numRows();

		$pagerLink=$objPager->getPager($arryPayment,$RecordsPerPage,$_GET['curP']);
		(count($arryPayment)>0)?($arryPayment=$objPager->getPageRecords()):("");
	}
	/*************************/
	$arrySupplier = $objSupplier->GetSupplierBrief('');

	require_once("../includes/footer.php"); 	
?>


