<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();

	$ModuleName = "Expense Claim";	

	if($arryCurrentLocation[0]['ExpenseClaim']==1){
		$arryExpenseClaim=$objPayroll->ListExpenseClaim($_GET);
		$num = sizeof($arryExpenseClaim);

		$pagerLink=$objPager->getPager($arryExpenseClaim,$RecordsPerPage,$_GET['curP']);
		(count($arryExpenseClaim)>0)?($arryExpenseClaim=$objPager->getPageRecords()):("");
	}else{
		$ErrorMSG = MODULE_INACTIVE_SETTING;
	}

	require_once("../includes/footer.php");
?>