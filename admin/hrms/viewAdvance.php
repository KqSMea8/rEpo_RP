<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();

	$ModuleName = "Advance";	
	(empty($_GET['sc']))?($_GET['sc']=""):("");
	if($arryCurrentLocation[0]['Advance']==1){
		$arryAdvance=$objPayroll->ListAdvance($_GET);
		$num = sizeof($arryAdvance);
		$pagerLink=$objPager->getPager($arryAdvance,$RecordsPerPage,$_GET['curP']);
		(count($arryAdvance)>0)?($arryAdvance=$objPager->getPageRecords()):("");
	}else{
		$ErrorMSG = MODULE_INACTIVE_SETTING;
	}

	require_once("../includes/footer.php");
?>
