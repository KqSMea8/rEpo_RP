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
$TypeInfo = '<img src="'.$MainPrefix.'icons/help.png"  border="0"   onMouseover="ddrivetip(\''.SALES_RMA_TYPE_INFO.'\', 520,\'\')"; onMouseout="hideddrivetip()" >';

$styleCond='';
if($arryCompany[0]['TrackInventory'] !=1){ $styleCond ='style="display:none;"'; } ?>

<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
 <? if(sizeof($arrySaleItem)>0){ ?>
    <tr align="left"  >
		<td class="heading" >SKU</td>
<td width="8%" class="heading">Warehouse</td>
        <td width="8%" class="heading">Condition</td>
		<td 8 class="heading">Description</td>
		<td width="8%" class="heading">Serial Numbers</td>
		<td width="5%" class="heading">Type <?=$TypeInfo?></td>
		<td width="5%" class="heading">Action</td>
		<td width="5%" class="heading">Reason</td>
		<!--td width="8%" class="heading">Qty Ordered</td -->
		<td width="5%" class="heading">Qty Invoiced</td>
		<td width="5%" class="heading">Total RMA Qty</td>
		<td width="5%" class="heading">Qty RMA</td>
		<td width="5%"  class="heading">Unit Price</td>
		<td width="5%"  class="heading">Discount</td>
		<td width="5%" class="heading">Taxable</td>
		<? if($arrySale[0]['ReSt']=='1'){?>
		<td class="heading" width="5%" >Re-Stocking Fee</td>
		<? } ?>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>


	<? $subtotal=0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	

		$qty_ordered = $objrmasale->GetQtyOrderded($arrySaleItem[$Count]["ref_id"]);	
		$total_received = $objrmasale->GetQtyInvoicedRma($arrySaleItem[$Count]["ref_id"]);	

		$total_returned = $objrmasale->GetQtyReturned($arrySaleItem[$Count]["ref_id"]);	

		$totalRmaQty = $objrmasale->GetQtyRma($arrySaleItem[$Count]["ref_id"]);
		
		$RmaTypeVal = $objrmasale->RmaTypeValue($arrySaleItem[$Count]["Type"]);
	
	

		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}

		$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
		
		//$TotalRmaQty += $arrySaleItem[$Count]["qty_returned"];

	?>
     <tr class='itembg'>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?><a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>>&nbsp;&nbsp;<img src="../images/tab-new.png" border="0" title="Additional Items"></a> </td>
      <td><div <?=$styleCond?>><?=stripslashes($arrySaleItem[$Count]["warehouse_code"])?></div></td>   
 <td><div <?=$styleCond?>><?=stripslashes($arrySaleItem[$Count]["Condition"])?></div></td>
<td><?=stripslashes($arrySaleItem[$Count]["description"])?></td>
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
<td><?=stripslashes($arrySaleItem[$Count]["Action"])?></td>
<td><?=stripslashes($arrySaleItem[$Count]["Reason"])?></td>

       <!--td><?=$arrySaleItem[$Count]["qty"]?></td-->
         <td><?=$total_received?></td>
        <td><?=$totalRmaQty[0]['QtyRma']?></td>
        <td><?=$arrySaleItem[$Count]["qty"]?>
    <!--
            <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1 && $arrySaleItem[$Count]["evaluationType"] == 'Serialized'){ ?>
                    <br> <a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?= $Line ?>&total=<?=$arrySaleItem[$Count]["qty_returned"]?>&sku=<?=stripslashes($arrySaleItem[$Count]["sku"])?>&SerialValue=<?=$arrySaleItem[$Count]["SerialNumbers"]?>&view=1" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;View S.N.<a>
            <?php }?>
-->
       </td>
       <td><?=number_format($arrySaleItem[$Count]["price"],2)?>

<?php if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){ ?>
<br>

<span class="red"> (<? echo round(GetConvertedAmount($arrySale[0]['ConversionRate'], $arrySaleItem[$Count]["price"]) ,2)." ".$Config['Currency'];?>)</span>

<? }?>
</td>
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
	<? if($arrySale[0]['ReSt']=='1'){?>
		<td> <div <?=($arrySaleItem[$Count]['Type']=="C" || $arrySaleItem[$Count]['Type']=="AC")?(""):('style="display: none;"')?>  > <?=$arrySaleItem[$Count]['fee']?> </div> </td>
	<? } ?>
       <td align="right"><?=number_format($arrySaleItem[$Count]["amount"],2)?>


<?php if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){ ?>
<br>

<span class="red"> (<? echo round(GetConvertedAmount($arrySale[0]['ConversionRate'], $arrySaleItem[$Count]["amount"]) ,2)." ".$Config['Currency'];?>)</span>

<? }?>


</td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} 

	?>



     <tr class='itembg'>
        <td colspan="16" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	 
		$Freight = $arrySale[0]['Freight'];
		$ReStocking = '<span style="color:red;">('.number_format($arrySale[0]['ReStocking'],2).')</span>';
 
$TDiscount = "<span style='color:red;'>(".number_format($arrySale[0]['TDiscount'],2).")</span>";
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$TotalAmount = $arrySale[0]['TotalAmount'];


		echo '<div>';
			echo '<br>Sub Total : '.number_format($subtotal,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $subtotal) ,2).' '.$Config['Currency'].')</span>';
}			
			echo '<br><br>Freight : '.number_format($Freight,2);

if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			 
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $Freight) ,2).' '.$Config['Currency'].')</span>';
}


			if($arrySale[0]['ReSt']==1){
			echo '<br><br><span style="color:red;">Re-Stocking Fee</span> : '.$ReStocking;
			}
			echo "<br><br>Add'l Discount : ".$TDiscount;

			echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			 
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $taxAmnt) ,2).' '.$Config['Currency'].')</span>';
}


			echo '<br><br>Grand Total : '.number_format($TotalAmount,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			 
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $TotalAmount) ,2).' '.$Config['Currency'].')</span>';
}

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

