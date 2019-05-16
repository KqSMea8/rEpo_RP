<script>
 function popSn(vl) {
//alert(vl);
				document.getElementById(vl).style.display = 'block';
			}
			function hide(vl) {
				document.getElementById(vl).style.display = 'none';
			}
			//To detect escape button
			document.onkeydown = function(evt) {
				evt = evt || window.event;
				if (evt.keyCode == 27) {
					hide(vl);
				}
			};
function closeSN(vl){
//alert(vl);

			//alert("hiii");
			document.getElementById(vl).style.display = 'none';
		

}
	

</script>
<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arrySaleItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td width="12%" class="heading">Description</td>
     <td width="8%" class="heading">Warehouse</td>
		<td width="8%" class="heading">Condition</td>
 		<td width="12%" class="heading">Serial Numbers</td>
		<td width="12%" class="heading">Type</td>
		<td width="6%" class="heading">Qty RMA</td>
		<td width="9%"  class="heading">Original Qty Returned</td>
		<td width="6%" class="heading">Qty Return</td>
		<td width="8%"  class="heading">Unit Price</td>
		<td width="6%"  class="heading">Discount</td>
		<td width="5%" class="heading">Taxable</td>
		<? if($arrySale[0]['ReSt']=='1'){?>
		<td class="heading" width="5%" >Re-Stocking Fee</td>
		<? } ?>
		<td width="12%" class="heading" align="right" >Amount</td>
		
    </tr>

	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		//$qty_ordered = $objrmasale->GetQtyOrderded($arrySaleItem[$Count]["ref_id"]);	
		//$total_received = $objrmasale->GetQtyReceived($arrySaleItem[$Count]["ref_id"]);	
	
		//$qtyTotalInvoiced = $objWarehouseRma->Totalinvoicedrmaw($arrySaleItem[$Count]["ref_id"]);
		
		$valReceiptTotal = $objWarehouseRma->GetSumQtyReceipt($arrySaleItem[$Count]['OrderID'],$arrySaleItem[$Count]['item_id']);

		$RmaTypeVal = $objrmasale->RmaTypeValue($arrySaleItem[$Count]["Type"]);
	?>
     <tr class='itembg'>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arrySaleItem[$Count]["description"])?></td>
        <td><?=stripslashes($arrySaleItem[$Count]["warehouse_code"])?></td>
        <td><?=stripslashes($arrySaleItem[$Count]["Condition"])?></td>
        <td>


<? if($arrySaleItem[$Count]["SerialNumbers"]!=''){?>
 <a id="showpopup" style="cursor:pointer;" onclick ="popSn('mrgn<?=$Line?>');">View S.N.</a>


<div id="mrgn<?=$Line?>" style="display:none;  background-attachment: scroll;background-clip: border-box;background-color: rgba(0, 0, 0, 0.45); background-image: none;background-origin: padding-box;background-position: 0 0;background-repeat: repeat;background-size: auto auto;bottom: 0;box-sizing: border-box;    left: 0;opacity: 1;position: fixed;right: 0;top: 0;"  class="ontop" >

<div class="inner-mrgn">
<div class="close-mgn" ><i class="fa fa-times" onclick="closeSN('mrgn<?=$Line?>');" aria-hidden="true"></i></div>
<div class="popup-header">Serial Number List</div>
<div style="width: 317px; height: 376px; overflow-y: scroll;">
<table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">

<?php 

$SN = explode(",",$arrySaleItem[$Count]["SerialNumbers"]);
if(sizeof($SN)>0){
for($s=0;$s<sizeof($SN);$s++){
echo '<tr class="itembg"><td>';
echo $SN[$s]."<br>";
echo '</td></tr>';
}

}else{
echo '<tr><td>';
echo 'No serial number selected';
echo '</td></tr>';
}

?>
</table>
</div></div> </div>

<? }else{?>
No Specified
<? }?>


</td>
<td>
<?=$RmaTypeVal;?>
</td>
       <td><?=$arrySaleItem[$Count]["qty"]?></td>
        <td><?=$valReceiptTotal?></td>
       <td><?=$arrySaleItem[$Count]["qty_receipt"]?></td>
       <td><?=number_format($arrySaleItem[$Count]["price"],2)?></td>
	   <td><?=$arrySaleItem[$Count]["discount"]?></td>
       <td><?=stripslashes($arrySaleItem[$Count]['Taxable'])?>
	 
	   </td>
	<? if($arrySale[0]['ReSt']=='1'){?>
		<td> <div <?=($arrySaleItem[$Count]['Type']=="C" || $arrySaleItem[$Count]['Type']=="AC")?(""):('style="display: none;"')?>  > <?=$arrySaleItem[$Count]['fee']?></div> </td>
	<? } ?>
       <td align="right"><?=number_format($arrySaleItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} 

	?>



     <tr class='itembg'>
        <td colspan="14" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		
		
		$TotalAmountn=$subtotal+$arrySale[0]['FreightAmt']+$arrySale[0]['wtaxAmnt']-$arrySale[0]['ReStocking'];
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arrySale[0]['FreightAmt'],2);
		$ReStockingVal = number_format($arrySale[0]['ReStocking'],2);
	$Restocking_fee = '<span style="color:red;">('.number_format($arrySale[0]['ReStocking'],2).')</span>';

		$TotalAmount = number_format($TotalAmountn,2);


		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
			echo '<br><br>Freight : '.$Freight;
			
			if($arrySale[0]['ReSt']==1){
			echo '<br><br><span style="color:red;">Re-Stocking Fee:</span> :'.$Restocking_fee;
			}
			echo '<br><br>'.$TaxCaption.' : '.$arrySale[0]['wtaxAmnt'];
			echo '<br><br>Grand Total : '.$TotalAmount.'<br><br>';
		echo '</div>';

		?>
		<?php
		 //echo '<div class=redmsg style="float:left">'.$RtnInvoiceMess.'</div>';
		?>
        </td>
    </tr>

<? }else{ ?>
     <tr class='itembg'>
        <td align="center" class="no_record">

      //<?=NO_ITEM_RETURNED?>
        </td>
    </tr>
<? } ?>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
