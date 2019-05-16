
<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arrySaleItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td class="heading" >Description</td>
		<td class="heading">Type</td>
		<td  class="heading">Action</td>
		<td class="heading">Reason</td>
		<td class="heading" >Qty Ordered</td>
		<td class="heading" >Qty Returned</td>
		<td class="heading">Qty Receipted</td>
		<td class="heading" >Unit Price</td>
		<td class="heading">Discount</td>
		<td class="heading">Taxable</td>
		<td class="heading">Amount</td>
    </tr>

	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objSaleRma->GetQtyOrderded($arrySaleItem[$Count]["ref_id"]);	
		$total_received = $objSaleRma->GetQtyReceived($arrySaleItem[$Count]["ref_id"]);	

		$total_returned = $objSaleRma->GetQtyReturned($arrySaleItem[$Count]["ref_id"]);


		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}

		$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');

	?>
     <tr class='itembg'>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?><a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>>&nbsp;&nbsp;<img src="../images/tab-new.png" border="0" title="Additional Items"></a> </td>
        <td><?=stripslashes($arrySaleItem[$Count]["description"])?></td>
		<td>
		<?=stripslashes($arrySaleItem[$Count]["Type"])?>
		</td>
		
		<td>
		<?=stripslashes($arrySaleItem[$Count]["Action"])?>
		</td>
		
		<td>
		<?=stripslashes($arrySaleItem[$Count]["Reason"])?>
		</td>
       <td><?=$arrySaleItem[$Count]["qty"]?></td>
         
        <td><?=$arrySaleItem[$Count]["qty_returned"]?></td>
       <td><? if(!empty($arrySaleItem[$Count]["qty_receipt"])) echo $arrySaleItem[$Count]["qty_receipt"]; ?>
    
            <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1 && $arrySaleItem[$Count]["evaluationType"] == 'Serialized'){ ?>
                    <br> <a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?= $Line ?>&total=<?=$arrySaleItem[$Count]["qty_returned"]?>&sku=<?=stripslashes($arrySaleItem[$Count]["sku"])?>&SerialValue=<?=$arrySaleItem[$Count]["SerialNumbers"]?>&view=1" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;View S.N.</a>
            <?php }?>
       </td>
       <td><?=number_format($arrySaleItem[$Count]["price"],2)?></td>
	   <td><?=$arrySaleItem[$Count]["discount"]?></td>
       <td>

		<span style="display:<?=$TaxShowHide?>">
		<? /*if(!empty($arrySaleItem[$Count]["RateDescription"]))
				echo $arrySaleItem[$Count]["RateDescription"].' : ';
				echo number_format($arrySaleItem[$Count]["tax"],2);
			*/
			
			?>  
	 	</span>
		<?=$arrySaleItem[$Count]['Taxable']?>
	   </td>
       <td align="right"><?=number_format($arrySaleItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} 

	?>
     <tr class='itembg'>
        <td colspan="12" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
 		$Restocking_fee=0;

		if(!empty($subtotal)) $subtotal = number_format($subtotal,2);
		if(!empty($arrySale[0]['Freight']))$Freight = number_format($arrySale[0]['Freight'],2);
		if(!empty($arrySale[0]['taxAmnt'])) $taxAmnt = number_format($arrySale[0]['taxAmnt'],2);
if(!empty($arrySale[0]['ReStocking']))  $Restocking_fee = '<span style="color:red;">('.number_format($arrySale[0]['ReStocking'],2).')</span>';
		if(!empty($arrySale[0]['TotalAmount'])) $TotalAmount = number_format($arrySale[0]['TotalAmount'],2);

		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
		
			echo '<br><br>Freight : '.$Freight;
 echo '<br><br><span style="color:red;">Re-Stocking Fee:</span> :'.$Restocking_fee;
				echo '<br><br>'.$TaxCaption.' : '.$taxAmnt;
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

<script language="JavaScript1.2" type="text/javascript">
$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });
});
</script>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });
                 
                 $(".slnoclass").fancybox({
			'width'         : 300
		 });
                 
});

</script>

<? echo '<script>SetInnerWidth();</script>'; ?>
