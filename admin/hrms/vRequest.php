<?php
	session_start();
	/**************************************************/
	$HideNavigation = 1;
	$ThisPageName = 'viewRequest.php';	
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();

	$RedirectUrl = "viewRequest.php?curP=".$_GET['curP'];
	$ModuleName = "Request";	

		
	if(isset($_GET['view']) && $_GET['view'] >0){
		$arryRequest = $objCommon->getRequest($_GET['view']);
	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
