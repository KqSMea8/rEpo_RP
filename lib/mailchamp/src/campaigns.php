<?php
//http://www.wellnet.it/node/1745
ini_set('display_errors','1');
require 'Mailchimp.php';

$MailChimp = new MailChimp('c5085810ebeb6dd716f087ee1b7da949-us10');

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);

$options= array('list_id'=>'799283c68c','subject'=>'test mail','from_email'=>'pankaj.kumar@vstacks.in','from_name'=>'pankaj yadav','to_name'=>'CRM' ,'template_id'=>'8421','auto_footer'=>false);

$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => '1525')));


$content = array('html'=>'some pretty html content','text' => 'text text text *|UNSUB|*');
$addCampaign = $Mailchimp_Campaigns->create('plaintext', $options, $content, $segment);

echo "<pre>";print_r($addCampaign);

?>