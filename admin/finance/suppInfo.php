<?php 
	$HideNavigation = 1;
	/**************************************************/
	//$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");

	$objSupplier=new supplier();

	if (!empty($_GET['view'])) {
		$arrySupplier = $objSupplier->GetSupplier('',$_GET['view'],'');
		$SuppID   = $_GET['view'];	
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}
	require_once("../includes/footer.php"); 	 
?>


