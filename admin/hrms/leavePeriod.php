<?php
	if(!empty($_GET['pop']))$HideNavigation = 1;

	/**************************************************/
	$EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	$objLeave=new leave();
	$ModuleName = "Leave Period";
	$RedirectUrl ="leavePeriod.php";

	if ($_POST) {
		$objLeave->UpdateLeavePeriod($_POST);
		$_SESSION['mess_leave_pr'] = LEAVE_PERIOD_UPDATED;
		header("location:".$RedirectUrl);
		exit;
	}
	
	$arryLeavePeriod = $objLeave->GetLeavePeriod();

	require_once("../includes/footer.php");  
?>
