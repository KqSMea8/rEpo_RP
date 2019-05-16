<?php  $FancyBox=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/event.class.php");
	$ModuleName = "Event";
	$objEvent=new event();

	$arryEvent=$objEvent->ListEvent('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objEvent->numRows();

	$pagerLink=$objPager->getPager($objEvent,$RecordsPerPage,$_GET['curP']);
	(count($arryEvent)>0)?($arryEvent=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>