<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();


/*************************/
if(!empty($_GET['f']) && !empty($_GET['t'])){
	$arryPayment=$objPurchase->PaymentReport($_GET['f'],$_GET['t'],$_GET['s']);
	$num=$objPurchase->numRows();

	/*$pagerLink=$objPager->getPager($arryPayment,$RecordsPerPage,$_GET['curP']);
	(count($arryPayment)>0)?($arryPayment=$objPager->getPageRecords()):("");*/
}
/*************************/

$filename = "Payment_History_".date('d-m-Y').".xls";
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

	$header = "Payment Date\tPayment Method\tPayment Ref #\tInvoice #\tInvoice Date\tPO #\tOrder Date\tVendor\tAmount\tCurrency";

	$data = '';
	foreach($arryPayment as $key=>$values){
		 
		 
		 $PaymentDate = ($values['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($values['PaymentDate']))):("");
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 $OrderDate = ($values['OrderDate']>0)?(date($Config['DateFormat'], strtotime($values['OrderDate']))):("");

		$line = $PaymentDate."\t".stripslashes($values["Method"])."\t".stripslashes($values["ReferenceNo"])."\t".$values['InvoiceID']."\t".$PostedDate."\t".$values['PurchaseID']."\t".$OrderDate."\t".stripslashes($values["SuppCompany"])."\t".$values['CreditAmnt']."\t".$values['Currency']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

