<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/quote.class.php");
$objQuote=new quote();

/*************************/
$arryQuote=$objQuote->ListQuote('',$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);

/*************************/
$num=$objQuote->numRows();
$filename = "Quote_List_".date('d-m-Y').".xls";
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

	$header = "Subject\tQuote Stage \tOpportunity Name\tValid Till\tTotal\tCreated Date";

	$data = '';
	foreach($arryQuote as $key=>$values){
		

$total_ammount= stripslashes($values["TotalAmount"]) ." ".$Config['Currency'];
$validtill = date($Config['DateFormat'] , strtotime($values["validtill"]));
$PostedDate = date($Config['DateFormat'] , strtotime($values["PostedDate"]));

$assignee = stripslashes($values["UserName"]) ."- ".$values["Department"];
		$line = stripslashes($values["subject"])."\t".stripslashes($values['quotestage'])."\t".stripslashes($values["opportunityName"])."\t".$validtill."\t".$total_ammount."\t".$PostedDate."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

