<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/lead.class.php");
$objLead=new lead();

/*************************/
$arryCampaign=$objLead->ListCampaign('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objLead->numRows();

$pagerLink=$objPager->getPager($arryCampaign,$RecordsPerPage,$_GET['curP']);
(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");
/*************************/

$filename = "Campaign_List_".date('d-m-Y').".xls";
if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Campaign Name\tCampaign Type\tCampaign Status\tExpected Revenue\tExpected Close Date\tAssign To";

	$data = '';
	foreach($arryCampaign as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
//$UserName=$values["campaigntype"]." ".$values["LastName"];
		$line = 
			$values["campaignname"]."\t".stripslashes($values["campaigntype"])."\t".stripslashes($values['campaignstatus'])."\t".stripslashes($values["expectedrevenue"])."\t".$values["closingdate"]."\t".$values["AssignTo"]."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

