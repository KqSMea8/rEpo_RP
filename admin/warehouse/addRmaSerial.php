<?php

/* * *********************************************** */
#$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;
include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/rma.sales.class.php");
$objrmasale = new rmasale();
$objSale = new sale();
 
if(!empty($_GET['sku'])){
    $arrySerialNumber = $_GET['SerialValue'];
    #$arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);
}
 
//echo '<pre>';
$sku=$_GET['sku'];
$orderid=$_GET['OrderID'];
$condition=$_GET['condition'];

$checkProduct=$objConfig->IsItemSku($_GET['sku']);

		
		if(empty($checkProduct))
		{
		$arryAlias = $objConfig->IsItemAliasSku($_GET['sku']);
			if(count($arryAlias))
			{
					$mainSku = $arryAlias[0]['sku'];		
			}
		}else{

$mainSku = $_GET['sku'];
}


$selectedData=$objrmasale->GetOrderItembyOrderIDAndSKU($orderid,$sku,$condition);

$selectedData=$selectedData[0]['SerialNumbers'];

if($selectedData){
$serial_value_sel=explode(',',$selectedData);
}else{
$serial_value_sel=array();
}


$inoiceOrderID=$objrmasale->getInvoiceOrderIDByRMA($orderid);

$items= $objrmasale->GetOrderItembyOrderIDAndSKU($inoiceOrderID,$sku,$condition);


/********** RAM serals*********/
$craditsOrdeIDS=$objrmasale->getOrderIDByMode($orderid,'Credit');

if(!empty($craditsOrdeIDS)){
	foreach ($craditsOrdeIDS as $valCredit){
		$orderidArray[]=$valCredit['OrderID'];
	}
}
$craditserials=$objrmasale->GetOrderItembyOrderIDAndSKU($orderidArray,$sku,$condition);
$creditserial=array();
if(!empty($craditserials)){
foreach($craditserials as $craditserialsvalue){
$creditserial[]=trim($craditserialsvalue['SerialNumbers']);
}

}
$creditserial= implode(',',$creditserial);
$creditserial=explode(',',$creditserial);

/*********************************/
//print_r($items);
//die;
$allserials = explode(",",$items[0]['SerialNumbers']);


$serialValue=$objrmasale->getSerialDetails($mainSku,$condition,$allserials);


require_once("../includes/footer.php");
?>
