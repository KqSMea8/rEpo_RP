<?php
include_once("includes/header.php");
require_once("classes/orders.class.php");

if (class_exists(orders)) {
	$objOrder=new orders();
} else {
	echo "Class Not Found Error !! Order Class Not Found !";
	exit;
}

$OrderID = isset($_GET['OrderID'])?$_GET['OrderID']:"";
$OrderStatus = isset($_GET['OrderStatus'])?$_GET['OrderStatus']:"";
$PaymentStatus = isset($_GET['PaymentStatus'])?$_GET['PaymentStatus']:"";
$CustomerName = isset($_GET['CustomerName'])?$_GET['CustomerName']:"";
$OrderPeriod = isset($_GET['OrderPeriod'])?$_GET['OrderPeriod']:"";

$arrayOrders = $objOrder->GetOrders($OrderID,$OrderStatus,$PaymentStatus,$CustomerName,$OrderPeriod);
$num=$objOrder->numRows();

$ModuleName = 'Order';
$ListTitle  = 'Orders';
$ListUrl    = "viewOrder.php?curP=".$_GET['curP'];

//Delete Order
if(!empty($_GET['del_id'])){
	$_SESSION['mess_order'] = $ModuleName.REMOVED;
	$objOrder->deleteOrder($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}
 
require_once("includes/footer.php");

?>
