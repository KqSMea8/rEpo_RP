<?php

/* * *********************************************** 
$ThisPageName = 'editRma.php';
/* * *********************************************** */
$HideNavigation = 1;


include_once("../includes/header.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix."classes/rma.purchase.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
$objPurchase=new purchase();


if(!empty($_GET['sku'])){
	$sku=$_GET['sku'];
	$orderid=$_GET['OrderID'];
	$condition=$_GET['condition'];
$Config['Cond'] = $_GET['condition'];
$shsku = $_GET['shsku'];
	$inoiceOrderID=$objPurchase->getInvoiceOrderIDByRMA($orderid);	
    $arrySerialNumber = $objPurchase->selectSerialNumberForItembyID($inoiceOrderID,$_GET['item_id'],$_GET['shsku']);
    
    $allserials = explode(",",$arrySerialNumber[0]['SerialNumbers']);
	$serialValue=$objPurchase->getSerialDetails($sku,$condition,$allserials);
	
	
$selectedData=$objPurchase->GetOrderItembyOrderIDAndSKU($orderid,$shsku,$condition);

 $selectedData=$selectedData[0]['SerialNumbers'];


if($selectedData){
$serial_value_sel=explode(',',$selectedData);
}else{
$serial_value_sel=array();
}
	


/********** RAM serals*********/

$craditsOrdeIDS=$objPurchase->getOrderIDByMode($orderid,'Credit');

if(!empty($craditsOrdeIDS)){
	foreach ($craditsOrdeIDS as $valCredit){
		$orderidArray[]=$valCredit['OrderID'];
	}
}
$craditserials=$objPurchase->GetOrderItembyOrderIDAndSKU($orderidArray,$shsku,$condition);
$creditserial=array();
if(!empty($craditserials)){
	foreach($craditserials as $craditserialsvalue){
	$creditserial[]=trim($craditserialsvalue['SerialNumbers']);
	}
	$creditserial= implode(',',$creditserial);
	$creditserial=explode(',',$creditserial);
}



/*********************************/

}


require_once("../includes/footer.php");
?>
