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
        <div class="right_pen">
            <h1><?=REGISTER?></h1>

            <div class="register fulllayout block">
                <h2><?=CONTACT_INFORMATION?></h2>
                 <form name="form1" class="register_form" action="" method="post"  enctype="multipart/form-data">
                    <fieldset>
                        <label><?=FIRST_NAME?> : <span class="red">*</span> </label>
                        <input type="text"name="FirstName" id="FirstName" value="" />
                    </fieldset>
                    <fieldset>
                        <label><?=LAST_NAME?> : <span class="red">*</span></label>
                        <input type="text" name="LastName" id="LastName" value="" />
                    </fieldset>
                    <fieldset>
                        <label><?=COMPANY_NAME?> :</label>
                        <input type="text" name="Company" id="Company" value="" />
                    </fieldset>
                    <fieldset>
                        <label><?=ADDRESS_LINE1?> : <span class="red">*</span></label>
                        <input type="text" name="Address1" id="Address1" value="" />
                    </fieldset>
                    <fieldset>
                        <label><?=ADDRESS_LINE2?> :</label>
                        <input type="text" name="Address2" id="Address2" value="" />
                    </fieldset>
                   
                    <fieldset>
                        <label><?=COUNTRY?> : <span class="red">*</span></label>
                        <div class="sel-wrap-friont">
                            <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                              <option value="">--- Select ---</option>
                                <? 
                                $CountrySelected = $Config['country_id'];
                                for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                    <option value="<?= $arryCountry[$i]['country_id'] ?>" <?
                                /*if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                    echo "selected";
                                }*/
                                    ?>>
                                    <?= $arryCountry[$i]['name'] ?>
                                    </option>
                              <? } ?>
                            </select>        
                        </div>
                    </fieldset>
                    <fieldset>
                        <label><?=STATE?> : <span class="red">*</span></label>
                        <div class="sel-wrap-friont">
                            <span id="state_td"></span>
                        </div>
                    </fieldset>
                     <div id="StateBillOther_Div">
                       <fieldset>
                        <label><div id="StateTitleDiv"><?=OTHER_STATE;?> : <span class="red">*</span></div></label>
                        <div class="sel-wrap-friont">
                            <div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryEmployee[0]['OtherState']; ?>"  maxlength="30" /> </div> 
                        </div>
                    </fieldset>
                     </div>    
                     <div id="CityBill_Div">
                     <fieldset>
                        <label><div id="MainCityTitleDiv"> <?=CITY?> : <span class="red">*</span></div></label>
                        <div class="sel-wrap-friont">
                            <div id="city_td"></div>
                        </div>
                    </fieldset>
                     </div>
                     <div id="CityBillOther_Div">
                     <fieldset>
                        <label><div id="CityTitleDiv"> <?=OTHER_CITY?> : <span class="red">*</span></div></label>
                        <div class="sel-wrap-friont">
                           <div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryEmployee[0]['OtherCity']; ?>"  maxlength="30" />  </div>
                        </div>
                    </fieldset>
                     </div>     
                    <fieldset>
                        <label><?=ZIP_CODE?> : <span class="red">*</span></label>
                        <input type="text" name="ZipCode" id="ZipCode" value="" />
                    </fieldset>
                    <fieldset>
                        <label><?=PHONE_NUMBER?> : <span class="red">*</span></label>
                        <input type="text" name="Phone" onkeyup="keyup(this);" id="Phone" value="" />
                    </fieldset>

                    <h2><?=ACCOUNT_INFORMATION?></h2>
                    <fieldset>
                        <label><?=EMAIL_ADDRESS?> : <span class="red">*</span></label>
                        <input type="text" name="Email" id="Email" value="" />
                    </fieldset>
                    <fieldset>
                        <label><?=PASSWORD?> : <span class="red">*</span></label>
                        <input type="Password" name="Password" id="Password" value="" />
                    </fieldset>
                    <fieldset>
                        <label><?=CONFIRM_PASSWORD?> : <span class="red">*</span></label>
                        <input type="Password" name="Confirm_Password" id="Confirm_Password" value="" />
                    </fieldset>
                    <fieldset class="btn">
                        <input type="button" name="SaveCustomer" id="SaveCustomer" value="<?=REGISTER?>" />
                    </fieldset>
                    <input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />
                      <input type="hidden" value="<?php echo $arryCustomer[0]['State']; ?>" id="main_state_id" name="main_state_id">		
                      <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustomer[0]['City']; ?>" />
                      <input type="hidden" name="billcountry_id" id="billcountry_id"  value="" />
                </form>
 
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
StateListSend();
</script>