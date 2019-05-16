<tr>
	<td colspan="2"    class="blackbold">Item Sku : 
	<?=$arryProduct[0]['Sku']?></td>

	</tr>
	<td colspan="2"    class="blackbold">Item Description : 
	<?=stripslashes($arryProduct[0]['description'])?></td>

	</tr>

	<tr>
	<td colspan="2" align="left" class="head">Vendor Price List  </td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">


	<tr align="left">
	
	<td width="15%"  class="head1"> Vendor</td>
	<td width="15%"  class="head1">Date</td>
	<td width="15%"  class="head1"> Qty Received</td>
	<td width="15%"  class="head1"> Unit Price</td>
	 


	<td width="15%"  class="head1"> Net Price [<?=$Config['Currency']?>]</td>



	</tr>

	<?php
	if (is_array($arryItemOrder) && $num > 0) {
	$flag = true;
	$Line = 0;
	foreach ($arryItemOrder as $key => $values) {
	$flag = !$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$ItemCost = round($values['ItemCost'],2);
	?>
	<tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
	

	<td> <a class="fancybox supp fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a></td>
	<td><?= date($Config['DateFormat'] , strtotime($values['PostedDate'])); ?></td>
	<td><?=$values['qty_received']?></td>
	<td><?=number_format($ItemCost,2)?> <?=$values['Currency']; ?></td>

	 


	<td> <?php 
	
	if($values['Currency']!=$Config['Currency']){
		$ConversionRate=$values['ConversionRate']; //from db
		if(empty($ConversionRate)){
			$ConversionRate = 1;		
		}
		/*if(empty($arryCurrencyVal[$values['Currency']])){
			$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
			$arryCurrencyVal[$values['Currency']]=$ConversionRate;			
		}else{
			$ConversionRate=$arryCurrencyVal[$values['Currency']];
		}*/
	}else{
		$ConversionRate = 1;
	}

	 
#echo $ConversionRate."+";
	$NetPrice = GetConvertedAmount($ConversionRate, $ItemCost);

	echo number_format($NetPrice,2);?></td>

	</tr>
	<?php
		$avgTotCost += $NetPrice;
		$totalQty +=$values['qty_received'];		 

		} // foreach end 
		 $avrageCost = $avgTotCost/$totalQty ; 
 
	?>



	<?php } else { ?>
	<tr >
	<td  colspan="6" class="no_record">No Records found.</td>
	</tr>

	<?php } ?>



	<tr >  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryItemOrder) > 0) { ?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}
	?></td>
	</tr>






	</table>
	</div>


	<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">



	</td>
	</tr>

<tr>
	<td colspan="2" align="left" class="head">Adjustments Price List  </td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">


	<tr align="left">
	
	<td width="15%"  class="head1"> Adjustment</td>
	<td width="15%"  class="head1">Date</td>
	<td width="15%"  class="head1"> Qty Received</td>
	<td width="15%"  class="head1"> Unit Price</td>
	 


	<td width="15%"  class="head1"> Net Price [<?=$Config['Currency']?>]</td>



	</tr>

	<?php
	if (is_array($arryIAdjOrder) && count($arryIAdjOrder) > 0) {
	$flag = true;
	$Line = 0;
	foreach ($arryIAdjOrder as $key => $values2) {
	$flag = !$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	 $ItemCost2 = round($values2['ItemCost'],2);
	?>
	<tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
	

	<td> <a  ><?=stripslashes($values2["OrderID"])?></a></td>
	<td><? if($values2['PostedDate']>0){ echo date($Config['DateFormat'] , strtotime($values2['PostedDate']));} ?></td>
	<td><?=$values2['qty_received']?></td>
	<td><?=number_format($ItemCost2,2)?> <?=$values2['Currency']; ?></td>

	 


	<td> <?php 
	
	if($values2['Currency']!=$Config['Currency']){
		$ConversionRate2=$values2['ConversionRate']; //from db
		if(empty($ConversionRate2)){
			$ConversionRate2 = 1;		
		}
		/*if(empty($arryCurrencyVal[$values['Currency']])){
			$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
			$arryCurrencyVal[$values['Currency']]=$ConversionRate;			
		}else{
			$ConversionRate=$arryCurrencyVal[$values['Currency']];
		}*/
	}else{
		$ConversionRate2 = 1;
	}

	$NetPrice2 =  $ItemCost2;
	 
	//$NetPrice2 = round(GetConvertedAmount($ConversionRate2, $ItemCost2),2);

	echo number_format($NetPrice2,2);?></td>

	</tr>
	<?php
		$avgTotCost2 += $NetPrice2;
		$totalQty2 +=$values2['qty_received'];		 

		} // foreach end 
		//$avrageCost2 = $avgTotCost2/$num2 ;
//echo $avgCost = $avgTotCost+$avgTotCost2;
// echo $totalNum = $num+$num2;


 $avrageCost = ($avgTotCost+$avgTotCost2)/($num+$num2);







	?>



	<?php } else { ?>
	<tr >
	<td  colspan="6" class="no_record">No Records found.</td>
	</tr>

	<?php } ?>



	<tr >  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo $num2; ?>      <?php if (count($arryItemOrder) > 0) { ?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}
	?></td>
	</tr>
</table>
</td>
	</tr>

	<tr>
	<td colspan="2" align="left" class="head">Item Price </td>
	</tr>

<?php if($_SESSION['SelectOneItem'] == 0){ ?>
<tr>
	<td align="right"  class="blackbold">Condition :</td>
	<td align="left"  class="blacknormal">
<select name="Condition" id="Condition" class="textbox"  <?php if($_GET['edit']>0){ ?>onchange="getConditionCost(this.value)" <?php }?> style="width:110px;"><option value="" <?=$selectCond?>>Select</option><?=$ConditionSelectedDrop?></select>
</td>
	</tr>
<? }?>
	<tr>
	<td align="right"  class="blackbold">Average Cost :</td>
	<td align="left"  class="blacknormal">
	<input  name="average_cost" id="average_cost" readonly value="<? echo $avgCost;  ?>" type="text"  class="disabled"  size="13" maxlength="10" /> <?=$Config['Currency']?></td>
	</tr>

	<tr>
	<td align="right"  class="blackbold">Last Cost :</td>
	<td align="left"  class="blacknormal">
	<input  name="last_cost" id="last_cost" value="<? echo $lastPrice; ?>" type="text"  class="disabled" readonly  size="13" maxlength="10" /> <?=$Config['Currency']?></td>

	</tr>

	
	<!--tr>
	<td align="right"  class="blackbold">Cost of good  :</td>
	<td align="left"  class="blacknormal">
	<input  name="purchase_cost" id="purchase_cost" onkeypress="return isDecimalKey(event);" class="disabled" value="<? echo round($avgCost,2);?>" type="text"    size="10" maxlength="10" /> <?=$Config['Currency']?> </td>
	</tr-->


	<tr>
	<td align="right"  class="blackbold">Sell Price :</td>
	<td align="left"  class="blacknormal">
	<input  name="sell_price" id="sell_price" onkeypress="return isDecimalKey(event);" value="<? echo $arryProduct[0]['sell_price']; ?>" type="text"  class="textbox"  size="13" maxlength="10" />  <?=$Config['Currency']?></td>

	</tr>
