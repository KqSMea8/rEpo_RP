<?php 	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/user.class.php");
	$objUser=new user();
	$CmpID   = $_SESSION['CmpID'];

	(empty($_GET['mode']))?($_GET['mode']=""):("");
	$_GET['loginID'] = $_GET['view'];

	if($_GET['loginID']>0){	
		$arryLog=$objUser->GetUserLog($_GET);

		$arryUserPage=$objUser->GetUserLogPage($_GET);
		$num=$objUser->numRows();
		$RecordsPerPage = 100;
		$pagerLink=$objPager->getPager($arryUserPage,$RecordsPerPage,$_GET['curP']);
		(count($arryUserPage)>0)?($arryUserPage=$objPager->getPageRecords()):("");
	
	}else{
		$ErrorMsg = INVALID_REQUEST;
	}

	require_once("includes/footer.php"); 	 
?>


