<?php
	/**************************************************/
	$ThisPageName = 'viewDeduction.php'; $EditPage = 1;
	/*************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");	
	require_once($Prefix."classes/finance.account.class.php");
	$objTax=new tax();
	$objBankAccount = new BankAccount();
	$ModuleName = "Deduction";
	$RedirectURL = "viewDeduction.php";


	 if(!empty($_GET['del_id'])){
		$_SESSION['mess_deduction'] = DEDUCTION_REMOVED;
		$objTax->deleteDeduction($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_deduction'] = DEDUCTION_STATUS_CHANGED;
		$objTax->changeDeductionStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['dedID'])) {
			$objTax->updateDeduction($_POST);
			$dedID = $_POST['dedID'];
			$_SESSION['mess_deduction'] = DEDUCTION_UPDATED;
			
		} else {		
			$dedID = $objTax->addDeduction($_POST);
			$_SESSION['mess_deduction'] = DEDUCTION_ADDED;
		}				
	
		header("Location:".$RedirectURL);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryDeduction = $objTax->getDeduction($_GET['edit'],0);
		$PageHeading = 'Edit Deduction: '.stripslashes($arryDeduction[0]['Heading']);
	}


	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],8)==1){
		$arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();
	}
 
  	require_once("../includes/footer.php"); 

?>

