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
      <h1><?=SHIPPING_ADDRESS_EDITING?></h1>
      <div class="register fulllayout addressBook">  
        <form class="register_form" method="post" action="">
          <div class="block">
            <h2><?=SHIPPING_ADDRESS?></h2>
            <div class="fieldset">
              <fieldset>
              <div class="field required first">
                <label> <?=ADDRESS_TYPE?> : <span class="red">*</span></label>
                <div class="sel-wrap-friont">
                  <select name="AddressType" id="AddressType">
                    <option value="">Please select...</option>
                    <option value="Residential" <?php if($address[0]['AddressType'] == "Residential"){echo "selected";}?>>Residential</option>
                    <option value="Business" <?php if($address[0]['AddressType'] == "Business"){echo "selected";}?>>Business</option>
                  </select>
                </div>
              </div>
              </fieldset>
              <fieldset>
              <div class="field required">
                <label><?=NAME?> : <span class="red">*</span></label>
                <input type="text" value="<?=$address[0]['Name'];?>" name="Name" maxlength="24" class="formControlText" id="Name">
              </div>
              </fieldset>
              <fieldset>
              <div class="field">
                <label><?=COMPANY_NAME?> : </label>
                <input type="text" value="<?=$address[0]['Company'];?>" name="Company" maxlength="50" class="formControlText" id="Company">
              </div>
              </fieldset>
              <fieldset>
              <div class="field required">
                <label><?=ADDRESS_LINE1?> : <span class="red">*</span></label>
                <input type="text" value="<?=$address[0]['Address1'];?>" name="Address1" maxlength="125" id="Address1">
              </div>
              </fieldset>
              <fieldset>
              <div class="field">
                <label><?=ADDRESS_LINE2?> : </label>
                <input type="text" value="<?=$address[0]['Address2'];?>" name="Address2" maxlength="125" id="Address2">
              </div>
              </fieldset>
            
              <fieldset>
              <div class="field required" id="billing_country">
                <label><?=COUNTRY?> : <span class="red">*</span></label>
                <div class="sel-wrap-friont">
                    <?php
                        if ($address[0]['Country'] != '') {
                            $CountrySelected = $address[0]['Country'];
                        } else {
                            $CountrySelected = $Config['country_id'];
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
                  <label><div id="StateTitleDiv"> <?=OTHER_STATE?> : <span class="red">*</span></div></label>
                <div class="sel-wrap-friont" id="state_td">
                 <div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?=$address[0]['OtherState'];?>"  maxlength="30" /> </div>  
                </div>
              </div>
              </fieldset>   
             <fieldset>
              <div class="field required"  id="CityBill_Div">
                  <label><div id="MainCityTitleDiv"> <?=CITY?> : <span class="red">*</span></div></label>
                <div id="city_td" class="sel-wrap-friont"></div>
              </div>
              </fieldset>
              
              <fieldset>
              <div class="field required" id="CityBillOther_Div">
                <label><div id="CityTitleDiv"><?=OTHER_CITY?> : <span class="red">*</span></div></label>
                <div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?=$address[0]['OtherCity'];?>"  maxlength="30" />  </div>
              </div>
              </fieldset>
                
              <fieldset>
              <div class="field required">
                <label><?=ZIP_CODE?> : <span class="red">*</span></label>
                <input type="text" value="<?=$address[0]['Zip'];?>" name="Zip" maxlength="24" id="Zip">
              </div>
              </fieldset>
              <fieldset>
               <div class="field required">
                <label><?=PHONE_NUMBER?> : <span class="red">*</span></label>
                <input type="text" value="<?=$address[0]['Phone'];?>" onkeyup="keyup(this);" name="Phone" maxlength="24" id="Phone">
              </div>
              </fieldset>   
             <?//php if($address[0]['IsPrimary'] != "Yes") { ?> 
                <!--<fieldset>
                <div class="field required checkbox">
                  <label> <?//=MAKE_PRIMARY?>  </label>
                  <input type="checkbox" value="Yes"  name="IsPrimary">
                </div>
                </fieldset>-->
              <?php// }?>
            </div>
          </div>
          <div class="buttons">
              <input type="hidden" value="edit_address" id="action" name="action">
              <input type="hidden" value="<?=$Cid;?>" id="Cid" name="Cid">
              <input type="hidden" value="<?=$_GET['address_id'];?>" id="Csid" name="Csid">
              <input type="hidden" value="<?=$address[0]['State'];?>" id="main_state_id" name="main_state_id">		
             <input type="hidden" name="main_city_id" id="main_city_id"  value="<?=$address[0]['City'];?>" />
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
<style>
    
   .addressbook .col-wrap .col-50 {float: left;width: 48%; margin:0 20px 20px 0;height: 150px;}
   .addressbook .col-wrap .second{ margin:0 0 20px;}
   .addressbook .col-wrap .col-50 h3{ background: #ddd;padding: 5px 10px;}
  .addressbook .msg-notice{font-weight: bold;padding: 2px 2px 8px 2px;}
</style>