<?php
$FancyBox = 1;

/**************************************************/
//$ThisPageName = 'meeting.php'; $EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/meeting.class.php");
$ModuleName = $_GET['module'];

$objMeeting = new Meeting();

$ViewUrl = "meeting.php?curP=".$_GET['curP']."&module=".$_GET['module'];

if($_SESSION['AdminType']=='admin'){
	$user_email = $_SESSION['AdminEmail'];
}else{
	$user_email = $_SESSION['EmpEmail'];
}

$MeetingUser = $userIsTrue = $objMeeting->findMeetingUserByEmail($user_email); 
$viewAll = false;
$zoomPermission = array();
if(!empty($_SESSION['EmpEmail']) && !empty($MeetingUser)){
	$zoomPermission = $objMeeting->getPermissionByUser($MeetingUser[0]['cust_id']);
	$zoomPermission=unserialize($zoomPermission[0]['permission']);
	
	if( in_array('viewAll', $zoomPermission) ) $viewAll = true;
	
	 if(!(in_array('createMeeting', $zoomPermission) || $viewAll))
	 $MeetingUser = '';
	 
	 if( ($_GET['tab']=='Recordings') && (in_array('viewRecording', $zoomPermission) || $viewAll) ){
	 	$MeetingUser = $MeetingUser = $userIsTrue;
	 }else if($_GET['tab']=='Recordings'){
	 	$MeetingUser = '';
	 }
	 
	 if( ($_GET['tab']=='Webinar' || $_GET['tab']=='MyProfile') && (in_array('createWebinar', $zoomPermission) || $viewAll) ){ 
	 	$MeetingUser = $userIsTrue;
	  }else if($_GET['tab']=='Webinar') {
	 	$MeetingUser = '';
	 }
	 
}

# for admins
if($_GET['tab']=='Webinar' && $MeetingUser[0]['enable_webinar']==0) {
	header("location:" . $ViewUrl);
	exit;
}

if(!empty($MeetingUser)){
	if($_GET['tab']=='MyProfile'){
		include_once('meetingMyProfile.php');
	}elseif($_GET['tab']=='Webinar'){
		include_once('meetingWebinarList.php');
	}elseif($_GET['tab']=='UserManagement'){
		include_once('meetingUserManagement.php');
	}elseif($_GET['tab']=='Recordings'){
		include_once('meetingRecordings.php');
	}elseif($_GET['tab']=='Reports'){
		include_once('meetingReports.php');
	}else{ 
		include_once('meetingMeetingList.php');	
	}
}else{ 
	
	if(($_SESSION['AdminType']=='admin') && empty($_SESSION['mess_meetingBasic'])){ //$_POST['ActivateSubmit'] && 4132..1005
		$user['email'] = $_SESSION['AdminEmail'];
		$user['first_name'] = $_SESSION['DisplayName'];
		$result = $objMeeting->custcreateAdminUser($user);

		if(!empty($result->email)){
			$result->created_at  = $objMeeting->convertIsoDateToSql($result->created_at);
			$result->account_type= 'admin';
			$result->cust_id= $_SESSION['AdminID'];
			$objMeeting->saveUser($result);
			$_SESSION['mess_meeting'] = 'Your Account is activated successfully.';
		}else if($result->error){
			$_SESSION['mess_meetingBasic'] = $result->error->message.'Please Contact to Administrator!';
		}else{
			$_SESSION['mess_meetingBasic'] = 'Something went wrong. Contact to Administrator!';
		}
		
		header("location:" . $ViewUrl);
		exit;
	}
	
}

require_once("../includes/footer.php");
?>
