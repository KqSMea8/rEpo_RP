<div class="container account">
    <div class="mid_wraper clearfix">
        <?php //include_once("includes/left.php"); ?>
        <div class="right_pen myOrder">
            <h3><?= MY_ORDER ?> <div style="float: right;"><?= ORDER_ID ?>:  #<?= $arryOrderIfo['OrderID'] ?></div></h3>
            <div class="admin-form-header">
                <h3><?= BILLING_N_SHIPPING; ?></h3>
                <table width="100%" cellspacing="1" cellpadding="3" border="1" bgcolor="white" class="wishlist">
                    <tbody>
                        <tr valign="top">
                            <td width="40%" style="padding:10px 0px 0px 22px;"><strong><?= BILLING_ADDRESS; ?></strong><br>
                                <?= stripslashes($arryOrderIfo['BillingName']) ?>
                                <br>
                                <?= stripslashes($arryOrderIfo['BillingAddress']) ?>
                                <br>
                                <?= stripslashes($arryOrderIfo['BillingCity']) ?>
                                ,
                                <?= stripslashes($arryOrderIfo['BillingState']) ?>
                                ,
                                <?= $arryOrderIfo['BillingZip'] ?>
                                <br>
                                <?= stripslashes($arryOrderIfo['BillingCountry']) ?>
                                <br>
                                <?= EMAIL ?>: <a href="mailto:<?= $arryOrderIfo['Email'] ?>">
                                    <?= $arryOrderIfo['Email'] ?>
                                </a><br>
                                <?= PHONE ?>:
                                <?= $arryOrderIfo['Phone'] ?>
                                <br>
                                &nbsp; </td>
                            <td width="40%" style="padding:10px 0px 0px 15px;"><strong><?= SHIPPING_ADDRESS ?></strong><br>
                                <?= stripslashes($arryOrderIfo['ShippingName']) ?>
                                <i>(
                                    <?= stripslashes($arryOrderIfo['ShippingAddressType']) ?>
                                    )</i><br>
                                <?= ($arryOrderIfo['ShippingAddress']) ?>
                                <br>
                                <?= stripslashes($arryOrderIfo['ShippingCity']) ?>
                                ,
                                <?= stripslashes($arryOrderIfo['ShippingState']) ?>
                                ,
                                <?= $arryOrderIfo['ShippingZip'] ?>
                                <br>
                                <?= stripslashes($arryOrderIfo['ShippingCountry']) ?>
                                <br>
                                &nbsp; </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end billing and shipping -->
            <!-- order content start-->
            <div class="admin-form-header">
                <h3><?= ORDER_CONTENT ?></h3>
                <table width="100%" cellspacing="1" cellpadding="3" border="1" bgcolor="white" class="admin-list-table order_content wishlist">
                    <thead>
                        <tr>
                            <th width="15%"  class="wish_head"><?= PRODUCT_ID ?></th>
                            <th width="40%"  class="wish_head"><?= NAME ?></th>
                            <th width="25%"  class="wish_head"><?= PRICE ?></th>
                            <th width="10%" class="wish_head"><?= QUANTITY ?></th>
                            <th width="10%" class="wish_head"><?= TOTAL ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $CurrencySymbol=$arryOrderIfo['Currency'];
                        if(!empty($arryOrderIfo['CurrencySymbol'])) $CurrencySymbol=$arryOrderIfo['CurrencySymbol'];
                         
                        foreach ($arryOrderProduct as $orderdata) { ?>
                            <tr valign="top" class="wish-field">
                                <td ><?= $orderdata['ProductSku'] ?>
                               <?php if($orderdata['UploadedFile']!='' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/ecom/upload/ordersfile/' . $orderdata['UploadedFile'])){ ?>
                                
                                <br>
                                <a href="/ecom/upload/ordersfile/<?php echo $orderdata['UploadedFile']; ?> " target="_blank">View</a>
                                <?php }?>
                                </td>
                                <td ><strong>
                                        <?= $orderdata['ProductName'] ?>
                                    </strong> 
                                     <?php if ($orderdata['Weight'] != '0.00') { ?> 
                                                            <br> Weight(<?= WEIGHT_UNIT ?>): <?= $orderdata['Weight'] ?>
                                                        <br><?php } ?>
                                         <?php 
		    //By karishma 6 oct//
		    if($orderdata['Variant_ID']!=''){
			$objVariant = new varient();
			$Variant_IDArray= explode(',',$orderdata['Variant_ID']);
			$Variant_val_IdArray= json_decode($orderdata['Variant_val_Id'], true);
			
			echo ' <br> '.Configure.':';
			
			foreach($Variant_IDArray as $key=>$val){
			$variants = $objVariant->GetVariantDispaly($val);
			if (is_array($Variant_val_IdArray[$val])) {

                            $vals = implode(',', $Variant_val_IdArray[$val]);
                        } else {

                            $vals = $Variant_val_IdArray[$val];
                        }
			
			echo $variants[0]['variant_name'].'('.$vals.')<br>';
			
			}
			
		    ?>
		     
		   
		    <?php }//End//?>
                                    <?php if (!empty($orderdata['OptionsAttribute'])) { ?>
                                        <?= OPTIONS ?>:<br>
                                        <?php
                                                                                     	
                                     
                                            	$optionArr= json_decode($orderdata['OptionsAttribute']);
                                                
                                                foreach($optionArr as $val){
                                                	echo $val;
                                                	echo '<br>';
                                                }
												
                                          
												
                                            
                                                        ?>
                                       
                                    <?php } ?>
                                </td>
                                <td ><?= display_price_symbol($orderdata['Price'], $CurrencySymbol) ?>
                                    <br>
                                    <i>(not taxable)</i></td>
                                <td ><?= $orderdata['Quantity'] ?></td>
                                <td ><?= display_price_symbol($orderdata['Quantity'] * $orderdata['Price'], $CurrencySymbol) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <!-- order amounts-->
                        <tr class="wish-field">
                            <td align="right" colspan="4" style="text-align:right; padding-right: 7px;"><?= SUB_TOTAL ?> </td>
                            <td ><?= display_price_symbol($arryOrderIfo['SubTotalPrice'], $CurrencySymbol) ?></td>
                        </tr>

                        <?php if ($arryOrderIfo['DiscountAmount'] > 0) { ?>
                            <tr class="wish-field">
                                <td colspan="4"  style="text-align: right; padding-right: 7px;"> <?= DISCOUNT ?>  </td>
                                <td>-<?= display_price_symbol($arryOrderIfo['DiscountAmount'], $CurrencySymbol) ?></td>		
                            </tr>
                        <?php } ?>
                        <?php if ($arryOrderIfo['PromoDiscountAmount'] > 0) { ?>
                            <tr class="wish-field">
                                <td colspan="4" style="text-align: right; padding-right: 7px;"> <?= COUPON_DISCOUNT ?> : </td>
                                <td >-<?= display_price_symbol($arryOrderIfo['PromoDiscountAmount'], $CurrencySymbol) ?></td>		
                            </tr>
                        <?php } ?>
                        <tr class="wish-field">
                            <td colspan="4" style="text-align:right; padding-right: 7px;"> <?= SHIPPING_CHARGE ?> 
                                (
                                <?= $arryOrderIfo['ShippingMethod'] ?>
                                )  </td>
                            <td ><?= display_price_symbol($arryOrderIfo['Shipping'], $CurrencySymbol) ?></td>
                        </tr>
                        <tr class="wish-field">
                            <td colspan="4" style="text-align:right; padding-right: 7px;"> <?= TAX_CHARGE ?>  </td>
                            <td ><?= display_price_symbol($arryOrderIfo['Tax'], $CurrencySymbol) ?></td>																																																																																																																																														
                        </tr>
                        <tr class="wish-field">
                            <td colspan="4" style="text-align:right; padding-right: 7px;"><strong><?= TOTAL_CHARGE ?> </strong></td>
                            <td><strong>
                                    <?= display_price_symbol($arryOrderIfo['TotalPrice'], $CurrencySymbol) ?>
                                </strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="admin-form-header">
                <h3><?= PAYMENT_N_SHIPPING_INFO ?></h3>
                <table width="100%" cellspacing="1" cellpadding="3" border="1" bgcolor="white" class="wishlist">
                    <tbody>
                        <tr valign="top">
                            <td valign="top" style="font-size:13px;padding: 10px 0 5px 22px;">
                                <?= PAYMENT_METHOD ?>  : <?= $arryOrderIfo['PaymentGateway'] ?><br>
                                <?php if (!empty($arryOrderIfo['ShippingMethod'])) { ?>
                                    <?= SHIPPING_METHOD ?> : <?= CUSTOM_SHIPPING ?> (<?= $arryOrderIfo['ShippingMethod'] ?>)<br>
                                <?php } else { ?>
                                    <?= SHIPPING_METHOD ?> : <?= FREE_SHIPPING ?><br>
                                <?php } ?>
                                <?= COMPLETE_AT ?> : <?= $arryOrderIfo["OrderComplatedDate"] ?>              	

                            </td>
                        </tr>  
                </table>
            </div>
            <!-- end of order amounts -->

        </div>
    </div>
</div>
