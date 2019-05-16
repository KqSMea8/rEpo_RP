<?php 
	include_once("includes/header.php");
	require_once("../classes/admin.class.php");
	$ModuleName = "IP Address";
	$objConfig=new admin();

	$RedirectURL = "blockedIP.php?curP=".$_GET['curP'];

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_block'] = IP_REMOVED;
		$objConfig->RemoveBlockIP($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	$arryIP=$objConfig->GetBlockIP($_GET['key']);
	$num=$objConfig->numRows();

	/*$pagerLink=$objPager->getPager($arryIP,$RecordsPerPage,$_GET['curP']);
	(count($arryIP)>0)?($arryIP=$objPager->getPageRecords()):("");*/


	require_once("includes/footer.php"); 	 
?>


