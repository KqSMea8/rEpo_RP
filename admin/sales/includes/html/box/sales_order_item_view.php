<?php 
	if($arryCompany[0]['TrackInventory'] !=1){
		$style ='style="display:none;"';
		$numTd = 12;
	}else{
	       $numTd = 12;
	}
?>

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
<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td width="9%" class="heading" >SKU</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
		<td width="8%"  class="heading">Warehouse</td>
				<? }?>
		<?php if ($_SESSION['SelectOneItem']!='1'){?>
		<td width="8%"  class="heading">Condition</td>
				<? }?>
		<td width="3%" class="heading">Recurring</td>
                <td   class="heading">Description</td>
		<td width="8%" class="heading">Qty Ordered</td>
		<?if($module!='Quote' && $module!='CreditNote'){?>
		<!--td width="8%" class="heading">Qty Invoiced</td-->
		<?php }?>
                <!--td width="15%" class="heading">Serial Number</td-->
		<td width="8%"  class="heading">Unit Price</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
                <td width="4%" class="heading">Dropship</td>
                <? if(empty($_SESSION['UserData']['CustID'])){?><td width="6%" class="heading">Cost</td><?}?>
<? }?>
		<td width="6%" class="heading">Discount</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
		<td width="6%" class="heading">Taxable</td>
<? }?>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>

	<? 


if($_GET['ccav']==1){  echo"<pre>"; print_r($arrySaleItem);}

$subtotal=0;$TotalQtyReceived=0;$TotalQtyOrdered=0;$costofgood=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$total_received = $objSale->GetQtyInvoiced($arrySaleItem[$Count]["id"]);
		$total_received = $total_received[0]['QtyInvoiced'];
		$ordered_qty = $arrySaleItem[$Count]["qty"];

$childCount = $objSale->CounchildItem($arrySaleItem[$Count]["item_id"],$arrySaleItem[$Count]['OrderID']);
if($childCount>0 && $arrySaleItem[$Count]["Condition"]=='' ){
$arrySaleItem[$Count]["evaluationType"] ='';
}

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
  if($DropshipCheck =='No'){  $avgCost = $arrySaleItem[$Count]["avgCost"];     }else{ $avgCost = stripslashes($arrySaleItem[$Count]["DropshipCost"]); }

	?>

     <?php 
        //By chetan 21Mar2017 for color//
        
        if(!empty($arrySaleItem[$Count]['parent_item_id'])){
		$color = "style='background-color:#f5d6d6'";
        }else{
		if($arrySaleItem[$Count]['req_item']){
            		$color = (!empty($_GET['view'])||!empty($_GET['edit'])) ? "style='background-color:#EBF5FD'" : '';
		}else{
		$color = '';
		}
        }?>

     <tr class='itembg' <?=$color?>>
        <td><?=stripslashes($arrySaleItem[$Count]["sku"])?>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="../sales/reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display: none;" border="0" title="Additional Items"></a> </td>
 <?php if ($_SESSION['SelectOneItem']!='1'){?>
<td><div <?=$style?>><?=stripslashes($arrySaleItem[$Count]["warehouse_code"])?></div></td>
<? }?>
    <?php if ($_SESSION['SelectOneItem']!='1'){?>
<td><div <?=$style?>><?=stripslashes($arrySaleItem[$Count]["Condition"])?></div></td>
<? }?>


<td>
<? if($arrySaleItem[$Count]["RecurringCheck"] == 'on' &&  $arrySaleItem[$Count]["EntryType"]=='recurring'){ ?>
<a class="fancybox fancybox.iframe" href="../vEntryType.php?line=<?=$Line?>&view=<?=$arrySaleItem[$Count]['id']?>"  >Yes</a>
<? } ?>

</td>

<td><?=stripslashes($arrySaleItem[$Count]["description"])?>
<?php if(!empty($arrySaleItem[$Count]["FromDate"]) && $arrySaleItem[$Count]["FromDate"]>0){?>
<br><span class="heading">From Date:</span>&nbsp;
          <?php echo stripslashes($arrySaleItem[$Count]["FromDate"]); }?>
<?php if(!empty($arrySaleItem[$Count]["ToDate"])  && $arrySaleItem[$Count]["ToDate"]!="0000-00-00"){?><br>

<span class="heading">To Date:</span>&nbsp;<?php echo stripslashes($arrySaleItem[$Count]["ToDate"]); }?>

</td>
         <td><?=$arrySaleItem[$Count]["qty"]?></td>
	<?if($module!='Quote' && $module!='CreditNote'){?>
       <!--td><?=$arrySaleItem[$Count]["qty_invoiced"]?></td-->
	<?php }?>
      
       <td><?=number_format($arrySaleItem[$Count]["price"],2)?>

<?php if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){ ?>
<br>

<span class="red"> (<? echo round(GetConvertedAmount($arrySale[0]['ConversionRate'], $arrySaleItem[$Count]["price"]) ,2)." ".$Config['Currency'];?>)</span>

<? }?>

</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
       <td><?=$DropshipCheck;?></td>
       <? if(empty($_SESSION['UserData']['CustID'])){?><td><?=$avgCost?></td><?}?>
<? }?>
       <td style="color:red;"><?=number_format($arrySaleItem[$Count]["discount"],2)?></td>
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
       <td align="right"><?=number_format($arrySaleItem[$Count]["amount"],2)?>

<?php if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){ ?>
<br>

<span class="red"> (<? echo round(GetConvertedAmount($arrySale[0]['ConversionRate'], $arrySaleItem[$Count]["amount"]) ,2)." ".$Config['Currency'];?>)</span>

<? }?>

</td>
       
    </tr>
	<? 

/*
if($arrySaleItem[$Count]["DropshipCheck"]=="1"){
	$costofgood += $arrySaleItem[$Count]["DropshipCost"] * $arrySaleItem[$Count]["qty_invoiced"]; 
}else{
	if($arrySaleItem[$Count]["parent_item_id"]==0){
		$costofgood += $arrySaleItem[$Count]["avgCost"] * $arrySaleItem[$Count]["qty_invoiced"]; 
	}
}*/


if($arrySaleItem[$Count]["parent_item_id"]=="0"){
	$costofgood += $avgCost * $arrySaleItem[$Count]["qty_invoiced"]; 
}



		$subtotal += $arrySaleItem[$Count]["amount"];

		$TotalQtyReceived += $total_received;
		$TotalQtyOrdered += $ordered_qty;
		//echo "=>".$TotalQtyReceived."-".$TotalQtyOrdered;
	} ?>


     <tr class='itembg'>
        <td colspan="15" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		<?			
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight'];
		$ShipFreight = $arrySale[0]['ShipFreight']; 
		$TDiscount = $arrySale[0]['TDiscount'];
		
		$TotalAmount = $subtotal+$taxAmnt+$Freight+$ShipFreight-$TDiscount;
	
		

		if($arrySale[0]['MDType']=='Markup'){
			$TotalAmount = $TotalAmount + $arrySale[0]['CustDisAmt'];
		}else if($arrySale[0]['MDType']=='Discount'){
			$TotalAmount = $TotalAmount - $arrySale[0]['CustDisAmt'];
		}



		echo '<div>';
			echo '<br>Sub Total : '.number_format($subtotal,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $subtotal) ,2).' '.$Config['Currency'].')</span>';
}
if($arrySale[0]['MDType'] && $arrySale[0]['CustDisAmt']){
echo '<br><br>'.$arrySale[0]['MDType'].' : '.$arrySale[0]['CustDisAmt'];
}
		
			echo '<br><br>Freight : '.number_format($Freight,2);
			if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){
			 
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $Freight) ,2).' '.$Config['Currency'].')</span>';
}


			if($ShipFreight>0){echo '<br><br>Actual Freight : '.number_format($ShipFreight,2);}


			if($TDiscount>0){ ?>
			
	<br><br> Add'l Discount : <span style="color:red;">(<?=number_format($TDiscount,2)?>)</span>
		<?php }
			echo '<br><br>'.$TaxCaption.' : '.number_format($taxAmnt,2);
if($arrySale[0]['CustomerCurrency']!=$Config['Currency']){			 
			echo '<br><span class="red">('.round(GetConvertedAmount($arrySale[0]['ConversionRate'], $taxAmnt) ,2).' '.$Config['Currency'].')</span>';
}




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
