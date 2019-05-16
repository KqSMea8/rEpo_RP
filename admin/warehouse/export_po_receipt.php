<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();


/*************************/
$arryReceipt=$objPurchase->ListReceipt($_GET);
$num=$objPurchase->numRows();

/*$pagerLink=$objPager->getPager($arryReceipt,$RecordsPerPage,$_GET['curP']);
(count($arryReceipt)>0)?($arryReceipt=$objPager->getPageRecords()):("");
/*************************/

$filename = "Purchase_Receipt_".date('d-m-Y').".xls";
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

	$header = "Receipt Date\tReceipt Number\tPO/Reference #\tVendor\tPosted By\tAmount\tCurrency\tReceipt Status";

	$data = '';
	foreach($arryReceipt as $key=>$values){
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		if($values["AdminType"]=='employee') {
			$PostedBy = stripslashes($values["PostedBy"]);
		}else {
			$PostedBy = $values["PostedBy"];
		}
		if(!empty($values["VendorName"])){
			$VendorName = $values["VendorName"];
		}else{
			$VendorName = $values["SuppCompany"];
		}

		$line = $PostedDate."\t".$values['ReceiptID']."\t".$values['PurchaseID']."\t".stripslashes($VendorName)."\t".$PostedBy."\t".$values['TotalAmount']."\t".$values['Currency']."\t".$values['ReceiptStatus']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

