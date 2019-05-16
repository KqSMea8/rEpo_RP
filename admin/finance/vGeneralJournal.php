<?php
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewGeneralJournal.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/function.class.php");

	$objJournal = new journal();
	$objCommon = new common();
	$objBankAccount = new BankAccount();
	$objFunction = new functions();
		

 
	$ListUrl = "viewGeneralJournal.php?curP=".$_GET['curP'];
	$EditUrl = "editGeneralJournal.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
	$ModuleName = "Journal";
	$MainModuleName = "General Journal";	
		 
                
	if(!empty($_GET['view'])){
		$JournalID = $_GET['view'];
		$arryJournal = $objJournal->getJournalById($JournalID);
		$arryJournalEntry = $objJournal->GetJournalEntry($JournalID);
		$NumLine = sizeof($arryJournalEntry);
		$arryJournalAttachment = $objJournal->GetJournalAttachment($JournalID);
		$num=$objJournal->numRows();	
	}

	
	if(empty($arryJournal[0]["JournalID"])) {
		header("Location:".$ListUrl);
		exit;
	}
                


   require_once("../includes/footer.php"); 
 
 
 ?>
