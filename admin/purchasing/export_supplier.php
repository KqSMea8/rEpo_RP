<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/supplier.class.php");
$objSupplier=new supplier();

/*************************/
$arrySupplier=$objSupplier->ListSupplier($_GET);
$num=$objSupplier->numRows();

/*$pagerLink=$objPager->getPager($arrySupplier,$RecordsPerPage,$_GET['curP']);
(count($arrySupplier)>0)?($arrySupplier=$objPager->getPageRecords()):("");
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

	$header = "Vendor Code\tCompany Name\tCountry\tState\tCity\tCurrency\tStatus";

	$data = '';
	foreach($arrySupplier as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$line = $values["SuppCode"]."\t".stripslashes($values["CompanyName"])."\t".stripslashes($values["Country"])."\t".stripslashes($values["State"])."\t".stripslashes($values["City"])."\t".$values["Currency"]."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

