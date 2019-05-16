<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	
	$objCustomer=new Customer();

	
	/*************************/
	if($_GET['Cid']>0){
		$arryContact = $objCustomer->GetCustomerContact($_GET['Cid'],'');
		$num=$objCustomer->numRows();    	

		$pagerLink=$objPager->getPager($arryContact,$RecordsPerPage,$_GET['curP']);
		(count($arryContact)>0)?($arryContact=$objPager->getPageRecords()):("");
	}
	/*************************/
 
	$arryCustomer=$objCustomer->getCustomers('','','active','','');
	require_once("../includes/footer.php"); 	
?>
