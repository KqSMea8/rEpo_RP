<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/lead.class.php");
$objLead=new lead();

/*************************/
$arryOpportunity=$objLead->ListOpportunity('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objLead->numRows();

/*$pagerLink=$objPager->getPager($arryOpportunity,$RecordsPerPage,$_GET['curP']);
(count($arryOpportunity)>0)?($arryOpportunity=$objPager->getPageRecords()):("");
/*************************/

$filename = "Opportunity_List_".date('d-m-Y').".xls";
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

	
	$header = "Opportunity Name\tSales Stage\tLead Source\tCreated Date\tExpected Close Date\tAssign TO\tStatus";

	$data = '';
	foreach($arryOpportunity as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
$UserName=$values["FirstName"]." ".$values["LastName"];
		//$line = 	$values["OpportunityID"]."\t".$values["LeadID"]."\t".stripslashes($values['OpportunityName'])."\t".stripslashes($values['SalesStage'])."\t".stripslashes($values['lead_source'])."\t".date($Config['DateFormat'],strtotime($values["CloseDate"]))."\t".stripslashes($values["AssignTo"])."\t".$status."\n";

		$line = 
			stripslashes($values['OpportunityName'])."\t".stripslashes($values['SalesStage'])."\t".stripslashes($values['lead_source'])."\t".date($Config['DateFormat'],strtotime($values["AddedDate"]))."\t".date($Config['DateFormat'],strtotime($values["CloseDate"]))."\t".stripslashes($values["AssignTo"])."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

