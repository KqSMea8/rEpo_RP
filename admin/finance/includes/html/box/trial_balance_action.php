<?
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.class.php");
	$objReport = new report();
	$objBankAccount=new BankAccount();
	$objCommon = new common();
	$ModuleName = "Trial Balance Report";

	(empty($_GET['TransactionDate']))?($_GET['TransactionDate']=""):("");         
	#$TotalAccountBalance=0;
	$SpecificDate='';    
        /****************
	if($_GET['TransactionDate'] == "E"){
		$TempDate  = mktime(0, 0, 0, $_GET['m']-1 , "01", $_GET['y']);
		$FromDate = date("Y-m-d",$TempDate);
		$arryDate = explode("-",$FromDate);
		$ToDateTemp = date($arryDate['0'].'-'.$arryDate['1'].'-d');
		$FromDate = date("Y-m-t", strtotime($ToDateTemp) );	 

		$ToDateTemp = date($_GET['y'].'-'.$_GET['m'].'-d');
		$ToDate = date("Y-m-t", strtotime($ToDateTemp) );
	}else if($_GET['TransactionDate'] == "A"){		             
		$SpecificDate =1;
		if(!empty($FromDate)){
			$FromDate = $FromDate;
			$ToDate = $ToDate;
		}else{
			$FromDate = date('Y-m-01');
			$ToDate = date('Y-m-d');
		}
	}else{//Monthly
		$_GET['TransactionDate'] = "B";

		if(empty($_GET['m'])){
			$_GET['m'] = date('m');                          	
		}
		if(empty($_GET['y'])){
			$_GET['y'] = date('Y');                          	
		}
		$FromDate = $_GET['y'].'-'.$_GET['m'].'-01';
		$ToDateTemp = date($_GET['y'].'-'.$_GET['m'].'-d');
		$ToDate = date("Y-m-t", strtotime($ToDateTemp) );	
	}

        ****************/
	if(empty($_GET['m'])){
		$_GET['m'] = date('m');                          	
	}
	if(empty($_GET['y'])){
		$_GET['y'] = date('Y');                          	
	}
	$FromDate = $_GET['y'].'-'.$_GET['m'].'-01';
	/*$ToDateTemp = date($_GET['y'].'-'.$_GET['m'].'-d');
	$ToDate = date("Y-m-t", strtotime($ToDateTemp) );   */

	$numberDays = cal_days_in_month(CAL_GREGORIAN, $_GET['m'], $_GET['y']);
	 $ToDate = $_GET['y'].'-'.$_GET['m'].'-'.$numberDays;

	/****************/ 
	if(empty($_GET['TrType'])){
		$_GET['TrType'] = 'E';                          	
	}
	$Config['TransactionType'] =  $_GET['TrType'];
 	 
         $_SESSION['DateFormat'] =  $Config['DateFormat'];
         $_SESSION['Currency'] = $Config['Currency'];
         $DownloadUrl = "pdfTrialB.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate."";
         $EmailUrl = "email_pl_report.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate."";
         $ExportUrl = "export_TrialBalance.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate."&export=1"; 
         
         /********************************************************************************/
         
         $arr=array();
         $arr["Status"]='Yes';
         $arryAccountType=$objBankAccount->getAccountType($arr);          
         $num=$objBankAccount->numRows();   
	/*************************/


	/*************************/
 	$RetainedEarning = $objCommon->getSettingVariable('RetainedEarning');
	$FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
	$FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');

	$FromYear = date("Y",strtotime($FromDate));
	$ToYear = date("Y",strtotime($ToDate));

	$CurrentPeriodAR = $objReport->getCurrentPeriodDate('AR');
	$CurrentPeriodAP = $objReport->getCurrentPeriodDate('AP');
	$CurrentPeriodGL = $objReport->getCurrentPeriodDate('GL');
	$CurrentPeriodINV = $objReport->getCurrentPeriodDate('INV');
	if($CurrentPeriodAR==$CurrentPeriodAP && $CurrentPeriodGL==$CurrentPeriodINV && $CurrentPeriodAR==$CurrentPeriodINV){
		 $CurrentPeriod = $CurrentPeriodAR; //anyone
	}else{		
		
		$CurrentPeriod = $FromYear.'-01-01';
	}

	$CurrentPYear = date("Y",strtotime($CurrentPeriod));
	
	if($FromYear<$CurrentPYear){
		$CurrentPeriod = $FromYear.'-01-01';
	}



	//$ReFromDate = $FromDate;
	$ReFromDate = $FromYear.'-01-01';
	$CreditAmtRE=0;
 	if($Config['TransactionType']!='A' && $RetainedEarning>0 && $CurrentPeriod!=''){
	 
		$arryReAccount = $objBankAccount->getBankAccountById($RetainedEarning);		

		$PnLAmount_CurrentRE = $objBankAccount->getDebitCreditForPNLAmount($ReFromDate,$ToDate);
		
		$PnLAmount_RE = $objBankAccount->getDebitCreditForPNLAmount('',$ReFromDate); //Last Year's Pnl Amount
 
		/************************/		 
		$Config['CreditMinusDebit'] = 1;
		$ReNettBalance=0; $ReBeginningBalance=0;
		$ReBeginningBalance=$objBankAccount->getBeginningBalance($RetainedEarning,$ReFromDate);//Last Year's Beginning Balance for RE
		$ReNettBalance = round($ReBeginningBalance,2) + $PnLAmount_RE;			
		 
		  
		//$BeginningBalance=$objBankAccount->getBeginningBalance($RetainedEarning,$FromDate);
		$accountdataRE = $objBankAccount->getTotalDebitCreditAmount($RetainedEarning,'',$ReFromDate,$ToDate);
 		$CurrentReNettBalance = round(($accountdataRE[0]['CrAmnt']-$accountdataRE[0]['DbAmnt']),2);

		/*$NettBalanceRE = round(($accountdataRE[0]['CrAmnt']-$accountdataRE[0]['DbAmnt']),2) + $PnLAmount_CurrentRE  ;// + $BeginningBalance55-  $NettBalance;
		#$TotalAccountBalance+=$NettBalanceRE;
		if($NettBalanceRE<0){
			$NettBalanceREVal = str_replace("-","",$NettBalanceRE);
			//$NettBalanceREVal = number_format($NettBalanceREVal, 2);
			$NettBalanceREVal = "(".number_format($NettBalanceREVal, 2).")";
		}else{
			$NettBalanceREVal = number_format($NettBalanceRE, 2);
		}*/

		//if($_GET['pk']==1){ $NettBalanceREVal .= "#".$NettBalanceRE."#"; }

		 /*$ReRowContent = ' <tr align="left"> 
			<td height="20"> '.$AccPrefix3."CURRENT YEAR ".strtoupper($values['AccountName']).'</td>
			 <td align="right"  > 0.00</td>				 
			<td align="right">'.$NettBalanceREVal.'</td> 
			<td></td>
			</tr>';*/

 		$OriginalReBalance = $ReNettBalance + $CurrentReNettBalance55;

		if($OriginalReBalance<0){
			$NettBalanceVal = str_replace("-","",$OriginalReBalance);
			$NettBalanceREDis = "(".number_format($NettBalanceVal, 2).")";	 	
		}else{
			$NettBalanceREDis = number_format($OriginalReBalance, 2);
		}
		
		/************************/

 
		$arrayReTransaction=$objBankAccount->GetDebitCreditTrail($RetainedEarning, $arryReAccount[0]['RangeFrom'] ,$FromDate,$ToDate); 
		$CreditAmtRE = $arrayReTransaction['CreditAmtVal'];

		 
	}  
 
	#if($_GET['pk']==1){ echo $PnLAmount_CurrentRE.'#'.$PnLAmount_RE ;  echo '<br>'.$ReFromDate; }
	/*************************/







 




 
?>
