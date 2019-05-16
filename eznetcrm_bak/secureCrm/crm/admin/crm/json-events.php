<?php

include_once("../includes/settings.php");
require_once($Prefix."classes/event.class.php");
$objActivity=new activity();

	$year = date('Y');
	$month = date('m');
	
	$arrayEvent = $objActivity->ListActivity('','','','','','');
	$return_arr = array();
/*
$strAddQuery = ($Config['vAllRecord']!=1)?(" and (e.assignedTo like '%".$_SESSION['AdminID']."%' OR e.created_id='".$_SESSION['AdminID']."') "):("");

$fetch = mysql_query("select e.* from c_activity e   where 1 ".$strAddQuery."  order by e.activityID"); 
*/

foreach ($arrayEvent as $values) {
    $row_array['id'] = $values['activityID'];
    $row_array['title'] = $values['subject'];

	if($values['startTime']!='00:00:00' && $values['closeTime']!='00:00:00'){
    $row_array['start'] = $values['startDate'].' '.$values['startTime'];
	$row_array['end'] = $values['closeDate'].' '.$values['closeTime'];
	}else{
 $row_array['start'] = $values['startDate'];
 $row_array['end'] = $values['closeDate'];
	}
	if($values['activityType']=="Task"){
	$row_array['url'] = "vActivity.php?view=".$values['activityID']."&module=Activity&mode=".$values['activityType']."&tab=Activity";
     }else{
	 $row_array['url'] = "vActivity.php?view=".$values['activityID']."&module=Activity&mode=Event&tab=Activity";
	 }
    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);


	
	
	

	




?>
