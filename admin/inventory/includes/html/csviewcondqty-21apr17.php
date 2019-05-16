<script>
$(function(){

$(document).on('change','select[name="condition"]',function(){
		var thisobj = $(this);
		sku 	= $(this).next('input').val();
		id 	= $(this).next('input').next('input').val();
		condi 	= $(this).val();
		var bomqty = $(this).next('input').next('input').next('input').val();
		var avgcost = $(this).closest('tr').find('#avgcost').val();
		//updated 18Apr2017 by chetan//
		shserial = "<?= ((!empty($_GET['serial'])) ? $_GET['serial'] : '')?>"; 
		WID	 = "<?= ((!empty($_GET['WID'])) ? $_GET['WID'] : '') ?>";    	//END// 
		$.ajax({
			url:'ajax.php?action=getCSItemonCondition',
			type: 'POST',
			data:{sku:sku,condition:condi,serial:shserial,item_id:id,WID:WID},//updated by chetan 4Apr2017// 
			dataType : "json",
			success:function(data) {
				if(data!='')
				{				
					thisobj.closest('tr').find('td:gt(2)').remove();
					thisobj.closest('tr').append(data.html);
					refreshtotal(thisobj,bomqty,avgcost,data);			
				}			
			    }						
			
		})


	});

})
//toFixed
function refreshtotal(obj,qty,avgcost,data)
{//alert(qty);alert(avgcost);
	oldtotal = parseFloat(obj.closest('tr').closest('table').find('#total td:eq(4)').html());//alert(oldtotal + ('old'));
	lesstotal = Number(oldtotal) - Number(qty*avgcost); //alert(lesstotal + ('less'));
	newtotal = Number(lesstotal) + Number(qty*data.avgcost);//alert(newtotal + ('new'));
	newtotal = Number(newtotal.toFixed(2)) + (" <?=$Config['Currency']?>");//alert(newtotal + ('new2'));
	obj.closest('tr').closest('table').find('#total td:eq(4)').html(newtotal);
}

</script>

<div class="had"> Items </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td id="ProductsListing">         
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>

<? if(!empty($optionsArr)){?>
     <tr align="left">
	<td class="head1">Option Code</td>			
		</tr>
		<?php
		
		if (is_array($optionsArr)) {
			$flag = true;
			$Line = 0;
			foreach ($optionsArr as $key => $values) {
				$flag=!$flag;
				$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
				$Line++;
		?>
		    <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
		        <td><span><?=$values['option_code']?></span>
		            <table width="100%" id="myTable" style="margin-top: 5px" cellpadding="0" cellspacing="1">
		                    <tr>
		                        <td align="left" width="20%"  class="head1">Sku</td>
		                        <td align="left" width="20%"  class="head1">Description</td>
		                        <td align="left" width="20%"  class="head1">Bom Qty</td>
					<td width="20%"class="head1">Qty</td>
					<td width="20%"class="head1">Average Cost</td>
					<? if($_GET['serial']==1){?> 
						<td align="left" width="20%" class="head1">Serial No.</td>
					<? }?>
		                    <tr>
		                     
		                    <?php 
		                        $resArr = $objItem->GetOptionCodeItem($values['optionID']);//print_r($resArr);
		                        if(count($resArr)>0 ) {  
		                            $totalAvgCost = '';
		                            foreach($resArr as $res){?>
		                            
		                                <tr>
		                                    <td align="left"><?php echo $res['sku'];?>
<br/>Condition: <select name="condition" id="condition" class="textbox"  style="width:110px;"><?=$ConditionSelectedDrop?></select>
<input type="hidden" name="sku" id="sku" value="<?php echo $res['sku'];?>">
<input type="hidden" name="itemid" id="itemid" value="<?=$res['item_id']?>">
<input type="hidden" name="qty" id="qty" value="<?=$res['qty']?>">
</td>
		                                    <td align="left"><?php echo $res['description'];?></td>
		                                    <td align="left"><?php echo $res['qty'];?></td>
<?php 

$arryCondQty=$objItem->getItemCondion($res['sku'],$_GET['condition']);
$numQty =count($arryCondQty);
if (is_array($arryCondQty) && $numQty > 0) {
foreach ($arryCondQty as $key => $CondQty) {

$flag = !$flag;
$bgcolor2=($flag)?("#FAFAFA"):("#FFFFFF");
$Line++;

if($values['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $res['sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgTransPrice($res['item_id'],$_GET,$_GET['WID']);//updated by chetan 4Apr2017//
}else if($values['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $res['sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgTransPrice($res['item_id'],$_GET,$_GET['WID']);//updated by chetan 4Apr2017//

}else{
$_GET['Sku']  = $res['sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgSerialPrice($res['item_id'],$_GET,$_GET['WID']);//updated by chetan 4Apr2017//
}
$totalAvgCost = bcadd($totalAvgCost, ($AvgCost[0]['price'] * $res['qty']) , 2);
}?>
																																		
<td><?=($CondQty['condition_qty']) ? $CondQty['condition_qty']  : '0';?></td>
<td><?= $AvgCost[0]['price']." ".$Config['Currency']?>
<input type="hidden" name="avgcost" id="avgcost" value="<?=$AvgCost[0]['price']?>">
</td>
<?php }else{  ?>
<td>0</td>
<td>0 <?=$Config['Currency']?><input type="hidden" name="avgcost" id="avgcost" value="0"></td>
<?}?>

			   <?if($_GET['serial']==1){ //updated by chetan 4Apr2017// ?> 
				<td  width="20%"><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku=<?=$res['sku']?>&pop=1&Condition=<?=$_GET['condition']?>&WID=<?=$_GET['WID']?>"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>
				<?}?>	
		                                <tr>
		       <?php   } ?>
<tr id="total">
<td width="20%"></td>
<td width="20%"></td>
<td width="20%"></td>
<td width="20%" align="right">TotalCost:</td>
<td width="20%"> <?=($totalAvgCost) ? $totalAvgCost : 0;?> <?=$Config['Currency']?></td>
<?if($_GET['serial']==1){?> 
<td width="20%"></td>
<?}?>
</tr>		                        

<? }?>
		               </table>
		       
		       </td>





		   </tr>
           <!--End--->
<?}  } else{?>
<tr>
<td  class="no_record" colspan ="2">No Records Found.</td>
</tr>
<? }?>			

<?}else{?>

                    <tr align="left">
			<td width="20%" class="head1" >Sku</td>
			<td  class="head1" >Item Description</td>
			<? if($Itemval[0]['itemType']=='Kit' || $Itemval[0]['itemType']=='Non Kit'){?>
			<td  width="20%"class="head1">Bom Qty</td>
			<? } ?>
			<td  width="20%"class="head1">Qty</td>
			<td  width="20%"class="head1">Average Cost</td>
			<?if($_GET['serial']==1){?> 
				<td  class="head1" >Serial No.</td>
			<?}?>	       		      	                                      
                  </tr>

                    <?php $totalAvgCost = 0;
                    if (is_array($arryProduct) && count($arryProduct) > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">                           
                                <td><?= stripslashes($values['Sku']); ?>
<br/>Condition: <select name="condition" id="condition" class="textbox"  style="width:110px;"><?=$ConditionSelectedDrop?></select>
<input type="hidden" name="sku" id="sku" value="<?php echo $values['Sku'];?>">
<input type="hidden" name="itemid" id="itemid" value="<?=$values['item_id']?>">
<input type="hidden" name="qty" id="qty" value="<?=$values['qty']?>">
</td>
                                <td><?= stripslashes($values['description']);?></td>
				<td><?php if($values['qty']>0){ echo stripslashes($values['qty']); } else{ echo '0';}?></td>

<?php 

$arryCondQty=$objItem->getItemCondion($values['Sku'],$_GET['condition']);
$numQty =count($arryCondQty);
if (is_array($arryCondQty) && $numQty > 0) {
foreach ($arryCondQty as $key => $CondQty) {

$flag = !$flag;
$bgcolor2=($flag)?("#FAFAFA"):("#FFFFFF");
$Line++;

if($values['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $values['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgTransPrice($values['item_id'],$_GET,$_GET['WID']);//updated by chetan 4Apr2017//
}else if($values['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $values['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgTransPrice($values['item_id'],$_GET,$_GET['WID']);//updated by chetan 4Apr2017//

}else{
$_GET['Sku']  = $values['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgSerialPrice($values['item_id'],$_GET,$_GET['WID']);//updated by chetan 4Apr2017//
}
//$totalAvgCost = ($totalAvgCost) + ($AvgCost);
$totalAvgCost = bcadd($totalAvgCost, ($AvgCost[0]['price'] * $values['qty']), 2);
}?>
																																		
<td><?=($CondQty['condition_qty']) ? $CondQty['condition_qty']  : '0';?></td>
<td><?=$AvgCost[0]['price']." ".$Config['Currency']?>
<input type="hidden" name="avgcost" id="avgcost" value="<?=$AvgCost[0]['price']?>">
</td>
<?php }else{  ?>
<td>0</td>
<td>0 <?=$Config['Currency']?><input type="hidden" name="avgcost" id="avgcost" value="0"></td>
<?}?>
<?if($_GET['serial']==1){ //updated by chetan 4Apr2017// ?> 
				<td  width="20%"><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku=<?=$values['Sku']?>&pop=1&Condition=<?=$_GET['condition']?>&WID=<?=$_GET['WID']?>"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>
				<?}?>		
</tr>

                        <?php  } // foreach end // ?>

<tr id="total">
<td width="20%"></td>
<td width="20%"></td>
<td width="20%"></td>
<td width="20%" align="right">TotalCost:</td>
<td width="20%"> <?=($totalAvgCost) ? $totalAvgCost : 0;?> <?=$Config['Currency']?></td>
<?if($_GET['serial']==1){?> 
<td width="20%"></td>
<?}?>
</tr>

                    <?php } else { ?>
                        <tr >
                            <td  colspan="8" class="no_record">No Items found.</td>
                        </tr>

                    <?php } ?>

<? }?>                    
                </table>
</div>

        </td>
    </tr>
</table>

