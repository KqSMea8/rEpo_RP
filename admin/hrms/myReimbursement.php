<?php 
	$EditPage=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/reimbursement.class.php");
	$objReimbursement=new reimbursement();

	$ModuleName = "Reimbursement";	

	if($arryCurrentLocation[0]['ExpenseClaim']==1){
		$_GET['EmpID'] = $_SESSION['AdminID'];
		/******Get Records***********/	
		$Config['RecordsPerPage'] = $RecordsPerPage;
		$arryReimbursement=$objReimbursement->ListReimbursementDetail($_GET);
		/**********Count Records**************/	
		$Config['GetNumRecords'] = 1;
		$arryCount=$objReimbursement->ListReimbursementDetail($_GET);
		$num=$arryCount[0]['NumCount'];	
		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
		/*************************/	
	}else{
		$ErrorMSG = MODULE_INACTIVE_SETTING;
	}
 
	
	require_once("../includes/footer.php");
?>
