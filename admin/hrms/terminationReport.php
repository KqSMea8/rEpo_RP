<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$ModuleName = "Employee";
	$objEmployee=new employee();

	(empty($_GET['Year']))?($_GET['Year']=""):("");
	(empty($_GET['s']))?($_GET['s']=""):("");
	/*************************/
	$arryEmployee=$objEmployee->ListTerminated('',$_GET['Year'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objEmployee->numRows();

	$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


