
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
            NumLine = parseInt($("#NumLine").val());


            var DsmID = Trim(document.getElementById("DsmID")).value;

            //document.getElementById("sku"+i)

            if (ValidateForSelect(frm.Sku, "Bill Number")
		     && ValidateForSelect(frm.bomCondition, "Condition")
                    && ValidateForSelect(frm.warehouse, "Warehouse Location ")
                    && ValidateForSimpleBlank(frm.disassembly_qty, "Disassembly quantity")

                    ) {



                if (parseInt(document.getElementById("disassembly_qty").value) > parseInt(document.getElementById("on_hand_qty").value)) {
                    alert("Dis-assembly quantity should be less then or equal to available quantity.");
                    document.getElementById("disassembly_qty").focus();
                    return false;
                }


			if (parseInt(document.getElementById("price").value) != parseInt(document.getElementById("TotalValue").value)) {
			alert("Total cost  should be same as disassembly cost.");
			document.getElementById("TotalValue").focus();
			return false;
			}

                if (document.getElementById("Serialized").value == "Serialized") {

                    if (!ValidateForSimpleBlank(document.getElementById("serial_Num"), "Serial Number for " + document.getElementById("Sku").value)) {
                        return false;
                    }


                }


                for (var i = 1; i <= NumLine; i++) {
                    if (document.getElementById("sku" + i) != null) {
                        if (!ValidateForSelect(document.getElementById("sku" + i), "SKU")) {
                            return false;
                        }
												if (!ValidateForSelect(document.getElementById("Condition" + i), "Condition")) {
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
                        if (document.getElementById("valuationType" + i).value == "Serialized" || document.getElementById("valuationType" + i).value == "Serialized Average") {
                            if (!ValidateForSimpleBlank(document.getElementById("serial_value" + i), "Serial Number for " + document.getElementById("sku" + i).value)) {
                                return false;
                            }

                        }

                    }
                }

                var Url = "isRecordExists.php?checkItem=" + escape(document.getElementById("Sku").value) + "&editID=" + document.getElementById("DsmID").value;

                //SendExistRequest(Url,frm.Sku, "Disassembly Item");
                return true;


            } else {
                return false;
            }

        }


       function UpdateAssembleqty() {
            var NumLine = document.getElementById("NumLine").value;

            //alert(NumLine);
            var totval = parseInt(0);
						var cost = parseInt(0);
            for (var i = 1; i <= NumLine; i++) {
                if (document.getElementById("disassembly_qty").value != '') {

										cost  = document.getElementById("disassembly_qty" ).value * document.getElementById("total_dis_cost").value;

                     document.getElementById("price" ).value =(cost.toFixed(2))

                    //document.getElementById("qty" + i).value = document.getElementById("qty" + i).value*document.getElementById("disassembly_qty").value;
										document.getElementById("qty" + i).value = document.getElementById("disassembly_qty").value;
                    document.getElementById("amount" + i).value = document.getElementById("qty" + i).value * document.getElementById("price" + i).value;

                    var TotValue = document.getElementById("amount" + i).value;

                    totval = parseInt(totval) + parseInt(TotValue);
                } else {
                    document.getElementById("qty" + i).value = document.getElementById("disassembly_qty").value;

                }

            }

            document.getElementById("TotalValue").value = parseInt(totval);



        }

 /*function UpdateAssembleqty() {
            

            //alert(NumLine);
            var totval = parseInt(0);
           
                if (document.getElementById("disassembly_qty").value != '') {
                    
                    totval  = document.getElementById("disassembly_qty" ).value * document.getElementById("total_dis_cost").value;

                     document.getElementById("price" ).value =(totval.toFixed(2))

                    
                } 

            }*/



        /*    function UpdateAssembleqty() {
         NumLine = document.getElementById("NumLine").value;
         //alert(NumLine);
         var totval = parseInt(0);
         for (var i = 1; i <= NumLine; i++) {
         if (document.getElementById("assembly_qty").value != '') {
         document.getElementById("qty" + i).value = document.getElementById("bomqty" + i).value * document.getElementById("assembly_qty").value;
         document.getElementById("amount" + i).value = document.getElementById("qty" + i).value * document.getElementById("price" + i).value;
         
         var TotValue = document.getElementById("amount" + i).value;
         
         totval = parseInt(totval) + parseInt(TotValue);
         } else {
         document.getElementById("qty" + i).value = document.getElementById("bomqty" + i).value;
         
         }
         
         }
         
         document.getElementById("TotalValue").value = parseInt(totval);
         
         
         
         }*/

        $(document).ready(function() {

            $('#addItemdis').on('click', function() {

                var qty = $('#disassembly_qty').val();
                var Availqty = $('#on_hand_qty').val();
                var serial_Num = $('#serial_Num').val();
                var serial_sku = $('#Sku').val();
                var warehouse = $('#warehouse').val();
                 var Condition = $('#bomCondition').val();

                if (qty != '' && warehouse != '' && serial_sku != '' && parseInt(qty) <= parseInt(Availqty)) {
//alert('23423423bh');
                    var linkhref = $('#addItemdis').attr("href") + '&total=' + qty + '&sku=' + serial_sku + '&cond='+Condition+'&warehouse=' + warehouse+'&serial_value_sel='+serial_Num;
                    $('#addItemdis').attr("href", linkhref);
                } else {
//alert('23423423ch');
                    if (qty == '') {
                        alert("Please Enter disassembly Qty.")
                        $('#disassembly_qty').focus();
                        return false;
                    }



                    if (warehouse == '') {
                        alert("Please Select Warehouse Location.")
                        $('#warehouse').focus();
                        return false;
                    }
                    
                    if (parseInt(qty) > parseInt(Availqty)) {
                        alert("Dis-assembly quantity should be less then or equal to available quantity.");
                        //$('#disassembly_qty').focus();
                        return false;
                    }
                }

            });

            $('#disassembly_qty').on('blur', function() {

                //alert("aaaaaa");
                var qty = $('#disassembly_qty').val();
                var Availqty = $('#on_hand_qty').val();

                if (parseInt(qty) > parseInt(Availqty)) {
                    alert("Dis-assembly quantity should be less then or equal to available quantity.");
                    $('#disassembly_qty').focus();
                    return false;
                }


            });
        });


function SearchBill(Key){
  
var DataExist =0;
 var DsmID = document.getElementById("DsmID").value;
//alert(bomID);
if(document.getElementById("Sku").value==''){
return false;
}
//DataExist = CheckAvailField('MsgSpan_Display','Sku',DsmID);
//alert(DataExist);
//DataExist = CheckExistingData("isRecordExists.php","&bom_Sku="+escape(Key)+"&editID="+bomID, "Sku","Bill Number");
  


  var SendUrl = "&action=BillNumberCode&key="+escape(Key)+"&r="+Math.random();
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {


             if(responseText == null){
                 //alert('Item Sku [ '+document.getElementById("bom_Sku").value+' ] is not exists.');
                document.getElementById('MsgSpan_Display').innerHTML="<span class=redmsg>Bom! is not exists.</span>";
                   document.getElementById("Sku").value='';
                   document.getElementById("bomCondition").value='';
                   document.getElementById("item_id").value='';
                   document.getElementById("description").value='';
                   document.getElementById("on_hand_qty").value='';
                   document.getElementById("price").value='';
                   
                  }else{

if(responseText["bill_option"] == 'No'){

		location.href="editDassemble.php?bc="+responseText["bomID"];
	}else{
	
		$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'OptionList.php?edit='+responseText["bomID"]+'&link=editDassemble.php',
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
		//location.href ="OptionList.php?edit="+bomCode;

	}
		          /* document.getElementById("Sku").value=responseText["Sku"];
		           document.getElementById("bomCondition").value=responseText["Condition"];
		           document.getElementById("item_id").value=responseText["ItemID"];
		           document.getElementById("description").value=responseText["description"];
		            document.getElementById("on_hand_qty").value=responseText["on_hand_qty"];
		            document.getElementById("price").value=responseText["sell_price"];
                                  document.getElementById("disassembly_qty").focus();*/

		           
               }
           


            }
        });
        /******************/
  

}


function getItemCondionQtyMain(Sku,Condi){
	
	
	
	if(Sku!='')
	{			
	    ShowHideLoader('1', 'P');    
	    SendUrl = 'action=getItemCondionQty&Sku='+Sku+'&Condi='+Condi;
	    $.ajax({
		    type: "GET",
		    url: "../sales/ajax.php",
		    data: SendUrl,
		    dataType : "JSON",
		    success: function(responseText){                                               
				document.getElementById("on_hand_qty").value =responseText["condition_qty"];  
				if(responseText["AvgCost"]>0){
				    $('#total_dis_cost').val(responseText["AvgCost"]);  
						$('#price').val(responseText["AvgCost"]);            
				}else{
				    $('#price').val('0.00');
				}
	
			ShowHideLoader('2', 'P');    
		                                
		}
  }); 
 }	
}

    </script>




<div class="message"><? if (!empty($_SESSION['mess_dsm'])) {
                echo $_SESSION['mess_dsm'];
                unset($_SESSION['mess_dsm']);
            } ?>
            </div>



    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head">
                                Disassembly Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 





                                    <tr>
                                        <td width="31%" align="right"   class="blackbold" > Bill Number:  <span class="red">*</span> </td>
                                        <td width="69%" height="30" align="left">
                                            <input  name="Sku" id="Sku" value="<?= $arryAssemble[0]['Sku'] ?>" onBlur="Javascript:return SearchBill(this.value);  " onclick="Javascript:SetBomComplete(this);"  type="text" class="textbox" size="10"  maxlength="50" />
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['item_id'] ?>" type="hidden"  class="inputbox"  maxlength="30" />


                                            <?
                                            if (empty($_GET['edit'])) {
                                                 echo ' <a  class="js-open-modal" href="#" data-modal-id="popup1" >' . $search . '</a>';
                                            }
                                            ?>
</br><span id="MsgSpan_Display"></span>
                                    <!--<a class="fancybox fancybox.iframe" href="finishItemList.php?id=1" ><?= $search ?></a>--></td>

                   
                                    </tr>
 <tr>
                                        <td width="31%" align="right"   class="blackbold" > Item Condition:  <span class="red">*</span> </td>
                                        <td width="69%" height="30" align="left">


                                           <select name="bomCondition" id="bomCondition" class="inputbox" onchange="getItemCondionQtyMain('<?=stripslashes($arryAssemble[0]['Sku'])?>',this.value)">
<option value="">Select Condition</option>
<?=$ConditionDrop?>
</select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="31%" align="right"   class="blackbold" > Description:   </td>
                                        <td width="69%" height="30" align="left">


                                            <input  name="description" id="description" value="<?= $arryAssemble[0]['description'] ?>" type="text"  size="50"  class="inputbox" style="width:350px;"  maxlength="200" />

                                        </td>
                                    </tr>


                                    <tr>
                                        <td width="31%" align="right"   class="blackbold" > Available Quantity:   </td>
                                        <td width="69%" height="30" align="left">
                                            <input  name="on_hand_qty" id="on_hand_qty"  value="<? if(isset($arrayItem[0]['qty_on_hand'])) echo $arrayItem[0]['qty_on_hand']; ?>" type="text" readonly  class="disabled" size="10"  maxlength="30" />

                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="31%" align="right"   class="blackbold" > Disassembly Cost:   </td>
                                        <td width="69%" height="30" align="left">
                         <input  name="total_dis_cost" id="total_dis_cost"  value="<?=$arryAssemble[0]['total_dis_cost']?>" type="text" readonly  class="disabled" size="10"  maxlength="30" />



                                        </td>
                                    </tr>
<?
if(!isset($arrayItem[0]['qty_on_hand'])) $arrayItem[0]['qty_on_hand']='';
if(!isset($arryAssemble[0]['disassembly_qty'])) $arryAssemble[0]['disassembly_qty']='';
if(!isset($arryAssemble[0]['WarehouseCode'])) $arryAssemble[0]['WarehouseCode']='';



?>

 
 <!--tr>
                                        <td width="31%" align="right"   class="blackbold" >Cost:   </td>
                                        <td width="69%" height="30" align="left">
                                            <input  name="kit_cost" id="kit_cost"  value="<?= ($UnitCost*$arrayItem[0]['qty_on_hand']) ?>" type="text" readonly  class="disabled" size="10"  maxlength="30" />



                                        </td>
                                    </tr-->
                                    <tr>
                                        <td width="31%" align="right"   class="blackbold" > Warehouse Location:  <span class="red">*</span> </td>
                                        <td width="69%" height="30" align="left">
                                        <!--<input  name="warehouse" id="warehouse" value="" readonly="readonly" type="text" class="disabled"  maxlength="30" />-->	
                                        <!--<input  name="WID" id="WID" value="" type="hidden"  class="inputbox"  maxlength="30" />	-->
                                            <select name="warehouse" id="warehouse" class="inputbox">
                                                <option value="">Select Location</option>
                                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                                    <option value="<?= $arryWarehouse[$i]['WID'] ?>" <?
                                                    if ($arryWarehouse[$i]['WID'] == $arryAssemble[0]['WarehouseCode']) {
                                                        echo "selected";
                                                    }
                                                    ?>>
                                                                <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                                    </option>
                                                <? }
                                                ?>                                                     
                                            </select>

                    <!--<a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?= $search ?></a>--></td>
                                    </tr>

<?
if(!isset($arrayItem[0]['evaluationType'])) $arrayItem[0]['evaluationType']='';
if(!isset($arryAssemble[0]['serial_Num'])) $arryAssemble[0]['serial_Num']='';


?>
                                    <tr>
                                        <td width="31%" align="right"   class="blackbold" > Disassembly Quantity:  <span class="red">*</span> </td>
                                        <td width="69%" height="30" align="left">
                                            <input  name="disassembly_qty" id="disassembly_qty" onchange=" UpdateAssembleqty();" value="<?= $arryAssemble[0]['disassembly_qty'] ?>" type="text"   class="textbox" size="10"  maxlength="30" />
                                            <input  name="Serialized" id="Serialized"  value="<?= $arrayItem[0]['evaluationType'] ?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
                                            <? if ((($arrayItem[0]['evaluationType'] == 'Serialized' || $arrayItem[0]['evaluationType'] == 'Serialized Average') && $_GET['edit'] == '') || $arryAssemble[0]['serial_Num'] !='') { ?>
                                                <a  class="fancybox slnoclass2 fancybox.iframe" href="SelectSerialNumber.php?id=<?= $_GET['bc'] ?>" id="addItemdis"><img src="../images/tab-new.png"  title="Serial number">  Add S.N</a>
                                                 <input  name="serial_Num" id="serial_Num"  value="<?=$arryAssemble[0]['serial_Num']?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
<input  name="serial_value" id="serial_value"  value="<?=$arryAssemble[0]['serial_Num']?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
                                                <input  name="serial_qty" id="serial_qty"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" />
                                            <? } ?>

                                        </td>
                                    </tr>
                                   

<tr >
                                        <td width="31%" align="right"   class="blackbold" > Total Disassembly Cost:   </td>
                                        <td width="69%" height="30" align="left">
                                            <input  name="price" id="price" value="<?=$arryAssemble[0]['unit_cost']?>" type="text" readonly="readonly" size="10"  class="disabled"  maxlength="15" />

                                        </td>
                                    </tr>


                                    <tr>
                                        <td  align="right"   class="blackbold" >Status  : </td>
                                        <td   align="left" >
                                            <select name="Status" id="Status" class="inputbox">
                                                <option value="">Select Status</option>
                                                <option value="2" <?
                                                if ($arryAssemble[0]['Status'] == 2) {
                                                    echo "selected";
                                                }
                                                ?>>Completed</option>
                                                <option value="0" <?
                                                if ($arryAssemble[0]['Status'] == 0) {
                                                    echo "selected";
                                                }
                                                ?>> Parked</option>
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
                        <? if (!empty($arryAssemble[0]['bomID']) || !empty($_GET['edit'])) { ?>
                            <tr>
                                <td colspan="2" align="left" class="head" >Kit Item</td>
                            </tr>
                        <? } ?>
                        <? if (!empty($arryAssemble[0]['bomID']) || !empty($_GET['edit'])) { ?>
                            <tr>
                                <td align="left" colspan="2">


                                    <?
                                    require_once("includes/html/box/disassemble_item_form.php");



//include("includes/html/box/assemble_item_edit.php");
                                    ?>
                                    <? //include("includes/html/box/assemble_item_edit.php");  ?>
                                </td>
                            </tr>
                        <? } ?>

                    </table>	


                </td>
            </tr>
            <?
            if ($_GET['edit'] > 0) {
                if ($arryAssemble[0]['Status'] == 2 || $arryAssemble[0]['Status'] == 1) {
                    $disNone = "style='display:none;'";
                } $ButtonTitle = 'Update ';
            } else {
                $ButtonTitle = ' Submit ';
            }
            ?>
            <tr <?= $disNone ?>>
                <td  align="center">






                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />


                    <input type="hidden" name="DsmID" id="DsmID" value="<?= $_GET['edit'] ?>" />
                    <input type="hidden" name="bomID" id="bomID" value="<?= $arryAssemble[0]['bomID'] ?>" />

                    <input type="hidden" name="ModuleIDValue" id="ModuleIDValue" value="<? if(isset($arryAssemble[0]['DsmCode'])) echo $arryAssemble[0]['DsmCode']; ?>  " />


                    <input type="hidden" name="PrefixPO" id="PrefixPO" value="<?= $PrefixPO ?>" />



                </td>
            </tr>

        </table>

    </form>


<? } ?>


<? echo '<script>SetInnerWidth();</script>'; ?>
    <script>
 $(document).ready(function() {


        $(".slnoclass2").fancybox({
            'width': 300
        });

  $("#addItemdis").fancybox({
            'width': 700
        });

    });
function SetBomComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonBomSku.php",
		minLength: 1
	});

}

</script><? include("includes/html/box/bomPopUpForDis.php");?>
