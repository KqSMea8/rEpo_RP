<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
$module = 'Order';
$ModuleName = "Sale".$_GET['module'];
$ModuleIDTitle = "SO Number"; $ModuleID= "SaleID";

/*************************/
$arrySale=$objSale->SalesReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$_GET['s'],$_GET['st']);
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

	$header = "".$module." Date\t".$ModuleIDTitle."\tSales Person\tCustomer\tAmount\tCurrency\tStatus\tApproved";

	$data = '';
	foreach($arrySale as $key=>$values){
	$ddate = $module.'Date';
		 $OrderDate = ($values[$ddate]>0)?(date($Config['DateFormat'], strtotime($values[$ddate]))):("");
		 $Approved = ($values['Approved']==1)?("Yes"):("No");

		$line = $OrderDate."\t".$values[$ModuleID]."\t".stripslashes($values["SalesPerson"])."\t".stripslashes($values["CustomerName"])."\t".$values['TotalAmount']."\t".$values['CustomerCurrency']."\t".stripslashes($values["Status"])."\t".$Approved."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

