<?php
        $startDate = $_GET['startDate'];
        $startTime = $_GET['startTime'];
        $closeDate = $_GET['closeDate'];
        $closeTime = $_GET['closeTime']; 
        $subject = $_GET['subject']; 
        $location = $_GET['location'];
        $description = $_GET['description']; 

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






