<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.account.class.php");

	$objJournal = new journal();

        $objBankAccount = new BankAccount();

	$ModuleName = "General Journal";

	$ViewUrl = "viewGerenalJournal.php";
	$AddUrl = "editGerenalJournal.php";
	$EditUrl = "editGerenalJournal.php?curP=".$_GET['curP'];
	$ViewUrl = "vGerenalJournal.php?curP=".$_GET['curP'];
	$RedirectURL = "viewGerenalJournal.php?curP=".$_GET['curP'];


	/*************************/
		$arryGerenalJournal=$objJournal->ListGerenalJournal($_GET);
		$num=$objJournal->numRows();

		$pagerLink=$objPager->getPager($arryGerenalJournal,$RecordsPerPage,$_GET['curP']);
		(count($arryGerenalJournal)>0)?($arryGerenalJournal=$objPager->getPageRecords()):("");

	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


