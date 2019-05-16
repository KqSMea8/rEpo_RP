<?php

include_once("../includes/settings.php");
	
	
 $return_arr = array();
 $fetch = "SELECT e.*,d.Department as emp_dep,d.depID from h_employee e left outer join  h_department d on e.Department=d.depID  WHERE e.Status=1 and e.Division in (5) and e.UserName LIKE '%".$_GET['q']."%' and  e.locationID=".$_SESSION['locationID'] ." ORDER BY e.UserName DESC LIMIT 10"; 
 $query=mysql_query($fetch);

  //array_push($return_arr, array('id'=> 0 ,'name'=> $_GET["q"],'department'=>'','designation'=>''));
while ($row = mysql_fetch_array($query)) {
	
    $row_array['id'] = $row['EmpID'];
    $row_array['name'] =$row['UserName'];
	//$row_array['department'] = ''; //$row['emp_dep'];
	//$row_array['designation'] = '';
	
	
    array_push($return_arr,$row_array);
}

foreach ($return_arr as $k => $v) {
  $tArray[$k] = $v['id'];
}
 $max_value = max($tArray);
 
 array_push($return_arr,array('id'=>mt_rand(1000,100000),'name'=>$_GET[q]));

//print_r($return_arr);
 //array_push($return_arr,array('name'=>$_GET[q]));

$json_response= json_encode($return_arr);


if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

echo $json_response;


?>