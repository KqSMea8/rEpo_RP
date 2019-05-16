<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");

	require_once($Prefix."classes/warehouse.class.php");

	$objWarehouse=new warehouse();
 	$arryWarehouse=$objWarehouse->ListManageBin('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objWarehouse->numRows();
	
	$pagerLink=$objPager->getPager($arryWarehouse,$RecordsPerPage,$_GET['curP']);
	(count($arryLead)>0)?($arryWarehouse=$objPager->getPageRecords()):("");



	require_once("../includes/footer.php"); 	 
?>

