<?php 
	$HideNavigation = 1;
	/**************************************************/
	include_once("includes/header.php");
	include ('includes/function.php');
	require_once($Prefix."classes/company.class.php");
	$ModuleName = "Company";
	$objCompany=new company();

	$_GET['RsID']=$_SESSION['CrmRsID'];
	$arryCompany=$objCompany->CompanyListing($_GET);
	$num=$objCompany->numRows();

	$pagerLink=$objPager->getPager($arryCompany,$RecordsPerPage,$_GET['curP']);
	(count($arryCompany)>0)?($arryCompany=$objPager->getPageRecords()):("");


	require_once("includes/footer.php"); 	 
?>


