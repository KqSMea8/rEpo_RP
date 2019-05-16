<?php 
	include_once("includes/header.php");
	require_once("../classes/help.class.php");
	$objHelp = new help();

	$ModuleName = "Help Category";	
	(empty($_GET['sc']))?($_GET['sc']=''):(""); 


	$arryHelpCategory=$objHelp->ListHelpCategory($_GET);
	$num=$objHelp->numRows();

	$pagerLink=$objPager->getPager($arryHelpCategory,$RecordsPerPage,$_GET['curP']);
	(count($arryHelpCategory)>0)?($arryHelpCategory=$objPager->getPageRecords()):("");

	require_once("includes/footer.php"); 	 
?>


