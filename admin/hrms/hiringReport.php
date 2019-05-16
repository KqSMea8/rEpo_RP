<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$ModuleName = "Employee";
	$objEmployee=new employee();

	/*************************/
	if(!empty($_GET['f']) && !empty($_GET['t'])){
		$arryEmployee=$objEmployee->ListHired($_GET['f'],$_GET['t'],$_GET['d']);
		$num=$objEmployee->numRows();

		$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
		(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	}
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


