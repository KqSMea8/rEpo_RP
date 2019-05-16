<?php
	/**************************************************/
	$ThisPageName = 'viewShift.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once("includes/FieldArray.php");
	$objCommon=new common();
	
	$ModuleName = "Shift";
	
	$RedirectUrl = "viewShift.php?curP=".$_GET['curP'];


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_shift'] = SHIFT_REMOVED;
		$objCommon->deleteShift($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_shift'] = SHIFT_STATUS_CHANGED;
		$objCommon->changeShiftStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		CleanPost(); 
		if(!empty($_POST['shiftID'])) {
			$objCommon->updateShift($_POST);
			$_SESSION['mess_shift'] = SHIFT_UPDATED;
		}else{		
			$objCommon->addShift($_POST);
			$_SESSION['mess_shift'] = SHIFT_ADDED;
		}		
		header("location:".$RedirectUrl);
		exit;
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryShift = $objCommon->getShift($_GET['edit'],'');
		$Status   = $arryShift[0]['Status'];
	}
 
	require_once("../includes/footer.php"); 
  ?>
