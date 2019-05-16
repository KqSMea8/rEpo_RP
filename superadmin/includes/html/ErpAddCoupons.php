<script language="JavaScript1.2" type="text/javascript">
    function validateForm(frm) {
        var cpEdit = '<?php echo $_GET['edit']; ?>';
        if (ValidateForSimpleBlank(frm.CouponCode, "Coupon Code")
                && ValidateForSimpleBlank(frm.MinAmount, "Minimum Amount")
                //&& ValidateForSimpleBlank(frm.Amount, "Amount")
                && ValidateForSelect(frm.CouponType, "Coupon Type")
                && ValidateForSelect(frm.ExpiryDate, "Expiry Date")
                ) {

            if (cpEdit == '') {
               
                var Url = "isRecordExists.php?CouponCode=" + escape(document.getElementById("CouponCode").value) + "&editID=" + document.getElementById("CouponCode").value;

                SendExistRequest(Url, "CouponCode", "Coupon Code");
                return false;   
            }


        } else {
            return false;
        }

    }


    function randomString() {
        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var string_length = 10;
        var randomstring = '';
        for (var i = 0; i < string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }
        document.form1.CouponCode.value = randomstring;
    }


    function ShowTypeOption() {
        if (document.getElementById("CouponType").value == 'Fixed') {
            document.getElementById('AmountTitle').style.display = 'block';
            document.getElementById('AmountValue').style.display = 'block';

            document.getElementById('PercentageTitle').style.display = 'none';
            document.getElementById('PercentageValue').style.display = 'none';

            document.getElementById('PackageTitle').style.display = 'none';
            document.getElementById('PackageValue').style.display = 'none';
            document.getElementById('UserValue').style.display = 'none';
            document.getElementById('UserTitle').style.display = 'none';

            document.getElementById('DiscountTypeTitle').style.display = 'none';
            document.getElementById('DiscountType').style.display = 'none';


        } else if (document.getElementById("CouponType").value == 'Percentage') {
            document.getElementById('AmountTitle').style.display = 'none';
            document.getElementById('AmountValue').style.display = 'none';

            document.getElementById('PackageTitle').style.display = 'none';
            document.getElementById('PackageValue').style.display = 'none';

            document.getElementById('PercentageTitle').style.display = 'block';
            document.getElementById('PercentageValue').style.display = 'block';

            document.getElementById('UserValue').style.display = 'none';
            document.getElementById('UserTitle').style.display = 'none';

            document.getElementById('DiscountTypeTitle').style.display = 'none';
            document.getElementById('DiscountType').style.display = 'none';


        } else if (document.getElementById("CouponType").value == 'Package') {
            document.getElementById('AmountTitle').style.display = 'none';
            document.getElementById('AmountValue').style.display = 'none';

            document.getElementById('PackageTitle').style.display = 'block';
            document.getElementById('PackageValue').style.display = 'block';

            document.getElementById('PercentageTitle').style.display = 'none';
            document.getElementById('PercentageValue').style.display = 'none';

            document.getElementById('UserValue').style.display = 'block';
            document.getElementById('UserTitle').style.display = 'block';

            document.getElementById('DiscountTypeTitle').style.display = 'block';
            document.getElementById('DiscountType').style.display = 'block';

        } else {

            document.getElementById('AmountTitle').style.display = 'none';
            document.getElementById('AmountValue').style.display = 'none';

            document.getElementById('PackageTitle').style.display = 'none';
            document.getElementById('PackageValue').style.display = 'none';

            document.getElementById('PercentageTitle').style.display = 'none';
            document.getElementById('PercentageValue').style.display = 'none';

            document.getElementById('UserValue').style.display = 'none';
            document.getElementById('UserTitle').style.display = 'none';

            document.getElementById('DiscountTypeTitle').style.display = 'none';
            document.getElementById('DiscountType').style.display = 'none';

        }
    }

    function ShowTypeOption2() {
        if (document.getElementById("DiscountType").value == 'Fixed') {

            document.getElementById('AmountTitle').style.display = 'block';
            document.getElementById('AmountValue').style.display = 'block';

            document.getElementById('PercentageTitle').style.display = 'none';
            document.getElementById('PercentageValue').style.display = 'none';


        } else if (document.getElementById("DiscountType").value == 'Percentage') {

            document.getElementById('PercentageTitle').style.display = 'block';
            document.getElementById('PercentageValue').style.display = 'block';

            document.getElementById('AmountTitle').style.display = 'none';
            document.getElementById('AmountValue').style.display = 'none';


        } else {


            //document.getElementById('AmountTitle').style.display = 'none'; 
            //document.getElementById('AmountValue').style.display = 'none'; 

            //document.getElementById('PercentageTitle').style.display = 'none'; 
            //document.getElementById('PercentageValue').style.display = 'none'; 



        }
    }


</script>

<?php include('siteManagementMenu.php'); ?>
<div class="clear"></div>
<br>
<div class="message" align="center">
    <?php if(!empty($_SESSION['mess_coupons'])) {echo $_SESSION['mess_coupons']; unset($_SESSION['mess_coupons']); }?>
</div>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">

    <form name="form1" action="" method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
        <tr>
            <td align="center" valign="top">
                
                <table width="100%" border="0" cellpadding="5" cellspacing="10" class="borderall">
                    <div align="right">
                        <a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
                    </div>
                    <br>
                    <tr>
                        <td align="right" class="blackbold" valign="top">Coupon Code :<span class="red">*</span></td>
                        <td align="left">
                            <input id="CouponCode" name="CouponCode" 
                                <?php if (!empty($_GET['edit'])) { ?> readonly
                                    class="inputbox disabled" <?php } ?> maxlength="30"
                                    class="datebox"
                                    value="<?= !empty($arryCoupon[0]['CouponCode']) ? stripslashes($arryCoupon[0]['CouponCode']) : ''; ?>"
                                    type="text" onKeyPress="Javascript:ClearAvail('MsgSpan_Domain');"
                                    onBlur="Javascript:CheckAvailField('MsgSpan_Domain', 'CouponCode', '<?= $_GET['edit'] ?>');">
                                <?php if(empty($_GET['edit'])){ ?> <span id="MsgSpan_Domain"></span><?php }?>
                        </td>
                    </tr>

                    <?php if(empty($_GET['edit'])) { ?>
                    <tr>
                        <td align="right" class="blackbold"></td>
                        <td align="left" valign="top">
                            <a href="Javascript:void(0);" onClick="randomString();" class="grey_bt" style="float: left;">
                                Generate Coupon Code</a>
                        </td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td align="right" width="45%" class="blackbold" valign="top">Minimum Amount:<span
                                class="red">*</span></td>
                        <td align="left">
                            <input id="MinAmount" name="MinAmount" maxlength="10" class="datebox"
                                value="<?= !empty($arryCoupon[0]['MinAmount']) ? stripslashes($arryCoupon[0]['MinAmount']) : ''; ?>"
                                type="text" onkeypress="return isNumberKey(event);"/> $
                        </td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold">Coupon Type :<span class="red">*</span></td>
                        <td align="left">
                            <select name="CouponType" class="inputbox" id="CouponType" onChange="Javascript:ShowTypeOption();">
                                <option value="">--- Select ---</option>
                                <option value="Fixed"
                                    <?php if ($arryCoupon[0]['CouponType'] == "Fixed") {
                                        echo "selected";} ?>>Fixed Amount
                                </option>
                                <option value="Percentage"
                                        <?php if ($arryCoupon[0]['CouponType'] == "Percentage") {
                                            echo "selected";} ?>>Percentage</option>
                                <option value="Package" <?php if ($arryCoupon[0]['CouponType'] == "Package") {
                                    echo "selected";} ?>>Package Discount
                                </option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold" id="DiscountTypeTitle">Discount Type :</td>
                        <td align="left">
                            <select name="DiscountType" class="inputbox"
                                    id="DiscountType" onChange="Javascript:ShowTypeOption2();">
                                <option value="">--- Select ---</option>
                                <option value="Fixed" <?php if ($arryCoupon[0]['DiscountType'] == "Fixed") {
                                    echo "selected";} ?>>Fixed Amount
                                </option>
                                <option value="Percentage" <?php if ($arryCoupon[0]['DiscountType'] == "Percentage") {
                                    echo "selected";} ?>>Percentage
                                </option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold" valign="top">
                            <div id="PercentageTitle">
                                Discount Percentage :
                            </div>
                            <div id="AmountTitle">
                                Discount Amount :
                            </div>
                            <div id="PackageTitle" style="margin-top:18px;">Package :</div>
                        </td>
                        <td align="left">
                            <div id="PercentageValue">
                                <input name="Percentage" type="text" class="textbox" id="Percentage"
                                       value="<?= stripslashes($arryCoupon[0]['Percentage']) ?>" size="3"
                                       maxlength="10" onkeypress='return isDecimalKey(event)' /> %
                            </div>

                            <div id="AmountValue">
                                <input name="Amount" type="text" class="textbox" id="Amount"
                                       value="<?= stripslashes($arryCoupon[0]['Amount']) ?>"
                                       maxlength="10" size="10" onkeypress='return isNumberKey(event)'/> $
                            </div> <?php $package = explode(",", $arryCoupon[0]['Package']); ?>

                            <div id="PackageValue" style="margin-top:10px;">
                                <input type="checkbox" name="Package[]" id="AmountValue"
                                       value="7" <?php if (in_array("7", $package)) {echo "checked";} ?> />
                                STANDARD<br> 
                                <input type="checkbox" name="Package[]" id="AmountValue" value="8"
                                    <?php if (in_array("8", $package)) {echo "checked";} ?> />
                                PROFESSIONAL<br> 
                                <input type="checkbox" name="Package[]" id="AmountValue" value="9"
                                    <?php if (in_array("9", $package)) {echo "checked";} ?> />
                                ENTERPRISE<br>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold">
                            <div id="UserTitle"> Discount Users:</div>
                        </td>

                        <td align="left">
                            <div id="UserValue">
                                <input id="User" name="User" maxlength="10" class="datebox"
                                       value="<?= !empty($arryCoupon[0]['User']) ? stripslashes($arryCoupon[0]['User']) : ''; ?>"
                                       type="text" onkeypress="return isNumberKey(event);">
                            </div>
                        </td>
                    </tr>

                    <tr>

                        <td align="right" class="blackbold">
                            <div>Use Limit:</div>
                        </td>

                        <td align="left">
                            <div>
                                <input id="UseLimit" name="UseLimit" maxlength="10" class="datebox"
                                       value="<?= !empty($arryCoupon[0]['UseLimit']) ? stripslashes($arryCoupon[0]['UseLimit']) : ''; ?>"
                                       type="text" onkeypress="return isNumberKey(event);">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">Expiry Date :<span class="red">*</span>
                        </td>
                        <td align="left"><?php $ExpiryDate =''; if($arryCoupon[0]['ExpiryDate']>0)$ExpiryDate = $arryCoupon[0]['ExpiryDate'];?>
                            <script>
                                $(function () {
                                    $("#ExpiryDate").datepicker({
                                        showOn: "both",
                                        yearRange: '<?= date("Y") - 1 ?>:<?= date("Y") + 20 ?>',
                                                    dateFormat: 'yy-mm-dd',
                                                    changeMonth: true,
                                                    changeYear: true
                                                });

                                                $("#expNone").on("click", function () {
                                                    $("#ExpiryDate").val("");
                                                }
                                                );

                                            });
                            </script> 
                            <input id="ExpiryDate" name="ExpiryDate" readonly=""
                                             class="datebox" value="<?= $ExpiryDate ?>" type="text"/>


                            &nbsp;&nbsp;&nbsp;&nbsp;<!--a href="Javascript:void(0);" id="expNone">None</a-->
                        </td>
                    </tr>

                    <tr>
                        <td align="right" class="blackbold">Status :</td>
                        <td align="left"><?php 
                            $ActiveChecked = ' checked'; $InActiveChecked ='';
                            if($_GET['edit'] > 0){
                            if($arryCoupon[0]['Status'] == 'Yes') {$ActiveChecked = ' checked'; $InActiveChecked ='';}
                            if($arryCoupon[0]['Status'] == 'No') {$ActiveChecked = ''; $InActiveChecked = ' checked';}
                            }
                            ?> <label><input type="radio" name="Status" id="Status"
                                             value="Yes" <?= $ActiveChecked ?> /> Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="Status" id="Status" value="No"
                                    <?= $InActiveChecked ?> /> InActive</label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td align="left" valign="top">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <div id="SubmitDiv" style="display: none1">

                    <? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton"
                           value=" <?= $ButtonTitle ?> " /> <input type="hidden"
                           name="LicenseID" id="LicenseID" value="<?= $_GET['edit'] ?>" />
                </div>
            </td>
        </tr>
    </form>
</table>
<SCRIPT LANGUAGE=JAVASCRIPT>
    ShowTypeOption();
    ShowTypeOption2();
</SCRIPT>
