<?php  if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:none;"'; } ?>

<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arrySaleItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
                <td width="10%" class="heading">Condition</td>
		<td width="15%" class="heading">Description</td>
		<td width="6%" class="heading">Type</td>
		<td width="6%" class="heading">Action</td>
		<td width="6%" class="heading">Reason</td>
		<td width="8%" class="heading">Qty Ordered</td>
		<td width="8%" class="heading">Qty Invoiced</td>
		<td width="8%" class="heading">Qty Returned</td>
		<td width="8%" class="heading">Qty Return</td>
		<td width="10%"  class="heading">Unit Price</td>
		<td width="8%"  class="heading">Discount</td>
		<td width="8%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objSale->GetQtyOrderded($arrySaleItem[$Count]["ref_id"]);	
		$total_received = $objSale->GetQtyReceived($arrySaleItem[$Count]["ref_id"]);	

		$total_returned = $objSale->GetQtyReturned($arrySaleItem[$Count]["ref_id"]);


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
        
 <td><div <?=$style?>><?=stripslashes($arrySaleItem[$Count]["Condition"])?></div></td>
<td><?=stripslashes($arrySaleItem[$Count]["description"])?></td>

<td><?=stripslashes($arrySaleItem[$Count]["Type"])?></td>
<td><?=stripslashes($arrySaleItem[$Count]["Action"])?></td>
<td><?=stripslashes($arrySaleItem[$Count]["Reason"])?></td>

       <td><?=$arrySaleItem[$Count]["qty"]?></td>
         <td><?=$arrySaleItem[$Count]["qty_invoiced"]?></td>
        <td><?=$arrySaleItem[$Count]["qty_returned"]?></td>
       <td><?=$arrySaleItem[$Count]["qty_returned"]?>
    
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
        <td colspan="15" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arrySale[0]['Freight'],2);
		$taxAmnt = number_format($arrySale[0]['taxAmnt'],2);
		$TotalAmount = number_format($arrySale[0]['TotalAmount'],2);


		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
			echo '<br><br>Tax : '.$taxAmnt;
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

