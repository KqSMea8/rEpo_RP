<?php //echo "<pre>";print_r($arryPurchaseItem);?>
<?php if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:none;"'; } ?>
 <table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">
 <? if(sizeof($arryPurchaseItem)>0){ ?>
    <tr align="left"  >
		<td width="8%" class="heading" >SKU</td>
 		<td width="13%" class="heading" >Condition</td>
		<td class="heading" >Description</td>
		<td width="10%" class="heading" >Qty Ordered</td>
		<td width="13%" class="heading" >Qty Received</td>
		
		<td width="10%" class="heading" >Qty Returned</td>
		<td width="8%"  class="heading" >Unit Price</td>
		<td width="7%" class="heading" >Taxable</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objPurchase->GetQtyOrderded($arryPurchaseItem[$Count]["ref_id"]);	
		$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["ref_id"]);	
        $total_returned = $objPurchase->GetQtyReturned($arryPurchaseItem[$Count]["ref_id"]);
    
        $subtotla_val = ($arryPurchaseItem[$Count]["qty_returned"])*($arryPurchaseItem[$Count]["price"]);


	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
		<td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?></td>
		<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></div></td>	
		<td><?=stripslashes($arryPurchaseItem[$Count]["description"])?><?php if(!empty($arryPurchaseItem[$Count]["PurchaseComment"])) { ?><br><b>Comment: </b><?=stripslashes($arryPurchaseItem[$Count]["PurchaseComment"])?><?php } ?></td>
		<td><?=$qty_ordered?></td>
		<td><?=$arryPurchaseItem[$Count]["qty_received"]?></td>
		
		<td><?=$arryPurchaseItem[$Count]["qty_returned"]?></td>
		<td><?=number_format($arryPurchaseItem[$Count]["price"],2)?></td>
		<td><!--span style="display:<?=$TaxShowHide?>">
		<? /* if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
		echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
		echo number_format($arryPurchaseItem[$Count]["tax"],2);
		*/	
		?>  
		</span-->  
		<?=$arryPurchaseItem[$Count]['Taxable']?>
		</td>
		<td align="right"><?=number_format($subtotla_val,2)?></td>
       
    </tr>
	<? 
		$subtotla_val_w += $subtotla_val;
              
	} 

	?>



     <tr class='itembg'>
        <td colspan="10" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$subtotla_val_w = number_format($subtotla_val_w,2);
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);

		echo '<div>';
			echo '<br>Sub Total : '.$subtotla_val_w;
			echo '<br><br>'.$TaxCaption.' : '.$taxAmnt;
			echo '<br><br>Freight : '.$Freight;
			echo '<br><br>Grand Total : '.$TotalAmount;
		echo '</div>';


		?>
		
        </td>
    </tr>

<? }else{ ?>
     <tr class='itembg' >
        <td align="center" class="no_record">

      <?=NO_ITEM_RETURNED?>
        </td>
    </tr>
<? } ?>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
