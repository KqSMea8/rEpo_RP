<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/vendor.class.php");
include_once("includes/FieldArray.php");
$objVendor=new vendor();

/*************************/
$arryVendor=$objVendor->ListVendor($_GET);
$num=$objVendor->numRows();

$pagerLink=$objPager->getPager($arryVendor,$RecordsPerPage,$_GET['curP']);
(count($arryVendor)>0)?($arryVendor=$objPager->getPageRecords()):("");
/*************************/

$filename = "VendorList_".date('d-m-Y').".xls";
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

	$header = "Vendor Code\tVendor Name\tEmail\tCountry\tState\tCity\tStatus";

	$data = '';
	foreach($arryVendor as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$line = $values["VendorCode"]."\t".stripslashes($values["VendorName"])."\t".stripslashes($values["Email"])."\t".stripslashes($values["Country"])."\t".stripslashes($values["State"])."\t".stripslashes($values["City"])."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

