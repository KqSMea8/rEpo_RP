<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

//ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');

require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/erp.admin.class.php");

	require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."includes/browser_detection.php");
	require_once($Prefix."classes/rsl.class.php");
	
	$objConfig=new admin();
	$objCompany=new company();
	$objUser=new user();
	
	/*$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();*/

include ('includes/footer.php');
 ?>