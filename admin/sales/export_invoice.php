<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();

$_GET['module'] = 'Invoice';
$module = $_GET['module'];
$ModuleName = $_GET['module'];
$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
/*************************/
$arrySale=$objSale->ListSale($_GET);
$num=$objSale->numRows();

/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
/*************************/

$filename = $ModuleName."_".date('d-m-Y').".xls";
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

	$header = "Invoice Date\tInvoice Number\tSO Number\tSales Person\tCustomer\tAmount\tCurrency\tStatus";

	$data = '';
	foreach($arrySale as $key=>$values){
		 $InvoiceDate = ($values['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($values['InvoiceDate']))):("");
		 $Approved = ($values['Approved']==1)?("Yes"):("No");

		$line = $InvoiceDate."\t".$values[$ModuleID]."\t".$values['SaleID']."\t".stripslashes($values["SalesPerson"])."\t".stripslashes($values["CustomerName"])."\t".$values['TotalAmount']."\t".$values['CustomerCurrency']."\t".stripslashes($values["InvoicePaid"])."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

