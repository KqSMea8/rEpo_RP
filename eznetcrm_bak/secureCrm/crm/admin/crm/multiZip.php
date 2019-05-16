<?php

include_once("../includes/settings.php");
	
/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/	
	
$return_arr = array();

$fetch = "SELECT * from city where state_id=".$_GET['state_id']; 
$query=mysql_query($fetch);

while ($row = mysql_fetch_array($query)) {	
    $row_array['id'] = $row['city_id'];
    $row_array['name'] =$row['name'];	
    array_push($return_arr,$row_array);
}

$json_response= json_encode($return_arr);


if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

echo $json_response;


?>
