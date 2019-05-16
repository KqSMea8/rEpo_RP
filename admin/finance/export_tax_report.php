<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.report.class.php");
$objReport = new report();


/*************************/
if(empty($_GET['rtype'])){ $_GET['rtype'] = 'S';}
if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}


if($_GET['rtype']=='P'){  //Purchase Tax Report
	$arryData=$objReport->PurchaseTaxReportLocation($_GET);
	$num=$objReport->numRows();	
	$Module = 'Purchase';
}else{        
	$arryData=$objReport->SalesTaxReportLocation($_GET);
	$num=$objReport->numRows();	 
	$Module = 'Sales';
}

$fileName = $Module.'_Tax_Report';

$ExportFile=$fileName."_".date('d-m-Y').".xls";

include_once("includes/html/box/tax_report_data.php");
?>
