<?php

/* * *********************************************** 
$ThisPageName = 'editRma.php';
/* * *********************************************** */
$HideNavigation = 1;


include_once("../includes/header.php");
require_once($Prefix."classes/rma.purchase.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
$objPurchase=new purchase();


if(!empty($_GET['sku'])){
	
	//$arrySerialNumber = $_GET['SerialValue'];
	
    //$arrySerialNumber = $objPurchase->WselectSerialNumberForItemByID($_GET['OrderID'],$_GET['item_id'],$_GET['sku']);
$SelSerialNumber = $_GET['SerialValue'];
$Config['Condition'] = $_GET['cond'];
$Config['warehouse'] = $_GET['warehouse'];

    $arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);
    
  	
}


require_once("../includes/footer.php");
?>
