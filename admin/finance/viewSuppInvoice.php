<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/supplier.class.php");
	$objSupplier=new supplier();
	$objPurchase = new purchase();


	

	/*************************/
	if(!empty($_GET['sc'])){
	    $arrySupplier = $objSupplier->GetSupplier('',$_GET['sc'],'');
		if(!empty($arrySupplier[0]['SuppID'])){
			$arryInvoice=$objPurchase->GetSuppPurchase($_GET['sc'],'','','Invoice');
			$num=$objPurchase->numRows();

			$pagerLink=$objPager->getPager($arryInvoice,$RecordsPerPage,$_GET['curP']);
			(count($arryInvoice)>0)?($arryInvoice=$objPager->getPageRecords()):("");
		}else{
			$ErrorMSG = NOT_EXIST_SUPP;
		}
	}
	/*************************/
 


	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


