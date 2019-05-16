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
    <div class="full_layout">
      <div class="cart_page">
        <h1>
          <?= YOUR_CART ?>
        </h1>
        <div>
          <? if(!empty($_SESSION['MsgCart'])) {echo $_SESSION['MsgCart']; unset($_SESSION['MsgCart']); 
				 }?>
        </div>
        <?php if ($numCart > 0) { ?>
        <form action=""  method="post" name="form1" id="form1" onsubmit="return validateCart(this);">
          <table width="100%" class="table_content" border="0" cellspacing="0" cellpadding="0">
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
                                    $VatAmount = 0;

                                    foreach ($arryCart as $key => $values) {
                                        $Count++;
                                        $SubTotal += $values['Quantity'] * $values['Price'];
                                        $ProductIDs .= $values['ProductID'] . ",";
                                        $TotalQuantity += $values['Quantity'];
                                        $VatAmount += $values['Quantity'] * $values['Tax'];

                                        $PrdLink = 'productDetails.php?id=' . $values['ProductID'];








                                        if ($values['Image'] != '' && file_exists('upload/products/images/'.$Config['CmpID'].'/' . $values['Image'])) {
                                            $ImagePath = 'resizeimage.php?img=upload/products/images/'.$Config['CmpID'].'/' . $values['Image'] . '&w=73&h=73';
                                            $ImagePath = '<img src="' . $ImagePath . '"  border="0"  alt="' . stripslashes($values['Name']) . '" title="' . stripslashes($values['Name']) . '"/>';
                                        } else {
                                            $ImagePath = '<img src="./../images/no.jpg" border="0"  alt="' . stripslashes($values['Name']) . '" title="' . stripslashes($values['Name']) . '" width="65">';
                                        }

                                        $ImagePathLink = '<a href="' . $PrdLink . '">' . $ImagePath . '</a>';
                                        ?>
              <tr>
                <td width="300"><div class="img">
                    <?= $ImagePathLink ?>
                  </div>
                  <div class="pr_name"> <a class="name" href="<?= $PrdLink ?>"><?= ucfirst(stripslashes($values['Name'])) ?>
                    </a>
                    <?php echo '<br>Product Sku: ' . stripslashes($values['ProductSku']);?>
                      
                     <br> Weight(<?=WEIGHT_UNIT?>): <?=$values['Weight']?>
                    
                    <a href="javascript:void();" class="deleteProduct" alt="<?=$Cid."#".$values['ProductID']."#".$values['CartID'];?>">Remove</a>
                    <input type="hidden" name="ProductID<?= $Count ?>" id="ProductID<?= $Count ?>" value="<?php echo $values['ProductID']; ?>" />
                     <input type="hidden" name="CartID<?= $Count ?>" id="CartID<?= $Count ?>" value="<?php echo $values['CartID']; ?>" />
                   
                  </div>
                 
                
                </td>
                <td> <?php
                     if(!empty($values['Options']))
                     {
                         echo nl2br($values['Options']);
                     }
                    
                    ?></td>
                <td width="100" class="ali_center right_div"><?= display_price($values['Price'], '', '', $arryCurrency[0]['symbol_left'], $arryCurrency[0]['symbol_right']) ?></td>
                <td width="100" class="ali_center right_div"><input name="Quantity<?= $Count ?>"  id="Quantity<?= $Count ?>" value="<?php echo $values['Quantity']; ?>" type="text" class="quantity_val" size="5" maxlength="3" style="width:40px;" />
                  <input name="AvailableQuantity<?= $Count ?>"  id="AvailableQuantity<?= $Count ?>" value="<?php echo $values['AvailableQuantity']; ?>" type="hidden" class="textfeild" size="5" />
                  <input name="InventoryControl<?= $Count ?>"  id="InventoryControl<?= $Count ?>" value="<?php echo $values['InventoryControl']; ?>" type="hidden" class="textfeild" size="5" />
                </td>
                <td width="100" class="ali_center right_div"><?= display_price($values['Quantity'] * $values['Price'], '', '', $arryCurrency[0]['symbol_left'], $arryCurrency[0]['symbol_right']) ?></td>
              </tr>
              <tr>
                <td colspan="6" class="botline"><div class="line"></div></td>
              </tr>
              <?php
        }
    }
    //$Tax = ($SubTotal * $arrayConfig[0]['Tax'])/100;
    //$Shipping = ($SubTotal * $arrayConfig[0]['Shipping'])/100;
    //$Total = $SubTotal + $Tax  + $Shipping;
    //$VatAmount = ($SubTotal * $_SESSION['VatPercentage'])/100;
    //$VatAmount = number_format($VatAmount,2,'.','');

    $Total = $SubTotal + $Tax + $VatAmount;

    $_SESSION['ProductIDs'] = rtrim($ProductIDs, ",");
    $_SESSION['TotalQuantity'] = rtrim($TotalQuantity, ",");

    //////////////////////////////////////////////////////

    $_SESSION['discountAmount'] = number_format($discountAmount, 2, '.', '');
    $_SESSION['Shipping'] = number_format($Shipping, 2, '.', '');
    $_SESSION['SubTotal'] = number_format($SubTotal, 2, '.', '');
    $_SESSION['Total'] = number_format($Total, 2, '.', '');
    ?>
            <input type="hidden" name="numCart" id="numCart" value="<?php echo $numCart; ?>" />
            <input type="hidden" name="Cid" id="Cid" value="<?php echo $Cid; ?>" />
            </tbody>
            
            <tfoot>
              <tr>
                <td><div class="button_left">
                    <input type="button" value="Continue Shopping" id="continueShopping" name="">
                  </div></td>
                <td></td>
                <td></td>
                <td></td>
                <td><div class="button_right">
                    <input type="hidden" name="TotalQuantity" id="TotalQuantity" value="<?php echo $TotalQuantity; ?>" />
                    <input name="ProductIDs" type="hidden" id="ProductIDs" value="<?php echo rtrim($ProductIDs, ","); ?>" />
                    <input name="CartSubmit" type="hidden" id="CartSubmit" value="1" />
                    <input name="Total" type="hidden" id="Total" value="<?php echo number_format($Total, 2, '.', ''); ?>" />
                    <input type="submit" value="Update" name="submit">
                  </div></td>
              </tr>
              <tr>
                <td colspan="6" class="botline"><div class="line"></div></td>
              </tr>
              <tr>
                <td colspan="6" class="ali_right"><div class="subtotal"> <b><?= SUB_TOTAL ?>:</b>
                    <?= display_price($SubTotal) ?>
                  </div></td>
              </tr>
              <?php if($discountAmount > 0){?>
               <tr>
                <td colspan="6" class="ali_right"><div class="subtotal"> <b><?=DISCOUNT?>:</b>
                   -<?= display_price($discountAmount) ?>
                  </div></td>
              </tr>
              <?php }?>
              
               <?php if($_SESSION['promo_discount_amount'] > 0){?>
               <tr>
                <td colspan="6" class="ali_right"><div class="subtotal"> <b><?=COUPON_DISCOUNT?>:</b>
                   -<?= display_price($_SESSION['promo_discount_amount']) ?>
                  </div></td>
              </tr>
              <?php }?>
              
            
              
              <?php if($settings['DiscountsPromo'] == "Yes"){?>
               <tr>
                <td colspan="6" class="ali_right"><div class="subtotal"> <b><?=ENTER_COUPON_CODE?>:</b>
                   -<input type="text" value="<?=$_SESSION['promo_code']?$_SESSION['promo_code']:"";?>" class="inputbox" name="promo_code" id="promo_code" style="width: 75px;">
                   <input type="hidden" name="cartSubTotal" id="cartSubTotal" value="<?=$CartSubtotalAmount;?>">
                   <input type="button"  value="Apply" id="applyPromo" class="button">
                  </div></td>
              </tr>
              <?php }?>
              
              <tr>
                <td colspan="6" class="ali_right"><div class="checkout">
                    <?php if(!empty($_SESSION['Cid'])){?>
                     <input name="CartSubmitFromCheckOut" type="hidden" id="CartSubmitFromCheckOut" value="" />    
                     <input type="submit" value="<?=PROCEED_TO_CHECKOUT?>" name="btnChechout" id="btnChechout">
                    <?php } else {?>
                    <input type="button" value="<?=PROCEED_TO_CHECKOUT?>" name="btnSendLogin" id="btnSendLogin">
                    <?php }?>
                  </div></td>
              </tr>
            </tfoot>
          </table>
        </form>
        <?php }else if (empty($_SESSION['MsgCart'])) { ?>
        <table width="100%" class="table_content" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="6"><?= CART_EMPTY ?></td>
          </tr>
        </table>
        <?php } ?>
        <div> </div>
      </div>
    </div>
  </div>
</div>
