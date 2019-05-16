<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/product.class.php");
	require_once($Prefix."classes/category.class.php");
		
	$objProduct=new product();
	$objCategory=new category();
	

	/******* Eamazon/Ebay by Sanjiv singh *******/
	if(isset($_POST['add_amazon']) && !empty($_POST['AddToAmazon'])){
		$objProduct->AddAmazonProductToList($_POST);
		//$objProduct->getLowestPriceASIN($Prefix);
		//$objProduct->listBatchAmazon($Prefix);
		//$objProduct->updateInventoryPricImageBatchAmazon($Prefix);
		
		$post_data = array();
		$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
		$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
		$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
		$post_data = implode('&', $post_data);
		///var/www/html/erp/
		$pid = exec('php /var/www/html/erp/cron/AmazonBatchProduct.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);

		if ($pid) {
			$statusPID = true;
			$objConfig->removePID('e-commerce','batch');
			$objConfig->setPID('e-commerce','batch',$pid);
		} else {
			$statusPID = false;
		}
		
	}

	if(isset($_POST['add_ebay']) && !empty($_POST['AddToEbay'])){ //pr($_POST,1);
		require_once($Prefix."classes/item.class.php");
		$objProduct->AddEbayProductToList($_POST);
		//$objProduct->listBatchEbay($Prefix);
	
		$post_data = array();
		$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
		$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
		$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
		$post_data = implode('&', $post_data);
		///var/www/html/erp/
		$pid = exec('php /var/www/html/erp/cron/EbayBatchProduct.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
	
		if ($pid) {
			$statusPID = true;
			$objConfig->removePID('e-commerce','ebayBatch');
			$objConfig->setPID('e-commerce','ebayBatch',$pid);
		} else {
			$statusPID = false;
		}
	
	}

	if($_GET['marketplace']=='inlineAmazon' && (int)$_GET['id']>0){
		$objProduct->AddAmazonProductToInlineList((int)$_GET['id']);
		$objProduct->getLowestPriceASIN($Prefix);
		$objProduct->listBatchAmazon($Prefix);
		//$objProduct->updateInventoryPricImageBatchAmazon($Prefix);
		if(isset($_POST['FeedProcessingStatus']) && !($_POST['FeedProcessingStatus']=='_FAILED_' || $_POST['FeedProcessingStatus']=='Error')){
			$post_data = array();
			$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
			$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
			$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
			$post_data[] = urlencode('ProductID') . '=' . urlencode((int)$_GET['id']);
			
			$post_data = implode('&', $post_data);///opt/lampp/htdocs/
			$pid = exec('php /var/www/html/erp/cron/AmazonProductUpdate.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
		}
		$_SESSION['mess_product'] = 'Your listing is in process. It may take up to 15 minutes for your changes to propagate to amazon.';
		header('location: viewProduct.php?curP='.$_GET["curP"]);
		exit;
	}

	if($_GET['marketplace']=='inlineEbay' && (int)$_GET['id']>0){
		require_once($Prefix."classes/item.class.php");
		$objProduct->AddEbayProductToInlineList((int)$_GET['id']);
		$objProduct->getLowestPriceEbay($Prefix); 
		$objProduct->listBatchEbay($Prefix);
		$_SESSION['mess_product'] = 'Your listing is in process.';
		header('location: viewProduct.php?curP='.$_GET["curP"]);
		exit;
	}
/******* Eamazon/Ebay by Sanjiv singh *******/

	/*$arryProduct=$objProduct->GetProductsView('',$_GET['CatID'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');

	$num=$objProduct->numRows();

	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); */
	 
       #$sync_items = $objCompany->checkItemSyncSetting();

/******************************/	
$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryProduct=$objProduct->GetProductsView('',$_GET['CatID'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
$Config['GetNumRecords'] = 1;
     $arryCount=$objProduct->GetProductsView('',$_GET['CatID'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	
$num=$arryCount[0]['NumCount'];	
$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
/******************************/

        require_once("../includes/footer.php");

?>
