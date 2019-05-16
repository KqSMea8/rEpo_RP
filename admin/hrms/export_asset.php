<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/asset.class.php");
require_once($Prefix."classes/vendor.class.php");
include_once("includes/FieldArray.php");
$objVendor=new vendor();
$objAsset=new asset();

/*************************/
$arryAsset=$objAsset->ListAsset($_GET);
$num = sizeof($arryAsset);
/*
$pagerLink=$objPager->getPager($arryAsset,$RecordsPerPage,$_GET['curP']);
(count($arryAsset)>0)?($arryAsset=$objPager->getPageRecords()):("");
/*************************/

$filename = "AssetList_".date('d-m-Y').".xls";
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

	//$header = "Tag ID\tAsset Name\tCategory\tModel\tVendor\tAssigned To";
	$header = "Tag ID\tSerialNumber\tAsset Name\tModel\tAssigned To";
	$data = '';
	foreach($arryAsset as $key=>$values){

		$line = $values["TagID"]."\t".stripslashes($values["SerialNumber"])."\t".stripslashes($values["AssetName"])."\t".stripslashes($values["Model"])."\t".stripslashes($values["UserName"])."\n";


		/*$line = $values["TagID"]."\t".stripslashes($values["AssetName"])."\t".stripslashes($values["Category"])."\t".stripslashes($values["Model"])."\t".stripslashes($values["VendorName"])."\t".stripslashes($values["UserName"])."\n";*/

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

