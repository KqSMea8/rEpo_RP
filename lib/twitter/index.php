<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "2992271948-BW4tU4Tmx6bFaA7hCc3UB2ZCWocDi5QpihYpkYI",
    'oauth_access_token_secret' => "GW6FbHJh6Tu7sqr0Bs3GZZ3fmgV0dPxHJForLflXc6lze",
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/blocks/create.json';
$requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above **/
$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);

/** Perform a POST request and echo the response **/
$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
//$url = 'https://api.twitter.com/1.1/followers/ids.json';
//$url="https://api.twitter.com/1.1/search/tweets.json";

$url="https://api.twitter.com/1.1/users/search.json";
$getfield = '?q=kaushal967&amp;page=1';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$aaa= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
             echo '<pre>';
             print_r(json_decode($aaa));
echo '**************************************************************************************';
             
$url = 'https://api.twitter.com/1.1/followers/ids.json';
$getfield = '?screen_name=J7mbo';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();