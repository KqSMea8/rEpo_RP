<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewStockAdjustment.php'; $EditPage = 1;
    /**************************************************/


    require_once("../includes/header.php");
    require_once($Prefix . "classes/warehouse.recieve.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehousing.class.php");
	require_once($Prefix."classes/warehouse.class.php");		
	//include_once("language/en_lead.php");
    require_once($Prefix."classes/item.class.php");

	
     $RedirectURL = $ThisPageName."?curP=".$_GET['curP'];

	$Module = "Stock In";
     $objItem=new items();
     $objWarehouse=new warehouse();
	 $objWrecieve = new wrecieve();
	 $objTax=new tax();
	$objCommon=new common();

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RETURN_REMOVED;
		$objWrecieve->RemoveAdjustmentOrder($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}



	if(!empty($_POST['ReturnOrderID'])){ 
		
		
		$OrderID = $objWrecieve->AdjustmentOrder($_POST);
		$_SESSION['mess_return'] = RETURN_ADDED;
		#$RedirectURL = "vReturn.php?view=".$OrderID;
		header("Location:".$RedirectURL);
		exit;
	}else if(!empty($_POST['OrderID'])){  
		$objPurchase->UpdateAdjustment($_POST);
		$_SESSION['mess_return'] = RETURN_UPDATED;
		header("Location:".$RedirectURL);
		exit;
	}

 if(!empty($_GET['adj'])){	
   $CheckID =$objWrecieve->isAdjustment($_GET['adj']);
   
 }
	if(empty($CheckID)){
		$arryAdjustment = $objItem->GetAdjustment($_GET['adj'],2);
		$OrderID   = $arryAdjustment[0]['adjID'];
		$po =  $arryAdjustment[0]['adjustNo'];
		if($OrderID>0){
			$ref = 2;
			$arryAdjustmentItem = $objItem->GetAdjustmentStock($OrderID);
			$NumLine = sizeof($arryAdjustmentItem);
			$AdjustmentID = $arryAdjustment[0]['adjustNo'];
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}

		$ModuleName = $Module;

	}
	else if(!empty($_GET['edit'])){

		$arryAdjustment = $objWrecieve->GetAdjustmentOrder($_GET['edit']);
		$OrderID   = $arryAdjustment[0]['adjustmentID'];	
		$po =  $arryAdjustment[0]['adjustNo'];

		if($OrderID>0){
			$ref = 0;
			$arryAdjustmentItem = $objWrecieve->GetAdjustmentOrderItem($OrderID);
			$NumLine = sizeof($arryAdjustmentItem);
			$AdjustmentID = $arryAdjustment[0]['adjustNo'];
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
		$ModuleName = "Edit ".$Module;
		$HideSubmit = 1;
	}else if(!empty($CheckID)){
		$arryAdjustment = $objWrecieve->GetAdjustmentOrder($CheckID);
		$OrderID   = $arryAdjustment[0]['adjustmentID'];
		$po =  $arryAdjustment[0]['adjustNo'];
		if($OrderID>0){
			$ref = 1;
			$arryAdjustmentItem = $objWrecieve->GetAdjustmentOrderItem($OrderID);
			$NumLine = sizeof($arryAdjustmentItem);
			$AdjustmentID = $arryAdjustment[0]['adjustNo'];
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}

		$ModuleName = $Module;
	}else{

		exit;
	}
				

	if(empty($NumLine)) $NumLine = 1;	
	//$arryPurchaseTax = $objTax->GetTaxRate('2');
	//$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
    $arrySaleTax = $objTax->GetTaxRate('2');
    $arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	$arryPaid = $objCommon->GetAttribValue('Paid','');
	$arryTrasport = $objCommon->GetAttribValue('Transport','');
	$arryCharge = $objCommon->GetAttribValue('Charge','');
	$arryPackageType = $objCommon->GetAttribValue('PackageType','');
          $arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);	
		

	require_once("../includes/footer.php"); 
?>


