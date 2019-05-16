<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();

	$ModuleName = "Expense Claim";	

	if($arryCurrentLocation[0]['ExpenseClaim']==1){
		$arryExpenseClaim=$objPayroll->getExpenseClaim('',$_SESSION["AdminID"]);
		$num = sizeof($arryExpenseClaim);

		$pagerLink=$objPager->getPager($arryExpenseClaim,$RecordsPerPage,$_GET['curP']);
		(count($arryExpenseClaim)>0)?($arryExpenseClaim=$objPager->getPageRecords()):("");
	}else{
		$ErrorMSG = FACILITY_NA;
	}

	require_once("../includes/footer.php");
?>
