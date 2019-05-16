<?php
/**************************************************/
           $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
        
	$objCommon = new common();
        $objReport = new report();
	$objBankAccount= new BankAccount();
        
        $ModuleName = 'Bank Reconciliation';
        $ListUrl = "bankReconciliation.php";
	
        
	$_GET['edit'] = (int)$_GET['edit'];
	$_GET['del_id'] = (int)$_GET['del_id'];
	(empty($_GET['tran']))?($_GET['tran']=""):("");
	(empty($_GET['tr']))?($_GET['tr']=""):("");
	(empty($_GET['Type']))?($_GET['Type']=""):("");
        (empty($_GET['Year']))?($_GET['Year']=""):("");
	(empty($_GET['Month']))?($_GET['Month']=""):("");
	(empty($_GET['RYear']))?($_GET['RYear']=""):("");
	(empty($_GET['RMonth']))?($_GET['RMonth']=""):("");
	(empty($_GET['AccountID']))?($_GET['AccountID']=""):("");
	(empty($_GET['RAccountID']))?($_GET['RAccountID']=""):("");
	$EndingGLBalance=0;
	$HideUnRecMonth='';
	$HideUnRecMonth = 'style="display:none"'; //remove this
	$UN_REC_FROM = $objCommon->getSettingVariable('UN_REC_FROM');
	(empty($_GET['UnRecMonth']))?($_GET['UnRecMonth']=$UN_REC_FROM):("");
	

        if(!empty($_GET['del_id'])){
		$_SESSION['mess_reconcile'] = "Reconcilled month".REMOVED;
		$objReport->RemoveMonthReconciliation($_GET['del_id']);
		header("location:".$ListUrl.'?tr='.$_GET['tr']);
		exit;
	}
        
	

	     if(!empty($_POST)){
		 CleanPost();


		$EndingBankBalance = round($_POST["EndingBankBalance"],2);
		$EndingBalance = round($_POST["EndingBalance"],2);


		/*if($_POST["CompleteReconcile"]==1){
			if($EndingBalance!=$EndingBankBalance){
				 $_SESSION['mess_reconcile'] = "Ending Bank Balance must be equal to Gl Ending Balance which is ".$EndingBalance;
				header("location:".$ListUrl);
				exit;
				 
			}
		}*/
 		 
		 if(empty($_POST['NumRecords']) || $_POST['TotalDebitByCheck'] > 0 || $_POST['TotalCreditByCheck'] > 0){
		 
		        if($_POST['Status'] == "Reconciled"){   
		            $_SESSION['mess_reconcile'] = RECONCIL_MONTH;
		        }else{
		            $_SESSION['mess_reconcile'] = NOT_RECONCIL_MONTH;
		        }
		        
			$_POST['UnRecMonth'] = $_GET['UnRecMonth'];

		        // echo $_POST['UnRecMonth'];exit;              
		        $ReconcileID = $objReport->AddMonthReconciliation($_POST);
		        
		        $objReport->AddMonthReconciliationTransaction($_POST,$ReconcileID);
		        
		        header("location:".$ListUrl);
		        exit;
		 }   
		       
	    }	
 

        //Get Bank Account
        
      
       
       
	$num2=0;
     
        if(!empty($_GET['Year']) && !empty($_GET['Month']) && !empty($_GET['AccountID'])){
                $year = $_GET['Year'];
                $month = $_GET['Month'];
		$Type='';
		if($_GET['Type']=='D'){
                	$Type = "('Sales','Other Income')";
		}else if($_GET['Type']=='C'){
			$Type = "('Purchase','Other Expense','Spiff Expense','Adjustment')"; 
		}	
                $FromDate = $year."-".$month."-01";
                $ToDate = $year."-".$month."-31";
                $AccountID = $_GET['AccountID'];
		$numNotReconciled=$numReconciled='';
		/*********Check for Not Reconciled **********/
		if($_GET['edit'] <=0 ){
			$_GET['RAccountID'] = $_GET['AccountID'];
			$_GET['RYear'] = $_GET['Year'];
		        $_GET['RMonth'] = $_GET['Month'];
			$_GET['RStatus'] = 'NotReconciled';
			$arryReMonths = $objReport->getReconciliationMonths($_GET);  
			$numNotReconciled = sizeof($arryReMonths);

			$_GET['RStatus'] = 'Reconciled';
			$arryReMonths2 = $objReport->getReconciliationMonths($_GET);  
			$numReconciled = sizeof($arryReMonths2);
			$_GET['RAccountID']='';
		}else{

			$arryUnRecMonth = $objReport->getUnRecMonth($_GET['edit']);
			if(!empty($arryUnRecMonth[0]["UnRecMonth"])) {
				$_GET['UnRecMonth'] = $arryUnRecMonth[0]["UnRecMonth"];
			}
			$HideUnRecMonth = 'style="display:none"';
		}
		/************************************************/

		
		$arryDate = explode("-", $FromDate);
		 
	 	if($numNotReconciled>0){
			$ErrorMsg = RECONCILB_EXIST_MONTH;
		}elseif($numReconciled>0){
			$ErrorMsg = RECONCIL_EXIST_MONTH;
		}else{
			/****************************/
			$StartDate = $FromDate;
			$EndDate = $ToDate;
		 
			/***********************/
 
 
			
			/***********************/
			//$NumLastMonth = $_GET['UnRecMonth'];

			if(empty($NumLastMonth)){
				$NumLastMonth = $objReport->GetNumLastMonth($AccountID,$StartDate);
			}

			for($i=1;$i<=$NumLastMonth;$i++){
				$FromDatePrev  = date("Y-m-01", mktime(0, 0, 0, $arryDate[1]-$i , $arryDate[2], $arryDate[0]));		 
				$PrevYear = date("Y",strtotime($FromDatePrev));
				$PrevMonth = date("m",strtotime($FromDatePrev));

 
				//if($PrevYear == $year){ // year should be same
					$ReconcileIDPrev = $objReport->isReconciledMonth($PrevYear,$PrevMonth,$AccountID);
					if($ReconcileIDPrev > 0){
						$StartDate = $FromDatePrev;
						$arryReconcileIDPrev[] = $ReconcileIDPrev;
					}
				//}
			}
 
			if(!empty($arryReconcileIDPrev[0])){
				$Config['LastMonthReconcileID'] = implode(",", $arryReconcileIDPrev);
			}
			/***********************/

			$objReport->SetGroupConcatLen();//defined in dbclass

			$arryTransDeposit = $objReport->getReconciliationDeposit($StartDate,$EndDate,$AccountID,$Type); 
			$numDeposit = sizeof($arryTransDeposit);

			$arryTransCheck = $objReport->getReconciliationCheck($StartDate,$EndDate,$AccountID,$Type); //group checks 

			$numCheck = sizeof($arryTransCheck);
 
 
 
			if($numDeposit>0 && $numCheck>0){
				$arryTransaction = array_merge($arryTransDeposit, $arryTransCheck);
				$arryTransaction = sortMultiArrayByKey($arryTransaction, "PaymentDate", SORT_DESC);
			}else if($numDeposit>0){
				$arryTransaction = $arryTransDeposit;
			}else if($numCheck>0){
				$arryTransaction = $arryTransCheck;
			}else{		
				$arryTransaction = array();
			}			 

			$num2 = sizeof($arryTransaction);
			/****************************/


			/*$arryTransaction = $objReport->getTransactionForReconciliation($FromDate,$ToDate,$AccountID,$Type); 
			$num2=$objReport->numRows();*/


			$arrytotalDC = $objReport->getTotalForReconciliation($FromDate,$ToDate,$AccountID,$Type);
			$totalDifference = round(($arrytotalDC[0]['totalDebit']-$arrytotalDC[0]['totalCredit']),2);
			$BeginningBalance=$objBankAccount->getBeginningBalance($_GET['AccountID'],$FromDate);

			$EndingGLBalance = round(($BeginningBalance + $totalDifference),2);



		}
             
              
        }
	
	if($_GET['edit'] > 0){
	   	$arryMonthReconcil = $objReport->getMonthReconcil($_GET['edit']);
		
		
		
	}else{
		//Get Last Reconcilled Month
		$LastYear = $objReport->getLastReconcilledYear(); 
		if(!empty($LastYear)){
			$LastMonth = $objReport->getLastReconcilledMonth($LastYear); 
			$date = mktime(0, 0, 0, $LastMonth, 1, $LastYear);
			$NextMonthYear = date("Y-m", strtotime('+1 month', $date));
			$arryNext = explode("-", $NextMonthYear);
			$NextMonth = $arryNext[1];
			$NextYear = $arryNext[0];

			if($NextMonth=="01" && $NextYear!=$LastYear){
				$NextMonth = 12;
				
			}
		}
 
		$arryMonthReconcil = $objConfigure->GetDefaultArrayValue('f_reconcile');
		$arryMonthReconcil[0]['EndingBankBalance']=0;
	}


	
 

	/*$arryReconciliationMonths = $objReport->getReconciliationMonths($_GET);  
	$num=$objReport->numRows();
	$pagerLink=$objPager->getPager($arryReconciliationMonths,$RecordsPerPage,$_GET['curP']);
	(count($arryReconciliationMonths)>0)?($arryReconciliationMonths=$objPager->getPageRecords()):("");*/

	$Config['BankAccount']=1;
        $arryAccount = $objBankAccount->getBankAccountWithAccountType();
	unset($Config['BankAccount']);


	

	require_once("../includes/footer.php");  
 ?>
