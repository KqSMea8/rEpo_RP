<?php

ini_set('display_errors','1');
require 'Mailchimp.php';

$MailChimp = new MailChimp('c5085810ebeb6dd716f087ee1b7da949-us10');

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);


//$segmentId = $Mailchimp_Lists->StaticSegmentAdd('799283c68c','first_segment-1');
$segmentId = '1525';
 
$batch =  array('emails' => array('euid' => '7944afbcfb')); 
$listseg = $Mailchimp_Lists->staticSegmentMembersAdd('799283c68c',$segmentId, $batch); 
echo "<pre>";print_r($listseg);
?>