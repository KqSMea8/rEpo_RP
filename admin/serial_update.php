<?php $HideNavigation = 1;
	
	include_once("includes/header.php");
require_once($Prefix."classes/item.class.php");
$objItem=new items();
//$arryProduct=$objItem->GetItemsView($_GET);
//foreach ($arryProduct as $key => $values) {

//if($values['evaluationType']=='Serialized' || $values['evaluationType']=='Serialized Average'){

$arryCondQty=$objItem->GetonHandQty('');


if(is_array($arryCondQty)){

foreach ($arryCondQty as $key => $values) {
if($values['evaluationType']=='Serialized' || $values['evaluationType']=='Serialized Average'){

 $Sql = "select COUNT(*) as qty from inv_serial_item where   OrderID=0 and SelectType=''  and UsedSerial=0   and Sku='".$values['Sku']."' and `Condition`= '".$values['condition']."' and warehouse = '".$values['WID']."'";
$res = $objConfig->query($Sql,1);
//echo "<pre>";
//print_r($res);


//foreach($res as $key => $res[0]) {

//if($res[0]['qty']!='' && !empty($res[0]['qty'])){
if(sizeof($res)>0){

# echo $values['condition']."=>".$values['condition_qty']."=> Sku=>".$values['Sku']."=>warehouse=>".$values['WID']."=> SerialQty- ".$res[0]['qty']."<br/>";

 $SqlUpdate = "update inv_item_quanity_condition set condition_qty ='".$res[0]['qty']."' where `condition` ='".$values['condition']."' and Sku ='".$values['Sku']."' and WID = '".$values['WID']."'";

$objConfig->query($SqlUpdate,0);


$sqluptodate = "SELECT COUNT(*) as qty,Sku,warehouse,`Condition` FROM `inv_serial_item` WHERE `LineID` != 0 and UsedSerial=1 and OrderID=0 and SelectType='' and ReceiptDate>'2018-04-01' and Sku='".$values['Sku']."' and `Condition`= '".$values['condition']."' and warehouse = '".$values['WID']."' ORDER BY `inv_serial_item`.`ReceiptDate` DESC ";
$result = $objConfig->query($sqluptodate,1);



if($result[0]['qty']>0){

$SqlreailUpdate = "update inv_item_quanity_condition set condition_qty ='".$result[0]['qty']."' where `condition` ='".$result[0]['Condition']."' and Sku ='".$result[0]['Sku']."' and WID = '".$result[0]['warehouse']."'";

$objConfig->query($SqlreailUpdate,0);
}

}else{
#echo $res[0]['Condition']."=>".$values['condition_qty']."=> Sku=>".$values['Sku']."=>warehouse=>".$values['WID']."=> SerialQty- ".$values['condition_qty']."<br/>";
$SqlUpdate2 = "update inv_item_quanity_condition set condition_qty ='0' where `condition` ='".$values['condition']."' and Sku ='".$values['Sku']."' and WID = '".$values['WID']."'";
$objConfig->query($SqlUpdate2,0);
}
#$objConfig->query($SqlUpdate,0);
//}
}
}
}

?>
