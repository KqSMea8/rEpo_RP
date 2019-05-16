<?php
	/**************************************************/
	$EditPage = 1; $_GET['edit']=999; $Tooltip = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	$objCommon = new common();
	$objBankAccount= new BankAccount();
	

	$ListUrl = "globalSetting.php";
	$arrayModule = array("AR", "AP", "GL", "INV");	 
	//$arrayModule = array("AR");	 
		 
	if(!empty($_POST)){
		CleanPost(); 
		$_SESSION['SettingIndex']=$_POST['SettingIndex'];
		$_SESSION['CurrencyIndex']=$_POST['CurrencyIndex'];
		/***********************/
		if(empty($_POST['SO_APPROVE'])) $_POST['SO_APPROVE']=0;
		if(empty($_POST['SO_APPROVE_REQUIRED'])) $_POST['SO_APPROVE_REQUIRED']=0;
		if(empty($_POST['SO_SOURCE'])) $_POST['SO_SOURCE']=0;
		if(empty($_POST['PO_APPROVE'])) $_POST['PO_APPROVE']=0;
		if(empty($_POST['OpeningStock'])) $_POST['OpeningStock']=0;
		if(empty($_POST['AutoPostToGlAr'])) $_POST['AutoPostToGlAr']=0;
		if(empty($_POST['AutoPostToGlAp'])) $_POST['AutoPostToGlAp']=0;
		if(empty($_POST['AutoPostToGlArCredit'])) $_POST['AutoPostToGlArCredit']=0;
		if(empty($_POST['AutoPostToGlApCredit'])) $_POST['AutoPostToGlApCredit']=0;
		if(empty($_POST['AutoFreightBilling'])) $_POST['AutoFreightBilling']=0;
		if(empty($_POST['TaxableBilling'])) $_POST['TaxableBilling']=0;
		if(empty($_POST['TaxableBillingAp'])) $_POST['TaxableBillingAp']=0;
		if(empty($_POST['CommissionAp'])) $_POST['CommissionAp']=0;
		if(empty($_POST['SpiffDisplay'])) $_POST['SpiffDisplay']=0;

		$date1 = $_POST['FiscalYearStartDate'];
		$date2 = $_POST['FiscalYearEndDate'];

		$ts1 = strtotime($date1);
		$ts2 = strtotime($date2);

		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);

		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);

		$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
		if($diff!=11){
			$_SESSION['mess_setting'] = "Please Set Valid Fiscal Year.";
			header("location:".$ListUrl);
			exit;
		}
		/***********************/
		
                                       
		$_SESSION['mess_setting'] = GLOBAL_UPDATED;
		$objCommon->updateSettingsFields($_POST);

		$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);
		$objCommon->updateCurrencySetting($_POST,$arrayModule,$arrySelCurrency); 
 
		header("location:".$ListUrl);
		exit;		
	}

	
	$clear = '<img src="'.$Config['Url'].'admin/images/clear.gif" border="0"  onMouseover="ddrivetip(\'<center>Clear</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';


	


	$Config['CmpDepartment']='4,7,8,6,3';  
	$Config['SortBy']='Department asc';
	if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){
		$Config['CmpDepartment'] .= ',12';
	}
	$arryDepartmentSet = $objConfigure->GetDepartmentList();

	 
	
	/*$Config['NormalAccount']=1;
	$arryAccount = $objBankAccount->getBankAccount('','Yes','','','');*/


	if(empty($_SESSION['SettingIndex'])){
		$_SESSION['SettingIndex']=0;
	}
 

	//echo CurrencyConvertor(1,'EUR','INR');exit;

	require_once("../includes/footer.php"); 
  
 ?>
