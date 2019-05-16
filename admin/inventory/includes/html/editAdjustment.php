
<a href="<?= $RedirectURL ?>" class="back">Back</a>

<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <? echo (!empty($_GET['edit'])) ? ("Edit " . $ModuleName) : ("Add " . $ModuleName); ?>

    </span>
</div>
<? if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
<?
}



if (!empty($ErrorMSG)) {
    echo '<div class="message" align="center">' . $ErrorMSG . '</div>';
} else {
    #include("includes/html/box/po_form.php");
    ?>


    <script language="JavaScript1.2" type="text/javascript">
        function validateForm(frm) {
            var NumLine = parseInt($("#NumLine").val());


            var adjID = Trim(document.getElementById("adjID")).value;



            if (ValidateForSelect(frm.warehouse, "Adjustment Location ")
                    && ValidateForSelect(frm.adjustment_reason, "Adjustment Reason")

                    ) {

                for (var i = 1; i <= NumLine; i++) {
                    if (document.getElementById("sku" + i) != null) {
                        if (!ValidateForSelect(document.getElementById("sku" + i), "SKU")) {
                            return false;
                        }
												if (!ValidateForSelect(document.getElementById("Condition" + i), "Item Condition")) {
                            return false;
                        }
                        if (!ValidateForSimpleBlank(document.getElementById("description" + i), "Item Description")) {
                            return false;
                        }
                        if (!ValidateMandNumField2(document.getElementById("qty" + i), "Quantity", 1, 999999)) {
                            return false;
                        }

                        if (!ValidateMandDecimalField(document.getElementById("price" + i), "Unit Price")) {
                            return false;
                        }
//1Feb by chetan//
                        if (document.getElementById("valuationType" + i).value == "Serialized"   || document.getElementById("valuationType" + i).value === 'Serialized Average') {
                            if (!ValidateForSimpleBlank(document.getElementById("serial_value" + i), "Serial Number for " + document.getElementById("sku" + i).value)) {
                                return false;
                            }

                        }

                    }
                }



                if (ModuleVal != '' && OrderID == '') {
                    var Url = "isRecordExists.php?" + ModuleField + "=" + escape(ModuleVal) + "&editID=" + OrderID;
                    SendExistRequest(Url, ModuleField, "<?= $ModuleIDTitle ?>");
                    return false;
                } else {
                    ShowHideLoader('1', 'S');
                    return true;
                }

            } else {
                return false;
            }

        }
    </script>




    <script>
        $(function() {
            var ModuleID = '';
            $("#" + ModuleID).tooltip({
                position: {
                    my: "center bottom-2",
                    at: "center+110 bottom+70",
                    using: function(position, feedback) {
                        $(this).css(position);

                    }
                }
            });
        });



function getBinLoction(WID)
{
//var WID =$('#WID'+selid).val();

if(WID)

{
$.ajax
({
type:'POST',
url:'../ajaxInv.php',
data:'WID='+WID,
success:function(data)
{

$('#binloc').html(data);
//$(‘#binloc’).html(‘<option value=””>Select Warehouse First</option>’);
}
});
}else
{
$('#binloc').html('<option value="">Select Warehouse First</option>');
//$(‘#city’).html(‘<option value=””>Select State First</option>’);

}

}


    </script>

<? //PK ?>
 <div class="message"><? if (!empty($_SESSION['mess_adjustment'])) {
    echo $_SESSION['mess_adjustment'];
    unset($_SESSION['mess_adjustment']);
} ?>
</div>


    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head">Adjustment Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 

 <tr <?=$HideTr?>>
                                        <td align="right"   class="blackbold" > <?=ADJ_NO?>:  <span class="red">*</span> </td>
                                        <td  align="left">
                                        <input type="text" name="Adj_No" id="Adj_No" class="disabled" readonly maxlenghth="40" value="<?= stripslashes($arryAdjustment[0]['adjustNo']); ?>">
                                           </td>
                                    </tr>


 <tr>
                                        <td align="right"   class="blackbold" > <?=ADJ_DATE?>:  <span class="red">*</span> </td>
                                        <td  align="left">
                                        <?
	 
	echo  date($Config['DateFormat'] , strtotime($arryAdjustment[0]['adjDate']));

 ?>
                                           </td>
                                    </tr>


                                    <tr>
                                        <td align="right"   class="blackbold" > Adjustment to Item At Location:  <span class="red">*</span> </td>
                                        <td  align="left">
                                        
                                            <select name="warehouse" id="warehouse" class="inputbox" <? if($_SESSION['InventoryLevel']==1){?>onchange="return getBinLoction(this.value,'ation');"<?}?>>
                                                <option value="">Select Adjustment Location</option>
                                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                                    <option value="<?= $arryWarehouse[$i]['WID'] ?>" <?
                                                    if ($arryWarehouse[$i]['WID'] == $arryAdjustment[0]['WID']) {
                                                        echo "selected";
                                                    }
                                                    ?>>
                                                    <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                                    </option>
    <? } ?>                                                     
                                            </select>

    <!--<a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?= $search ?></a>--></td>
                                    </tr>

<? if($_SESSION['InventoryLevel']==1){?>
<tr>
<td  align="right"   class="blackbold" >   Bin Location:  <span class="red">*</span> </td>
		<td   align="left"><select name="binloc" class="inputbox"  id="binloc"  >
<option value="">Select Bin</option>
<? if(count($arrayBin) > 0){
       
        foreach($arrayBin as $key=>$values){
if($values['binid'] == $arryAdjustment[0]['binloc']){
$select = "selected";
}else{

$select = "";
}
            echo '<option value="'.$values['binid'].'" '.$select.'>'.$values['binlocation_name'].'</option>';
        }
    }else{
        echo '<option value="">Bin not available</option>';
    }?>
</select></td>
</tr>
<? }?>

                                    <tr>
                                        <td align="right"   class="blackbold" >Adjustment Reason:  <span class="red">*</span> </td>
                                        <td  align="left">


<?
/***PK********/
if($OpeningStock==1){
	echo '<input type="text" name="adjustment_reason" id="adjustment_reason" class="disabled_inputbox" readonly maxlenghth="40" value="Opening Stock">';
	$HideQty = 'Style="display:none"';
}else{
	$HideQty = '';
?>


    <select name="adjustment_reason" id="adjustment_reason" class="inputbox">
        <option value="">Select Adjustment Reason</option>
        <? for ($i = 0; $i < sizeof($arryReason); $i++) { ?>
            <option value="<?= $arryReason[$i]['attribute_value'] ?>" <?
                        if ($arryReason[$i]['attribute_value'] == $arryAdjustment[0]['adjust_reason']) {
                            echo "selected";
                        }
                        ?>>
<?= $arryReason[$i]['attribute_value'] ?>
            </option>
<? } ?>                                                     
    </select>

<? } 
/***PK********/
?>


                                        </td>
                                    </tr>

                                    <tr>
                                        <td  align="right"   class="blackbold" >Adjustment Status  : </td>
                                        <td   align="left" >
                                            <select name="Status" id="Status" class="inputbox">
                                                <option value=" ">--Select Status--</option>
                                                <option value="1" <? if ($arryAdjustment[0]['Status'] == 1) {
        echo "selected";
    } ?>>Parked</option>
                                                <option value="2" <? if ($arryAdjustment[0]['Status'] == 2) {
        echo "selected";
    } ?>>Completed</option>
                                                <option value="0" <? if ($arryAdjustment[0]['Status'] == '0') {
        echo "selected";
    } ?>> Canceled</option>

                                            </select>


                                        </td>
                                    </tr>



                                </table>

                            </td>
                        </tr>






                        <tr>
                            <td colspan="2" align="right">
    <?
//$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
    ?>	 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left" class="head" >Adjustment Item</td>
                        </tr>

                        <tr>
                            <td align="left" colspan="2">
    <? include("includes/html/box/adjust_item_form.php"); ?>
                            </td>
                        </tr>

                    </table>	


                </td>
            </tr>


            <tr <?= $disNone ?>>
                <td  align="center">


    <? 
    
    #echo $arryAdjustment[0]['Status']; exit;
    if ($_GET['edit'] > 0){
        $ButtonTitle = 'Update ';
    }else{
        $ButtonTitle = ' Submit ';
    }
    if ($arryAdjustment[0]['Status'] != 2 ) {
        ?>
                        <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
    <? } ?>
                    <input type="hidden" name="adjID" id="adjID" value="<?= $_GET['edit'] ?>" />
                    <input type="hidden" name="PrefixPO" id="PrefixPO" value="<?= $PrefixPO ?>" />



                </td>
            </tr>

        </table>

    </form>


<? } ?>


<? #echo '<script>SetInnerWidth();</script>';  ?>


