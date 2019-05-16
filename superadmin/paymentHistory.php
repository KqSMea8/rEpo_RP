<?php
	include_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");
	include_once("includes/FieldArray.php");
	$supercmsObj=new supercms();
 

	$ListUrl = "paymentHistory.php?curP=".$_GET['curP'];
	if(!empty($_GET['del_id'])){
		$_SESSION['mess_order'] = ORDER_REMOVED;
		$supercmsObj->deleteOrderHistory($_GET['del_id']);
		header("location:".$ListUrl);
		exit;
	}



	/*******Get Payment History**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryPaymentHistory=$supercmsObj->getPaymentHistory($_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['mode']);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$supercmsObj->getPaymentHistory($_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['mode']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/



	require_once("includes/footer.php");
?>
