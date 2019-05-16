<?php
 $HideNavigation = 1;
	
	include_once("includes/header.php");
//select c.*,(SELECT SUM(s_order_item.qty) from s_order_item as s_order_item inner join s_order as s_order on s_order_item.OrderID =s_order.OrderID WHERE 1 and s_order.Module='Invoice' and s_order_item.`Condition`=c.`condition` and s_order_item.item_id =c.ItemID and s_order.PostToGL!=1) as invQty,(SELECT SUM(shi.qty) from s_order_item as shi inner join s_order as sh on shi.OrderID =sh.OrderID WHERE 1 and sh.Module='Shipment' and shi.`Condition`=c.`condition` and shi.item_id =c.ItemID and sh.InvoiceID='') as shipQty,(SELECT SUM(soi.qty) from s_order_item as soi inner join s_order as so on soi.OrderID =so.OrderID WHERE 1 and so.Module='Order' and soi.`Condition`=c.`condition` and soi.item_id =c.ItemID and NOT EXISTS (SELECT 1 FROM s_order b WHERE b.SaleID = so.SaleID and b.Module ='Shipment' )) as saleQty from inv_item_quanity_condition c where 1 ORDER BY `invQty`  DESC

//"select c.*,(SELECT SUM(s_order_item.qty) from s_order_item as s_order_item inner join s_order as s_order on s_order_item.OrderID =s_order.OrderID WHERE 1 and s_order.Module='Invoice' and s_order_item.`Condition`=c.`condition` and s_order_item.item_id =c.ItemID and s_order.PostToGL!=1) as invQty,(SELECT SUM(shi.qty) from s_order_item as shi inner join s_order as sh on shi.OrderID =sh.OrderID WHERE 1 and sh.Module='Shipment' and shi.`Condition`=c.`condition` and shi.item_id =c.ItemID and sh.InvoiceID='') as shipQty,(SELECT SUM(soi.qty) from s_order_item as soi inner join s_order as so on soi.OrderID =so.OrderID WHERE 1 and so.Module='Order' and soi.`Condition`=c.`condition` and soi.item_id =c.ItemID and NOT EXISTS (SELECT 1 FROM s_order b WHERE b.SaleID = so.SaleID and b.Module ='Shipment' )) as saleQty from inv_item_quanity_condition c where c.Sku = '660093-001' and c.`condition` = 'New Bulk' ORDER BY `invQty`  DESC "
//SELECT s_order_item.OrderID,s_order_item.item_id,s_order_item.avgCost,s_order_item.qty,s_order_item.sku,s_order_item.`Condition`,s_order_item.parent_item_id,s_order.SaleID,s_order.InvoiceID,s_order_item.SerialNumbers from s_order_item as s_order_item inner join s_order as s_order on s_order_item.OrderID =s_order.OrderID WHERE 1 and s_order.Module='Invoice' and s_order_item.`Condition`='' and s_order_item.avgCost ='0.00' 
$sqlres= "SELECT s_order_item.OrderID,s_order_item.item_id,s_order_item.avgCost,s_order_item.qty,s_order_item.sku,s_order_item.`Condition`,s_order_item.parent_item_id,s_order.SaleID,s_order.InvoiceID,s_order_item.SerialNumbers from s_order_item as s_order_item inner join s_order as s_order on s_order_item.OrderID =s_order.OrderID WHERE 1 and s_order.Module='Invoice'";

$rest = $objConfig->query($sqlres,1);
//echo "<pre>";
//print_r($rest);

foreach ($rest as $key => $values) {
$result1 =  explode ( ",", $values['SerialNumbers'] );
 $result = "'" . implode ( "', '", $result1 ) . "'";


echo $Sql = "select UnitCost as avgCost,serialID from inv_serial_item where 1 and UsedSerial=1 and Status=1 and `Condition`='".$values['Condition']."' and Sku ='".$values['sku']."' and serialNumber IN($result)"; 
$res = $objConfig->query($Sql,1);
//echo"<pre>";
//print_r($res);
foreach ($res as $key => $serVal) {
echo $SqlUpdate = "update inv_serial_item set OrderID ='".$values['OrderID']."',SelectType ='SaleOrder' where serialID ='".$serVal['serialID']."' ";
$objConfig->query($SqlUpdate,1);
}


}
/*$Sr = explode(',',$values['SerialNumbers']);

for($i=0;$i<sizeof($Sr);$i++){
 $Sql = "select UnitCost as avgCost from inv_serial_item where 1 and `Condition`='".$values['Condition']."' and Sku ='".$values['sku']."' and serialNumber ='".$Sr[$i]."'"; 
$res = $objConfig->query($Sql,1);
$Srr += $res[$i]['avgCost'];
}

if($values['Condition']!=''){

$Cost = $Srr/$values['qty'];
$Cost = number_format($Cost,2);
 $SqlUpdate = "update s_order_item set avgCost ='".$Cost."' where `Condition` ='".$values['Condition']."' and Sku ='".$values['sku']."' and DropShipCheck =0 and OrderID = '".$values['OrderID']."' and `Condition`!='' ";
$objConfig->query($SqlUpdate,0);
}*/
#echo $Sql = "select SUM(UnitCost) as avgCost from inv_serial_item where 1 and `Condition`='".$values['Condition']."' and Sku ='".$values['Sku']."' and serialNumber IN('".$Sr."')"; exit;
#$res = $objConfig->query($Sql,1);

//echo $Srr;



//}












?>
