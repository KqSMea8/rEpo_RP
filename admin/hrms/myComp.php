<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	$objLeave=new leave();

	$ModuleName = "Compensatory-Off";	

	$arryComp=$objLeave->getComp('',$_SESSION["AdminID"]);
	$num = sizeof($arryComp);

	$pagerLink=$objPager->getPager($arryComp,$RecordsPerPage,$_GET['curP']);
	(count($arryComp)>0)?($arryComp=$objPager->getPageRecords()):("");


	require_once("../includes/footer.php");
?>
