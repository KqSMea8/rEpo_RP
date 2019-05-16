<?php 
	/**************************************************/
	$ThisPageName = 'viewAccount.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.class.php");             
        $objBankAccount=new BankAccount();
	$objCommon = new common();

	$_GET['accountID'] = (int)$_GET['accountID'];
             
	if($_GET['FromDate'] > 0){$FromDate = $_GET['FromDate'];}else{$FromDate = date('Y-m-01');}
	if($_GET['ToDate'] > 0){$ToDate = $_GET['ToDate'];}else{$ToDate = date('Y-m-d');}


	/*if($_GET['delp']>0 && $_GET['pk']=='22101980'){
		//echo $_GET['delp'];exit;
		$objBankAccount->RemovePaymentByID($_GET['delp']);
	}*/



	if($_GET['accountID']>0){
		$CurrencyArray[] = $Config["Currency"]; //Default Currency
		$arryAccount = $objBankAccount->getBankAccountById($_GET['accountID']);		
 
		if(!empty($_GET['Currency']) && $_GET['Currency']!= $Config['Currency']){
			$Config['ModuleCurrencySel'] = $_GET['Currency'];
		}


		/****BankFlag*******/		 
		if($arryAccount[0]['BankFlag']==1 && !empty($arryAccount[0]['BankCurrency'])){
			$BankCurrencyArray = explode(",",$arryAccount[0]['BankCurrency']);
			foreach($BankCurrencyArray as $bCurrency){
				$CurrencyArray[] = $bCurrency;	 //Bank Currency	
			}
		}		
		/******************/	
		if($arryAccount[0]['RangeFrom']=='2000' || $arryAccount[0]['RangeFrom']=='3000' || $arryAccount[0]['RangeFrom']=='4000' || $arryAccount[0]['RangeFrom']=='7000'){
			$Config['CreditMinusDebit'] = 1;
		}
		/*********ModuleCurrency**********/		
	 	$arryModuleCurrency = $objBankAccount->getModuleCurrency($_GET['accountID'],$_GET['key'],$FromDate,$ToDate);
		foreach($arryModuleCurrency as $ky=>$val){ 
			$CurrencyArray[] = $val['ModuleCurrency']; 
		}				
		/*************************/
 
		$arryBankAccountHistory=$objBankAccount->getBankAccountHistory($_GET['accountID'],$_GET['key'],$FromDate,$ToDate);

		$num=$objBankAccount->numRows();       
		

		/*$RecordsPerPage = 2000;
		$pagerLink=$objPager->getPager($arryBankAccountHistory,$RecordsPerPage,$_GET['curP']);
		(count($arryBankAccountHistory)>0)?($arryBankAccountHistory=$objPager->getPageRecords()):(""); 
		*/
		$ReFlag=0;
		/******************/
		$RetainedEarning = $objCommon->getSettingVariable('RetainedEarning');
		if($RetainedEarning==$_GET['accountID']){
			$ReFlag=1;
			$FromYear = date("Y",strtotime($FromDate));
			$ReFromDate = $FromYear.'-01-01';
			
			$arryDate = explode("-",$FromDate);
			list($year, $month, $day) = $arryDate;
			$TempDate  = mktime(0, 0, 0, $month , $day-1, $year);
			$ReToDate = date("Y-m-d",$TempDate);

			

			if($ReToDate>=$ReFromDate){				
				$accountdataRE = $objBankAccount->getTotalDebitCreditAmount($_GET['accountID'],'',$ReFromDate,$ReToDate);
				$BeginningBalance = round(($accountdataRE[0]['CrAmnt']-$accountdataRE[0]['DbAmnt']),2);
			}

			if($_GET['pk']==1){ echo $ReFromDate.'#'.$ReToDate." : ".$BeginningBalance; }
		}
		/******************/


		if($ReFlag==0){ 
			 $BeginningBalance=$objBankAccount->getBeginningBalance($_GET['accountID'],$FromDate);			 
		}
	}else{
		header("location:".$ThisPageName);
		exit;
	}
	//Get Bank Account List	
	$arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();		
 
	$CurrencyArray = array_unique($CurrencyArray);

	require_once("../includes/footer.php"); 	
?>


