<?php 
	/**************************************************/
	if($_GET['pop']==1)$HideNavigation = 1;
	$ThisPageName = 'viewRecurringQuote.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix . "classes/quote.class.php");
	$objQuote = new quote();


	$module = 'Quote';
	$ModuleName = "Recurring ".$module;
       

	$RedirectURL = "viewRecurringQuote.php?curP=".$_GET['curP'];


	
	

	 if ($_POST) {	
		CleanPost(); 		
		if(!empty($_POST['EntryType'])) {
			$objQuote->UpdateQuoteRecurring($_POST);
			$_SESSION['mess_rec_quote'] = QUOTE_REC_UPDATED;	
			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';	
			//header("Location:".$RedirectURL);
			exit;
		 } 
	}
		

	if(!empty($_GET['edit'])){            
		$arryQuote = $objQuote->GetQuote($_GET['edit'],'');	
	}

	if(empty($arryQuote[0]['quoteid'])) {
		header('location:'.$RedirectURL);
		exit;
	}			
	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


