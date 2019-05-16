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
    <div class="right_pen addressbook">
      <h1><?=MY_ADDRESS_BOOK?></h1>
       
      <?php if(count($addresses) > 0){?>
      <div class="msg-notice"><?=SHIPPING_NOTICE;?></div>
       <div class="col-wrap spacer clearfix no-space-bottom">
           <?php
            /********Connecting to main database*********/
                $Config['DbName'] = $Config['DbMain'];
                $objConfig->dbName = $Config['DbName'];
                $objConfig->connect();
            /*******************************************/
           ?>
      <?php
      $i=1;
      foreach($addresses as $address) {?>
     
           <div class="col-50 <?php if($i%2 == 0){?>second<?php }?>">
                            <div class="gap-bottom gap-right">
                                <div class="fieldset clearfix ">
                                <h3> <?=ADDRESS?> <?=$i?>  <?//php if($address['IsPrimary'] == "Yes"){?><!--(<?//=PRIMARY?>)--><?//php }?></h3>
                                <input type="hidden" value="0" name="shipping_country_id[6]">
                                <input type="hidden" value="95&gt;" name="shipping_state_id[6]">
                                <div class="spacer clearfix no-space-top">
                                    <div>
                                    <b><?=ucfirst($address['Name'])?>, <?=ucfirst($address['Company'])?></b>
                                    <i>(<?=$address['AddressType']?>)</i>
                                    <br>
                                    
                                    <?php
                                    
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
                                    
                                    <?=ucfirst($address['Address1'])?>, <?=ucfirst($address['Address2'])?><br>
                                    <?=ucfirst($CityName)?>, <?=ucfirst($StateName)?>, <?=$address['Zip']?><br>
                                    <?php
                                     if($address['Country']>0){
                                                    $arryCountryName = $objRegion->GetCountryName($address['Country']);
                                                    $CountryName = stripslashes($arryCountryName[0]["name"]);
                                            }
                                    ?>
                                    <?=$CountryName?>
                                    </div>
                                    <div>
                                        <a class="small_link" href="address_edit.php?address_id=<?=$address['Csid']?>"><?=EDIT_ADDRESS;?></a> | 
                                        <a href="javascript:void();" alt="<?=$address['Csid']?>#<?=$address['Cid']?>" class="small_link DeleteShippingAddress"><?=DELETE_ADDRESS?></a>
                                    </div>
                                 </div>
                                </div>
                            </div>
                    </div>
                
                  

      <?php $i++;} ?>
           </div>
       <? }
      else{?>
      <p><?=NO_SHIPPING_MSG?></p>
      <?php }?>
      <div class="register fulllayout addressBook">
         
        <form class="register_form" method="post" action="">
          <div class="block">
            <h2><?=ENTER_NEW_SHIPPING?></h2>
            <div class="fieldset">
              <fieldset>
              <div class="field required first">
                <label> <?=ADDRESS_TYPE?> : <span class="red">*</span></label>
                <div class="sel-wrap-friont">
                  <select name="AddressType" id="AddressType">
                    <option value="">Please select...</option>
                    <option value="Residential">Residential</option>
                    <option value="Business">Business</option>
                  </select>
                </div>
              </div>
              </fieldset>
              <fieldset>
              <div class="field required">
                <label><?=NAME?> : <span class="red">*</span></label>
                <input type="text" value="" name="Name" maxlength="24" class="formControlText" id="Name">
              </div>
              </fieldset>
              <fieldset>
              <div class="field">
                <label><?=COMPANY_NAME?> : </label>
                <input type="text" value="" name="Company" maxlength="50" class="formControlText" id="Company">
              </div>
              </fieldset>
              <fieldset>
              <div class="field required">
                <label><?=ADDRESS_LINE1?> : <span class="red">*</span></label>
                <input type="text" value="" name="Address1" maxlength="125" id="Address1">
              </div>
              </fieldset>
              <fieldset>
              <div class="field">
                <label><?=ADDRESS_LINE2?> : </label>
                <input type="text" value="" name="Address2" maxlength="125" id="Address2">
              </div>
              </fieldset>
            
              <fieldset>
              <div class="field required" id="billing_country">
                <label><?=COUNTRY?> : <span class="red">*</span></label>
                <div class="sel-wrap-friont">
                     <?php
                   
                        $CountrySelected = $Config['country_id'];
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
              </fieldset>
              <fieldset>
              <div class="field required invisible" id="billing_state">
                <label> <?=STATE?> : <span class="red">*</span></label>
                <div class="sel-wrap-friont" id="state_td">
                 
                </div>
              </div>
              </fieldset>
              <fieldset>
              <div class="field required invisible" id="StateBillOther_Div">
                <label><div id="StateTitleDiv"><?=OTHER_STATE?> : <span class="red">*</span></div></label>
                <div class="sel-wrap-friont" id="state_td">
                 <div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value=""  maxlength="30" /> </div>  
                </div>
              </div>
              </fieldset>   
             <fieldset>
              <div class="field required"  id="CityBill_Div">
                <label><div id="MainCityTitleDiv"><?=CITY?> : <span class="red">*</span></div></label>
                <div id="city_td" class="sel-wrap-friont"></div>
              </div>
              </fieldset>
              
              <fieldset>
              <div class="field required" id="CityBillOther_Div">
                <label><div id="CityTitleDiv"><?=OTHER_CITY?> : <span class="red">*</span></div></label>
                <div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value=""  maxlength="30" />  </div>
              </div>
              </fieldset>
                
              <fieldset>
              <div class="field required">
                <label><?=ZIP_CODE?> : <span class="red">*</span></label>
                <input type="text" value="" name="Zip" maxlength="24" id="Zip">
              </div>
              </fieldset>
               <fieldset>
               <div class="field required">
                <label><?=PHONE_NUMBER?> : <span class="red">*</span></label>
                <input type="text" value="" name="Phone" onkeyup="keyup(this);" maxlength="24" id="Phone">
              </div>
              </fieldset>
             <!-- <fieldset>
              <div class="field required checkbox">
                <label> <?//=MAKE_PRIMARY?> </label>
                <input type="checkbox" value="Yes" name="IsPrimary">
              </div>
              </fieldset>-->
            </div>
          </div>
          <div class="buttons">
              <input type="hidden" value="save_address" id="action" name="action">
               <input type="hidden" value="<?=$Cid;?>" id="Cid" name="Cid">
              <input type="hidden" value="" id="main_state_id" name="main_state_id">		
             <input type="hidden" name="main_city_id" id="main_city_id"  value="" />
              <input type="hidden" name="billcountry_id" id="billcountry_id"  value="" />
            <input type="submit" value="<?=SAVE?>" id="SaveShippingAddress" class="button submit ">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script LANGUAGE=JAVASCRIPT>
    StateListSend();
</script>
