<?php
ini_set('display_errors', 1);
$results=array();

require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "2992271948-BW4tU4Tmx6bFaA7hCc3UB2ZCWocDi5QpihYpkYI",
    'oauth_access_token_secret' => "GW6FbHJh6Tu7sqr0Bs3GZZ3fmgV0dPxHJForLflXc6lze",
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);


$url="https://api.twitter.com/1.1/mutes/users/list.json";
$getfield = '?include_entities=true&skip_status=true';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$aaa= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
            
           $results=json_decode($aaa);
           echo '<pre>';
           print_r($results);
           

?>
<html>

<title>
Search User
</title>
<head></head>
<body>
<form>
<div><label>Search User</label><input type="text" name="q" value="<?php echo !empty($_GET['q'])?$_GET['q']:'';?>" /><input type="submit" value="search"></div>
</form>
<div>
<h2>Results</h2>
<?php if(!empty($results)){
echo '<ul>';
	foreach($results as $result){
	
	echo '<li>';
	echo '<div><label>Id</label>:'.$result->id.'<div>';
	echo '<div><label>Name</label>:'.$result->name.'<div>';
	echo '<div><label>Screen Name</label>:'.$result->screen_name.'<div>';
	echo '<div><label>Location</label>:'.$result->location.'<div>';
	echo '<div><label>Image</label>:<img src="'.$result->profile_image_url.'"><div>';
	echo '<div><label>followers_count</label>:'.$result->followers_count.'<div>';	
	echo '<div><label>friends_count</label>:'.$result->friends_count.'<div>';	
	
	echo '</li>';
	
	
	}
	echo '<ul>';

}?>

</div>
</body>
</html>