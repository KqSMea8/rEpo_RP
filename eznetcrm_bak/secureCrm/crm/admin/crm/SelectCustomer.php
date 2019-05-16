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
	if($_GET['Cid']>0){
		$arryCustomer = $objCustomer->GetCustomer($_GET['Cid'],'','');

		$PageTitle = 'Select Customer Address';
	}else{
		$arryCustomer = $objCustomer->ListCustomer($_GET);
		$num=$objCustomer->numRows();

		$RecordsPerPage=20;
		$pagerLink=$objPager->getPager($arryCustomer,$RecordsPerPage,$_GET['curP']);
		(count($arryCustomer)>0)?($arryCustomer=$objPager->getPageRecords()):("");

		$PageTitle = 'Select Customer';
	}
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


