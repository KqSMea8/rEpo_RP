<?php 
	include_once("../includes/header.php");
	require_once($Prefix . "classes/quote.class.php");
	$ModuleName = "Quote";
	$objQuote = new quote();
        
      	$_GET['EntryType'] = 'recurring';

	$ModuleName = "Recurring ".$ModuleName;
              
	$ViewUrl = "viewRecurringQuote.php";
	$AddUrl = "editRecurringQuote.php";
	$EditUrl = "editRecurringQuote.php?curP=".$_GET['curP'];
	$ViewUrl = "vQuote.php?curP=".$_GET['curP'];

	$RedirectURL = "viewRecurringQuote.php?curP=".$_GET['curP'];

	/*************************/

	if(isset($_GET['cancel_id']) && $_GET['cancel_id'] && !empty($_GET['cancel_id'])){
		$_SESSION['mess_rec_quote'] = QUOTE_REC_CANCELLED;
		$objQuote->RemoveQuoteRecurring($_GET['cancel_id']);
		header("Location:".$RedirectURL);
		exit;
	}
     
        
	     
	 $arryQuote = $objQuote->ListRecurringQuote('', '', '', $_GET['key'], $_GET['sortby'], $_GET['asc']);
	$num=$objQuote->numRows();

	$pagerLink=$objPager->getPager($arryQuote,$RecordsPerPage,$_GET['curP']);
	(count($arryQuote)>0)?($arryQuote=$objPager->getPageRecords()):("");
	/*************************/
             
	require_once("../includes/footer.php"); 	
?>


