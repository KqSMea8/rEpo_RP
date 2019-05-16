<table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">
	<tr align="left"  >
		<td class="head1" width="10%" >SKU</td>
		<td width="15%" class="head1" >Condition</td>
		<td width="22%" class="head1" >Description</td>
		<td width="10%" class="head1" >Adjust Qty</td>
		<!--<td width="13%" class="head1" >Total Qty Received</td>-->
		<td width="12%"  class="head1" >Value</td>
		<td width="12%" class="head1" align="right" >Total Value</td>
	</tr>

	<? $TotalQty=0;$TotalorderQty=0;$TotalorderQtySub=0;
	$TotalValueSub=$TotalValue=0;
	$total_received=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		//$total_received = $objPurchase->GetQtyReceived($arryAdjustmentItem[$Count]["id"]);
		$ordered_qty = $arryAdjustmentItem[$Count]["qty"];
	?>
     <tr class="itembg">
	<td><?=stripslashes($arryAdjustmentItem[$Count]["sku"])?></td>
	<td><?=stripslashes($arryAdjustmentItem[$Count]["Condition"])?></td>
	<td><?=stripslashes($arryAdjustmentItem[$Count]["description"])?></td>
	<td><? if($arryAdjustmentItem[$Count]["QtyType"]=='Subtract'){ echo '-';}else{ echo '+';}  ?><?=$ordered_qty?>  <? if($arryAdjustmentItem[$Count]['valuationType']=="Serialized" || $arryAdjustmentItem[$Count]['valuationType']=="Serialized Average"){
                        
                    echo '<br><a  class="fancybox fancybox.iframe" href="vSerial.php?id='.$Line.'&SerialType=adjust&adjID='.$arryAdjustmentItem[$Count]["id"].'&Sku='.$arryAdjustmentItem[$Count]["sku"].'" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;View S.N.</a>';   
                        
                    }
                 ?></td>
	<!--<td><?=number_format($total_received)?></td>-->
	<td><?=number_format($arryAdjustmentItem[$Count]["price"],2)?></td> 
	<td align="right"><?=number_format($arryAdjustmentItem[$Count]["amount"],2)?></td>

     </tr>
	<? 
if($arryAdjustmentItem[$Count]["QtyType"]=='Subtract'){ $TotalorderQtySub += $ordered_qty; $TotalValueSub += $arryAdjustmentItem[$Count]["amount"];}else{ $TotalorderQty += $ordered_qty; $TotalValue += $arryAdjustmentItem[$Count]["amount"];}
		//$TotalorderQty += $ordered_qty;
                //$TotalValue += $arryAdjustmentItem[$Count]["amount"];
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


		$TotalorderQty = $TotalorderQty-$TotalorderQtySub;
$TotalValue =$TotalValue -$TotalValueSub;

                $TotalValue = number_format($TotalValue,2);
		 #$TotalValue += $arryAdjustmentItem[$Count]["amount"];
		//$TotalValue = number_format($arryAdjustment[0]['total_adjust_value'],2);
		?>
		<br>
		 Total Quantity: <?=$TotalorderQty?>
		
		<br><br>
		Total Value : <?=$TotalValue?>
		<br><br>
        </td>
    </tr>
</table>

<? //echo '<script>SetInnerWidth();</script>'; ?>
