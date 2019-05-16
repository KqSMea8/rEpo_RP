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

<?php 


//echo"<pre>";print_r($arryPurchaseItem);?>
 <table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arryPurchaseItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td width="8%" class="heading" >Condition</td>
		<td width="10%" class="heading">Description</td>
		<td width="8%" class="heading">Serial Number</td>
		<td width="8%" class="heading" >Type</td>
        <td width="5%" class="heading" >Action</td>
        <td width="5%" class="heading" >Reason</td>
		<!--<td width="9%" class="heading">Qty Ordered</td>--->
		<td width="7%" class="heading">Qty RMA</td>
	
		<td width="8%" class="heading">Original Qty Returned</td>
		<td width="8%" class="heading">Qty Returned</td>
		<td width="8%"  class="heading">Unit Price</td>
		 
		<td width="8%" class="heading">Taxable</td>
		<? if($arryRMA[0]['Restocking']=='1'){?>
		<td class="heading" width="5%" >Re-Stocking Fee</td>
		<? } ?>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objPurchase->GetQtyOrderded($arryPurchaseItem[$Count]["ref_id"]);	
		$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["ref_id"]);	

		$ValReciept = $objWarehouse->GetPurchaseSumQtyReceipt($arryPurchaseItem[$Count]["OrderID"],$arryPurchaseItem[$Count]["item_id"]);
		
		$total_returned = $objPurchase->GetQtyReturned($arryPurchaseItem[$Count]["ref_id"]);
		
		//echo "hello";print_r($total_received);
		

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
         <td>

<? if($arryPurchaseItem[$Count]["SerialNumbers"] != ''){?>
<a id="showpopup" style="cursor:pointer;" onclick ="popSn('mrgn<?=$Line?>');">View S.N.</a>
<?}?>
<div id="mrgn<?=$Line?>" style="display:none;  background-attachment: scroll;background-clip: border-box;background-color: rgba(0, 0, 0, 0.45); background-image: none;background-origin: padding-box;background-position: 0 0;background-repeat: repeat;background-size: auto auto;bottom: 0;box-sizing: border-box;    left: 0;opacity: 1;position: fixed;right: 0;top: 0;"  class="ontop" >

<div class="inner-mrgn">
<div class="close-mgn" ><i class="fa fa-times" onclick="closeSN('mrgn<?=$Line?>');" aria-hidden="true"></i></div>
<div class="popup-header">Serial Number List</div>
<div style="width: 317px; height: 376px; overflow-y: scroll;">
<table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">

<?php 

$SN = explode(",",$arryPurchaseItem[$Count]["SerialNumbers"]);
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
</div></div></div>







</td>
       <td><?=$objPurchase->GetRmaType($arryPurchaseItem[$Count]["Type"])?>
         <td><?=$arryPurchaseItem[$Count]["Action"]?></td>
         <td><?=$arryPurchaseItem[$Count]["Reason"]?></td>
       
       <?/*?><td><?=$arryPurchaseItem[$Count]["qty"]?></td>*/?>
         <td><?=$arryPurchaseItem[$Count]["qty"]?></td>

        <td><?=$ValReciept?><?#=$arryPurchaseItem[$Count]["qty_receipt"]?></td>
      <td><?=$arryPurchaseItem[$Count]["qty_receipt"]?></td>
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?></td>
	  
       <td><?=$arryPurchaseItem[$Count]["Taxable"];?><?/* if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["Tax"],2);
				
			*/?>  
	 
	   </td>

	<? if($arryRMA[0]['Restocking']=='1'){?>
		<td> <div <?=($arryPurchaseItem[$Count]['Type']=="C" || $arryPurchaseItem[$Count]['Type']=="AC")?(""):('style="display: none;"')?>  > <?=$arryPurchaseItem[$Count]['fee']?> </div> </td>
	<? } ?>


       <td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];
	} 

	?>



     <tr class='itembg'>
        <td colspan="14" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);
$Restocking_fee = '<span style="color:red;">('.number_format($arryPurchase[0]['Restocking_fee'],2).')</span>';
		$TotalAmount = number_format($arryPurchase[0]['TotalReceiptAmount'],2);
		//$TotalAmount = number_format($arryPurchaseItem[$Count]["amount"],2);

		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
		
			echo '<br><br>Freight : '.$Freight;
			if($arryPurchase[0]['Restocking_fee'] >0 && $arryRMA[0]['Restocking']==1){
				echo '<br><br><span style="color:red;">Re-Stocking Fee</span> : '.$Restocking_fee;
			}
					echo '<br><br>'.$TaxCaption.' : '.$taxAmnt;
			echo '<br><br>Grand Total : '.$TotalAmount;
		echo '</div>';


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
 
 
 
 <?php /**********************************************************************************/?>
 
