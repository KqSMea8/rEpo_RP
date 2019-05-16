<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPoInvoice.php'; $SetFullPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase=new purchase();

	$ModuleName = "Invoice";

	$RedirectURL = "viewPoInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editPoInvoice.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfPoInvoice.php?o=".$_GET["view"]; 


	if(!empty($_GET['po'])){
		$MainModuleName = "Invoices for PO Number# ".$_GET['po'];
		$RedirectURL .= "&po=".$_GET['po'];
		$EditUrl .= "&po=".$_GET['po'];
	}





	if(!empty($_GET['view'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],'','Invoice');
		$OrderID   = $arryPurchase[0]['OrderID'];
		
		/*****************/
		if($Config['vAllRecord']!=1 && $HideNavigation != 1){
			if($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arryPurchase[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/


	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			//////////*/
		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				
	if(empty($NumLine)) $NumLine = 1;	
	

	require_once("../includes/footer.php"); 	 
?>


