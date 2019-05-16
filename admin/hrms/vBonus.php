<?php
	 $HideNavigation = 1;	
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();

	$RedirectUrl = $ThisPageName."?curP=".$_GET['curP'];
	$ModuleName = "Bonus";	
	$EmpID = '';
		
	if(isset($_GET['view']) && $_GET['view'] >0){

		$arryBonus = $objPayroll->getBonus($_GET['view'],$EmpID);
		if(empty($arryBonus[0]['BonusID'])){
			$ErrorMSG = RECORD_NOT_EXIST;
		}

	}else{
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
