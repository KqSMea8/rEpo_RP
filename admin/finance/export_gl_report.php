<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.transaction.class.php");
$objTransaction=new transaction();

$DefaultCurrency =  $Config["Currency"];
$CurrencyArray[] = $DefaultCurrency; //Default Currency

/*************************/
if(empty($_GET['FromDate'])) $_GET['FromDate'] =  date('Y-m-01');
if(empty($_GET['ToDate'])) $_GET['ToDate'] =  date('Y-m-d');

	(empty($_GET['AccountID']))?($_GET['AccountID']=""):(""); 
	(empty($_GET['FilterBy']))?($_GET['FilterBy']=""):(""); 
	(empty($_GET['Month']))?($_GET['Month']=""):(""); 
	(empty($_GET['Year']))?($_GET['Year']=""):(""); 
	(empty($_GET['Currency']))?($_GET['Currency']=""):("");  

/*********ModuleCurrency**********/	
	$_GET['GetModuleCurrency'] = 1;
 	$arryModuleCurrency = $objTransaction->GLReport($_GET);
	foreach($arryModuleCurrency as $ky=>$val){ 
		$CurrencyArray[] = $val['ModuleCurrency']; 
	}
	
	$_GET['GetModuleCurrency'] = 0;
	$CurrencyArray = array_unique($CurrencyArray);		
	/*************************/
	      
	if(!empty($_GET['Currency']) && $_GET['Currency']!= $Config['Currency']){
		$Config['ModuleCurrencySel'] = $_GET['Currency'];
		$DefaultCurrency = $Config['ModuleCurrencySel'];
	}



$arryReport=$objTransaction->GLReport($_GET);
$num=$objTransaction->numRows();  
/****************************/   
$fileName = "GlAccountReport";
$ExportFile=$fileName."_".date('d-m-Y').".xls";
include_once("includes/html/box/gl_report_data.php");

?>


