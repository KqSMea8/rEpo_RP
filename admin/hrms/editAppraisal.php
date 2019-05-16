<?php
	/**************************************************/
	$ThisPageName = 'viewAppraisal.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="viewAppraisal.php?curP=".$_GET['curP'];
	$ModuleName = "Appraisal";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_appraisal'] = APPRAISAL_REMOVED;
		$objPayroll->deleteAppraisal($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		/********************************/
		CleanPost();
		/********************************/
		$objPayroll->addAppraisal($_POST);
		$objPayroll->updateSalary($_POST);
		$_SESSION['mess_appraisal'] = APPRAISAL_ADDED;
		header("location:".$RedirectUrl);
		exit;		
	}
	
	/******************************/
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	if($_GET['emp'] >0){	
		/*
		$appraisalID = $objPayroll->isAppraisalExists($_GET['emp'],'');
		if($appraisalID>0){
			$ErrorMsg = str_replace("[EDIT_ID]",$appraisalID,APPRAISAL_EXIST);
		}*/
		$arryEmployeeDetail = $objEmployee->GetEmployeeBrief($_GET['emp']);
		$arrySalary = $objPayroll->getSalary('',$_GET['emp']);
		if(!empty($arrySalary[0]['CTC'])){
			$salaryID = $arrySalary[0]['salaryID'];
			$catEmp = $arrySalary[0]['catEmp'];
			$CTC  = $arrySalary[0]['CTC'];
			$Gross  = $arrySalary[0]['Gross'];
			$NetSalary  = $arrySalary[0]['NetSalary'];
			$_GET['emp'] = $arrySalary[0]['EmpID'];
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
			$SalaryNotExist = str_replace("[EMP_ID]",$_GET['emp'],SALARY_NOT_EXIST);
			$ErrorMsg = $SalaryNotExist;
		}
	}
	/******************************/
	if(empty($catEmp)) $catEmp='0';

	$arryPayCategory=$objPayroll->getPayCategory('',1);

	require_once("../includes/footer.php"); 
?>
