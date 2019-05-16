<?php
	include_once("../includes/header.php");
	require_once($Prefix . "classes/finance.journal.class.php"); 
	$objJournal = new journal(); 
	$ModuleName = "Recurring Journal"; 
	$EditUrl = "editRecurringJournal.php?curP=" . $_GET['curP'];
	$RedirectURL = "viewRecurringJournal.php?curP=" . $_GET['curP'];

	(empty($_GET['type']))?($_GET['type']=""):("");
	(empty($_GET['cancel_id']))?($_GET['cancel_id']=""):("");
	(empty($_GET['intv']))?($_GET['intv']=""):("");
	(empty($_GET['status']))?($_GET['status'] = "Active"):("");

	/*************************/
	if(!empty($_GET['cancel_id'])){
		$_SESSION['mess_rec_journal'] = JOURNAL_REC_CANCELLED;
		$objJournal->RemoveRecurringJournal($_GET['cancel_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	$arryInterval = array('biweekly','semi_monthly','monthly','yearly');
	if(!in_array($_GET['intv'],$arryInterval)){
		$_GET['intv']='';
	}  
	/*************************/
	$_GET['EntryInterval'] = $_GET['intv']; 
	$arryGerenalJournal = $objJournal->ListRecurringJournal($_GET); 
	$num=sizeof($arryGerenalJournal); 	 
	require_once("../includes/footer.php");
?>


