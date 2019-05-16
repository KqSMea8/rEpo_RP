<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.account.class.php");
$objBankAccount=new BankAccount();


(empty($_GET['AccountTypeID']))?($_GET['AccountTypeID']=""):("");
(empty($_GET['status']))?($_GET['status']=""):("");

if($_GET['pop']==1){
	$Config['HideUnwanted'] = 'style="display:none"';
	$Config['pop'] = 1;
}else{
	$Config['HideUnwanted'] = '';
	$Config['pop'] = '';
}
$flag='';
/*************************/
$arryBankAccountType=$objBankAccount->getBankAccountByAccountType($_GET['AccountTypeID']);
$num=$objBankAccount->numRows();   
$arryValues = array();
$arryValues['Status'] = 'Yes'; 
$arryAccountType = $objBankAccount->getAccountType($arryValues);
/****************************/   
$fileName = "ChartOfAccounts";
$ExportFile=$fileName."_".date('d-m-Y').".xls";
include_once("includes/html/box/chart_account_data.php");

?>


