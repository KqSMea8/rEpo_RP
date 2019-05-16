<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();


/*************************/
$arryReturn=$objPurchase->ListCreditNoteRMA($_GET);
$num=$objPurchase->numRows();

/*$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
/*************************/

//$filename = "PO_Return_".date('d-m-Y').".xls";
$filename = "RMA.xls";
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

	$header = "RMA Date\tRMA Type\tRMA Number\tInvoice Number\tExpiry Date\tVendor\tAmount\tCurrency\tAmount Paid";

	$data = '';
	foreach($arryReturn as $key=>$values){
		$RmaType = $values['Module'];
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 $OrderDate = ($values['OrderDate']>0)?(date($Config['DateFormat'], strtotime($values['OrderDate']))):("");
		 $InvoicePaid = ($values['InvoicePaid']==1)?("Yes"):("No");

		$line = $PostedDate.$RmaType."\t".$values['ReturnID']."\t".$values['InvoiceID']."\t".$OrderDate."\t".stripslashes($values["SuppCompany"])."\t".$values['TotalAmount']."\t".$values['Currency']."\t".$InvoicePaid."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

