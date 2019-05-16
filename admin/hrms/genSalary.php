<?php
	/**************************************************/
	$ThisPageName = 'viewGeneratedSalary.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$objLeave=new leave();
	$objTime=new time();


	$RedirectUrl ="viewGeneratedSalary.php?curP=".$_GET['curP'];
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");
	$RedirectUrl .= (!empty($_GET['Department']))?("&Department=".$_GET['Department']):("");

	if($_POST) { 
		$objPayroll->addBulkPaySalary($_POST);
		$_SESSION['mess_gen_salary'] = SALARY_GENERATED;
		header("location:".$RedirectUrl);
		exit;		
	}



	if(!empty($_GET['y']) && !empty($_GET['m'])){	
		$arryEmployee = $objPayroll->EmpToPaySalary($_GET['Department'],$_GET['catEmp'],$_GET['y'],$_GET['m']);
		$num = sizeof($arryEmployee);
		$ShowList = 1;

		
		$RecordsPerPage = 500;
		$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
		(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
		
		/*****************/
		$NumDayMonth = date('t', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
	}
	
	
	if(!empty($arryCurrentLocation[0]['WorkingHourStart']) && !empty($arryCurrentLocation[0]['WorkingHourEnd'])){
		   	$WorkingHour = $objTime->GetTimeDifference($arryCurrentLocation[0]['WorkingHourStart'],$arryCurrentLocation[0]['WorkingHourEnd'],1);
			//echo $WorkingHour;
	}

	$arryPayCategory=$objPayroll->getPayCategory('','');
	$arryEmpCategory = $objCommon->GetEmpCategory();			

	require_once("../includes/footer.php"); 
?>
<script>
	$('.left-main-nav').hide(); 
	document.getElementById("inner_mid").style.width="98%";
</script>