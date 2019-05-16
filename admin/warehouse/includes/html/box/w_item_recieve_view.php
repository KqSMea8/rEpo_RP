<? $bgcolor="#FFFFFF"; ?>	


 <table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arryPurchaseItem)>0){ ?>
    <tr align="left"  >
		<td width="8%" class="heading" >SKU</td>
		<td class="heading" >Description</td>
		<td width="10%" class="heading" >Qty Ordered</td>
		<td width="13%" class="heading" >PO Qty Received</td>
		
		<td  class="heading" > Total Qty Received</td>
		<td width="10%" class="heading" > Qty Received</td>
		<td width="8%"  class="heading" >Unit Price</td>
		<td width="10%" class="heading" >Tax Rate</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	

		$qty_ordered = $objInbound->GetQtyOrderdedInWarehouse($arryPurchaseItem[$Count]["id"]);	
		$total_received = $objInbound->GetQtyReceivedInWarehouse($arryPurchaseItem[$Count]["id"]);
		 //$total_received;
		
		$total_returned = $objInbound->GetQtyReturnedInWarehouse($arryPurchaseItem[$Count]["id"]);
      if($arryPurchaseItem[$Count]["qty_wRecieved"]>0){

	?>
     <tr bgcolor="<?=$bgcolor?>">
        <td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
       <td><?=$arryPurchaseItem[$Count]["qty"]?></td>
         <td><?=$arryPurchaseItem[$Count]["qty_received"]?></td>
       <td><?=$total_received?></td>
       <td><?=$arryPurchaseItem[$Count]["qty_wRecieved"]?></td>
      <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?></td>
       <td><? if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);
				
			?>  
	 
	   </td>
       <td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
	  }
		$subtotal += $arryPurchaseItem[$Count]["amount"];
	} 

	?>



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
			echo '<br><br>Grand Total : '.$TotalAmount.'<br><br>';
		echo '</div>';

		?>
		
        </td>
    </tr>

<? }else{ ?>
     <tr bgcolor="<?=$bgcolor?>" >
        <td align="center" class="no_record">

      <?=NO_ITEM_RETURNED?>
        </td>
    </tr>
<? } ?>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
