<?   if(empty($arryProduct[0]['pricetype'])) $arryProduct[0]['pricetype']='';
 ?>
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
$totalQty = $avgTotCost = $avgTotCost2 = $totalQty2 = $num = $num2 ='0';  
$avrageCost=0; $avrageCost2=0;

	if (is_array($arryItemOrder) && $NumCount1>0) {
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

		if($totalQty>0){
		 	$avrageCost = $avgTotCost/$totalQty ; 
		}
 
	?>



	<?php } else { ?>
	<tr >
	<td  colspan="6" class="no_record">No Records found.</td>
	</tr>

	<?php } ?>


<tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $NumCount1; ?>      <?php if (count($arryItemOrder) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                  






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

		//if($num2>0)
			//$avrageCost2 = $avgTotCost2/$num2 ;
		//echo $avgCost = $avgTotCost+$avgTotCost2;
		 
	$totalNum = $num+$num2;



	if($totalNum>0){
 		$avrageCost = ($avgTotCost+$avgTotCost2)/($num+$num2);
	}






	?>



	<?php } else { ?>
	<tr >
	<td  colspan="6" class="no_record">No Records found.</td>
	</tr>

	<?php } ?>



	<tr >  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo count($arryItemOrder) ?>     

	</td>
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


<!--by chetan 13Feb//updated 24feb2017-->
	<tr>
	<td align="right"  class="blackbold">Price :</td>
	<td align="left"  class="blacknormal">
	<select name="pricetype" id="pricetype" class="pricetype" class="textbox" style="width:110px;">
	<option value="">Select</option>
	<option value="fixed" <? if($arryProduct[0]['pricetype'] == 'fixed'){ echo "selected"; }?>>Fixed</option>
	<option value="percentage" <? if($arryProduct[0]['pricetype'] == 'percentage'){ echo "selected"; }?>>Percentage</option>
	<option value="range" <? if($arryProduct[0]['pricetype'] == 'range'){ echo "selected"; }?>>Range</option>
	</select>
	<? if($arryProduct[0]['pricetype']!='range' || $arryProduct[0]['pricetype']== ''){?>
	<input style="display:none" name="fprice[]" id="fprice" value="<? if(isset($arryProduct[0]['fprice'])) echo number_format($arryProduct[0]['fprice'],2); ?>" type="text" placeholder="price"  class="textbox fprice"  size="10" maxlength="10" />  
	<input style="display:none;width:50px" placeholder="price %" name="prpercent[]" id="prpercent" value="<? if(isset($arryProduct[0]['prpercent'])) echo $arryProduct[0]['prpercent']; ?>" type="text"  class="textbox prpercent" maxlength="3" />
	<? }?>
	</td>
	</tr>
	<? if($arryProduct[0]['pricetype'] == 'range' && $arryProduct[0]['pricetype']!= ''){
		$qtyfrom 	= explode(',',$arryProduct[0]['qtyfrom']);
		$qtyto	 	= explode(',',$arryProduct[0]['qtyto']);	
		$fprice 	= explode(',',$arryProduct[0]['fprice']);
		$prpercent	= explode(',',$arryProduct[0]['prpercent']);	
		$count 		= count($qtyfrom);
		for($i=0;$i<$count;$i++){
	?>
		<tr id='qtyRange<?=$i?>' class="qtyRange">
		<td align="right"  class="blackbold">&nbsp;</td>
		<td align="left"  class="blacknormal" style="width:120px;float:left">	<label>Qty From :</label>
		<input style="width:50px;" placeholder="QtyFrom" name="qtyfrom[]" id="qtyfrom" value="<? if($qtyfrom[$i] != '0') echo $qtyfrom[$i]; ?>" type="text"  class="textbox qtyfrom" maxlength="4" />
		</td>
	
		<td align="left"  class="blacknormal" style="float:left">	<label>Qty To :	</label>
		<input style="width:50px;margin-left:3px;margin-right:5px" placeholder="Qty To" name="qtyto[]" id="qtyto" value="<? if($qtyto[$i] != '0') echo $qtyto[$i]; ?>" type="text"  class="textbox qtyto" maxlength="4" />
		<input style="width:50px;" placeholder="price %" name="prpercent[]" id="prpercent" value="<? if($prpercent[$i] != '0') echo $prpercent[$i]; ?>" type="text" class="textbox prpercent" maxlength="3" />		
		<input  name="fprice[]" id="fprice" value="<? if($fprice[$i] != '0') echo $fprice[$i]; ?>" type="text" placeholder="price"  size="10" maxlength="10" <? if($prpercent[$i]){?> readonly='readonly' class="textbox fprice disabled" <? }else{ ?> class="textbox fprice" <? }?>/>  	
<? if($i>=1){?> <img src="../images/delete-161.png" class="rangDel" style="cursor:pointer"> <? }?>
<? if($count-$i==1){?>		<a href="javascript:;" class="add_row" id="addmore">Add More</a> <?}?>

		</td>
		</tr>
		

	<? } }else{?>
		<tr id='qtyRange' class="qtyRange" style="display:none;">
		<td align="right"  class="blackbold">&nbsp;</td>
		<td align="left"  class="blacknormal" style="width:120px;float:left">	<label>Qty From :</label>
		<input style="width:50px;" placeholder="QtyFrom" name="qtyfrom[]" id="qtyfrom" value="<? if(isset($arryProduct[0]['qtyfrom'])) echo $arryProduct[0]['qtyfrom']; ?>" type="text"  class="textbox qtyfrom" maxlength="4" />
		</td>
	
		<td align="left"  class="blacknormal" style="float:left">	<label>Qty To :	</label>
		<input style="width:50px;margin-left:3px;margin-right:5px" placeholder="Qty To" name="qtyto[]" id="qtyto" value="<? if(isset($arryProduct[0]['qtyto'])) echo $arryProduct[0]['qtyto']; ?>" type="text"  class="textbox qtyto" maxlength="4" />
		
		</td>
		</tr>
	<? }?>

<script type="text/javascript">
$(document).on('keyup','.prpercent,.fprice',function(){
		if($(this).prop('readonly')===false){ 
			//$new = $(this).val().replace(/[^0-9]/g, '');
			$new = $(this).val();
			$(this).val($new);
		}
		if($(this).attr('id') == 'prpercent'){  
		if($(this).val()!='')
		{
			$(this).next('.fprice').addClass('disabled').attr('readonly',true);		
			$prout = (Number($('#sell_price').val()) * Number($(this).val()))/100;
			$finalVal = Number($('#sell_price').val()) - Number($prout.toFixed(2));
			$(this).next('.fprice').val($finalVal.toFixed(2));
		}else{
			$(this).next('.fprice').val('');
			if($('#pricetype').val()=='range'){ $(this).next('.fprice').removeClass('disabled').attr('readonly',false); }
		}}else{
			
			if($('#pricetype').val()=='range'){		
				if($(this).val()!=''){
					if($(this).prev('.prpercent').val() == '') $(this).prev('.prpercent').hide();
				}else{
					$(this).prev('.prpercent').show();
				}
			}
		}
	})

$(document).on('focusin',".fprice", function(){ if($(this).prev('.prpercent').val() == '' && $('#pricetype').val()=='range') $(this).removeClass("disabled").attr('readonly',false);
}).focusout(function(){   $(this).addClass("disabled").attr('readonly',true); });


$(document).on('click', '.rangDel', function(){ 
	if($(this).closest('td').parent('tr').find('.add_row').length) {
		$(this).closest('td').parent('tr').prev('tr').find('.qtyto').closest('td').append('<a href="javascript:;" class="add_row" id="addmore">Add More</a>');
	}
	$(this).closest('td').parent('tr').remove(); 
})

function addMoreRangePr(thisobj)
{	
		$('.qtyRange:first').clone().attr('id','qtyRange'+$('.qtyRange').length).insertAfter($('.qtyRange:last')).find('td:last').append('<img src="../images/delete-161.png" class="rangDel" style="cursor:pointer">');
		$('.qtyRange:last a').remove();
		$('.qtyRange:last').find(':input').val('');
		$('.qtyRange:last .prpercent').show();
}


$(function(){
	
	$('#pricetype').change(function(event,param){
		$(this).closest('td').parent('tr').next('tr').find('span').remove();
		if($('#Condition').val()=='' && $(this).val() != '')
		{
			if($(this).next('span').length == '0')$('<span style="color:red">Select Condition First!</span>').insertAfter('#pricetype');
			return false;
		}
		
		if(param =='' || typeof param === 'undefined'){ console.log($('.pricetype').closest('td').parent('tr'));
			$('.pricetype').closest('td').parent('tr').find('input').val(''); 
			$('.qtyRange input').val('');
		}

		if($(this).val() == 'fixed')
		{
			$('.fprice').show().removeClass('disabled').attr('readonly',false)
			$clobj = $('#fprice').clone();
			$('#fprice').remove(); 
			$clobj.insertAfter('#pricetype');

			$('.qtyRange:first').hide();
			if($('.qtyRange').length > 1)  $('.qtyRange:not(:first)').remove();
			$('#prpercent').hide();			
		}else if($(this).val() == 'percentage')
		{
			$('#fprice').show().addClass('disabled').attr('readonly',true);

			$clobj = $('#prpercent').clone();
			$('#prpercent').remove(); 
			$clobj.insertAfter('#pricetype');  
	
			$clobj = $('#fprice').clone();
			$('#fprice').remove(); 
			$clobj.insertAfter('#prpercent');
			
			$('.qtyRange:first').hide();
			if($('.qtyRange').length > 1)  $('.qtyRange:not(:first)').remove();
			$('#prpercent').show();	
				
		}else if($(this).val() == 'range')
		{
			$('.qtyRange').show();
			if(param =='' || typeof param === 'undefined'){ 
				$('.prpercent').hide();
				$('.fprice').hide();
			}
		}else{
			$('.fprice').hide();
			$('.prpercent').hide();
			$('.qtyRange:first').hide();
			if($('.qtyRange').length > 1){  $('.qtyRange:not(:first)').remove();}
		}	

	})

	$(document).on('keyup', '.qtyfrom,.qtyto', function(){
		$(this).closest('td').parent('tr').find('span,a').remove();
		$new = $(this).val().replace(/[^0-9]/g, '');
            	$(this).val($new);
		var clostd = $(this).closest('td');
		if($(this).attr('id') == 'qtyto')
		{
			if($.trim(clostd.parent('tr').find('.qtyfrom').val()) == '' && $.trim($(this).val())!='')
			{
				$(this).closest('td').append('<span  style="color:red">Qtyfrom is required field!</span>');
			}
			else if($.trim(clostd.parent('tr').find('.qtyfrom').val()) > $.trim($(this).val()))
			{
				$(this).closest('td').append('<span  style="color:red">Qtyfrom should be less then qtyto!</span>')
			}
		}
		if($(this).attr('id') == 'qtyfrom')
		{
			if(($.trim($(this).val()) > $.trim(clostd.parent('tr').find('.qtyto').val())) && $.trim(clostd.parent('tr').find('.qtyto').val())!='')
			{
				$(this).closest('td').next('td').append('<span  style="color:red">Qtyfrom should be less then qtyto!</span>')
			}

		}

		if($(this).closest('td').parent().attr('id').replace(/[^0-9]/g, '') < 1)
		{
			if($.trim(clostd.parent('tr').find('.qtyfrom').val()) != '' && $.trim(clostd.parent('tr').find('.qtyto').val())!='' && ($.trim(clostd.parent('tr').find('.qtyfrom').val()) < $.trim(clostd.parent('tr').find('.qtyto').val())))
			{	
				$('<a href="javascript:;" class="add_row" id="addmore">Add More</a>').insertAfter('#qtyto');
				$('#prpercent').show().insertAfter('#qtyto');
				$('#fprice').show().insertAfter('#prpercent');
			}
		}		
	})

	
$('#pricetype').trigger('change',["<?=$arryProduct[0]['pricetype']?>"]);
$(document).on('click','.add_row', function(){	addMoreRangePr($(this));	});
})

</script>
<!--End-->
