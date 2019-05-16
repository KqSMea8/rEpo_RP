<?php
	$HideNavigation = 1;	
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();

 

	$RedirectUrl = $ThisPageName."?curP=".$_GET['curP'];
	$ModuleName = "Advance";	
	$EmpID = '';
		
	if(isset($_GET['view']) && $_GET['view'] >0){

		$arryAdvance = $objPayroll->getAdvance($_GET['view'],$EmpID);
		if(empty($arryAdvance[0]['AdvID'])){
			$ErrorMSG = RECORD_NOT_EXIST;
		}else{
			$arryAdvanceReturn = $objPayroll->getAdvanceReturn($_GET['view']);
		}

	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
