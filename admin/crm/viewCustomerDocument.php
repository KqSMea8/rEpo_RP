<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/lead.class.php");
	$objCustomer=new Customer();
	$objLead=new lead();
	
	/*************************/
	if($_GET['Cid']>0){
		$arryDocument=$objLead->GetCustomerDocument($_GET['Cid']);
		$num=$objLead->numRows();    	

		$pagerLink=$objPager->getPager($arryDocument,$RecordsPerPage,$_GET['curP']);
		(count($arryDocument)>0)?($arryDocument=$objPager->getPageRecords()):("");
	}
	/*************************/
 
	$arryCustomer=$objCustomer->getCustomers('','','active','','');
	require_once("../includes/footer.php"); 	
?>
