<?php if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:none;"'; } 





$TypeInfo = '<img src="'.$MainPrefix.'icons/help.png"  border="0"   onMouseover="ddrivetip(\''.PURCHASE_RMA_TYPE_INFO.'\', 520,\'\')"; onMouseout="hideddrivetip()" >';



?>
 <table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">
 <? if(sizeof($arryPurchaseItem)>0){ ?>
    <tr align="left"  >
		<td width="8%" class="heading" >SKU</td>
<td width="8%" class="heading" >Warehouse</td>
 		<td width="8%" class="heading" >Condition</td>
		<td class="heading" >Description</td>
		
		<td width="8%" class="heading" >Serial Number</td>

		<td width="6%" class="heading" >Type <?=$TypeInfo?></td>
		<td width="6%" class="heading" >Action</td>
		<td width="8%" class="heading" >Reason</td>
		
		<td width="8%" class="heading" >Total Qty Invoiced</td>
		
		<td width="8%" class="heading" >Total Qty RMA</td>
		<td width="6%" class="heading" >Qty RMA</td>
		<td width="8%"  class="heading" >Unit Price</td>
		<td width="7%" class="heading" >Taxable</td>
		<? if($arryPurchase[0]['Restocking']=='1'){?>
		<td class="heading" width="5%" >Re-Stocking Fee</td>
		<? } ?>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objPurchase->GetQtyOrderded($arryPurchaseItem[$Count]["ref_id"]);
		//echo ($arryPurchaseItem[$Count]["id"]);
		//echo "<br>";
		//echo $arryPurchaseItem[$Count]["ref_id"];
		$total_invoiced = $objPurchase->GetQtyInvoiced($arryPurchaseItem[$Count]["ref_id"]);	

		$total_returned = $objPurchase->GetQtyReturned($arryPurchaseItem[$Count]["ref_id"]);
		
		$total_rma = $objPurchase->GetQtyRma($arryPurchaseItem[$Count]["ref_id"]);


	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
		<td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?></td>
<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["warehouse_code"])?></div></td>
		<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></div></td>	
		<td><?=stripslashes($arryPurchaseItem[$Count]["description"])?><?php if(!empty($arryPurchaseItem[$Count]["PurchaseComment"])) { ?><br><b>Comment: </b><?=stripslashes($arryPurchaseItem[$Count]["PurchaseComment"])?><?php } ?></td>

		<td><?=$arryPurchaseItem[$Count]["SerialNumbers"]?></td>
		
		<td><?=$objPurchase->GetRmaType($arryPurchaseItem[$Count]["Type"])?>




</td>
		<td><?=stripslashes($arryPurchaseItem[$Count]["Action"])?></td>
		<td><?=stripslashes($arryPurchaseItem[$Count]["Reason"])?></td>
		
	
		<td><?=$total_invoiced?></td>
		
		<td><?=$total_rma?></td>
		<td><?=$arryPurchaseItem[$Count]["qty"]?></td>
		<td><?=number_format($arryPurchaseItem[$Count]["price"],2)?>

<?php if($arryPurchase[0]['Currency']!=$Config['Currency']){ ?>
<br>
<span class="red"> (<? echo round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $arryPurchaseItem[$Count]["price"]) ,2)." ".$Config['Currency'];?>)</span>
<? }?>

</td>
		<td><!--span style="display:<?=$TaxShowHide?>">
		<? /* if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
		echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
		echo number_format($arryPurchaseItem[$Count]["tax"],2);
		*/	
		?>  
		</span-->  
		<?=$arryPurchaseItem[$Count]['Taxable']?>
		</td>


<? if($arryPurchase[0]['Restocking']=='1'){?>
		<td> <div <?=($arryPurchaseItem[$Count]['Type']=="C" || $arryPurchaseItem[$Count]['Type']=="AC")?(""):('style="display: none;"')?>  > <?=$arryPurchaseItem[$Count]['fee']?> </div> </td>
	<? } ?>


		<td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?>

<?php if($arryPurchase[0]['Currency']!=$Config['Currency']){ ?>
<br>
<span class="red"> (<? echo round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $arryPurchaseItem[$Count]["amount"]) ,2)." ".$Config['Currency'];?>)</span>
<? }?>


</td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];
	} 

	?>



     <tr class='itembg'>
        <td colspan="15" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		 
		$Freight =  $arryPurchase[0]['Freight'];
$Restocking_fee = '<span style="color:red;">('.number_format($arryPurchase[0]['Restocking_fee'],2).')</span>';
		//$Restocking_fee = number_format($arryPurchase[0]['Restocking_fee'],2);
		$taxAmnt =  $arryPurchase[0]['taxAmnt'];
		$TotalAmount =  $arryPurchase[0]['TotalAmount'];

		echo '<div>';
			echo '<br>Sub Total : '.number_format($subtotal,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $subtotal) ,2).' '.$Config['Currency'].')</span>';
}
			
			echo '<br><br>Freight : '.number_format($Freight,2);
if($arryPurchase[0]['Currency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $Freight) ,2).' '.$Config['Currency'].')</span>';
}

			if($arryPurchase[0]['Restocking_fee'] >0 && $arryPurchase[0]['Restocking']==1){
				//echo '<br><br>Re-Stocking Fee : '.number_format($arryPurchase[0]['Restocking_fee'],2);
echo '<br><br><span style="color:red;">Re-Stocking Fee</span> : '.$Restocking_fee;
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
