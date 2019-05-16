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
//$arryQuote=$objQuote->ListQuote('',$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
//echo print_r($_GET);exit;
$arryActivity = $objActivity->GetActivityList($_GET);
if($_GET['flage']==1)
{
$filename = "Event_List_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";
$del="\t";
$delm="\t";
}
else if($_GET['flage']==2)
{
	$filename = "Event_List_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";
	$del=",";
	$delm=",";
}
 
// echo "<pre>";print_r($arryActivity);exit;
/*************************/
$num = $objActivity->numRows();

if($num>0)
{
	

	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type:$contanttype ");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Title $del Activity Type $del Priority $del Created By $del Start Date $del Close Date $del Status";

	$data = '';
	foreach($arryActivity as $key=>$values)
	{
		



	$stdate = $values["startDate"] . " " . $values["startTime"];
		$ctdate = $values["closeDate"] . " " . $values["closeTime"];


		if ($values['created_by'] == 'admin') {
			$created_by = "Admin";                      
		} else {
			$created_by = $values['created'];
		}



		//$line =stripslashes($values["subject"]).$delm.$values['activityType'].$delm.stripslashes($values["priority"]).$delm.stripslashes($created_by).$delm.$stdate.$delm.$ctdate.$delm.stripslashes($values["status"])."\n";

		$line ="\"".$values["subject"]."\"".$delm."\"".$values['activityType']."\"".$delm."\"".stripslashes($values["priority"])."\"".$delm."\"".$created_by."\"".$delm."\"".$stdate."\"".$delm."\"".$ctdate."\"".$delm."\"".stripslashes($values["status"])."\""."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

