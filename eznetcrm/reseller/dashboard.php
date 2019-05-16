<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

//ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');

require_once("../../classes/company.class.php");
	require_once("../../classes/admin.class.php");

	require_once("../../classes/user.class.php");
	require_once("../../classes/configure.class.php");
	require_once("../../includes/browser_detection.php");
	require_once("../../classes/rsl.class.php");
	
	$objConfig=new admin();
	$objCompany=new company();
	$objUser=new user();
	
	/*$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();*/

include ('includes/footer.php');
 ?>