<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();


require_once($Prefix."classes/warehouse.rma.class.php");
$objWarehouserma = new warehouserma();

$ModuleName = "Return";

/*************************/

$arryReturn=$objWarehouserma->ListReceiptRma($_GET);

$num=$objWarehouserma->numRows();
	

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

	$header = "Receipt Date\tReceipt Number\tInvoice Number\tCustomer Name\tAmount\tCurrency\tReceipt Status";

	$data = '';
	foreach($arryReturn as $key=>$values){
		 $ReceiptDate = ($values['ReceiptDate']>0)?(date($Config['DateFormat'], strtotime($values['ReceiptDate']))):("");

		$line = $ReceiptDate."\t".$values['ReceiptNo']."\t".$values['InvoiceID']."\t".$values['CustomerName']."\t".stripslashes($values["TotalReceiptAmount"])."\t".$values['CustomerCurrency']."\t".$values['ReceiptStatus']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

