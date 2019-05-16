<div class="main-container">
  <div class="mid_wraper clearfix">
    <div class="full_layout">
      <div class="cart_page checkout">
        <h1>Choose your delivery options</h1>
        <form action="payment.php" method="post" name="ShippingMethodForm" id="ShippingMethodForm">
        <div class="layout-zone-content layout-zone clearfix "id="content">
          <div class="col-wrap gap-top clearfix">
            <div class="div-shipping_method" id="div-shipping_method">
              <div class="gap-right">
                <div class="fieldset ">
                  <fieldset class="formFieldSet">
                  <legend class="no-gap-bottom">Choose a shipping Method</legend>
                  
                  <?php
                  if(count($arrayShippingMethods) > 0){
                  foreach($arrayShippingMethods as $method){?>
                  <div class="field required first">
                      <input type="radio" name="Ssid" value="<?=$method['Ssid']?>"> &nbsp;&nbsp; <?=$method['CarrierName']?>(<?=$method['MethodName']?>) -
                      <?php if($method['CarrierPriceType'] == "amount"){?><?= display_price($method['CarrierPrice'], '', '', '', '') ?><?php } else {?> <?=number_format($method['CarrierPrice'],0)."%";?><?php }?>
                  </div>
                  <?php }
                  
                  } else {?>
                  <div class="field required first" style="padding: 15px; color: red;">Sorry no delivery options found for your shipping address.</div>
                  <?php }?>
                  </fieldset>
                </div>
              </div>
            </div>
          </div>
          <div class="buttons">
            <input type="submit" value="<?=CONTINUE_WITH_ORDER?>" <?php if(count($arrayShippingMethods) > 0){?>id="CheckShippingMetod" <?php }?>  class="button-get-shipping-rates button ">
          </div>
        </div>
       </form>
      </div>
    </div>
  </div>
</div>

