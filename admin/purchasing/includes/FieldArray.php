<?php 
$RightArray='';
if($ThisPageName=='viewPO.php?module=Quote' || $ThisPageName=='viewPO.php?module=Order'){
	$RightArray = array
	(
		array("label" => $ModuleIDTitle,  "value" => "o.".$ModuleID),
		array("label" => "Order Type",  "value" => "o.OrderType"),
		array("label" => "Sales Order",  "value" => "o.SaleID"),
		array("label" => "Vendor",  "value" => "o.SuppCompany"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.Currency"),
		array("label" => "Status",  "value" => "o.Status"),
		array("label" => "Approved",  "value" => "o.Approved"),
		array("label" => "Tracking Number",  "value" => "o.TrackingNo")

	); 
}else if($ThisPageName=='viewRma.php'){
	$RightArray = array
	(
		array("label" => "RMA Number",  "value" => "o.ReturnID"),
		array("label" => "Invoice Number",  "value" => "o.InvoiceID"),
		array("label" => "Vendor",  "value" => "o.SuppCompany"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.Currency")
		//array("label" => "Amount Paid",  "value" => "o.InvoicePaid")
	); 
}			

	

$arryRightCol ='';

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
