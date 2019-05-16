<?php 
	/**************************************************/
	$_GET['Division'] = 5; 
	/**************************************************/	
	require_once("../../define.php");
	include_once("../includes/header.php");
	require_once(_ROOT."/lib/twitter/TwitterAPIExchange.php");
 $settings = array(
    'oauth_access_token' => "2992271948-BW4tU4Tmx6bFaA7hCc3UB2ZCWocDi5QpihYpkYI",
    'oauth_access_token_secret' => "GW6FbHJh6Tu7sqr0Bs3GZZ3fmgV0dPxHJForLflXc6lze",
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);


$url="https://api.twitter.com/1.1/users/show.json";
$getfield = '?screen_name='.$_GET['screen_name'];
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$aaa= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
            
           $result=json_decode($aaa);

	require_once("../includes/footer.php"); 	
?>
