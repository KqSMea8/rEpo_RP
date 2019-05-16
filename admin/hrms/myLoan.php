<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$ModuleName = "Loan";	

	$TotalLoanAmount='';
	/************************/	
	$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
	if(empty($arryEmployee[0]['EmpID'])){
		$ErrorMSG = EMP_NOT_EXIST;
	}else if(empty($arryEmployee[0]['ExistingEmployee'])){
		$ErrorMSG = NOT_EXIST_EMPLOYEE;
	}else{
		if($arryCurrentLocation[0]['Loan']==1){
			$arryLoan=$objPayroll->getLoan('',$_SESSION["AdminID"]);
			$num = sizeof($arryLoan);

			$pagerLink=$objPager->getPager($arryLoan,$RecordsPerPage,$_GET['curP']);
			(count($arryLoan)>0)?($arryLoan=$objPager->getPageRecords()):("");
		}else{
			$ErrorMSG = FACILITY_NA;
		}
	}
	require_once("../includes/footer.php");
?>
