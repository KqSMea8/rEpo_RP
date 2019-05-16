<?php
	if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewGerenalJournal.php'; $EditPage = 1;
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
		

	$JournalID = isset($_REQUEST['view'])?$_REQUEST['view']:"";	
	$ListUrl = "viewGerenalJournal.php?curP=".$_GET['curP'];
	$EditUrl = "editGerenalJournal.php?edit=".$JournalID."&curP=".$_GET['curP'];
	$ModuleName = "Journal";
	$MainModuleName = "General Journal";	
		 
                
		if(!empty($JournalID)){

			$arryJournal = $objJournal->getJournalById($JournalID);
			$arryJournalEntry = $objJournal->GetJournalEntry($JournalID);
			$NumLine = sizeof($arryJournalEntry);

			$arryJournalAttachment = $objJournal->GetJournalAttachment($JournalID);
			$num=$objJournal->numRows();
 
		
		}
                


   require_once("../includes/footer.php"); 
 
 
 ?>
