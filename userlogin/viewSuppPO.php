<?php 
	include_once("includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/supplier.class.php");
	$objSupplier=new supplier();
	$objPurchase = new purchase();


	/*************************/
	if(!empty($_GET['sc'])){
	    $arrySupplier = $objSupplier->GetSupplier('',$_GET['sc'],'');
		if(!empty($arrySupplier[0]['SuppID'])){
			$arryPurchase=$objPurchase->GetSuppPurchase($_GET['sc'],'','','Order');
			$num=$objPurchase->numRows();

			$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
			(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");
		}else{
			$ErrorMSG = NOT_EXIST_SUPP;
		}
	}
	/*************************/
 

	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly


	require_once("includes/footer.php"); 	
?>


