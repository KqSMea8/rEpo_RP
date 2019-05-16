<?php
	/**************************************************/
	$ThisPageName = 'viewLeaveCheck.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	
	$ModuleName = "Check";
	
	$RedirectUrl = "viewLeaveCheck.php?curP=".$_GET['curP'];


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_check'] = LEAVE_CHECK_REMOVED;
		$objCommon->deleteLeaveCheck($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_check'] = LEAVE_CHECK_STATUS_CHANGED;
		$objCommon->changeLeaveCheckStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		CleanPost(); 
		if(!empty($_POST['checkID'])) {
			$objCommon->updateLeaveCheck($_POST);
			$_SESSION['mess_check'] = LEAVE_CHECK_UPDATED;
		}else{		
			$objCommon->addLeaveCheck($_POST);
			$_SESSION['mess_check'] = LEAVE_CHECK_ADDED;
		}		
		header("location:".$RedirectUrl);
		exit;
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryLeaveCheck = $objCommon->getLeaveCheck($_GET['edit'],'');
		$Status   = $arryLeaveCheck[0]['Status'];
	}
 
	require_once("../includes/footer.php"); 
  ?>
