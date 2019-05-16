<?php
$FancyBox=1;

require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once($Prefix."classes/crm.class.php");
require_once($Prefix."classes/socialCrm.class.php");

$ObjectSocial =  new socialcrm();
//require_once("twitter_listening/db.php");
$res_alert = $ObjectSocial->TwitterSearch("c_twitter_tweets",'`tweet_type`, COUNT(*) as t',"`status`='1' GROUP BY `tweet_type`");

require_once("../includes/footer.php"); 
?>






