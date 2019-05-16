<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.report.class.php");
$objReport = new report();
$module = 'Sales_Tax_Report';

/*************************/
if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
if(empty($_GET['rby'])){ $_GET['rby'] = 'C'; }

if($_GET['rby']=='C'){ $TaxDisplay = 'style="display:none"'; }
        
$arrySale=$objReport->SalesTaxReportLocation($_GET);
$num=$objReport->numRows();

$ExportFile=$module."_".date('d-m-Y').".xls";

include_once("includes/html/box/sales_tax_report_action.php");


?>
