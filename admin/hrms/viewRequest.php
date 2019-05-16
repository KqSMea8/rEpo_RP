<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();

	$ModuleName = "Request";	
	$ListUrl = "viewRequest.php?curP=".$_GET['curP'];

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_request'] = REQUEST_REMOVED;
		$objCommon->RemoveRequest($_GET['del_id']);
		header("location:".$ListUrl);
		exit;
	}

	$arryRequest=$objCommon->ListRequest($id,$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['FromDate'],$_GET['ToDate']);
	$num = sizeof($arryRequest);

	$pagerLink=$objPager->getPager($arryRequest,$RecordsPerPage,$_GET['curP']);
	(count($arryRequest)>0)?($arryRequest=$objPager->getPageRecords()):("");
		

	require_once("../includes/footer.php");
?>
