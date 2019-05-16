<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.report.class.php");
require_once($Prefix."classes/sales.quote.order.class.php");


$objSale = new sale();	 
$objReport = new report();


/*************************/

if($_GET['t']>0){ $ToDate = $_GET['t'];}else{$ToDate = date('Y-m-d');}
if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-01');}

$arrySale=$objReport->InvoiceMarginReport($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);
$num=$objReport->numRows();

$fileName = 'Invoice_Margin_Report';

$ExportFile=$fileName."_".date('d-m-Y').".xls";

include_once("includes/html/box/margin_report_data.php");
?>
