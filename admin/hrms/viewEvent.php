<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$ModuleName = "Vacancy";
	$objEmployee=new employee();

	$arryEvent = $objEmployee->GetEventDetail();
	$num=sizeof($arryEvent);
  
	$pagerLink=$objPager->getPager($arryEvent,$RecordsPerPage,$_GET['curP']);
	(count($arryEvent)>0)?($arryEvent=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


