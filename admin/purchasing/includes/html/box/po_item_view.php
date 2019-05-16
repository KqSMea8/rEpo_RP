
<?php if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:none;"'; } ?>
 <table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" >SKU</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
<td width="8%" class="heading" >Warehouse</td>
<? }?>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
<td width="8%" class="heading" >Condition</td>
<? }?>
		<td width="15%" class="heading" >Description</td>
		<td width="10%" class="heading">Comments</td>
		<td width="10%" class="heading" >Qty Ordered</td>
		<?if($module!='Quote'){?><td width="15%" class="heading" >Total Qty Received</td><?}?>
		<td width="10%"  class="heading" >Unit Price</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
		<?if($arryPurchase[0]['OrderType']=='Dropship' ){?><!--td width="5%" class="heading">Dropship Cost</td--><?}?>
		
<? }?>
		<td width="5%" class="heading" >Taxable</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>

	<? 
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["id"]);
		$ordered_qty = $arryPurchaseItem[$Count]["qty"];

	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}


	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';


 

	?>
     <tr class='itembg'>
        <td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?></td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["warehouse_code"])?></div></td>
<? }?>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></div></td>
<? }?>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
<td><?=stripslashes($arryPurchaseItem[$Count]["DesComment"])?></td>
         <td><?=$arryPurchaseItem[$Count]["qty"]?></td>
      <?if($module!='Quote'){?> <td><?=$total_received?></td><?}?>
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?>

<?php if($arryPurchase[0]['Currency']!=$Config['Currency']){ ?>
<br>
<span class="red"> (<? echo round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $arryPurchaseItem[$Count]["price"]) ,2)." ".$Config['Currency'];?>)</span>
<? }?>


</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
       <?if($arryPurchase[0]['OrderType']=='Dropship' ){?><!--td>
<? //if($arryPurchaseItem[$Count]['DropshipCheck'] ==1){  echo "Yes"; } ?>
<? echo  number_format($arryPurchaseItem[$Count]["DropshipCost"],2); ?></td--><?}?>

     
<? }?>
	  <td><!--span style="display:<?=$TaxShowHide?>">
		<? if(!empty($arryPurchaseItem[$Count]["RateDescription"]))

				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);
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

		$TotalQtyReceived += $total_received;
		#$TotalQtyLeft += ($ordered_qty - $total_received);

	} ?>


     <tr class='itembg'>
        <td colspan="10" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?	
 
		$Freight = $arryPurchase[0]['Freight'];
		$taxAmnt = $arryPurchase[0]['taxAmnt'];
		$PrepaidAmount = $arryPurchase[0]['PrepaidAmount']; 
		$TotalAmount = $arryPurchase[0]['TotalAmount'];
		echo '<div>';
			echo '<br>Sub Total : '.number_format($subtotal,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $subtotal) ,2).' '.$Config['Currency'].')</span>';
}	
			echo '<br><br>Freight Cost : '.number_format($Freight,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $Freight) ,2).' '.$Config['Currency'].')</span>';
}


			if($arryPurchase[0]['PrepaidFreight']=='1'){   
				echo '<br><br>Prepaid Freight : '.number_format($PrepaidAmount,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $PrepaidAmount) ,2).' '.$Config['Currency'].')</span>';
}


			}
			echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $taxAmnt) ,2).' '.$Config['Currency'].')</span>';
}

			echo '<br><br>Grand Total : '.number_format($TotalAmount,2);
	if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $TotalAmount) ,2).' '.$Config['Currency'].')</span>';
}
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

<? #echo '<script>SetInnerWidth();</script>'; ?>
