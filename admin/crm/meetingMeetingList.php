<?php


$RedirectUrl = "meeting.php?curP=".$_GET['curP']."&MeetingType=".$_GET['Previous'];

/***********************/
if($_POST) {
	//CleanPost();
        //header("location:" . $RedirectUrl);
       // exit;
}

/***********************/
if(!empty($_GET['del_id']) && !empty($_GET['meeting_id'])){
	$result = $objMeeting->deleteAMeeting($_GET['meeting_id'],$_GET['del_id']);
	if($result->id){
		$objMeeting->deleteAMeetingFromTable($_GET['meeting_id'],$_GET['del_id']);
		$_SESSION['mess_meeting'] = 'Meeting is deleted successfully.';
	}else if($result->error){
		$_SESSION['mess_meeting'] = $result->error->message;
	}else{
		$_SESSION['mess_meeting'] = 'Not able to delete. Try after some time!';
	}
	header("location:" . $RedirectUrl);
	exit;
}

/******************* get persional meeting zpk **************************/
if(!empty($MeetingUser[0]['id']) && empty($MeetingUser[0]['zpk'])){
	$result = $objMeeting->getUserInfoByEmail($MeetingUser[0]);
	if($result->id){
		$objMeeting->updateMeetingUserByZPK($result->zpk, $MeetingUser[0]['email']);
		header("location:" . $RedirectUrl);
		exit;
	}
}

if(!empty($_GET['zpk'])){
	$result = $objMeeting->checkZpkByEmail($_GET['zpk']);
	if($result->error){
		
		$result = $objMeeting->getUserInfoByEmail($MeetingUser[0]);
		if($result->id){
			$objMeeting->updateMeetingUserByZPK($result->zpk, $MeetingUser[0]['email']);
			header("location:" . "https://www.zoom.us/s/".$result->pmi."?zpk=".$result->zpk);
			exit;
		}
		
	}
}

/***********************************************************************/

$arryMeetings = $objMeeting->findMeetingByUserID($MeetingUser[0]['id'], $viewAll);
$num = $objMeeting->numRows();

$pagerLink = $objPager->getPager($arryMeetings, $RecordsPerPage, $_GET['curP']);
(count($arryMeetings) > 0) ? ($arryMeetings = $objPager->getPageRecords()) : ("");

require_once("includes/html/meetingMeetingList.php");

?>
