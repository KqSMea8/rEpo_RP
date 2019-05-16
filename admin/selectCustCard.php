<?php 
	$HideNavigation = 1;
	
	include_once("includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "Customer";
	$objCustomer = new Customer();

	(empty($_GET['CustID']))?($_GET['CustID']=""):("");
	(empty($_GET['type']))?($_GET['type']=""):("");


	if(!empty($_GET['CustID'])) {
		$arryCard = $objCustomer->GetCard('',$_GET['CustID'],''); 
		$num = sizeof($arryCard);
	}else{
		$ErrorMsg = '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}
	require_once("includes/footer.php"); 	
?>


