<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'mySalary.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();

	CleanGet();

	$ModuleName = "Salary Detail";	
	$ShowList='';
	if(!empty($_GET['y']) && !empty($_GET['m'])){
		$arrySalary=$objPayroll->ListPaySalary('',$_SESSION['AdminID'],$_GET['y'],$_GET['m'],'','','');
		$num = sizeof($arrySalary);
		if($num == 1){
			header("location: salarySlip.php?view=".$arrySalary[0]['payID']);
			exit;
		}

		$ShowList = 1;
	}

	require_once("../includes/footer.php");
?>
