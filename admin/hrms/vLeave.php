<?php
	$HideNavigation = 1;	

	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	$objLeave=new leave();

	if($_SESSION['AdminType'] == "admin") { 		
		$EmpID = '';
	}else{		
		$EmpID = $_SESSION["AdminID"];
	}

 

	if(isset($_GET['view']) && $_GET['view'] >0){
		$arryLeave = $objLeave->getLeave($_GET['view']);
		$PageHeading = 'Leave for Employee: '.stripslashes($arryLeave[0]['UserName']);
		if(empty($arryLeave[0]['LeaveID'])){
			$ErrorMSG = RECORD_NOT_EXIST;
		}else{
			if($arryLeave[0]['LeaveStart']>0) $LeaveStart = $arryLeave[0]['LeaveStart'];
			if($arryLeave[0]['LeaveEnd']>0) $LeaveEnd = $arryLeave[0]['LeaveEnd'];
		}

		$arryApproval = $objLeave->GetLeaveApproval($_GET['view']);

	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
