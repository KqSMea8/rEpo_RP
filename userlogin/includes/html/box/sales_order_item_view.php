<?php  if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:none;"'; } ?>
<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" >SKU</td>
<? if($_SESSION['SelectOneItem'] != 1){ ?>
                 <td width="10%" class="heading">Condition</td>
<? }?>
		<td width="13%" class="heading">Description</td>
		<td width="10%" class="heading">Comments</td>
		<td width="10%" class="heading">Qty Ordered</td>
		<?if($module!='Quote'){?>
		<td width="10%" class="heading">Qty Invoiced</td>
		<?php }?>
		<td width="10%"  class="heading">Unit Price</td>
<? if($_SESSION['SelectOneItem'] != 1){ ?>
                <td width="4%" class="heading">Dropship</td>

                <td width="8%" class="heading">Cost</td><? }?>
		<td width="10%" class="heading">Discount</td>
		<td width="8%" class="heading">Taxable</td>
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


		if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
        <td valign="top"><?=stripslashes($arrySaleItem[$Count]["sku"])?>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display: none;" border="0" title="Additional Items"></a> </td>
 <? if($_SESSION['SelectOneItem'] != 1){ ?>       
<td valign="top"><div <?=$style?>><?=stripslashes($arrySaleItem[$Count]["Condition"])?></div></td>
<? }?>
<td valign="top"><?=stripslashes($arrySaleItem[$Count]["description"])?>
<td><?=stripslashes($arrySaleItem[$Count]["DesComment"])?></td>
	<?
	/********************
	$RequiredItem = stripslashes($arrySaleItem[$Count]['req_item']);
	if(!empty($RequiredItem)){
		$arryReqItem = explode("#",$RequiredItem);
		$Count=0;
		foreach($arryReqItem as $values_sal){
			$arryTemp = explode("|",$values_sal);
			echo '<br>- '. $arryTemp[2].' : '.$arryTemp[3];
			$Count++;
		}
	}
	/********************/
	?>
	</td>
         <td><?=$arrySaleItem[$Count]["qty"]?></td>
	<?if($module!='Quote'){?>
       <td><?=$arrySaleItem[$Count]["qty_invoiced"]?></td>
	<?php }?>
       <td><?=number_format($arrySaleItem[$Count]["price"],2)?></td>
<? if($_SESSION['SelectOneItem'] != 1){ ?>
       <td><?=$DropshipCheck;?></td>

       <td><?=number_format($arrySaleItem[$Count]["DropshipCost"],2)?></td>
<? }?>
       <td><?=number_format($arrySaleItem[$Count]["discount"],2)?></td>
       <td ><span style="display:<?=$TaxShowHide?>">
	<? /* if(!empty($arrySaleItem[$Count]["RateDescription"]))
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

		$TotalQtyReceived += $total_received;
		$TotalQtyOrdered += $ordered_qty;
		//echo "=>".$TotalQtyReceived."-".$TotalQtyOrdered;
	} ?>


     <tr class='itembg'>
        <td colspan="14" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?	
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arrySale[0]['Freight'],2);
		$taxAmnt = number_format($arrySale[0]['taxAmnt'],2);
		$TotalAmount = number_format($arrySale[0]['TotalAmount'],2);


			
		echo '<div>';
			echo '<br>Sub Total : '.$subtotal;
if($arrySale[0]['MDType']!=''){

echo '<br><br>'.$arrySale[0]['MDType'].' : '.$arrySale[0]['CustDisAmt'];
}
			echo '<br><br>Tax : '.$taxAmnt;
			echo '<br><br>Freight : '.$Freight;
			echo '<br><br>Grand Total : '.$TotalAmount;
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
