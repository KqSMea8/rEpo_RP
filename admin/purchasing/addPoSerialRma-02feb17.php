<?php

/* * *********************************************** 
$ThisPageName = 'editRma.php';
/* * *********************************************** */
$HideNavigation = 1;


include_once("../includes/header.php");
require_once($Prefix."classes/rma.purchase.class.php");
require_once($Prefix."classes/purchasing.class.php");
	
$objPurchase=new purchase();

if(!empty($_GET['sku'])){
	
	$arrySerialNumber = $_GET['SerialValue'];
	
    $arrySerialNumber = $objPurchase->selectSerialNumberForItembyID($_GET['OrderID'],$_GET['item_id'],$_GET['sku']);
}


require_once("../includes/footer.php");
?>