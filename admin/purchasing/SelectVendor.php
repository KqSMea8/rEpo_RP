<?php 
	$HideNavigation = 1;

	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	$ModuleName = "Vendor";
	$objSupplier=new supplier();


	/*************************/
	if($_GET['SuppID']>0){
		$arrySupplier = $objSupplier->GetSupplier($_GET['SuppID'],'','');

		$PageTitle = 'Select Vendor Address';
	}else{
		$_GET['Status'] =1;
		$arrySupplier=$objSupplier->ListSupplier($_GET);
		$num=$objSupplier->numRows();

		$RecordsPerPage=20;
		$pagerLink=$objPager->getPager($arrySupplier,$RecordsPerPage,$_GET['curP']);
		(count($arrySupplier)>0)?($arrySupplier=$objPager->getPageRecords()):("");

		$PageTitle = 'Select Vendor';
	}
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


