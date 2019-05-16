<?php
	include_once("../includes/settings.php");
	require_once($Prefix."classes/socialCrm.class.php");

require_once 'twitter_listening/lib/twitteroauth.php';
 
define('CONSUMER_KEY', 'itqEazc9Q0KYCX9ihTACwXWJ9');
define('CONSUMER_SECRET', '38Mu8SdwNU6NfVA2I2Ck64ox9xt6wlkzqoVaMwzUiNAExw9xe1');
define('ACCESS_TOKEN', '3042380816-IeoAGl9ette6ieTgefp0UBFc56KpVS8bUNorjmP');
define('ACCESS_TOKEN_SECRET', 'klEwMsPt4Z7NnQvBnHot3qH9n5bRdhOhjDHHmcTZteWIq');

function search(array $query)
{
	$toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	return $toa->get('search/tweets', $query);
}
//require_once("twitter_listening/db.php");
$ObjectSocial =  new socialcrm();

?>
<?php
$cron_name=$ObjectSocial->TwitterSearch("c_twitter_alerts","`id`,`alert_name`","`status`='1'");
//print_r($cron_name);
foreach($cron_name as $search_alert)						//if(isset($_REQUEST['a_name']))//if(isset($_REQUEST['submit']))
{
	$sq=$search_alert['alert_name'];
	$aid_id=$search_alert['id'];
	$count=0; 
	$b=0; 
	$g=0;
	$query = array(
	  "q" => $sq,
	  "count" => 100,
	  "result_type" => "recent",
	  "lang" => "en",);

	$results = search($query);
	//echo "<pre>";print_r($results); die();
	$fr['f']=0;
	$f=0;
	//$s=mysqli_query($con,"select max(created_at) as f from `c_twitter_tweets`");
	$fr=$ObjectSocial->TwitterSearch("c_twitter_tweets","max(created_at) as f");
	//$fr=mysqli_fetch_array($s); 
	//echo $fr[0]['f'];
	//$resul=json_decode($results); echo "<pre>"; print_r($resul);
	/*$word=array("not good","it's bad","It's Bad","this is bad","This is bad","IS BAD",
				"it's suck","fuck it","FUCK","fuck","not fulfill","yakk","disgusting",
				"ugly","Shame on you","shame on");*/
				$word=array();
	$words=$ObjectSocial->TwitterSearch("c_twitter_badkeys","bad_key");
	foreach($words as $w)$word[]=$w['bad_key'];
	$v=array();
	
	foreach($results->statuses as $result) 
	{ 
		$flag='good';
		$str=$result->created_at;
		$date = date_create($str);
	 	$time = date_format($date, 'Y-m-d H:i:s');//echo '<br>';

		$value['created_at']=$time;
		//echo $value['date'];*/
		if($fr[0]['f']<$value['created_at'] or $fr[0]['f']==0)
		{
			$count++;
			$f=1;
			$value['name']=addslashes($result->user->name);
			$value['tweet_id']=$result->id;
		
			$value['tweet_text']=$result->user->screen_name . ": " . addslashes($result->text) . "\n";
		
			foreach($word as $w)
			{ 
				//if(stristr($value['tweet_text'], $w) == TRUE)
				if(strpos($value['tweet_text'], $w) == TRUE)
				{
					$flag='bad';$b++;
					//echo 'found in string';
					break;
				}
			
			}
			$value['location']=empty($result->user->location)?'none':addslashes($result->user->location);
			$value['url']=empty($result->user->url)?'none':addslashes($result->user->url);
			$v[]="('" .$aid_id. "','" .$value['name']. "','" .$value['tweet_text']. "','" . $value['created_at']. "','" .$value['location']. "','" .$value['tweet_id']. "','" .$value['url']. "','".$flag."')";
		}//end if
		//else echo "same date time.......";
	}// end foreach
	if($f!=0)
	{
		$ObjectSocial->TwitterCronInsert("c_twitter_tweets",$v);
	}
	$g=$count-$b;

}//end submit
?>



