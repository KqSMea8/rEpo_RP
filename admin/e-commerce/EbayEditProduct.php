<?php 
 include_once("../includes/header.php");
require_once("../../classes/product.class.php");
require_once("../../classes/cartsettings.class.php");
require_once("../../classes/item.class.php");
     $objProduct=new product();
     $objCartsettings=new Cartsettings();
		
	if(!empty($_GET['del_id'])){
		$objProduct->deleteEbayProduct($Prefix,$_GET['ItemID'],$_GET['del_id']);
		$_SESSION['CRE_Update'] = 'Deleted successfully.';
		 header("Location:EbayEditProduct.php");
	}
	
	$EditUrl = "EbayEditProduct.php?curP=".$_GET["curP"]."&tab=";
	if(empty($_GET['tab'])){
		$_GET['tab'] = 'Basic';
	}
	
	/************ Sync Product *********************/
	if(isset($_REQUEST['sync_ebay'])){ 
	 //$objProduct->syncEbayProducts($Prefix);
		 $post_data = array();
		$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
		$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
		$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
		$post_data = implode('&', $post_data);
		///var/www/html/erp/
		$pid = exec('php /var/www/html/erp/cron/EbaySyncProduct.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
		
		if ($pid) {
			$statusPID = true;
			$objConfig->removePID('e-commerce','addEbayProduct');
			$objConfig->setPID('e-commerce','addEbayProduct',$pid);
		} else {
			$statusPID = false;
		} 
		unset($_REQUEST['sync_ebay']);
	}else if (isset($_POST['update_lowestPrice']) && $_POST['select_lowestPrice']==2){
		$objConfig->setPID('e-commerce','lowestPrice',1);
		$_SESSION['CRE_Update'] = "Lowest price of all product is scheduled for update.It will take some time to update.";
	}else if (isset($_POST['CurrentPage'])){ 
		unset($_POST['CurrentPage']);
		$quantity = $Price = array();
		foreach ($_POST as $key => $values){ 
			$pos = strpos($key, 'Price_');
			if($pos!== false){
				$sku = substr($key,6);
				$Price[$sku] = $values;
			}
			
			$pos1 = strpos($key, 'Quantity_');
			if($pos1!== false){
				$sku1 = substr($key,9);
				$quantity[$sku1] = $values;
			}
		}
		
		$objProduct->updateEbayAllQuantity($Prefix,$quantity);
		$objProduct->updateEbayAllPrice($Prefix,$Price);
		$_SESSION['Amazon_PQ_Update'] = 1;
		$_SESSION['CRE_Update'] = "It will take 5 to 10 minutes to update on Ebay.";
		
	}else if (!empty($_POST['ProductID'])){ 
		/*if(count($_POST['ProductID'])>10){
			$productids = array_chunk($_POST['ProductID'],10,true);  
			$objProduct->deleteMultipleEbayProduct($Prefix, $productids[0]);
			$objProduct->deleteMultipleEbayProduct($Prefix, $productids[1]);
		}else{ 
			$objProduct->deleteMultipleEbayProduct($Prefix, $_POST['ProductID']);
		}
		$_SESSION['CRE_Update'] = 'Ebay Items are deleted successfully.';
		 header("Location:EbayEditProduct.php?".$_SERVER["QUERY_STRING"]);
		 exit;*/
		 
		$post_data = array();
		$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
		$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
		$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
		$post_data[] = urlencode('ProductID') . '=' . urlencode(implode("#", $_POST['ProductID']));
		$post_data = implode('&', $post_data);
		///var/www/html/erp/
		$pid = exec('php /var/www/html/erp/cron/EbayDeleteProduct.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
		
		if ($pid) {
			$statusPID = true;
			$objConfig->removePID('e-commerce','addEbayProduct');
			$objConfig->setPID('e-commerce','addEbayProduct',$pid);
		} else {
			$statusPID = false;
		} 
		unset($_POST['ProductID']);
	}
	/************End of Sync Product *********************/
	
		$status = '';
		$FeedStatus = '';
		if($_GET['tab']=='ActiveItems'){
			$status = 1;
			$FeedStatus = 'Active';
		}elseif($_GET['tab']=='UnlistedProduct'){
			$status = 1;
			$FeedStatus = 'Error';
		}elseif($_GET['tab']=='QueuedProducts'){
			$status = 0;
			$FeedStatus = '';
		}
		
		
		if(isset($_GET['s2'])){
			$jsonData = json_encode(array('ItemCondition'=>$_GET['ItemCondition'],'QuantityFrom'=>$_GET['QuantityFrom'],'QuantityTo'=>$_GET['QuantityTo'],'PriceFrom'=>$_GET['PriceFrom'],'PriceTo'=>$_GET['PriceTo']));
			$Fsettings = array('AmazonFilter'=>$jsonData);
			$objCartsettings->updateCartSettingsFields($Fsettings);
			$arryEbay=$objProduct->getAmazonData('','ebay',$status,$FeedStatus,$_GET,'');
		}else{
		$arryEbay=$objProduct->getAmazonData('','ebay',$status,$FeedStatus,'','');
		}
		$fiterSet = $objCartsettings->getCartSettingsFields(6);
		//echo "<pre>";print_r($arryEbay);
		$num=$objProduct->numRows();
	
	$pagerLink=$objPager->getPager($arryEbay,$RecordsPerPage,$_GET['curP']);
	(count($arryEbay)>0)?($arryEbay=$objPager->getPageRecords()):("");
	
	
	/* if ($_POST['update_lowestPrice'] && $_POST['select_lowestPrice']==1){ 
		if(!empty($arryEbay)){
			foreach ($arryEbay as $key => $values) {
				$Amazonservice = $objProduct->AmazonProductSettings($Prefix,true,$values['AmazonAccountID']);
				$lowestPriceArr = $objProduct->GetLowestPricingForSKU($Amazonservice,$values['ItemCondition'],stripslashes($values['ProductSku']));
				$objProduct->manualUpdateForLowestPrice($lowestPriceArr,stripslashes($values['ProductSku']));
			}
		}
		$_SESSION['CRE_Update'] = "Lowest price of current page products have been updated.";
		header('Location: '.$_SERVER['PHP_SELF']);
		exit;
	} */
	
	
        require_once("../includes/footer.php");

?>
