<?php 
 $wBinOption = "<option value='0'>Default</option>";
 for($i=0;$i<sizeof($arryBin);$i++) {
	$wBinOption .= "<option value='".$arryBin[$i]['binid']."'>
	 ".$arryBin[$i]['binlocation_name']."</option>";
 } 

?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />





 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading" >SKU</td>
		<td width="20%" class="heading">Description</td>
		<td width="10%" class="heading">Qty Ordered</td>
		<td width="15%" class="heading">Invoice Qty</td>
		<td width="15%" class="heading"> Pick Form Bin</td>
		<td width="15%" class="heading">Pick Qty </td>
		<td width="10%"  class="heading">Unit Price</td>
		<td width="10%"  class="heading">Discount</td>
		<td width="12%" class="heading">Tax Rate</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>


	<? $subtotal=0;
	
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		if($arrySaleItem[$Count]["qty_received"] == $arrySaleItem[$Count]["qty"])
		{
		  $dd = "disabled";
		  $rd = "readonly";
		  }else{
			$dd = "textbox";
			$rd = "";
		  }
		  
		  $remainQty = $arrySaleItem[$Count]["qty"]-$arrySaleItem[$Count]["qty_received"];
		  
	?>
     <tr class='itembg'>
		<td>
		 <input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arrySaleItem[$Count]["sku"])?>"/>
		 <input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="remainQty<?=$Line?>" id="remainQty<?=$Line?>" value="<?=$remainQty?>" readonly maxlength="20"  />
		</td>
        <td><?=stripslashes($arrySaleItem[$Count]["description"])?>
		<input type="hidden" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/>
		</td>
        
        <td><input type="text" value="<?=$arrySaleItem[$Count]["qty_received"]?>" size="5" readonly="" class="disabled" id="received_qty<?=$Line?>" name="received_qty<?=$Line?>"></td>
		<td><input type="text" value="<?=$arrySaleItem[$Count]["qty"]?>" size="5" readonly="" class="disabled" id="ordered_qty<?=$Line?>" name="ordered_qty<?=$Line?>"></td>
		<td> <select name="bin<?=$Line?>" id="bin<?=$Line?>" class="disabled" style="width:120px;" >
			<?=$wBinOption?>		
		</select></td>
		<td><input type="text" value="" name="pickQty<?=$Line?>" id="pickQty<?=$Line?>" onkeypress="return isNumberKey(event);" maxlength="6" size="5"  class="textbox"></td>
        <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" readonly="" class="disabled" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/></td>
		<td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" readonly="" class="disabled" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>"/></td>
       <td>
		<input type="text" name="tax<?=$Line?>" id="tax<?=$Line?>" readonly="" class="disabled" value="<?=$arrySaleItem[$Count]['tax'];?>">
		<input type="hidden" name="tax_id<?=$Line?>" id="tax_id<?=$Line?>" readonly="" class="disabled"  value="<?=$arrySaleItem[$Count]['tax_id'];?>">
	   </td>
       <td align="right">
	   
	   <input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arrySaleItem[$Count]["amount"])?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="10" align="right">

		 <!--<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>-->
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		//$subtotal = number_format($subtotal,2);
		$Freight = $arrySale[0]['Freight']; // number_format($arrySale[0]['Freight'],2);
		$TotalAmount = $arrySale[0]['TotalAmount']; //number_format($arrySale[0]['TotalAmount'],2);
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="" size="15" style="text-align:right;"/>
		<br><br>
		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="15" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
