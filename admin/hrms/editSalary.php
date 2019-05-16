<?php
	/**************************************************/
	$ThisPageName = 'viewSalary.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$objTime=new time();
	$objCommon=new common();
	$RedirectUrl ="viewSalary.php?curP=".$_GET['curP'];
	$ModuleName = "Salary Detail";	
	$PayMethod = $arryCurrentLocation[0]['PayMethod'];
	$GlobalPayCycle=$WeekEndArry=$HideInSalaryForm=$HideTableRow=$monthlytrHide='';
	$BankDivHtml=$TotalLabel='';
	if(!empty($_GET['del_id'])){
		$_SESSION['mess_salary'] = SALARY_REMOVED;
		$objPayroll->deleteSalary($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		CleanPost(); 
		/*******************/
		if($PayMethod=='H'){
			$_POST['CTC'] = $_POST['YearlySalary'];
			if($_POST['PayRate']=='S'){
				$_POST['HourRate'] = $_POST['HourRateTemp'];
			}
		}else{
			unset($_POST['PayRate']);
		}

		
		/*******************/
		if (!empty($_POST['salaryID'])) {
			$objPayroll->updateSalary($_POST);
			$_SESSION['mess_salary'] = SALARY_UPDATED;
		} else {		
			$objPayroll->addSalary($_POST);
			$_SESSION['mess_salary'] = SALARY_ADDED;
		}
		header("location:".$RedirectUrl);
		exit;		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arrySalary = $objPayroll->getSalary($_GET['edit'],'');
		if(empty($arrySalary[0]['EmpID'])){
			$ErrorMsg = INVALID_REQUEST;
		}


		$PageHeading = 'Edit Salary for Employee: '.stripslashes($arrySalary[0]['UserName']);
		$_GET['emp'] = $arrySalary[0]['EmpID'];
		$arryEmployeeDetail = $objEmployee->GetEmployeeBrief($_GET['emp']);
		$salaryID = $arrySalary[0]['salaryID'];
		$catEmp = $arrySalary[0]['catEmp'];
		$PayRate = $arrySalary[0]['PayRate'];
		/********************/
		$SalaryData = $arrySalary[0]['SalaryData'];
		if(!empty($SalaryData)){
			$arrySalaryData = explode("#",$SalaryData);
			foreach($arrySalaryData as $values_sal){
				$arryIDSalary = explode(":",$values_sal);
				$arrySalaryDb[$arryIDSalary[0]] = $arryIDSalary[1];
			}
		}
		/********************/

	}else{
		 
		$arryEmployee = $objEmployee->GetEmployeeBrief('');

		if($_GET['emp'] >0){	
			$salaryID = $objPayroll->isSalaryExists($_GET['emp'],'');
			if($salaryID>0){
				$ErrorMsg = str_replace("[EDIT_ID]",$salaryID,SALARY_EXIST);
			}
			$arryEmployeeDetail = $objEmployee->GetEmployeeBrief($_GET['emp']);
			$catEmp = $arryEmployeeDetail[0]['catID'];
			
			/***********/		
			$PayCycle = ($arryCurrentLocation[0]['UseShift']==1)?($arryEmployeeDetail[0]['PayCycle']):($arryCurrentLocation[0]['PayCycle']);	
			$PayRate = ($PayCycle=="Monthly")?("S"):("H");			
			/***********/
			if(empty($arryEmployeeDetail[0]['EmpID'])){
				$ErrorMsg = EMP_NOT_EXIST;
			}else if(empty($arryEmployeeDetail[0]['ExistingEmployee'])){
				$ErrorMsg = NOT_EXISTING_EMPLOYEE;
			}

		}else{
			$ErrorMsg = INVALID_REQUEST;
		}

	}

	
	if(empty($catEmp)) $catEmp='0';

	$arryPayCategory=$objPayroll->getPayCategory('',1);
		
	if($PayMethod=='H'){
		$monthlytrHide = 'style="display:none"';
	}else{
		$hourlytrHide = 'style="display:none"';
	}

	/****************************/
	/****************************/
	if($_GET['emp'] >0){
		$EmpWorkingHour = $objTime->GetEmpWorkingHour($_GET['emp']);
		$arryBank = $objPayroll->GetBank('',$_GET['emp'],'1');
		if(!empty($arryBank[0]['AccountNumber'])){
			$BankDivHtml = 'Bank Name : '.stripslashes($arryBank[0]['BankName'])
					.'<br>Account Name : '.stripslashes($arryBank[0]['AccountName'])
					.'<br>Account Number : '.stripslashes($arryBank[0]['AccountNumber'])
					.'<br>Routing Number : '.stripslashes($arryBank[0]['IFSCCode']);
		}
	}	
	/****************************/
	/****************************/
	if($arryCurrentLocation[0]['UseShift']==1){ 
		if($arryEmployeeDetail[0]['shiftID']>0){
			$arryShiftDet = $objCommon->getShift($arryEmployeeDetail[0]['shiftID'],'');
			$GlobalPayCycle = $arryShiftDet[0]['PayCycle'];
			if(!empty($arryShiftDet[0]['PayrollStart'])){
				$PayrollStart = $arryShiftDet[0]['PayrollStart'];
				$WeekEndArry = GetWeekEndNum($arryShiftDet[0]['WeekStart'], $arryShiftDet[0]['WeekEnd']);
			}
		}
	}else{
		$GlobalPayCycle = $arryCurrentLocation[0]['PayCycle'];
		$PayrollStart = $arryCurrentLocation[0]['PayrollStart'];
		$WeekEndArry = GetWeekEndNum($arryCurrentLocation[0]['WeekStart'], $arryCurrentLocation[0]['WeekEnd']);
	}

	

	if(!empty($PayrollStart)){  // Yearly working days
		$PayrollStartArry = explode('-',$PayrollStart);
		$PayrollEnd = date('Y-m-d', mktime(0, 0, 0, $PayrollStartArry[1], $PayrollStartArry[2] , $PayrollStartArry[0]+1));	

		$current = $PayrollStart;
       	 	$count = 0; //weekendcount
		while($current != $PayrollEnd){
		    $DinNo = date("w",strtotime($current));
		    if(!in_array($DinNo, $WeekEndArry)){
			$count++;
		    }

		    $current = date('Y-m-d', strtotime($current.' +1 day'));
		};
		$NumWorkingDays = $count;
		
	}

 
	if($GlobalPayCycle!='Daily'){
		$NumWorkingDays = 7 - sizeof($WeekEndArry);
	}

	/****************************/
	/****************************/

	require_once("../includes/footer.php"); 
?>
