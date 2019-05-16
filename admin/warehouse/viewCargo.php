<?php 
    include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	$ModuleName = "Cargo";

	
	$objSupplier=new supplier();
	$objWarehouse=new warehouse();
	
	/*************************/

	$arryCargo=$objWarehouse->ListCargo($_GET);
	$num=$objWarehouse->numRows();
	$pagerLink=$objPager->getPager($objWarehouse,$RecordsPerPage,$_GET['curP']);
	(count($objWarehouse)>0)?($objWarehouse=$objPager->getPageRecords()):("");

	/*************************/
	
	require_once("../includes/footer.php"); 	
?>


