

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	//var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;
                
                setInterval(function() {
                    var number = 1 + Math.floor(Math.random() * 6);
                        $('#num_gen').value(number);
                     }, 10);
                
                //alert(counter);

		var newRow = $("<tr class='itembg'>");
		var cols = "";

		//cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
		
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="disabled" readonly size="10" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="AssemblyItemList.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /></td><td><input type="text" name="Condition' + counter + '" id="Condition' + counter + '" class="disabled" readonly style="width:100px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly style="width:200px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="valuationType' + counter + '" id="valuationType' + counter + '" class="disabled" readonly  size="5"/></td><td><input type="text" name="on_hand' + counter + '" id="on_hand' + counter + '" class="disabled" readonly  size="5"/></td><td><input type="text" name="qty' + counter + '" id="qty' + counter + '" class="textbox"  size="5"/><br><span id="seril'+counter+'"></span><input  name="serial_number' + counter + '" id="serial_number' + counter + '"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" /><input  name="Comp_Serialized' + counter + '" id="Comp_Serialized' + counter + '"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);"/></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="WastageQty"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});
        
      

	

     $("table.order-list").on("blur", 'input[name^="qty"]', function (event) {

		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});
	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		calculateGrandTotal();

	});
        
        $("table.order-list").on("click", "#addItem", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var qty = row.find('input[name^="qty"]').val(); 
                var Wastageqty = row.find('input[name^="Wastageqty"]').val(); 
                var serial_sku = row.find('input[name^="sku"]').val(); 
		if(qty>0){
                        var linkhref = $(this).attr("href")+'&total='+qty+'&Wastageqty='+Wastageqty+'&sku='+serial_sku;
                       	$(this).attr("href", linkhref);
		}
		/*****************************/

	});
        

	});

	function calculateRow(row) {
          
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		
                var totalQ = qty;
		var SubTotal = price*totalQ;
//alert(totalQ);
		

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {
		var subtotal=0, TotalValue=0;
                var TotalQty=0;
		//var Currency = $("#Currency").val();
		
		$("table.order-list").find('input[name^="amount"]').each(function () {
			subtotal += +$(this).val();
		});
                $("table.order-list").find('input[name^="qty"]').each(function () {
			TotalQty += +$(this).val();
		});
                $("#TotalQty").val(TotalQty.toFixed(2));
		$("#TotalValue").val(subtotal.toFixed(2));

		subtotal += +$("#Freight").val();
		
		//$("#TotalAmount").val(subtotal.toFixed(2));
	}



</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td width="19%" class="heading" >&nbsp;&nbsp;&nbsp;SKU</td>
		<td   width="15%" class="heading" >Description</td>
<td   width="15%" class="heading" >Condition</td>
		<td width="12%" class="heading" >Valuation Type</td>
                <td width="10%" class="heading" > Qty On Hand</td>
		<td width="12%" class="heading" >Qty</td>
                <!--td width="12%" class="heading" >Wastage Qty</td-->
		<td width="10%"  class="heading" >Unit Cost</td>
                <td width="10%"  class="heading" align="right" >Total Cost</td>	
    </tr>
</thead>
<tbody>
	<? $TotalQty=0;
//echo $NumLine;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
$arryItem=$objItem->GetItems($arryBomItem[$Count]['item_id'],'','','');

#echo "<pre>";
#print_r($arryItem);
if($loadAssemble ==1){ $orderQty = $arryBomItem[$Count]['bom_qty']; } else{ $orderQty = $arryBomItem[$Count]['qty']; }

//$arryOptionCat=$objBom->GetOptionBill($arryBowidth="15%"mItem[$Count]["option_code"],$BomID);
	#echo $arryItem[0]['Sku']."==>";	
	?>
     <tr class="itembg">
<td><?=($Line>=1)?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")?>
<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arryItem[0]['Sku'])?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="AssemblyItemList.php?id=<?=$Line?>&kit=Kit" ><img src="../images/view.gif" border="0"></a>
<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryItem[0]['ItemID'])?>" readonly maxlength="20"  />
<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arryBomItem[$Count]['id'])?>" readonly maxlength="20"  />
</td>
<td><input type="text" class="disabled" readonly name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:100px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryItem[0]['Condition'])?>"/></td>
<td><input type="text" class="disabled" readonly name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:200px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryItem[0]['description'])?>"/></td>

<td><input type="text" name="valuationType<?=$Line?>"  readonly id="valuationType<?=$Line?>" class="disabled" size="5" maxlength="10" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryItem[0]['evaluationType'])?>"/>
</td>

<td><input type="text" name="on_hand<?=$Line?>" class="disabled" readonly id="on_hand<?=$Line?>"  value="<?=stripslashes($arryItem[0]['qty_on_hand'])?>"  size="5"/></td>

<td><input type="text" class="textbox" onkeypress="return isNumberKey(event);"   name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox"  size="5"  value="<?=$orderQty?>"/><input type="hidden" class="disabled" readonly name="bomqty<?=$Line?>" id="bomqty<?=$Line?>" class="textbox"  size="5"  value="$orderQty"/>
<? if($arryItem[0]['evaluationType']=='Serialized' ){?>
<br>

<a  class="fancybox fancybox.iframe" href="SerialList.php?Sku=<?=$arryItem[0]['Sku']?>&item_ID=<?=$arryItem[0]['ItemID']?>&pop=1&Line=<?=$Line?>&selectIDs=<?=$arryBomItem[$Count]['serial']?>" id="serial<?=$Line?>"> <img src="../images/tab-new.png"  title="Serial number">  Select S.No.</a>


<input  name="serial_number<?=$Line?>" id="serial_number<?=$Line?>"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" />
<? }?>
<input  name="Comp_Serialized<?=$Line?>" id="Comp_Serialized<?=$Line?>"  value="<?=$arryItem[0]['evaluationType']?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
</td>

<td style="display:none;"><input type="text" class="disabled" readonly name="WastageQty<?=$Line?>" id="WastageQty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryBomItem[$Count]["wastageQty"])?>"/><span id="serialqty1"></span><span style="display:none;"  id="serial<?=$Line?>"><a  class="fancybox fancybox.iframe" href="editSerial.php?id=<?=$Line?>" id="addItem"><img src="../images/tab-new.png"  title="Serial number"></a></span></td>

<td><input type="text" class="disabled" readonly name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryBomItem[$Count]["unit_cost"])?>"/></td>
<td align="right"><input type="text" class="disabled" readonly align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arryBomItem[$Count]["total_bom_cost"])?>"/></td>
       
       
    </tr>
	<? 
		//$TotalQty += $arryBomItem[$Count]["bom_qty"];
                $Total_bom_cost += $arryBomItem[$Count]["total_bom_cost"];
	} ?>
</tbody>
<tfoot>

    <tr class="itembg">
        <td colspan="8" align="right">

	  <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$TotalQty =$TotalQty;
		
		$TotalValue = $Total_bom_cost;
		?>
		
		
		Total Cost : <input type="text" align="right" name="TotalValue" id="TotalValue" class="disabled" readonly value="<?=$Total_bom_cost?>" size="15" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>

<? //echo '<script>SetInnerWidth();</script>'; ?>
<script type="text/javascript">
	$(document).ready(function() {
                $("#addItemBackup").click(function() {                   
                    var TotQty = $("#qty1").val();                   
                    $(this).attr("href", "editSerial.php?id=1&total="+TotQty);
                    $('.fancybox').fancybox();
                })
		
	});
</script>
<? echo '<script>SetInnerWidth();</script>'; ?>
