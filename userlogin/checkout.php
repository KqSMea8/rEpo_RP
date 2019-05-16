<?php
include_once("includes/header.php");
require_once("../classes/sales.quote.order.class.php");
require_once("../classes/sales.customer.class.php");
require_once("../classes/sales.class.php");
$objSale = new sale();
$objCommon = new common();
if($_POST){
	
	$AutomaticApprove = $objCommon->getSettingVariable('SO_APPROVE');
	$_POST['Approved'] = $AutomaticApprove;
	$res=$objSale->addOrderCustomer($_POST);
	if($res){
		$_SESSION['mess_order']='You have successfully placed an order.';
		header("Location: dashboard.php?curP=1&tab=salesorder");
		exit;
	}
}else{
	header("Location: home.php");
	exit;
}
require_once("includes/footer.php");
?>
