<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/rma.purchase.class.php");
$objPurchase = new purchase();


/*************************/
$arryReturn=$objPurchase->ListReturnRMA($_GET);
$num=$objPurchase->numRows();

/*$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
/*************************/

$filename = "RMA_".date('d-m-Y').".xls";

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

	$header = "RMA Date\tRMA Number\tInvoice Number\tInvoice Date\tVendor\tAmount\tCurrency";

	$data = '';
	foreach($arryReturn as $key=>$values){
		
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 $InvoiceDate = ($values['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($values['InvoiceDate']))):("");
		if(!empty($values["VendorName"])){
			$VendorName = $values["VendorName"];
		}else{
			$VendorName = $values["SuppCompany"];
		}

		$line = $PostedDate."\t".$values['ReturnID']."\t".$values['InvoiceID']."\t".$InvoiceDate."\t".stripslashes($VendorName)."\t".$values['TotalAmount']."\t".$values['Currency']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

