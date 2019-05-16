<html>
<head>
<title>Show / Add Events</title>
</head>
<body>
<h1>Show / Add Events</h1>
<?php
$mysql = mysql_connect("localhost", "root", "root123");
mysql_select_db("test", $mysql) or die(mysql_error());

// Add our new events
if ($_POST){
	$m = $_POST['m'];
	$d = $_POST['d'];
	$y = $_POST['y'];

	// Formatting for SQL datetime (if this is edited, it will NOT work.)
	$event_date = $y."-".$m."-".$d." ".$_POST["event_time_hh"].":".$_POST["event_time_mm"].":00";

	$insEvent_sql = "INSERT INTO calendar_events (event_title,
			event_shortdesc, event_start) VALUES('
			".$_POST["event_title"]."',
			'".$_POST["event_shortdesc"]."', '$event_date')";
	$insEvent_res = mysql_query($insEvent_sql, $mysql)
			or die(mysql_error($mysql));
} else {
	$m = $_GET['m'];
	$d = $_GET['d'];
	$y = $_GET['y'];
}
// Show the events for this day:
$getEvent_sql = "SELECT event_title, event_shortdesc,
		date_format(event_start, '%l:%i %p') as fmt_date FROM
		calendar_events WHERE month(event_start) = '".$m."'
		AND dayofmonth(event_start) = '".$d."' AND
		year(event_start)= '".$y."' ORDER BY event_start";
$getEvent_res = mysql_query($getEvent_sql, $mysql)
		or die(mysql_error($mysql));

if (mysql_num_rows($getEvent_res) > 0){
	$event_txt = "<ul>";
	while($ev = @mysql_fetch_array($getEvent_res)){
		$event_title = stripslashes($ev["event_title"]);
		$event_shortdesc = stripslashes($ev["event_shortdesc"]);
		$fmt_date = $ev["fmt_date"];
		$event_txt .= "<li><strong>".$fmt_date."</strong>:
			      ".$event_title."<br/>".$event_shortdesc."</li>";
	}
	$event_txt .="</ul>";
	mysql_free_result($getEvent_res);
} else {
	$event_txt = "";
}

mysql_close($mysql);

if ($event_txt != ""){
	echo "<p><strong>Today's Events:</strong></p>
	$event_txt
	<hr/>";
}

// Show form for adding the event:

echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
<p><strong>Add Event:</strong><br/>
Complete the form below then press the submit button when you are done.</p>
<p><strong>Event Title:</strong><br/>
<input type=\"text\" name=\"event_title\" size=\"25\" maxlength=\"25\"/></p>
<p><strong>Event Description:</strong<br/>
<input type=\"text\" name=\"event_shortdesc\" size=\"25\" maxlength=\"255\"/></p>
<p><strong>Event Time (hh:mm):</strong><br/>
<select name=\"event_time_hh\">";
for ($x=1; $x<=24; $x++){
	echo "<option value=\"$x\">$x</option>";
}
echo "</select> :

<select name=\"event_time_mm\">
<option value=\"00\">00</option>
<option value=\"15\">15</option>
<option value=\"30\">30</option>
<option value=\"45\">45</option>
</select>

<input type=\"hidden\" name=\"m\" value=\"".$m."\">
<input type=\"hidden\" name=\"d\" value=\"".$d."\">
<input type=\"hidden\" name=\"y\" value=\"".$y."\">
<br/><br/>
<input type=\"submit\" name=\"submit\" value=\"Add Event!\">
</form>";
?>
</body>
</html>

