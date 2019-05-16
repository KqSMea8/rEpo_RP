<?php  
	include_once("../includes/settings.php");
	require_once($Prefix."classes/warehouse.class.php");
	$ModuleName = "Manage Bin";
	$objWarehouse=new warehouse();

	$arryWarehouse=$objWarehouse->ListManageBin('',$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	$num=$objWarehouse->numRows();
	
	$pagerLink=$objPager->getPager($arryWarehouse,$RecordsPerPage,$_GET['curP']);
	(count($arryWarehouse)>0)?($arryWarehouse=$objPager->getPageRecords()):("");

/*************************/

$filename = "LeadList_".date('d-m-Y').".xls";
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

	$header = "Binid\tWarehouse Code\tWarehouse Name\tBin Location\tNote/Comments\tStatus";

	$data = '';
	foreach($arryWarehouse as $key=>$values){
	$widval = $values["warehouse_id"]; 
	$dataval = $objWarehouse->getWarehousedata($widval);
        foreach($dataval as $warehousedata): 
$line = $values["binid"]."\t".stripslashes($warehousedata["warehouse_code"])."\t".stripslashes($warehousedata["warehouse_name"])."\t".stripslashes($values['binlocation_name'])."\t".stripslashes($values["description"])."\t".$values["status"]."\n";

		
        endforeach;
		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

