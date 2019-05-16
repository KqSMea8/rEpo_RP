<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/vendor.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Vendor";
	$objVendor=new vendor();


	/*************************/
	$arryVendor=$objVendor->ListVendor($_GET);
	$num=$objVendor->numRows();

	$pagerLink=$objPager->getPager($arryVendor,$RecordsPerPage,$_GET['curP']);
	(count($arryVendor)>0)?($arryVendor=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


