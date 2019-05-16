
<div class="had"> Items </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td id="ProductsListing">         
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


   
	
		    <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
		        <td>
		            <table width="100%" id="myTable" style="margin-top: 5px" cellpadding="0" cellspacing="1">
				<tr>
					<td align="left"   class="head1">Sku</td>
					<td align="left" width="20%"  class="head1">Bom Qty</td>
					<td width="20%" class="head1">Average Cost</td>
					<? if($_GET['serial']==1){?> 
						<td align="left" width="20%" class="head1">Serial No.</td>
					<? }?>
				<tr>
		                     
	                    <?php 
	                        //$resArr = $objItem->GetOptionCodeItem($values['optionID']);//print_r($resArr);
	                        if(count($bomArr)>0 ) {  
	                            $totalAvgCost = '';
	                            foreach($bomArr as $res){?>
	                            
	                                <tr>
																<td align="left"><?php echo $res['Sku'];?>
<input type="hidden" name="sku" id="sku" value="<?php if(!empty($res['Sku'])) echo $res['Sku'];?>">
<input type="hidden" name="itemid" id="itemid" value="<?php if(!empty($res['item_id'])) echo $res['item_id']; ?>">
<input type="hidden" name="qty" id="qty" value="<?php if(!empty($res['qty'])) echo $res['qty'];?>">
																</td>
														
																<?php 

$arryCondQty=$objItem->getItemCondion($res['Sku'],$_GET['condition']);

$numQty =count($arryCondQty);
if (is_array($arryCondQty) && $numQty > 0) {

foreach ($arryCondQty as $key => $CondQty) {

$flag = !$flag;
$bgcolor2=($flag)?("#FAFAFA"):("#FFFFFF");
$Line++;

(empty($values['evaluationType']))?($values['evaluationType']=""):("");  

if($values['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $res['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgTransPrice($res['ItemID'],$_GET,$_GET['WID']); //updated by chetan on 5Apr2017//
}else if($values['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $res['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgTransPrice($res['ItemID'],$_GET,$_GET['WID']); //updated by chetan on 5Apr2017//

}else{
$_GET['Sku']  = $res['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$AvgCost=$objItem->GetAvgSerialPrice($res['ItemID'],$_GET,$_GET['WID']); //updated by chetan on 5Apr2017//
}
$totalAvgCost = bcadd($totalAvgCost, ($AvgCost[0]['price'] * $CondQty['condition_qty']) , 2);
}?>
																																		
<td><?=($CondQty['condition_qty']) ? $CondQty['condition_qty']  : '0';?></td>
<td><?= $AvgCost[0]['price']." ".$Config['Currency']?>
<input type="hidden" name="avgcost" id="avgcost" value="<?=$AvgCost[0]['price']?>">
</td>
<?php }else{  ?>
<td>0</td>
<td>0 <?=$Config['Currency']?><input type="hidden" name="avgcost" id="avgcost" value="0"></td>
<?}?>

 <?if($_GET['serial']==1){ //updated by chetan on 5Apr2017//?> 
				<td  ><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku=<?=$res['Sku']?>&pop=1&Condition=<?=$_GET['condition']?>&WID=<?=$_GET['WID']?>"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>
				<?}?>	
		                                <tr>
		       <?php   } ?>
<tr id="total">

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



                   
                </table>
</div>

        </td>
    </tr>
</table>

