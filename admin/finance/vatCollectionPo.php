<?php
	
	require_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	$objReport = new report();
	
	$_SESSION['CustExlstate_id']=$_GET['state_id'];
	$_SESSION['CustExlcountry_id']=$_GET['country_id'];	
        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}       
        $_SESSION['CustExlstate_id']=$_GET['state_id'];
	$_SESSION['CustExlcountry_id']=$_GET['country_id'];	
	
	$arryVatSales=$objReport->VatCollectionReportSales($_GET);
	//$arryVatSales = array_values(array_filter(array_map('array_filter', $arryVatSales)));
	$arryVatPurchase=$objReport->VatCollectionReportPurchase($_GET); 	
	//$arryVatPurchase = array_values(array_filter(array_map('array_filter', $arryVatPurchase)));	
	$arryVatpo=$objReport->VatCollectionReport($_GET); 
	
	$arryVat = array_merge($arryVatSales, $arryVatPurchase,$arryVatpo);
	$num=count($arryVat);

	$pagerLink=$objPager->getPager($arryVat,$RecordsPerPage,$_GET['curP']);
	(count($arryVat)>0)?($arryVat=$objPager->getPageRecords()):("");
	
        require_once("../includes/footer.php"); 
      
        

?>
