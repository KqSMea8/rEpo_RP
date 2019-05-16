<?php if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:none;"'; } ?>
 <table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">
 <? if(sizeof($arryPurchaseItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
                <td width="12%" class="heading" >Condition</td>
		<td width="15%" class="heading" >Description</td>
		<td width="10%" class="heading" >Qty Ordered</td>
		<td width="14%" class="heading" >Total Qty Received</td>
		<td width="11%" class="heading" >Qty Received</td>
		<td width="10%"  class="heading" >Unit Price</td>
		<td width="12%" class="heading" >Tax Rate</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objPurchase->GetQtyOrderded($arryPurchaseItem[$Count]["ref_id"]);	
		$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["ref_id"]);

	if($arryPurchase[0]['Taxable']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}


	
	?>
     <tr class='itembg'>
        <td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?></td>
        <td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></div></td>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
       <td><?=$qty_ordered?></td>
         <td><?=$total_received?></td>
       <td><?=$arryPurchaseItem[$Count]["qty_received"]?></td>
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?></td>
       <td> <span style="display:<?=$TaxShowHide?>">
	<? if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);
				
			?>  
	 	</span> 
	   </td>
       <td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];

		//$TotalQtyLeft += ($qty_ordered - $total_received);
	} 

	?>



     <tr class='itembg'>
        <td colspan="8" align="right">

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




		/*****************************/
		$TotalQtyLeft = $objPurchase->GetTotalQtyLeft($arryPurchase[0]['PurchaseID']);
		if($TotalQtyLeft<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
		}

		/*****************************/
		?>
		
        </td>
    </tr>

<? }else{ ?>
     <tr class='itembg' >
        <td align="center" class="no_record">

      <?=NO_ITEM_RECEIVED?>
        </td>
    </tr>
<? } ?>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
