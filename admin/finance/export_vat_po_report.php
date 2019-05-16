<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.report.class.php");

$objReport = new report();


/*************************/
	$_SESSION['CustExlstate_id']=$_GET['state_id'];
	$_SESSION['CustExlcountry_id']=$_GET['country_id'];
	
        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
        
        
        $_SESSION['CustExlstate_id']=$_GET['state_id'];
	$_SESSION['CustExlcountry_id']=$_GET['country_id'];
	
	$arryVatSales=$objReport->VatCollectionReportSales($_GET);
	$arryVatPurchase=$objReport->VatCollectionReportPurchase($_GET); 	
	$arryVatpo=$objReport->VatCollectionReport($_GET); 
	$arryVat = array_merge($arryVatSales, $arryVatPurchase,$arryVatpo);	
	$num = count($arryVat);
	
	$fileName = 'Vat_Report';
	$ExportFile=$fileName."_".date('d-m-Y').".xls";
	include_once("includes/html/box/vat_po_report_data.php");
	
/*************************/
?>


