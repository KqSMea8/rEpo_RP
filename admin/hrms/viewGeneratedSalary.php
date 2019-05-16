<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$ModuleName = "Salary Detail";	

	/****************************/

	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);
	$arryYearMonth = explode("-",$arryTime[0]);
	if(empty($_GET['y'])) $_GET['y']=$arryYearMonth[0];
	//if(empty($_GET['m'])) $_GET['m']=$arryYearMonth[1];

	$ShowList = '';
	/****************************/



	$RedirectUrl ="viewGeneratedSalary.php?curP=".$_GET['curP'];
	$RedirectUrl .= (!empty($_GET['Department']))?("&Department=".$_GET['Department']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");

	$UrlSuffix = '&emp='.$_GET['emp'].'&Department='.$_GET['Department'].'&y='.$_GET['y'].'&m='.$_GET['m'];
	$UrlSuffixGen = '&emp='.$_GET['emp'].'&Department='.$_GET['Department'].'&y='.$_GET['y'];


	if($_POST){
		if(sizeof($_POST['payID']>0)){
			$att = implode(",",$_POST['payID']);
			//echo $att;exit;
			if(!empty($_POST['PaymentStatus'])){
				$_SESSION['mess_gen_salary'] = SALARY_PAYMENT_STATUS;
				$objPayroll->changePayStatusMultiple($att);
			}else if(!empty($_POST['Delete'])){
				$_SESSION['mess_gen_salary'] = SALARY_REMOVED;
				$objPayroll->deletePaySalary($att);
			}

			header("location:".$RedirectUrl);
			exit;
		}
	}






	if(!empty($_GET['y']) && !empty($_GET['m'])){
		$arrySalary=$objPayroll->ListPaySalary($_GET['Department'],$_GET['emp'],$_GET['y'],$_GET['m'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$num = sizeof($arrySalary);
		$ShowList = 1;

		if(!empty($_GET['emp']) && !empty($arrySalary[0]['depID'])) $_GET['Department']=$arrySalary[0]['depID'];

		$pagerLink=$objPager->getPager($arrySalary,$RecordsPerPage,$_GET['curP']);
		(count($arrySalary)>0)?($arrySalary=$objPager->getPageRecords()):("");

	}

	$arryEmployee = $objEmployee->GetEmployeeBrief('');


	require_once("../includes/footer.php");
?>
