<?php

$FancyBox = 1; $ThisPageName = 'meeting.php'; 

include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("language/en_lead.php");
require_once($Prefix . "classes/meeting.class.php");

$ModuleName = "Webinar Lead Form";
$objLead = new lead();
$objFilter = new filter();
$objGroup = new group();
$objMeeting = new Meeting();
$ViewUrl = "meeting.php?curP=" . $_GET['curP'];

$RedirectUrl = "meetingViewCreateLead.php??type=meetingLead&curP=" . $_GET['curP'];

/************************************************/

if(!empty($_SESSION['EmpEmail'])){
	$MeetingUser = $objMeeting->findMeetingUserByEmail($_SESSION['EmpEmail']);
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

/*********************Set Defult ************/


    
    unset($_SESSION['msg_lead_form']);
    
   
   $arryLeadForm = $objLead->ListCreateLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);


$num = $objLead->numRows();

$pagerLink = $objPager->getPager($arryLeadForm, $RecordsPerPage, $_GET['curP']);
(count($arryLead) > 0) ? ($arryLeadForm = $objPager->getPageRecords()) : ("");



/* * ******************************************** */





require_once("../includes/footer.php");
?>
