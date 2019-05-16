<?php
//session_start();
//echo '<pre>'; print_r($_SERVER);die;
//ini_set('display_errors',1);

//require_once("../../../admin/includes/header.php");
//require_once("settings.php");

require_once(_ROOT."/lib/mailchamp/src/Mailchimp.php");
require_once(_ROOT."/classes/massmail.class.php");
$massmail = new massmail();
$objConfig=new admin();	
/* * **************************************** */
//echo $Config['Url'];
$tt=  $massmail->Getmailchimpaccount();
//echo "'".$tt[0]['mail_chimp_Api_Key']."'";
//require_once($Config['Url']."lib/mailchamp/src/Mailchimp.php");
//echo '<pre>'; print_r($tt);die('fff');

if(empty($tt)){
	header("location:mailChimpSetting.php");
	exit();
}
if(!empty($tt)){
//require_once(_ROOT."/lib/mailchamp/src/Mailchimp.php");
$MailChimp = new MailChimp($tt[0]['mail_chimp_Api_Key']);

//echo '<pre>'; print_r($tt);die('fff');
$MailchimSetting = $massmail->GetMailchimSetting();



//echo "'".$tt[0]['mail_chimp_Api_Key']."'";
 $cmpId =$tt[0]['mail_chimp_cmpId'];
  $groupIdP =$tt[0]['groupId'];
 $group_Name =$tt[0]['group_name'];
 
}

?>