<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" >SKU</td>
		<td width="25%" class="heading">Description</td>
		<td width="10%" class="heading">Comments</td>
		<td width="10%" class="heading">Qty Ordered</td>
		
		<td width="10%"  class="heading">Unit Price</td>
		<td width="10%" class="heading">Discount</td>
		<td width="5%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>

	<? $subtotal=0;$TotalQtyReceived=0;$TotalQtyOrdered=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		//$total_received = $objSale->GetQtyInvoiced($arryQuoteProduct[$Count]["id"]);
		//$total_received = $total_received[0]['QtyInvoiced'];
		$ordered_qty = $arryQuoteProduct[$Count]["qty"];

	#if($arryQuote[0]['Taxable']=='Yes' && $arryQuote[0]['Reseller']!='Yes' && $arryQuoteProduct[$Count]['Taxable']=='Yes'){
	if($arryQuote[0]['tax_auths']=='Yes' && $arryQuoteProduct[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	$ReqDisplay = !empty($arryQuoteProduct[$Count]['req_item'])?(''):('style="display:none"');
	if(empty($arryQuoteProduct[$Count]['Taxable'])) $arryQuoteProduct[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
        <td><?=stripslashes($arryQuoteProduct[$Count]["sku"])?>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arryQuoteProduct[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a></td>
	 <td><?=stripslashes($arryQuoteProduct[$Count]["description"])?></td>

        <td><?=stripslashes($arryQuoteProduct[$Count]["DesComment"])?></td>


         <td><?=$arryQuoteProduct[$Count]["qty"]?></td>
      
       <td><?=number_format($arryQuoteProduct[$Count]["price"],2)?></td>
	   <td><?=number_format($arryQuoteProduct[$Count]["discount"],2)?></td>
       <td>
	<span style="display:<?=$TaxShowHide?>">
	<? /*if(!empty($arryQuoteProduct[$Count]["RateDescription"]))
				echo $arryQuoteProduct[$Count]["RateDescription"].' : ';
				echo number_format($arryQuoteProduct[$Count]["tax"],2);*/
			?>
	</span>  
	 <?=$arryQuoteProduct[$Count]['Taxable']?>
	   </td>
       <td align="right"><?=number_format($arryQuoteProduct[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$subtotal += $arryQuoteProduct[$Count]["amount"];

		//$TotalQtyReceived += $total_received;
		$TotalQtyOrdered += $ordered_qty;
		//echo "=>".$TotalQtyReceived."-".$TotalQtyOrdered;
	} ?>


     <tr class='itembg'>
        <td colspan="9" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?	

		$subtotal = number_format($subtotal,2,'.','');
		$taxAmnt = $arryQuote[0]['taxAmnt'];
		$Freight = $arryQuote[0]['Freight'];
		$CustDisAmt = $arryQuote[0]['CustDisAmt'];
	
	        $TotalAmount = $arryQuote[0]['TotalAmount'];
		
		echo '<div>';
			echo '<br>Sub Total : '.number_format($subtotal,2);
if($arryQuote[0]['MDType']){
echo '<br><br>'.$arryQuote[0]['MDType'].' : '.number_format($CustDisAmt,2);
}
			
			echo '<br><br>Freight : '.number_format($Freight,2);
			echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);
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
