<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	$ModuleName = "Vendor";
	$objSupplier=new supplier();
	
	(empty($_GET['link'])) ? ($_GET['link']='') : ("");
	define("NO_SUPPLIER","Total Records");

	/*******Get Vendor Records**************/
	$Config['addTp'] = 'billing';
	$_GET['Status'] =1;	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySupplier=$objSupplier->ListSupplier($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSupplier->ListSupplier($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/

	require_once("../includes/footer.php"); 	
?>


