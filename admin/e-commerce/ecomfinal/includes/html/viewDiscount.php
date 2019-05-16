<div class="had"><?=$ModuleTitle;?></div>
<form name="frmDiscounts" action="" method="post" onSubmit="return CheckDiscountsForm(this)">
    <table width="100%"   border=0 align="center" cellpadding=0 cellspacing=0>
        <tr>
            <td>
                <div class="message"><? if (!empty($_SESSION['mess_discount'])) {
                            echo stripslashes($_SESSION['mess_discount']);
                            unset($_SESSION['mess_discount']);
                        } ?></div>

                <table width="100%" cellpadding="0" cellspacing="5" border="0" class="borderall">
                    <tr>
                        <td>

                            <input type="hidden" name="action" value="update_discounts">
                            <table width="50%" cellpadding="0" cellspacing="5" border="0">
                                <tr>
                                    <td class="formItemCaption"><b>Use global discounts?</b></td>
                                    <td class="formItemControl">
                                        <select name="DiscountsActive" class="inputboxSmall">
                                            <option value="Yes">Yes</option>
                                            <option value="No" <?= $settings["DiscountsActive"] == "No" ? "selected" : "" ?>>No</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="admin-list-table">
                                <thead>
                                    <tr>
                                        <th class="icon">&nbsp;</th>
                                        <th style="width:115px;">&nbsp;</th>
                                        <th style="width:115px;">Min Amount</th>
                                        <th style="width:115px;">Max Amount</th>
                                        <th style="width:115px;">Discount</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($arryDiscount as $key => $discount) {
                                        ?>
                                        <tr valign="top">
                                            <td class="icom"><input id="id_active<?= $i ?>" type="checkbox" name="active[<?= $discount["DID"] ?>]" value="Yes" <?= $discount["Active"] == "Yes" ? "checked" : "" ?>></td>
                                            <td><label for="id_active<?= $i ?>"><b>Range <?= $i++ ?></b></label></td>
                                            <td><input type="text" name="min_values[<?= $discount["DID"] ?>]" value="<?= $objDiscount->myNum($discount["Min"]) ?>" class="inputboxSmall"></td>
                                            <td><input type="text" name="max_values[<?= $discount["DID"] ?>]" value="<?= $objDiscount->myNum($discount["Max"]) ?>" class="inputboxSmall"></td>
                                            <td><input type="text" name="discounts[<?= $discount["DID"] ?>]" value="<?= $objDiscount->myNum($discount["Discount"]) ?>" class="inputboxSmall"></td>
                                            <td>
                                                <select name="types[<?= $discount["DID"] ?>]" class="inputboxSmall" style="width:85px;">
                                                    <option value="percent">%</option>
                                                    <option value="amount" <?= $discount["Type"] == "amount" ? "selected" : "" ?>>amount</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php
                                        $i = $i + 1;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </td>   
                    </tr>   
                </table>   

            </td>
        </tr>
        <tr>
            <td align="center" height="135" valign="top"><br>
                <input type="submit" class="button" value="Save changes"/>
            </td>
        </tr>
    </table>
</form>        
