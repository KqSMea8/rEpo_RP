<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAssemble.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	$ModuleName = "BOM";
	$objBom=new bom();


	/*************************/
	$_GET['Status'] =1;
	$arryOption = $objBom->ListOptionBill($_GET);
        $num=$objBom->numRows();

	$pagerLink=$objPager->getPager($arryOption,$RecordsPerPage,$_GET['curP']);
	(count($arryOption)>0)?($arryOption=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


