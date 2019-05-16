<?php
require_once("Mailchimp.php");
//require_once(_ROOT."/lib/mailchamp/src/Mailchimp.php");
$MailChimp = new MailChimp('a3d6c81da7047082cee09295550e3c5e-us11');
require_once($Prefix."classes/massmail.class.php");
$massmail = new massmail();

$MailchimSetting = $massmail->GetMailchimSetting();

if(count($MailchimSetting)==0){
	//header("location:mailchimp.php");
	//exit();
}

$cmpId =  '9fad7829c1';
$groupIdP = '123461';
$group_Name = 'vstacks Info Tech';

?>
