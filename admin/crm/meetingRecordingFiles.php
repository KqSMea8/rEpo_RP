<?php 
//$HideNavigation=1;
$FancyBox=1;//$HideNavigation = 1;
/**************************************************/
$ThisPageName = 'meeting.php'; $EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/meeting.class.php");
$ModuleName = $_GET['module'];

$objMeeting = new Meeting();

 $RedirectURL = "meeting.php?curP=".$_GET['curP']."&tab=Recordings";

/************************************************/
 if(!empty($_SESSION['EmpEmail'])){
 	//$MeetingUser = $objMeeting->findMeetingUserByEmail($_SESSION['EmpEmail']);
 	$zoomPermission = $objMeeting->getPermissionByUser($_SESSION['AdminID']);
 	$zoomPermission=unserialize($zoomPermission[0]['permission']);
 	
 	 if( !(in_array('viewRecording', $zoomPermission) || in_array('viewAll', $zoomPermission)) ){
 	 	header("location:" . $RedirectURL);
 	 	exit;
 	 }
 }
/************************************************/
 
 if(!empty($_GET['del_id'])){
 	$fileID = str_replace(" ", "+",urldecode($_GET['del_id']));
 	$result = $objMeeting->deleteSingleRecording($fileID);
 	$_SESSION['mess_meeting'] ="File is deleted successfully!";
 	$Redirectthis = "meetingRecordingFiles.php?edit=".$_GET['edit'];
 	header("location:" . $Redirectthis);
 	exit;
 }
 
$url = str_replace(" ", "+",urldecode($_GET['edit']));
$recordsData = $objMeeting->getRecordingDetail($url);
$recordingData = $objMeeting->getRecordingFilesDetail($url);

?>

<?php require_once("../includes/footer.php"); ?>
