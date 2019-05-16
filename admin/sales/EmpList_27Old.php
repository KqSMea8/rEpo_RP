<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();


	/*************************/
	$_GET["d"] = 14;
	if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$num=$objEmployee->numRows();
	
	$RecordsPerPage=20;
	$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


