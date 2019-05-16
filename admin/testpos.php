 <?php 
$HideNavigation = 1;
	
	include_once("includes/header.php");

$Sql = "SELECT OrderID FROM `s_order` WHERE `CustomerPO` LIKE '%Dadel-%' ORDER BY `OrderID` DESC  "; 

$rest = $objConfig->query($Sql,1);
echo $res[0]['ToID'];

foreach ($rest as $key => $values) {
$delete2 ="delete from s_order where OrderID ='".$values['OrderID']."' ";
$objConfig->query($delete2,1);
$delete ="delete from s_order_item where OrderID ='".$values['OrderID']."' ";
$objConfig->query($delete,1);
}

?>
