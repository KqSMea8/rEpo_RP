<?php
if($arryCompany[0]['TrackInventory'] !=1){
		
		$numTd = 10;
	}else{
	       $numTd = 11;
	}
(empty($RecDis))?($RecDis=""):("");
$costofgood=0;
?>
<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td width="10%" class="heading" >SKU</td>

		<? if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){?>
		<td  class="heading" width="10%">Condition</td>
		<? }?>
		<td width="3%" class="heading">Recurring</td>
		<td  class="heading" width="15%">Description</td>
		<td width="10%" class="heading">Qty Invoiced</td>
<? if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){?>
                <td  class="heading">Serial Number</td>
<? }?>
		<td width="8%"  class="heading">Unit Price</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
                <td width="4%" class="heading">Dropship</td>
                <td width="8%" class="heading">Cost</td>
<? }?>
		<td width="8%" class="heading">Discount</td>
 
		<td width="6%" class="heading">Taxable</td>
 
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


 //if($arrySaleItem[$Count]["DropshipCheck"] == 1){ }$arrySaleItem[$Count]["avgCost"]
           if($arrySaleItem[$Count]["DropshipCheck"] != 1 ){ $avgCost = $arrySaleItem[$Count]["avgCost"];      }else{ $avgCost = stripslashes($arrySaleItem[$Count]["DropshipCost"]); }



	?>
     <tr class='itembg'>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="../sales/reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display: none;" border="0" title="Additional Items"></a> </td>

 <? if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){?><td><div><?=stripslashes($arrySaleItem[$Count]["Condition"])?></div></td>    <? }?>   



<td>
<? if($arrySaleItem[$Count]["RecurringCheck"] == 'on' &&  $arrySaleItem[$Count]["EntryType"]=='recurring'){ 

 
?>
<a class="fancybox fancybox.iframe" style="<?=$RecDis?>" href="../vEntryType.php?line=<?=$Line?>&view=<?=$arrySaleItem[$Count]['id']?>" id="controle<?=$Line?>" >Yes</a>
<? } ?>

</td>


<td><?=stripslashes($arrySaleItem[$Count]["description"])?>
<?php if(!empty($arrySaleItem[$Count]["FromDate"]) && $arrySaleItem[$Count]["FromDate"]>0){?>
<br><span class="heading">From Date:</span>&nbsp;
          <?php if(!empty($arrySaleItem[$Count]["FromDate"]) && $arrySaleItem[$Count]["FromDate"]!="0000-00-00") echo stripslashes($arrySaleItem[$Count]["FromDate"]); else echo '<span class="red">Not specified</span>'; } ?>
<?php if($arrySaleItem[$Count]["ToDate"]!="0000-00-00"){?>
<br>
<span class="heading">To Date:</span>&nbsp;<?php if(!empty($arrySaleItem[$Count]["ToDate"])  && $arrySaleItem[$Count]["ToDate"]!="0000-00-00")echo stripslashes($arrySaleItem[$Count]["ToDate"]);else echo '<span class="red">Not specified</span>';

}?>

</td>
       <td><?=$arrySaleItem[$Count]["qty_invoiced"]?></td>
<? if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){?>
       <td><?=$SerialNumbers;?></td>
<? }?>

       <td><?=number_format($arrySaleItem[$Count]["price"],2)?>

<?php if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){ ?>
<br>

<span class="red"> (<? echo round(GetConvertedAmount($arrySale[0]['ConversionRate'], $arrySaleItem[$Count]["price"]) ,2)." ".$Config['Currency'];?>)</span>

<? }?>


</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
       <td><?=$DropshipCheck;?></td>
       <td><?=number_format($avgCost,2)?></td>
<? }?>
	<td><span style"color:red"><?=number_format($arrySaleItem[$Count]["discount"],2)?></span></td>
 
       <td ><span style="display:<?=$TaxShowHide?>">
	
		</span>  
	  <?=$arrySaleItem[$Count]['Taxable']?>
	   </td>
 
       <td align="right"><?=number_format($arrySaleItem[$Count]["amount"],2)?>

<?php if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){ ?>
<br>

<span class="red"> (<? echo round(GetConvertedAmount($arrySale[0]['ConversionRate'], $arrySaleItem[$Count]["amount"]) ,2)." ".$Config['Currency'];?>)</span>

<? }?>

</td>
       
    </tr>
	<? 
		//$subtotal += $arrySaleItem[$Count]["amount"];
		
		//$TotalQtyReceived += $total_received;
		//$TotalQtyOrdered += $ordered_qty;

if($arrySaleItem[$Count]["DropshipCheck"]==1){
$costofgood += $arrySaleItem[$Count]["DropshipCost"] * $arrySaleItem[$Count]["qty_invoiced"]; 
}else{

$costofgood += $arrySaleItem[$Count]["avgCost"] * $arrySaleItem[$Count]["qty_invoiced"]; 
}
		$subtotal += $arrySaleItem[$Count]["amount"];

		$TotalQtyReceived += $total_received;
		$TotalQtyOrdered += $ordered_qty;
		//echo "=>".$TotalQtyReceived."-".$TotalQtyOrdered;
	} 


		//echo "=>".$TotalQtyReceived."-".$TotalQtyOrdered;
	//} 


?>


     <tr class='itembg'>
        <td colspan="12" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?	
		
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight'];
		$CustDisAmt = $arrySale[0]['CustDisAmt'];
$TDiscount = $arrySale[0]['TDiscount'];
		$TotalAmount = $subtotal+$taxAmnt+$Freight-$TDiscount;

		if($arrySale[0]['MDType']=='Markup'){
			$TotalAmount = $TotalAmount + $CustDisAmt;
		}else if($arrySale[0]['MDType']=='Discount'){
			$TotalAmount = $TotalAmount - $CustDisAmt;
		}


	
		echo '<div>';
			echo '<br>Sub Total : '.number_format($subtotal,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $subtotal) ,2).' '.$Config['Currency'].')</span>';
}


if($arrySale[0]['MDType']!='' && $CustDisAmt>0){
	echo '<br><br>'.$arrySale[0]['MDType'].' : '.number_format($CustDisAmt,2);
}
			echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);

if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){
			 
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $taxAmnt) ,2).' '.$Config['Currency'].')</span>';
}

			echo '<br><br>Freight : '.number_format($Freight,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			 
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $Freight) ,2).' '.$Config['Currency'].')</span>';
}


?>
		<br><br> Add'l Discount : <span style"color:red">(<?=number_format($TDiscount,2)?>)</span>
			<? 

echo '<br><br>Grand Total : '.number_format($TotalAmount,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			 
		echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $TotalAmount) ,2).' '.$Config['Currency'].')</span>';
}



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

<script>
function pop(div) {

				document.getElementById(div).style.display = 'block';
			}
			function hide(div) {
				document.getElementById(div).style.display = 'none';
			}
			//To detect escape button
			document.onkeydown = function(evt) {
				evt = evt || window.event;
				if (evt.keyCode == 27) {
					hide('mrgn');
				}
			};

	jQuery(document).ready(function(){
		
		jQuery(".close-mgn").click(function(){
			//alert("hiii");
			jQuery("div#mrgn").css({"display":"none"});
		});
	});
</script>
<? echo '<script>SetInnerWidth();</script>'; ?>
