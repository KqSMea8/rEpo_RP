<?php 
$RightArray=''; 
                       
if($ThisPageName=='viewWarehouse.php'){
	$RightArray = array
	(
		array("label" => "WareHouse Code",  "value" => "w.warehouse_code"),
		array("label" => "WareHouse Name",  "value" => "w.warehouse_name"),
		array("label" => "City",  "value" => "l.City"),
		array("label" => "State",  "value" => "l.State"),
		array("label" => "Country",  "value" => "l.Country")
	); 
}else if($ThisPageName=='viewManageBin.php'){
	$RightArray = array
	(
		array("label" => "WareHouse Code",  "value" => "w.warehouse_code"),
		array("label" => "WareHouse Name",  "value" => "w.warehouse_name"),
		array("label" => "Bin Location",  "value" => "w.binlocation_name")
	); 
}else if($ThisPageName=='viewPoReceipt.php'){
	$RightArray = array
	(
		array("label" => "Receipt Number",  "value" => "o.ReceiptID"),
		array("label" => "PO Number",  "value" => "o.PurchaseID"),
		array("label" => "Vendor",  "value" => "o.SuppCompany"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.Currency"),
		array("label" => "Receipt Status",  "value" => "o.ReceiptStatus")
	); 

}else if($ThisPageName=='viewShipment.php'){
	$RightArray = array
	(
		array("label" => "Shipment Number",  "value" => "o.ShippedID"),
		array("label" => "SO Number",  "value" => "o.SaleID"),
		array("label" => "Invoice Number",  "value" => "s.RefID"),
		array("label" => "Customer",  "value" => "o.CustomerName"),
		array("label" => "Sales Person",  "value" => "o.SalesPerson"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.CustomerCurrency"),
		array("label" => "Status",  "value" => "s.ShipmentStatus")

	); 
}else if($ThisPageName=='viewPicking.php'){
	$RightArray = array
	(
		array("label" => $ModuleIDTitle,  "value" => "o.".$ModuleID),
		//array("label" => "Order Type",  "value" => "o.OrderType"),
		array("label" => "Customer",  "value" => "o.CustomerName"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.CustomerCurrency"),
		//array("label" => "Status",  "value" => "o.Status"),
		array("label" => "Tracking Number",  "value" => "o.TrackingNo")

	); 
}else if($ThisPageName=='viewReturn.php'){
	$RightArray = array
	(
		array("label" => "Return Number",  "value" => "o.ReturnID"),
		array("label" => "PO Number",  "value" => "o.PurchaseID"),
		array("label" => "Vendor",  "value" => "o.SuppCompany"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.Currency"),
		array("label" => "Amount Paid",  "value" => "o.InvoicePaid")

	); 
}else if($ThisPageName=='viewSalesReturn.php'){
	$RightArray = array
	(
		array("label" => "Receipt Number",  "value" => "w.ReceiptNo"),
		array("label" => "Invoice Number",  "value" => "w.InvoiceID"),
		array("label" => "RMA Number",  "value" => "w.ReturnID"),
		array("label" => "Receipt Status",  "value" => "w.ReceiptStatus")		

	); 
}else if($ThisPageName=='viewPoRma.php'){
	$RightArray = array
	(
		array("label" => "Reciept Number",  "value" => "w.ReceiptNo"),
		array("label" => "RMA Number",  "value" => "w.ReturnID"),
		array("label" => "Invoice Number",  "value" => "w.InvoiceID"),
		array("label" => "Vendor",  "value" => "w.SuppCompany"),
		array("label" => "Amount",  "value" => "w.TotalReceiptAmount")

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
