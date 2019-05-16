<?php 
	include_once("../includes/header.php");
	require_once($Prefix . "classes/event.class.php");
	$ModuleName = "Event";
	$objActivity = new activity();
        
      	$_GET['EntryType'] = 'recurring';

	$ModuleName = "Recurring Event";
              
	$ViewUrl = "viewRecurringActivity.php";
	$AddUrl = "editRecurringActivity.php";
	$EditUrl = "editRecurringActivity.php?curP=".$_GET['curP'];
	$ViewUrl = "vActivity.php?curP=".$_GET['curP'];

	$RedirectURL = "viewRecurringActivity.php?curP=".$_GET['curP'];

	/*************************/

	if(isset($_GET['cancel_id']) && $_GET['cancel_id'] && !empty($_GET['cancel_id'])){
		$_SESSION['mess_rec_act'] = EVENT_REC_CANCELLED;
		$objActivity->RemoveActivityRecurring($_GET['cancel_id']);
		header("Location:".$RedirectURL);
		exit;
	}
     
        
	     
	$arryActivity=$objActivity->GetRecurringActivity($_GET);
	$num=$objActivity->numRows();

	$pagerLink=$objPager->getPager($arryActivity,$RecordsPerPage,$_GET['curP']);
	(count($arryActivity)>0)?($arryActivity=$objPager->getPageRecords()):("");
	/*************************/
             
	require_once("../includes/footer.php"); 	
?>


