<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
include_once("includes/FieldArray.php");
$objSale = new sale();

(!$_GET['module'])?($_GET['module']='Quote'):(""); 
$module = $_GET['module'];

$ModuleName = "Sale".$_GET['module'];


if($_GET['module']=='Quote'){	
	$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";
}elseif($_GET['module']=='Invoice'){	
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
}else{
	$ModuleIDTitle = "SO Number"; $ModuleID= "SaleID";
}
/*************************/
if($Config['batchmgmt']==1){
	$arrySale=$objSale->ListSale($_GET);
}else{
	$arrySale=$objSale->ListSaleOrdersOnly($_GET);
}
$num=$objSale->numRows();

/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
/*************************/

$filename = $module."_".date('d-m-Y').".xls";
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

	$header = "Order Date\t".$ModuleIDTitle."\tCustomer\tSales Person\tAmount\tCurrency\tStatus";

	$data = '';
	foreach($arrySale as $key=>$values){
		$ddate = $module.'Date';
		 $OrderDate = ($values['OrderDate']>0)?(date($Config['DateFormat'], strtotime($values['OrderDate']))):("");
		 //$Approved = ($values['Approved']==1)?("Yes"):("No");


		$OrderStatus = $objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
		$OrderStatus = strip_tags($OrderStatus);



		$line = $OrderDate."\t".$values[$ModuleID]."\t".stripslashes($values["CustomerName"])."\t".stripslashes($values["SalesPerson"])."\t".$values['TotalAmount']."\t".$values['CustomerCurrency']."\t".$OrderStatus."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

