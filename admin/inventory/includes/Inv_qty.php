<?php
      	/********purchase Qty**************/
	//$OrderQty=$objItem->GetOrderdedQty($arryProduct[0][Sku]);
$OrderQty = $objItem->GetRecievedQty($arryProduct[0][Sku]);
	$AdjQty=$objItem->GetAdjustmentQty($arryProduct[0][Sku]);
	
	//$onHandQty = $arryProduct[0]['qty_on_hand'];
	/**********************/

	/**********************/
	$RecvedQty=$objItem->GetRecievedQty($arryProduct[0][Sku]);
	if($RecievedQty>0){	$RecievedQty=$RecvedQty;}else{$RecievedQty=0;}
	/**********************/

	/*******On Sales Order***************/
	$SaleOrderQty=$objItem->GetSaleOrderdedQty($arryProduct[0][Sku]);
	 $on_sale_order=$SaleOrderQty[0]['sales_qty'];

$qtyInvoice=$SaleOrderQty[0]['qtyInvoice'];
$onHandQty=$OrderQty+$AdjQty-$qtyInvoice;
	/**********************/

	/**********Allocation Qty************/
	$AllocatedQty=$objItem->GetAssemblyQty($arryProduct[0][Sku]);

	/**********************/
	$availableQty=$onHandQty-$on_sale_order-$AllocatedQty;
$onHandQty = $availableQty;

$_POST['allocated_qty'] =$AllocatedQty;
$_POST['qty_on_hand']  =$onHandQty;
$_POST['qty_on_demand']=$arryProduct[0]['qty_on_demand'];
$_POST['ItemID'] = $arryProduct[0]['ItemID'];
$objItem->UpdateQuantity($_POST);


$onHandQty = $availableQty;
	/**********************/

?>
