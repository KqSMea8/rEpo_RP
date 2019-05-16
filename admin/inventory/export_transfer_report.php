<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/item.class.php");
$objItem = new items();

/*************************/
	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){
	$arryTransfer=$objItem->TransferReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['w1'],$_GET['w2'],$_GET['ast']);

		$num=$objItem->numRows();
	$pagerLink=$objPager->getPager($arryTransfer,$RecordsPerPage,$_GET['curP']);
	(count($arryTransfer)>0)?($arryTransfer=$objPager->getPageRecords()):("");
}
/*************************/

$filename = "Transfer_Order_Report_".date('d-m-Y').".xls";
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

	$header = "Transfer Number\tTransfer Date\tTransfer Reason\tFrom Warehouse\tTo Warehouse\tTotal Quantity\tTotal Amount\tStatus";

	$data = '';
	foreach($arryTransfer as $key=>$values){
		 $TransferDate = ($values['transferDate']>0)?(date($Config['DateFormat'], strtotime($values['transferDate']))):("");
		 if($values['Status'] == 1 ){
			
			 $status="Parked";
		 }else if($values['Status'] == 2){
			 
			 $status="Completed";
		 }else{
			
			 $status="Cancel";
		 }

		$line = $values["transferNo"]."\t".$TransferDate."\t".stripslashes($values['transfer_reason'])."\t".stripslashes($values["from_warehouse"])."\t".$values['to_warehouse']."\t".$values['total_transfer_qty']."\t".$values["total_transfer_value"].' '.$Config['Currency']."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

