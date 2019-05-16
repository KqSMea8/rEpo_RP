<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/rma.sales.class.php");
$objRmaSale = new rmasale();
$module = 'RMA';
$ModuleName = $_GET['Module'];
if(empty($ModuleName)){
	$ModuleName="RMA";
}
$ModuleIDTitle = "RMA Number"; $ModuleID = "ReturnID";
/*************************/
$arrySale=$objRmaSale->listRma($_GET);

$num=$objRmaSale->numRows();

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

	$header = "RMA Date\tRMA Number\tInvoice Number\tSO Number\tSales Person\tCustomer\tAmount\tCurrency";

	$data = '';
	foreach($arrySale as $key=>$values){
		 $ReturnDate = ($values['ReturnDate']>0)?(date($Config['DateFormat'], strtotime($values['ReturnDate']))):("");
		 $ReturnPaid = ($values["ReturnPaid"]=="Yes")?("Yes"):("No");

		$line = $ReturnDate."\t".$values[$ModuleID]."\t".$values['InvoiceID']."\t".$values['SaleID']."\t".stripslashes($values["SalesPerson"])."\t".stripslashes($values["CustomerName"])."\t".$values['TotalAmount']."\t".$values['CustomerCurrency']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

