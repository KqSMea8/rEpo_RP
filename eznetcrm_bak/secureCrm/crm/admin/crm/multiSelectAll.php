<?php

include_once("../includes/settings.php");
	
	
	
	$return_arr = array();

 $fetch = "SELECT e.*,d.Department as emp_dep,d.depID from h_employee e left outer join  h_department d on e.Department=d.depID  WHERE e.Status=1 and e.UserName LIKE '%".$_GET['q']."%'  ORDER BY e.UserName DESC LIMIT 10"; 
$query=mysql_query($fetch);

while ($row = mysql_fetch_array($query)) {
	
    $row_array['id'] = $row['EmpID'];
    $row_array['name'] =$row['UserName'];
	$row_array['department'] = ''; //$row['emp_dep'];
	$row_array['designation'] = $row['JobTitle'];
	
	if($row['Image']==''){
$row_array['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
	}else{
	$row_array['url'] ="resizeimage.php?w=50&h=50&img=../hrms/upload/employee/".$_SESSION['CmpID']."/".$row['Image']."";
	}
    array_push($return_arr,$row_array);
}

$json_response= json_encode($return_arr);


if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

echo $json_response;


?>
