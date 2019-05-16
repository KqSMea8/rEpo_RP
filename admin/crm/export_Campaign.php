<?php  	
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/lead.class.php");
include_once("includes/FieldArray.php");
$objLead=new lead();

/*************************/
$arryCampaign=$objLead->ListCampaign('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objLead->numRows();

$pagerLink=$objPager->getPager($arryCampaign,$RecordsPerPage,$_GET['curP']);
(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");
/*************************/

//$filename = "Campaign_List_".date('d-m-Y').".xls";

if($_GET['flage']==1)
{
$filename = "Campaign_List_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";

$delm="\t";
}
else if($_GET['flage']==2)
{
	$filename = "Campaign_List_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";

	$delm=",";
}
else if($_GET['flage']==3)
{
	
	$filename = "Documents_".date('d-m-Y').".doc";
	$contanttype="application/vnd.ms-word";

	$delm="\t";
}


if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type:$contanttype");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Campaign Name $delm Campaign Type $delm Campaign Status $delm Expected Revenue $delm Expected Close Date $delm Assign To";

	$data = '';
	foreach($arryCampaign as $key=>$values)
	{
		
		 /*if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 } */ 
//$UserName=$values["campaigntype"]." ".$values["LastName"];

		  $closingdate= ($values['closingdate']>0)?(date($_SESSION['DateFormat'], strtotime($values["closingdate"]))):(" ");
		 
		 
		$line = 
			"\"".$values["campaignname"]."\"".$delm."\"".stripslashes($values["campaigntype"])."\"".$delm."\"".stripslashes($values['campaignstatus'])."\"".$delm."\"".stripslashes($values["expectedrevenue"])."\"".$delm."\"".$closingdate."\"".$delm."\"".$values["AssignTo"]."\""."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

