<?php

include_once("../includes/settings.php");
	
	
	
	$return_arr = array();

 $fetch = "SELECT e.*,d.Department as emp_dep,d.depID from h_employee e left outer join  department d on e.Department=d.depID  WHERE e.UserName LIKE '".$_GET['q']."%'  and e.locationID=".$_SESSION['locationID']." ORDER BY e.UserName Asc LIMIT 20"; 
$query=mysql_query($fetch);

while ($row = mysql_fetch_array($query)) {
	
    $row_array['id'] = $row['EmpID'];
    $row_array['name'] =$row['UserName'];
	$row_array['department'] =$row['emp_dep'];
	$row_array['designation'] = $row['JobTitle'];
	
	if($row['Image']==''){
$row_array['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
	}else{
	$row_array['url'] ="resizeimage.php?w=50&h=50&img=upload/employee/".$row['Image']."";
	}
    array_push($return_arr,$row_array);
}

$json_response= json_encode($return_arr);


if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

echo $json_response;


?>
