<?php

/* * *********************************************** */
$ThisPageName = 'viewWorkOrder.php';
/* * *********************************************** */

// require_once("phpuploader/include_phpuploader.php");
require_once("../includes/header.php");
require_once($Prefix . "classes/bom.class.php");
require_once($Prefix . "classes/item.class.php");

require_once($Prefix . "classes/warehouse.class.php");

$objWarehouse = new warehouse();



(!$_GET['curP']) ? ($_GET['curP'] = 1) : (""); // current page number
$objItem = new items();
$RedirectURL = "viewWorkOrder.php?curP=" . $_GET['curP'] . "";
$ModuleName = "Work Order";
$objBom = new bom();







if (!empty($_GET['view'])) {
$_GET['id'] = $_GET['view'];
    $arryWorkOrder = $objBom->ListWorkOrder($_GET);

$Oid = $arryWorkOrder[0]['Oid'];

$arryProduct=$objItem->getItemCondionQty($arryWorkOrder[0]['BOM'],$arryWorkOrder[0]['woCondition']);
 
if(!empty($arryProduct[0]['condition_qty']) && !empty($arryProduct[0]['condition_qty'])){
 $qty = $arryProduct[0]['condition_qty'];
}else{
 $qty = 0;
}

    if ($Oid > 0) {
        $arryBomItem = $objBom->GetWorkOrderItem($Oid);
//echo "<pre>";
//print_r($arryBomItem);
//exit;
        $NumLine = sizeof($arryBomItem);
    } else {
        $ErrorMSG = $NotExist;
    }
}








$arryWarehouse = $objWarehouse->ListWarehouse('', $_GET['key'], '', '', 1);


if (empty($NumLine))
    $NumLine = 1;



require_once("../includes/footer.php");
?>
