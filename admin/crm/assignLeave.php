<?php 
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; 
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/employee.class.php");


	$objEmployee=new employee();
	
	$ModuleName = "Employee";
	$RedirectURL = "viewOpportunity.php?module=".$_GET['module']."curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="personal";

	$EditUrl = "editEmployee.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vEmployee.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 


	if (!empty($_GET['view'])) {
		$arryEmployee = $objEmployee->GetEmployee($_GET['view'],'');
		$EmpID   = $_REQUEST['view'];	
		
		$arrySupervisor = $objEmployee->GetEmployeeBrief($arryEmployee[0]['Supervisor']);

		
	}else{
		header('location:'.$RedirectURL);
		exit;
	}


	require_once("../includes/footer.php"); 	 
?>


