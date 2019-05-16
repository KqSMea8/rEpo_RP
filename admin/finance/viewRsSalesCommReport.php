<?php 	
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/reseller.class.php");				
	$objSale = new sale();
	$objReseller=new reseller();
	/*************************/
	 (empty($_GET['s']))?($_GET['s']=""):("");

	if(!empty($_GET['m']) && !empty($_GET['y'])){		
		$FromDate = $_GET['y']."-".$_GET['m']."-01";
		$NumDayMonth = date('t', strtotime($FromDate));
		$ToDate = $_GET['y']."-".$_GET['m']."-".$NumDayMonth;
	}else if(!empty($_GET['y'])){
		$FromDate = $_GET['y']."-01-01";		
		$ToDate = $_GET['y']."-12-31";
	}

	if(!empty($_GET['sb'])){	
		$arryPayment=$objReseller->SalesCommReport($FromDate,$ToDate,$_GET['s']);
		$num=$objReseller->numRows();	
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$arryReseller = $objReseller->GetResellerWithComm('',1);

	require_once("../includes/footer.php"); 	
?>


