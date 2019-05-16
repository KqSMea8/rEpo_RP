<?php

$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;
$ModuleName = 'MailChimp';
require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);

//ini_set('display_errors',1);



if($_POST){
  header("location:viewchimpSegment.php");
  exit;
}else{
	 $ChimpSegmentList = $massmail->GetchimpSegment();
	 //echo '<pre>';print_r($ChimpSegmentList);die;
	 $num = $massmail->numRows();
     $pagerLink = $objPager->getPager($ChimpSegmentList, $RecordsPerPage, $_GET['curP']);
     (count($ChimpSegmentList) > 0) ? ($ChimpSegmentList = $objPager->getPageRecords()) : ("");
}	

//$seglist=$Mailchimp_Lists->staticSegments(21197);
//echo '<pre>';print_r($seglist);die('seglist');

if (!empty($_GET['del_id'])) {
    $massmail->deleteMailchimSegment($_GET['del_id']);
	$segmentId = array('segment_id' =>$_GET['del_segment']);
	//print_r($segmentId);die;
	//$segmentId[] = $_GET['del_segment']);
	$Mailchimp_Lists->staticSegmentDel($cmpId,$segmentId['segment_id'],true,false,false);
    header("location:viewchimpSegment.php");
    exit;
}


require_once("../includes/footer.php"); 
?>






