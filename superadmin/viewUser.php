<?php 
	include_once("includes/header.php");
	include_once("../classes/Suser.Class.php");

	$ModuleName = "User";
	$objUser=new Suser();

	/*******Get User Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryUser=$objUser->UserList($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objUser->UserList($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/
 
	require_once("includes/footer.php"); 	
?>
