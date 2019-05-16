<?php


$RedirectUrl = "meeting.php?tab=Webinar&curP=".$_GET['curP']."&MeetingType=".$_GET['Previous'];

/***********************/
if($_POST) {
	//CleanPost();
        //header("location:" . $RedirectUrl);
       // exit;
}

/***********************/
if(!empty($_GET['del_id']) && !empty($_GET['webinar_id'])){
	$result = $objMeeting->deleteAWebinar($_GET['webinar_id'],$_GET['del_id']);
	if($result->id){
		$objMeeting->deleteAWebinarFromTable($_GET['webinar_id'],$_GET['del_id']);
		$_SESSION['mess_meeting'] = 'Webinar is deleted successfully.';
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

$arryWebinars = $objMeeting->findWebinarByUserID($MeetingUser[0]['id'], $viewAll);
$num = $objMeeting->numRows();

$pagerLink = $objPager->getPager($arryWebinars, $RecordsPerPage, $_GET['curP']);
(count($arryWebinars) > 0) ? ($arryWebinars = $objPager->getPageRecords()) : ("");

require_once("includes/html/meetingWebinarList.php");

?>
