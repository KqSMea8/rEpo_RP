
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




            var asmID = Trim(document.getElementById("editID")).value;

            //document.getElementById("sku"+i) 

            if (ValidateForSelect(frm.SKU, "Sku")
		    && ValidateForSelect(frm.DES, "description")
                    && ValidateForSelect(frm.ParentCondition, "Condition")
                    //&& ValidateForSimpleBlank(frm.assembly_qty, "Assembly quantity")
                    // && ValidateForSimpleBlank(frm.serial_qty, "Serial Number")

                    ) {

             //alert(document.getElementById("serialized").value);
//if(responseText["ParentValuationType"]=='Serialized' || responseText["evaluationType"]=='Serialized Average'){   
              if (document.getElementById("ParentValuationType").value == "Serialized" || document.getElementById("ParentValuationType").value == "Serialized Average")
                {
                    
                    
                    if (document.getElementById("serial_Num").value == "")
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                        alert(" Please add  serial number.");
                        //document.getElementById("assembly_qty").focus();
                        return false;
                    }

                }


 
                var avilQty = 0;
                var inQty = 0;
                var totalSum = 0;
                for (var i = 1; i <= NumLine; i++) {
         
                    avilQty = document.getElementById("on_hand" + i).value;

                    //var SerialQty = document.getElementById("serial_number" + i).value;
                    inQty = document.getElementById("qty" + i).value;

                    totalSum += parseInt(inQty);
                    if (parseInt(inQty) > parseInt(avilQty))
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                        alert(" Qauntity must  be less than qty on hand for this item.");
                        document.getElementById("qty" + i).focus();
                        return false;
                    }
                    
                    
                    
              if (document.getElementById("Comp_Serialized"+i).value == "Serialized")
                {
                    
                    
                    if (document.getElementById("serial_number" + i).value == "")
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                         alert(" Please select component serial number.");
                        document.getElementById("serial_number" + i).focus();
                        return false;
                    }

                }
                    
                   /* if (SerialQty == '')
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                        alert(" Please select component serial number.");
                        document.getElementById("serial_number" + i).focus();
                        return false;
                    }*/

                }
                //alert(totalSum);return false;
                totalSum = parseInt(totalSum, 10);
                if (totalSum == 0)
                {
                    alert("Sub Item qty should not be blank.");
                    document.getElementById("qty1").focus();
                    return false;
                } else {
                    ShowHideLoader('1', 'S');
                    false
                    return true;
                }

                var Url = "isRecordExists.php?checkMergeItem=" + escape(document.getElementById("Sku").value) + "&editID=" + document.getElementById("editID").value;

                //SendExistRequest(Url,frm.Sku, "Assembly Item");
                return true;


            } else {
                return false;
            }

        }


        function UpdateMergeItemqty() {
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
        }

        $(document).ready(function() {
            $('#addItem').on('click', function() {
                var qty = 1;
                 var Availqty = $('#HAND_QTY').val();
                var item_ID = $('#ITEM_ID').val();
                var serial_sku = $('#SKU').val();
                //var warehouse = $('#warehouse').val();
									var cond = $('#ParentCondition').val();

                 if (qty != ''  && serial_sku != '' ) {

                    var linkhref = $('#addItem').attr("href") + '&total=' + qty + '&Sku=' + serial_sku + '&item_ID='+item_ID+'&Condition='+cond;
                    $(this).attr("href", linkhref);
                } else {
                    
                    if (cond == '') {
                        alert("Please Select Condition.")
                        $('#ParentCondition').focus();
                        return false;
                    }

                   
                }

            });
        });

/*function BinListSend(){


		var OtherOption = '';
		if(document.getElementById("OtherBin") != null){
			OtherOption = '&other=1';
		}
		var SelectOption = '';
		if(document.getElementById("SelectOption") != null){
			SelectOption = '&select=1';
		}
		
		//document.getElementById("MainBinTitleDiv").style.display = 'inline';

		document.getElementById("bin_td").innerHTML = '<select name="bin_id" class="inputbox" id="bin_id" ><option value="">Loading...</option></select>';
		
		if(document.getElementById("bin_id") != null){
			
			
			var SendUrl = 'ajax.php?action=bin&warehouse_id='+document.getElementById("warehouse").value+'&Sku='+document.getElementById("Sku").value+'&current_bin='+document.getElementById("main_bin_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1';
			

			httpObj.open("GET", SendUrl, true);

			httpObj.onreadystatechange = function BinListRecieve(){
 //alert(httpObj.responseText);
				if (httpObj.readyState == 4) {
					//alert(httpObj.responseText);
					document.getElementById("bin_td").innerHTML  = httpObj.responseText;
										
				}
			};
			httpObj.send(null);
			
		}

	}*/



function SetAutoComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});

}
    </script>

<script language="JavaScript1.2" type="text/javascript">

function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
	$("#msg_div").html("");
}
function ShowList(){	
	$("#prv_msg_div").hide();
	$("#frmSrch").show();
	$("#preview_div").show();
}





function SetItemCodeSelect(Sku){


	//var NumLine = document.getElementById("NumLine").value;	
	
	/******************/
	var SkuExist = 0;

	/*for(var i=1;i<=NumLine;i++){
		if(document.getElementById("sku"+i) != null){
			if(document.getElementById("sku"+i).value == Sku){
				SkuExist = 1;
				break;
			}
		}
	}*/
	/******************/
	if(SkuExist == 1){
		 $("#msg_div").html('Item Sku [ '+Sku+' ] has been already selected.');
	}else{
		ResetSearch();
		//var SelID = $("#id").val();
		var proc = $("#proc").val();
		//var SendUrl = "&action=ItemInfo&ItemID="+escape(ItemID)+"&proc="+escape(proc)+"&r="+Math.random(); 
		var SendUrl = "&action=SearchSalesCode&key="+escape(Sku)+"&r="+Math.random();

		/******************/
		$.ajax({
			type: "GET",
			url: "../sales/ajax.php",
			data: SendUrl,
			dataType : "JSON",
			success: function (responseText) {
			
			//alert(responseText["evaluationType"]);
					document.getElementById("SKU").value=responseText["Sku"];
					document.getElementById("ITEM_ID").value=responseText["ItemID"];
				
					document.getElementById("DES").value=responseText["description"];
					//document.getElementById("qty").value='1';
					document.getElementById("HAND_QTY").value=responseText["qty_on_hand"];

					if(responseText["evaluationType"]=='Serialized' || responseText["evaluationType"]=='Serialized Average'){    
										                 
									document.getElementById("add_serial").style="";
									document.getElementById("ParentValuationType").value=responseText["evaluationType"];     
								}else{
					document.getElementById("add_serial").style="display:none";
					}
					//document.getElementById("TotalValue").value=responseText["purchase_cost"];
					//document.getElementById("ParentPrice").value=responseText["purchase_cost"];
					//document.getElementById("evaluationType").value=responseText["price"]
					//document.getElementById("subitemtext").style='';
					//document.getElementById("subitem").style='';
					
					//document.getElementById("price").value=responseText["price"];

					//document.getElementById("price").focus();

					//parent.jQuery.fancybox.close();
					//ShowHideLoader('1','P');
				
			


			}
		});
		/******************/
	}

}
function getItemCondionQty(Condi){
	
	var Sku =  $('#SKU').val();
	if(Sku!='')
	{			
	    //ShowHideLoader('1', 'P');    
	    SendUrl = 'action=getItemCondionQty&Sku='+Sku+'&Condi='+Condi;
	    $.ajax({
		    type: "GET",
		    url: "../sales/ajax.php",
		    data: SendUrl,
		    dataType : "JSON",
		    success: function(responseText){                                               
				//document.getElementById("on_hand_qty").value =responseText["condition_qty"];  
//alert(responseText["AvgCost"]);
					if(responseText["AvgCost"]!='' && typeof responseText["AvgCost"] != 'undefined' ){ 
					    $('#TotalValue').val(responseText["AvgCost"]);
							$('#ParentPrice').val(responseText["AvgCost"]);
					}else{
 $('#TotalValue').val('0.00');
							$('#ParentPrice').val('0.00');

}
	  document.getElementById("subitemtext").style='';
					document.getElementById("subitem").style='';   
	 	}
});
  }
}


 $("table.order-list").on("click", "#addItem", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var qty = row.find('input[name^="qty"]').val(); 
                var serial_value_sel = row.find('input[name^="serial_number"]').val(); 
                var serial_sku = row.find('input[name^="sku"]').val(); 
		if(qty>0){
                        var linkhref = $(this).attr("href")+'&total='+qty+'&serial_value_sel='+serial_value_sel+'&sku='+serial_sku;
                       	$(this).attr("href", linkhref);
		}
		/*****************************/

	});
</script>

    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head">
                               Add Parent Item</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 

<?
if(!isset($arryMergeItem[0]['description']))  $arryMergeItem[0]['description']='';
if(!isset($arryMergeItem[0]['item_id']))  $arryMergeItem[0]['item_id']='';
if(!isset($arrayItem[0]['qty_on_hand']))  $arrayItem[0]['qty_on_hand']='';
if(!isset($arrayItem[0]['evaluationType']))  $arrayItem[0]['evaluationType']='';
if(!isset($arryMergeItem[0]['assembly_qty']))  $arryMergeItem[0]['assembly_qty']='';
if(!isset($arryMergeItem[0]['serial_name'] ))  $arryMergeItem[0]['serial_name'] ='';

?>


                                    <tr>
                                        <td  align="right"   class="blackbold" > Sku:  <span class="red">*</span> </td>
                                        <td height="30" align="left">
                                            <input  name="SKU" id="SKU" value="<?= $arryMergeItem[0]['Sku'] ?>"   type="text" class="textbox" size="10" onblur="Javascript:SetItemCodeSelect(this.value);"   maxlength="50" onclick="Javascript:SetAutoComplete(this);" onblur="Javascript:return SearchBoCode(this.value); " autocomplete="off" />
                                            <input  name="ITEM_ID" id="ITEM_ID" value="<?= $arryMergeItem[0]['item_id'] ?>" type="hidden"  class="inputbox"  maxlength="30" />
                                            <input  name="HAND_QTY" id="HAND_QTY" value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="hidden"  class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="inputbox"  maxlength="30" />

                                    <a class="fancybox fancybox.iframe" href="ItemListMerge.php?id=1" id="g-search-button" ><?= $search ?></a>
</br><span id="MsgSpan_Display"></span>
</tr>

 

<tr>
                                        <td  align="right"   class="blackbold" > Description:   </td>
                                        <td height="30" align="left">


                                            <input  name="DES" id="DES"  value="<?=$arryMergeItem[0]['description'] ?>" type="text"  size="30"   class="disabled" readonly style="width:350px;"  maxlength="150" />

                                        </td>
</tr>

<tr>  
  <td  align="right"   class="blackbold" > Item Condition:  <span class="red">*</span> </td>
                                        <td height="30" align="left">


<select name="ParentCondition" id="ParentCondition" class="inputbox" onchange="getItemCondionQty(this.value);">
<option value="">Select Condition</option>
<?=$ConditionDrop?>
</select>

                                        </td>
                                   </tr>
<tr style="display:none;">
                             
			<td  align="right"   class="blackbold" > Available Quantity:   </td>
			<td height="30" align="left">
			    <input  name="on_hand_qty" id="on_hand_qty"  value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="text" readonly  class="disabled" size="10"  maxlength="30" />

			</td>
		</tr>
<tr id ="add_serial" style="<?=$Serialdis?>">
                             
			<td  align="right"   class="blackbold" > Serial number:   </td>
			<td height="30" align="left">
			   <a  class="fancybox slnoclass fancybox.iframe" href="ParentSerialList.php?id=<?= $Line ?>&cond=<?=$arryMergeItem[0]["ParentCondition"]?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a>
<input type="hidden" name="ParentValuationType" id="ParentValuationType" value=""  />
 <input type="text" name="serial_Num" readonly class="disabled" id="serial_Num" value="<?=$arryMergeItem[0]["serial_Num"]?>"  />
             

			</td>
		</tr>
	<tr>
		<td  align="right"   class="blackbold" > Cost:  <span class="red">*</span> </td>
		<td height="30" align="left">
			<input type="text" align="right" name="TotalValue" id="TotalValue" class="disabled" readonly value="<?=$arryMergeItem[0]["AvgCost"]?>" size="15" style="text-align:right;"/>
<input type="hidden" name="ParentPrice" id="ParentPrice" value="<?=$arryMergeItem[0]["ParentPrice"]?>"  />
		</td>
	</tr>

	<tr style="display:none;"> 
		<td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Bin Location :<span class="red">*</span></td>
		<td  align="left" id="bin_td" class="blacknormal">&nbsp;</td>
	</tr>
<tr style="display:none;">                         
<td  align="right"   class="blackbold" > Assembly Quantity:  <span class="red">*</span> </td>
<td height="30" align="left">
<input  name="assembly_qty" id="assembly_qty"  onblur="return UpdateMergeItemqty();" value="<?= $arryMergeItem[0]['assembly_qty']?>" type="text"   class="textbox" size="10"  maxlength="30" />

 <input  name="Serialized" id="Serialized"  value="<?=$arrayItem[0]['evaluationType']?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
<? if (($arrayItem[0]['evaluationType'] == 'Serialized' && $_GET['edit'] == '') || $arryMergeItem[0]['serial_name'] !='') { ?>
      <a  class="fancybox slnoclass2 fancybox.iframe" href="BillSerial.php?id=<?= $_GET['bc'] ?>" id="addItem"><img src="../images/tab-new.png"  title="Serial number">  Add S.N</a>
      <input  name="serial_Num" id="serial_Num"  value="<?=$arryMergeItem[0]['serial_Num']?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
     <input  name="serial_qty" id="serial_qty"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" />
<? } ?>




                                        </td>
                                   
                                   </tr>
<tr>
                                   
                                        <td  align="right"   class="blackbold" >Status  : </td>
                                        <td   align="left" >
                                            <select name="Status" id="Status" class="inputbox">
                                                <option value="">Select Status</option>

                                                <option value="1" <? if ($arryMergeItem[0]['Status'] == 1) {
        echo "selected";
    } ?>>Completed</option>
                                                <option value="0" <? if ($arryMergeItem[0]['Status'] == 0) {
        echo "selected";
    } ?>> Parked</option>

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
                
                            <tr id="subitemtext" style="<?=$disSubItem?>">
                                <td colspan="2" align="left" class="head" >Sub Item</td>
                            </tr>

                            <tr id="subitem" style="<?=$disSubItem?>">
                                <td align="left" colspan="2">
                            <? require_once("includes/html/box/MergeItem_item_form.php");?>
                                </td>
                            </tr>
   		

                    </table>	


                </td>
            </tr>
    <? if ($_GET['edit'] > 0) {
        if ($arryMergeItem[0]['Status'] == 2 || $arryMergeItem[0]['Status'] == 1) {
            $disNone = "style='display:none;'";
        } $ButtonTitle = 'Update ';
    } else {
        $ButtonTitle = ' Submit ';
    } ?>
            <tr <?= $disNone ?>>
                <td  align="center">
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="editID" id="editID" value="<?= $_GET['edit'] ?>" />
                    


                </td>
            </tr>

        </table>

    </form>


<? } ?>
 <script>
 $(document).ready(function() {


        $(".slnoclass2").fancybox({
            'width': 300
        });



    });

</script>
<script>
//BinListSend();

</script>
<? //include("includes/html/box/bomPopUpForDis.php");?>
