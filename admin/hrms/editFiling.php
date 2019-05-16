<?php
	/**************************************************/
	$ThisPageName = 'viewFiling.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();
	
	$ModuleName = "Filing Status";
	
	$RedirectUrl = "viewFiling.php";


	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_filing'] = FILING_STATUS_CHANGED;
		$objTax->changeFilingStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		CleanPost(); 
		if(!empty($_POST['filingID'])) {
			$objTax->updateFiling($_POST);
			$_SESSION['mess_filing'] = FILING_STATUS_UPDATED;
		}		
		header("location:".$RedirectUrl);
		exit;
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryFiling = $objTax->getFiling($_GET['edit'],'');
	}
 
	require_once("../includes/footer.php"); 
  ?>
