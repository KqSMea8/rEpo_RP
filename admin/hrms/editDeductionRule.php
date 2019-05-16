<?php
	/**************************************************/
	$ThisPageName = 'viewDeductionRule.php'; $EditPage = 1;
	/*************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();
	$ModuleName = "Deduction Rule";
	$RedirectURL = "viewDeductionRule.php";

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_rule'] = DED_RULE_REMOVED;
		$objTax->deleteDeductionRule($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_rule'] = DED_RULE_STATUS_CHANGED;
		$objTax->changeDeductionRuleStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if($_POST){
		CleanPost(); 
		if(!empty($_POST['ruleID'])) {
			$objTax->updateDeductionRule($_POST);
			$ruleID = $_POST['ruleID'];
			$_SESSION['mess_rule'] = DED_RULE_UPDATED;			
		}else{		
			$ruleID = $objTax->addDeductionRule($_POST);
			$_SESSION['mess_rule'] = DED_RULE_ADDED;
		}		
		header("Location:".$RedirectURL);
		exit;		
	}
	
	$Status = 1;
	if($_GET['edit']>0){
		$arryDeductionRule = $objTax->getDeductionRule($_GET['edit'],0);
		$PageHeading = 'Edit Deduction Rule: '.stripslashes($arryDeductionRule[0]['Heading']);
	}else{
		$arryDeductionRule[0]['Year'] = date("Y");
	}

	$arryFiling = $objTax->getFiling('','1');
	$arryDeduction = $objTax->getDeduction('',1);

  	require_once("../includes/footer.php");
?>

