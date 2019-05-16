<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php?module=Order'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "Customer";
	$objCustomer = new Customer();
	
	//$_GET['CustID'] = '49';
	/*************************/
	if($_GET['CustID']>0){
		$arryContact = $objCustomer->GetCustomerContact($_GET['CustID'],'');
		$num=$objCustomer->numRows();
	}else{
		echo '<div class="redmsg" align="center"><br><br>'.SELECT_CUSTOMER.'</div>';
	}
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


