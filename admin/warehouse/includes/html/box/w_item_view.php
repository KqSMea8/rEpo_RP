<? $bgcolor="#FFFFFF"; ?>	


 <table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td width="24%" class="heading" >Description</td>
		<td width="10%" class="heading" >Qty Ordered</td>
		<?if(!empty($module)){?><td width="15%" class="heading" >Total Qty Received</td><?}?>
		<td width="10%"  class="heading" >Unit Price</td>
		<td width="15%" class="heading" >Tax Rate</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>

	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["id"]);
		$ordered_qty = $arryPurchaseItem[$Count]["qty"];
	?>
     <tr bgcolor="<?=$bgcolor?>">
        <td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
         <td><?=$arryPurchaseItem[$Count]["qty"]?></td>
       <?if(!empty($module)){?><td><?=number_format($total_received)?></td><?}?>
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?></td>
       <td><? if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);
			?>  
	 
	   </td>
       <td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];

		$TotalQtyReceived += $total_received;
		#$TotalQtyLeft += ($ordered_qty - $total_received);

	} ?>


     <tr bgcolor="<?=$bgcolor?>">
        <td colspan="9" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?	
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);

		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
			echo '<br><br>Freight : '.$Freight;
			echo '<br><br>Grand Total : '.$TotalAmount;
		echo '</div>';


		/*****************************/
		if($module=="Order"){
			$TotalQtyLeft = $objPurchase->GetTotalQtyLeft($arryPurchase[0]['PurchaseID']);
			if($TotalQtyLeft<=0){
				echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
			}
		}

		/*****************************/

		?>


        </td>
    </tr>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
