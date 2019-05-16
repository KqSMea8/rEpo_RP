<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewQuote.php?module=Quote'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "Customer";
	$objCustomer = new Customer();


	/*************************/
	$arryCustomer = $objCustomer->ListCustomer($_GET);
	
	//echo "<pre>";print_r($arryCustomer);die;
	$num=$objCustomer->numRows();

	$pagerLink=$objPager->getPager($arryCustomer,$RecordsPerPage,$_GET['curP']);
	(count($arryCustomer)>0)?($arryCustomer=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


