<?php
	/**************************************************/
	$ThisPageName = 'viewGeneratedSalary.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/leave.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$objLeave=new leave();

	$RedirectUrl ="viewGeneratedSalary.php?curP=".$_GET['curP'];
	$EditUrl = "generateSalary.php?edit=".$_GET['view']."&curP=".$_GET['curP'];

	$ModuleName = "Salary";	


	if(isset($_GET['view']) && $_GET['view'] >0){
		$arrySalary = $objPayroll->getPaySalary($_GET['view'],'','','');
		$_GET['y'] = $arrySalary[0]['Year'];
		$_GET['m'] = $arrySalary[0]['Month'];
		$ShowList = 1;
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
		$RedirectUrl ="viewGeneratedSalary.php?emp=".$_GET['emp']."&y=".$_GET['y']."&m=".$_GET['m'];
		$_GET['emp'] = $arrySalary[0]['EmpID'];
	}else{
		header("location:".$RedirectUrl);
		exit;		
	}


	$arryPayCategory=$objPayroll->getPayCategory('','');
	require_once("../includes/footer.php"); 
?>
