<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");

        $objBankAccount=new BankAccount();			  
			  
	$ListUrl = "viewAccountType.php";
	$ModuleName = "Account Type";

	$arryAccountType=$objBankAccount->getAccountType($_GET);
	$num=$objBankAccount->numRows();       


	require_once("../includes/footer.php");
?>

