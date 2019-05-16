<?php

$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);
$Mailchimp_Reports = new Mailchimp_Reports($MailChimp);

//ini_set('display_errors',1);

$Campaignfolder = $MailchimSetting['0']['campaign_folder_id'];
//print_r($Campaignfolder);die;

if(!empty($_GET['ReCmpID'])){
    //$RCmpID="'".$_GET['ReCmpID']."'";
    //echo $_GET['ReCmpID'];
$GetcampaignSummery=$massmail->GetchimpCampaignSummery($_GET['ReCmpID']);
//echo '<pre>';print_r($GetcampaignSummery);die('kkkl');
$viewreport=$Mailchimp_Reports->opened($_GET['ReCmpID']);
$viewsummer=$Mailchimp_Reports->summary($_GET['ReCmpID']);

//echo "<pre>";print_r($viewreport);
//echo "<br/> part 2 <br/>";
//echo "<pre>";print_r($viewsummer);die('newwww');
if(!empty($viewsummer) && !empty($viewreport)) {
$openrate=$viewsummer['unique_opens']*100/$viewsummer['emails_sent'];
 $Openrate=round($openrate,1).'%';
 $OpenrateWidth=round($openrate,0).'%';
//echo $viewsummer['emails_sent'];
//die();
}   
}


//$viewreport=$Mailchimp_Reports->opened('04aed5a5c3');
//$viewsummer=$Mailchimp_Reports->summary('04aed5a5c3');
//echo "<pre>";print_r($viewreport);
//echo "<br/> part 2" ;
//echo "<pre>";print_r($viewsummer);

//die('hello');
//opened(string apikey, string cid, struct opts)

require_once("../includes/footer.php"); 
?>






