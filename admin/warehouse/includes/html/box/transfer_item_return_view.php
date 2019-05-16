<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arrySaleItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td width="20%" class="heading">Description</td>
		<td width="10%" class="heading">Qty Transfer</td>
		
		<td width="12%" align="center" class="heading">Qty Recieved</td>
		<td width="12%" align="center" class="heading">Qty Recieve</td>
		<td width="10%"  class="heading">Unit Price</td>
	
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objSale->GetQtyOrderded($arrySaleItem[$Count]["ref_id"]);	
		$total_received = $objSale->GetQtyReceived($arrySaleItem[$Count]["ref_id"]);	

		$total_returned = $objSale->GetQtyReturned($arrySaleItem[$Count]["ref_id"]);


	?>
     <tr class='itembg'>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arrySaleItem[$Count]["description"])?></td>
       <td><?=$arrySaleItem[$Count]["qty"]?></td>
         
        <td><?=$arrySaleItem[$Count]["qty_returned"]?></td>
       <td><?=$arrySaleItem[$Count]["qty_returned"]?></td>
       <td><?=number_format($arrySaleItem[$Count]["price"],2)?></td>
	   
	 
	   </td>
       <td align="right"><?=number_format($arrySaleItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
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
