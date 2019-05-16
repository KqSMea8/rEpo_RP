<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/bom.class.php");
$objBom=new bom();

/*************************/
	
#echo "bhoodev"; exit;
	 $arryBOM = $objBom->ListBOM('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status']);
         $num=$objBom->numRows();
	 $pagerLink=$objPager->getPager($arryBOM,$RecordsPerPage,$_GET['curP']);
	(count($arryBOM)>0)?($arryBOM=$objPager->getPageRecords()):(""); 

/*************************/

$filename = "bom_Order_Report_".date('d-m-Y').".xls";
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

	$header = "Bill Number\t Description\tBill With Option\tBill Date";

	$data = '';
	foreach($arryBOM as $key=>$values){
		 $bomDate = ($values['bomDate']>0)?(date($Config['DateFormat'] , strtotime($values['bomDate']))):("");
		

		$line = $values["Sku"]."\t".stripslashes($values["description"])."\t".$values['bill_option'].'\t '.$bomDate."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

