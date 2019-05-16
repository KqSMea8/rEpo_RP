<?php

include_once("../includes/settings.php");
	
if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}	
	
	$return_arr = array();

 $fetch = "SELECT e.*,d.Department as emp_dep,d.depID from h_employee e inner join  h_department d on e.Department=d.depID  WHERE e.Status=1 and  e.Division in (5,7) and e.UserName LIKE '%".$_GET['q']."%' and  e.locationID='".$_SESSION['locationID'] ."' ORDER BY e.UserName DESC LIMIT 10"; 
$query=mysql_query($fetch);

$MainDir = $Config['FileUploadDir'].$Config['EmployeeDir'];
while ($row = mysql_fetch_array($query)) {
	
    $row_array['id'] = $row['EmpID'];
    $row_array['name'] =$row['UserName'];
	$row_array['department'] = ''; //$row['emp_dep'];
	$row_array['designation'] = $row['JobTitle'];
	
	if($row['Image'] !='' && file_exists($MainDir.$row['Image']) ){ 
		$row_array['url'] ="resizeimage.php?w=50&h=50&img=".$MainDir.$row['Image'];
	}else{
		$row_array['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";

	}
    array_push($return_arr,$row_array);
}

$json_response= json_encode($return_arr);


if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

echo $json_response;


?>
