<?php

include ('includes/function.php');
include_once("includes/header.php");
require_once($Prefix."classes/erp.superAdminCms.class.php");
$supercmsObj=new supercms();
$ListUrl    = "orderHistory.php?curP=".$_GET['curP'];
//echo $_SESSION['CrmRsID'];
/*if (is_object($supercmsObj)) { 
	$arryOrderHistory=$supercmsObj->getOrderHistoryByRsID($_SESSION['CrmRsID']);
	$num=$supercmsObj->numRows();
	$pagerLink=$objPager->getPager($arryOrderHistory,$RecordsPerPage,$_GET['curP']);
	(count($arryOrderHistory)>0)?($arryOrderHistory=$objPager->getPageRecords()):("");

}*/

if(!empty($_GET['active_id'])){
	$_SESSION['mess_payment_status'] = PAYMENT_STATUS_CHANGED;
	$supercmsObj->changePaymentStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}

require_once("includes/footer.php");
?>