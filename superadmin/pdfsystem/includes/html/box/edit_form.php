<?php $plandata=  unserialize($arryUser->planData); ?>
<style>span.error-message {color:#FF0000;}</style>
<table width="97%" border="0" align="center" cellpadding="0"
       cellspacing="0">
    <form name="form1" action="" method="post" onSubmit="" enctype="multipart/form-data">
        <tr>
            <td align="center" valign="top">
<?php //echo '<pre>';print_r($arryUser);?>
<input type="hidden" name="company_code" value="<?php echo $arryUser->company_code; ?>">
                <table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="2" align="left" class="head">User Details</td>
                    </tr>
                    <tr>
                        <td align="right" class="blackbold">Company Name :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userFname'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userFname', 'maxlength' => 50, 'value' => stripslashes($arryUser->firstName)));
?></td>
                    </tr>

                   <!--<tr>
                        <td align="right" class="blackbold">LastName :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userLname'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userLname', 'maxlength' => 50, 'value' => stripslashes($arryUser->lastName)));
?></td>
                    </tr>-->

                    <tr>
                        <td align="right" class="blackbold">ContactNo :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userContacts'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userContacts', 'maxlength' => 50, 'value' => stripslashes($arryUser->phone)));
?></td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold">Country :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userCountry'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userCountry', 'maxlength' => 50, 'value' => stripslashes($arryUser->country)));
?></td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold">State :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userState'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userState', 'maxlength' => 50, 'value' => stripslashes($arryUser->state)));
?></td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold">City :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userCity'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userCity', 'maxlength' => 50, 'value' => stripslashes($arryUser->city)));
?></td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold" valign="top">Address :<span
                                class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userAddress'), array('type' => 'textarea', 'class' => '', 'id' => 'userAddress', 'maxlength' => 50, 'value' => stripslashes($arryUser->address)));
?></td>
                    </tr>
<?php //print_r($package); ?>
                    <tr>
                        <td align="right" class="blackbold">Package :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('userPackageId'), array('type' => 'select', 'disabled' => 'disabled', 'class' => 'inputbox', 'id' => 'userPackageId', 'maxlength' => 50, 'selected' =>$plandata['id'], 'options' => $package));
?></td>
                    </tr>


<!--<tr>
                            <td align="right" class="blackbold">Payment mode :<span class="red"></span></td>
                            <td align="left"><input type="checkbox" id = 'onLinePayment' value="1" name="onLinePayment" <?php if(!empty($arryUser->onLinePayment)){ echo " checked=\"checked\""; }?> > Online
                            </td>
                    </tr> -->
<?php 
if($plandata['plan_type']=='STORAGE'){?>
 <tr>

                        <td align="right" class="blackbold">Allow storage (GB) :<span class="red">*</span></td>
                        <td align="left"><?php echo $FormHelper->input(__('allow_storage'), array('type' => 'text',  'class' => 'inputbox', 'id' => 'allow_storage', 'maxlength' => 50,'value' => stripslashes($arryUser->allow_storage) ));
?></td>
                    </tr>
<?php } ?>

                    <tr>
                        <td colspan="2" align="left" class="head">Account Details</td>
                    </tr>


                    <tr>
                        <td align="right" class="blackbold" width="35%">User Name :</td>
                        <td align="left"><level><?php echo stripslashes($arryUser->username); ?></label></td>
                        </tr>



                        <tr>
                            <td align="right" class="blackbold">Status :</td>
                            <td align="left"><?
                                $ActiveChecked = ' checked';
                                if ($_REQUEST['edit'] > 0) {
                                    if ($arryUser->status == 1) {
                                        $ActiveChecked = ' checked';
                                        $InActiveChecked = '';
                                    }
                                    if ($arryUser->status == 0) {
                                        $ActiveChecked = '';
                                        $InActiveChecked = ' checked';
                                    }
                                }
                                ?> 
                                <label><input type="radio" name="status" id="status" value="1"
<?= $ActiveChecked ?> /> Active</label>&nbsp;&nbsp;&nbsp;&nbsp; 
                                <label><input type="radio" name="status" id="status" value="0" <?= $InActiveChecked ?> /> InActive</label></td>
                        </tr>

                </table>

            </td>
        </tr>

        <tr>
            <td align="left" valign="top">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <div id="SubmitDiv" style="display: none1"><? if ($_REQUEST['edit'] > 0) $ButtonTitle = 'Update ';
else $ButtonTitle = ' Submit '; ?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton"value=" <?= $ButtonTitle ?> " /> <input type="hidden" name="userID"
                                                                                                                             id="userID" value="<?= $_REQUEST['edit'] ?>" /> </div>

            </td>
        </tr>
    </form>
</table>
