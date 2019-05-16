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
	
	
		if($_REQUEST['id']!='' && $_REQUEST['status']=='Reject'){
			$arryWalletHistory=$objDealer->updateDealerMsgStatus($_REQUEST);	
			header("location: viewDealerRequest.php?DealerId=".$_REQUEST['DealerId']);		
			
		}
		$postArray=$_REQUEST;

		//$objDealer->creditDebitWallet($postArray);
		$DealerId=$_REQUEST['DealerId'];
		$arryWalletHistory=$objDealer->getDealerRequestByDealerId($DealerId);
		$num=$objDealer->numRows();



	


	$arryCustomer=$objCustomer->getCustomers();


}

require_once("../includes/footer.php");

?>
