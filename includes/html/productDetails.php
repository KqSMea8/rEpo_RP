<?php if (!empty($_SESSION['successMsg'])) { ?>
<div class="successMsg">
    <?php echo $_SESSION['successMsg']; ?>
    <?php unset($_SESSION['successMsg']);?>
</div>
<?php } ?>
<?php if (!empty($_SESSION['errorMsg'])) { ?>
<div class="warningMsg">
       <?php echo $_SESSION['errorMsg']; ?>
       <?php unset($_SESSION['errorMsg']);?>
</div>
<?php } ?>
<div class="main-container">
    <div class="mid_wraper clearfix">
      <?php include_once("includes/left.php"); ?>
      <div class="right_pen">
        <?php if($arryProductDetail[0]['ProductID'] > 0){?>  
         <div class="products_details block">
          <h2><?=ucfirst(stripslashes($arryProductDetail[0]['Name']))?></h2>
           
           <form name="formQnt"  <?=$formMethod?>  onsubmit="return validateProductQuantity(this);" >
           
          <div class="products_info clearfix">
          	<div class="left"> 
            	<div class="clearfix" id="content">
                     
                    <?php
                    //list($width_orig, $height_orig) = getimagesize('upload/products/'.$arryProductDetail[0]['Image']);
			
			if($width_orig>=350 || $height_orig>=350){
				$zoom_apend = ' data-zoomsrc="upload/products/'.$arryProductDetail[0]['Image'].'" id="myimage"';

				$TextClickImage = 'Rollover image above to zoom';
			}else{
				$TextClickImage = 'Click image above to enlarge';
			}

			
			$ImagePath = 'resizeimage.php?img=upload/products/images/'.$Config['CmpID'].'/'.$arryProductDetail[0]['Image'].'&w=300&h=280'; 
			
                    ?>
                <div class="main_img">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle" align="center">
                    <?php if(!empty($arryProductDetail[0]['Image'])){?>
                    <a data-fancybox-group="gallery" class="fancybox"  href="../upload/products/images/<?=$Config['CmpID'].'/'.$arryProductDetail[0]['Image'];?>" >
                    <img src="<?=$ImagePath;?>" title="<?=ucfirst(stripslashes($arryProductDetail[0]['Name']))?>" />
                     <span class="clickzoom"><?=CLICK_TO_ZOOM?></span>
                    </a>
                    <?php } else {?>
                    <img src="./../images/no.jpg" title="<?=ucfirst(stripslashes($arryProductDetail[0]['Name']))?>" />
                    <?php }?>
                </td>
              </tr>
            </table>
               
                  
                </div>
                    <?php if(count($arryProductAlternativeImages) > 0){?>
                   <ul id="mycarousel" class="jcarousel-skin-tango clearfix thumb">                 
		  <?php
                
                                $irts = 1;
                                foreach($arryProductAlternativeImages as $image){
                                     $ImageName = $image['Image'];
                                     
                                      $ImageId = $image['Iid'];
                                      if ($ImageName != '' && file_exists('upload/products/images/secondary/'.$Config['CmpID'].'/' . $ImageName)) {   
                                      $ImagePath = '../resizeimage.php?img=upload/products/images/secondary/'.$Config['CmpID'].'/' . $ImageName . '&w=70&h=60';
                                      $showImage =  '<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle" align="center"><a data-fancybox-group="gallery" class="fancybox" href="../upload/products/images/secondary/'.$Config['CmpID'].'/'.$ImageName.'"><img src="' . $ImagePath . '" border=0 ></a></td>
              </tr>
            </table>';
                                  }
                             ?>
				
                          <li>
                             <?=$showImage;?>
                        </li>   
						
                                <?php 
		              }
		        ?>
                         
		
                </ul>
               <?php }?>     
            </div>                
            </div>
            <div class="right">
            	<div class="price"><?=$SalePriceHTML?></div>
                <div class="priceStrike"><?=$PriceHTML?></div>
                <div class="rows">
                    <span><?=PRODUCT_SKU?>:</span> <?=$arryProductDetail[0]['ProductSku']?>
                </div>
                <?php if(!empty($ManufacturerName)){?>
                <div class="rows">
                    <span><?=MANUFACTURER?>:</span> <?=$ManufacturerName?>
                </div>
                <?php }?>
                <div class="rows">
                    <span><?=WEIGHT?>(<?=WEIGHT_UNIT?>):</span> <?=$arryProductDetail[0]['Weight']?>
                </div> 
                 <!---Code For Product QUANTITY -->
                <div class="quantity">
                	<span><?=QUANTITY?>:</span>
                     
                         <div class="formfield">
                    <fieldset>
                    <input name="Quantity" id="Quantity" type="text" value="1" />
                    </fieldset>
                    <fieldset>
                    <input name="Price" id="Price" type="hidden" value="<?=round($SalePrice,2)?>" />
                    <input name="ProductID" id="ProductID" type="hidden" value="<?=$arryProductDetail[0]['ProductID']?>" />
                    <input name="AvailableQuantity"  id="AvailableQuantity" value="<?=$arryProductDetail[0]['Quantity']?>" type="hidden" /> 
                    <input name="InventoryControl"  id="InventoryControl" value="<?=$arryProductDetail[0]['InventoryControl']?>" type="hidden" /> 
                     <input name="Weight" id="Weight" type="hidden" value="<?=$arryProductDetail[0]['Weight']?>" />
                    <input name="Tax" id="Tax" type="hidden" value="<?=$Tax?>" />
                    <input name="" type="submit" value="<?=ADD_TO_CART?>" />
                    </fieldset>
                         </div>
                  
                </div>
                <!-- End Code for Product QUANTITY-->
                
                
                <!---Code For Product Attribute -->
                <?php if(!empty($arryProductAttributes)){
                    $options = array();
                    foreach($arryProductAttributes as $key=>$attribute)
                    {   
                        $options = $objProduct->parseOptions($attribute['options']);     
                    ?>
                       
                        
                        <div class="product-attribute">
                            <label><?=stripslashes($attribute['caption'])?></label>
                        <div class="sel-wrap-friont">
                        <?php if ($attribute['attribute_type'] == "select") { ?>
                        <select id="attribute_input_<?=$attribute['paid']?>" name="oa_attributes[<?=$attribute['paid']?>]" onchange="calcAttrPrice()">
                         <?php foreach($options as $option) {  ?>
                         <option value="<?=trim($option)?>"><?=trim($option)?></option>
                         <?php }?>
                        </select>
                        <?php }?>
                        </div>
                        </div>
                        
                       <?php
                          }
                       
                       }?>
                <!-- End Code for Product Attribute-->
                
                 <!---Code For Product Discount -->
                <?php if(count($arryProductDiscount)>0){ ?>     
                <div class="product-special-offer-quantity">
                    <ul>
                   <?php foreach($arryProductDiscount as $key=>$discount){ 
                       
                       if($discount['discount_type'] == "percent"){$discountAmnt = number_format($discount['discount'],0)."%"; }else{$discountAmnt = $arryCurrency[0]['symbol_left'].number_format($discount['discount'],0);}
                       
                       ?>     
                      <li>
                       <?=BUY?> <?=$discount['range_min']?> - <?=$discount['range_max']?> <?=GET_AN_ADDITIONAL?> <?=$discountAmnt;?> <?=OFF?><br>
                      </li>
                    <?php }?>
                    </ul>
                </div>
                <?php }?>
                 <!-- End Code for Product Discount-->
                <div class="emailto_f">
                    <?php if($settings['EnableEmailToFriend'] == "Yes"){?>
                    <a class="fancybox" href="#emailTo_Friend_div"><?=EMAIL_TO_FRIEND?></a> <span class="div"></span>
                    <?php }?>
                 <?php if($settings['EnableWishList'] == "Yes"){?>   
                 <?php if(!empty($_SESSION['Cid'])){?>    
                  <a  class="fancybox addtowish" href="#add_ProductWishList_div" ><?=ADD_TO_WISHLIST?></a>
                <?php } else {?>
                  <a href="login.php?ref=<?=$ThisPage;?>?id=<?=$arryProductDetail[0]['ProductID']?>" class="addtowish"><?=ADD_TO_WISHLIST?></a>
                 <?php }?>
                 <?php }?> 
                </div>
                <div class="reviews">
                    <div title="<?=number_format($AvgProductRating,2);?>" class="rating-value" id="product-rating"></div>
                    <div class="reviewsright"> 
                <?=REVIEWS?> (<span><?=count($arryProductReview);?></span>)</div>
                </div>
                 
                 <?php if($settings['facebookLikeButtonProduct'] == "Yes"){?>
                 <div class="product-facebook-like-button">
                 <iframe src="http://www.facebook.com/plugins/like.php?href=<?=urlencode($PrdLink);?>&amp;send=false&amp;layout=button_count&amp;
                    width=90&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=20" scrolling="no" frameborder="0" 
                    style="border:none; overflow:hidden; width:90; height:25px;" allowTransparency="true"></iframe>
                </div>
                 <?php }?>
                <?php if($settings['TwitterTweetButton'] == "Yes"){?>
                 <div class="product-twitter-tweet-button" style="float:left;">
                     <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?=$PrdLink?>" data-count="horizontal" data-via="<?=$settings['TwitterAccount']?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                </div>
                 <?php }?>
                <?php if($settings['GooglePlusButton'] == "Yes"){?>
                    <div class="product-google-plus-button">
                     <!-- Place this tag where you want the +1 button to render. -->
                          <div class="g-plusone" data-size="medium"></div>

                    <!-- Place this tag after the last +1 button tag. -->
                    <script type="text/javascript">
                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                </div>
             <?php }?>
              


            </div>
          </div>
         </form>
           <div class="taber">
            <ul class="tabs" id="toggle" style="padding-left:0px; height:34px;">  
            <li  id="tt1" onclick="st2('1')"><a href="javascript:undefined" id="aa1" <?php if(!empty($_GET['review'])){?><?php }else{?>class="active"<?php }?>><span><?=DESCRIPTION?></span></a></li>
            <li  id="tt2" onclick="st2('2')"><a  href="javascript:undefined" id="aa2" <?php if(!empty($_GET['review'])){?>class="active"<?php }else{?><?php }?>><span><?=REVIEWS?>(<?=count($arryProductReview);?>)</span></a></li>
             <?php if(count($arryProductRecommended) > 0) {?>   
             <li  id="tt3" onclick="st2('3')"><a href="javascript:undefined" id="aa3" ><span><?=RECOMMENDED_PRODUCT?></span></a></li>
             <?php }?>
            </ul>
            <div class="bb" style="">
            <div <?php if(!empty($_GET['review'])){?>style="display: none; visibility: hidden;"<?php }else{?>style="display: block; visibility: visible;"<?php }?> id="dd1">
                    <?=stripslashes($arryProductDetail[0]['Detail'])?>
            </div>
            <div  <?php if(!empty($_GET['review'])){?>style="display: block; visibility: visible;"<?php }else{?>style="display: none; visibility: hidden;"<?php }?> id="dd2" class="display">
                        
                
                <div class="logregi">
                <?php if(!empty($_SESSION['Cid'])){?>
                 <a class="fancybox" href="#write_review_div"><?=WRITE_REVIEW?></a>
                <?php }else{?>
                 <a href="login.php?ProductId=<?=$arryProductDetail[0]['ProductID'];?>"><?=LOGIN?></a> <?=ORR?> <a href="register.php?ProductId=<?=$arryProductDetail[0]['ProductID'];?>"><?=REGISTER?></a> <?=TO_WRITE_REVIEW?>
                <?php }?>
                </div>
              <?php foreach($arryProductReview as $key=>$review){?>  
               <div class="product-review-item">
                
                <div class="col-70">
                    <h5><?=stripslashes($review['ReviewTitle']);?></h5>
                <div class="gap-left">
                <?=stripslashes($review['ReviewText']);?>
                </div>
                    <div title="<?=$review['Rating'];?>" class="product-review-item-rating"></div>
                    <b style=" color:#636363;">Reviewed by <?=ucfirst($review['FirstName']);?></b>
                <em style=" color: #A9A9A9;"><?=date($Config['DateFormat'],strtotime($review["DateCreated"]))?></em>
                </div>
             </div>
             <?php }?> 
            </div>  
            <?php if(count($arryProductRecommended) > 0) {?>   
                <div  style="display: none; visibility: hidden;" id="dd3">
                      <?php include("recommended_products.php");?>
                </div>     
             <?php }?>   
            </div>
            <!--<div class="b_bot"><img align="right" width="10" vspace="0" hspace="0" height="10" src="corn2.gif"> <img align="left" width="10" vspace="0" hspace="0" height="10" src="corn1.gif"> </div>-->
            </div>
          
        </div>
       <?php } else {?>
          <b>This product is temporarily unavailable.</b>
        <?php }?>  
      </div>
    </div>
  </div>
<?include("includes/html/box/emailto_friend_form.php");?>
<?include("includes/html/box/write_review.php");?>
<?include("includes/html/box/add_ProductWishList.php");?>
<?include("includes/html/box/create_ProductWishList.php");?>
