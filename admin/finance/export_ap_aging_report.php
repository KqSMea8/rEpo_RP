<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.report.class.php");
 require_once($Prefix."classes/finance.account.class.php");
 $objReport = new report();
 $objBankAccount=new BankAccount();
 $module = 'AP_Aging_Report';


/*************************/
$arryAging=$objReport->apAgingReort($_GET['s']);
$num=$objReport->numRows();


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

	$header = "Vendor\tTotal Unpaid(".$Config['Currency'].")\t0-30 Days(".$Config['Currency'].")\t31-60 Days(".$Config['Currency'].")\t61-90 Days(".$Config['Currency'].")\t90+ Days (".$Config['Currency'].")";

	$data = '';
        $totalVar = 'Total';
        $TotalUnpaidInvoice = 0;
        $TotalfirstUnPaidInvoice = 0;
        $TotalsecondUnPaidInvoice = 0;
        $TotalthirdUnPaidInvoice = 0;
        $TotalfourthUnPaidInvoice = 0;
	foreach($arryAging as $key=>$values){
            
	 $totalInvoice = $values['TotalInvoiceAmount'];
                $PaidAmnt = $values['PaidAmnt'];
                if($PaidAmnt > 0)
                {
                    $UnpaidInvoice = $totalInvoice-$PaidAmnt;
                }else{
                    $UnpaidInvoice = $totalInvoice;
                }
                
                $TotalUnpaidInvoice +=$UnpaidInvoice;
                
                //UNPAID INVOICE FOR 0-30
                //$fromDate = date('Y-m-d', strtotime('today - 30 days'));
                //$toDate = date('Y-m-d');
                $firstUnPaidInvoice = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 30 days')),date('Y-m-d'),$values['SuppCode']);
                $secondUnPaidInvoice = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 60 days')),date('Y-m-d',strtotime('today - 31 days')),$values['SuppCode']);
                $thirdUnPaidInvoice = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 90 days')),date('Y-m-d',strtotime('today - 61 days')),$values['SuppCode']);
                $fourthUnPaidInvoice = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 365 days')),date('Y-m-d',strtotime('today - 91 days')),$values['SuppCode']);
                
                $TotalfirstUnPaidInvoice +=$firstUnPaidInvoice;
                $TotalsecondUnPaidInvoice +=$secondUnPaidInvoice;
                $TotalthirdUnPaidInvoice +=$thirdUnPaidInvoice;
                $TotalfourthUnPaidInvoice +=$fourthUnPaidInvoice;
                
                 if(empty($values["SuppCompany"])){ 
                $SupplierName = $objBankAccount->getSupplierName($values['SuppCode']);
                }else{
                $SupplierName = $values["SuppCompany"];
                }
                
		 $line = stripslashes($SupplierName)."\t".number_format($UnpaidInvoice,2,'.','')."\t".number_format($firstUnPaidInvoice,2,'.','')."\t".number_format($secondUnPaidInvoice,2,'.','')."\t".number_format($thirdUnPaidInvoice,2,'.','')."\t".number_format($fourthUnPaidInvoice,2,'.','')."\n";

		$data .= trim($line)."\n";
	}
        $data .= "\n";
        $data .= $totalVar."\t".number_format($TotalUnpaidInvoice,2,'.','')."\t".number_format($TotalfirstUnPaidInvoice,2,'.','')."\t".number_format($TotalsecondUnPaidInvoice,2,'.','')."\t".number_format($TotalthirdUnPaidInvoice,2,'.','')."\t".number_format($TotalfourthUnPaidInvoice,2,'.','')."\n";
       // $data .='Total Tax Amount '.$totalTaxAmnt.' '.$Config['Currency']."\n";
        
	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

