<? 
if($Config['MarketPlace']){
	require_once($Prefix."classes/product.class.php");
	$objProduct=new product();
	$objProduct->runReportForFees($Prefix);
}
?>
