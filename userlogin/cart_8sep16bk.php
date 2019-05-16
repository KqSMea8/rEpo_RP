<?php
include_once("includes/header.php");
require_once("../classes/sales.quote.order.class.php");
require_once("../classes/sales.customer.class.php");
$objCustomer = new Customer();
$objSale = new sale();

if(!empty($_GET['DelID'])){
	$_SESSION['mess_cart'] = $ModuleName.REMOVED;
	$objSale->RemoveCart($_GET['DelID']);

	header("location:cart.php");
	exit;
}

$arryContact = $objCustomer->GetCustomerShippingContact($_SESSION['UserData']['Cid']);

$CartItem=$objSale->getCartItem();
require_once("includes/footer.php");

?>
