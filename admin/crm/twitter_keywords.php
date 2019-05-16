<?php

$FancyBox=1;
$ThisPageName = 'social_listening.php';
$EditPage = 1;

//require_once("../../define.php");
require_once("../includes/header.php");

/*require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/event.class.php");
require_once($Prefix."classes/group.class.php");*/
require_once($Prefix."classes/crm.class.php");
require_once($Prefix."classes/socialCrm.class.php");


$ObjectSocial =  new socialcrm();
$table="c_twitter_badkeys";

if(isset($_REQUEST['DeleteButton']))
{
	if(empty($_REQUEST['checkB'])){$_SESSION['mess_comp']="Please firstly select Keywords";}
	else{
		$cheks = implode("','", $_REQUEST['checkB']);//implode("','", $_REQUEST['checkB']);
	
		$wr="`id` in ('$cheks')";
		$ObjectSocial->TwitterDelete($table,$wr);
			//$st="`alert_id`=''";
			//$ObjectSocial->TwitterUpdate("c_twitter_tweets",$st,"`alert_id`='$adel_id'");
			$_SESSION['mess_comp'] ="Keywords removed successfully";
	}
}

if(isset($_GET['bdel_id']))
{
	$bdel_id=$_GET['bdel_id'];
	$wr="`id`='$bdel_id'";
	$res_adel=$ObjectSocial->TwitterDelete($table,$wr);	
	$_SESSION['mess_comp'] = "Keyword removed successfully";
}


$res_badkey=$ObjectSocial->TwitterSearch($table);
//**********************************Bad***************************
require_once("../includes/footer.php"); 
?>






