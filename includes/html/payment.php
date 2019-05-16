<div class="main-container">
  <div class="mid_wraper clearfix">
    <div class="full_layout">
      <div class="cart_page checkout payment">
        <h1><?=CHECKOUT?></h1>
       <form action="payment_process.php"  method="post" name="PaymentProcess" id="PaymentProcess">
        <div class="layout-zone-content layout-zone clearfix "id="content">
          <div style="padding-top:10px;" class="col-wrap spacer clearfix">
            <div id="div_billing_address" class="col-50 div-billing-address">
              <div class="fieldset gap-right ">
                <fieldset class="formFieldSet">
                <legend class="formHeader"><?=BILLING_ADDRESS?></legend>
               
                <div class="msg-notice spacer no-space-top"> 
                   <? echo stripslashes($BillingName); ?>
                   
                    <br>
                <? echo stripslashes($BillingAddress); ?>, <br>
                  <?=$BillingCityName?>, <?=$BillingStateName?><br>
                  <?=$BillingCountryName?>, <? echo stripslashes($BillingZipCode); ?><br>
                  Phone Number : <?=$BillingPhone;?>
                </div>
                 <input name="BillingName" type="hidden"  value="<? echo stripslashes($BillingName); ?>" />
                 <input name="BillingCompany" type="hidden"  value="<? echo stripslashes($BillingCompany); ?>" />
                 <input name="BillingAddress" type="hidden"  value="<? echo stripslashes($BillingAddress); ?>" />
                 <input name="BillingCity" type="hidden"  value="<? echo stripslashes($BillingCityName); ?>" />
                 <input name="BillingState" type="hidden"  value="<? echo stripslashes($BillingStateName); ?>" />
                 <input name="BillingCountry" type="hidden"  value="<? echo stripslashes($BillingCountryName); ?>" />
                 <input name="BillingZip" type="hidden"  value="<? echo stripslashes($BillingZipCode); ?>" />
                 <input name="Phone" type="hidden"  value="<? echo stripslashes($BillingPhone); ?>" />
                 <input name="Email" type="hidden"  value="<? echo stripslashes($BillingEmail); ?>" />
                </fieldset>
              </div>
            </div>
            <div id="div_shipping_address" class="col-50 col-right div-shipping-addres">
              <div class="fieldset gap-left ">
                <fieldset class="formFieldSet">
                <legend class="formHeader"><?=SHIPPING_ADDRESS?></legend>
              
                <div class="msg-notice spacer no-space-top">
                    <?=$ShippingName;?>
                    <br>
                 <?=$ShippingAddress;?>, <br>
                  <?=$ShippingCity?>, <?=$ShippingState?><br>
                  <?=$ShippingCountry?>, <?=$ShippingZip;?>  <br>
                  Phone Number : <?=$ShippingPhone;?>
                </div>
                
                 <input name="AddressType" type="hidden"  value="<?=$_SESSION['AddressType'];?>" />
                 <input name="ShippingName" type="hidden"  value="<?=$ShippingName;?>" />
                 <input name="ShippingCompany" type="hidden"  value="<?=$ShippingCompany;?>" />
                 <input name="ShippingAddress" type="hidden"  value="<?=$ShippingAddress;?>" />
                 <input name="ShippingCity" type="hidden"  value="<?=$ShippingCity;?>" />
                 <input name="ShippingState" type="hidden"  value="<?=$ShippingState;?>" />
                 <input name="ShippingCountry" type="hidden"  value="<?=$ShippingCountry;?>" />
                 <input name="ShippingZip" type="hidden"  value="<?=$ShippingZip;?>" />
                 <input name="ShippingPhone" type="hidden"  value="<?=$ShippingPhone?>" />
                 
                </fieldset>
              </div>
            </div>
          </div>
          <div id="div_edit_addresses_link" class="buttons button_left"> <a class="editca" href="checkout.php<?php if(!empty($_SESSION["guestId"])) {?>?user=guest<?php }?>"><?=EDIT_ADDRESS?></a> </div>
          <div class="spacer">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table_content invoice">
              <thead>
              <tr>
                <th class="ali_left"><?= DESCRIPTION ?></th>
                <th>&nbsp;</th>
                <th class="ali_center"><?= PRICE ?></th>
                <th class="ali_center"><?= QUANTITY ?></th>
                <th class="ali_center"><?= TOTAL ?></th>
              </tr>
              </thead>
              <tbody>
               <?php
              
              
                                if (is_array($arryCart)) {
                                    $Count = 0;
                                    $SubTotal = 0;
                                    $TaxAmount = 0;
                                    $ProductIDs ='';
                                    $TotalWeight = 0;
                                    
                                    foreach ($arryCart as $key => $values) {
                                        $Count++;
                                        $SubTotal += $values['Quantity'] * $values['Price'];
                                        $ProductIDs .= $values['ProductID'] . ",";
                                        $TotalQuantity += $values['Quantity'];
                                        $TaxAmount += $values['Quantity']*$values['Price']*$values['TaxRate']/100;

                                        $PrdLink = 'productDetails.php?id=' . $values['ProductID'];
                                        
                                         $TotalWeight += ($values['Quantity']*$values['Weight']);


                                        if ($values['Image'] != '' && file_exists('upload/products/images/'.$Config['CmpID'].'/' . $values['Image'])) {
                                            $ImagePath = 'resizeimage.php?img=upload/products/images/'.$Config['CmpID'].'/' . $values['Image'] . '&w=73&h=73';
                                            $ImagePath = '<img src="' . $ImagePath . '"  border="0"  alt="' . stripslashes($values['Name']) . '" title="' . stripslashes($values['Name']) . '"/>';
                                        } else {
                                            $ImagePath = '<img src="./../images/no.jpg" border="0"  alt="' . stripslashes($values['Name']) . '" title="' . stripslashes($values['Name']) . '" width="65">';
                                        }

                                        $ImagePathLink = '<a href="' . $PrdLink . '">' . $ImagePath . '</a>';
                                        ?>    
                <tr>
                  <td width="300">
                    <div class="img">
                    <?= $ImagePathLink ?>
                  </div>                   
                  
                  <div class="pr_name"> <a class="name" href="<?= $PrdLink ?>"><?= ucfirst(stripslashes($values['Name'])) ?> </a>
                                     
                    <?php echo '<br>Product Sku: ' . stripslashes($values['ProductSku']);?>
                      
                     <br> Weight(<?=WEIGHT_UNIT?>): <?=$values['Weight']?>
                    <ul style="margin: 5px; list-style: none;">
                      <li><?php if(!empty($values['Options'])) {    echo nl2br($values['Options']);   }  ?></li>
                    </ul>
                   
                  </div>                     
                       </td>
                       <td></td>
                  <td class="ali_center right_div" width="100"><?= display_price($values['Price'], '', '', $arryCurrency[0]['symbol_left'], $arryCurrency[0]['symbol_right']) ?> <br>
                  <?php if(!empty($values['TaxDescription'])) { ?><?=$values['TaxDescription']?><?php } ?>
                  </td>
                  <td class="ali_center right_div" width="100"><?php echo $values['Quantity']; ?></td>
                  <td class="ali_center right_div" width="100"><?= display_price($values['Quantity'] * $values['Price'], '', '', $arryCurrency[0]['symbol_left'], $arryCurrency[0]['symbol_right']) ?></td>
                </tr>
                <tr>
                <td class="botline" colspan="5"><div class="line"></div></td>
              </tr>
                <?php } }
                
                $ProductIDs = rtrim($ProductIDs,",");
                $_SESSION['TotalQuantity'] = rtrim($TotalQuantity,",");
                $SubTotalPrice = $SubTotal;
                $TotalPrice =  $SubTotal+$shippingCharge+$TaxAmount;
                if($_SESSION['discountAmount'] > 0)
                 {
                    $TotalPrice = $TotalPrice-$_SESSION['discountAmount'];
                 }
                 if($_SESSION['promo_discount_amount'] > 0)
                 {
                     $TotalPrice = $TotalPrice-$_SESSION['promo_discount_amount'];
                 }
                ?>
              </tbody>
              <tfoot>
              
              <tr>
              	<td colspan="3">
                	<div class="button_left edit">
                    <a class="editca" href="cart.php"><?=EDIT_CART?></a>
                  </div>
                </td>
                <td class="ali_right" colspan="2">
                     <div class="subtotal charge"> <b><?=SHIPPING_CHARGE?>:</b>
                      <span align="right"> <?= display_price($shippingCharge) ?></span>
                </div>
                <div class="subtotal charge"> <b><?=TAX_CHARGE?>:</b>
                    <span align="right"> <?= display_price($TaxAmount) ?></span>
                </div>
                 <?php if($_SESSION['discountAmount'] > 0){?>    
                 <div class="subtotal charge"> <b>Discount:</b>
                    <span align="right"> -<?= display_price($_SESSION['discountAmount']) ?></span>
                </div>  
                <?php }?>    
                 <?php if($_SESSION['promo_discount_amount'] > 0){?>    
                 <div class="subtotal charge"> <b>Coupon Discount:</b>
                    <span align="right"> -<?= display_price($_SESSION['promo_discount_amount']) ?></span>
                </div>  
                <?php }?>       
                <div class="subtotal charge"> <b><?=TOTAL_CHARGE?>:</b>
                    <span align="right"> <?= display_price($TotalPrice) ?></span>
                </div>
                </td>
              </tr>
              <tr>
                <td class="botline" colspan="5"><div class="line"></div></td>
              </tr>
              <tr>
                <td class="ali_right" colspan="5">
                <div class="subtotal"><b><?=DELIVERY_DATE?>:</b>
                    <?=$_SESSION['DelivaryDate'];?></div>
                </td>
              </tr>
              
          
              
                
               <tr>
                <td class="botline" colspan="5"><div class="line"></div></td>
              </tr>
              <tr class="payment_method_tr">
                <td colspan="3"><div class="spacer">
        <div class="fieldset div-payment-methods ">
        <h4><?=PLEASE_SELECT_PAYMENT?></h4>
        <div id="dvGiftCertPayment1">
            <?php foreach($arrayPaymentMethods as $method){?>
            <div class="option clearfix">
                <div class="col-30" style=" float: left; width: 250px;">
                <input type="radio" id="<?=$method['PaymetMethodId']?>" value="<?=$method['PaymetMethodId']?>" class="selectPaymentMethod"  name="payment_method">
                <label><?=$method['PaymentMethodTitle']?></label>
                </div>
                <div class="paymentDescription" id="paymentDescription_<?=$method['PaymetMethodId']?>" style=" float: right;width: 500px; display: none;"><?=$method['PaymentMethodMessage']?></div>
            </div>
            <?php }?>
        </div>
        </div>
        </div></td>
        <td class="ali_right"  colspan="2">
        <div class="checkout">
                <input type="hidden" name="DelivaryDate" value="<?=$_SESSION['DelivaryDate']?>">
                <input type="hidden" name="ShippingMethod" id="ShippingMethod" value="<?=$shippingMethod[0]['CarrierName']?>" />
                <input type="hidden" name="Shipping" id="Shipping" value="<?=modified_price($shippingCharge)?>" />
                <input type="hidden" name="Cid" id="Cid" value="<?=$Cid; ?>" />
                <input type="hidden" name="Tax" id="Tax"  value="<?=modified_price($TaxAmount)?>" />
                <input name="ProductIDs" type="hidden" id="ProductIDs" value="<?=$ProductIDs?>" />
                <input name="SubTotalPrice" type="hidden" id="SubTotalPrice" value="<?=modified_price($SubTotalPrice)?>" />
                <input name="TotalPrice" type="hidden" id="TotalPrice" value="<?=modified_price($TotalPrice)?>" />
                <input name="Weight" type="hidden" id="Weight" value="<?=$TotalWeight?>" />
                <input name="WeightUnit" type="hidden" id="WeightUnit" value="lbs" />
                <input name="currency_id" type="hidden" id="currency_id" value="<?=$_SESSION['currency_id']?>" /> 
                <input type="hidden" name="TotalQuantity" id="TotalQuantity" value="<?=$_SESSION['TotalQuantity']?>" />
                
                <input name="DiscountAmount" type="hidden" id="DiscountAmount" value="<?=modified_price($_SESSION['discountAmount'])?>" />     
                <input name="DiscountValue" type="hidden" id="DiscountValue" value="<?=$_SESSION['discountValue']?>" />  
                <input name="DiscountType" type="hidden" id="DiscountType" value="<?=$_SESSION['discountType']?>" />     
                
                
                <input name="PromoCampaignID" type="hidden" id="PromoCampaignID" value="<?=$_SESSION['promo_campaign_id']?>" />     
                <input name="PromoDiscountAmount" type="hidden" id="PromoDiscountAmount" value="<?=modified_price($_SESSION['promo_discount_amount'])?>" />  
                
              
              <input type="submit" id="btnPurchase30" value="<?=PURCHASE?> &gt;&gt;" class="button-purchase button-cart_ccs button ">
          </div>
          </td>
              </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
</div>
 
