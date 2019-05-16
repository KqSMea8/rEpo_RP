<?
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.class.php");
	$objReport = new report();
        $objBankAccount=new BankAccount();
        $objCommon = new common();

	$ModuleName = "Balance Sheet";
	(empty($_GET['TransactionDate']))?($_GET['TransactionDate']=""):("");
	 (empty($_GET['InvStatus']))?($_GET['InvStatus']=""):("");        

         /********************************************************************/
          if($_GET['TransactionDate'] == "All")
                    {
			$Year = date('Y')-10;
			$FromDate = $Year.'-01-01';
			$ToDate = date('Y-m-d');
                        
                    }else if($_GET['TransactionDate'] == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($_GET['TransactionDate'] == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($_GET['TransactionDate'] == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($_GET['TransactionDate'] == "Last Three Month")
                    {
                        $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                     }else if($_GET['TransactionDate'] == "Specific Date"){
                        $SpecificDate =1;
                        if(!empty($_GET['FromDate'])){
                            
                            $FromDate = $_GET['FromDate'];
                            $ToDate = $_GET['ToDate'];
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                   }else{//Monthly
			 $_GET['TransactionDate'] = "Monthly";

			  if(empty($_GET['m'])){
				$_GET['m'] = date('m');                          	
			  }
			  if(empty($_GET['y'])){
				$_GET['y'] = date('Y');                          	
			  }
			   $FromDate = $_GET['y'].'-'.$_GET['m'].'-01';
                           /*$ToDateTemp = date($_GET['y'].'-'.$_GET['m'].'-d');
			   $ToDate = date("Y-m-t", strtotime($ToDateTemp) );*/
			$numberDays = cal_days_in_month(CAL_GREGORIAN, $_GET['m'], $_GET['y']);
			  $ToDate = $_GET['y'].'-'.$_GET['m'].'-'.$numberDays;	
		    }
                  
          $_SESSION['DateFormat'] =  $Config['DateFormat'];
          $_SESSION['Currency'] = $Config['Currency'];
         $DownloadUrl = "pdfBL.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate.""; 
         $EmailUrl = "email_bl_report.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate."";
         $ExportUrl = "export_BalanceSheet.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate."&export=1"; 
         /********************************************************************************/
         $arr=array();
         $arr['Status']='Yes';
	 $arr['BalanceSheet']='1';
         $arryAccountType=$objBankAccount->getAccountType($arr);
         $num=$objBankAccount->numRows();   
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

	if($RetainedEarning>0 && $CurrentPeriod!=''){
		/*//CURRENT YEAR RETAINED EARNINGS
		$arryPNL_CurrentRE=$objBankAccount->getDebitCreditForPNL($FromDate,$ToDate);
		$PnLAmount_CurrentRE = ($arryPNL_CurrentRE[0]["CrAmnt"] - $arryPNL_CurrentRE[0]["DbAmnt"]);

		//RETAINED EARNINGS
		$arryPNL_RE=$objBankAccount->getDebitCreditForPNL('',$CurrentPeriod);
		$PnLAmount_RE = ($arryPNL_RE[0]["CrAmnt"] - $arryPNL_RE[0]["DbAmnt"]);*/

		$PnLAmount_CurrentRE = $objBankAccount->getDebitCreditForPNLAmount($ReFromDate,$ToDate);
 
		$PnLAmount_RE = $objBankAccount->getDebitCreditForPNLAmount('',$ReFromDate);

	}  
 
if(!empty($_GET['pk'])){ echo $PnLAmount_CurrentRE.'#'.$PnLAmount_RE ;  echo '<br>'.$ReFromDate; }


?>
