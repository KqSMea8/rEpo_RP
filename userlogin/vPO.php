<?php 
	if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php'; $SetFullPage = 1;
	/**************************************************/

	include_once("includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();

	$objPurchase=new purchase();
	$objTax=new tax();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Purchase ".$_GET['module'];

	$RedirectURL = "dashboard.php?tab=general&curP=".$_GET['curP'];
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
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				



	/*******************/
	$arryOrderStatusTemp = $objCommon->GetFixedAttribute('OrderStatus','');		
	for($i=0;$i<sizeof($arryOrderStatusTemp);$i++) {
		$arryOrderStatus[] = $arryOrderStatusTemp[$i]['attribute_value'];
	}
	if(in_array($arryPurchase[0]['Status'],$arryOrderStatus) && $arryPurchase[0]['Approved'] == 1){
		$OrderIsOpen = 1;
	}else if($arryPurchase[0]['Status'] == 'Cancelled' || $arryPurchase[0]['Status'] == 'Rejected'){
		$CancelledRejected = 1;
	}
	/*******************/







	if(empty($NumLine)) $NumLine = 1;	


	$arryPurchaseTax = $objTax->GetTaxRate('2');

	

	require_once("includes/footer.php"); 	 
?>


