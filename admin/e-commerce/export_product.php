<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/product.class.php");
$objProduct=new product();

/*************************/
$arryExportProduct=$objProduct->exportProducts();

/*************************/

$filename = "ProductList_".date('d-m-Y').".xls";
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

	$header = "ProductID\tProductSku\tName\tCategoryID\tManufaturerID\tPrice\tSalePrice\tQuantity\tInventoryControl\tInventoryRule\tStockWarning\tFeatured\tStatus\tIsTaxable\tTaxClassId\tWeight\tFreeShipping\tMetaTitle\tMetaKeywords\tMetaDescription\tAddedDate";

	$data = '';
	foreach($arryExportProduct as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$line = $values["ProductID"]."\t".stripslashes($values["ProductSku"])."\t".stripslashes($values['Name'])."\t".stripslashes($values["CategoryID"])."\t".$values["Mid"]."\t".$values["Price2"]."\t".$values["Price"]."\t".$values["Quantity"]."\t"
                        .$values["InventoryControl"]."\t".$values["InventoryRule"]."\t".$values["StockWarning"]."\t".$values["Featured"]."\t".$status."\t".$values["IsTaxable"]."\t"
                        .$values["TaxClassId"]."\t".$values["Weight"]."\t".$values["FreeShipping"]."\t".$values["MetaTitle"]."\t".$values["MetaKeywords"]."\t".$values["MetaDescription"]."\t".$values["AddedDate"]."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No Product found.";
}
exit;
?>

