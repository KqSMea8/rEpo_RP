<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'CustomerViewList.php?module=CustomerViewlist'; 
	/**************************************************/
		
	include_once("../includes/header.php");
	
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "CustomerViewlist";
	//$objCustomer = new supplier();
	$objCustomerViewList = new Customer();


	/*************************/
	//$arryCustomer = $objVenderList->ListCustomer($_GET);
	$arryCustomerViewList = $objCustomerViewList->ListCustomer($_GET);
	//print_r($objCustomerViewList); die('suneel');
	$num=$objCustomerViewList->numRows();
	//echo $num; die('aaa');
	$pagerLink=$objPager->getPager($arryCustomerViewList,$RecordsPerPage,$_GET['curP']);
	(count($arryCustomerViewList)>0)?($arryCustomerViewList=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>

