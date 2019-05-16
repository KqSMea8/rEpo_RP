<?php
	/**************************************************/
	$ThisPageName = 'viewHoliday.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	$objLeave=new leave();

	$RedirectUrl ="viewHoliday.php";
	$ModuleName = "Holiday";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_holiday'] = HOLIDAY_REMOVED;
		$objLeave->deleteHoliday($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_holiday'] = HOLIDAY_STATUS_CHANGED;
		$objLeave->changeHolidayStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {		 
		CleanPost(); 
 
 		if (!empty($_POST['holidayID'])) {
			$objLeave->updateHoliday($_POST);
			$_SESSION['mess_holiday'] = HOLIDAY_UPDATED;
		} else {		
			$objLeave->addHoliday($_POST);
			$_SESSION['mess_holiday'] = HOLIDAY_ADDED;
		}
	
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$holidayDateTo='';
	$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryHoliday = $objLeave->getHoliday($_GET['edit'],'');
		$PageHeading = 'Edit Holiday: '.stripslashes($arryHoliday[0]['heading']);
		$Status   = $arryHoliday[0]['Status'];
		$holidayDateTo  = $arryHoliday[0]['holidayDateTo'];
	}

	 require_once("../includes/footer.php"); 
 
?>
