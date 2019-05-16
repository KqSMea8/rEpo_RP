<?php
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalary.php';
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$objCommon=new common();

	$RedirectUrl ="viewSalary.php?curP=".$_GET['curP'];
	$EditUrl = "editSalary.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
	$ModuleName = "Salary Detail";	

	if($_GET['view'] >0 || $_GET['emp'] >0){
		$arrySalary = $objPayroll->getSalary($_GET['view'],$_GET['emp']);
		$PageHeading = 'Salary for Employee: '.stripslashes($arrySalary[0]['UserName']);

		$_GET['emp'] = $arrySalary[0]['EmpID'];
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
		$BankDivHtml=$TotalLabel='';
		/****************************/
		if($_GET['emp'] >0){
			$arryEmployeeDetail = $objEmployee->GetEmployeeBrief($_GET['emp']);

			$arryBank = $objPayroll->GetBank('',$_GET['emp'],'1');
			if(!empty($arryBank[0]['AccountNumber'])){
				$BankDivHtml = 'Bank Name : '.stripslashes($arryBank[0]['BankName'])
						.'<br>Account Name : '.stripslashes($arryBank[0]['AccountName'])
						.'<br>Account Number : '.stripslashes($arryBank[0]['AccountNumber'])
						.'<br>Routing Number : '.stripslashes($arryBank[0]['IFSCCode']);
			}

			
			if($arryCurrentLocation[0]['UseShift']==1){ 
				if($arryEmployeeDetail[0]['shiftID']>0){
					$arryShiftDet = $objCommon->getShift($arryEmployeeDetail[0]['shiftID'],'');
					$GlobalPayCycle = $arryShiftDet[0]['PayCycle'];					
				}
			}else{
				$GlobalPayCycle = $arryCurrentLocation[0]['PayCycle'];
				
			}




		}	
		/****************************/

	}else{
		header("location:".$RedirectUrl);
		exit;		
	}

	if(empty($catEmp)) $catEmp='0';
	$arryPayCategory=$objPayroll->getPayCategory('',1);
	$PayMethod = $arryCurrentLocation[0]['PayMethod'];
	if($PayMethod=='H'){
		$monthlytrHide = 'style="display:none"';
		$hourlytrHide = '';
	}else{
		$monthlytrHide = '';
		$hourlytrHide = 'style="display:none"';
	}
	require_once("../includes/footer.php"); 
?>
