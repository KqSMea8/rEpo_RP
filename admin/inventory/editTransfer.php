<?php


    /**************************************************/
	$ThisPageName = 'viewTransfer.php';   $EditPage = 1;$SetFullPage = 1;
     /**************************************************/
	
	// require_once("phpuploader/include_phpuploader.php");
	require_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/inv.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix . "classes/inv.condition.class.php");

	$objCommon=new common();
        $objWarehouse=new warehouse();
	$objTax = new tax();
		$objCondition = new condition();

 
	$objRegion=new region();
	$RedirectURL = "viewTransfer.php?curP=".$_GET['curP']."";
	$ModuleName  = "Transfer";
	$objItem=new items();        
	$EditUrl = "editTransfer.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"].""; 
	$TaxShowHide=$PrefixPO=$serDisSub='';

	
	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		
		$objItem->RemoveTransfer($_GET['del_id']);
                $_SESSION['mess_transfer'] = 'Transfer'.ADJ_REMOVED;
		header("location: ".$RedirectURL);
	 }
	     
	if(!empty($_GET['edit'])){
		$arryTransfer = $objItem->ListingTransfer($_GET);
		$transferID   = $arryTransfer[0]['transferID'];	
		if($transferID>0){
			$arryTransferItem = $objItem->GetTransferStock($transferID);
			$NumLine = sizeof($arryTransferItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}


		

	if ($_POST) {
		CleanPost();

		if(empty($_POST['from_WID']) && empty($_POST['to_WID'])) {
		  $errMsg = ENTER_WAREHOUSE_ID;
		} else {
			if (!empty($_POST['transferID'])) {
			$objItem->UpdateTransfer($_POST);
			$transID = $_POST['transferID'];
			$_SESSION['mess_transfer'] = 'Transfer'.ADJ_UPDATED;
			}else {	 
			$transID = $objItem->AddTransfer($_POST); 				
			$_SESSION['mess_transfer'] = 'Transfer'.ADJ_ADDED;
		}
					
		$objItem->AddUpdateTransferStock($transID, $_POST); 
		header("Location:".$RedirectURL);
		exit;

		}
	}



	$arryReason = $objCommon->GetCrmAttribute('AdjReason','');
	$arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	$arrySaleTax = $objTax->GetTaxRate(1);
	$arryPurchaseTax = $objTax->GetTaxRate('2');
	if(empty($NumLine)) $NumLine = 1;
	
	 $ConditionDrop  =$objCondition-> GetConditionDropValue('');
	 
	
	require_once("../includes/footer.php"); 
	
?>
