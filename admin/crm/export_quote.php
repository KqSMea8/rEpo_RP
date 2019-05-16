<?php 
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/quote.class.php");
include_once("includes/FieldArray.php");
$objQuote=new quote();

/*************************/

$arryQuote=$objQuote->ListQuote('',$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);

/*************************/
$num=$objQuote->numRows();
$filename = "Quote_List_".date('d-m-Y').".xls";


if($_GET['flage']==1)
{
$filename = "Quote_List_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";
$del="\t";
$delm="\t";
$Comma="";
}
else if($_GET['flage']==2)
{
	$filename = "Quote_List_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";

	$delm=",";
	$Comma='"';
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
	header("Content-Type: $contanttype");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Subject $delm Quote Stage $delm Opportunity Name $delm Valid Till $delm Total $delm Created Date";

	$data = '';
	foreach($arryQuote as $key=>$values)
	{	 
$total_ammount= stripslashes($values["TotalAmount"]) ." ".$values['CustomerCurrency'];
$validtill = ($values['validtill']>0)?(date($Config['DateFormat'], strtotime($values['validtill']))):(" ");
$PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):(" ");;
//$PostedDate = date($Config['DateFormat'] , strtotime($values["PostedDate"]));

//$validtill =$values["validtill"];
//$PostedDate =$values["PostedDate"];

                // $assignee = stripslashes($values["UserName"]) .$Comma.$values["Department"]; // Abid
		$line = "\"".stripslashes($values["subject"])."\"".$delm."\"".stripslashes($values['quotestage'])."\"".$delm."\"".stripslashes($values["opportunityName"])."\"".$delm."\"".$validtill."\"".$delm."\"".$total_ammount."\"".$delm."\"".$PostedDate."\""."\n";

		$data .= trim($line)."\n";
		
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

