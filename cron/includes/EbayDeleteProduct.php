<?php 
//$objProduct=new product();
//pr($parameters,1);
if(!empty($parameters['ProductID'])){
$ids = explode("#",urldecode($parameters['ProductID']));
if(count($ids)>10){
			$productids = array_chunk($ids,10,true);  
			$objProduct->deleteMultipleEbayProduct($Prefix, $productids[0]);
			$objProduct->deleteMultipleEbayProduct($Prefix, $productids[1]);
		}else{ 
			$objProduct->deleteMultipleEbayProduct($Prefix, $ids);
		}
//$objProduct->syncEbayProducts($Prefix);
}
?>
