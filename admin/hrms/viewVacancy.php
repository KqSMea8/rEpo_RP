<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/candidate.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Vacancy";
	$objCandidate=new candidate();

	/******Get Vacancy Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryVacancy=$objCandidate->ListVacancy($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCandidate->ListVacancy($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/

	require_once("../includes/footer.php"); 	 
?>


