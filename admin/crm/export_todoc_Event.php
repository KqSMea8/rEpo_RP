<?php
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix . "classes/event.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/lead.class.php");
include_once("includes/FieldArray.php");
//require_once("includes/RightFieldArray.php");
$ModuleName = $_GET['module'];
$objActivity = new activity();
$objCommon = new common();
$objFilter = new filter();
$objLead = new lead();
/*************************/
$arryActivity = $objActivity->GetActivityList($_GET);

//echo "<pre>";print_r($arryActivity);

$num=$objActivity->numRows();
$filename = "EventList_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");



echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="2" width="100%">';


echo '<tr align="left"><th>Title</th><th>Activity Type</th><th>Priority</th><th>Created By</th><th>Start Date</th><th>Close Date</th><th>Status</th></tr>';

if($num>0)
{
foreach($arryActivity as $key=>$values)
	{
		$stdate = $values["startDate"] . " " . $values["startTime"];
		$ctdate = $values["closeDate"] . " " . $values["closeTime"];


		if ($values['created_by'] == 'admin')
		 {
			$created_by = "Admin";                      
		} 
		else
		 {
			$created_by = $values['created'];
		 }
	
	
echo '<tr><td>'.$values['subject'].'</td><td>'.$values['activityType'].'</td><td>'.$values['priority'].'</td><td>'.$created_by.'</td><td>'.$stdate.'</td><td>'.$ctdate.'</td><td>'.$values["status"].'</td></tr>';	
}
}
echo '</table>';
echo "</body>";
echo "</html>";

?>
