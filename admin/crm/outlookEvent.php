<?php
include_once("../includes/settings.php");
require_once($Prefix."classes/event.class.php");
$objActivity=new activity();

if (!empty($_GET['activityID'])) {
	
	$OutlookFileData = $objActivity->GetActivity($_GET['activityID'],'');

        $startDate = $OutlookFileData[0]["startDate"];
        $startDateStr = date_format(date_create($startDate), 'd M');
        $closeDate = $OutlookFileData[0]['closeDate'];
        $closeDateStr = date_format(date_create($closeDate), 'd M');
        $startTime = $OutlookFileData[0]['startTime'];
        $closeTime = $OutlookFileData[0]['closeTime'];
        $location = $OutlookFileData[0]['location'];
        
        $subject = $OutlookFileData[0]['subject']." - ".$OutlookFileData[0]['activityType']." [".$startDateStr."-".$closeDateStr."]";   
        $description = strip_tags($OutlookFileData[0]['description']);        
        
}


if(empty($OutlookFileData[0]['activityID'])){
	echo 'Invalid event';exit;
}



header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=calendar.ics");
echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//Foobar Corporation//NONSGML Foobar//EN\n";
//echo "METHOD:REQUEST\n"; // requied by Outlook
echo "BEGIN:VEVENT\n";
//echo "UID:".date('Ymd').'T'.date('His')."-".rand()."example.com\n"; // required by Outlok
echo "UID:" . md5(uniqid(mt_rand(), true)) . "example.com\n";
echo "DTSTAMP:".date('Ymd').'T'.date('His')."Z\n"; // required by Outlook
echo "DTSTART:".date_format(date_create($startDate), 'Ymd')."T".date_format(date_create($startTime),His)."00Z\n";
echo "DTEND:".date_format(date_create($closeDate), 'Ymd')."T".date_format(date_create($closeTime),His)."00Z\n";
echo "SUMMARY:$subject\n";
echo "LOCATION:$location\n";
echo "DESCRIPTION: $description\n";
echo "END:VEVENT\n";
echo "END:VCALENDAR\n";
?>






