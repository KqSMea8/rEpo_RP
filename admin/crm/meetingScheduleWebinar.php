<?php 

$FancyBox=1; if($_GET['openType']=='iframe') $HideNavigation = 1;
/**************************************************/
$ThisPageName = 'meeting.php'; $EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/meeting.class.php");
$ModuleName = $_GET['module'];

$objMeeting = new Meeting();

$ViewUrl = "meetingScheduleWebinar.php?curP=".$_GET['curP'];

$RedirectURL = "meeting.php?curP=".$_GET['curP']."&tab=Webinar";

/************************************************/

if(!empty($_SESSION['EmpEmail'])){
	$MeetingUser = $objMeeting->findMeetingUserByEmail($_SESSION['EmpEmail']);
	//$zoomPermission = $objMeeting->getPermissionByUser($MeetingUser[0]['cust_id']);
	//$zoomPermission=unserialize($zoomPermission[0]['permission']);

	if(!$MeetingUser[0]['enable_webinar']){
		echo '<div align="center" style="padding-top:200px;" class="redmsg">Sorry, you are not authorized to access this section.</div>';
		exit;
	}
}
/************************************************/

if($_SESSION['AdminType']=='admin'){
	$MeetingUser = $objMeeting->findMeetingUserByEmail($_SESSION['AdminEmail']);
	# for admins
	if($MeetingUser[0]['enable_webinar']==0) {
		echo '<div align="center" style="padding-top:200px;" class="redmsg">Sorry, you are not authorized to access this section.</div>';
		exit;
	}
}

if(!empty($_GET['edit'])){
	if (!empty($_POST['saveWebinar']) && !empty($_POST['webinar_id']))
	{	
		$panelists = array();
		if(!empty($_POST['panelist_name']) && !empty($_POST['panelist_email'])){
			for ($i=0; $i<=count($_POST['panelist_email']); $i++){
				$p = '';
				if(!empty($_POST['panelist_email'][$i])){
					$p = array('name'=>$_POST['panelist_name'][$i],'email'=>$_POST['panelist_email'][$i]);
					array_push($panelists, $p);
				}
			}
		}
		$_POST['panelists'] = (!empty($panelists)) ? json_encode($panelists) : '';
		
		$result = $objMeeting->updateWebinarInfo($_POST,$arryCurrentLocation);
		
		if($result->id){
			$_SESSION['mess_meeting'] = 'Webinar is updated successfully.';
		}else if($result->error){ 
			$RedirectURL = $ViewUrl."&edit=".$_GET['edit'];
			$_SESSION['mess_meeting'] = $result->error->message;
		}else{
			$_SESSION['mess_meeting'] = 'Not able to Add. Try after some time!';
		}
		header("location:" . $RedirectURL);
		exit;
	}
	$Webinar = $objMeeting->findWebinarByWebinarsColumn('webinar_id',$_GET['edit']);
	
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
	if (!empty($_POST['saveWebinar']) && empty($_POST['webinar_id']))
	{	
		$panelists = array();
		if(!empty($_POST['panelist_name']) && !empty($_POST['panelist_email'])){
			for ($i=0; $i<=count($_POST['panelist_email']); $i++){
				$p = '';
				if(!empty($_POST['panelist_email'][$i])){
					$p = array('name'=>$_POST['panelist_name'][$i],'email'=>$_POST['panelist_email'][$i]);
					array_push($panelists, $p);
				}
			}
		}
		$_POST['panelists'] = (!empty($panelists)) ? json_encode($panelists) : '';
		
		$result = $objMeeting->createAWebinar($_POST);
		
		if($result->id){
			$result->option_practice_session = $_POST['option_practice_session'];
			$result->password = $_POST['password'];
			$result->panelists = $_POST['panelists'];
			$result->original_start_time =  $_POST['start_date'].'T'. date("G:i", strtotime($_POST['start_time1'].' '. $_POST['start_half']));
			$result->start_time = $objMeeting->getMeetingLocalTime($result->start_time,$arryCurrentLocation[0]['Timezone']);
			$result->created_at = $objMeeting->getMeetingLocalTime($result->created_at,$arryCurrentLocation[0]['Timezone']);
			$objMeeting->saveWebinar($result);
			$_SESSION['mess_meeting'] = 'New webinar is added successfully.';
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
