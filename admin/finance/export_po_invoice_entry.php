<?php  	
$HideNavigation=1;
include_once("../includes/settings.php");
include_once("../includes/permission.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();


/*************************/
$_GET['InvoiceEntry']=1;
$arryInvoice=$objPurchase->ListInvoice($_GET);
$num=$objPurchase->numRows();

/*$pagerLink=$objPager->getPager($arryInvoice,$RecordsPerPage,$_GET['curP']);
(count($arryInvoice)>0)?($arryInvoice=$objPager->getPageRecords()):("");
/*************************/

$filename = "Vendor_Invoice_Entry".date('d-m-Y').".xls";
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

	$header = "Invoice Date\tInvoice #\tVendor\tAmount\tCurrency\tInvoice Paid";

	$data = '';
	foreach($arryInvoice as $key=>$values){
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 $OrderDate = ($values['OrderDate']>0)?(date($Config['DateFormat'], strtotime($values['OrderDate']))):("");
 		 $PostToGLDate = ($values['PostToGLDate']>0)?(date($Config['DateFormat'], strtotime($values['PostToGLDate']))):("");

		 if($values['InvoicePaid'] ==1){
			  $Paid = 'Paid';   
		 }elseif($values['InvoicePaid'] == 2){
			  $Paid = 'Partially Paid'; 
		 }else{
			  $Paid = 'Unpaid';  
		 }


		$line = $PostedDate."\t".$values['InvoiceID']."\t".stripslashes($values["SuppCompany"])."\t".$values['TotalAmount']."\t".$values['Currency']."\t".$Paid."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

