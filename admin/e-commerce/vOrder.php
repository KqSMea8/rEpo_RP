<?php
	/**************************************************/
	$ThisPageName = 'viewOrder.php';
	/**************************************************/
 	include_once("../includes/header.php");
	
	require_once($Prefix."classes/orders.class.php");
	require_once($Prefix."classes/variant.class.php");
	require_once($Prefix."classes/product.class.php");
	
	
	
        $objOrder=new orders();
	$objProduct = new product();


                $ModuleName = 'Order';
                $ListTitle  = 'Orders';
                $ListUrl    = "viewOrder.php?curP=".$_GET['curP'];
                $Oid = isset($_GET['view'])?$_GET['view']:"";
                $Cid = isset($_GET['cid'])?$_GET['cid']:"";
		$Service='';

/*--------------------- added by sanjiv singh ----------------------------*/
             if(isset($_POST['cancelOrder'])){
             	 $Amazonservice = $objProduct->AmazonSettings($Prefix,true,$_POST['AmazonAccountID']);
             	 if($Amazonservice){
	             	 $success = $objProduct->CancelAmazonFullOrder($Amazonservice,$_POST);
             	 }else{
             	 	$_SESSION['mess_order'] = 'Failed: Please see your account settings!';
             	 }
             }
             if(isset($_POST['refundOrder'])){
             	 $Amazonservice = $objProduct->AmazonSettings($Prefix,true,$_POST['AmazonAccountID']);
             	 if($Amazonservice){
	             	 $success = $objProduct->RefundCancelAmazonOrderItems($Amazonservice,$_POST);
             	 }else{
             	 	$_SESSION['mess_order'] = 'Failed: Please see your account settings!';
             	 }
             }
             if(isset($_POST['confirmShipment'])){
             	$Amazonservice = $objProduct->AmazonSettings($Prefix,true,$_POST['AmazonAccountID']);
             	 if($Amazonservice){
	             	 $success = $objProduct->shipAndConfirmShipment($Amazonservice,$_POST);
             	 }else{
             	 	$_SESSION['mess_order'] = 'Failed: Please see your account settings!';
             	 }
             }
             /*---------------------------------------------------------*/

                 
            if (!empty($Oid)) 
                { 
                    $arryOrderIfo = $objOrder->getOrdererInfo($Oid);
                    $arryOrderProduct = $objOrder->getOrderedProductById($Oid);
                    $arryShippingStatus = $objOrder->getShippingStatus();
													$arrayShippingMethods  = $objProduct->getShippingMethods(); //by sanjiv
                }
                  
             if(!empty($_POST))
             {
               
                $_SESSION['mess_order'] = $ModuleName.UPDATED;
                $objOrder->saveOrderStatus($_POST);
                header("location:".$ListUrl);
                exit;
             }

 require_once("../includes/footer.php"); 
 
 
 ?>
