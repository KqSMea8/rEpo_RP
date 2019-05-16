<?php
	include_once("includes/header.php");
	require_once("../classes/notification.class.php");

	$objNotification=new notification();

	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryNotification=$objNotification->ListNotifictaion();
	$Config['GetNumRecords'] = 1;
	$arryCount=$objNotification->ListNotifictaion();
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);

	require_once("includes/footer.php");
?>




