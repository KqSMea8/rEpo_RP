<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/reseller.class.php");		
	$objSale = new sale();
	$objReseller=new reseller();
	/*************************/
	if(!empty($_GET['f']) && !empty($_GET['t']) && !empty($_GET['s'])){
		$arryPayment=$objReseller->PaymentReport($_GET['f'],$_GET['t'],$_GET['s']);
		$num=$objReseller->numRows();

		$pagerLink=$objPager->getPager($arryPayment,$RecordsPerPage,$_GET['curP']);
		(count($arryPayment)>0)?($arryPayment=$objPager->getPageRecords()):("");
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$arryReseller = $objReseller->GetReseller('',1);

	require_once("../includes/footer.php"); 	
?>


