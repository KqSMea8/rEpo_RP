<?php 
	/**************************************************/
	$ThisPageName = "viewInbound.php";	$EditPage = 1;
	/**************************************************/
    require_once("language/english.php");
	include_once("../includes/header.php");
	require_once($Prefix."classes/inbound.class.php");
	
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehousing.class.php");

	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	$objCommon=new common();
	$objInbound=new inbound();
	$objPurchase=new purchase();
	$objWarehouse=new warehouse();
	$objTax=new tax();

	$Module = "Recieve";

	$RedirectURL = "viewInbound.php?curP=".$_GET['curP'];
	//$editURL = "editInbound.php?edit=".$_POST['ReturnOrderID']."&curP=".$_GET['curP'];

	


	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RECIEVE_REMOVED;
		$objInbound->RemovePurchase($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
		/*if($_POST){
		echo "<pre>";
		print_r($_POST);
		exit;
		}*/

	if(!empty($_POST['ReturnOrderID'])){   
		
		$OrderID = $objInbound->ReceiveOrder($_POST);
		$_SESSION['mess_return'] = RECIEVE_ADDED;
		#$RedirectURL = "vReturn.php?view=".$OrderID;
		header("Location:".$RedirectURL);
		exit;
		
	}else if(!empty($_POST['OrderID'])){  
		$objInbound->UpdateWarehouseRecieve($_POST);
		$_SESSION['mess_return'] = RECIEVE_UPDATED;
		header("Location:".$RedirectURL);
		exit;
	}
		

	if(!empty($_GET['po'])){
		
		$arryIn = $objPurchase->GetPurchase($_GET['po'],'','Order');

		//echo $arryIn[0]['PurchaseID'];
		if(!empty($arryIn[0]['PurchaseID'])){
		 $arryCheckID = $objInbound->isInboundOrder($arryIn[0]['PurchaseID']);
		}  
			if(!empty($arryCheckID)){
				$arryInbound = $objInbound->GetInbound($arryPurchase[0]['InboundID']);
				$arryPurchase = $objInbound->GetWOrder('',$arryCheckID,'');
				$OrderID = $arryPurchase[0]['OrderID'];
			     $ref = 1;
				if($OrderID>0){
					$arryPurchaseItem = $objInbound->GetWarehouseItem($OrderID);
					
					$NumLine = sizeof($arryPurchaseItem);
					$arryInbound[0]['transaction_ref'] = $arryPurchase[0]['PurchaseID'];
					$PurchaseID = $arryPurchase[0]['PurchaseID'];
					#$arryInvoiceOrder = $objInbound->GetInvoiceOrder($PurchaseID);
				 }
			}else{
				$arryPurchase = $objPurchase->GetPurchase($_GET['po'],'','Order');
				$OrderID   = $arryPurchase[0]['OrderID'];
				$ref = 2;
				$po =  $arryPurchase[0]['PurchaseID'];
				$arryInbound[0]['warehouse'] = $arryPurchase[0]['wCode'];
				if($OrderID>0){
					$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
					/*echo "<pre>";
					print_r($arryPurchaseItem);
					echo "</pre>";*/
					$NumLine = sizeof($arryPurchaseItem);
					$arryInbound[0]['transaction_ref'] = $arryPurchase[0]['PurchaseID'];
					$PurchaseID = $arryPurchase[0]['PurchaseID'];
					#$arryInvoiceOrder = $objInbound->GetInvoiceOrder($PurchaseID);
				}else{
					$ErrorMSG = NOT_EXIST_ORDER;
				}
	}
		/*if($objInbound->isRecieveExists($_GET['po'],'')){
			$ErrorMSG = ALREADY_EXIST_PO;
		
		}	*/

		$ModuleName = "Add ".$Module;

	}else if(!empty($_GET['edit'])){

		$arryPurchase = $objInbound->GetReciveWarehouse($_GET['edit'],'','');
		$arryInbound = $objInbound->GetInbound($arryPurchase[0]['InboundID']);
		/*echo "<pre>";
		print_r($arryInbound);
		exit;*/
		
		$OrderID   = $arryPurchase[0]['OrderID'];	
		$po = $arryPurchase[0]['PurchaseID'];

		if($OrderID>0){
			$arryPurchaseItem = $objInbound->GetWarehouseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
		
			//echo "numlinr--".$NumLine;
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
		$ModuleName = "Edit ".$Module;
		$HideSubmit = 1;
	}else{
		$ErrorMSG = SELECT_PO_FIRST;
		$ModuleName = "Add ".$Module;
	}
				

	if(empty($NumLine)) $NumLine = 1;	
	  $arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	$arryPurchaseTax = $objTax->GetTaxRate('2');
	$arryPaid = $objCommon->GetAttribValue('Paid','');
	$arryTrasport = $objCommon->GetAttribValue('Transport','');
	$arryCharge = $objCommon->GetAttribValue('Charge','');
	
	$arryPackageType = $objCommon->GetAttribValue('PackageType','');


	require_once("../includes/footer.php"); 	 
?>


