<?php if($arryCompany[0]['TrackInventory'] !=1){
		$style ='style="display:none;"';
		$numTd = 10;
	}else{
	       $numTd = 11;
	}
?>

<script>
 function pop(vl) {
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
 <table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">
 <? if(sizeof($arryPurchaseItem)>0){ ?>
    <tr align="left"  >
		<td width="10%" class="heading" >SKU</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
 <td  class="heading" width="7%" >Warehouse</td>
<td  class="heading" width="7%" >Bin</td>
                <td  class="heading" width="7%" >Condition</td>
<? }?>

		<td  class="heading"  >Description</td>
		<td width="7%" class="heading" >Qty Ordered</td>
		<!--td width="5%" class="heading" >Total Qty Received</td-->
		<td width="7%" class="heading" >Qty Received</td>
    <td  class="heading" width="10%" >Serial Number</td>
		<td width="7%"  class="heading" >Unit Price</td>
		<td width="7%" class="heading"> Cost</td>
		<td width="5%" class="heading" >Taxable</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objPurchase->GetQtyOrderded($arryPurchaseItem[$Count]["ref_id"]);	
		$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["ref_id"]);

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
<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["bin"])?></div></td>
	<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></div></td>

        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
       <td><?=stripslashes($arryPurchaseItem[$Count]["qty"])?></td>
         <!--td><?=$total_received?></td-->
<!--td><?=$qty_ordered?></td-->
       <td><?=$arryPurchaseItem[$Count]["qty_received"]?></td>
       <td>



 <a id="showpopup" onclick ="pop('mrgn<?=$Line?>');">View S.N.</a>

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
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?>
<?php if($arryPurchase[0]['Currency']!=$Config['Currency']){
	 echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $arryPurchaseItem[$Count]["price"]) ,2).' '.$Config['Currency'].')</span>';
}?>

</td>
	<td><?
		if(!empty($arryPurchaseItem[$Count]["avgCost"])){
			if($arryPurchase[0]['OrderType']=='Dropship' ){ 
				echo number_format($arryPurchaseItem[$Count]["avgCost"],2);
			} else{ 
				echo number_format($arryPurchaseItem[$Count]["avgCost"],2) ; 
			}
		}

?></td>
       <td> <!--span style="display:<?=$TaxShowHide?>">
	<? /*if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);
			*/	
			?>  
	 	</span--> 
		<?=$arryPurchaseItem[$Count]['Taxable']?>
	   </td>
       <td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?>
<?php
if($arryPurchase[0]['Currency']!=$Config['Currency']){
			
			echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $arryPurchaseItem[$Count]["amount"]) ,2).' '.$Config['Currency'].')</span>';
}
?>

</td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];

		//$TotalQtyLeft += ($qty_ordered - $total_received);
	} 

	?>



     <tr class='itembg'>
        <td colspan="13" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
 
		$taxAmnt =  $arryPurchase[0]['taxAmnt'];
		$Freight =  $arryPurchase[0]['Freight'];
		$PrepaidAmount =  $arryPurchase[0]['PrepaidAmount']; 
		$TotalAmount =  $arryPurchase[0]['TotalAmount'];


		
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

			if($arryPurchase[0]['AdjustmentAmount']!='0.00'){
				echo '<br><br>Adjustments : '.$arryPurchase[0]['AdjustmentAmount'];
			}
			echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);
			if($arryPurchase[0]['Currency']!=$Config['Currency']){
				echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $taxAmnt) ,2).' '.$Config['Currency'].')</span>';
			}

			echo '<br><br>Grand Total : '.number_format($TotalAmount,2);
			if($arryPurchase[0]['Currency']!=$Config['Currency']){
				echo '<br><span class="red">('.round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $TotalAmount) ,2).' '.$Config['Currency'].')</span>';
			}else{
				echo '<br><br>';
			}
	




		/*****************************/
		$TotalQtyLeft = $objPurchase->GetTotalQtyLeft($arryPurchase[0]['PurchaseID']);
		if($TotalQtyLeft<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
		}

		/*****************************/
		?>
		
        </td>
    </tr>

<? }else{ ?>
     <tr class='itembg' >
        <td align="center" class="no_record">

      <?=NO_ITEM_RECEIVED?>
        </td>
    </tr>
<? } ?>
</table>

<? //echo '<script>SetInnerWidth();</script>'; ?>
