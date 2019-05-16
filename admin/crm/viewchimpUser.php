<?php

$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;
$ModuleName = 'MailChimp User';
require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);

//ini_set('display_errors',1);



if($_POST){
  header("location:viewchimpUser.php");
  exit;
}else{
	 $ChimpUserList = $massmail->GetMailchimUser();
	 $num = $massmail->numRows();
     $pagerLink = $objPager->getPager($ChimpUserList, $RecordsPerPage, $_GET['curP']);
     (count($ChimpUserList) > 0) ? ($ChimpUserList = $objPager->getPageRecords()) : ("");
}	


if (!empty($_GET['del_id'])) {
    $massmail->deleteMailchimUser($_GET['del_id']);
	$batch[] = array('email' =>$_GET['del_email']);
	$Mailchimp_Lists->BatchUnsubscribe($cmpId,$batch,true,false,false);
    header("location:viewchimpUser.php");
    exit;
}


require_once("../includes/footer.php"); 
?>






