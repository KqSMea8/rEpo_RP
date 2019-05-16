<?php
	$EditPage=1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objLeave=new leave();
	$objEmployee=new employee();

	$arryLeave[0]['EmpID'] = $_SESSION['AdminID'];
	$EmpDisplay = 'style="display:none"';

	$RedirectUrl = "myLeave.php";
	$ModuleName = "Leave";	
	/************************/
	$arryEmployeeDetail = $objEmployee->GetEmployeeBrief($_SESSION['AdminID']);
	if(empty($arryEmployeeDetail[0]['EmpID'])){
		$ErrorMSG = EMP_NOT_EXIST;
	}else if(empty($arryEmployeeDetail[0]['ExistingEmployee'])){
		$ErrorMSG = NOT_EXIST_EMPLOYEE;
	}else{
		require_once("includes/html/box/leave_action.php");
	}
	/************************/
	

	require_once("../includes/footer.php"); 

?>
