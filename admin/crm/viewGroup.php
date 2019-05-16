<?php  $FancyBox=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/group.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Group";
	$objGroup=new group();
	
	$arryGroup=$objGroup->ListGroup('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objGroup->numRows();

	$pagerLink=$objPager->getPager($arryGroup,$RecordsPerPage,$_GET['curP']);
	(count($arryGroup)>0)?($arryGroup=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


