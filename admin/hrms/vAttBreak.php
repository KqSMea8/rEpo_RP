<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objTime=new time();
	$objEmployee=new employee();

	

	if(!empty($_GET['att'])){
		$arryBreak=$objTime->getAttPunching($_GET['att'],'','');
		$num=sizeof($arryBreak);

		$arryAttendence=$objTime->getAttendence('',$_GET['att'], '', '', '', '');
	}

	if(!empty($_GET['emp'])){
		$arryEmployee = $objEmployee->GetEmployeeBrief($_GET['emp']);
	}


	require_once("../includes/footer.php");
?>

