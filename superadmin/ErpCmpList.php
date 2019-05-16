<?php 
	$HideNavigation = 1;
	/**************************************************/
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	$ModuleName = "Company";
	$objCompany=new company();

	//$_GET['sortby'] = 'c.CompanyName';
	$arryCompany=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objCompany->numRows();

	$pagerLink=$objPager->getPager($arryCompany,$RecordsPerPage,$_GET['curP']);
	(count($arryCompany)>0)?($arryCompany=$objPager->getPageRecords()):("");


	require_once("includes/footer.php"); 	 
?>


