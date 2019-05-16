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



$CustID = $_SESSION['UserData']['CustID'];
$arryContact = $objCustomer->GetCustomerShippingContact($CustID);
$arryCustomerInfo = $objCustomer->GetCustomer($CustID,'','');
$CustCode=$arryCustomerInfo['0']['CustCode'];

if($_GET['pk']==1){	
	echo $CustID.'#'.$CustCode;
echo "<pre>";
print_r($_SESSION['UserData']);
}

$arryCustomer = $objCustomer->GetCustomerAllInformation('',$CustCode,'');

$CartItem=$objSale->getCartItem();

$arryPaymentTerm = $objConfigure->GetTerm('','1');
$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');

require_once("includes/footer.php");

?>
