<?php

$RedirectUrl = "meeting.php?curP=".$_GET['curP']."&tab=Recordings";

//pr($Config);
/***********************/
if(!empty($_POST['sync_meeting'])){
	$x = array();
	$x['user_id'] = $MeetingUser[0]['id'];
	$resentMeetings = $objMeeting->saveUserRecordingList($x, $_SESSION['CmpID']);
	if(!empty($_SESSION['mess_meeting'])){
		$_SESSION['mess_meeting'] ="Recording Synced successfully!";
	}else{
		$_SESSION['mess_meeting'] ="No new recording Found!";
	}
header("location:" . $RedirectUrl);
exit;
}

if(!empty($_GET['del_id'])){
	$uuid = str_replace(" ", "+",urldecode($_GET['del_id']));
	$result = $objMeeting->deleteFullRecording($uuid);
	$_SESSION['mess_meeting'] ="Recording has been deleted successfully!";
	header("location:" . $RedirectUrl);
	exit;
}

if (!empty($_GET['active_id']))
{
	$_GET['active_id'] = (int) $_GET['active_id'];
	$objMeeting->updateUserStatus($_GET['active_id'],$_GET['status']);
	$_SESSION['mess_meeting'] ="User status has been changed successfully!";
	header("location:" . $RedirectUrl);
	exit;
}

/***********************/

$arryMeetingRecords = $objMeeting->getRecordingsByUserType($_SESSION['AdminType'],$MeetingUser[0]['id'], $viewAll);
$num = $objMeeting->numRows();

//pr($arryMeetingRecords);
$pagerLink = $objPager->getPager($arryMeetingRecords, $RecordsPerPage, $_GET['curP']);
(count($arryMeetingRecords) > 0) ? ($arryMeetingRecords = $objPager->getPageRecords()) : ("");
 

require_once("includes/html/meetingRecordings.php");

?>
