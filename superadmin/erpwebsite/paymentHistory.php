<?php
include_once("includes/header.php");
require_once("../../classes/erp.superAdminCms.class.php");
include_once("includes/FieldArray.php");
$supercmsObj=new supercms();
 
if (is_object($supercmsObj)) {
	$ListUrl = "paymentHistory.php?curP=".$_GET['curP'];
	if(!empty($_GET['del_id'])){
		$_SESSION['mess_order'] = ORDER_REMOVED;
		$supercmsObj->deleteOrderHistory($_GET['del_id']);
		header("location:".$ListUrl);
		exit;
	}

	$arryPaymentHistory=$supercmsObj->getPaymentHistory($_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['mode']);
	$num=$supercmsObj->numRows();
	$pagerLink=$objPager->getPager($arryPaymentHistory,$RecordsPerPage,$_GET['curP']);
	(count($arryPaymentHistory)>0)?($arryPaymentHistory=$objPager->getPageRecords()):("");

}
require_once("includes/footer.php");
?>