<?php 

    error_reporting(E_ALL);
ini_set('display_errors', true);
	
	require_once("includes/settings.php");
	
	require_once("../classes/company.class.php");
	require_once("../classes/region.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/dbfunction.class.php");
	require_once("../classes/phone.class.php");

	
	$objCompany=new company();
	
	//$objCompany->addcc($_REQUEST['CmpID']);
	$objCompany->syncInventoryCompany($_REQUEST['CmpID']);		
	
?>


