<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objEmployee=new employee();
	$objCommon=new common();

	if(sizeof($arryDepartment)==1){
		$_GET['d']=$arryDepartment[0]['depID'];	
	}


	$ModuleName = "Department";
	if($_GET['d']>0){
		$arryDept=$objCommon->getDepartment('',$_GET['d'],'');
		$num=$objCommon->numRows();

		$pagerLink=$objPager->getPager($arryDept,$RecordsPerPage,$_GET['curP']);
		(count($arryDept)>0)?($arryDept=$objPager->getPageRecords()):("");
	}
	require_once("../includes/footer.php");
?>


