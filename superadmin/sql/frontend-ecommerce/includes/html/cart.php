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
<div class="container cart">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3><?= YOUR_CART ?></h3>
            <div>
                <? if(!empty($_SESSION['MsgCart'])) {echo $_SESSION['MsgCart']; unset($_SESSION['MsgCart']); 
                }?>
            </div>
        </div>
        <?php if ($numCart > 0) { ?>
            <form action=""  method="post" name="form1" id="form1" onsubmit="return validateCart(this);">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><?= DESCRIPTION ?></th>
                                        <th>&nbsp;</th>
                                        <th><?= PRICE ?></th>
                                        <th><?= QUANTITY ?></th>
                                        <th><?= TOTAL ?></th>
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
											$ProductName=$values['Name'];
                                        	if(!empty($values['ItemAliasCode'])){
			                        	 	$ProductName=$values['ItemAliasCode'];
			                        	 }
                                            if ($values['Image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/' . $Config['CmpID'] . '/' . $values['Image'])) {
                                                $ImagePath = 'resizeimage.php?img=' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/' . $Config['CmpID'] . '/' . $values['Image'] . '&w=73&h=73';
                                                $ImagePath = '<img src="' . $ImagePath . '"  border="0"  alt="' . stripslashes($ProductName) . '" title="' . stripslashes($values['Name']) . '"/>';
                                            } else {
                                                $ImagePath = '<img src="./../images/no.jpg" border="0"  alt="' . stripslashes($ProductName) . '" title="' . stripslashes($values['Name']) . '" width="65">';
                                            }

                                            $ImagePathLink = '<a href="' . $PrdLink . '">' . $ImagePath . '</a>';
                                            ?>
                                            <tr>
                                                <td width="300"><div class="img"><?= $ImagePathLink ?></div>
                                                    <div class="pr_name"> <a class="name" href="<?= $PrdLink ?>"><?= ucfirst(stripslashes($ProductName)) ?>
                                                        </a>
            <?php echo '<br>Product Sku: ' . stripslashes($values['ProductSku']); ?>
                                                        <?php if ($values['Weight'] != '0.00') { ?> 
                                                            <br> Weight(<?= WEIGHT_UNIT ?>): <?= $values['Weight'] ?>
                                                        <?php } ?>
                                                        <?php
                                                        //By Chetan14Sep//
                                                        if ($values['Variant_ID'] != '') {
                                                            $objVariant = new varient();
                                                            $Variant_IDArray = explode(',', $values['Variant_ID']);
                                                            $Variant_val_IdArray = json_decode($values['Variant_val_Id'], true);

                                                            echo ' <br> ' . Configure . ':';

                                                            foreach ($Variant_IDArray as $key => $val) {
                                                                $variants = $objVariant->GetVariantDispaly($val);
                                                               
                                                                
                                                                if (is_array($Variant_val_IdArray[$val])) {
                                                                    //$Variant_Val = implode(',', $Variant_val_IdArray[$val]);
                                                                    $vals = implode(',', $Variant_val_IdArray[$val]);
                                                                } else {
                                                                    //$Variant_Val = $Variant_val_IdArray[$val];
                                                                    $vals = $Variant_val_IdArray[$val];
                                                                }
                                                                
                                                                
                                                                /*$variantVal = $objVariant->GetMultipleVariantOption($val, $Variant_Val);
                                                                if (count($variantVal) > 1) {
                                                                    $vals = array_map(function($arr) {
                                                                        return $arr['option_value'];
                                                                    }, $variantVal);
                                                                    $vals = implode(",", $vals);
                                                                } else {
                                                                    $vals = $variantVal[0]['option_value'];
                                                                }*/
                                                                echo $variants[0]['variant_name'] . '(' . $vals . ')<br>';
                                                            }
                                                            ?>

                                                            <?php ?>
                                                        <?php }//End//?>
                                                        <a href="javascript:void(0);" class="deleteProduct" alt="<?= $Cid . "#" . $values['ProductID'] . "#" . $values['CartID']; ?>">Remove</a>
                                                        <input type="hidden" name="ProductID<?= $Count ?>" id="ProductID<?= $Count ?>" value="<?php echo $values['ProductID']; ?>" />
                                                        <input type="hidden" name="CartID<?= $Count ?>" id="CartID<?= $Count ?>" value="<?php echo $values['CartID']; ?>" />

                                                    </div>


                                                </td>
                                                <td> <?php
                                            if (!empty($values['OptionsAttribute'])) {
                                            	$optionArr= json_decode($values['OptionsAttribute']);
                                                
                                                foreach($optionArr as $val){
                                                	echo $val;
                                                	echo '<br>';
                                                }
												
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
    $Total = $SubTotal + $Tax + $VatAmount;

    $_SESSION['ProductIDs'] = rtrim($ProductIDs, ",");
    $_SESSION['TotalQuantity'] = rtrim($TotalQuantity, ",");

    //////////////////////////////////////////////////////

    $_SESSION['discountAmount'] = number_format($discountAmount, 2, '.', '');
    $_SESSION['Shipping'] = number_format($Shipping, 2, '.', '');
    $_SESSION['SubTotal'] = number_format($SubTotal, 2, '.', '');
    $_SESSION['Total'] = number_format($Total, 2, '.', '');
    $_SESSION['GroupdiscountAmount'] = number_format($GroupdiscountAmount, 2, '.', '');
    ?>
                                <input type="hidden" name="numCart" id="numCart" value="<?php echo $numCart; ?>" />
                                <input type="hidden" name="Cid" id="Cid" value="<?php echo $Cid; ?>" />     
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><div class="button_left">
                                                <input type="button" class="btn btn-info" value="Continue Shopping" id="continueShopping" name="">
                                            </div></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><div class="button_right">
                                                <input type="hidden" name="TotalQuantity" id="TotalQuantity" value="<?php echo $TotalQuantity; ?>" />
                                                <input name="ProductIDs" type="hidden" id="ProductIDs" value="<?php echo rtrim($ProductIDs, ","); ?>" />
                                                <input name="CartSubmit" type="hidden" id="CartSubmit" value="1" />
                                                <input name="DefaultOQantity"  id="DefaultOQantity" value="<?= $settings['DefaultOQantity'] ?>" type="hidden" /> 
                                                <input name="Total" type="hidden" id="Total" value="<?php echo number_format($Total, 2, '.', ''); ?>" />
                                                <input type="submit" value="Update" class="btn btn-info" name="submit">
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="botline"><div class="line"></div></td>
                                    </tr>



                                </tfoot>
                            </table>
                            <hr>
                            <dl class="dl-horizontal pull-right">
                                <dt><?= SUB_TOTAL ?>:</dt>
                                <dd><?= display_price($SubTotal) ?></dd>

    <?php if ($discountAmount > 0) { ?>
                                    <dt><?= DISCOUNT ?>:</dt>
                                    <dd><?= display_price($discountAmount) ?></dd>
    <?php } ?>

                                <?php if ($_SESSION['promo_discount_amount'] > 0) { ?>
                                    <dt><?= COUPON_DISCOUNT ?>:</dt>
                                    <dd><?= display_price($_SESSION['promo_discount_amount']) ?></dd>
                                <?php } ?>

                                <?php if ($GroupdiscountAmount > 0) { ?>
                                    <dt><?= GROUPDISCOUNT ?>:</dt>
                                    <dd><?= display_price($GroupdiscountAmount) ?></dd>
                                <?php } ?>

                                <?php if ($settings['DiscountsPromo'] == "Yes") { ?>
                                    <dt><?= ENTER_COUPON_CODE ?>:</dt>
                                    <dd><input type="text" value="<?= $_SESSION['promo_code'] ? $_SESSION['promo_code'] : ""; ?>" class="inputbox" name="promo_code" id="promo_code" style="width: 75px;">
                                        <input type="hidden" name="cartSubTotal" id="cartSubTotal" value="<?= $CartSubtotalAmount; ?>">
                                        <input type="button"  value="Apply" id="applyPromo" class="button btn btn-info"></dd>
                                <?php } ?>
                                <!--            <dt>Total:</dt>-->
                                <!--            <dd>$35.025</dd>-->
                            </dl>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="checkout.php" class="btn btn-primary pull-right"><?= PROCEED_TO_CHECKOUT ?></a>
                            <!--<?php if (!empty($_SESSION['Cid'])) { ?>
                                             <input name="CartSubmitFromCheckOut" type="hidden" id="CartSubmitFromCheckOut" value="" />    
                                             <input type="submit" value="<?= PROCEED_TO_CHECKOUT ?>" name="btnChechout" id="btnChechout" class="btn btn-primary pull-right">
    <?php } else { ?>
                                            <input type="submit" value="<?= PROCEED_TO_CHECKOUT ?>" name="btnChechout" id="btnChechout" class="btn btn-primary pull-right">
                                            
                                            <input type="button" value="<?= PROCEED_TO_CHECKOUT ?>" name="btnSendLogin" id="btnSendLogin" class="btn btn-primary pull-right">
                            <?php } ?>
                              
                            --></div>
                    </div>
                </div>
            </form>
<?php } else if (empty($_SESSION['MsgCart'])) { ?>
            <table width="100%" class="table table-striped" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="6"><?= CART_EMPTY ?></td>
                </tr>
            </table>
<?php } ?> 
    </div>
</div>



