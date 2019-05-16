<?php 
	/**************************************************/
	if($_GET['pop']==1)$HideNavigation = 1;
	$ThisPageName = 'viewRecurringJournal.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.journal.class.php");
	$objJournal = new journal();	 
	$ModuleName = "Recurring Journal";
	$RedirectURL = "viewRecurringJournal.php?curP=".$_GET['curP'];

	if (!empty($_POST)) {	 
		CleanPost();		
		if(!empty($_POST['JournalType'])) {
			$objJournal->UpdateJournalRecurring($_POST);
			$_SESSION['mess_rec_journal'] = JOURNAL_REC_UPDATED;	
			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';	
			exit;
		} 
	}		

	if(!empty($_GET['edit'])) {
		$arryJournal = $objJournal->getJournalById($_GET['edit']);
	}		

	require_once("../includes/footer.php"); 	 
?>


