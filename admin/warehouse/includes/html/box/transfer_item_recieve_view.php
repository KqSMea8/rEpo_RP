<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arryTransferItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td width="20%" class="heading">Description</td>
		<td width="10%" class="heading">Qty Transfer</td>
		
		<td width="12%" align="center" class="heading">Qty Received</td>
		
		<td width="10%"  class="heading">Unit Price</td>
	
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1; 	
		//$qty_ordered = $objWrecieved->GetQtyOrderded($arryTransferItem[$Count]["ref_id"]);	
		//$total_received = $objWrecieved->GetQtyReceived($arryTransferItem[$Count]["ref_id"]);	

		//$total_returned = $objWrecieved->GetQtyReturned($arryTransferItem[$Count]["ref_id"]);


	?>
     <tr class='itembg'>
        <td><?=stripslashes($arryTransferItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arryTransferItem[$Count]["description"])?></td>
       <td><?=$arryTransferItem[$Count]["qty"]?></td>
         
       
       <td><?=$arryTransferItem[$Count]["qty_received"]?></td>
       <td><?=number_format($arryTransferItem[$Count]["price"],2)?></td>
	   
	 
	   </td>
       <td align="right"><?=number_format($arryTransferItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arryTransferItem[$Count]["amount"];
	} 

	?>



     <tr class='itembg'>
        <td colspan="10" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arrySale[0]['Freight'],2);
		$TotalAmount = number_format($arrySale[0]['TotalAmount'],2);


		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
			echo '<br><br>Freight : '.$Freight;
			echo '<br><br>Grand Total : '.$TotalAmount.'<br><br>';
		echo '</div>';

		?>
		<?php
		 echo '<div class=redmsg style="float:left">'.$RtnInvoiceMess.'</div>';
		?>
        </td>
    </tr>

<? }else{ ?>
     <tr class='itembg'>
        <td align="center" class="no_record">

      <?=NO_ITEM_RETURNED?>
        </td>
    </tr>
<? } ?>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
