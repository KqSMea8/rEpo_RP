

<script language="JavaScript1.2" type="text/javascript">


    function SendEventExistRequest(Url) {
        var SendUrl = Url + "&r=" + Math.random();
        httpObj.open("GET", SendUrl, true);
        httpObj.onreadystatechange = function RecieveEventRequest() {
            if (httpObj.readyState == 4) {


                if (httpObj.responseText == 1) {

                    alert("Warehouse code already exists in database. Please enter another.");
                    document.getElementById("warehouse_code").select();
                    return false;
                } else if (httpObj.responseText == 2) {
                    alert("Warehouse name already exists in database. Please enter another.");
                    document.getElementById("warehouse_name").select();
                    return false;
                } else if (httpObj.responseText == 0) {
                    document.forms[0].submit();
                } else {
                    alert("Error occur : " + httpObj.responseText);
                    return false;
                }
            }
        };
        httpObj.send(null);
    }

    function validateAdjust(frm) {
        if (ValidateForSelect(frm.warehouse, "Adjustment Location")
                && ValidateForSelect(frm.adjustment_reason, "Adjustment Reason")
                && ValidateForSelect(frm.Sku, "Item")
                //&& ValidateForSelect(frm.evaluationType,"Evaluation Type")
                && ValidateForSimpleBlank(frm.quantity, "Quantity")
                //&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
                //&& ValidateForTextareaMand(frm.description,"description",10,300)
                //&& ValidateForSimpleBlank(frm.description,"description")


                ) {




            var Url = "isRecordExists.php?Sku=" + escape(document.getElementById("Sku").value) + "&editID=" + document.getElementById("ItemID").value + "&Type=Inventory";
            alert(Url);
            //SendExistRequest(Url);

            ShowHideLoader(1, 'S');

            return false;


        } else {
            return false;
        }


    }


    function newPopup(url, windowName) {
        window.open(url, windowName, 'height=768,width=1366,left=10,top=10,titlebar=no,toolbar=no,menubar=no,location=no,directories=no,status=no');
    }

</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" action=""  method="post" onSubmit="return validateAdjust(this);" enctype="multipart/form-data">


        <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="2" align="left" class="head">Adjustment </td>
                    </tr>

                    <tr>
                        <td width="31%" align="right"   class="blackbold" > Adjustment to Item At Location:  <span class="red">*</span> </td>
                        <td width="69%" height="30" align="left">
                        <!--<input  name="warehouse" id="warehouse" value="" readonly="readonly" type="text" class="disabled"  maxlength="30" />-->	
                        <!--<input  name="WID" id="WID" value="" type="hidden"  class="inputbox"  maxlength="30" />	-->
                            <select name="warehouse" id="warehouse" class="inputbox">
                                <option value="">Select Adjustment Location</option>
                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                    <option value="<?= $arryWarehouse[$i]['warehouse_code'] ?>" <? if ($arryWarehouse[$i]['warehouse_code'] == $arryAdjustment[0]['warehouse']) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                    </option>
<? } ?>                                                     
                            </select>

<!--<a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?= $search ?></a>--></td>
                    </tr>

                    <tr>
                        <td width="31%" align="right"   class="blackbold" >Adjustment Reason:  <span class="red">*</span> </td>
                        <td width="69%" height="30" align="left">

                            <select name="adjustment_reason" id="adjustment_reason" class="inputbox">
                                <option value="">Select Adjustment Reason</option>
                                    <? for ($i = 0; $i < sizeof($arryReason); $i++) { ?>
                                    <option value="<?= $arryReason[$i]['attribute_value'] ?>" <? if ($arryReason[$i]['attribute_value'] == $arryAdjustment[0]['adjust_reason']) {
                                        echo "selected";
                                    } ?>>
    <?= $arryReason[$i]['attribute_value'] ?>
                                    </option>
<? } ?>                                                     
                            </select>
                        </td>
                    </tr>



                    <tr>
                        <td width="31%" align="right"   class="blackbold" >Item Sku : <span class="red">*</span> </td>
                        <td width="69%" height="30" align="left">
						<input  type="text" name="Sku" class="disabled" readonly="readonly" id="Sku" value="<? echo stripslashes($arryAdjustment[0]['Sku']); ?>"/>	
						<input  type="hidden" name="item_id" class="inputbox" id="item_id" value="<? echo $arryAdjustment[0]['ItemID']; ?>"/>
						<a class="fancybox fancybox.iframe" href="ItemFetchList.php" ><?= $search ?></a>
                        </td>
                    </tr>


                    <tr>

                        <td width="31%" align="right"   class="blackbold" >Adjustment Quantity :  <span class="red">*</span> </td>
                        <td width="69%" height="30" align="left">

<span id="evelution"> </span>
                            <input  name="quantity" id="quantity" onkeypress="return isNumberKey(event);" value="<? echo stripslashes($arryAdjustment[0]['adjust_qty']); ?>" type="text" class="inputbox"  maxlength="30" />
<span id="serial_display" style="display:none;"> 
                            <?php
                            //if ($arryAdjustment[0]['evaluationType'] == "Serialized") {

                                echo'<a class="fancybox fancybox.iframe" href="editSerial.php?total=10&Sku=' . $arryAdjustment[0]['Sku'] . '&adjusmentID=' . $arryAdjustment[0]['adjustmentID'] . '" id="addItem">Add Serial Number</a>';
                            //}
                            ?>
</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="31%" align="right"   class="blackbold" >Value :  <span class="red">*</span> </td>
                        <td width="69%" height="30" align="left">
                            <input  name="value" id="value" onkeypress="return isNumberKey(event);" value="<? echo stripslashes($arryAdjustment[0]['adjust_value']); ?>" type="text" class="inputbox"  maxlength="30" />	 </td>
                    </tr>
                    <tr>
                        <td width="31%" align="right"   class="blackbold" >Availability  :   </td>
                        <td width="69%" height="30" align="left">
                            <input  name="availability" id="availability" value="<? echo $arryAdjustment[0]['availbility_qty']; ?>" readonly="readonly"  type="text" class="disabled"  size="10" />	 </td>
                    </tr>
                    <tr>
                        <td width="31%" align="right"   class="blackbold" >Comments  :   </td>
                        <td width="69%" height="30" align="left">
                            <textarea name="comment" id="comment" class="inputbox"> <? echo stripslashes($arryAdjustment[0]['comment']); ?></textarea>	 </td>
                    </tr>


                </table>	


            </td>
        </tr>

        <tr>
            <td align="left" valign="top">&nbsp;

            </td>
        </tr>

        <tr>
            <td  align="center">

                <div id="SubmitDiv" style="display:none1">
<? if ($_GET['edit'] > 0) $ButtonTitle = 'Update ';
else $ButtonTitle = ' Add Adjustment'; ?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="button" href="#" onclick="window.location='viewAdjustment.php';" class="button" value="Vieww All" />
                    <input type="hidden" name="WID" id="WID" value="<?= $_GET['edit'] ?>" />

                </div>

            </td>
        </tr>
        <tr>
            <td >
                <table width="100%" border="0"   cellspacing="0" class="borderall">
                    <tbody>

                        <tr >
                            <td class="head1" width="30%"  style="border-right: 1px solid #ddd;">
                                <table  style="width:100%; border-collapse:collapse;" cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td>Adjustment</td>
                                        </tr>
                                    </tbody>
                                </table></td>
                            <td class="head1" width="30%" style="border-right: 1px solid #ddd;"> 
                                <table width="100%"  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td>Warehouse</td>
                                        </tr>
                                    </tbody></table></td>

                            <td class="head1" width="30%"  style="border-right: 1px solid #ddd;">
                                <table width="100%" cellpadding="5" cellspacing="0">
                                    <tbody><tr>
                                            <td>Global Values</td>
                                        </tr>
                                    </tbody></table></td>
                        </tr>
                        
                        <tr>
                            <td   width="30%" style="border-right: 1px solid #ddd;">
                                <table  cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr>
                                        <td class="head1"   style="text-align:Left;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Left;">Product</td>
                                        </tr>
                                    </tbody></table></td>
                            <td  class="head1" style="text-align:Right;border-color: red"><table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Qty</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  class="head1" style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Value</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  class="head1" style="text-align:Left;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Left;">Comments</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                                    </tr>
                                    
                                </table>
                                
                            </td>
                            <td width="30%" style="border-right: 1px solid #ddd;">                        
                                <table  cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr>
                                        <td  class="head1"style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">On Hand</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>

                            <td  class="head1" style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">On Hand Value</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  class="head1" style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Available *</td>
                                        </tr>
                                    </tbody></table></td>
                                    </tr>
                                </table>  
                            </td>
                            <td  width="30%" style="border-right: 1px solid #ddd;">                        
                                <table  cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr>
                                      <td  class="head1" style="text-align:Right;">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Qty</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td class="head1" style="text-align:Right;">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Value</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  class="head1" style="text-align:Right;">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Avg. Land Cost</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td style="text-align:Right;" class="head1">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td>Delete</td>
                                        </tr>
                                    </tbody></table></td>  
                                    </tr>
                                </table>   
                            </td>
                                                               
                        </tr>
                       
                        
                        
                        
                        
                        
                        
                        <tr>
                            <td  width="30%" style="border-right: 1px solid #ddd;">
                                <table  cellpadding="0" cellspacing="0" width="100%" border="0">
                                  <tr>
                                    <td  style="text-align:Left;border-color: red"><table  cellpadding="0" cellspacing="0"><tbody><tr><td style="text-align:Left;">Product</td></tr></tbody></table></td>
                            <td  style="text-align:Right;border-color: red"><table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Qty</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Value</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  style="text-align:Left;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Left;">Comments</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                                    </tr>
                                    
                                </table>
                                
                            </td>
                            <td width="30%" style="border-right: 1px solid #ddd;">                        
                                <table  cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr>
                                        <td style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">On Hand</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>

                            <td  style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">On Hand Value</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Available *</td>
                                        </tr>
                                    </tbody></table></td>
                                    </tr>
                                </table>  
                            </td>
                            <td width="30%" style="border-right: 1px solid #ddd;">                        
                                <table  cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr>
                                      <td  style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Qty</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Value</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td  style="text-align:Right;border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td style="text-align:Right;">Avg. Land Cost</td>
                                        </tr>
                                    </tbody></table></td>
                                    <td i style="border-color: red">
                                <table  cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                            <td>Delete</td>
                                        </tr>
                                    </tbody></table></td>  
                                    </tr>
                                </table>   
                            </td>
                                                               
                        </tr>
                        
                        
                        
                        
                        
                        
                        
                    
                    
                    
                        
                    </tbody>
                </table></td>
        </tr>   </form>
</table>



<script type="text/javascript">
	$(document).ready(function() {
                $("#addItem").click(function() {
                    varTotBox = $("#quantity").val();
                    var Sku = $("#Sku").val();
                    $(this).attr("href", "editSerial.php?total="+varTotBox+"&Sku="+Sku+"&adjusmentID=")
                })
		//$('.fancybox').fancybox();
	});
</script>