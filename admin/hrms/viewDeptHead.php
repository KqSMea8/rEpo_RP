<?php 
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objEmployee=new employee();

	
	if($_POST["depID"]){
		$objEmployee->UpdateDeptHead($_POST["depID"],$_POST["OldEmpID"],1);
		$_SESSION['mess_head'] = DEPT_UPDATED;
		header("Location:viewDeptHead.php");
		exit;
	}




	$arryDepartmentHead = $objConfigure->GetSubDepartmentInfo('');
	$num=sizeof($arryDepartmentHead);

	require_once("../includes/footer.php");
?>

