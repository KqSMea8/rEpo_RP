<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();


/*************************/
if(!empty($_GET['f']) && !empty($_GET['t'])){
	$arryInvoice=$objPurchase->InvoiceReport($_GET['f'],$_GET['t'],$_GET['s'],$_GET['p']);
	$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryInvoice,$RecordsPerPage,$_GET['curP']);
	(count($arryInvoice)>0)?($arryInvoice=$objPager->getPageRecords()):("");
}
/*************************/

$filename = "Invoice_Report_".date('d-m-Y').".xls";
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

	$header = "Invoice Number\tInvoice Date\tPO Number\tOrder Date\tVendor\tAmount\tCurrency\tInvoice Paid";

	$data = '';
	foreach($arryInvoice as $key=>$values){
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 $OrderDate = ($values['OrderDate']>0)?(date($Config['DateFormat'], strtotime($values['OrderDate']))):("");
		 $InvoicePaid = ($values['InvoicePaid']==1)?("Yes"):("No");

		$line = $values['InvoiceID']."\t".$PostedDate."\t".$values['PurchaseID']."\t".$OrderDate."\t".stripslashes($values["SuppCompany"])."\t".$values['TotalAmount']."\t".$values['Currency']."\t".$InvoicePaid."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

