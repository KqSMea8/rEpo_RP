<?php
 	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();

	$arryBenefit=$objCommon->ListBenefit($_GET);
	//print_r($arryBenefit);exit;
	$num=$objCommon->numRows();

	$pagerLink=$objPager->getPager($arryBenefit,$RecordsPerPage,$_GET['curP']);
	(count($arryBenefit)>0)?($arryBenefit=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php");
?>
