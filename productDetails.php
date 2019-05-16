<?php 
require_once("includes/header.php");
include_once("includes/header_menu.php");

	
	if (!empty($_GET['id'])) {
		$arryProductDetail=$objProduct->GetProducts($_GET['id'],0,0,1,'');
                $arryProductAlternativeImages=$objProduct->GetAlternativeImage($_GET['id']);
                $arryProductAttributes=$objProduct->GetProductAttributesForFront($_GET['id']);      
		
	}else if(!empty($_POST['ProductID'])){
        
             //Code for addtocart
            
            $oa_attributes = isset($_POST["oa_attributes"]) ? $_POST["oa_attributes"] : array();
            $oa_attributes = is_array($oa_attributes) ? $oa_attributes : array();

            if (!empty($_POST['Price'])) {
               $objOrder->AddToCart($_POST['ProductID'],$Cid,$_POST['Quantity'],$oa_attributes);
               $objOrder->checkQuantityDiscounts($Cid);
               header("location: productDetails.php?id=".$_POST['ProductID']);										
               exit;
            }
            
            //end code
            
        }
        else{
		header("location: index.php");										
		exit;
	}

        if($settings['AfterProductAddedGoTo'] == "Current Page"){
          $formMethod = 'method="post" action="productDetails.php"';
        }else{
            $formMethod = 'method="get" action="cart.php"';
        }
        
        
     /*********************Code for product Review/Rating/Recommended****************************/   
        if(!empty($_POST['Rating']))
         {
            $InsertId = $objProduct->AddProductReview($_POST);
            if(!empty($InsertId))
            {
                $_SESSION['successMsg'] = REVIEW_THANK;
                header("location: productDetails.php?id=".$arryProductDetail[0]['ProductID']."&review=1");										
		exit;
            }
         }
         
       if($arryProductDetail[0]['ProductID'] > 0)
       { 
         $arryProductReview = $objProduct->getReviewsByProduct($arryProductDetail[0]['ProductID']);
         $TotalProductRating = $objProduct->countProductRating($arryProductDetail[0]['ProductID']);
		 if(count($arryProductReview) > 0){
         $AvgProductRating  = $TotalProductRating[0]['total']/count($arryProductReview);
         }
         $arryProductRecommended = $objProduct->getRecommendedByProduct($arryProductDetail[0]['ProductID']);
         $num=$objProduct->numRows();
       
         
      /**************************************End Code Review/Rating******************************************************/  
         
         
         /*********************Code for product Discount AND WISHLIST****************************/ 
           $arryProductDiscount = $objProduct->getDiscountByProduct($arryProductDetail[0]['ProductID']);
           if(!empty($_SESSION['Cid']))
           {
                $arryWishlist = $objProduct->getWishlist($_SESSION['Cid']);
              
           }
     
           if(!empty($_POST['Wlid']))
           {
               $oa_attributes = isset($_REQUEST["oa_attributes"]) ? $_REQUEST["oa_attributes"] : array();
	       $oa_attributes = is_array($oa_attributes) ? $oa_attributes : array();
                
               $addedProduct = $objProduct->addProductWishlist($_POST,$oa_attributes);
               
           }
           
           if(!empty($_POST['Name']) && !empty($_POST['WhishlistCid']))
           {
                
               $addedProduct = $objProduct->addWishlist($_POST,$oa_attributes);
               
           }
             
           
         /*********************EndCode for product Discount****************************/ 
	

            $SalePrice = ($arryProductDetail[0]['Price']>0)?($arryProductDetail[0]['Price']):($arryProductDetail[0]['Price']);
            $PrdLink   = $Config['Url'].$Config['DisplayName'].'/productDetails.php?id='.$arryProductDetail[0]['ProductID'];
            $CartLink  = 'cart.php?ProductID='.$_GET['id'].'&Price='.round($Price,2).'&StoreID='.$arryProductDetail[0]['PostedByID'].'&Tax='.round($Tax,2);	
            $SalePriceHTML = display_price($SalePrice,'','','','');
            $PriceHTML = display_price($arryProductDetail[0]['Price2'],'','','','');
		
	

                //***** Similar Items *************/

                //$arrySimilarItems=$objProduct->SimilarProducts($_GET['id'],$arryProductDetail[0]['CategoryID'],1);
              $ImageLocation = 'resizeimage.php?img=upload/products/images/'.$arryProductDetail[0]['Image'].'&w=160&h=160';
	      $objRecent->add($PrdLink, $arryProductDetail[0]['Name'],$ImageLocation,$SalePrice);

            /****************************/	 
            $_GET['cat'] = $arryProductDetail[0]['CategoryID'];
            $Mid = $arryProductDetail[0]['Mid'];
            if($Mid>0){$ManufacturerName = $objManufacturer->getManufacturerByProductId($Mid); }
       }
            /*********Send Email To Friend ***************/

      
            if($_POST['Submit'] == "Email to a Friend")
            {    
                $sendMail = $objProduct->emailToFriend($_POST);
                if($sendMail == 1){
                  $_SESSION['successMsg'] = SENT_FRIEND_EMAIL;
                }
            }
          /*********End Email To Friend ***************/

            $objProduct->UpdateViewedDate($_GET['id']);
            
            
           

            require_once("includes/footer.php"); 

 ?>