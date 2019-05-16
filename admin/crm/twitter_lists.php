<?php

$FancyBox=1;
$ThisPageName = 'social_listening.php';
$EditPage = 1;
$InnerPage=1;

require_once("../includes/header.php");
//ini_set('display_errors',1);

require_once($Prefix."classes/crm.class.php");
require_once($Prefix."classes/socialCrm.class.php");

$ObjectSocial =  new socialcrm();

//**************************************************************************************************
 
//require_once("twitter_listening/db.php");
$tablename="c_twitter_tweets";

if(isset($_GET['Gid']))
{
	$gid=$_GET['Gid'];
	$st="`tweet_type`='bad'";
		$ObjectSocial->TwitterUpdate($tablename,$st,"`id`='$gid'");
		$_SESSION['mess_comp'] = "Tweet has been marked as Bad successfully";
	//$res=mysqli_query($con,"update `c_twitter_tweets`  set `tweet_type`='bad' where id='$gid'");

}

if(isset($_GET['Bid']))
{
	$bid=$_GET['Bid'];
	$st="`tweet_type`='good'";
		$ObjectSocial->TwitterUpdate($tablename,$st,"`id`='$bid'");
		$_SESSION['mess_comp'] = "Tweet has been marked as good successfully";
	//$res=mysqli_query($con,"update `c_twitter_tweets` set `tweet_type`='good' where id='$bid'");
	//if($res)$s_msg="Tweet has been marked as Good successfully.";
}

$list_row=array();
$wr='';
if(isset($_REQUEST['search'])=='Search')
{
	$sortby=$_REQUEST['sortby'];
	$sq=mysql_real_escape_string($_REQUEST['s_key']);
	$asc=$_REQUEST['asc'];
	$K=$_REQUEST['alertsK'];
	$alertsk=empty($_REQUEST['alertsK'])?'':'and `alert_id`='.$_REQUEST['alertsK'];
	
	
	if($sortby=='all' && $sq!='')
	{ 
		$wr="`status`='1' and `tweet_text` LIKE '%$sq%' $alertsk ORDER BY `id` $asc";
		//$list_row = $ObjectSocial->TwitterSearch($tablename,"*",$wr);	
	}
		
	elseif($alertsk!='' && $sortby=='all' && $sq=='')
	{ 
		$wr="`status`='1' and `alert_id`='$K' ORDER BY `id` $asc";
		//$list_row = $ObjectSocial->TwitterSearch($tablename,"*",$wr);
		//$query="select * from `c_twitter_tweets` where `alert_id`='$K' ORDER BY `id` $asc";
	}
	elseif($alertsk=='' && $sortby=='all' && $sq=='')
	{
		$wr="`status`='1' ORDER BY `id` $asc";
		//$list_row = $ObjectSocial->TwitterSearch($tablename,"*",$wr);
		//$query="select * from `c_twitter_tweets` ORDER BY `id` $asc";
	}
	elseif($sortby!='all' && $sq=='')
	{
		$wr="`status`='1' and `tweet_type`='$sortby' $alertsk ORDER BY `id` $asc";
		//$list_row = $ObjectSocial->TwitterSearch($tablename,"*",$wr);
		//$query="select * from `c_twitter_tweets`  WHERE `tweet_type`='$sortby' $alertsk ORDER BY `id` $asc";
	}
	else
	{
		$wr="`status`='1' and `tweet_text` LIKE '%$sq%' and `tweet_type`='$sortby' $alertsk ORDER BY `id` $asc";
		//$list_row = $ObjectSocial->TwitterSearch($tablename,"*",$wr);
		//$query="select * from `c_twitter_tweets`  WHERE `tweet_text` LIKE '%$sq%' and `tweet_type`='$sortby' $alertsk ORDER BY `id` $asc";
	}
	$list_row = $ObjectSocial->TwitterSearch($tablename,"*",$wr);
	$num = count($list_row);
	$i=0;	
}
else
{
	$list_row = $ObjectSocial->TwitterSearch($tablename,"*","`status`='1'");
	$num=count($list_row);
}

//**********pagignation
$pagerLink = $objPager->getPager($list_row, $RecordsPerPage, $_GET['curP']);
(count($list_row) > 0) ? ($list_row = $objPager->getPageRecords()) : ("");


//*****************************************************************************
require_once("../includes/footer.php"); 
?>