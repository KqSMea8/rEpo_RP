<div class="main-container">
  <div class="mid_wraper clearfix">
    <div class="full_layout">
      <div class="cart_page checkout">
        <h1><?=CHECKOUT;?></h1>
        <form action="shippingMethods.php" method="post">
        <div class="layout-zone-content layout-zone clearfix "id="content">
          <div class="col-wrap gap-top clearfix">
            <div class="col-50 div-billing-address" id="div_billing_address">
              <div class="gap-right">
                <div class="fieldset ">
                  <fieldset class="formFieldSet">
                  <legend class="no-gap-bottom"><?=BILLING_ADDRESS;?></legend>
                  <div class="field required first">
                    <label><?=FIRST_NAME?> : <span class="red">*</span></label>
                      <input type="text" value="<?=$arryCustomer[0]['FirstName']?>" name="FirstName" id="FirstName" maxlength="24">
                  </div>
                  <div class="field required">
                    <label><?=LAST_NAME?> : <span class="red">*</span></label>
                      <input type="text" value="<?=$arryCustomer[0]['LastName']?>" name="LastName" id="LastName" maxlength="36">
                  </div>
                  <div class="field">
                    <label><?=COMPANY_NAME?> : </label>
                      <input type="text" value="<?=$arryCustomer[0]['Company']?>" name="Company" id="Company" maxlength="36">
                  </div>
                  <div class="field required">
                    <label><?=ADDRESS_LINE1?> : <span class="red">*</span></label>
                      <input type="text" value="<?=$arryCustomer[0]['Address1']?>" name="Address1" id="Address1" maxlength="36">
                  </div>
                  <div class="field">
                    <label><?=ADDRESS_LINE2?> :</label>
                      <input type="text" value="<?=$arryCustomer[0]['Address2']?>" name="Address2" id="Address2" maxlength="36">
                  </div>
                 
                  <div class="field required" id="billing_country">
                    <label><?=COUNTRY?> : <span class="red">*</span></label>
                    <div class="sel-wrap-friont">
                     <?php
                    if ($arryCustomer[0]['Country'] != '') {
                        $CountrySelected = $arryCustomer[0]['Country'];
                    } else {
                        $CountrySelected = 106;
                    }
                     ?>
                        <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                            <? for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                <option value="<?= $arryCountry[$i]['country_id'] ?>" <? if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                echo "selected";
                            } ?>>
                                <?= $arryCountry[$i]['name'] ?>
                                </option>
                                <? } ?>
                </select>  
                      </div>
                  </div>
                  <div class="field required invisible">
                    <label><?=STATE?> : <span class="red">*</span></label>
                    <div class="sel-wrap-friont" id="state_td">
                     
                      </div>
                  </div>
                  <div class="field required invisible" id="StateBillOther_Div">
                    <label><div id="StateTitleDiv"><?=OTHER_STATE?> : <span class="red">*</span></div></label>
                      <div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCustomer[0]['OtherState']; ?>"  maxlength="30" /> </div>  
                  </div>
                   <div class="field required" id="CityBill_Div">
                       <label><div id="MainCityTitleDiv"> <?=CITY?> : <span class="red">*</span></div></label>
                      <div id="city_td" class="sel-wrap-friont"></div>
                  </div>
                   <div class="field required" id="CityBillOther_Div">
                    <label><div id="CityTitleDiv"><?=OTHER_CITY?> : <span class="red">*</span></div></label>
                      <div id="CityValueDiv">
                          <input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCustomer[0]['OtherCity']; ?>"  maxlength="30" />  
                      </div>
                  </div>
                  <div class="field required">
                    <label><?=ZIP_CODE?> : <span class="red">*</span></label>
                    <input type="text" value="<?=$arryCustomer[0]['ZipCode']?>" name="ZipCode" maxlength="24" id="ZipCode">
                  </div>
                  <div class="field required">
                    <label><?=PHONE_NUMBER?> : <span class="red">*</span></label>
                      <input type="text" value="<?=$arryCustomer[0]['Phone']?>" name="Phone" onkeyup="keyup(this);" maxlength="24" id="Phone">
                  </div>
                  <div class="field required">
                    <label><?=EMAIL_ADDRESS?> : <span class="red">*</span></label>
                      <input type="text" value="<?=$arryCustomer[0]['Email']?>" name="Email" id="Email">
                  </div>
                  <div class="field required date">
                      <script type="text/javascript">
                            w(function() {
                                   w('#DelivaryDate').datepicker(
                                           {
                                           yearRange: '<?=date("Y")?>:<?=date("Y")+5?>',
                                           dateFormat: 'dd-mm-yy',                
                                           changeMonth: true,
                                           minDate : "+1D",
                                           changeYear: true

                                           }
                                   );
                            });
                        </script>
                    <label><?=DELIVERY_DATE?> : </label>
                    <div><input type="text" value="<?=$_SESSION['DelivaryDate']?>" maxlength="20" name="DelivaryDate"  id="DelivaryDate">
                        <img  src="../images/cal.png" style="margin: 2px 2px 2px -22px;vertical-align: text-bottom;" alt="..." title="...">
                        </div>
                     <div style="padding-top:5px;clear: both;">
                    </div>
                    </div>
                  </fieldset>
                    <input type="hidden" value="<?php echo $arryCustomer[0]['Country']; ?>" id="billcountry_id" name="billcountry_id">
                    <input type="hidden" value="<?php echo $arryCustomer[0]['State']; ?>" id="main_state_id" name="main_state_id">		
                    <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustomer[0]['City']; ?>" />
                  
                </div>
              </div>
              
            </div>
            <div class="col-50 col-right div-shipping-address" id="div_shipping_address">
              <div class="gap-left">
                <div class="fieldset ">
                  <fieldset style="padding-bottom:10px;" class="formFieldSet">
                  <legend class="no-gap-bottom"><?=SHIPPING_ADDRESS?></legend>
                 <?php
                         /********Connecting to main database*********/
                $Config['DbName'] = $Config['DbMain'];
                $objConfig->dbName = $Config['DbName'];
                $objConfig->connect();
            /*******************************************/
                  foreach($addresses as $address) {
                      
                      
                    if(!empty($address['State'])) {
                                  $arryState = $objRegion->getStateName($address['State']);
                                  $StateName = stripslashes($arryState[0]["name"]);
                          }else if(!empty($address['OtherState'])){
                                   $StateName = stripslashes($address['OtherState']);
                          }

                          if(!empty($address['City'])) {
                                  $arryCity = $objRegion->getCityName($address['City']);
                                  $CityName = stripslashes($arryCity[0]["name"]);
                          }else if(!empty($address['OtherCity'])){
                                   $CityName = stripslashes($address['OtherCity']);
                          }
                      
                      ?>
                  <div class="option clearfix">
                      <input type="radio" value="<?=$address['Csid']?>" <?php if($_SESSION['shipping_address_id'] == $address['Csid']){echo "checked";}?> class="ShippingAddress"  name="shipping_address_id">
                    <p style="margin-left: 28px;"><?=ucfirst($address['Name'])?>, 
                    <?=ucfirst($address['Address1'])?>, <?=ucfirst($address['Address2'])?>,
                    <br>
                    <?=ucfirst($CityName)?>, <?=ucfirst($StateName)?>, <?=$address['Zip']?><br>
                                    <?php
                                     if($address['Country']>0){
                                                    $arryCountryName = $objRegion->GetCountryName($address['Country']);
                                                    $CountryName = stripslashes($arryCountryName[0]["name"]);
                                            }
                                    ?>
                                    <?=$CountryName?></p>
                  </div>
                   <?php } ?>
                
                  <div class="option clearfix">
                      <input type="radio" value="new"  name="shipping_address_id" class="toggle-new-shipping" <?php if($_SESSION['shipping_address_id'] == "new" || empty($_SESSION['shipping_address_id'])){echo "checked";}?> id="shipping_address_id">
                    <p style="margin-left: 28px;"><?=ENTER_NEW_ADDRESS?></p>
                  </div>
                  
                  <div id="div_new_shipping_address">
                     <div class="field first required" style="width: 367px;">
                      <label><?=ADDRESS_TYPE?> : <span class="red">*</span></label>  
                      <div style="float: left; width: 110px; margin: 4px;">
                       <input type="radio" name="AddressType" <?php if($_SESSION['AddressType'] == "Residential"){?> checked <?php }?> id="AddressType" value="Residential">Residential
                      </div>
                     <div style="float: right;width: 110px;margin: 4px;">
                     <input type="radio" name="AddressType" id="AddressType" <?php if($_SESSION['AddressType'] == "Business"){?> checked <?php }?> value="Business">Business
                     </div>

                    </div>
                    <div class="field first required">
                      <label><?=NAME?> : <span class="red">*</span></label>
                        <input type="text" value="<?=$arryCustomer[0]['ShippingName']?>" name="ShippingName" id="ShippingName" maxlength="24">
                    </div>
                    <div class="field">
                      <label><?=COMPANY_NAME?> :</label>
                        <input type="text" value="<?=$arryCustomer[0]['ShippingCompany']?>" name="ShippingCompany" id="ShippingCompany" maxlength="36">
                    </div>
                    <div class="field required">
                      <label><?=ADDRESS_LINE1?> : <span class="red">*</span></label>
                        <input type="text" value="<?=$arryCustomer[0]['ShippingAddress1']?>" name="ShippingAddress1" id="ShippingAddress1" maxlength="36">
                    </div>
                    <div class="field">
                      <label><?=ADDRESS_LINE2?> : </label>
                        <input type="text" value="<?=$arryCustomer[0]['ShippingAddress2']?>" name="ShippingAddress2" id="ShippingAddress" maxlength="36">
                    </div>
                    
                    <div class="field required" id="shipping_country">
                      <label><?=COUNTRY?> : <span class="red">*</span></label>
                      <div class="sel-wrap-friont">
                          
                            <?php
                    if ($arryCustomer[0]['ShippingCountry'] != '') {
                        $CountrySelected = $arryCustomer[0]['ShippingCountry'];
                    } else {
                        $CountrySelected = $Config['country_id'];
                    }
                     ?>
                        <select name="country_id_shipp" class="inputbox" id="country_id_shipp"  onChange="Javascript: StateListSendCheckout();">
                            <? for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                <option value="<?= $arryCountry[$i]['country_id'] ?>" <? if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                echo "selected";
                            } ?>>
                                <?= $arryCountry[$i]['name'] ?>
                                </option>
                                <? } ?>
                           </select>  
                       
                        </div>
                    </div>
                    <div class="field required invisible">
                      <label><?=STATE?> : <span class="red">*</span></label>
                      <div class="sel-wrap-friont" id="state_td_shipp">
                        </div>
                    </div>
                    <div class="field required invisible" id="StateShippOther_Div">
                      <label><div id="StateTitleDiv_shipp"><?=OTHER_STATE;?> : <span class="red">*</span></div></label>                      
                        <div id="StateValueDiv_shipp"><input name="OtherState_shipp" type="text" class="inputbox" id="OtherState_shipp" value="<?=$arryCustomer[0]['OtherState_shipp']?>"  maxlength="30" /> </div>
                       
                    </div>
                      
                  <div class="field required">
                      <label><div id="MainCityTitleDiv_shipp"> <?=CITY?> : <span class="red">*</span></div></label>
                       <div id="city_td_shipp" class="sel-wrap-friont"></div>
                    </div>
                    
                     <div class="field required" id="CityShippOther_Div">
                      <label><div id="CityTitleDiv_shipp"><?=OTHER_CITY?> : <span class="red">*</span></div></label>
                      <div id="CityValueDiv_shipp"><input name="OtherCity_shipp" type="text" class="inputbox" id="OtherCity_shipp" value="<?=$arryCustomer[0]['OtherCity_shipp']?>"  maxlength="30" />  </div>
                    </div>
                      
                    <div class="field">
                      <label><?=ZIP_CODE?> : <span class="red">*</span></label>
                        <input type="text" value="<?=$arryCustomer[0]['ShippingZip']?>" name="ShippingZip" id="ShippingZip" maxlength="48">
                    </div>
                    <div class="field required">
                      <label><?=PHONE_NUMBER?> : <span class="red">*</span></label>
                        <input type="text" value="<?=$arryCustomer[0]['ShippingPhone']?>" maxlength="20" name="ShippingPhone" onkeyup="keyup(this);" id="ShippingPhone">
                       
                    </div>
                    <?php if(empty($_SESSION["guestId"])){?>  
                    <div class="option clearfix">
                        <input type="checkbox" value="Yes" name="add_to_address_book" id="add_to_address_book">
                      <p style="margin-left: 28px;"><?=ADD_THIS_NEW_ADDRESS?></p>
                    </div>
                    <?php }?>
                    </div>
                 
                    <input type="hidden" value="<?=$arryCustomer[0]['ShippingState']?>" id="main_state_id_shipp" name="main_state_id_shipp">		
                    <input type="hidden" name="main_city_id_shipp" id="main_city_id_shipp"  value="<?=$arryCustomer[0]['ShippingCity']?>" />
                    
                  </fieldset>
                </div>
              </div>
            </div>
          </div>
          <div class="buttons">
             <input type="hidden" name="Cid" id="Cid"  value="<?php echo $Cid; ?>" />
            <input type="submit" value="<?=CONTINUE_WITH_ORDER?>" id="ContinueWithOrder" class="button-get-shipping-rates button ">
          </div>
        </div>
       </form>
      </div>
    </div>
  </div>
</div>
</div>
  <SCRIPT LANGUAGE=JAVASCRIPT>
    StateListSend();
    StateListSendCheckout();         
    </SCRIPT>