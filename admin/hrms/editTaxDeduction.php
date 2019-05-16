<?php
	/**************************************************/
	$ThisPageName = 'viewTaxBracket.php'; $EditPage = 1;
	/*************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");	
	require_once($Prefix."classes/finance.account.class.php");
	$objTax=new tax();
	$objBankAccount = new BankAccount();
	$ModuleName = "Tax Deduction";
	$RedirectURL = "viewTaxDeduction.php";


	 if(!empty($_GET['del_id'])){
		$_SESSION['mess_deduction'] = DEDUCTION_REMOVED;
		$objTax->deleteTaxDeduction($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_deduction'] = DEDUCTION_STATUS_CHANGED;
		$objTax->changeTaxDeductionStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if($_POST) {
		CleanPost(); 
		
		if($_POST['state_id']>0){
			/***********************************/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************************/
			$_POST['country_id']= $arryCurrentLocation[0]['country_id'];
			$arryCountryName = $objRegion->GetCountryName($_POST['country_id']);
			$_POST['CountryName']= stripslashes($arryCountryName[0]["name"]);
			
		
			$arryStateName = $objRegion->getStateName($_POST['state_id']);
			$_POST['StateName']= stripslashes($arryStateName[0]["name"]);
			
			/***********************************/
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
		}




		if (!empty($_POST['dedID'])) {
			$objTax->updateTaxDeduction($_POST);
			$dedID = $_POST['dedID'];
			$_SESSION['mess_deduction'] = DEDUCTION_UPDATED;
			
		} else {		
			$dedID = $objTax->addTaxDeduction($_POST);
			$_SESSION['mess_deduction'] = DEDUCTION_ADDED;
		}				
	
		header("Location:".$RedirectURL);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryTaxDeduction = $objTax->getTaxDeduction($_GET['edit'],0);
		$PageHeading = 'Edit Tax Deduction: '.stripslashes($arryTaxDeduction[0]['Heading']);
	}


	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],8)==1){
		$arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();
	}



	/******************STATE NAME*****************/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	$arryState = $objRegion->getStateByCountry($arryCurrentLocation[0]['country_id']);
	/***********************************/



  	require_once("../includes/footer.php"); 

?>

