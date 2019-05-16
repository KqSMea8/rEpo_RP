<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/reseller.class.php");		
$objSale = new sale();
$objReseller=new reseller();

/*************************/
if(!empty($_GET['f']) && !empty($_GET['t']) && !empty($_GET['s'])){
	$arryPayment=$objReseller->PaymentReport($_GET['f'],$_GET['t'],$_GET['s']);
	$num=$objReseller->numRows();

	$pagerLink=$objPager->getPager($arryPayment,$RecordsPerPage,$_GET['curP']);
	(count($arryPayment)>0)?($arryPayment=$objPager->getPageRecords()):("");
}
/*************************/

/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
$arryReseller = $objReseller->GetReseller($_GET['s'],'');
$ResellerName = str_replace(" ","_",$arryReseller[0]['FullName']);
$filename = "SalesbyReseller_".$ResellerName."_".date('d-m-Y').".xls";
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

	$header = "Payment Date\tPayment Method\tPayment Ref #\tInvoice #\tInvoice Date\tCustomer\tAmount";

	$data = '';
	foreach($arryPayment as $key=>$values){		 
		 
		 $PaymentDate = ($values['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($values['PaymentDate']))):("");
		 $InvoiceDate = ($values['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($values['InvoiceDate']))):("");
		
		$line = $PaymentDate."\t".stripslashes($values["Method"])."\t".stripslashes($values["ReferenceNo"])."\t".$values['InvoiceID']."\t".$InvoiceDate."\t".stripslashes($values["CustomerName"])."\t".$values['DebitAmnt'].' '.$values['Currency']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

