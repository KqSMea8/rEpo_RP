<?php 
	if($arryCompany[0]['TrackInventory'] !=1){
		$style ='style="display:none;"';
		$numTd = 12;
	}else{
	       $numTd = 12;
	}
?>
<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td width="9%" class="heading" >SKU</td>
		<?php if ($_SESSION['SelectOneItem']!='1'){?>
		<td width="8%"  class="heading">Condition</td>
				<? }?>
                <td   class="heading">Description</td>
		<td width="8%" class="heading">Qty Ordered</td>
		<?if($module!='Quote' && $module!='CreditNote'){?>
		<td width="8%" class="heading">Qty Invoiced</td>
		<?php }?>
                <td width="15%" class="heading">Serial Number</td>
		<td width="8%"  class="heading">Unit Price</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
                <td width="4%" class="heading">Dropship</td>
                <td width="6%" class="heading">Cost</td>
<? }?>
		<td width="6%" class="heading">Discount</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
		<td width="6%" class="heading">Taxable</td>
<? }?>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>

	<? $subtotal=0;$TotalQtyReceived=0;$TotalQtyOrdered=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$total_received = $objSale->GetQtyInvoiced($arrySaleItem[$Count]["id"]);
		$total_received = $total_received[0]['QtyInvoiced'];
		$ordered_qty = $arrySaleItem[$Count]["qty"];

		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}
		$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
                
                  if($arrySaleItem[$Count]["DropshipCheck"] == 1){
                    $DropshipCheck = 'Yes';
                }else{
                    $DropshipCheck = 'No';
                }
                
                  $SerialNumbers = preg_replace('/\s+/', ' ', $arrySaleItem[$Count]["SerialNumbers"]);
if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="../sales/reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display: none;" border="0" title="Additional Items"></a> </td>
    <?php if ($_SESSION['SelectOneItem']!='1'){?>
<td><div <?=$style?>><?=stripslashes($arrySaleItem[$Count]["Condition"])?></div></td>
<? }?>

<td><?=stripslashes($arrySaleItem[$Count]["description"])?>
<?php if(!empty($arrySaleItem[$Count]["FromDate"]) && $arrySaleItem[$Count]["FromDate"]>0){?>
<br><span class="heading">From Date:</span>&nbsp;
          <?php echo stripslashes($arrySaleItem[$Count]["FromDate"]); }?>
<?php if(!empty($arrySaleItem[$Count]["ToDate"])  && $arrySaleItem[$Count]["ToDate"]!="0000-00-00"){?><br>

<span class="heading">To Date:</span>&nbsp;<?php echo stripslashes($arrySaleItem[$Count]["ToDate"]); }?>

</td>
         <td><?=$arrySaleItem[$Count]["qty"]?></td>
	<?if($module!='Quote' && $module!='CreditNote'){?>
       <td><?=$arrySaleItem[$Count]["qty_invoiced"]?></td>
	<?php }?>
        <td><?=$SerialNumbers;?></td>
       <td><?=number_format($arrySaleItem[$Count]["price"],2)?></td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
       <td><?=$DropshipCheck;?></td>
       <td><?=number_format($arrySaleItem[$Count]["DropshipCost"],2)?></td>
<? }?>
       <td><?=number_format($arrySaleItem[$Count]["discount"],2)?></td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
       <td ><span style="display:<?=$TaxShowHide?>">
	<? /*if(!empty($arrySaleItem[$Count]["RateDescription"]))
				echo $arrySaleItem[$Count]["RateDescription"].' : ';
				echo number_format($arrySaleItem[$Count]["tax"],2);
		*/
		
		?>
		</span>  
	 <?=$arrySaleItem[$Count]['Taxable']?>
	   </td>
<? }?>
       <td align="right"><?=number_format($arrySaleItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];

		$TotalQtyReceived += $total_received;
		$TotalQtyOrdered += $ordered_qty;
		//echo "=>".$TotalQtyReceived."-".$TotalQtyOrdered;
	} ?>


     <tr class='itembg'>
        <td colspan="14" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?			
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight'];
		$TDiscount = $arrySale[0]['TDiscount'];
		
		$TotalAmount = $subtotal+$taxAmnt+$Freight-$TDiscount;
	
		

		if($arrySale[0]['MDType']=='Markup'){
			$TotalAmount = $TotalAmount + $arrySale[0]['CustDisAmt'];
		}else if($arrySale[0]['MDType']=='Discount'){
			$TotalAmount = $TotalAmount - $arrySale[0]['CustDisAmt'];
		}



		echo '<div>';
			echo '<br>Sub Total : '.number_format($subtotal,2);
if($arrySale[0]['MDType']){
echo '<br><br>'.$arrySale[0]['MDType'].' : '.$arrySale[0]['CustDisAmt'];
}
			echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);
			echo '<br><br>Freight : '.number_format($Freight,2);
			echo '<br><br>Total Discount : '.number_format($TDiscount,2);
			echo '<br><br>Grand Total : '.number_format($TotalAmount,2);
		echo '</div>';

		

		/*if($TotalQtyReceived == $TotalQtyOrdered){
			echo '<div class=redmsg style="float:left">'.ALL_INVOICE_ITEM.'</div>';
		}*/

		?>


        </td>
    </tr>
</table>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });

});

</script>
<? echo '<script>SetInnerWidth();</script>'; ?>
