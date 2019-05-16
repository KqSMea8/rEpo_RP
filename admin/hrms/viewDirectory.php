<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/******************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objEmployee=new employee();


	$RedirectURL = 'viewDirectory.php';

	if($_POST){
		if (!empty($_POST['sbo'])) {
			$objEmployee->updateOrderBy($_POST);
			$_SESSION['mess_directory'] = EMP_ORDER_UPDATED;
		}
		header("Location:".$RedirectURL);
		exit;
	}


	/*************************/
	$arryEmployee=$objEmployee->ListDirectory('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objEmployee->numRows();

	/*$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	/*************************/
 




	require_once("../includes/footer.php"); 	
?>


