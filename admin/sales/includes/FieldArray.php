<?php 

$RightArray='';


if($ThisPageName=='viewSalesQuoteOrder.php?module=Quote' || $ThisPageName=='viewSalesQuoteOrder.php?module=Order'){
	$RightArray = array
	(
		array("label" => $ModuleIDTitle,  "value" => "o.".$ModuleID),
		array("label" => "Order Type",  "value" => "o.OrderType"),
		array("label" => "Customer",  "value" => "o.CustomerName"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.CustomerCurrency"),
		array("label" => "Status",  "value" => "o.Status"),
		array("label" => "Tracking Number",  "value" => "o.TrackingNo"),
		array("label" => "Customer PO",  "value" => "o.CustomerPO")
	); 
}else if($ThisPageName=='viewReturn.php'){
	$RightArray = array
	(
		array("label" => "Return Number",  "value" => "o.ReturnID"),
		array("label" => "SO Number",  "value" => "o.SaleID"),
		array("label" => "Customer",  "value" => "o.CustomerName"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.CustomerCurrency"),
		array("label" => "Paid",  "value" => "o.ReturnPaid"),
		array("label" => "Customer PO",  "value" => "o.CustomerPO")
	); 
}			

	
		




/*******************/
if(!empty($RightArray)){
	foreach($RightArray as $values){
		$arryRightCol[] = $values['value'];
	}
}
$arryRightOrder = array('Asc','Desc');
/*******************/
if(!empty($_GET['sortby'])){
	if(!in_array($_GET['sortby'],$arryRightCol)){
		$_GET['sortby']='';
	}
}
if(!empty($_GET['asc'])){
	if(!in_array($_GET['asc'],$arryRightOrder)){
		$_GET['asc']='';
	}
}
/*****************/


/*************************************/
/*************************************/



?>
