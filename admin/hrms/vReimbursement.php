<?php
    $HideNavigation = 1; 
	/**************************************************/ 
 
	include_once("../includes/header.php");
	require_once($Prefix."classes/reimbursement.class.php");
	$objReimbursement=new reimbursement();

	CleanGet();
	$RedirectURL = "vReimbursement.php?curP=".$_GET['curP'];
	$ModuleName = "Reimbursement";	

		
	if(isset($_GET['view']) && $_GET['view'] >0){
		$arryReimbursement = $objReimbursement->ListReimbursementView($_GET['view']);
		/************** Line Item ****************/
		$arryReimbursementItem = $objReimbursement->ListReimbursementItem($_GET['view']);
		$NumLine = sizeof($arryReimbursementItem);
		/***************************************/
		
		if(empty($arryReimbursement[0]['ReimID'])){
			$ErrorMSG = RECORD_NOT_EXIST;
		}
	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
