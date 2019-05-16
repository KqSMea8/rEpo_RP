
<div class="main-container">
          <div class="mid_wraper clearfix">
            <?php include_once("includes/left.php"); ?>
                <div class="right_pen">
                 <!-- <h1><?//=HOME_MSG?>Welcome to <?//=ucfirst($Config['DisplayName']);?> Store</h1>
                 <h3><?//=HOME_MSG2?></h3>-->
        <div class="home_feat_prod block">
          <h2><?=FEATURED_PRODUCTS?></h2>
         <?php if($num>0 ) {  ?>
          <ul class="listing_prod">
            <? 
   
	//$arryTotalRanking = $objMember->GetMemberRanking('','Seller');

 
   $i=0;
   
  foreach($arryProductFeatured as $key=>$values){
   $i++;
   
    		
		$Price = ($values['OfferPrice']>0)?($values['OfferPrice']):($values['Price']);
		if(!empty($_SESSION['VatPercentage']) && $values['TaxExempt']!=1){
			$Tax = ($Price * $_SESSION['VatPercentage'])/100;
			$PriceFinal = $Price+$Tax;
		}else{
			$Tax = 0;
			$PriceFinal = $Price;
		} 
   
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'].$StoreSuffix;
		$CartLink  = 'cart.php?ProductID='.$values['ProductID'].'&Price='.round($Price,2).'&StoreID='.$values['PostedByID'].'&Tax='.round($Tax,2);
		
		
		if($values['Image'] !='' && file_exists('upload/products/images/'.$Config['CmpID'].'/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/images/'.$Config['CmpID'].'/'.$values['Image'].'&w=160&h=160'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			//$EnlargeImage = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.CLICK_TO_ENLARGE.'</a>';
		}else{
			$ImagePath = '<img src="../images/no.jpg" height="150" border="0" />';
			//$EnlargeImage = '';
		}
		?>   
            <li <?php if($i%3==0){?> class="third"<?php }?>>
              <div class="img"> <a href="<?=$PrdLink;?>" ><?=$ImagePath?></a> </div>
              <div class="name"> <a href="<?=$PrdLink;?>"><?=ucfirst(stripslashes($values['Name']));?></a> </div>
              <div class="price"><?=display_price($PriceFinal,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']);?></div>
            </li>
          
           <?php } 
	 
	 ?>     
          </ul>
          <? } else{ ?>			
 
          <div class="productnotfound"><? echo NO_FEATURED_PRODUCT_FOUND; ?></div>
			 <? } ?>
        </div>
          </div>
        </div>
