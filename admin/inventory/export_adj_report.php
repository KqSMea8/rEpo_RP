<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/item.class.php");
$objItem = new items();

/*************************/
	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){
	$arryAdjustment=$objItem->AdjustmentReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['w'],$_GET['ast']);
	
	$num=$objItem->numRows();

	$pagerLink=$objPager->getPager($arryAdjustment,$RecordsPerPage,$_GET['curP']);
	(count($arryAdjustment)>0)?($arryAdjustment=$objPager->getPageRecords()):("");
}
/*************************/

$filename = "Adjustment_Order_Report_".date('d-m-Y').".xls";
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

	$header = "Adjustment Number\tAdjustment Date\tAdjustment Reason\tWarehouse\tTotal Amount\tTotal Quantity\tStatus";

	$data = '';
	foreach($arryAdjustment as $key=>$values){
		 $adjDate = ($values['adjDate']>0)?(date($Config['DateFormat'], strtotime($values['adjDate']))):("");
		 if($values['Status'] == 1 ){
			
			 $status="Parked";
		 }else if($values['Status'] == 2){
			 
			 $status="Completed";
		 }else{
			
			 $status="Cancel";
		 }

		$line = $values["adjustNo"]."\t".$adjDate."\t".stripslashes($values["adjust_reason"])."\t".stripslashes($values["warehouse_code"])."\t".$values['total_adjust_value'].' '.$Config['Currency']."\t".$values["total_adjust_qty"]."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

