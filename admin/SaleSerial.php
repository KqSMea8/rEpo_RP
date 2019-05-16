<? 

 $HideNavigation = 1;
	
	include_once("includes/header.php");


#echo $sqlres= "SELECT p_order.Module,p_order.Status,p_order_item.OrderID,p_order_item.WID,p_order_item.item_id,p_order_item.qty,p_order_item.sku,p_order_item.`Condition`,p_order.SaleID,p_order.InvoiceID,p_order_item.SerialNumbers from p_order_item as p_order_item inner join p_order as p_order on p_order_item.OrderID =p_order.OrderID WHERE 1 and p_order.Module='RMA' and p_order_item.SerialNumbers!='' ";

//echo $sqlres= "SELECT * from inv_stock_adjustment WHERE 1 and (sku = '500202-061' or sku ='500656-B21')";

 $sqlres= "SELECT asmID,serial,Sku,`Condition`,WID FROM `inv_item_assembly`  WHERE 1  order by asmID";


$rest = $objConfig->query($sqlres,1);

#echo"<pre>";
#print_r($rest);  exit;
foreach ($rest as $key => $values) {
$result1 =  explode ( ",", $values['serial'] );
 $result = "'" . implode ( "', '", $result1 ) . "'";


 $Sql = "select Sku,`Condition`,warehouse,serialNumber from inv_serial_item where 1 and UsedSerial=0 and Status=1 and `Condition`='".$values['Condition']."' and Sku ='".$values['Sku']."' and serialNumber IN($result)"; 
$res = $objConfig->query($Sql,1);
echo"<pre>";
print_r($res); exit;
//foreach ($res as $key => $serVal) {
//echo $SqlUpdate = "update inv_serial_item set OrderID ='".$values['OrderID']."',SelectType ='SaleOrder' where serialID ='".$serVal['serialID']."' ";
//$objConfig->query($SqlUpdate,1);
//}

if($res[0]['serialNumber']!=''){
echo $res[0]['serialNumber'];
echo "<br />";
echo $SqlUpdate = "update inv_serial_item set SelectType='".$values['asmID']."',UsedSerial=1 where  serialNumber like '".$res[0]['serialNumber']."'  and warehouse= '".$res[0]['warehouse']."' and Sku= '".$res[0]['Sku']."' and `Condition` = '".$res[0]['Condition']."' and UsedSerial =0";
$objConfig->query($SqlUpdate,1);
echo "<br />";
 }

//$objConfig->query($SqlUpdate,1);

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
 $SqlUpdate = "update p_order_item set avgCost ='".$Cost."' where `Condition` ='".$values['Condition']."' and Sku ='".$values['sku']."' and DropShipCheck =0 and OrderID = '".$values['OrderID']."' and `Condition`!='' ";
$objConfig->query($SqlUpdate,0);
}*/
#echo $Sql = "select SUM(UnitCost) as avgCost from inv_serial_item where 1 and `Condition`='".$values['Condition']."' and Sku ='".$values['Sku']."' and serialNumber IN('".$Sr."')"; exit;
#$res = $objConfig->query($Sql,1);

//echo $Srr;



//}
?>
