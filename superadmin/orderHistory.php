<?php
	include_once("includes/header.php");
	include_once("../classes/superAdminCms.class.php");
	include_once("includes/FieldArray.php");
	$supercmsObj=new supercms();
	 

	$ListUrl    = "orderHistory.php?curP=".$_GET['curP'];

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_payment_status'] = PAYMENT_STATUS_CHANGED;
		$supercmsObj->changePaymentStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
		exit;
	}

	/*******Get Order History**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryOrderHistory=$supercmsObj->getOrderHistoryReller($_GET['key'],$_GET['sortby'],$_GET['asc']);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$supercmsObj->getOrderHistoryReller($_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/

	require_once("includes/footer.php");
?>
