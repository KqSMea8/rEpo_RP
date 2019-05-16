<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/group.class.php");
$objLead=new lead();
$objGroup=new group();
/*************************/
$arryTicket=$objLead->ListTicket($_GET);
$num=$objLead->numRows();
/*
$pagerLink=$objPager->getPager($arryTicket,$RecordsPerPage,$_GET['curP']);
(count($arryTicket)>0)?($arryTicket=$objPager->getPageRecords()):("");
/*************************/

$filename = "TicketList_".date('d-m-Y').".xls";
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

	$header = "Title\tAssignTo\tStatus\tCreated On";

	$data = '';
	foreach($arryTicket as $key=>$values){
		/* if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }*/
		 //$status=
		 
	
		$AssignTo = '';
		
		if($values['AssignType'] == 'Group') { 
			$arryGrp = $objGroup->getGroup($values['GroupID'],1);
			$AssignTo .= $arryGrp[0]['group_name'];
		} else if(!empty($values['AssignedTo'])){ 
			$assignee = $values['AssignedTo'];
			$arryAssignee = $objLead->GetAssigneeUser($values['AssignedTo']);
			
		    foreach($arryAssignee as $values2) {
			$AssignTo .= $values2['UserName'].', ';
		    }
		}
		$AssignTo = rtrim($AssignTo,", ");
        
 $line = stripslashes($values["title"])."\t".$AssignTo."\t".stripslashes($values["Status"])."\t".date($Config['DateFormat'],strtotime($values["ticketDate"]))."\n";


		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

