 <?php $arryQty=$objItem->getCondionQtyBySku($arryProduct[0]['Sku'],''); 


$availableQty = $RecievedQty+$on_sale_order;

?>

<tr>
	<td colspan="2" align="left" class="head">Item Quantity </td>
	</tr>
<?php if($_SESSION['SelectOneItem'] == 0){ ?>
<tr>
	<td align="right"  class="blackbold">Condition :</td>
	<td align="left"  class="blacknormal">
<select name="Condition" id="Condition" class="textbox"  <?php if($_GET['edit']>0){ ?>onchange="getConditionQty(this.value)" <?php }?> style="width:110px;"><option value="" <?=$selectCond?>>Select</option><?=$ConditionSelectedDrop?></select>
</td>
	</tr>
<? }?>
	<tr>
	<td align="right" width="45%"  class="blackbold">On Hand  :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_on_hand" id="qty_on_hand" readonly value="<? echo $availableQty; ?>" type="text" onkeypress="return isNumberKey(event);"  class="disabled"  size="13" maxlength="10" /> </td>
	</tr>

	<tr>
	<td align="right"  class="blackbold">On Purchase Order  :</td>
	<td align="left"  class="blacknormal">
	<input  name="on_purchase_qty" id="on_purchase_qty" readonly value="<? echo $OrderQty; ?>" onkeypress="return isNumberKey(event);" type="text"  class="disabled"  size="13" maxlength="10" /> </td>

	</tr>

	<tr>
	<td align="right"  class="blackbold">On Sales Order  :</td>
	<td align="left"  class="blacknormal">
	<input  name="on_sales_qty" id="on_sales_qty" readonly value="<? echo $on_sale_order; ?>" onkeypress="return isNumberKey(event);" type="text"  class="disabled"  size="13" maxlength="10" /> </td>
	</tr>

	<tr style="display:none;">
	<td align="right"  class="blackbold">Allocated :</td>
	<td align="left"  class="blacknormal">
	<input  name="allocated_qty" id="allocated_qty" value="<? echo $AllocatedQty; ?>" onkeypress="return isNumberKey(event);" readonly type="text" class="disabled"  size="13" maxlength="10" /> </td>

	</tr>
	<tr style="display:none;">
	<td align="right"  class="blackbold">On Demand :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_on_demand" id="qty_on_demand" value="<? echo $arryProduct[0]['qty_on_demand']; ?>" onkeypress="return isNumberKey(event);" type="text"  class="textbox"  size="13" maxlength="10" /> </td>

	</tr>
	<tr style="display:none;">
	<td align="right"  class="blackbold">Max level :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_max_level" id="qty_max_level" value="<? if(isset($arryProduct[0]['qty_max_level']))echo $arryProduct[0]['qty_max_level']; ?>" onkeypress="return isNumberKey(event);" type="text"  class="textbox"  size="13" maxlength="10" /> </td>

	</tr>
	<tr>
	<td align="right"  class="blackbold">Available :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_available" id="qty_available" value="<? echo $availableQty-$on_sale_order; ?>" onkeypress="return isNumberKey(event);" type="text" readonly  class="disabled"  size="13" maxlength="10" /> </td>

	</tr>
