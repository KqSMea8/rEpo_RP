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
	$sku=$_GET['sku'];
	$orderid=$_GET['OrderID'];
	$condition=$_GET['condition'];
	$arrySerialNumber = $_GET['SerialValue'];
	
    $arrySerialNumber = $objPurchase->selectSerialNumberForItembyID($_GET['OrderID'],$_GET['item_id'],$_GET['sku']);
   
    
    
    
    $allserials = explode(",",$arrySerialNumber[0]['SerialNumbers']);
$serialValue=$objPurchase->getSerialDetails($sku,$condition,$allserials);

}





require_once("../includes/footer.php");
?>
