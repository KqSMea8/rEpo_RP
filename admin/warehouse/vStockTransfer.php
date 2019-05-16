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






 if(!empty($_GET['view'])){

		$arryTransfer = $objWrecieve->GetTransferOrder($_GET['view']);

		
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
		$ModuleName = "View ".$Module;
		$HideSubmit = 1;
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


