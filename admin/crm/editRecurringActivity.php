<?php 
	/**************************************************/
	if($_GET['pop']==1)$HideNavigation = 1;
	$ThisPageName = 'viewRecurringActivity.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix . "classes/event.class.php");
	$objActivity = new activity();


	$module = 'Event';
	$ModuleName = "Recurring ".$module;
       

	$RedirectURL = "viewRecurringActivity.php?curP=".$_GET['curP'];


	
	

	 if ($_POST) {	
		CleanPost(); 		
		if(!empty($_POST['EntryType'])) {
			$objActivity->UpdateActivityRecurring($_POST);
			$_SESSION['mess_rec_act'] = EVENT_REC_UPDATED;	
			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';	
			//header("Location:".$RedirectURL);
			exit;
		 } 
	}
		

	if(!empty($_GET['edit'])){            
		$arryActivity = $objActivity->GetActivity($_GET['edit'],'');           		
	}

	if(empty($arryActivity[0]['activityID'])) {
		header('location:'.$RedirectURL);
		exit;
	}
				
	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


