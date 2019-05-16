<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();

/*************************/
if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){
	$arryPurchase=$objPurchase->PurchaseReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['y'],$_GET['s'],$_GET['st']);
	$num=$objPurchase->numRows();

	/*$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
	(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");*/
}
/*************************/

$filename = "Purchase_Order_Report_".date('d-m-Y').".xls";
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

	$header = "PO Number\tOrder Date\tOrder Type\tVendor\tAmount\tCurrency\tStatus\tApproved";

	$data = '';
	foreach($arryPurchase as $key=>$values){
		 $OrderDate = ($values['OrderDate']>0)?(date($Config['DateFormat'], strtotime($values['OrderDate']))):("");
		 $Approved = ($values['Approved']==1)?("Yes"):("No");

		$line = $values["PurchaseID"]."\t".$OrderDate."\t".$values["OrderType"]."\t".stripslashes($values["VendorName"])."\t".$values['TotalAmount']."\t".$values['Currency']."\t".stripslashes($values["Status"])."\t".$Approved."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

