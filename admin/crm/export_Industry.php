<?php  	
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/group.class.php");
include_once("includes/FieldArray.php");
$objLead=new lead();
$objGroup=new group();

/*************************/
$arryLead=$objLead->LeadReportByRating($_GET);
//echo print_r($arryLead);exit;
$num=$objLead->numRows();

/*$pagerLink=$objPager->getPager($arryLead,$RecordsPerPage,$_GET['curP']);
(count($arryLead)>0)?($arryLead=$objPager->getPageRecords()):("");
/*************************/

$filename = "LeadIndustryList_".date('d-m-Y').".xls";
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

	$header = "Lead Name\tLeadDate\tIndustry\tRating";

	$data = '';$Line=0;
	

	foreach($arryLead as $key=>$values){

	$Line++;
   
    
     /*$arryAssignee = $objLead->GetAssigneeUser($values['AssignTo']);
     
     foreach ($arryAssignee as $values2){
         
        $salesPerson .= $values2['UserName'].",";
     }
     
     $salesPerson = rtrim($salesPerson,',');
    */
     
     

		$line = stripslashes($values["FirstName"]).' '.stripslashes($values["LastName"])." \t".stripslashes($values["LeadDate"])."\t".stripslashes($values["Industry"])."\t".stripslashes($values["Rating"])."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 
        unset($salesPerson);

}else{
	echo "No record found.";
}
exit;
?>


