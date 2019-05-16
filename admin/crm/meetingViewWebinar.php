<?php 

$FancyBox=1; $HideNavigation = 1;
/**************************************************/
//$ThisPageName = 'meeting.php'; $EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/meeting.class.php");
$ModuleName = $_GET['module'];

$objMeeting = new Meeting();
/* if($_GET['type']=='personal'){
	$userData = $objMeeting->findMeetingUserColumn('id',$_GET['view']);
}else{ */
 $Webinar = $objMeeting->findWebinarByWebinarsColumn('webinar_id',$_GET['view']);
//}

?>

<?php require_once("../includes/footer.php"); ?>