<?php 
	$HideNavigation = 1;
	/**************************************************/
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	$ModuleName = "Company";
	$objCompany=new company();

	//$_GET['sortby'] = 'c.CompanyName';

	/*******Get Company Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryCompany=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/


	require_once("includes/footer.php"); 	 
?>


