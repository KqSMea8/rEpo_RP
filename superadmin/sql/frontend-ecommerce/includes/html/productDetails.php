<script language="JavaScript1.2" type="text/javascript">
    //By chetan 11Sep//
    $(function () {

        $('#variant').on('change', function () {
            $.ajax({
                url: "ajax.php",
                method: "GET",
                data: {action: 'variantData', VariantId: $(this).val()},
                success: function (responseText) {

                    $('#ajaxdata').html(responseText);
                }
            });
        });


        $(document).on('change', '#varselect', function () {

            $('#variantVal').val($(this).val());
        })


    });

    function display_price(Price){ 
       
    	var CurrencySymbol='<?php echo $Config['CurrencySymbol']; ?>';
    	var CurrencyValue='<?php echo $Config['CurrencyValue']; ?>';
    	var CurrencySymbolRight='<?php echo $Config['CurrencySymbolRight']; ?>';
    	
    	var final_price = CurrencySymbol+''+Price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");+''+CurrencySymbolRight;

    	return final_price;
    	}
//End//
</script>   




<div class="clearfix"></div>
<div class="product-detail">
    <?php if (!empty($_SESSION['successMsg'])) { ?>
        <div class="successMsg">
            <?php echo $_SESSION['successMsg']; ?>
            <?php unset($_SESSION['successMsg']); ?>
        </div>
    <?php } ?>
    <?php if (!empty($_SESSION['errorMsg'])) { ?>
        <div class="warningMsg">
            <?php echo $_SESSION['errorMsg']; ?>
            <?php unset($_SESSION['errorMsg']); ?>
        </div>
    <?php } ?>
    <?php if ($arryProductDetail[0]['ProductID'] > 0) { ?>  
        <div class="row product-details">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div id="myCarousel" class="carousel slide">
                    <?php
                    //list($width_orig, $height_orig) = getimagesize('upload/products/'.$arryProductDetail[0]['Image']);

                    if ($width_orig >= 350 || $height_orig >= 350) {
                        $zoom_apend = ' data-zoomsrc=' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/' . $arryProductDetail[0]['Image'] . '" id="myimage"';

                        $TextClickImage = 'Rollover image above to zoom';
                    } else {
                        $TextClickImage = 'Click image above to enlarge';
                    }


                    $ImagePath = 'resizeimage.php?img=' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/' . $Config['CmpID'] . '/' . $arryProductDetail[0]['Image'] . '&w=1000&h=500';
                    ?>
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <?php if (count($arryProductAlternativeImages) > 0) { ?>
                            <?php
                            $irts = 1;
                            foreach ($arryProductAlternativeImages as $image) {
                                if ($ImageName != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/secondary/' . $Config['CmpID'] . '/' . $ImageName)) {
                                    echo '<li data-target="#myCarousel" data-slide-to="' . $irts . '" class=""></li>';
                                }

                                $irts++;
                            }
                        }
                        ?>

                    </ol>
                    <div class="carousel-inner">
                        <div class="item active"><?php if (!empty($arryProductDetail[0]['Image'])) { ?>
                                <a data-fancybox-group="gallery" class="fancybox"  href="<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>/erp/upload/products/images/<?= $Config['CmpID'] . '/' . $arryProductDetail[0]['Image']; ?>" >
                                    <img src="<?= $ImagePath; ?>" title="<?= ucfirst(stripslashes($arryProductDetail[0]['Name'])) ?>"  class="img-responsive"/>                     
                                </a>


                            <?php } else { ?>
                                <img src="images/no.jpg" title="<?= ucfirst(stripslashes($arryProductDetail[0]['Name'])) ?>" />
                            <?php } ?>
                        </div>
                        <?php if (count($arryProductAlternativeImages) > 0) { ?>

                            <?php
                            $irts = 1;
                            foreach ($arryProductAlternativeImages as $image) {
                                $ImageName = $image['Image'];

                                $ImageId = $image['Iid'];
                                if ($ImageName != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/secondary/' . $Config['CmpID'] . '/' . $ImageName)) {
                                    $ImagePath = '../resizeimage.php?img=' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/secondary/' . $Config['CmpID'] . '/' . $ImageName . '&w=320&h=400';
                                    $showImage = '<a data-fancybox-group="gallery" class="fancybox" href="' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/secondary/' . $Config['CmpID'] . '/' . $ImageName . '"><img src="' . $ImagePath . '" class="img-responsive"></a>';
                                    echo ' <div class="item"> ' . $showImage . '</div>';
                                }
                                ?>


                                <?php
                            }
                            ?>



                        <?php } ?> 

                    </div>
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="icon-prev"></span></a> 
                    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="icon-next"></span></a> 
                </div>



            </div>
            <!-- /.col-xs-12 col-sm-12 col-md-6 .carousel -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 product-single">
            <form name="formQnt"  <?= $formMethod ?>  onsubmit="return validateProductQuantity(this);"  enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12">
                        	<?php 
                        	// Added by karishma 13 oct 2015 for Alias
                        	$ProductName=$arryProductDetail[0]['Name'];
                        	 if(!empty($arryProductDetail[0]['AliasID'])){
                        	 	$ProductName=$arryProductDetail[0]['ItemAliasCode'];
                        	 }
                        	?>
                            <h2><?= ucfirst(stripslashes($ProductName)) ?></h2>
                            <p class="product-price-div"><?= $PriceHTML ?></p>
                            <p class="lead text-danger"><strong>NOW <span id="salePriceHtml"><?= $SalePriceHTML ?></span></strong></p>
                            <ul class="hidden-xs product-sku">
                                <li><span><?= PRODUCT_SKU ?>:</span> <?= $arryProductDetail[0]['ProductSku'] ?></li>
                                <?php if (!empty($ManufacturerName)) { ?>
                                    <li>
                                        <span><?= MANUFACTURER ?>:</span> <?= $ManufacturerName ?>
                                    </li>
                                <?php } ?>
                                <?php if ($arryProductDetail[0]['Weight'] != '0.00') { ?>
                                    <li id="weightHtml"><span><?= WEIGHT ?>(<?= WEIGHT_UNIT ?>):</span> <?= $arryProductDetail[0]['Weight'] ?></li>
                                <?php } ?>


                            </ul>

                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12" style="margin-bottom:10px;"> 
                            
                            <div class="row" style="margin-bottom:10px;">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6c col-variant"><?= QUANTITY ?>:</div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <input name="Quantity" id="Quantity" type="text" value="1"  class="form-control" />
                                    <fieldset>
                                    	<?php 
                                    	if(!empty($arryProductDetail[0]['AliasID'])){
                                    		echo '<input name="AliasID" id="AliasID" type="hidden" value="'.$arryProductDetail[0]['AliasID'].'" />';
                                    	}
                                    	?>
                                    	
                                        <input name="Price" id="Price" type="hidden" value="<?= round($SalePrice, 2) ?>" />
                                        <input name="ProductID" id="ProductID" type="hidden" value="<?= $arryProductDetail[0]['ProductID'] ?>" />
                                        <input name="DefaultOQantity"  id="DefaultOQantity" value="<?= $settings['DefaultOQantity'] ?>" type="hidden" /> 
                                        <input name="AvailableQuantity"  id="AvailableQuantity" value="<?= $arryProductDetail[0]['Quantity'] ?>" type="hidden" /> 
                                        <input name="InventoryControl"  id="InventoryControl" value="<?= $arryProductDetail[0]['InventoryControl'] ?>" type="hidden" /> 
                                        <input name="Weight" id="Weight" type="hidden" value="<?= $arryProductDetail[0]['Weight'] ?>" />
                                        <input name="Tax" id="Tax" type="hidden" value="<?= $Tax ?>" />

                                    </fieldset>
                                </div>
                                <!--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="margin-bottom:10px;">
                                    <select class="form-control">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                        <option>Option  5</option>
                                    </select>
                                </div>
                                -->
                            </div>
                     <!---Code For Product Attribute -->
    <?php

    if (!empty($arryProductAttributes)) {
    	
        //$options = array();
        $var=0;
        foreach ($arryProductAttributes as $key => $attribute) {
            //
            
        	        	
            $requiredhtml=($attribute['required']==1)? '<span class="red">*</span>':'';
			if($attribute['gaid']!=0) {
			$options = $objProduct->GetOptionList($attribute['gaid'],0);
				
			}else {
				$options = $objProduct->GetOptionList($attribute['gaid'],$attribute['paid']);
			}
			//else $options = $objProduct->parseOptions($attribute['options']);
			
			
            ?>


                                <div class="row" style="margin-bottom:10px;"><div class="col-xs-12 col-sm-12 col-md-6 col-lg-6c col-variant"><?= stripslashes($attribute['caption']) ?><?php echo $requiredhtml;?></div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php if ($attribute['attribute_type'] == "select") { ?>
            								<input type="hidden" readonly="readonly" name="requireattr[]" id="requireattr<?php echo $var;?>" value="<?=$attribute['required'] ?>">
                                            <input type="hidden" readonly="readonly" name="compulsoryattr[]" id="compulsoryattr<?php echo $var;?>" value="<?= $attribute['paid'] ?>">
                                            <select id="attribute_input_<?= $attribute['paid'] ?>" name="oa_attributes[<?= $attribute['paid'] ?>]" class="form-control"  style="width:257px" onchange="calcAttrPrice()">
               
               <option value="">Select</option>
                <?php foreach ($options as $option) { 
                	 echo '<option value="'. $option['Id'].'">'.$option['title'].'</option>';
                	
                	
                	?>
                									<!--<option value="<?= trim($option) ?>"><?= trim($option) ?></option>
                									
                                                    <option value="<?= $option['title'] ?>(<?=$option['Price']?>,<?=$option['Weight']?>):<?=$option['PriceType']?>"><?= $option['title'] ?></option>
                                            --><?php } ?>
                                            </select>
                                            <?php } ?>
                                    </div>
                                </div>

                                        <?php
                                        $var++;
                                    }
                                }
                                
                               
                                ?>
                                <?php if($arryProductDetail[0]['is_upld']==1){?>
                                <div style="margin-bottom:10px;" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6c col-variant"><?php echo $arryProductDetail[0]['label_txt']?></div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <input type="file"  value="" id="uploadFile" name="uploadFile">
                                   
                                </div>
                               
                            </div>
                            <?php }?>
                                
                        <!-- End Code for Product Attribute--><!--
                            <?php
                            //By Chetan 11Sep//
                            /*if ($arryProductDetail[0]['variant_id']) {
                                $objVariant = new varient();
                                $variants = $objVariant->GetVariantDispaly($arryProductDetail[0]['variant_id']);
                                ?>
                                <p> <?= Configure ?>:</p>*/



                                
                                
								/*$var=0;
                                foreach ($variants as $variant) {
                                    

                                    $variantArray = $objvariant->GetVariant($variant['id']);
									$AjaxHtml='';
									
                                    foreach ($variantArray as $varvalues) {
                                    	$requiredhtml=($varvalues['required']==1)? '<span class="red">*</span>':'';
                                    	echo '<div class="row" style="margin-bottom:10px;"><div class="col-xs-12 col-sm-12 col-md-6 col-lg-6c col-variant">' . $variant['variant_name'] . $requiredhtml.'</div>';
                                      
                                        $AjaxHtml.='<input type="hidden" readonly="readonly" name="variantID['.$varvalues['id'].']" id="variantID'.$var.'" value="' . $varvalues['id'] . '">';
                                        $AjaxHtml.='<input type="hidden" readonly="readonly" name="compulsory[]" id="compulsory" value="' . $varvalues['required'] . '">';
                                        if ($varvalues['variant_type_id'] == '4') {

                                            $arryvariantm = $objvariant->GetMultipleVariantOption($varvalues['id']);

                                            if (!empty($arryvariantm)) {
                                                $AjaxHtml.='<select name="varselect['.$varvalues['id'].'][]" id="varselect'.$var.'" multiple class="form-control"  style="width:200px">';
                                                foreach ($arryvariantm as $val) {
                                                    $AjaxHtml.='<option value="' . $val['id'] . '">' . $val['option_value'] . '</option>';
                                                }
                                                $AjaxHtml.='</select>';
                                            }
                                        } elseif ($varvalues['variant_type_id'] == '5') {
                                            $arryvariantd = $objvariant->GetMultipleVariantOption($varvalues['id']);


                                            if (!empty($arryvariantd)) {
                                                $AjaxHtml.='<select name="varselect['.$varvalues['id'].']" id="varselect'.$var.'" class="form-control" style="width:200px">';
                                                $AjaxHtml.='<option value="">Select</option>';
                                                foreach ($arryvariantd as $val) {
                                                    $AjaxHtml.='<option value="' . $val['id'] . '">' . $val['option_value'] . '</option>';
                                                }
                                                $AjaxHtml.='</select>';
                                            }
                                        }
                                    }

                                    echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											'.$AjaxHtml.'
										</div>
								</div>  ';
                                    $var++;
                                }*/
                                ?>






    <?php //}//End//  ?>


                            --><div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> <input name="" class="btn btn-block btn-warning" type="submit" value="<?= ADD_TO_CART ?>" />  </div>
                                <!--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> <a class="btn btn-block btn-default" href="#" title="" style="margin-bottom:10px;">SAVE FOR LATER</a> </div>
                                -->
                            </div>
                        </div>
						<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> 
                            <!---Code For Product Discount -->
                            <?php if (count($arryProductDiscount) > 0) { ?>     
                                <div class="product-special-offer-quantity">
                                    <ul>
            <?php
            foreach ($arryProductDiscount as $key => $discount) {
    
                if ($discount['discount_type'] == "percent") {
                    $discountAmnt = number_format($discount['discount'], 0) . "%";
                } else {
                    $discountAmnt = $arryCurrency[0]['symbol_left'] . number_format($discount['discount'], 0);
                }
                ?>     
                                            <li>
                                            <?= BUY ?> <?= $discount['range_min'] ?> - <?= $discount['range_max'] ?> <?= GET_AN_ADDITIONAL ?> <?= $discountAmnt; ?> <?= OFF ?><br>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <!-- End Code for Product Discount-->
                            <div class="emailto_f">
        <?php if ($settings['EnableEmailToFriend'] == "Yes") { ?>
                                    <a class="fancybox btn btn-info" href="#emailTo_Friend_div"><?= EMAIL_TO_FRIEND ?></a> <span class="div"></span>
                            <?php } ?>
        <?php if ($settings['EnableWishList'] == "Yes") { ?>   
                                    <?php if (!empty($_SESSION['Cid'])) { ?><!--    
                                        <a  class="fancybox addtowish btn btn-info" href="#add_ProductWishList_div" ><?= ADD_TO_WISHLIST ?></a>
                                    -->
                                    <input type="button" value="<?= ADD_TO_WISHLIST ?>" class="addtowish btn btn-info" onclick="Javascript:validateWishList();" name="add_wish">
                                   
                                    <?php } else { ?>
                                        <a href="login.php?ref=<?= $ThisPage; ?>?id=<?= $arryProductDetail[0]['ProductID'] ?>" class="addtowish btn btn-info"><?= ADD_TO_WISHLIST ?></a>
                                    <?php } ?>
                                <?php } ?> 
                            </div>
                            <div class="reviews">
                                <div title="<?= number_format($AvgProductRating, 2); ?>" class="rating-value" id="product-rating"></div>
                                <div class="reviewsright"> 
                                <?= REVIEWS ?> (<span><?= count($arryProductReview); ?></span>)</div>
                            </div>
    
                            <div style="clear:both;">
    
                                    <?php if ($settings['facebookLikeButtonProduct'] == "Yes") { ?>
                                    <span>
                                        <iframe src="http://www.facebook.com/plugins/like.php?href=<?= urlencode($PrdLink); ?>&amp;send=false&amp;layout=button_count&amp;
                                                width=90&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=20" scrolling="no" frameborder="0" 
                                                style="border:none; overflow:hidden; width:90; height:25px;" allowTransparency="true"></iframe>
                                    </span>
        <?php } ?>
        <?php if ($settings['TwitterTweetButton'] == "Yes") { ?>
                                    <span>
                                        <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?= $PrdLink ?>" data-count="horizontal" data-via="<?= $settings['TwitterAccount'] ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                                    </span>
                                <?php } ?>
                                <?php if ($settings['GooglePlusButton'] == "Yes") { ?>
                                    <span>
                                        <!-- Place this tag where you want the +1 button to render. -->
                                        <div class="g-plusone" data-size="medium"></div>
    
                                        <!-- Place this tag after the last +1 button tag. -->
                                        <script type="text/javascript">
                                            (function () {
                                                var po = document.createElement('script');
                                                po.type = 'text/javascript';
                                                po.async = true;
                                                po.src = 'https://apis.google.com/js/plusone.js';
                                                var s = document.getElementsByTagName('script')[0];
                                                s.parentNode.insertBefore(po, s);
                                            })();
                                        </script>
                                    </span>
        <?php } ?>
    
                            </div>
                         </div>
                    </div>
                
            </form>
			</div>
            <div class="col-xs-12 footer-tab-menu">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab"><?= DESCRIPTION ?></a></li>
                        <li class=""><a href="#profile" data-toggle="tab"><?= REVIEWS ?>(<?= count($arryProductReview); ?>)</a></li>
        <?php if (count($arryProductRecommended) > 0) { ?> 
                            <li class=""><a href="#recommd" data-toggle="tab"><?= RECOMMENDED_PRODUCT ?></a></li>
        <?php } ?>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <p><?= stripslashes($arryProductDetail[0]['Detail']) ?></p>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <p><?php if (!empty($_SESSION['Cid'])) { ?>
                                    <a class="fancybox btn btn-info" id="write_a" href="#write_review_div"><?= WRITE_REVIEW ?></a>
        <?php } else { ?>
                                    <a href="#mySignin"  role="button" class="btn btn-link" data-toggle="modal"><?= LOGIN ?></a> <?= ORR ?> <a href="#createaccount" role="button" class="btn btn-link" data-toggle="modal"><?= REGISTER ?></a> <?= TO_WRITE_REVIEW ?>
        <?php } ?>
        <?php foreach ($arryProductReview as $key => $review) { ?> 
                                <div class="product-review-item">
    
                                    <div class="col-70">
                                        <h5><?= stripslashes($review['ReviewTitle']); ?></h5>
                                        <div class="gap-left">
            <?= stripslashes($review['ReviewText']); ?>
                                        </div>
                                        <div title="<?= $review['Rating']; ?>" class="product-review-item-rating"></div>
                                        <b style=" color:#636363;">Reviewed by <?= ucfirst($review['FirstName']); ?></b>
                                        <em style=" color: #A9A9A9;"><?= date($Config['DateFormat'], strtotime($review["DateCreated"])) ?></em>
                                    </div>
                                </div>
        <?php } ?> 
    
                            </p>
                        </div>
                            <?php if (count($arryProductRecommended) > 0) { ?>  
                            <div class="tab-pane fade" id="recommd">
                                <p><?php include("recommended_products.php"); ?></p>
                            </div>
                        <?php } ?> 
    
                    </div>
            </div>    
        </div>
                <?php } else { ?>
        <b>This product is temporarily unavailable.</b>
<?php } ?>  
</div>
<!-- /container -->



<?php include("includes/html/box/emailto_friend_form.php"); ?>
<?php include("includes/html/box/write_review.php"); ?>
<?php include("includes/html/box/add_ProductWishList.php"); ?>
<?php include("includes/html/box/create_ProductWishList.php"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#write_a").fancybox({'width': 450,
            'height': 400,
            'autoSize': false});
    });
   

</script>
