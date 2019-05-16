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
 <? if(sizeof($arrySaleItem)>0){
#echo "<pre>";
#print_r($arrySaleItem);
#echo "</pre>";
#echo $arrySaleItem[0]["SerialNumbers"];

 ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td width="7%" class="heading">Condition</td>
		<td width="10%" class="heading">Description</td>
		<td width="10%" class="heading">Comment</td>
		<td width="8%" class="heading">Qty Ordered</td>
		<td width="7%" class="heading">Qty Invoiced</td>
		<td width="7%" class="heading">Qty shipped</td>
		<td width="8%" class="heading">S.N.</td>
		<td width="8%"  class="heading">Unit Price</td>
		<td width="8%"  class="heading">Discount</td>
		<td width="8%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$qty_ordered = $objSale->GetQtyOrderded($arrySaleItem[$Count]["ref_id"]);	
		$total_received = $objSale->GetQtyReceived($arrySaleItem[$Count]["ref_id"]);	

$childCount = $objShipment->CounchildItem($arrySaleItem[$Count]["item_id"],$arrySaleItem[$Count]['OrderID']);
if($childCount>0){
$arrySaleItem[$Count]["evaluationType"] ='';
}


		$total_shipped = $objShipment->GetQtyShipped($arrySaleItem[$Count]["ref_id"]);
//echo $Count;
//echo stripslashes($arrySaleItem[$Count]["SerialNumbers"]; exit;
		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}

		#$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
		$ReqDisplay = 'style="display:none"';

	?>
     <tr class='itembg'>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?><a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>>&nbsp;&nbsp;<img src="../images/tab-new.png" border="0" title="Additional Items"></a> </td>
 <td><?=stripslashes($arrySaleItem[$Count]["Condition"])?></td>
        <td><?=stripslashes($arrySaleItem[$Count]["description"])?></td>
 <td><?=stripslashes($arrySaleItem[$Count]["DesComment"])?></td>
       <td><?=$arrySaleItem[$Count]["qty"]?></td>
         <td><? if($arryShip[0]['ShipmentStatus']=='Shipped') { echo $arrySaleItem[$Count]["qty_shipped"]; }?></td>
        <td><?=$arrySaleItem[$Count]["qty_shipped"]?></td>
        <td><?php //echo stripslashes($arrySaleItem[$Count]["SerialNumbers"])?>
<? if($childCount == 0){?>
<a id="showpopup" style="cursor:pointer;" onclick ="popSn('mrgn<?=$Line?>');">View S.N.</a>
<?}?>
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
</div></div></div>




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

 <input type="hidden" name="TotalAmount" id="TotalAmount" value="<?=$arrySale[0]['TotalAmount']?>" readonly  />
		<?	
		$subtotal = number_format($subtotal,2);
		
		$Freight = number_format($arrySale[0]['Freight'],2);
		$TDiscount = number_format($arrySale[0]['TDiscount'],2);
		$taxAmnt = number_format($arrySale[0]['taxAmnt'],2);
		$TotalAmount = number_format($arrySale[0]['TotalAmount'],2);
 

		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;

			if($arrySale[0]['ActualFreight']>0){			 
				echo '<br><br>Actual Freight : '.number_format($arrySale[0]['ActualFreight'],2);
			}
			
			echo '<br><br>Freight : '.$Freight;
			if($TDiscount>0){
				echo "<br><br>Add'l Discount : <span class=red>(".$TDiscount.")</span>";
			}

			echo '<br><br>'.$TaxCaption.' : '.$taxAmnt;
			echo '<br><br>Grand Total : '.$TotalAmount.'<br><br>';
		echo '</div>';

		?>
		<?php
		if(!empty($RtnInvoiceMess)){
		 echo '<div class=redmsg style="float:left">'.$RtnInvoiceMess.'</div>';
		}
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
