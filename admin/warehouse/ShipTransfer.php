<?php 

	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewTransferOrder.php'; $EditPage = 1;
	/**************************************************/
	
		require_once("../includes/header.php");
		require_once($Prefix."classes/item.class.php");
		//require_once($Prefix."classes/inv.class.php");
		require_once($Prefix."classes/warehouse.class.php");
		require_once($Prefix."classes/warehousing.class.php");
		

		$objItem = new items();
		$objCommon = new common();
		$objWarehouse = new warehouse();
		(!$_GET['module'])?($_GET['module']='Transfer'):(""); 
		$module = $_GET['module'];
		//$ModuleName = "Ship ".$_GET['module']." Order";
		$RedirectURL = "viewTransferOrder.php?curP=".$_GET['curP'];
		//$EditUrl = "editInvoice.php?edit=".$_GET["invoice"]."&module=".$module."&curP=".$_GET["curP"]; 
		$ModuleIDTitle = "Transfer Number"; $ModuleID = "transferID"; $PrefixPO = "IN";  $NotExist = NOT_EXIST_ORDER;

		 /**************************/
		if(!empty($_GET['transferID'])){
			$arryTransfer = $objItem->GetTransfer($_GET['transferID']);
			$transferID = $arryTransfer[0]['transferID'];
			$transferNo = $arryTransfer [0]['transferNo'];
			
			if($transferID>0){
				$arryTransferItem = $objItem->GetTransferStock($transferID);
				$NumLine = sizeof($arryTransferItem);
			}else{
				$ErrorMSG = $NotExist;
			}
		}else{
			header("Location:".$RedirectURL);
			exit;
		}

		if(!empty($_POST['ShipOrder'])) {
        
				$ship_id = $objWarehouse->GenerateTranferShipping($_POST);
				
				$_SESSION['mess_Invoice'] = SHIPPING_GENERATED_MESSAGE;
				$objWarehouse->AddTranferShippingItem($ship_id, $_POST); 
				$RedirectURL = "viewShipOrder.php";
				header("Location:".$RedirectURL);
				exit;
			 } 
		if(empty($NumLine)) $NumLine = 1;	
		$arryBin = $objWarehouse->GetWarehouseBin($arrySale[0]['wCode']);

	//$arryPurchaseTax = $objTax->GetTaxRate('2');
	$arryPaid = $objCommon->GetAttribValue('Paid','');
	$arryTrasport = $objCommon->GetAttribValue('Transport','');
	$arryCharge = $objCommon->GetAttribValue('Charge','');
	
	$arryPackageType = $objCommon->GetAttribValue('PackageType','');
		/**************************/			
	/*
			if(!empty($_POST['ShipInVoice'])) {

			
					$ship_id = $objWarehouse->GenerateShipping($_POST);
					
					$_SESSION['mess_Invoice'] = SHIPPING_GENERATED_MESSAGE;
					$objWarehouse->AddShippingItem($ship_id, $_POST); 
					$RedirectURL = "viewInvoice.php?module=Invoice";
					header("Location:".$RedirectURL);
					exit;
				 } 
					
					
		
		$arrySaleTax = $objTax->GetTaxRate('2');
		$_SESSION['DateFormat']= $Config['DateFormat'];*/

	require_once("../includes/footer.php"); 	 
?>


