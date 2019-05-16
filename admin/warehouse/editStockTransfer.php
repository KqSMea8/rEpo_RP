<?php

/* * *********************************************** */
$ThisPageName = "viewStockTransfer.php";
$EditPage = 1;
/* * *********************************************** */

include_once("../includes/header.php");
require_once($Prefix . "classes/warehouse.recieve.order.class.php");
require_once($Prefix . "classes/item.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/warehousing.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix . "classes/item.class.php");
require_once("language/english.php");

$objCommon = new common();
$objWrecieve = new wrecieve();
$objItem = new items();
$objWarehouse = new warehouse();
$objItem = new items();
$objTax = new tax();

$Module = "Stock Transfer";
$ModuleIDTitle = "Recieve Number";
$ModuleID = "RecieveID";
$PrefixSale = "RTN";
$NotExist = NOT_EXIST_ORDER;
$RedirectURL = "viewStockTransfer.php?curP=" . $_GET['curP'];


if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_transfer'] = TRANSFER_REMOVED;
    $objWrecieve->RemoveTransferRecieve($_GET['del_id']);
    header("Location:" . $RedirectURL);
    exit;
}



if (!empty($_POST['RecieveOrderID'])) {

    $transferID = $objWrecieve->TransferRecieveOrder($_POST);
    $_SESSION['mess_transfer'] = TRANSFER_ADDED;
    header("Location:" . $RedirectURL);
    exit;
} else if (!empty($_POST['rtnID']) && ($_POST['Submit'] == "Save")) {
    $objWrecieve->UpdateTransferRecieve($_POST);
    $_SESSION['mess_transfer'] = TRANSFER_UPDATED;
    header("Location:" . $RedirectURL);
    exit;
}

if(!empty($_GET['tn'])){	
    $CheckID =$objWrecieve->isTransfer($_GET['tn']); 
   
 }




if(empty($CheckID) && !empty($_GET['tn'])){
		$arryTransfer = $objItem->GetTransfer($_GET['tn']);

		$OrderID   = $arryTransfer[0]['transferID'];
		$refID = $arryTransfer[0]['transferID'];
		$po =  $arryTransfer[0]['transferNo'];
		$to_warehouse = $objWarehouse->GetWarehouse($arryTransfer[0]['to_WID']);
        $to_location = $to_warehouse[0]['warehouse_name'];
        $to_WID = $to_warehouse[0]['WID'];
        $from_warehouse = $objWarehouse->GetWarehouse($arryTransfer[0]['from_WID']);
        $from_location = $from_warehouse[0]['warehouse_name'];
        $from_WID = $from_warehouse[0]['WID'];
		if($OrderID>0){
			$ref = 2;
			$arryTransferItem = $objItem->GetTransferStock($OrderID);
			$NumLine = sizeof($arryTransferItem);
			$TransferID = $arryTransfer[0]['transferNo'];
		}else{
			$ErrorMSG = NOT_EXIST_TRANSFER;
		}

		$ModuleName = $Module;

	}
	else if(!empty($_GET['edit'])){

		$arryTransfer = $objWrecieve->GetTransferOrder($_GET['edit']);
		$OrderID   = $arryTransfer[0]['transferID'];	
		$po =  $arryTransfer[0]['transferNo'];
		$refID = $arryTransfer[0]['refID'];
		$to_warehouse = $objWarehouse->GetWarehouse($arryTransfer[0]['to_WID']);
        $to_location = $to_warehouse[0]['warehouse_name'];
        $to_WID = $to_warehouse[0]['WID'];
        $from_warehouse = $objWarehouse->GetWarehouse($arryTransfer[0]['from_WID']);
        $from_location = $from_warehouse[0]['warehouse_name'];
        $from_WID = $from_warehouse[0]['WID'];

		if($OrderID>0){
			$ref = 0;
			$arryTransferItem = $objWrecieve->GetTransferOrderItem($_GET['edit']);
			$NumLine = sizeof($arryTransferItem);
			$TransferID = $arryTransfer[0]['transferNo'];
		}else{
			$ErrorMSG = NOT_EXIST_TRANSFER;
		}
		$ModuleName = "Edit ".$Module;
		$HideSubmit = 1;
	}else if(!empty($CheckID)){
		$arryTransfer = $objWrecieve->GetTransferOrder($CheckID);
		$OrderID   = $arryTransfer[0]['transferID'];	
		$po =  $arryTransfer[0]['transferNo'];
		$refID = $arryTransfer[0]['refID'];
		$to_warehouse = $objWarehouse->GetWarehouse($arryTransfer[0]['to_WID']);
        $to_location = $to_warehouse[0]['warehouse_name'];
        $to_WID = $to_warehouse[0]['WID'];
        $from_warehouse = $objWarehouse->GetWarehouse($arryTransfer[0]['from_WID']);
        $from_location = $from_warehouse[0]['warehouse_name'];
        $from_WID = $from_warehouse[0]['WID'];
		if($OrderID>0){
			$ref = 1;
			$arryTransferItem = $objWrecieve->GetTransferOrderItem($OrderID);
			$NumLine = sizeof($arryTransferItem);
			$TransferID = $arryTransfer[0]['transferNo'];
		}else{
			$ErrorMSG = NOT_EXIST_TRANSFER;
		}

		$ModuleName = $Module;
	}else{

		exit;
	}
	
 
if (empty($NumLine))
    $NumLine = 1;
$objItemTax = $objTax->GetTaxRate('2');
$arryWarehouse = $objWarehouse->ListWarehouse('', $_GET['key'], '', '', 1);
$arryPaid = $objCommon->GetAttribValue('Paid', '');
$arryTrasport = $objCommon->GetAttribValue('Transport', '');
$arryCharge = $objCommon->GetAttribValue('Charge', '');
$arryPackageType = $objCommon->GetAttribValue('PackageType', '');
/* * ***************************************** */
require_once("../includes/footer.php");
?>


