<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.customer.class.php");
$objCustomer = new Customer();
$_GET["CustCode"] = $_GET["c"];	
if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}

if(!empty($_GET["CustCode"])){
	$arryCustomer = $objCustomer->GetCustomer('',$_GET['CustCode'],'');
	if($arryCustomer[0]['Cid']>0){	
		$arryData=$objCustomer->GetSalesDataByCustomer($_GET);	
		$num = sizeof($arryData);
	} 
}

if($arryCustomer[0]['Cid']<=0){
	$ErrorMSG = CUSTOMER_NOT_EXIST;		
}


$fileName = $arryCustomer[0]['CustCode'].'_SalesHistory';
$ExportFile=$fileName."_".date('d-m-Y').".xls";

include_once("includes/html/box/customer_sales_history.php");
?>
