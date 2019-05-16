<?php

//ini_set('display_errors',1);
$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);

//ini_set('display_errors',1);
$ChimpUserList = $massmail->GetMailchimUser();
$num = $massmail->numRows();
$pagerLink = $objPager->getPager($ChimpUserList, $RecordsPerPage, $_GET['curP']);
 (count($ChimpUserList) > 0) ? ($ChimpUserList = $objPager->getPageRecords()) : ("");

if($_POST){
	
$segmentId = $Mailchimp_Lists->StaticSegmentAdd($ChimpUserList,'name');
print_r(check);die;
foreach(){
$batch =  array('emails' => array('euid' => '7944afbcfb'));
$listseg = $Mailchimp_Lists->staticSegmentMembersAdd($ChimpUserList,$segmentId, $batch);

} 
//echo "<pre>";print_r($listseg);


//echo "<pre>";print_r($_POST);die;
	
} 
require_once("../includes/footer.php");
?>






