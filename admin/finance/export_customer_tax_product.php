<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/finance.report.class.php");
$objCustomer = new Customer();
$objReport = new report();

/*************************/
if(empty($_GET['rtype'])){ $_GET['rtype'] = 'S';}
if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}

      
$arryData=$objCustomer->CustomerTaxByProduct($_GET);
$num=$objCustomer->numRows();	 

 

$fileName = 'CustomerTaxReportByProduct';

$ExportFile=$fileName."_".date('d-m-Y').".xls";

include_once("includes/html/box/customer_tax_product_data.php");
?>
