<?php
include_once("../includes/header.php");
require_once($Prefix."classes/dealer.class.php");
require_once($Prefix."classes/customer.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(dealer)) {
	$objCustomer=new Customer();
	$objDealer=new dealer();
} else {
	echo "Class Not Found Error !! ";
	exit;
}


if (is_object($objCustomer)) {
	$arryCustomer=$objCustomer->getCustomers();
	if ($_POST) {
		$DealerId=$_POST['DealerId'];

	}else{
		$DealerId=$arryCustomer[0]['Cid'];
	}

	if($DealerId!=''){
		$arryWalletHistory=$objDealer->getDealerWalletHistoryByDealerId($DealerId);
		$num=$objDealer->numRows();
	}
	$arryWalletHistory=$objDealer->getDealerWalletHistoryByDealerId($DealerId);
	$num=$objDealer->numRows();



}

require_once("../includes/footer.php");

?>
