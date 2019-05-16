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
        
        if(!empty($_GET['del_id'])){
		$_SESSION['mess_reconcile'] = "Reconcilled month".REMOVED;
		$objReport->RemoveMonthReconciliation($_GET['del_id']);
		header("location:".$ListUrl.'?tr='.$_GET['tr']);
		exit;
	}
        
	

	     if(!empty($_POST)){
		 CleanPost();
		 if($_POST['TotalDebitByCheck'] > 0 || $_POST['TotalCreditByCheck'] > 0){
		 
		        if($_POST['Status'] == "Reconciled"){   
		            $_SESSION['mess_reconcile'] = RECONCIL_MONTH;
		        }else{
		            $_SESSION['mess_reconcile'] = NOT_RECONCIL_MONTH;
		        }
		        
		
		         //echo $_POST['Status'];exit;              
		        $ReconcileID = $objReport->AddMonthReconciliation($_POST);
		        
		        $objReport->AddMonthReconciliationTransaction($_POST,$ReconcileID);
		        
		        header("location:".$ListUrl);
		        exit;
		 }   
		       
	    }	
 

        //Get Bank Account
        
       
       
       

     
        if(!empty($_GET['Year']) && !empty($_GET['Month']) && !empty($_GET['AccountID'])){
                $year = $_GET['Year'];
                $month = $_GET['Month'];
		if($_GET['Type']=='D'){
                	$Type = "('Sales','Other Income')";
		}else if($_GET['Type']=='C'){
			$Type = "('Purchase','Other Expense','Spiff Expense','Adjustment')"; 
		}	
                $FromDate = $year."-".$month."-01";
                $ToDate = $year."-".$month."-31";
                $AccountID = $_GET['AccountID'];

		/*********Check for Not Reconciled **********/
		if($_GET['edit'] <=0 ){
			$_GET['RYear'] = $_GET['Year'];
		        $_GET['RMonth'] = $_GET['Month'];
			$_GET['RStatus'] = 'NotReconciled';
			$arryReMonths = $objReport->getReconciliationMonths($_GET);  
			$numNotReconciled = sizeof($arryReMonths);

			$_GET['RStatus'] = 'Reconciled';
			$arryReMonths2 = $objReport->getReconciliationMonths($_GET);  
			$numReconciled = sizeof($arryReMonths2);
		}
		/************************************************/

		


		if($numNotReconciled>0){
			$ErrorMsg = RECONCILB_EXIST_MONTH;
		}elseif($numReconciled>0){
			$ErrorMsg = RECONCIL_EXIST_MONTH;
		}else{
			$arryTransaction = $objReport->getTransactionForReconciliation($FromDate,$ToDate,$AccountID,$Type); 
			$num2=$objReport->numRows();

			$arrytotalDC = $objReport->getTotalForReconciliation($FromDate,$ToDate,$AccountID,$Type);
			$totalDifference = $arrytotalDC[0]['totalDebit']-$arrytotalDC[0]['totalCredit'];


			$BeginningBalance=$objBankAccount->getBeginningBalance($_GET['AccountID'],$FromDate);
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
		}
 
		
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
