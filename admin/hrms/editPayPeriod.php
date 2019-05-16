<?php
	/**************************************************/
	$ThisPageName = 'viewPayPeriod.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();
	
	$ModuleName = "Payroll Period";
	$RedirectUrl = "viewPayPeriod.php";

	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_period'] = PERIOD_STATUS_CHANGED;
		$objTax->changePayPeriodStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST){
		CleanPost(); 
		if(!empty($_POST['periodID'])) {
			$objTax->updatePayPeriod($_POST);
			$_SESSION['mess_period'] = PERIOD_UPDATED;
		}		
		header("location:".$RedirectUrl);
		exit;
	}
	
	$Status = 1;
	if($_GET['edit']>0){
		$arryPayPeriod = $objTax->getPayPeriod($_GET['edit'],'');
	}
 
	require_once("../includes/footer.php"); 
  ?>
