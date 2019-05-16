<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();



	/************************/	
	$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
	if(empty($arryEmployee[0]['EmpID'])){
		$ErrorMSG = EMP_NOT_EXIST;
	}else if(empty($arryEmployee[0]['ExistingEmployee'])){
		$ErrorMSG = NOT_EXIST_EMPLOYEE;
	}else{
		$ModuleName = "Declaration";	
 		$_GET['EmpID'] = $_SESSION['AdminID'];
		$arryDeclaration=$objPayroll->ListDeclaration($_GET);
		$num = sizeof($arryDeclaration);

		/*$pagerLink=$objPager->getPager($arryDeclaration,$RecordsPerPage,$_GET['curP']);
		(count($arryDeclaration)>0)?($arryDeclaration=$objPager->getPageRecords()):("");*/
	}

	require_once("../includes/footer.php");
?>
