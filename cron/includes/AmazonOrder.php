<?php 
if($Config['MarketPlace']){

	require_once($Prefix."classes/product.class.php");
	$objProduct=new product();

	/**************Set Background Process for Lowest price ***********************/
	$post_data = array();
	$post_data[] = urlencode('CmpID') . '=' . urlencode($Config['AdminID']);
	$post_data[] = urlencode('AdminID') . '=' . urlencode($Config['AdminID']);
	$post_data[] = urlencode('AdminType') . '=' . urlencode($Config['AdminType']);
	$post_data[] = urlencode('ProcessName') . '=' . urlencode('AmazonLowestPrice');
	$post_data = implode('&', $post_data);

	$pid = exec('php /var/www/html/erp/cron/BackgroundProcesses.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
	/***************end of Lowest Price **********************/

	$objProduct->runAmazonOrder($objRegion,$Prefix);
	$objProduct->EbayImportOrders($objRegion,$Prefix);
}
?>
