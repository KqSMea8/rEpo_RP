


 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    
    <tr align="left"  >
		<td class="heading" >&nbsp;&nbsp;&nbsp;SKU</td>
		<td width="19%" class="heading" >Description</td>
		<!--<td width="10%" class="heading" >Qty on Hand</td>-->
		<td width="12%" class="heading" >Qty</td>
                <!--td width="12%" class="heading" >Wastage Qty</td-->
		<td width="14%"  class="heading" >Unit Cost</td>
                <td width="14%" align="right"  class="heading" >Total Cost</td>
		
		
    </tr>


	<?php $TotalQty=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		//$total_received = $objPurchase->GetQtyReceived($arryBOMItem[$Count]["id"]);
		$ordered_qty = $arryBOMItem[$Count]["bom_qty"];
	?>
     <tr class="itembg">
        <td><?=stripslashes($arryBOMItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arryBOMItem[$Count]["description"])?></td>
         <td><?=$ordered_qty?></td>
       <!--td><?=number_format($arryBOMItem[$Count]["wastageQty"])?></td-->
       <td><?=number_format($arryBOMItem[$Count]["unit_cost"],2)?></td>   
       <td align="right"><?=number_format($arryBOMItem[$Count]["total_bom_cost"],2)?></td>
       
    </tr>
	<? 
		$TotalorderQty += $ordered_qty;
                $TotalValue += $arryBOMItem[$Count]["total_bom_cost"];
		//$TotalQtyReceived += $total_received;
		//$TotalQtyLeft += ($ordered_qty - $total_received);

	} ?>


     <tr class="itembg">
        <td colspan="9" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		#echo $TotalQtyReceived.'-'.$TotalQtyLeft;
		/*if($TotalQtyLeft<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
		}*/


		$TotalorderQty = number_format($TotalorderQty,2);
                $TotalValue = number_format($TotalValue,2);
		 #$TotalValue += $arryBOMItem[$Count]["amount"];
		//$TotalValue = number_format($arryAdjustment[0]['total_adjust_value'],2);
		?>
		<br>
		 
		
		
		Total Value : <?=$TotalValue?>
		<br><br>
        </td>
    </tr>
</table>

<? //echo '<script>SetInnerWidth();</script>'; ?>
