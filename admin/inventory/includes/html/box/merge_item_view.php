

 <table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">
    
    <tr align="left"  >
		<td class="heading" >SKU</td>
            <td width="15%" class="heading" >Condition</td>
		<td width="15%" class="heading" >Description</td>
             
		<td width="10%" class="heading" >Qty on Hand</td>
		<td width="15%" class="heading" >Qty</td>
                <!--td width="12%" class="heading" >Wastage Qty</td-->
		<td width="10%"  class="heading" > Cost</td>
                <td width="10%"  class="heading" >Total Price</td>
		
		
    </tr>


	<?php $TotalQty=0;

$TotalorderQty= $TotalValue =0;

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	

if(!empty($_GET['view']) && $_GET['view']!=''){
//$arryItem=$objItem->GetItems($arryBomItem[$Count]['item_id'],'','','');
}
		//$total_received = $objPurchase->GetQtyReceived($arryBOMItem[$Count]["id"]);
		$ordered_qty = $arryBOMItem[$Count]["qty"];



	?>
     <tr class="itembg">
        <td><?=stripslashes($arryBOMItem[$Count]["sku"])?></td>
<td><? if(isset($arryBOMItem[$Count]["Condition"])) echo stripslashes($arryBOMItem[$Count]["Condition"])?></td>
        <td><?=stripslashes($arryBOMItem[$Count]["description"])?></td>
  
        <td><? if(isset($arryBOMItem[$Count]["qty_on_hand"])) echo  $arryBOMItem[$Count]["qty_on_hand"]; 
 
?></td>
         <td><?=$ordered_qty?>

<?   
if(!isset($arryBOMItem[$Count]["valuationType"])) $arryBOMItem[$Count]["valuationType"]=''; 


if ($arryBOMItem[$Count]["valuationType"] == 'Serialized') {

                    echo '&nbsp&nbsp&nbsp<a  class="fancybox slnoclass fancybox.iframe" href="editSerial.php?id=' . $Line . '&total='.$ordered_qty.'&dismly=' . $_GET['view'] . '&sku=' . $arryBOMItem[$Count]["sku"] . '&serial_value_sel='.$arryBOMItem[$Count]["serial"].'&view=1" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;View S.N.</a>';
                }


if(!isset($arryBOMItem[$Count]["wastageQty"])) $arryBOMItem[$Count]["wastageQty"]=''; 
 ?>



</td>
       <!--td><?=number_format($arryBOMItem[$Count]["wastageQty"])?></td-->
       <td><?=number_format($arryBOMItem[$Count]["price"],2)?></td>   
       <td align="right"><?=number_format($arryBOMItem[$Count]["amount"],2)?></td>
       
    </tr>
	<? 
		$TotalorderQty += $ordered_qty;
                $TotalValue += $arryBOMItem[$Count]["amount"];
		//$TotalQtyReceived += $total_received;
		//$TotalQtyLeft += ($ordered_qty - $total_received);

	} ?>


     <tr class="itembg">
        <td colspan="9" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />

         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		#echo $TotalQtyReceived.'-'.$TotalQtyLeft;
		/*if($TotalQtyLeft<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
		}*/
		$TotalorderQty = number_format($TotalorderQty,2);
                $TotalValue = number_format($TotalValue,2);
		 #$TotalValue += $arryBOMItem[$Count]["amount"];
		//$TotalValue = number_format($arryAdjustment[0]['total_adjust_value'],2);
		?>
		<br>
		 
		
		Total Cost : <?= $TotalValue ?>
                
		
		<br><br>
        </td>
    </tr>
</table>

<? //echo '<script>SetInnerWidth();</script>'; ?>


<script>
$(document).ready(function() {


        $(".slnoclass").fancybox({
            'width': 300
        });



    });

</script>
