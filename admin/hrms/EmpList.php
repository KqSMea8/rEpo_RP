<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();


	$PageHeading = 'Select Employee';

	unset($arryInDepartment);
	$arryInDepartment = $objConfigure->GetSubDepartment($_GET["dv"]);
	$numInDept = sizeof($arryInDepartment);
	if($_GET["dv"]>0){
		$arryDepartmentRec = $objConfigure->GetDepartmentInfo($_GET["dv"]);
		$PageHeading .= ' from '.$arryDepartmentRec[0]['Department'];
	}



	/*************************/
	if($numInDept>0){
		if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
		if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];
		$_GET["ExistingEmployee"]=1;
		$_GET["Status"]=1;
		/*******Get Employee Records**************/	
		$Config['RecordsPerPage'] = $RecordsPerPage;
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		/***********Count Records****************/	
		$Config['GetNumRecords'] = 1;
		$arryCount=$objEmployee->GetEmployeeList($_GET);
		$num=$arryCount[0]['NumCount'];	
		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
		/****************************************/
	}else{
		$ErrorMSG = NO_DEPARTMENT;
	}
	/*************************/
 
	
	require_once("../includes/footer.php"); 	
?>


