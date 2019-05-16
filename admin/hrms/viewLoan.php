<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();

	$ModuleName = "Loan";	
	(empty($_GET['sc']))?($_GET['sc']=""):("");
	if($arryCurrentLocation[0]['Loan']==1){
		$arryLoan=$objPayroll->ListLoan($_GET);
		$num = sizeof($arryLoan);

		$pagerLink=$objPager->getPager($arryLoan,$RecordsPerPage,$_GET['curP']);
		(count($arryLoan)>0)?($arryLoan=$objPager->getPageRecords()):("");
	}else{
		$ErrorMSG = MODULE_INACTIVE_SETTING;
	}

	require_once("../includes/footer.php");
?>
