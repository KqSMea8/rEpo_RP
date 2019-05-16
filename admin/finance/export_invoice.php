<?php  	
$HideNavigation=1;
include_once("../includes/settings.php");
include_once("../includes/permission.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();



$arrySale=$objSale->ListARInvoice($_GET);
$num=$objSale->numRows();

/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
/*************************/

$filename = "CustomerInvoices_".date('d-m-Y').".xls";
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

	 
	$header = "Invoice Date\tInvoice #\tSO/Reference #\tPO#\tCustomer\tAmount\tCurrency\tStatus";
	$data = '';
	foreach($arrySale as $key=>$values){
		 $InvoiceDate = ($values['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($values['InvoiceDate']))):("");
		 if(!empty($values["CustomerName"])){
			$CustomerName = stripslashes($values["CustomerName"]);
		 }else{
			$CustomerName = stripslashes($values["OrderCustomerName"]);
		 }
	
		if($values['InvoicePaid']=='Unpaid' && $values['PaymentTerm']=='Credit Card' && ($values['OrderPaid']==1 || $values['OrderPaid']==3 || $values['OrderPaid']==4)){	 
			 $values['InvoicePaid'] = 'Credit Card';
		}


		$line = $InvoiceDate."\t".$values["InvoiceID"]."\t".$values['SaleID']."\t".$values['CustomerPO']."\t".$CustomerName."\t".$values['TotalInvoiceAmount']."\t".$values['CustomerCurrency']."\t".stripslashes($values["InvoicePaid"])."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

