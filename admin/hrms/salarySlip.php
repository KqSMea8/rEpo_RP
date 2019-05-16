<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewGeneratedSalary.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/leave.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();
	$objLeave=new leave();
	
	$ModuleName = "Salary";	

	CleanGet();


	if($_SESSION['AdminType'] != "admin") {
		$EmpID = $_SESSION['AdminID'];
	}


	$TotalLabel=$OtherShown=$Mand=$DeductFlag='';


	if(isset($_GET['view']) && $_GET['view'] >0){
		$arrySalary = $objPayroll->getPaySalary($_GET['view'],'','','');
		if($arrySalary[0]['EmpID']>0){
			$_GET['y'] = $arrySalary[0]['Year'];
			$_GET['m'] = $arrySalary[0]['Month'];
			$catEmp = $arrySalary[0]['catEmp'];
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
			$PageHeading = 'Salary Slip of '.stripslashes($arrySalary[0]['UserName']).' for month: '.date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
		}else{
			$ErrorMSG = INVALID_REQUEST;
		}
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}

	if(empty($catEmp)) $catEmp='0';

	$arryPayCategory=$objPayroll->getPayCategory('','');
	require_once("../includes/footer.php"); 	 
?>

