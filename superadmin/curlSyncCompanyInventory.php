<?php 


 error_reporting(E_ALL);
ini_set('display_errors', true);
	
/*$myfile = fopen("newfile.txt", "a+") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);

die('asa');*/
	$param=explode('=',$argv[1]);
	
	$Prefix = "/var/www/html/erp";
	$Config['CronJob'] = '1';
	require_once($Prefix."/includes/config.php");
	require_once($Prefix."/includes/language.php");
	require_once($Prefix."/includes/function.php");
	require_once($Prefix."/classes/dbClass.php");
	require_once($Prefix."/classes/admin.class.php");	
	require_once($Prefix."/classes/pager.cls.php");
	require_once($Prefix."/classes/MyMailer.php");
	require_once($Prefix."/classes/Suser.Class.php");	
	//require_once("language/english.php");

	//require_once($Prefix."superadmin/includes/settings.php");
	//require_once($Prefix."includes/config.php");
	require_once($Prefix."/classes/company.class.php");
	require_once($Prefix."/classes/region.class.php");
	require_once($Prefix."/classes/configure.class.php");
	require_once($Prefix."/classes/dbfunction.class.php");
	require_once($Prefix."/classes/phone.class.php");

	
	$objCompany=new company();

	date_default_timezone_set('America/New_York');


	 $CmpID=trim($param[1]); //'281'; //$argv[1]; 
	
	//$objCompany->addcc($CmpID);
	$objCompany->syncInventoryCompany($CmpID);		
	
?>


