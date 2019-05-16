<?php 	
	/**************************************************/
	$ThisPageName = 'employeeConnect.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objEmployee=new employee();
	$objphone=new phone();

	/*if($_GET["dv"]=='7'){
		$_GET["dv"] .= ',5,6';
	}*/
	ini_set('display_errors',1);
	phpinfo();
	$agents=array();
	$agents=$objphone->api('https://66.55.11.57/webservice/acl_users.php',array());
	print_r($agents);
	die('test');
	$PageHeading = 'CRM Employee';
	if(!empty($_POST))
	{	ini_set('display_errors',1);
		$savesdetail=	$objphone->connectCallServer($_POST['empdata'],1);
		print_r($savesdetail);
	}
	unset($arryInDepartment);
	$arryInDepartment = $objConfigure->GetSubDepartment($_GET["dv"]);
	$numInDept = sizeof($arryInDepartment);
	if($_GET["dv"]>0){
		$arryDepartmentRec = $objConfigure->GetDepartmentInfo($_GET["dv"]);
		//$PageHeading .= ' from '.$arryDepartmentRec[0]['Department'];
	}



	/*************************/
	if($numInDept>0){
		if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
		if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$num=$objEmployee->numRows();

		$RecordsPerPage=20;
		$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
		(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	}else{
		$ErrorMSG = NO_DEPARTMENT;
	}

	
	/*************************/
 
	
	require_once("../includes/footer.php"); 	
?>


