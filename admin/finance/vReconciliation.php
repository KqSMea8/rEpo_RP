<?php  
        $HideNavigation = 1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	$objCommon = new common();
	$objReport = new report();
	$objBankAccount= new BankAccount();

	(empty($_GET['tran']))?($_GET['tran']=""):("");
	(empty($_GET['tr']))?($_GET['tr']=""):("");
	(empty($_GET['Type']))?($_GET['Type']=""):("");
        (empty($_GET['Year']))?($_GET['Year']=""):("");
	(empty($_GET['Month']))?($_GET['Month']=""):("");
	(empty($_GET['RYear']))?($_GET['RYear']=""):("");
	(empty($_GET['RMonth']))?($_GET['RMonth']=""):("");
	(empty($_GET['AccountID']))?($_GET['AccountID']=""):("");
	(empty($_GET['RAccountID']))?($_GET['RAccountID']=""):("");
	$Type='';
	$arryTransactionUn =  array();
	
 


	if($_GET['view'] > 0){
	   	$arryReconcile = $objReport->getMonthReconcil($_GET['view']);
		if(empty($arryReconcile[0]['ReconcileID'])){
			$ErrorMSG = INVALID_REQUEST;
		}else{
			//print_r($arryReconcile);
			$AccountName = $objBankAccount->getBankAccountById($arryReconcile[0]['AccountID']);
			if($arryReconcile[0]['Status'] == "NotReconciled"){
				$Status = "Not Reconciled";
				$StatusCls = "red";
			}else{
				$Status = "Reconciled";
				$StatusCls = "green";
			}


			$FromDate = $arryReconcile[0]['Year']."-".$arryReconcile[0]['Month']."-01";
			$ToDate = $arryReconcile[0]['Year']."-".$arryReconcile[0]['Month']."-31";
			$AccountID = $arryReconcile[0]['AccountID'];
			$year = $arryReconcile[0]['Year'];


			$arryDate = explode("-", $FromDate);
			 

			/****************************/
			$StartDate = $FromDate;
			$EndDate = $ToDate;
			/***********************/
		
			/*$NumLastMonth = $objCommon->getSettingVariable('UN_REC_FROM');
			if(!empty($arryReconcile[0]["UnRecMonth"])) {
				$NumLastMonth = $arryReconcile[0]["UnRecMonth"];
			}*/
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
			$arryTransDeposit = $objReport->getReconciliationDeposit($StartDate,$ToDate,$AccountID,$Type); 
			$numDeposit = sizeof($arryTransDeposit);

			$arryTransCheck = $objReport->getReconciliationCheck($StartDate,$ToDate,$AccountID,$Type); //group checks 
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


			/*$arryTransaction = $objReport->getTransactionForReconciliation($FromDate,$ToDate,$AccountID,''); 
			$num2=$objReport->numRows();*/



		}
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}

	require_once("../includes/footer.php"); 
 
 ?>
