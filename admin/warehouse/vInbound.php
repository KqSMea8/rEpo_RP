<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewInbound.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/inbound.class.php");
	$objInbound = new inbound();

	$ModuleName = "PO Receive";

	$RedirectURL = "viewInbound.php?curP=".$_GET['curP'];
	$EditUrl = "editInbound.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfRecieve.php?o=".$_GET["view"]; 


	if(!empty($_GET['po'])){
		$MainModuleName = "Recieve for PO Number# ".$_GET['po'];
		$RedirectURL .= "&po=".$_GET['po'];
		$EditUrl .= "&po=".$_GET['po'];
	}





	if(!empty($_GET['view'])){
		$arryPurchase = $objInbound->GetReciveWarehouse($_GET['view'],'','');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objInbound->GetWarehouseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				
	if(empty($NumLine)) $NumLine = 1;	
	

	require_once("../includes/footer.php"); 	 
?>


