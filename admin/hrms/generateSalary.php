<?php
	/**************************************************/
	$ThisPageName = 'viewGeneratedSalary.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/leave.class.php");
	
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$objLeave=new leave();
	$objTime=new time();
	
	/****************************/
	$RedirectUrl ="viewGeneratedSalary.php?curP=".$_GET['curP'];
	$RedirectUrl .= (!empty($_GET['Department']))?("&Department=".$_GET['Department']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");

	$ModuleName = "Salary";	
	$ShowList = $TotalLabel=$payID=$Mand='';
	if(!empty($_GET['del_id'])){
		$_SESSION['mess_gen_salary'] = SALARY_REMOVED;
		$objPayroll->deletePaySalary($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_gen_salary'] = SALARY_PAYMENT_STATUS;
		$objPayroll->changePayStatus($_REQUEST['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}






	if($_POST) { 
		if (!empty($_POST['payID'])) {
			$objPayroll->updatePaySalary($_POST);
			$_SESSION['mess_gen_salary'] = SALARY_UPDATED;
			$RedirectUrl ="viewGeneratedSalary.php?emp=".$_POST['EmpID']."&y=".$_POST['Year']."&m=".$_POST['Month'];
		} else {		
			$objPayroll->addPaySalary($_POST);
			$_SESSION['mess_gen_salary'] = SALARY_GENERATED;
		}
		

		/********************************/
		if(!empty($_POST['CompIDs'])) {
			$objLeave->paidComp($_POST['CompIDs']);
		}
		if(!empty($_POST['BonusIDs'])) {
			$objPayroll->paidBonus($_POST['BonusIDs']);
		}
		if(!empty($_POST['AdvanceData'])) {
			$objPayroll->updateReturnAdvance($_POST['AdvanceData']);
		}
		if(!empty($_POST['LoanData'])) {
			$objPayroll->updateReturnLoan($_POST['LoanData']);
		}
		/********************************/

		header("location:".$RedirectUrl);
		exit;		
	}


	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arrySalary = $objPayroll->getPaySalary($_GET['edit'],'','','');
		
		if(empty($arrySalary[0]['payID'])){
			header("location:".$RedirectUrl);
			exit;		
		}else if($arrySalary[0]['Status']==1){
			header("location:".$RedirectUrl);
			exit;		
		}
		$_GET['emp'] = $arrySalary[0]['EmpID'];
		$_GET['y'] = $arrySalary[0]['Year'];
		$_GET['m'] = $arrySalary[0]['Month'];
		$catEmp = $arrySalary[0]['catEmp'];
		$ShowList = 1;
		/********************/
		$SalaryData = $arrySalary[0]['SalaryData'];
		if(!empty($SalaryData)){
			$arrySalaryData = explode("#",$SalaryData);
			foreach($arrySalaryData as $values_sal){
				$arryIDSalary = explode(":",$values_sal);
				$arrySalaryDb[$arryIDSalary[0]] = $arryIDSalary[1];
				if(empty($BasicSalary))$BasicSalary = round($arryIDSalary[1],2);
			}
		}
		/********************/
		$PageHeading = 'Edit Salary of '.stripslashes($arrySalary[0]['UserName']).' for month: '.date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
		
	}else{
		$arryEmployee = $objEmployee->GetEmployeeBrief('');

		if($_GET['emp'] >0 && !empty($_GET['y']) && !empty($_GET['m'])){	
			
			$payID = $objPayroll->isPaySalaryExists($_GET['emp'],$_GET['y'],$_GET['m']);
			$arrySalary = $objPayroll->getSalary('',$_GET['emp']);
	
			if(!$objPayroll->isSalaryExists($_GET['emp'],'')){
				$SalaryNotExist = str_replace("[EMP_ID]",$_GET['emp'],SALARY_NOT_EXIST);
				$ErrorMsg = $SalaryNotExist;
				unset($arrySalary);
			}else if($payID>0){
				$ErrorMsg = str_replace("[EDIT_ID]",$payID,SALARY_GENERATED_EXIST);
				unset($arrySalary);
			}else if($arryCurrentLocation[0]['PayMethod']=='H'){
				$ErrorMsg = SALARY_PAY_HOURLY;
				unset($arrySalary);
			/*}else if($arrySalary[0]['PayRate']!='S'){
				$ErrorMsg = SALARIED_NOT_EMP;
				unset($arrySalary);*/
			}else if(empty($arrySalary[0]['CTC'])){
				$SalaryNotExist = str_replace("[EMP_ID]",$_GET['emp'],SALARY_NOT_EXIST);
				$ErrorMsg = $SalaryNotExist;
				unset($arrySalary);
			}else{
				$ShowList = 1;
				
				$catEmp = $arrySalary[0]['catEmp'];
				/********************/
				$SalaryData = $arrySalary[0]['SalaryData'];
				if(!empty($SalaryData)){
					$arrySalaryData = explode("#",$SalaryData);
					foreach($arrySalaryData as $values_sal){
						$arryIDSalary = explode(":",$values_sal);
						$arrySalaryDb[$arryIDSalary[0]] = $arryIDSalary[1]/12;
						if(empty($BasicSalary))$BasicSalary = round($arryIDSalary[1]/12,2);
					}
				}
				/********************/
				 

			}
		}

	}

	if(empty($catEmp)) $catEmp='0';

//echo '<pre>'; print_r($arrySalaryDb[1]);exit;
	$CommOn='';

	if($_GET['emp'] >0){
		$arryEmp = $objEmployee->GetEmployeeBrief($_GET['emp']);
		$CommOn = $arryEmp[0]['CommOn'];
	}


	$NumDayMonth = date('t', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
	$FromDate = $_GET['y'].'-'.$_GET['m'].'-01';  
	$ToDate = $_GET['y'].'-'.$_GET['m'].'-'.$NumDayMonth;


	/***************************/
	if($arryCurrentLocation[0]['Advance']==1){ 
			$arryAdvance=$objPayroll->getActiveAdvance($_GET['emp'],$_GET['y'],$_GET['m']);
			$TotalAdvanceAmount=0;  $AdvanceData = '';
			if(sizeof($arryAdvance)>0){
				foreach($arryAdvance as $key=>$values){
					$AdvanceAmount = 0;
					if(!empty($values['Amount'])){
						$AdvanceAmount = $values['Amount'] / $values['ReturnPeriod'];
						$TotalAdvanceAmount += $AdvanceAmount;
						$AdvanceData .= $values['AdvID'].':'.round($AdvanceAmount,2).'#';
					}

				}
			}
	}
	/***************************/
	if($arryCurrentLocation[0]['Loan']==1){ 
			$arryLoan=$objPayroll->getActiveLoan($_GET['emp'],$_GET['y'],$_GET['m']);
			$TotalLoanAmount=0; $LoanData = '';
			if(sizeof($arryLoan)>0){
				foreach($arryLoan as $key=>$values){
					$LoanAmount = 0;
					if(!empty($values['Amount'])){
						$Rate = ($values['Amount'] * $values['Rate']) / 100;
						$LoanAmount = ($values['Amount'] + $Rate) / $values['ReturnPeriod'];
						$TotalLoanAmount += $LoanAmount;
						$LoanData .= $values['LoanID'].':'.round($LoanAmount,2).'#';
					}

				}
			}
	}

	/***************************/
	if($arryCurrentLocation[0]['Overtime']==1){ 
			$arryOvertime=$objTime->getTotalOvertime($_GET['emp'],$_GET['y'],$_GET['m']);
			$TotalOvertimeHour = $arryOvertime[0]['TotalHour'];
			$TotalHoursRate = $arryOvertime[0]['TotalHoursRate'];
	}
	/***************************/
	if($arryCurrentLocation[0]['Bonus']==1){ 
			$arryBonus = $objPayroll->getTotalBonus($_GET['emp'],$_GET['y'],$_GET['m']);
			$TotalBonus=0;
			if(sizeof($arryBonus)>0){
				foreach($arryBonus as $key=>$values){
					$TotalBonus += $values['Amount'];
					$BonusIDs .= $values['BonusID'].',';
				}
				$BonusIDs = rtrim($BonusIDs,",");
			}
	}
	/***************************/

	$EmpID = $_GET['emp']; $EmpDivision = ''; $SuppID=0;
	 if(!empty($arryEmp[0]['Division'])) $EmpDivision = $arryEmp[0]['Division'];

	if($CommOn==1){
		require_once("../includes/html/box/commission_cal_per.php");
	}else{
		require_once("../includes/html/box/commission_cal.php");
	}
	/***************************/


	if(!empty($arryCurrentLocation[0]['WorkingHourStart']) && !empty($arryCurrentLocation[0]['WorkingHourEnd'])){
		   	$WorkingHour = $objTime->GetTimeDifference($arryCurrentLocation[0]['WorkingHourStart'],$arryCurrentLocation[0]['WorkingHourEnd'],1);
			//echo $WorkingHour;
	}












	/********************
	$Month = '7';	$MaxLeavePerMonth = '2';
    $EntitleTotal = $MaxLeavePerMonth;
	$LeaveTakenMonth = '7';

	$TotalLeaveTaken;

	$LeaveDeduct = '0';
	
	if($LeaveTakenMonth>$EntitleTotal){
	  $LeaveDeduct =  $LeaveTakenMonth - $EntitleTotal;
	}
	echo 'Entitle Total: '.$EntitleTotal.'<br>Leave Taken: '.$LeaveTakenMonth.'<br>Leave To Deduct: '.$LeaveDeduct; exit;
	/********************/
	$arryPayCategory=$objPayroll->getPayCategory('','');
	require_once("../includes/footer.php"); 
?>
