<?php
	/**************************************************/
	$ThisPageName = 'leaveApplied.php'; $EditPage = 1; $ModifyLabel = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objLeave=new leave();
	$objEmployee=new employee();

	$RedirectUrl = "leaveApplied.php?curP=".$_GET['curP'];
	$ModuleName = "Leave";	




	require_once("includes/html/box/leave_action.php");

	require_once("../includes/footer.php"); 

?>
