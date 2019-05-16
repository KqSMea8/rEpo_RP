<?php 

$FancyBox=1; if(isset($_GET['openType']) && $_GET['openType']=='iframe') $HideNavigation = 1;
/**************************************************/
$ThisPageName = 'meeting.php'; $EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/meeting.class.php");
$ModuleName = $_GET['module'];

$objMeeting = new Meeting();

$ViewUrl = "meetingScheduleMeeting.php?curP=".$_GET['curP'];

$RedirectURL = "meeting.php?curP=".$_GET['curP'];
 
/************************************************/

if(!empty($_SESSION['EmpEmail'])){
	//$MeetingUser = $objMeeting->findMeetingUserByEmail($_SESSION['EmpEmail']);
	$zoomPermission = $objMeeting->getPermissionByUser($_SESSION['AdminID']);
	$zoomPermission=unserialize($zoomPermission[0]['permission']);

	if( !(in_array('createMeeting', $zoomPermission) || in_array('viewAll', $zoomPermission)) ){
		header("location:" . $RedirectURL);
		exit;
	}
}
/************************************************/

if(!empty($_GET['edit'])){
	if (!empty($_POST['saveMeeting']) && !empty($_POST['meeting_id']))
	{
		$result = $objMeeting->updateMeetingInfo($_POST,$arryCurrentLocation);
		if($result->id){
			$_SESSION['mess_meeting'] = 'Meeting is updated successfully.';
		}else if($result->error){ 
			$RedirectURL = $ViewUrl."&edit=".$_GET['edit'];
			$_SESSION['mess_meeting'] = $result->error->message;
		}else{
			$_SESSION['mess_meeting'] = 'Not able to Add. Try after some time!';
		}
		header("location:" . $RedirectURL);
		exit;
	}
	$Meeting = $objMeeting->findMeetingByMeetingsColumn('meeting_id',$_GET['edit']);
	
}else{
	/*-----------------------------*/
	if(!empty($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	}else{
		
		if($_SESSION['AdminType']=='admin'){
			$user_email = $_SESSION['AdminEmail'];
		}else{
			$user_email = $_SESSION['EmpEmail'];
		}
		$MeetingUser = $objMeeting->findMeetingUserByEmail($user_email);
		$user_id = $MeetingUser[0]['id'];
	}
	
	if(empty($user_id)){
		$_SESSION['mess_meeting'] = 'server error. can not find user';
		header("location:" . $RedirectURL);
		exit;
	}
	/*-----------------------------*/
	
	
	/*-----------------------------*/
	if (!empty($_POST['saveMeeting']) && empty($_POST['meeting_id']))
	{
		$result = $objMeeting->createAMeeting($_POST);
		if($result->id){
			$result->start_time = $objMeeting->getMeetingLocalTime($result->start_time,$arryCurrentLocation[0]['Timezone']);
			$result->created_at = $objMeeting->getMeetingLocalTime($result->created_at,$arryCurrentLocation[0]['Timezone']);
			$objMeeting->saveMeeting($result);
			$_SESSION['mess_meeting'] = 'New meeting is added successfully.';
		}else if($result->error){
			$RedirectURL = $ViewUrl;
			$_SESSION['mess_meeting'] = $result->error->message;
		}else{
			$_SESSION['mess_meeting'] = 'Not able to Add. Try after some time!';
		}
		
		if($HideNavigation){ 
			header("location:" . $ViewUrl.'&openType=iframe&copyClip=1&lastID='.$objMeeting->lastInsertId());
		}else
		header("location:" . $RedirectURL);
		
		exit;
	}
	/*-----------------------------*/
	
}
?>

<?php require_once("../includes/footer.php"); ?>
