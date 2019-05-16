<?php 

//require_once($Prefix."classes/product.class.php");
//$objProduct=new product();
//pr($parameters,1);
$objProduct->getLowestPriceASIN($Prefix);

$objProduct->listBatchAmazon($Prefix);
sleep(180);
$objProduct->updateInventoryPricImageBatchAmazon($Prefix);
?>
