<link rel="stylesheet" type="text/css" href="../../css/admin.css">
<link rel="stylesheet" type="text/css" href="../../css/admin-style.css">
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


if(isset($_REQUEST['a_name']))//if(isset($_REQUEST['submit']))
{
	$sq=$_REQUEST['a_name'];
	$aid_id=$_REQUEST['aid_id'];
	$count=0; 
	$b=0; 
	$g=0;
	//echo "<script>confirm('heloo');<script>";
	//$sq=$row['alert_name'];
	//$sq=$_REQUEST['sq'];
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
	
	echo " <div class='had'>Tweets of:<span style=' color:green; margin-left:5px; font-weight:bold;'>$sq</span></div>";
	echo "<table border='1' cellspacing='1' cellpadding='3' width='100%' align='center' id='list_table' >";
	echo "<tr><th class='head' width='40px'>Name</th><th class='head' width='200px'>Tweets</th><th class='head' width='40px'>Location</th><th class='head' width='40px'>Tweet Type</th></tr>";
	
	foreach($results->statuses as $result) 
	{ 
		$flag='good';
		$str=$result->created_at;
		$date = date_create($str);
	 	$time = date_format($date, 'Y-m-d H:i:s');//echo '<br>';
		
		//echo $value['date']=$dt." ".$time;
		//$value['date']=$dt;
		$value['created_at']=$time;
		//echo $value['date'];*/
		echo "<tr>";
		if($fr[0]['f']<$value['created_at'] or $fr[0]['f']==0)
		{
			$count++;
			$f=1;
			//echo "<tr><td>".$value['date']."</td>";
			echo "<td align='center'>".$value['name']=addslashes($result->user->name);echo "</td>";
			/*echo "<td>".*/$value['tweet_id']=$result->id;
			//echo "</td>";
			echo "<td style='text-align:justify'>".$value['tweet_text']=$result->user->screen_name . ": " . addslashes($result->text) . "\n";echo '</td>';
		
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
			echo "<td align='center'>".$value['location']=empty($result->user->location)?'none':addslashes($result->user->location);echo '</td>';
			if($flag=='bad')echo "<td align='center' style='color:RED;text-transform:capitalize;'>".$flag."</td>";
			else echo "<td  align='center' style='color:#0F0;text-transform:capitalize;'>".$flag."</td>";
			$value['url']=empty($result->user->url)?'none':addslashes($result->user->url);
			echo '</tr>';
			$v[]="('" .$aid_id. "','" .$value['name']. "','" .$value['tweet_text']. "','" . $value['created_at']. "','" .$value['location']. "','" .$value['tweet_id']. "','" .$value['url']. "','".$flag."')";
		}//end if
		//else echo "same date time.......";
	}// end foreach
	if($f==0)
	{
		//echo "<tr><th align=center style=' color:RED;'>No new tweets found....</th></tr>";
		$error_msg="No new tweets found..";
		echo "</table>";
		$g=$b=0;
	}
	else{
	$ObjectSocial->TwitterCronInsert("c_twitter_tweets",$v);
	echo "</table>";
	}
	//$query="insert into `c_twitter_tweets`(`alert_id`,`name`,`tweet_text`,`created_at`,`location`,`tweet_id`,`url`,`tweet_type`) values". implode(',',$v);
	//print_r($query);
	//$c=mysqli_query($con,$query);
	/*if($c)echo "<script>alert('hello  C')<script>";
	print $count;*/
	$g=$count-$b;
?>
	<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script-->
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	 
      function drawChart() 
	  {
		  var a=1;
        var data = google.visualization.arrayToDataTable([
          ['Task', 'All Tweets'],
          ['Good Tweets',     <?php echo $g;?>],
          ['Bad Tweets',    <?php echo $b;?>]
		  ]);

        var options = {
          //title: 'Twitter Tweets Graph',
		  backgroundColor: '#f5f9f8',
		  legend: {position: 'bottom'},	//for side box hide view   
		  //pieSliceText: 'label',	//for text show in chart   //pieStartAngle: 100,  //sliceVisibilityThreshold: .2
		  //slices: {  4: {offset: 0.2},12: {offset: 0.3},14: {offset: 0.4},15: {offset: 0.5},}, //
		  is3D: true,
		  //pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
    <center>
    <?php  if($f==0)
	{ echo "<div class='red'>".$error_msg."</div>";
	}else{?>
    
    <!--div style=" border:1px; border-color:#999; border:solid; width:40%;"-->
    <div id="piechart_3d" style="width: 300px; height: 300px; margin-left:50px;background-color: #fff;"></div>
	<!--label style=" color:#0F0">Good Tweets:<?php /*echo $g;?></label><br/><label style=" color:#F00">Bad Tweets:<?php echo $b;?></label>
	<br/> <label style=" color:#009">Total Tweets:<?php echo $count;*/?></label-->
    
<?php
	}echo "</center>";
}//end submit
?>

