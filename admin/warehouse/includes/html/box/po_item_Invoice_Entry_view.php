

 <table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" >SKU</td>
                <td width="15%" class="heading" >Condition</td>
		<td width="24%" class="heading" >Description</td>
                <td width="10%" class="heading" >Qty Received</td>
                <td  class="heading" >Serial Number</td>
		<td width="10%"  class="heading" >Unit Price</td>
		<td width="7%" class="heading" >Taxable</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>

	<? 
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
	 

	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}
	 if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
        <td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></td>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
       <td><?=$arryPurchaseItem[$Count]["qty_received"];?></td>
       <td><?=$arryPurchaseItem[$Count]["SerialNumbers"]?></td>
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?></td>
       <td><!--span style="display:<?=$TaxShowHide?>">
		<? /*if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);*/
			?>  
	 	</span-->  
		<?=$arryPurchaseItem[$Count]['Taxable']?>
	   </td>
       <td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];

		 

	} ?>


     <tr class='itembg'>
        <td colspan="8" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?	
		$subtotal = number_format($subtotal,2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);

		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
			
			echo '<br><br>Freight : '.$Freight;
			echo '<br><br>'.$TaxCaption.' : '.$taxAmnt;
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
