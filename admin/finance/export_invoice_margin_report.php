<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.report.class.php");
$objReport = new report();
$module = 'Invoice_Margin_Report';
$ModuleID= "InvoiceID";

/*************************/
if($_GET['t']>0){ $ToDate = $_GET['t'];}else{$ToDate = date('Y-m-d');}
if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-1');}
        
$arrySale=$objReport->InvoiceMarginReport($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y']);
$num=$objReport->numRows();

//get total tax amnt by customer
//$totalTaxAmnt = $objReport->getCustomerTaxAmount($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);

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

	$header = "Invoice Number\tSale Price\tCost\tFees(Amazon/Ebay fees)\tMargin";

	$data = '';
	foreach($arrySale as $key=>$values){

$SubTotal=$objReport->InvoiceSubTotal($values['OrderID']);

 $SubDropTotal=$objReport->InvoiceCostTotal($values['OrderID']);
$SubDropTotal = $SubDropTotalQty[0]['Cost']*$SubDropTotalQty[0]['inv_qty'];
$subtotalDropCost += $SubDropTotal;
//$subtotalCost += $SubTotal;
//echo $SubTotal;

$margin = $SubTotal-$SubDropTotal-$values['Fee'];
$subtotalMargin += $margin;

	
		
		 $line = stripslashes($values["InvoiceID"])."\t".$SubTotal."\t". $SubDropTotal."\t".$values['Fee']."\t".$margin."\n";

		$data .= trim($line)."\n";
	}
        $data .= "\n";
        $data .= "\t\t\t\t\t";
        //$data .='Total Tax Amount '.$totalTaxAmnt.' '.$Config['Currency']."\n";
        
	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

