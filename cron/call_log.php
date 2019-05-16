<?php 		
	$Department = 7; $ThisPage = 'call_log.php';
	ob_start();
	session_start();
	
	
	$Prefix = "/var/www/html/erp/";
	ini_set("display_errors","1"); error_reporting(5);
	$Config['CronJob'] = '1';
	
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/MyMailer.php");	
    require_once($Prefix."classes/column_encode.class.php");
    require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);	
	$objphone=new phone();
	$allserver=$objphone->ListServer();
	//print_r($allserver);
			$CmpDatabase = $Config['DbName'];
			$Config['DbName'] = $CmpDatabase;
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			
			
	
	
?>
