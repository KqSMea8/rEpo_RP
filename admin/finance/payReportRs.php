<?php 
	$HideNavigation = 1;$_GET['sb']=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/reseller.class.php");			
	$objSale = new sale();
	$objReseller=new reseller();
	/*************************/
	$RsID = $_GET['s'];
	if($_GET['f']>0) $FromDate = $_GET['f'];
	if($_GET['t']>0) $ToDate = $_GET['t']; 
	if(!empty($_GET['sb'])){
		$arryPayment=$objReseller->PaymentReport($_GET['f'],$_GET['t'],$_GET['s']);
		$num=$objReseller->numRows();

	}
	/*************************/
	$MainModuleName = 'Sales Report';

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	if($RsID>0){
		$arryReseller = $objReseller->GetResellerWithComm($RsID,'');
		$arrySalesCommReseller[$RsID] = $objReseller->GetSalesCommission($RsID);
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	require_once("../includes/footer.php"); 	
?>


