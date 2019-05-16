<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewDocument.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/quote.class.php");
	$objQuote=new quote();

	$RedirectURL = "viewDocument.php?module=Document&curP=".$_GET['curP'];


	
	if(!empty($_POST["ToEmail"]) && !empty($_GET["view"])){		
		$_POST['documentID'] = $_GET["view"];
		/***********/
		$MainDir = "upload/temp/";		
		$documentDestination = $MainDir.$_FILES['document']['name'];				
		if(@move_uploaded_file($_FILES['document']['tmp_name'], $documentDestination)){
			$_POST['AttachDocument'] = $documentDestination;
		}
			
		$objQuote->sendDocTo($_POST);
		$_SESSION['mess_Document'] = DOC_SEND;	
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;				
	}


	if(!empty($_GET['view'])){
		$arryDoc = $objQuote->GetDoc($_GET['view'],'');		
	}else{
		header("Location:".$RedirectURL);
		exit;
	}

	require_once("../includes/footer.php"); 	 
?>


