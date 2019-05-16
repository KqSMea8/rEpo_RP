<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewGeneratedSalary.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	if(!empty($_GET['emp'])){
		$arryEmployeeDt = $objEmployee->GetEmployee($_GET['emp'],'');

		$arryLoan=$objPayroll->getActiveLoan($_GET['emp'],$_GET['y'],$_GET['m']);
		$num = sizeof($arryLoan);
	}

	require_once("../includes/footer.php");
?>