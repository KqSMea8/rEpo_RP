<? 

 $HideNavigation = 1;
	
	include_once("includes/header.php");


//echo $sqlres= "SELECT s_order.Module,s_order_item.OrderID,s_order_item.WID,s_order_item.item_id,s_order_item.avgCost,s_order_item.qty,s_order_item.sku,s_order_item.`Condition`,s_order_item.parent_item_id,s_order.SaleID,s_order.InvoiceID,s_order_item.SerialNumbers from s_order_item as s_order_item inner join s_order as s_order on s_order_item.OrderID =s_order.OrderID WHERE 1 and s_order.Module='Shipment' and s_order_item.sku = '500202-061'";

echo $sqlres= "SELECT * from inv_stock_adjustment WHERE 1 and (sku = '500202-061' or sku ='500656-B21')";

//echo $sqlres= "SELECT * FROM `inv_item_disassembly`  WHERE 1 and (sku = '500202-061' or sku ='500656-B21')";


$rest = $objConfig->query($sqlres,1);

echo"<pre>";
print_r($rest); exit;
foreach ($rest as $key => $values) {
$result1 =  explode ( ",", $values['SerialNumbers'] );
 $result = "'" . implode ( "', '", $result1 ) . "'";


//echo $Sql = "select UnitCost as avgCost,serialID from inv_serial_item where 1 and UsedSerial=1 and Status=1 and `Condition`='".$values['Condition']."' and Sku ='".$values['sku']."' and serialNumber IN($result)"; 
//$res = $objConfig->query($Sql,1);
//echo"<pre>";
//print_r($res);
//foreach ($res as $key => $serVal) {
//echo $SqlUpdate = "update inv_serial_item set OrderID ='".$values['OrderID']."',SelectType ='SaleOrder' where serialID ='".$serVal['serialID']."' ";
//$objConfig->query($SqlUpdate,1);
//}
echo $SqlUpdate = "update inv_serial_item set UsedSerial=1,OrderID ='".$values['OrderID']."',SelectType ='SaleOrder' where `Condition`='".$values['Condition']."' and Sku ='".$values['sku']."' and warehouse='".$values['WID']."' and serialNumber IN($result) and UsedSerial=0 ";
$objConfig->query($SqlUpdate,1);

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
