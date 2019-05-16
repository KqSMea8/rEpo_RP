<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	$objLeave=new leave();

	$ModuleName = "Comp-Off";	


	$RedirectUrl ="compApplied.php?curP=".$_GET['curP'];
	$ModuleName = "Compensation";	

	if($_GET["approve_id"]>0) {
		$objLeave->ApproveSuppComp($_GET["approve_id"]);
		$objLeave->sendCompEmail($_GET["approve_id"]); 

		$_SESSION['mess_comp'] = COMP_SUPP_APPROVED;

		header("location:".$RedirectUrl);
		exit;		
	}












	$_GET["SuppID"] = $_SESSION['AdminID'];
	$arryComp=$objLeave->ListComp($_GET);
	$num = sizeof($arryComp);

	$pagerLink=$objPager->getPager($arryComp,$RecordsPerPage,$_GET['curP']);
	(count($arryComp)>0)?($arryComp=$objPager->getPageRecords()):("");


	require_once("../includes/footer.php");
?>