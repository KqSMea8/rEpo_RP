<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.report.class.php");
$objReport = new report();
$module = 'Sales_Tax_Report';
$ModuleID= "InvoiceID";

/*************************/
if($_GET['t']>0){ $ToDate = $_GET['t'];}else{$ToDate = date('Y-m-d');}
if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-1');}

   (empty($_GET['c']))?($_GET['c']=""):(""); 
   (empty($_GET['st']))?($_GET['st']=""):("");
        
$arrySale=$objReport->SalesTaxReport($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);
$num=$objReport->numRows();

//get total tax amnt by customer
#$totalTaxAmnt = $objReport->getCustomerTaxAmount($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);

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

	$header = "Customer\tInvoice Date\tOrder Number\tInvoice Number\tStatus\tTax (".$Config['Currency'].")";

	$data = '';
	$totalTaxAmnt=0;
	foreach($arrySale as $key=>$values){
		
		$ddate = 'InvoiceDate';
		 $InvoiceDate = ($values[$ddate]>0)?(date($Config['DateFormat'], strtotime($values[$ddate]))):("");
		 //$Approved = ($values['Approved']==1)?("Yes"):("No");
                 if($values['InvoicePaid'] =='Paid'){$Status = 'Paid';}else{ $Status = 'Pending';}

		$ConversionRate=1;
		if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
			$ConversionRate = $values['ConversionRate'];			   
		}
	        $Amount = $values['taxAmnt']*$ConversionRate;

		$totalTaxAmnt += $Amount;


		 $line = stripslashes($values["CustomerName"])."\t".$InvoiceDate."\t".$values['SaleID']."\t".$values["InvoiceID"]."\t".$Status."\t".number_format($Amount,2)."\n";

		$data .= trim($line)."\n";
	}
        $data .= "\n";
        $data .= "\t\t\t\t\t";
        $data .='Total Tax Amount '.number_format($totalTaxAmnt,2).' '.$Config['Currency']."\n";
        
	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

