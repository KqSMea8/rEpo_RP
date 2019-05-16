<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/candidate.class.php");

	$objCandidate = new candidate();

	$arryVacancy=$objCandidate->GetVacancy('','');
	$num=$objCandidate->numRows();

	/*
	$pagerLink=$objPager->getPager($arryVacancy,$RecordsPerPage,$_GET['curP']);
	(count($arryVacancy)>0)?($arryVacancy=$objPager->getPageRecords()):("");
	*/

	require_once("../includes/footer.php"); 	 
?>


