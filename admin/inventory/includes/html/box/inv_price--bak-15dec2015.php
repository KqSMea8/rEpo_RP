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

	<td width="15%"  class="head1"> Price</td>
	<td width="15%"  class="head1"> Currency</td>


	<td width="15%"  class="head1"> <?=$Config['Currency']?> Price</td>



	</tr>

	<?php
	if (is_array($arryItemOrder) && $num > 0) {
	$flag = true;
	$Line = 0;
	foreach ($arryItemOrder as $key => $values) {
	$flag = !$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	//if($values['Status']<=0){ $bgcolor="#000000"; }
	?>
	<tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
	

	<td> <a class="fancybox supp fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a></td>
	<td><?= date($Config['DateFormat'] , strtotime($values['OrderDate'])); ?></td>

	<td><?=$values['price']; ?></td>

	<td><?=$values['Currency']; ?></td>


	<td> <?php 
	if($values['Currency']!=$Config['Currency']){
	$NetPrice=CurrencyConvertor($values['price'],$values['Currency'],$Config['Currency']);
	}else{
	$NetPrice=$values['price'];
	}
	echo number_format($NetPrice,2);?></td>

	</tr>
	<?php } // foreach end // ?>



	<?php } else { ?>
	<tr >
	<td  colspan="5" class="no_record">No Records found.</td>
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
	<td colspan="2" align="left" class="head">Item Price </td>
	</tr>
	<tr>
	<td align="right"  class="blackbold">Average Cost :</td>
	<td align="left"  class="blacknormal">
	<input  name="average_cost" id="average_cost" readonly value="<? echo $avgCost; ?>" type="text"  class="disabled"  size="10" maxlength="10" /> <?=$Config['Currency']?></td>
	</tr>

	<tr>
	<td align="right"  class="blackbold">Last Cost :</td>
	<td align="left"  class="blacknormal">
	<input  name="last_cost" id="last_cost" value="<? echo $lastPrice; ?>" type="text"  class="disabled" readonly  size="10" maxlength="10" /> <?=$Config['Currency']?></td>

	</tr>

	<input  name="purchase_cost" id="purchase_cost" onkeypress="return isDecimalKey(event);" value="<? echo $avgCost; ?>" type="hidden"  class="hidden"  size="10" maxlength="10" />
	<!--tr>
	<td align="right"  class="blackbold">Item Price  :</td>
	<td align="left"  class="blacknormal">
	<input  name="purchase_cost" id="purchase_cost" onkeypress="return isDecimalKey(event);" value="<? echo $avgCost; ?>" type="text"  class="hidden"  size="10" maxlength="10" /> <?=$Config['Currency']?> </td>
	</tr-->


	<tr>
	<td align="right"  class="blackbold">Sell Price :</td>
	<td align="left"  class="blacknormal">
	<input  name="sell_price" id="sell_price" onkeypress="return isDecimalKey(event);" value="<? echo $arryProduct[0]['sell_price']; ?>" type="text"  class="textbox"  size="10" maxlength="10" />  <?=$Config['Currency']?></td>

	</tr>
