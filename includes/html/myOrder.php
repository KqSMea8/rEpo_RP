<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen myOrder">
        <h1><?=MY_ORDER?> <div style="float: right;"><?=ORDER_ID?>:  #<?= $arryOrderIfo['OrderID'] ?></div></h1>
            <div class="admin-form-header">
            <h3><?=BILLING_N_SHIPPING;?></h3>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="white">
                    <tbody>
                      <tr valign="top">
                        <td width="40%" style="padding:10px 0px 0px 22px;"><strong><?=BILLING_ADDRESS;?></strong><br>
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
                          <?=EMAIL?>: <a href="mailto:<?= $arryOrderIfo['Email'] ?>">
                          <?= $arryOrderIfo['Email'] ?>
                          </a><br>
                          <?=PHONE?>:
                          <?= $arryOrderIfo['Phone'] ?>
                          <br>
                          &nbsp; </td>
                        <td width="40%" style="padding:10px 0px 0px 15px;"><strong><?=SHIPPING_ADDRESS?></strong><br>
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
                  <h3><?=ORDER_CONTENT?></h3>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="white" class="admin-list-table order_content">
                    <thead>
                      <tr>
                        <th width="15%" style="text-align:center;"><?=PRODUCT_ID?></th>
                        <th width="40%" style="text-align:left;"><?=NAME?></th>
                        <th width="25%" style="text-align:left;"><?=PRICE?></th>
                        <th width="10%" style="text-align:center;"><?=QUANTITY?></th>
                        <th width="10%" style="text-align:center;"><?=TOTAL?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($arryOrderProduct as $orderdata) { ?>
                      <tr valign="top">
                        <td style="text-align:center;"><?= $orderdata['ProductSku'] ?></td>
                        <td style="text-align:left;"><strong>
                          <?= $orderdata['ProductName'] ?>
                          </strong> <br>
                          <?php if(!empty($orderdata['ProductOptions'])){?>
                          <?=OPTIONS?>:<br>
                          <?=$orderdata['ProductOptions'];?>
                          <?php }?>
                        </td>
                        <td style="text-align:left;"><?= display_price_symbol($orderdata['Price'],$arryOrderIfo['CurrencySymbol']) ?>
                          <br>
                          <i>(not taxable)</i></td>
                        <td style="text-align:center;"><?= $orderdata['Quantity'] ?></td>
                        <td style="text-align:right;"><?= display_price_symbol($orderdata['Quantity'] * $orderdata['Price'],$arryOrderIfo['CurrencySymbol']) ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <!-- order amounts-->
                      <tr>
                        <td align="right" colspan="4" style="text-align:right;"><?=SUB_TOTAL?> :</td>
                        <td style="text-align:right;"><?= display_price_symbol($arryOrderIfo['SubTotalPrice'],$arryOrderIfo['CurrencySymbol']) ?></td>
                      </tr>
                      
                      <?php if($arryOrderIfo['DiscountAmount'] > 0){?>
                       <tr>
                        <td colspan="4"  style="text-align: right;"> <?=DISCOUNT?> : </td>
                        <td  style="text-align: right;">-<?= display_price_symbol($arryOrderIfo['DiscountAmount'],$arryOrderIfo['CurrencySymbol']) ?></td>		
                      </tr>
                      <?php }?>
                       <?php if($arryOrderIfo['PromoDiscountAmount'] > 0){?>
                       <tr>
                        <td colspan="4" style="text-align: right;"> <?=COUPON_DISCOUNT?> : </td>
                        <td style="text-align: right;">-<?= display_price_symbol($arryOrderIfo['PromoDiscountAmount'],$arryOrderIfo['CurrencySymbol']) ?></td>		
                      </tr>
                      <?php }?>
                      <tr>
                        <td colspan="4" style="text-align:right;"> <?=SHIPPING_CHARGE?> 
                          (
                          <?= $arryOrderIfo['ShippingMethod'] ?>
                          ) : </td>
                        <td style="text-align:right;"><?= display_price_symbol($arryOrderIfo['Shipping'],$arryOrderIfo['CurrencySymbol']) ?></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="text-align:right;"> <?=TAX_CHARGE?> : </td>
                        <td style="text-align:right;"><?= display_price_symbol($arryOrderIfo['Tax'],$arryOrderIfo['CurrencySymbol']) ?></td>																																																																																																																																														
                      </tr>
                      <tr>
                        <td colspan="4" style="text-align:right;border-top: 1px solid #DDDDDD;"><strong><?=TOTAL_CHARGE?> :</strong></td>
                        <td style="text-align:right;" style="border-top: 1px solid #DDDDDD;"><strong>
                          <?= display_price_symbol($arryOrderIfo['TotalPrice'],$arryOrderIfo['CurrencySymbol']) ?>
                          </strong></td>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                  
                  <div class="admin-form-header">
                  <h3><?=PAYMENT_N_SHIPPING_INFO?></h3>
                     <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="white">
                    <tbody>
                      <tr valign="top">
                          <td valign="top" style="font-size:13px;padding: 10px 0 5px 22px;">
                                    <?=PAYMENT_METHOD?>  : <?= $arryOrderIfo['PaymentGateway'] ?><br>
                                    <?php if(!empty($arryOrderIfo['ShippingMethod'])){?>
                                    <?=SHIPPING_METHOD?> : <?=CUSTOM_SHIPPING?> (<?= $arryOrderIfo['ShippingMethod'] ?>)<br>
                                   <?php }else{?>
                                    <?=SHIPPING_METHOD?> : <?=FREE_SHIPPING?><br>
                                   <?php }?>
                                    <?=COMPLETE_AT?> : <?= $arryOrderIfo["OrderComplatedDate"] ?>              	

                        </td>
                      </tr>  
                     </table>
                  </div>
                  <!-- end of order amounts -->
      
    </div>
  </div>
</div>
