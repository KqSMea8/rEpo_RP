<?php 
require_once("includes/header.php");
include_once("includes/header_menu.php");
require_once("classes/company.class.php");
$objCompany=new company();
	if(empty($_SESSION["guestId"])){
        $Cid = (!empty($_SESSION['Cid']))?($_SESSION['Cid']):(session_id());
        }else{
            $Cid = isset($_SESSION["guestId"])?$_SESSION["guestId"]:"";
        }
	
        $oa_attributes = isset($_REQUEST["oa_attributes"]) ? $_REQUEST["oa_attributes"] : array();
	$oa_attributes = is_array($oa_attributes) ? $oa_attributes : array();
        
      
	 if (!empty($_GET['Price'])) {
		$objOrder->AddToCart($_GET['ProductID'],$Cid,$_GET['Quantity'],$oa_attributes);
                $objOrder->checkQuantityDiscounts($Cid);
		header("location: cart.php");										
		exit;
	}
	
         else if(!empty($_REQUEST['oid']) && $_REQUEST['action'] == "reorder") {
		$objOrder->ReOrder($_REQUEST['oid'],$Cid);
                $objOrder->checkQuantityDiscounts($Cid);
                $_SESSION['successMsg'] = CART_REORDER;
		header("location: cart.php");										
		exit;
	}
        
		
	else if($_POST['CartSubmit']=='1'){
		$objOrder->UpdateCart($_POST);
	        $arryNumCart = $objOrder->GetNumItemCart($Cid);
                $objOrder->checkQuantityDiscounts($Cid);
                
                if(!empty($_POST['CartSubmitFromCheckOut'])){
                    header("location: checkout.php");										
                    exit;
                }else{
                    $_SESSION['successMsg'] = CART_UPDATED;
                    header("location: cart.php");										
                    exit;
                }
	}
        
        else if(!empty($_REQUEST['Wlpid']))
        {       
                $wl_product = $objProduct->getWishlistProduct($_REQUEST['Wlpid']);
                $objOrder->AddToCart($wl_product["ProductID"], $Cid, "1", $wl_product["product_attributes"]);
		$objOrder->checkQuantityDiscounts($Cid);
                header("location: cart.php");										
		exit;
        }
        
        else if(!empty($_REQUEST['Wlid']))
        {       
               $wl_products = $objProduct->GetProductByWishListId($Cid,$_REQUEST['Wlid']); 
               
		foreach ($wl_products["whishlist_products"] as $product)
		{  
			//if ($product["out_of_stock"] == "No" || $product["out_of_stock"] == "")
			//{
				$wl_product = $objProduct->getWishlistProduct($product["Wlpid"]);
				$objOrder->AddToCart($wl_product["ProductID"],$Cid, "1", $wl_product["product_attributes"]);
				$objOrder->checkQuantityDiscounts($Cid);
			//}
		}
		
                header("location: cart.php");										
		exit;
        }
        
	else{
            
            $objOrder->checkQuantityDiscounts($Cid);
            
        }
      
        
	
	
	$arryCart = $objOrder->GetCart($Cid);	
	$numCart  = $objOrder->numRows();
	
        $CartSubtotalAmount = $objOrder->getCartSubtotalAmount($Cid);	
       // echo "=>".$SubtotalAmount;
        $discountDetails = $objDiscount->getDiscountAmount($CartSubtotalAmount,$Cid);
	
        $discountAmount = $discountDetails['discountAmount'];
        $_SESSION['discountValue'] = $discountDetails['discountValue'];
        $_SESSION['discountType'] = $discountDetails['discountType'];
        
        if(!empty($_SESSION['promo_code'])){       
         $promo_result = $objDiscount->checkPromoCode($CartSubtotalAmount,$_SESSION['promo_code'],$Cid);
        
           $_SESSION['promo_discount_amount'] = $promo_result['promo_discount_amount'];
         
         
        }
        
 ?>

<?
	
	require_once("includes/footer.php"); 
?>