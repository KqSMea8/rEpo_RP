<?php 
 include_once("../includes/header.php");
require_once("../../classes/product.class.php");
require_once("../../classes/cartsettings.class.php");
     $objProduct=new product();
     $objCartsettings=new Cartsettings();
		
	$EditUrl = "AmazonEditProduct.php?curP=".$_GET["curP"]."&tab=";
	if(empty($_GET['tab'])){
		$_GET['tab'] = 'Basic';
	}
	
	if(!empty($_GET['del_id']) && !empty($_GET['ProductSku'])){
		$Amazonservice = $objProduct->AmazonSettings($Prefix, true, $_GET['AmazonAccountID']);
		$objProduct->deleteAmazonProduct($Amazonservice,$_GET['ProductSku'],$_GET['del_id']);
		$_SESSION['CRE_Update'] = 'Deleted successfully.';
		header("Location:".$EditUrl);
	}
	
	/************ Sync Product *********************/
	if(isset($_REQUEST['sync_amazon'])){
		//$objProduct->syncProduct($Prefix,$_REQUEST['AmazonAcc']); die;
		$post_data = array();
		$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
		$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
		$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
		$post_data[] = urlencode('AmazonAcc') . '=' . urlencode($_REQUEST['AmazonAcc']);
		$post_data = implode('&', $post_data);

		///var/www/html/erp/
		$pid = exec('php /var/www/html/erp/cron/AmazonSyncProduct.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
		
		if ($pid) {
			$statusPID = true;
			$objConfig->removePID('e-commerce','addProduct');
			$objConfig->setPID('e-commerce','addProduct',$pid);
		} else {
			$statusPID = false;
		}
	}else if (isset($_POST['update_lowestPrice']) && $_POST['select_lowestPrice']==2){
		$objConfig->setPID('e-commerce','lowestPrice',1);
		$_SESSION['CRE_Update'] = "Lowest price of all product is scheduled for update.It will take some time to update.<br/>";
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
		
		$Amazonservice = $objProduct->amazonSettings($Prefix,true,$_POST['AccountID']);
		$objProduct->updateAmazonAllQuantity($Amazonservice, $quantity, $_POST['AccountID']);
		$objProduct->updateAmazonAllPrice($Amazonservice, $Price, $_POST['AccountID']);
		$_SESSION['Amazon_PQ_Update'] = 1;
		$_SESSION['CRE_Update'] = "It will take 10 to 15 minutes to update on amazon.";
		
	}
	/************End of Sync Product *********************/
	
	//if(!isset($_SESSION['Amazon_PQ_Update']))
	//$objProduct->processAmazonSubmissionHistory($Prefix);
	
	if($_GET['tab']=='SubmissionHistory'){
		$arryEbay=$objProduct->getAmazonSubmitHistory('');
		$num=$objProduct->numRows();
		//print_r($arryEbay);
		//$data = $objProduct->getFeedSubmissionHistory($Amazonservice,$values['FeedSubmissionId']);
	}else{
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
		
		
		if($_GET['s2']){
			$jsonData = json_encode(array('ItemCondition'=>$_GET['ItemCondition'],'QuantityFrom'=>$_GET['QuantityFrom'],'QuantityTo'=>$_GET['QuantityTo'],'PriceFrom'=>$_GET['PriceFrom'],'PriceTo'=>$_GET['PriceTo']));
			$Fsettings = array('AmazonFilter'=>$jsonData);
			$objCartsettings->updateCartSettingsFields($Fsettings);
			$arryEbay=$objProduct->getAmazonData('','amazon',$status,$FeedStatus,$_GET,'');
		}else{
		$arryEbay=$objProduct->getAmazonData('','amazon',$status,$FeedStatus,'','');
		}
		$fiterSet = $objCartsettings->getCartSettingsFields(6);
	//echo "<pre>";print_r($arryEbay);
	$num=$objProduct->numRows();
	}  
	 
      $pagerLink=$objPager->getPager($arryEbay,$RecordsPerPage,$_GET['curP']);
	(count($arryEbay)>0)?($arryEbay=$objPager->getPageRecords()):("");
      

	if (isset($_POST['update_lowestPrice']) && $_POST['select_lowestPrice']==1){ 
		if(!empty($arryEbay)){
			foreach ($arryEbay as $key => $values) {
				$Amazonservice = $objProduct->AmazonProductSettings($Prefix,true,$values['AmazonAccountID']);
				$lowestPriceArr = $objProduct->GetLowestPricingForSKU($Amazonservice,$values['ItemCondition'],stripslashes($values['ProductSku']));
				$objProduct->manualUpdateForLowestPrice($lowestPriceArr,stripslashes($values['ProductSku']));
			}
		}
		$_SESSION['CRE_Update'] = "Lowest price for current page products have been updated.";
		header('Location: '.$EditUrl);
		exit;
	}

        require_once("../includes/footer.php");

?>
