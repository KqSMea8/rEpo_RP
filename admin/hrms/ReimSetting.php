<?php
	/**************************************************/
	$EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/configure.class.php");

	$objBankAccount=new BankAccount();
	$objConfigure=new configure();

	$RedirectUrl = "ReimSetting.php";


	if($arryCurrentLocation[0]['ExpenseClaim']==1){	
		if($_POST) {
			CleanPost();
			$objConfigure->updateReimLocation($_POST);
			$_SESSION['mess_reim'] = REIM_UPDATED;
			header("location:".$RedirectUrl);
			exit;	
		}
	
		$arryBankAccount = $objBankAccount->getBankAccountWithAccountType();
		$arryReimSettingVal=$objConfigure->GetLocation($_SESSION['locationID'],'');
	}else{
		$ErrorMSG = MODULE_INACTIVE_SETTING;
	}
 
	require_once("../includes/footer.php"); 
  ?>
