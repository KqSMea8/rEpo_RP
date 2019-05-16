<?php
/* * *********************************************** */
#$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;
include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/rma.sales.class.php");
$objSale = new sale();
$objrmasale = new rmasale();
if(!empty($_GET['sku'])){
   // $arrySerialNumber = $_GET['SerialValue'];
    #$arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);
    
    //$arrySerialNumber = $objSale->getSerialNumberForItemById($_GET['OrderID'],$_GET['item_id'],$_GET['sku']);
    
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


$craditsOrdeIDS=$objrmasale->getOrderIDByMode($orderid,'Credit');

$orderidArray = array();
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



$items= $objrmasale->GetOrderItembyOrderIDAndSKU($_GET['OrderID'],$sku,$condition);

//print_r($items[0]['SerialNumbers']);die;
$allserials = explode(",",$items[0]['SerialNumbers']);
$allserials=array_diff($allserials,$creditserial);
$serialValue=$objrmasale->getSerialDetails($mainSku,$condition,$allserials,$orderid);
    
}
 

require_once("../includes/footer.php");
?>