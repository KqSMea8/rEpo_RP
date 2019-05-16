<?php 	/**************************************************/
	$ThisPageName = 'chatlist.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/user.class.php");
	
	require_once($Prefix."classes/phone.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Chat Support";
	$objEmployee=new employee();
	$objphone=new phone();
	$objUser=new user();
	$empid='';
	$server_output='';
	
	
	?>
<?php require_once("../includes/footer.php"); 	
?>
