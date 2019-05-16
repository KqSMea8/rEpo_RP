<?php  
include_once("includes/settings.php");
require_once($Prefix."classes/item.class.php");	
include_once("crm/includes/FieldArray.php");	
$objItem=new items();

/*************************/
$arryItem=$objItem->GetItemsView($_GET);
$num=$objItem->numRows();


$pagerLink=$objPager->getPager($arryItem,$RecordsPerPage,$_GET['curP']);
(count($arryItem)>0)?($arryItem=$objPager->getPageRecords()):(""); 
/*************************/

$filename = "ItemList_".date('d-m-Y').".xls";
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

	$header = "SKU\tItem Name\tPrice [".$Config['Currency']."]\tQty on Hand\tStatus";

	$data = '';
	foreach($arryItem as $key=>$values){
		 if($values['Status'] ==1){
			  $Status = 'Active';
		 }else{
			  $Status = 'InActive';
		 }		

		$line = stripslashes($values['Sku'])."\t".stripslashes($values["description"])."\t".stripslashes($values["sell_price"])."\t".stripslashes($values['qty_on_hand'])."\t".$Status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

