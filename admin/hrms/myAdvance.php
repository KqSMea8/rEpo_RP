<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$ModuleName = "Advance";	


	/************************/	
	$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
	if(empty($arryEmployee[0]['EmpID'])){
		$ErrorMSG = EMP_NOT_EXIST;
	}else if(empty($arryEmployee[0]['ExistingEmployee'])){
		$ErrorMSG = NOT_EXIST_EMPLOYEE;
	}else{
		if($arryCurrentLocation[0]['Advance']==1){
			$arryAdvance=$objPayroll->getAdvance('',$_SESSION["AdminID"]);
			$num = sizeof($arryAdvance);

			$pagerLink=$objPager->getPager($arryAdvance,$RecordsPerPage,$_GET['curP']);
			(count($arryAdvance)>0)?($arryAdvance=$objPager->getPageRecords()):("");
		}else{
			$ErrorMSG = FACILITY_NA;
		}
	}

	require_once("../includes/footer.php");
?>
