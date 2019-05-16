<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/item.class.php");
$objItem=new items();

/*************************/
$arryExportProduct=$objItem->GetItemsView($_GET);

/*************************/

$filename = "ItemList_".date('d-m-Y').".xls";
if(count($arryExportProduct)>0){
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

	$header = "Sku\tItem Description\tTrack Inventory\tValuation Method\tItem Type\tQty on Hand\tStatus";

	$data = '';
	foreach($arryExportProduct as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$line = stripslashes($values["Sku"])."\t".stripslashes($values['description'])."\t".ucfirst($values['non_inventory'])."\t".$values["evaluationType"]."\t".$values["itemType"]."\t".$values["qty_on_hand"]."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No item found.";
}
exit;
?>

