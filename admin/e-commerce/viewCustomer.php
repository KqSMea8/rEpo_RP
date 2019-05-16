<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/customer.class.php");
        $objCustomer=new Customer();
	 

	/******Get Customer Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']); 
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	
  
        
  	require_once("../includes/footer.php");
  
?>
