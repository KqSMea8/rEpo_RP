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

if($EmpID>0 || $SuppID>0){			
	$arrySalesCommissionComm = $objEmployee->GetSalesCommission($EmpID,$SuppID);
}


if($_GET['f']>0) $FromDate = $_GET['f'];
if($_GET['t']>0) $ToDate = $_GET['t']; 
 
$arryPayment=$objSale->CommReport($arrySalesCommissionComm[0]['CommOn'], $_GET['f'],$_GET['t'],$_GET['s'],$_GET['sp']);
$num=$objSale->numRows(); 
/****************************/   
$SalesPerson=''; 
if(!empty($_GET['s'])){
	$SalesPerson = $objConfig->getSalesPersonName($_GET['s'],$_GET['sp']);
}


 
$ExportFile = "SalesCommissionReport_".$SalesPerson."_".date('d-m-Y').".xls";
  
include_once("includes/html/box/comm_report_data.php");
?>


