<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();

require_once($Prefix."classes/warehouse.purchase.rma.class.php");
$objWarehouse = new warehouse();

/*************************/
$arryReturn=$objWarehouse->ListPurchaseReceipt($_GET);
$num=$objWarehouse->numRows();

/*$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
/*************************/

$filename = "RMA_Return_".date('d-m-Y').".xls";
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

	$header = "Receipt Date\tReceipt Number\tRMA Number\tInvoice Number\tVendor\tAmount\tCurrency\tReceipt Status";

	$data = '';
	foreach($arryReturn as $key=>$values){
		 $ReceiptDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 if(!empty($values["VendorName"])){
			$VendorName = $values["VendorName"];
		}else{
			$VendorName = $values["SuppCompany"];
		}


		$line = $ReceiptDate."\t".$values['ReceiptNo']."\t".$values['ReturnID']."\t".$values['InvoiceID']."\t".stripslashes($VendorName)."\t".$values['TotalReceiptAmount']."\t".$values['Currency']."\t".$values['ReceiptStatus']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

