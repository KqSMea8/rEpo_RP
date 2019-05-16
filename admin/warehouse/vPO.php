<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");

	$objPurchase=new purchase();
	$objTax=new tax();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Purchase ".$_GET['module'];

	$RedirectURL = "viewPO.php?module=".$module."&curP=".$_GET['curP'];
	$EditUrl = "editPO.php?edit=".$_GET["view"]."&module=".$module."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfPO.php?o=".$_GET["view"]."&module=".$module; 

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER;
	}

	if(!empty($_GET['view']) || !empty($_GET['po'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],$_GET['po'],$module);
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

	if(empty($NumLine)) $NumLine = 1;	


	$arryPurchaseTax = $objTax->GetTaxRate('2');

	$_SESSION['DateFormat']= $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>


