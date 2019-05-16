<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
	include_once("includes/FieldArray.php");

	$objBankAccount=new BankAccount();
	 
	$ListUrl = "viewAccount.php?curP=".$_GET['curP'];
	$ModuleName = "Bank Account";
	(empty($_GET['AccountTypeID']))?($_GET['AccountTypeID']=""):("");
	(empty($_GET['status']))?($_GET['status']=""):("");		  
	(empty($_GET['id']))?($_GET['id']=""):("");	  

	$arryBankAccountType=$objBankAccount->getBankAccountByAccountType($_GET['AccountTypeID']);
	$num=$objBankAccount->numRows();   

	$arryValues = array();
	$arryValues['Status'] = 'Yes'; 
 

	$arryAccountType = $objBankAccount->getAccountType($arryValues);
	if($_GET['pop']==1){
		$Config['HideUnwanted'] = 'style="display:none"';
		$Config['pop'] = 1;
	}else{
		$Config['HideUnwanted'] = '';
		$Config['pop'] = '';
	}

	require_once("../includes/footer.php");  
?>
