<? 
if(!empty($Config['MarketPlace'])){
	require_once($Prefix."classes/product.class.php");
	require_once($Prefix."classes/rma.sales.class.php");
	$objProduct=new product();
	$objProduct->runReportForRMA($Prefix);

 
}
?>
