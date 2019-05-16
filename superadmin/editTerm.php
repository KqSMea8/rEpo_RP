<?php 
	/**************************************************/
	$ThisPageName = 'viewTerm.php'; $EditPage = 1;
	/**************************************************/
	include_once("includes/header.php");
	require_once("../classes/commonsuper.class.php");
	$objCommon=new common();
	$ModuleName = "Payment Term";
	$RedirectURL = "viewTerm.php?curP=".$_GET['curP'];

	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objCommon->RemoveTerm($del_id);
					}
					$_SESSION['mess_term'] = TERM_REMOVED;
					break;
			case 'active':
					$objCommon->MultipleTermStatus($multiple_action_id,1);
					$_SESSION['mess_term'] = TERM_STATUS_CHANGED;
					break;
			case 'inactive':
					$objCommon->MultipleTermStatus($multiple_action_id,0);
					$_SESSION['mess_term'] = TERM_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/		

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_term'] = TERM_REMOVED;
		$objCommon->RemoveTerm($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_term'] = TERM_STATUS_CHANGED;
		$objCommon->changeTermStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if($_POST){
			CleanPost();

			 if (empty($_POST['termName'])) {
				$errMsg = ENTER_TERM;
			 } else {
				if (!empty($_POST['termID'])) {
					$termID = $_POST['termID'];
					$objCommon->UpdateTerm($_POST);
					$_SESSION['mess_term'] = TERM_UPDATED;
				} else {	
					$termID = $objCommon->AddTerm($_POST); 
					$_SESSION['mess_term'] = TERM_ADDED;
				}			
						

				header("Location:".$RedirectURL);
				exit;
			
			}
		}
		

	$Status = 1;
	if(!empty($_GET['edit'])){
		$arryTerm = $objCommon->GetTerm($_GET['edit'],'');
		$termID   = $_REQUEST['edit'];	
		$Status = $arryTerm[0]['Status'];
	}

	require_once("includes/footer.php"); 	 
?>
