<link rel="stylesheet" type="text/css" href="../../css/admin.css">
<link rel="stylesheet" type="text/css" href="../../css/admin-style.css">
<?php
	include_once("../includes/settings.php");
	require_once($Prefix."classes/socialCrm.class.php");

$ObjectSocial =  new socialcrm();

if(isset($_REQUEST['aview_id']))
{
	$aview_id=$_REQUEST['aview_id'];
	//$query="SELECT `tweet_type`, COUNT(*) as t FROM c_twitter_tweets where `alert_id`='$aview_id' GROUP BY `tweet_type`";
	$a=array();
	$resG = $ObjectSocial->TwitterSearch("c_twitter_tweets",'`tweet_type`, COUNT(*) as t',"`alert_id`='$aview_id' GROUP BY `tweet_type`");
	//$qr=mysqli_query($con,$query)or die("not coonected with table..");
	foreach($resG as $row) {$a[]=$row['t'];}//print_r($a);
	$g=$a[0]; $b=$a[1];
}

?>
<?php if($b==NULL){$b=0;}
 		if($g==NULL){$g=0;}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
		  var a=1;
        var data = google.visualization.arrayToDataTable([
          ['Task', 'All Tweets'],
          ['Good Tweets',     <?php echo $g;?>],
          ['Bad Tweets',    <?php echo $b;?>]
        ]);

        var options = {
			backgroundColor: '#f5f9f8',
			//color:'black',
          //title: 'Twitter Tweets Graph',
		  legend: {position: 'bottom'},				//for side box hide view
		  //pieHole: 0.4,
		  is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

<?php  if($b==0 && $g==0)echo "<div align='center' style='color:RED; margin-top:92px;'>no tweets found.</div>";
else{?>
<div id="piechart_3d" style="width: 300px; height: 300px; margin-left:50px;background-color: #fff">
</div><?php }?>
