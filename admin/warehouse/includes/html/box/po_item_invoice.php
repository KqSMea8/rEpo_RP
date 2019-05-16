<style>


</style>

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
<? if($Config['SelectOneItem']!=1){?>
                <td  class="heading" width="8%" >Warehouse</td>
<td  class="heading" width="8%" >Bin</td>
<? }?>
<? if($Config['SelectOneItem']!=1){?>
                <td  class="heading" width="8%" >Condition</td>
<? }?>
		<td  class="heading"  >Description</td>
		<td width="10%" class="heading" >Qty Ordered</td>
		<td width="10%" class="heading" >Total Qty Received</td>
		<td width="10%" class="heading" >Qty Received</td>
<? if($Config['SelectOneItem']!=1){
if($arryPurchase[0]['OrderType']!='Dropship' ){
?>
                <td  class="heading" >Serial Number</td>
<? 
}}?>
		<!--<td width="8%"  class="heading" >Unit Price</td>-->
		<?if($arryPurchase[0]['OrderType']=='Dropship' ){?><td width="7%" class="heading">Dropship Cost</td><?}?>
		<td width="6%" class="heading" >Taxable</td>
		<!--<td width="10%" class="heading" align="right" >Amount</td>-->
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
<? if($Config['SelectOneItem']!=1){?>
<td><?=stripslashes($arryPurchaseItem[$Count]["warehouse_code"])?></td>
<td><?=stripslashes($arryPurchaseItem[$Count]["bin"])?></td>
<? }?>
<? if($Config['SelectOneItem']!=1){?>
<td><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></td>
<? }?>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
       <td><?=$qty_ordered?></td>
         <td><?=$total_received?></td>
       <td><?=$arryPurchaseItem[$Count]["qty_received"]?></td>
<? if($Config['SelectOneItem']!=1){

if($arryPurchase[0]['OrderType']!='Dropship' ){
?>
       <td><div id="content">
  
    <a id="showpopup" onclick ="pop('mrgn<?=$Count?>');">View S.N.</a>
</div>
<div id="mrgn<?=$Count?>" style="display:none;  background-attachment: scroll;background-clip: border-box;background-color: rgba(0, 0, 0, 0.45); background-image: none;background-origin: padding-box;background-position: 0 0;background-repeat: repeat;background-size: auto auto;bottom: 0;box-sizing: border-box;    left: 0;opacity: 1;position: fixed;right: 0;top: 0;"  class="ontop" >

<div class="inner-mrgn">
<div class="close-mgn" ><i class="fa fa-times" onclick="closeSN('mrgn<?=$Count?>');" aria-hidden="true"></i></div>
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
</div></div></div></td>
<?} }?>
       <!--<td><?=number_format($arryPurchaseItem[$Count]["price"],2)?></td>-->
	<?if($arryPurchase[0]['OrderType']=='Dropship' ){?><td><?=number_format($arryPurchaseItem[$Count]["DropshipCost"],2)?></td><?}?>
       <td> <!--span style="display:<?=$TaxShowHide?>">
	<? /*if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);
			*/	
			?>  
	 	</span--> 
		<?=$arryPurchaseItem[$Count]['Taxable']?>
	   </td>
       <!--<td align="right"><?=number_format($arryPurchaseItem[$Count]["amount"],2)?>

<?
if($arryPurchaseItem[$Count]["freight_cost"]>0){
	echo '<br><span class=red>[Landed Cost: '.number_format($arryPurchaseItem[$Count]["freight_cost"],2).']</span>';
}
?>

</td>-->
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];

		//$TotalQtyLeft += ($qty_ordered - $total_received);
	} 

	?>



     <tr class='itembg'>
        <td colspan="12" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$subtotal = number_format($subtotal,2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$PrepaidAmount = number_format($arryPurchase[0]['PrepaidAmount'],2); 
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);


		echo '<div>';
			//echo '<br>Sub Total : '.$subtotal;
		
			echo '<br><br>Freight Cost : '.$Freight;
			if($arryPurchase[0]['PrepaidFreight']=='1' ){   
				echo '<br><br>Prepaid Freight : '.$PrepaidAmount;
			}
				echo '<br><br>'.$TaxCaption.' : '.$taxAmnt;
			echo '<br><br>Grand Total : '.$TotalAmount.'<br><br>';
		echo '</div>';




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
