<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/event.class.php");
	$objCustomer=new Customer();
	$objActivity=new activity();
	
	/*************************/
	if($_GET['Cid']>0){
		$Config['vAllRecord']=1;
		$_GET['CustID'] = $_GET['Cid'];
		$arryActivity=$objActivity->GetActivityList($_GET);
		$num=$objActivity->numRows();    	

		$pagerLink=$objPager->getPager($arryActivity,$RecordsPerPage,$_GET['curP']);
		(count($arryActivity)>0)?($arryActivity=$objPager->getPageRecords()):("");
	}
	/*************************/
 
	$arryCustomer=$objCustomer->getCustomers('','','active','','');
	require_once("../includes/footer.php"); 	
?>
