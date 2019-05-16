<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/group.class.php");
	$objCustomer=new Customer();
	$objLead=new lead();
	$objGroup=new group();
	$vTicket="vTicket.php?module=Ticket&view=";
	/*************************/
	if($_GET['Cid']>0){
		$Config['vAllRecord']=1;
		$_GET['CustID'] = $_GET['Cid'];
		$arryTicket=$objLead->ListTicket($_GET);
		$num=$objLead->numRows();    	

		$pagerLink=$objPager->getPager($arryTicket,$RecordsPerPage,$_GET['curP']);
		(count($arryTicket)>0)?($arryTicket=$objPager->getPageRecords()):("");
	}
	/*************************/
 
	$arryCustomer=$objCustomer->getCustomers('','','active','','');
	require_once("../includes/footer.php"); 	
?>
