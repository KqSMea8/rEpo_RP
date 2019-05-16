<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/employee.class.php");		
$objSale = new sale();
$objEmployee=new employee();
/****************************/ 
if($_GET['sp']=="1"){
	$EmpID = 0; $SuppID = $_GET['s'];
}else{
	$EmpID = $_GET['s']; $SuppID=0;
}
if($_GET['f']>0) $FromDate = $_GET['f'];
if($_GET['t']>0) $ToDate = $_GET['t']; 
 
$arryPayment=$objSale->PaymentReport($_GET['f'],$_GET['t'],$_GET['s'],$_GET['sp']);
$num=$objSale->numRows(); 
/****************************/   
$SalesPerson = str_replace(" ","-",$arryPayment[0]['SalesPerson']); 
$ExportFile = "SalesCommissionReport_".$SalesPerson."_".date('d-m-Y').".xls";
 
include_once("includes/html/box/pay_report_data.php");
?>


