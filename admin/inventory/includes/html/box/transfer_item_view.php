
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

<? $bgcolor="#FFFFFF"; ?>	


 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="head1" width="10%" >SKU</td>
<td width="15%" class="head1" >Condition</td>
		<td width="22%" class="head1" >Description</td>
		<td width="10%" class="head1" >Transfer Qty</td>
		<td width="13%" class="head1" >Serial Num.</td>
		<td width="12%"  class="head1" >Value</td>
		
		<td width="12%" class="head1" align="right" >Total Value</td>
    </tr>

	<? $TotalQty=$TotalVal=0;$total_received=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		//$total_received = $objPurchase->GetQtyReceived($arryTransferItem[$Count]["id"]);
		$ordered_qty = $arryTransferItem[$Count]["qty"];
	?>
     <tr class="itembg">
        <td><?=stripslashes($arryTransferItem[$Count]["sku"])?></td>
        <td><?=stripslashes($arryTransferItem[$Count]["Condition"])?></td>
        <td><?=stripslashes($arryTransferItem[$Count]["description"])?></td>
         <td><?=$arryTransferItem[$Count]["qty"]?></td>



<td>

<?php //echo stripslashes($arrySaleItem[$Count]["SerialNumbers"])?>
<? //if($childCount == 0){?>
<a id="showpopup" style="cursor:pointer;" onclick ="popSn('mrgn<?=$Line?>');">View S.N.</a>
<?//}?>
<div id="mrgn<?=$Line?>" style="display:none;  background-attachment: scroll;background-clip: border-box;background-color: rgba(0, 0, 0, 0.45); background-image: none;background-origin: padding-box;background-position: 0 0;background-repeat: repeat;background-size: auto auto;bottom: 0;box-sizing: border-box;    left: 0;opacity: 1;position: fixed;right: 0;top: 0;"  class="ontop" >

<div class="inner-mrgn">
<div class="close-mgn" ><i class="fa fa-times" onclick="closeSN('mrgn<?=$Line?>');" aria-hidden="true"></i></div>
<div class="popup-header">Serial Number List</div>
<div style="width: 317px; height: 376px; overflow-y: scroll;">
<table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">

<?php 

$SN = explode(",",$arryTransferItem[$Count]["serial_value"]);
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
       <!--<td><?=number_format($total_received)?></td>-->
       <td><?=number_format($arryTransferItem[$Count]["price"],2)?></td>
       
       <td align="right"><?=number_format($arryTransferItem[$Count]["price"]*$arryTransferItem[$Count]["qty"],2)?></td>
       
    </tr>
	<? 
		$TotalQty += $arryTransferItem[$Count]["qty"];

		$TotalVal += $arryTransferItem[$Count]["price"]*$arryTransferItem[$Count]["qty"];
		//$TotalQtyLeft += ($ordered_qty - $total_received);

	} ?>


     <tr class="itembg">
        <td colspan="9" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		#echo $TotalQtyReceived.'-'.$TotalQtyLeft;
		#if($TotalQtyLeft<=0){
			#echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
		#}


		$TotalQty = number_format($TotalQty,2);
		
		$TotalValue = number_format($TotalVal,2);
		?>
		<br>
		 Total Quantity: <?=$TotalQty?>
		
		<br><br>
		Total Value : <?=$TotalValue?>
		<br><br>
        </td>
    </tr>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
