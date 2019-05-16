<?php


$FancyBox=1; $HideNavigation = 1;
/**************************************************/
//$ThisPageName = 'meeting.php'; $EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/meeting.class.php");
$ModuleName = $_GET['module'];

$objMeeting = new Meeting();


$Webinar = $objMeeting->findWebinarByWebinarsColumn('webinar_id',$_GET['view']);
if(!empty($Webinar)){
	$result = $objMeeting->getWebinarRegisterInfo($Webinar[0]);
}
require_once("../includes/footer.php");

?>
