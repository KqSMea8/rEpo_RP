<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="viewSalary.php?curP=".$_GET['curP'];
	$EditUrl = "editSalary.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
	$ModuleName = "Salary Detail";	


	 
	$BankDivHtml=$TotalLabel=$GlobalPayCycle=$PayRate='';

	if($_SESSION['AdminType'] != "admin") {
		$_GET['emp'] = $_SESSION['AdminID'];	
		$arrySalary = $objPayroll->getSalary('',$_GET['emp']);

		/************************/
	        $arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');	
		if(empty($arryEmployee[0]['EmpID'])){
			$ErrorMsg = EMP_NOT_EXIST;
		}else if(empty($arryEmployee[0]['ExistingEmployee'])){
			$ErrorMsg = NOT_EXIST_EMPLOYEE;
		}
		/************************/

		if(empty($ErrorMsg)){

			if(!empty($arrySalary[0]['EmpID'])){
				$_GET['emp'] = $arrySalary[0]['EmpID'];
				$catEmp = $arrySalary[0]['catEmp'];
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
				$ErrorMsg = SALARY_NOT_EXIST_EMP;
			}

		}
	}else{
		echo INVALID_REQUEST;
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

