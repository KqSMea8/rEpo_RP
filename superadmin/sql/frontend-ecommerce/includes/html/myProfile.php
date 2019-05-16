
<div class="account">
    <div class="mid_wraper clearfix">
        <?php //include_once("includes/left.php"); ?>
        <div class="right_pen">
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
            <h3><?= MY_ACCOUNT_INFO; ?></h3>
            <p><?= ACCOUNT_MSG; ?></p>
            <div class="register fulllayout myProfile">
            	<h3 class="section-title-inner"><?= YOUR_PERSONAL_DETAILS; ?></h3>
                <form class="register_form_profile" method="post" action="">
                	<div class="form-group">
                      <label><?= FIRST_NAME ?> : <span class="red">*</span></label>
                      <input type="text" value="<?= $arrayMyProfile[0]['FirstName'] ?>" name="FirstName" maxlength="24" id="FirstName">
                    </div>
                    
                    <div class="form-group">
                      <label><?= LAST_NAME ?> : <span class="red">*</span></label>
                      <input type="text" value="<?= $arrayMyProfile[0]['LastName'] ?>" name="LastName" maxlength="24" class="formControlText" id="LastName">
                    </div>
                    
                    <div class="form-group">
                      <label><?= COMPANY_NAME ?> : </label>
                       <input type="text" value="<?= $arrayMyProfile[0]['Company'] ?>" name="Company" maxlength="50" class="formControlText" id="Company">
                    </div>
                    
                    <div class="form-group">
                      <label><?= ADDRESS_LINE1 ?> : <span class="red">*</span></label>
                       <input type="text" value="<?= $arrayMyProfile[0]['Address1'] ?>" name="Address1" maxlength="125" id="Address1">
                    </div>
                    
                    <div class="form-group">
                      <label><?= ADDRESS_LINE2 ?> : </label>
                      <input type="text" value="<?= $arrayMyProfile[0]['Address2'] ?>" name="Address2" maxlength="125" id="Address2">
                    </div>
                    
                    <div class="form-group" id="billing_country">
                      <label><?= COUNTRY ?> : <span class="red">*</span></label>
                      <div class="sel-wrap-friont">
                                        <?php
                                        if ($arrayMyProfile[0]['Country'] != '') {
                                            $CountrySelected = $arrayMyProfile[0]['Country'];
                                        } else {
                                            $CountrySelected = $Config['country_id'];
                                        }
                                        ?>
                                        <select name="Country" class="inputbox form-control" id="country_ids"  onChange="Javascript: StateListSend();">
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
                    
                    <div class="form-group" id="billing_state">
                      <label><?= STATE ?> : <span class="red">*</span></label>
                      <div class="sel-wrap-friont" id="state_td">

                                </div>
                    </div>
                    
                    <div class="form-group" id="StateBillOther_Div">
                      <label> <div id="StateTitleDiv"><?= OTHER_STATE ?> : <span class="red">*</span></div></label>
                      <div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arrayMyProfile[0]['OtherState']; ?>"  maxlength="30" /> </div>  
                    </div>
                    
                    <div class="form-group" id="CityBill_Div">
                      <label> <div id="MainCityTitleDiv"> <?= CITY ?> : <span class="red">*</span></div></label>
                      <div id="city_td" class="sel-wrap-friont"></div>
                    </div>
                    
                    <div class="form-group" id="CityBillOther_Div">
                      <label>  <div id="CityTitleDiv"> <?= OTHER_CITY ?> : <span class="red">*</span></div></label>
                                <div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arrayMyProfile[0]['OtherCity']; ?>"  maxlength="30" />  </div>
                    </div>
                    
                    <div class="form-group">
                      	<label><?= ZIP_CODE ?> : <span class="red">*</span></label>
                        <input type="text" value="<?= $arrayMyProfile[0]['ZipCode'] ?>" name="ZipCode" maxlength="24" id="ZipCode">
                    </div>
                    
                    <div class="form-group">
                      	<label><?= PHONE_NUMBER ?> : <span class="red">*</span></label>
                        <input type="text" value="<?= $arrayMyProfile[0]['Phone'] ?>" name="Phone" maxlength="24" id="Phone">
                    </div>
                
                
                
                    <?php /*?><div class="block">
                        <div class="fieldset">
                            <fieldset>
                                <div class="field required first">
                                    <label></label>
                                    <input type="text" value="<?= $arrayMyProfile[0]['FirstName'] ?>" name="FirstName" maxlength="24" id="FirstName">
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="field required">
                                    <label><?= LAST_NAME ?> : <span class="red">*</span></label>
                                    <input type="text" value="<?= $arrayMyProfile[0]['LastName'] ?>" name="LastName" maxlength="24" class="formControlText" id="LastName">
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="field">
                                    <label><?= COMPANY_NAME ?> : </label>
                                    <input type="text" value="<?= $arrayMyProfile[0]['Company'] ?>" name="Company" maxlength="50" class="formControlText" id="Company">
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="field required">
                                    <label><?= ADDRESS_LINE1 ?> : <span class="red">*</span></label>
                                    <input type="text" value="<?= $arrayMyProfile[0]['Address1'] ?>" name="Address1" maxlength="125" id="Address1">
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="field">
                                    <label><?= ADDRESS_LINE2 ?> : </label>
                                    <input type="text" value="<?= $arrayMyProfile[0]['Address2'] ?>" name="Address2" maxlength="125" id="Address2">
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="field required" id="billing_country">
                                    <label><?= COUNTRY ?> : <span class="red">*</span></label>
                                    <div class="sel-wrap-friont">
                                        <?php
                                        if ($arrayMyProfile[0]['Country'] != '') {
                                            $CountrySelected = $arrayMyProfile[0]['Country'];
                                        } else {
                                            $CountrySelected = $Config['country_id'];
                                        }
                                        ?>
                                        <select name="Country" class="inputbox form-control" id="country_id"  onChange="Javascript: StateListSend();">
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
                            <div class="field required" id="billing_state">
                                <label><?= STATE ?> : <span class="red">*</span></label>
                                <div class="sel-wrap-friont" id="state_td">

                                </div>
                            </div>
                        </fieldset>

                            <fieldset>
                                <div class="field" id="StateBillOther_Div">
                                    <label> <div id="StateTitleDiv"><?= OTHER_STATE ?> : <span class="red">*</span></div></label>
                                    <div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arrayMyProfile[0]['OtherState']; ?>"  maxlength="30" /> </div>  
                                </div>
                            </fieldset>

                        <fieldset>
                            <div class="field" id="CityBill_Div">
                                <label> <div id="MainCityTitleDiv"> <?= CITY ?> : <span class="red">*</span></div></label>
                                <div id="city_td" class="sel-wrap-friont"></div>
                            </div>
                        </fieldset>  

                        <fieldset>
                            <div class="field" id="CityBillOther_Div">
                                <label>  <div id="CityTitleDiv"> <?= OTHER_CITY ?> : <span class="red">*</span></div></label>
                                <div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arrayMyProfile[0]['OtherCity']; ?>"  maxlength="30" />  </div>
                            </div>
                        </fieldset>  

                        <fieldset>
                            <div class="field required">
                                <label><?= ZIP_CODE ?> : <span class="red">*</span></label>
                                <input type="text" value="<?= $arrayMyProfile[0]['ZipCode'] ?>" name="ZipCode" maxlength="24" id="ZipCode">
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="field required">
                                <label><?= PHONE_NUMBER ?> : <span class="red">*</span></label>
                                <input type="text" value="<?= $arrayMyProfile[0]['Phone'] ?>" name="Phone" maxlength="24" id="Phone">
                            </div>
                        </fieldset>
                    </div>
                </div><?php */?>
                <div class="block">
                    <div class="buttons">
                        <input type="hidden" name="Cid" id="Cid"  value="<?php echo $Cid; ?>" />
                        <input type="hidden" value="<?php echo $arrayMyProfile[0]['State']; ?>" id="main_state_id" name="main_state_id">		
                        <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arrayMyProfile[0]['City']; ?>" />
                        <input type="hidden" name="billcountry_id" id="billcountry_id" value="">
                        <input type="submit" value="Save" class="btn btn-info submit" id="UpdateMyProfile">
                      <!--<input type="reset" value="Reset" class="button reset ">-->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script language="javascript">
    StateListSend();
</script>