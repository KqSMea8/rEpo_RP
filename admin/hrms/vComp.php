<?php
	session_start();
	/**************************************************/
	if($_SESSION['AdminType'] == "admin") { 
		$ThisPageName = 'viewComp.php';
		$EmpID = '';
	}else{
		$ThisPageName = 'myComp.php';
		$EmpID = $_SESSION["AdminID"];
	}
	/**************************************************/
	if(!empty($_GET['pop']))$HideNavigation = 1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	$objLeave=new leave();

	CleanGet();
	$RedirectUrl = $ThisPageName."?curP=".$_GET['curP'];
	$ModuleName = "Compensatory-Off";	

		
	if(isset($_GET['view']) && $_GET['view'] >0){
		$arryComp = $objLeave->getComp($_GET['view'],'');
		if(empty($arryComp[0]['CompID'])){
			$ErrorMSG = RECORD_NOT_EXIST;
		}

	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
