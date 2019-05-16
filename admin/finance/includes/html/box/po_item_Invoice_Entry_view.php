<?php
if($arryCompany[0]['TrackInventory'] !=1){
		$style ='style="display:none;"';
		$numTd = 10;
	}else{
	       $numTd = 11;
	}


?>

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
	$subtotal=0;
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
	<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></div></td>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
       <td><?=$arryPurchaseItem[$Count]["qty_received"];?></td>
       <td><?=$arryPurchaseItem[$Count]["SerialNumbers"]?></td>
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?>

<?php if($arryPurchase[0]['Currency']!=$Config['Currency']){ ?>
<br>
<span class="red"> (<? echo round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $arryPurchaseItem[$Count]["price"]) ,2)." ".$Config['Currency'];?>)</span>
<? }?>
</td>
       <td><!--span style="display:<?=$TaxShowHide?>">
		<? /*if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);*/
			?>  
	 	</span-->  
		<?=$arryPurchaseItem[$Count]['Taxable']?>
	   </td>
       <td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?>

<?php if($arryPurchase[0]['Currency']!=$Config['Currency']){ ?>
<br>
<span class="red"> (<? echo round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $arryPurchaseItem[$Count]["amount"]) ,2)." ".$Config['Currency'];?>)</span>
<? }?>
</td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];

		 

	} ?>


     <tr class='itembg'>
        <td colspan="8" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?	
		 
		$taxAmnt =  $arryPurchase[0]['taxAmnt'];
		$Freight =  $arryPurchase[0]['Freight'];
		$TotalAmount =  $arryPurchase[0]['TotalAmount'];

	
		echo '<br>Sub Total : '.number_format($subtotal,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $subtotal) ,2).' '.$Config['Currency'].')</span>';
}
		echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $taxAmnt) ,2).' '.$Config['Currency'].')</span>';
}

		echo '<br><br>Freight : '.number_format($Freight,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $Freight) ,2).' '.$Config['Currency'].')</span>';
}

		if($arryPurchase[0]['AdjustmentAmount']!='0.00'){
			echo '<br><br>Adjustments : '.number_format($arryPurchase[0]['AdjustmentAmount'],2);
		}
		echo '<br><br>Grand Total : '.number_format($TotalAmount,2);
 if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $TotalAmount) ,2).' '.$Config['Currency'].')</span>';
}		


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
