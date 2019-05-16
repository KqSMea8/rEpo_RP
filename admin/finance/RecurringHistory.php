<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php"); 
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();
	$objCustomer = new Customer();	 
	     
	$RecordsPerPage=1000;

	if(!empty($_GET['Parent'])){  
		/*************************/
		$Config['RecordsPerPage'] = $RecordsPerPage;		 
		$arrySale=$objCustomer->ListRecurringHistory($_GET);
		$num=sizeof($arrySale);
		/*******Count Records**********/
		$Config['GetNumRecords'] = 1;
		$arryCount=$objCustomer->ListRecurringHistory($_GET);
		$num=$arryCount[0]['NumCount'];	
		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);   
		/*************************/	
	}
	 
	require_once("../includes/footer.php"); 	
?>



