<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/bom.class.php");
	
		
	$objBom=new bom();

/*************************/
	
 $arryAssemble = $objBom->ListAssemble('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status']);
         
         
	 $num=$objBom->numRows();
       
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

	$header = "Assemble No\tWarehouse Location\tAssemble Date\tBill Number \tItem Description\tAssemble Qty\tStatus";

	$data = '';
	foreach($arryAssemble as $key=>$values){
		 $asmDate = ($values['asmDate']>0)?(date($Config['DateFormat'], strtotime($values['asmDate']))):("");
		 if($values['Status'] == 1 ){
			 $status="Cancel";
			 
		 }else if($values['Status'] == 2){
			 
			 $status="Completed";
		 }else{
			
			 $status="Parked";
		 }

$line = $values['asm_code']."\t".$values['warehouse_code']."\t".$asmDate."\t".$values['Sku']."\t".stripslashes($values['description'])."\t".$values['assembly_qty']."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

