 <?php   $ConditionDrop  =$objCondition-> GetConditionDropValue();
	 #echo $ConditionDrop ;?>
<script language="JavaScript1.2" type="text/javascript">
function ResetSearch() {
    $("#prv_msg_div").show();
    $("#frmSrch").hide();
    $("#preview_div").hide();
    $("#msg_div").html("");
}

function ShowList() {
    $("#prv_msg_div").hide();
    $("#frmSrch").show();
    $("#preview_div").show();
}
    $(document).ready(function() {
        var counter = 2;
        //var TaxRateOption = $("#TaxRateOption").val();

        $("#addrow").on("click", function() {
            /*var counter = $('#myTable tr').length - 2;*/

            counter = parseInt($("#NumLine").val()) + 1;

            setInterval(function() {
                var number = 1 + Math.floor(Math.random() * 6);
                $('#num_gen').val(number);
            }, 10);

            //alert(counter);

            var newRow = $("<tr class='itembg'>");
            var cols = "";

            /*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
             cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/

            cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" onclick="Javascript:SetAutoComplete(this);"   onblur="return SearchBOMComponent(this.value,' + counter + ');" class="textbox" size="10" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="ItemFetchList.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /></td><td><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionDrop?></select></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly  style="width:200px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><select <?=$HideQty?> name="QtyType' + counter + '" id="QtyType' + counter + '" onchange="QtyTypeReturn(' + counter + ');" class="textbox"><option value="Add">+</option><option value="Subtract">-</option></select><input type="text" name="qty' + counter + '"  onclick="return checkCondition('+counter+');" id="qty' + counter + '"  class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" /><span style="display:none;" id="serial' + counter + '"><a class="fancybox slnoclass fancybox.iframe" href="editSerial.php?id=' + counter + '&SerialType=adjust" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a></span><span style="display:none;"  id="serialSub' + counter + '"><a  onclick="frameDisplay('+counter+');"   ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a></span><input type="hidden" name="valuationType' + counter + '" id="valuationType' + counter + '" value="" readonly maxlength="20"  /><input type="hidden" name="serial_value' + counter + '" id="serial_value' + counter + '" value="" readonly   /><textarea style="display:none;" name="serialdesc'+ counter +'" id="serialdesc'+ counter +'"></textarea><span id="serialqty' + counter + '"></span><input type="hidden" name="serialPrice' + counter + '" id="serialPrice' + counter + '" value="" readonly   /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);"/></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



            newRow.append(cols);
            //if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
            $("table.order-list").append(newRow);
            $("#NumLine").val(counter);
            counter++;
        });

        $("table.order-list").on("blur", 'select[name^="QtyType"],input[name^="price"],input[name^="qty"]', function(event) {
            calculateRow($(this).closest("tr"));
            calculateGrandTotal();
        });

        $("table.order-list").on("blur", 'select[name^="QtyType"],input[name^="qty"]', function(event) {
            calculateRow($(this).closest("tr"));
            
            calculateGrandTotal();
        });


        $("table.order-list").on("click", "#ibtnDel", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var id = row.find('input[name^="id"]').val();
            if (id > 0) {
                var DelItemVal = $("#DelItem").val();
                if (DelItemVal != '')
                    DelItemVal = DelItemVal + ',';
                $("#DelItem").val(DelItemVal + id);
                components
            }
            /*****************************/
            $(this).closest("tr").remove();
            calculateGrandTotal();

        });

        $("table.order-list").on("click", "#addItem", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var qty = row.find('input[name^="qty"]').val();
            var serial_sku = row.find('input[name^="sku"]').val();
            if (qty > 0) {
                var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku;
                $(this).attr("href", linkhref);
            }
            /*****************************/

        });


    });

    function calculateRow(row) {

        var price = +row.find('input[name^="price"]').val();
        var qty = +row.find('input[name^="qty"]').val();
var qtyType = row.find('select[name^="QtyType"]').val();
//var amount = +row.find('input[name^="amount"]').val();
        //var taxRate = row.find('select[name^="tax"]').val();
 var SubTotal = price * qty;

//alert(qtyType);


        row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
    }

    function calculateGrandTotal() {
        var subtotal = 0, TotalValue = 0;
        var TotalQty = 0;
				var QtyType ='';
var SubAmt = 0;
var amount =0;
        //var Currency = $("#Currency").val();

	
        $("table.order-list").find('input[name^="amount"]').each(function() {
amount = $(this).val();
            subtotal += +$(this).val();
QtyType = $(this).closest("tr").find('select[name^="QtyType"]').val();
			if(QtyType=="Subtract"){
				SubAmt += +amount;	
				subtotal += -amount;
			}

        });
        $("table.order-list").find('input[name^="qty"]').each(function() {
            TotalQty += +$(this).val();
					

        });
//alert(SubAmt);
        $("#TotalQty").val(TotalQty.toFixed(2));
$("#subtractvalue").val(SubAmt.toFixed(2));
//subtotal = (subtotal-$("#subtractvalue").val());
//alert(subtotal);
var subtotalval = subtotal-SubAmt;
        $("#TotalValue").val(subtotalval.toFixed(2));

        //subtotal += +$("#Freight").val();

        //$("#TotalAmount").val(subtotal.toFixed(2));
    }

function checkCondition(sel){

var con =document.getElementById("Condition" + sel).value;
if(con ==''){

alert("Please select item condition");
document.getElementById("Condition" + sel).focus();
}

}
/*********************************************/
function SearchBOMComponent(key, count) {
 
    var NumLine = document.getElementById("NumLine").value;
document.getElementById("QtyType"+count).value = 'Add'
document.getElementById("serial"+count).style.display="none";
							document.getElementById("serialSub"+count).style.display="none";
    /******************/
    var SkuExist = 0;
    if (document.getElementById("sku" + count).value == '') {
        return false;
    }
   
    
    /*for (var i = 1; i <= NumLine; i++) {
        if (document.getElementById("sku" + i) != null) {
            if (document.getElementById("sku" + count).value != '') {
                if (i != count) {
                    if (document.getElementById("sku" + i).value == key) {
                        SkuExist = 1;
                        break;
                    }
                }
            } else {
                return false;
            }
        }
    }*/

//alert(NumLine );

    /******************/
    if (SkuExist == 1) {

        alert('Item Sku [ ' + key + ' ] has been already selected.');
        document.getElementById("sku" + count).focus();

    } else {
        ResetSearch();
        document.getElementById("sku" + count).value = '';
        var SelID = count;
        //alert(SelID );
        var SendUrl = "&action=SearchBomCode&key=" + escape(key) + "&r=" + Math.random();
//alert(SendUrl);
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType: "JSON",
            success: function (responseText) {
                
                //alert(responseText["Condition"]);
                if (responseText["Sku"] == undefined) {
                    alert('Item Sku [ ' + key + ' ] is not exists.');
                    document.getElementById("sku" + SelID).value = '';
                    document.getElementById("sku" + SelID).value = '';
                    document.getElementById("item_id" + SelID).value = '';
                    //document.getElementById("Condition" + SelID).value = '';
                    //window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
                    document.getElementById("description" + SelID).value = '';
                    //document.getElementById("qty" + SelID).value = '';
                    document.getElementById("price" + SelID).value = '';
                    document.getElementById("sku" + SelID).focus();

                } else {
                    document.getElementById("sku" + SelID).value = responseText["Sku"];
                    document.getElementById("item_id" + SelID).value = responseText["ItemID"];
                    //document.getElementById("Condition" + SelID).value = responseText["Condition"];
                    //window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
                    document.getElementById("description" + SelID).value = responseText["description"];
                    //document.getElementById("qty" + SelID).value = '1';
                    document.getElementById("price" + SelID).value = responseText["purchase_cost"];
			if(responseText["evaluationType"]=='Serialized' || responseText["evaluationType"]=='Serialized Average'){    
                           
			   window.parent.document.getElementById("serial"+SelID).style.display="block";
                           window.parent.document.getElementById("valuationType"+SelID).value=responseText["evaluationType"];     
			}


                    document.getElementById("qty" + SelID).focus();
                }



                //parent.jQuery.fancybox.close();
                //ShowHideLoader('1','P');
                //jQuery.fancybox.close();



            }
        });
        /******************/
    }

}


function QtyTypeReturn(ln){
	var valuationType = document.getElementById("valuationType"+ln).value;
	var QtyType = document.getElementById("QtyType"+ln).value;

	if(valuationType=='Serialized' || valuationType=='Serialized Average'){    
					if(QtyType =='Subtract'){          
							document.getElementById("serial"+ln).style.display="none";
							document.getElementById("serialSub"+ln).style.display="block";
					}else{

							document.getElementById("serial"+ln).style.display="block";
							document.getElementById("serialSub"+ln).style.display="none";

					}
		                             
				}


}

function frameDisplay(ln){

 var sku = document.getElementById("sku"+ln).value;
 var cond = document.getElementById("Condition"+ln).value;
var total = document.getElementById("qty"+ln).value;
//var link ='../warehouse/addSerial.php?id='+ln+'&cond='+cond+'&sku='+sku+'';
//alert(link);
//openIframe(link)
$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'addSerialNumber.php?id='+ln+'&total='+total+'&cond='+cond+'&sku='+sku,
                                type: 'iframe',
  width:'25%', height:'70%',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });

}

function openIframe(link) {

alert(link);
 $.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:link,
                                type: 'iframe',
width:240+'px',
height:240+'px',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
}


function SetAutoComplete(elm) {
        $(elm).autocomplete({
            source: "../jsonSku.php",
            minLength: 1
        });

    }
/************************************/

function getItemCondionQty(Sku,SelID,Condi){
	
	var skuSelect = document.getElementById("sku" + SelID).value;
	
	if(skuSelect!='')
	{			
	    ShowHideLoader('1', 'P');    
	    SendUrl = 'action=getItemCondionQty&Sku='+skuSelect+'&Condi='+Condi;
	    $.ajax({
		    type: "GET",
		    url: "../sales/ajax.php",
		    data: SendUrl,
		    dataType : "JSON",
		    success: function(responseText){                                               
			document.getElementById("on_hand_qty" + SelID).value =responseText["condition_qty"];  
ShowHideLoader('2', 'P');
}
});
}
}
</script>



<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <thead>
        <tr align="left"  >
            <td class="heading" >&nbsp;&nbsp;&nbsp;SKU</td>
            <td width="15%" class="heading" >Condition</td>
            <td width="19%" class="heading" >Description</td>
            <td width="10%" class="heading" >Qty on Hand</td>
            <td width="12%" class="heading" >Adj Qty</td>
            <td width="14%"  class="heading" >Unit Price</td>
            <td width="14%" align="right" class="heading" >Total Value</td>
        </tr>
    </thead>
    <tbody>
        <?
        $TotalQty = 0;
        for ($Line = 1; $Line <= $NumLine; $Line++) {
            $Count = $Line - 1;
$ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($arryAdjustmentItem[$Count]["Condition"]);
if($arryAdjustmentItem[$Count]["QtyType"]=='Add'){ echo "selected";}

if(($arryAdjustmentItem[$Count]['valuationType'] =='Serialized' || $arryAdjustmentItem[$Count]['valuationType'] == 'Serialized Average') &&  $arryAdjustmentItem[$Count]["QtyType"]=='Add'){
$serDis = '';
$serDisSub = 'display:none;';
}else{
$serDis = 'display:none;';
}

if(($arryAdjustmentItem[$Count]['valuationType'] =='Serialized' || $arryAdjustmentItem[$Count]['valuationType'] == 'Serialized Average') &&  $arryAdjustmentItem[$Count]["QtyType"]=='Subtract'){
$serDis = 'display:none;';
$serDisSub = '';
}else{
$serDisSub = 'display:none;';
}

if($_GET['edit']>0){$edit =1;}else{$edit =0;}


            ?>
            <tr class="itembg">
                <td><?= ($Line > 1) ? ('<img src="../images/delete.png" id="ibtnDel">') : ("&nbsp;&nbsp;&nbsp;") ?>
                    <input type="text" name="sku<?= $Line ?>" id="sku<?= $Line ?>" onclick="Javascript:SetAutoComplete(this);" onblur="return SearchBOMComponent(this.value, '<?= $Line ?>');"  class="textbox" size="10" maxlength="10"  value="<?= stripslashes($arryAdjustmentItem[$Count]["sku"]) ?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="ItemFetchList.php?id=<?= $Line ?>" ><img src="../images/view.gif" border="0"></a>
                    <input type="hidden" name="item_id<?= $Line ?>" id="item_id<?= $Line ?>" value="<?= stripslashes($arryAdjustmentItem[$Count]["item_id"]) ?>" readonly maxlength="20"  />
                    <input type="hidden" name="id<?= $Line ?>" id="id<?= $Line ?>" value="<?= stripslashes($arryAdjustmentItem[$Count]["id"]) ?>" readonly maxlength="20"  />
                </td>
 <td><select name="Condition<?=$Line?>" id="Condition<?=$Line?>" onchange="getItemCondionQty('<?=stripslashes($arryAdjustmentItem[$Count]['sku'])?>','<?=$Line?>',this.value)" class="textbox" style="width:120px;display:<?=$TaxShowHide?>"><option value="">Select Condition</option><?=$ConditionSelectedDrop?></select></td>
 <!--input type="text" name="Condition<?= $Line ?>" id="Condition<?= $Line ?>" class="disabled" readonly  style="width:100px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?= stripslashes($arryAdjustmentItem[$Count]["Condition"]) ?>"/--></td>
                <td><input type="text" name="description<?= $Line ?>" id="description<?= $Line ?>" class="disabled" readonly  style="width:200px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?= stripslashes($arryAdjustmentItem[$Count]["description"]) ?>"/></td>
                <td><input type="text" name="on_hand_qty<?= $Line ?>" id="on_hand_qty<?= $Line ?>" class="disabled" readonly size="5"  value="<?= stripslashes($arryAdjustmentItem[$Count]["on_hand_qty"]) ?>"/></td>
                <td><select <?=$HideQty?> name="QtyType<?=$Line?>" onchange="QtyTypeReturn(<?=$Line?>);" id="QtyType<?=$Line?>" class="textbox"><option value="Add" <? if($arryAdjustmentItem[$Count]["QtyType"]=='Add'){ echo "selected";}?>>+</option><option value="Subtract" <? if($arryAdjustmentItem[$Count]["QtyType"]=='Subtract'){ echo "selected";}?>>-</option></select><input type="text" name="qty<?= $Line ?>" onclick="return checkCondition('<?= $Line ?>');" id="qty<?= $Line ?>" <? if($_GET['edit']>0){  echo "readonly  "; echo 'class="disabled"'; }else{  echo 'class="textbox"'; } ?> size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?= stripslashes($arryAdjustmentItem[$Count]["qty"]) ?>"/><br />
                    <span id="serialqty1"></span><span style="<?=$serDis?>"  id="serial<?= $Line ?>"><a  class="fancybox slnoclass fancybox.iframe" href="editSerial.php?id=<?= $Line ?>&SerialType=adjust&edit=<?=$edit?>"id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
                       
                    </span>
<span style="<?=$serDisSub?>"  id="serialSub<?= $Line ?>"><a  onclick="frameDisplay(<?= $Line ?>);"   ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a>
                       
                    </span>
 <input type="hidden" name="valuationType<?= $Line ?>" id="valuationType<?= $Line ?>" value="<?= stripslashes($arryAdjustmentItem[$Count]['valuationType']) ?>" readonly maxlength="20"  />
        <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?= stripslashes($arryAdjustmentItem[$Count]["serial_value"]) ?>" readonly   />           
 <input type="hidden" name="serialPrice<?= $Line ?>" id="serialPrice<?= $Line ?>" value="<?= stripslashes($arryAdjustmentItem[$Count]["serialPrice"]) ?>" readonly   />
 <input type="hidden" name="serialdesc<?= $Line ?>" id="serialdesc<?= $Line ?>" value="<?= stripslashes($arryAdjustmentItem[$Count]["serialdesc"]) ?>" readonly   />

                    <? //if($arryAdjustmentItem[$Count]['valuationType']=="Serialized"){
                        
                    // echo '<br><a  class="fancybox fancybox.iframe" href="vSerial.php?id='.$Line.'&SerialType=adjust&adjID='.$_GET['edit'].'&Sku='.$arryAdjustmentItem[$Count]["sku"].'" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;View S.N.</a>';   
                        
                    //}
                  ?>
                    
                </td>
                <td><input type="text" name="price<?= $Line ?>" id="price<?= $Line ?>" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?= stripslashes($arryAdjustmentItem[$Count]["price"]) ?>"/></td>
                <td align="right"><input type="text" align="right" name="amount<?= $Line ?>" id="amount<?= $Line ?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?= stripslashes($arryAdjustmentItem[$Count]["amount"]) ?>"/></td>
            </tr>
            <?
            $TotalQty += $arryAdjustmentItem[$Count]["qty"];
        }
        ?>
    </tbody>
    <tfoot>

        <tr class="itembg">
            <td colspan="8" align="right">
 <? if ($arryAdjustment[0]['Status'] != 2) {?>
                <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
                <input type="hidden" name="NumLine" id="NumLine" value="<?= $NumLine ?>" readonly maxlength="20"  />
                <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
<input type="hidden" name="subtractvalue" id="subtractvalue" value="" class="inputbox" readonly />
 					<input type="hidden" name="AdjustID" id="AdjustID" value="<?=$arryAdjustment[0]['adjID']?>" readonly   />


 <?}
                $TotalQty = $TotalQty;

                $TotalValue = $arryAdjustment[0]['total_adjust_value'];
                ?>
                <br>
                Total Adjust Quantity : <input type="text" align="right" name="TotalQty" id="TotalQty" class="disabled" readonly value="<?= $TotalQty ?>" size="15" style="text-align:right;"/>
                <br><br>

                Total Value : <input type="text" align="right" name="TotalValue" id="TotalValue" class="disabled" readonly value="<?= $TotalValue ?>" size="15" style="text-align:right;"/>
                <br><br>
            </td>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
$(document).ready(function() {
             
  /* $('.slnoclass').fancybox({
 
    closeBtn    : false, // hide close button
      closeClick  : false,
    width:300,
    // prevents closing when clicking INSIDE fancybox
    helpers     : { 
        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
    }
   });*/
 
});
</script>
<script>

 /*$(document).ready(function() {


        $(".slnoclass").fancybox({
            'width': 300
        });



    });*/

</script>
