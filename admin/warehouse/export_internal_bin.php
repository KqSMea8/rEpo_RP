<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/warehouse.class.php");
	
		
	$objWarehouse=new warehouse();

/*************************/
	
	 $arryAssemble = $objWarehouse->ListBinAssembly('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status']);
	 $WarehouseName=$objWarehouse->AllWarehouses($arryAssemble[0]['warehouse_code']);
	 $BinName=$objWarehouse->getBindata($arryAssemble[0]['bin_id']);
	 $num=$objWarehouse->numRows();   
	 $pagerLink=$objPager->getPager($arryAssemble,$RecordsPerPage,$_GET['curP']);
	(count($arryAssemble)>0)?($arryAssemble=$objPager->getPageRecords()):(""); 

/*************************/

$filename = "assamble_Order_Report_".date('d-m-Y').".xls";
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

	$header = "Received Date\tRecieve No\tAssemble No\tWarehouse Location \tAssemble Date\tAssemble Qty\tStatus";

	$data = '';
	foreach($arryAssemble as $key=>$values){
		 $updatedDate = ($values['UpdatedDate']>0)?(date($Config['DateFormat'], strtotime($values['UpdatedDate']))):("");
	//	 $asmDate= ($values['asmDate']>0)?(date($Config['DateFormat'], strtotime($values['asmDate']))):("");
		 if($values['Status'] == 1 ){
			 $status="Cancel";
			 
		 }else if($values['Status'] == 2){
			 
			 $status="Completed";
		 }else{
			
			 $status="Parked";
		 }

$line = $updatedDate."\t".$values['RecieveNo']."\t".$WarehouseName[0]['warehouse_name']."\t".$BinName[0]['binlocation_name']."\t".$values['bin_qty']."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

