<?php

$FancyBox=1;
$ThisPageName = 'social_listening.php';
$EditPage = 1;


require_once("../includes/header.php");

require_once($Prefix."classes/crm.class.php");
require_once($Prefix."classes/socialCrm.class.php");


$ObjectSocial =  new socialcrm();


$table="c_twitter_alerts";
if(isset($_POST['DeleteButton']))
{
	if(empty($_POST['checkB'])){$note_msg="please firstly select item!";}
	else{
		$cheks = implode("','", $_POST['checkB']);//implode("','", $_REQUEST['checkB']);
		//$query_del="delete from `c_twitter_alerts` where `id` in ('$cheks')";
		//$res_del=mysqli_query($con,$query_del);
		$wr="`id` in ('$cheks')";
		$st="`status`='0'";
		//$res_del=$ObjectSocial->TwitterDelete($table,$wr);
		$ObjectSocial->TwitterUpdate($table,$st,$wr);
			$wr="`alert_id` in ('$cheks')";
			$st="`status`='0'";
			$ObjectSocial->TwitterUpdate("c_twitter_tweets",$st,$wr);
			$_SESSION['mess_comp'] ="Alerts removed successfully";
	}
}

if(isset($_GET['adel_id']))
{
	$res_adel='';
	$adel_id=$_GET['adel_id'];
	//$query_adel="delete from `c_twitter_alerts` where id='$adel_id'";
	//$res_adel=mysqli_query($con,$query_adel);
	$st="`status`='0'";
	$res_adel=$ObjectSocial->TwitterUpdate($table,$st,"`id`='$adel_id'");	
		//mysqli_query($con,"update `c_twitter_tweets` set `alert_id`='' where `alert_id`='$adel_id'");*/
		$st="`status`='0'";
		$ObjectSocial->TwitterUpdate("c_twitter_tweets",$st,"`alert_id`='$adel_id'");
		$_SESSION['mess_comp'] = "Alert removed successfully";
}
$res_alert = $ObjectSocial->TwitterSearch("c_twitter_alerts",'*',"`status`='1'");

require_once("../includes/footer.php"); 
?>






