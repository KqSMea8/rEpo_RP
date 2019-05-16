<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();
	$objEmployee=new employee();

	/************************/	
	$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
	if(empty($arryEmployee[0]['EmpID'])){
		$ErrorMSG = EMP_NOT_EXIST;
	}else if(empty($arryEmployee[0]['ExistingEmployee'])){
		$ErrorMSG = NOT_EXIST_EMPLOYEE;
	}else{
		$_GET['ApplyAll'] = '1';
		$_GET['Status'] = '1';
		$arryBenefit=$objCommon->ListBenefit($_GET);

		$num=$objCommon->numRows();

		$pagerLink=$objPager->getPager($arryBenefit,$RecordsPerPage,$_GET['curP']);
		(count($arryBenefit)>0)?($arryBenefit=$objPager->getPageRecords()):("");
	}

	require_once("../includes/footer.php");
?>

