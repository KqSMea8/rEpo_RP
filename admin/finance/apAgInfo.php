<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase = new purchase();
	$objSupplier=new supplier();
	

	if (!empty($_GET['supp'])) {
		$arrySupplier = $objSupplier->GetSupplier('',$_GET['supp'],'');
		$SuppID   = $_GET['supp'];	
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}else{
			$arryInvoice=$objPurchase->InvoiceReport('','',$_GET['supp'],'');
			$num=$objPurchase->numRows();		
		}
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}

	require_once("../includes/footer.php"); 	
?>


