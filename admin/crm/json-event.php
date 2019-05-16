<?php
/**************************************************/
$ThisPageName = 'viewActivity.php?module=Activity';
/**************************************************/
include_once("../includes/settings.php");
include_once("../includes/permission.php");
require_once($Prefix."classes/event.class.php");
$objActivity=new activity();

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

$year = date('Y');
$month = date('m');

$arrayEvent = $objActivity->ListActivity('','','','','','');
$return_arr = array();


foreach ($arrayEvent as $values) {
	$row_array['id'] = $values['activityID'];
	$row_array['title'] = $values['subject'];
	$row_array['start'] = $values['startDate'];

	/*if($values['startTime']!='00:00:00' && $values['closeTime']!='00:00:00'){
		$row_array['start'] = $values['startDate'].' '.$values['startTime'];
		$row_array['end'] = $values['closeDate'].' '.$values['closeTime'];
	}else{
		$row_array['start'] = $values['startDate'];
		$row_array['end'] = $values['closeDate'];
	}*/
	if($values['activityType']=="Task"){
		$row_array['url'] = "vActivity.php?view=".$values['activityID']."&module=Activity&mode=".$values['activityType']."&tab=Activity&pop=1";
	}else{
		$row_array['url'] = "vActivity.php?view=".$values['activityID']."&module=Activity&mode=Event&tab=Activity&pop=1";
	}
	array_push($return_arr,$row_array);
}

echo json_encode($return_arr);


	
	
	

	




?>
