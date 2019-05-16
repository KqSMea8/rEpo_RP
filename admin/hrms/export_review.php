<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/performance.class.php");
include_once("includes/FieldArray.php");
$objPerformance=new performance();

/*************************/
$arryReview=$objPerformance->ListReview('',$_GET['key'],$_GET['sortby'],$_GET['FromDate'],$_GET['ToDate'],$_GET['asc']);
$num=$objPerformance->numRows();


$pagerLink=$objPager->getPager($arryReview,$RecordsPerPage,$_GET['curP']);
(count($arryReview)>0)?($arryReview=$objPager->getPageRecords()):("");
/*************************/

$filename = "ReviewList_".date('d-m-Y').".xls";
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

	$header = "Employee\tJob Title\tReview From\tReview To\tReviewer\tStatus";

	$data = '';
	foreach($arryReview as $key=>$values){

		$FromDate = ($values["FromDate"]>0)?(date($Config['DateFormat'], strtotime($values["FromDate"]))):(""); 
		$ToDate = ($values["ToDate"]>0)?(date($Config['DateFormat'], strtotime($values["ToDate"]))):(""); 

		$line = stripslashes($values["UserName"])."\t".stripslashes($values['JobTitle'])."\t".$FromDate."\t".$ToDate."\t".stripslashes($values['ReviewerName'])."\t".$values["Status"]."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

