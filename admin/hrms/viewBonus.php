<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objPayroll=new payroll();

	$ModuleName = "Bonus";	
	(empty($_GET['sc']))?($_GET['sc']=""):("");
	if($arryCurrentLocation[0]['Bonus']==1){
		$arryBonus=$objPayroll->ListBonus($_GET);
		$num = sizeof($arryBonus);

		$pagerLink=$objPager->getPager($arryBonus,$RecordsPerPage,$_GET['curP']);
		(count($arryBonus)>0)?($arryBonus=$objPager->getPageRecords()):("");
	}else{
		$ErrorMSG = MODULE_INACTIVE_SETTING;
	}

	require_once("../includes/footer.php");
?>
