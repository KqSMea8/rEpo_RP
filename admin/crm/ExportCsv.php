<?php
include_once("../includes/settings.php");
require_once("../../define.php");

require_once(_ROOT . "/lib/mailchamp/src/config.php");



$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);


$ChimpCampaignList = $massmail->GetchimpCampaign();
//echo '<pre>';print_r($ChimpCampaignList);
foreach ($ChimpCampaignList as $values) {
    if ($values['status'] == 'send') {
        $campIdAll .=$values['campaign_id'] . ",";
    }
}
$campIdAll = strlen($campIdAll) ? substr($campIdAll, 0, strlen($campIdAll) - 1) : $campIdAll;
//echo $campIdAll;
$filter = array('campaign_id' => $campIdAll);
$listCampaign = $Mailchimp_Campaigns->getList($filter);
//echo '<pre>';print_r($listCampaign);die;
//$filattr = array('title','subject','status','send_time','id','emails_sent','folder_id', 'status');
$filattr = array('title','subject','send_time','emails_sent','summary','folder_id','id');
$updatelistcmp = $massmail->filterArray($filattr, $listCampaign['data']);
$renameArray = array(
    "title"=>"Title",
    "subject"=>"Subject",
    "send_time" => "Send Date",
    "emails_sent"=>"Successful Deliveries",
    "soft_bounces"=>"Soft Bounces",
    "hard_bounces"=>"Hard Bounces",
    "forwards"=>"Total Bounces",
    "forwards_opens"=>"Forwarded Opens",
    "unique_opens"=>"Unique Opens",
    "open_rate"=>"Open Rate",
    "opens"=>"Total Opens",
    "unique_clicks"=>"Unique Clicks",
    "click_rate"=>"Click Rate",
    "clicks"=>"Total Clicks",
    "unsubscribes"=>"Unsubscribes",
    "abuse_reports"=>"Abuse Complaints",
    "facebook_likes"=>"Times Liked on Facebook",
    "folder_id"=>"Folder Id",
    "id"=>"Unique Id",
    "syntax_errors"=>"Syntax Errors",
    "last_open"=>"Last Open",
    "users_who_clicked"=>"Users Clicked",
    "unique_likes"=>"Unique Likes",
    "recipient_likes"=>"Recipient Likes",
    "Times Liked on Facebook"=>"FaceBook Liked",
    "type"=>"Type",
    "bounce_rate"=>"Bounce Rate",
    "unsub_rate"=>"Unsub Rate",
    "unopen_rate"=>"Unopen Rate",
    "abuse_rate"=>"Abuse Rate",
    "last_click"=>"Last Click"
    
    
    
);
$updatelistcmp = $massmail->addNewAttribute($updatelistcmp);
$finalListCmp = $massmail->renameArrayKey($updatelistcmp,$renameArray);


function convert_to_csv($input_array, $output_file_name, $delimiter) {
    /** open raw memory as file, no need for temp files */
    $temp_memory = fopen('php://memory', 'w');
    /** loop through array  */
    foreach ($input_array as $line) {
        /** default php csv handler * */
        fputcsv($temp_memory, $line, $delimiter);
    }
    /** rewrind the "file" with the csv lines * */
    fseek($temp_memory, 0);
    /** modify header to be downloadable csv file * */
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($temp_memory);
}
$date=time();
//echo $CurDate;die('hfn');

convert_to_csv($finalListCmp, "MailChamp".$date.".csv", ",");
?>






