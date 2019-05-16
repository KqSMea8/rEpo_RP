<?php
 /**************************************************/
    $ThisPageName = 'viewMasterComments.php'; $EditPage = 1;
    /**************************************************/
	require_once("../includes/header.php");
	 require_once($Prefix."classes/finance.account.class.php");
	$objBankAccount = new BankAccount();
	
	$RedirectUrl ="viewMasterComments.php";
	$ModuleName = "PO/SO Comment";
	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = "Comment is deleted successfully";
		$objBankAccount->deleteMasterComment($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_att'] = "Comment status has been changed";
		$objBankAccount->changeCommentStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['MasterCommentID'])) {
			$objBankAccount->AddMasterComment($_POST);
			$_SESSION['mess_att'] = "Comment updated successfully";
		} else {		
			$objBankAccount->AddMasterComment($_POST);
			$_SESSION['mess_att'] = "Comment Added successfully.";
		}
	
		 
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryComments = $objBankAccount->getMasterComment('',$_GET['edit']);
		$Status   = $arryComments[0]['status'];
	}else{
		$arryComments = $objConfigure->GetDefaultArrayValue('s_master_comments');
	}




	 require_once("../includes/footer.php"); 
 
?>
