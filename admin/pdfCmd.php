<?php
session_start();
require_once("../includes/function.php"); 
ValidateAdminSession('pdfCmd.php');
	

ini_set('display_errors',0);
$_GET['attachfile']=1;

if (!empty($argv[1])) {
    $arr = explode("&", urldecode($argv[1]));
    foreach ($arr as $arrIndex => $arrValue) {
        $arr1 = explode("=", $arrValue);
        $parameters[$arr1[0]] = $arr1[1];
    }
}
	$Prefix='/var/www/html/erp/';

$pdfbycmd=$parameters['pdfbycmd'];
$savefileUrl = $Prefix."admin/finance/upload/pdf/";
$Prefix1=$Prefix.'admin/';
//$ModDepName='test';
$_GET['ModuleDepName']='SalesInvoice';


$Config['CronJob'] = '1';
   	require_once($Prefix."includes/config.php");
    	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/configure.class.php");


	
	$objConfig=new admin();


	$Config['DbName'] = $parameters['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 


//print_r($parameters['posttogl']);exit;
//foreach($parameters['posttogl'] as $val){
$_GET['o']=$parameters['posttogl'];

include($Prefix1 . "pdfCom.php");
echo 'success';exit;
//exit;
//}

	

	





?>

