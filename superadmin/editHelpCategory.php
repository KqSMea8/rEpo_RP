<?php 
	/**************************************************/
	$ThisPageName = 'viewHelpCategory.php'; $EditPage = 1;
	/**************************************************/

	include_once("includes/header.php");

	require_once("../classes/help.class.php");
	
	$objHelp = new help();
	$ModuleName = "Help Category";
	$RedirectURL = "viewHelpCategory.php?curP=".$_GET['curP'];

				

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_help'] = WCAT_REMOVED;
		$objHelp->RemoveHelpCategory($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_help'] = WCAT_STATUS_CHANGED;
		$objHelp->changeHelpCategoryStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if($_POST){
			CleanPost();

			 if (empty($_POST['CategoryName'])) {
				$errMsg = ENTER_CATEGORY;
			 } else {
				if (!empty($_POST['CategoryID'])) {
					$CategoryID = $_POST['CategoryID'];
					$objHelp->UpdateHelpCategory($_POST);
					$_SESSION['mess_help'] = WCAT_UPDATED;
				} else {	
					$CategoryID = $objHelp->AddHelpCategory($_POST); 
					$_SESSION['mess_help'] = WCAT_ADDED;
				}			
						

				header("Location:".$RedirectURL);
				exit;
			
			}
		}
		

	$Status = 1;
	if(!empty($_GET['edit'])){
		$arryHelpCategory = $objHelp->GetHelpCategory($_GET['edit'],'');
		$CategoryID   = $_GET['edit'];	
		$Status = $arryHelpCategory[0]['Status'];
	}

	require_once("includes/footer.php"); 	 
?>
