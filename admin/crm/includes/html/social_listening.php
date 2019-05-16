<b>Twitter Listening</b>
 <a class="fancybox add_quick fblogut" href="twitter_keywords.php" style="float: right;">Keywords</a>
    <a class="fancybox add_quick fblogut" href="twitter_alerts.php" style="float: right;">Alerts</a>
<a class="fancybox add_quick fblogut" href="<?php echo _SiteUrl?>admin/crm/twitter_lists.php" style="float: right;">Tweets List</a>

<?php
	//error_reporting(-1);
	//echo $g=1; echo $b=4;
	$a=array();
	//require "twitter_search/db.php";
	//if(!$con)echo "not connect";else echo "conneted";
	//$query="SELECT `tweet_type`, COUNT(*) as t FROM c_twitter_tweets WHERE `alert_id` != 'NULL' GROUP BY `tweet_type`";
	//echo $query;
	//$qr=mysqli_query($con,$query)or die("not coonected with table..");
	foreach($res_alert as $row) {$a[]=$row['t'];}//print_r($a);

	$g=$a[0];$b=$a[1];
	if($b==NULL){$b=0;}
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
          ['Overall Good Tweets',     <?php echo $g;?>],
          ['Overall Bad Tweets',    <?php echo $b;?>]
         /* ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]*/
        ]);

        var options = {
          //title: 'Twitter Tweets Graph',
		  legend: {position: 'bottom'},				//for side box hide view
		  //pieSliceText: 'label',		//for text show in chart
		  //pieStartAngle: 100,
		  //sliceVisibilityThreshold: .2
		  //slices: {  4: {offset: 0.2},12: {offset: 0.3},14: {offset: 0.4},15: {offset: 0.5},},
          is3D: true,
		  //pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

  <body>
  <center>
  <?php if($b==0 && $g==0)echo '<span style=" color:red;margin-top: 9%;display: inline-block;">No Tweets</span>';?>
    <div id="piechart_3d" style="width: 500px; height: 400px;"></div>
   </center>