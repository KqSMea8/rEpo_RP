<?php 

	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	$objLeave=new leave();
	$ModuleName = "Holiday";	

	$arryHoliday=$objLeave->getHoliday('','');
	$num=sizeof($arryHoliday);

	require_once("../includes/footer.php");
?>

