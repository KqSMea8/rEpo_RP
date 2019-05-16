<? $bgcolor="#FFFFFF"; 


 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arryPurchaseTax);$i++) {
	$TaxRateOption .= "<option value='".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['TaxRate']."'>
	".$arryPurchaseTax[$i]['RateDescription']." : ".$arryPurchaseTax[$i]['TaxRate']."</option>";
 } 

?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();
	

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});

	$("table.order-list").on("change", 'select[name^="tax"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});


	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		calculateGrandTotal();

	});

	});

	function calculateRow(row) {
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		var taxRate = row.find('select[name^="tax"]').val();
		var SubTotal = price*qty;

		var tax_add = 0;

		if(taxRate!=0){
			var arrField = taxRate.split(":");
			var tax = arrField[1];
			tax_add = (SubTotal*tax)/100;
			SubTotal += tax_add;
		}

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {
		var subtotal=0, TotalAmount=0;
		//var Currency = $("#Currency").val();
		
		$("table.order-list").find('input[name^="amount"]').each(function () {
			subtotal += +$(this).val();
		});
		$("#subtotal").val(subtotal.toFixed(2));

		subtotal += +$("#Freight").val();
		
		$("#TotalAmount").val(subtotal.toFixed(2));
	}


</script>


 <table width="100%" id="myTable" class="order-list" cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td width="8%" class="heading" >SKU</td>
		<td class="heading" >Description</td>
		<!--td width="10%" class="heading" >Qty Ordered</td -->
		<td width="13%" class="heading" >Qty Ordered</td>
		<td width="13%" class="heading" >Total Qty Received</td>
		<td width="10%" class="heading" >Qty Recieved</td>
		<td width="8%"  class="heading" >Unit Price</td>
		<td width="10%" class="heading" >Tax Rate</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	

		if($ref==1){
           $qty_ordered = $objWrecieve->GetQtyAdjustment($arryAdjustmentItem[$Count]["id"]);	
		   $total_Received = $objWrecieve->GetQtyAdjustmentReceived($arryAdjustmentItem[$Count]["id"]);
		  
		  
		}else{
			$qty_ordered = $arryAdjustmentItem[$Count]["qty"];
			$total_Received =0;
			
         }
		//$ordered_qty = $arryAdjustmentItem[$Count]["qty"];
		$to_receive =  $qty_ordered - $total_Received ;
		$QtyType = ($to_receive > 0)?('text'):('hidden');
		
	?>
     <tr bgcolor="<?=$bgcolor?>">
        <td><?=stripslashes($arryAdjustmentItem[$Count]["sku"])?>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryAdjustmentItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arryAdjustmentItem[$Count]["id"]?>" readonly maxlength="20"  />
		</td>
        <td><?=stripslashes($arryAdjustmentItem[$Count]["description"])?></td>

        <td><?=number_format($arryAdjustmentItem[$Count]["qty"])?>
		<input type="hidden" name="total_received<?=$Line?>" id="total_received<?=$Line?>" class="disabled" readonly size="5"  value="<?=number_format($arryAdjustmentItem[$Count]["qty"])?>"/></td>

         <!--td><?=number_format($total_Preceived )?><input type="hidden" name="total_received<?=$Line?>" id="total_received<?=$Line?>" class="disabled" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=number_format($total_Preceived )?>"/></td-->

         <td><?=number_format($total_Received)?><input type="hidden" name="total_returned<?=$Line?>" id="total_returned<?=$Line?>" class="disabled" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=number_format($total_Received)?>"/></td>
       <td><input type="<?=$QtyType?>" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value=""/></td>
       <td><?=number_format($arryAdjustmentItem[$Count]["price"],2)?><input type="hidden" name="price<?=$Line?>" id="price<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=$arryAdjustmentItem[$Count]["price"]?>"/></td>
       <td> <? if(!empty($arryAdjustmentItem[$Count]["RateDescription"]))
				echo $arryAdjustmentItem[$Count]["RateDescription"].' : ';
				echo number_format($arryAdjustmentItem[$Count]["tax"],2);
				
			?>
	   <select name="tax<?=$Line?>" id="tax<?=$Line?>" class="disabled" style="width:120px;display:none">
			<option value="0">None</option>
			<? for($i=0;$i<sizeof($arryPurchaseTax);$i++) {?>
			<option value="<?=$arryPurchaseTax[$i]['RateId'].':'.$arryPurchaseTax[$i]['TaxRate']?>" <? if($arryPurchaseTax[$i]['RateId']==$arryAdjustmentItem[$Count]['tax_id']){echo "selected";}?>>
			<?=$arryPurchaseTax[$i]['RateDescription'].' : '.$arryPurchaseTax[$i]['TaxRate']?>
			</option>
			<? } ?>			
		</select>
	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=number_format($amount,2)?>"/></td>
       
    </tr>
	<? 
		//$subtotal += $arryAdjustmentItem[$Count]["amount"];
		
       
		$TotalQtyReceived += $total_Received;
		$TotalToReturn += $to_receive;
		

	} ?>
</tbody>
<tfoot>

     <tr bgcolor="<?=$bgcolor?>">
        <td colspan="9" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
		<?	


		/*
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($Freight,2);
		$TotalAmount = number_format($TotalAmount,2);
		*/


		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="15" style="text-align:right;"/>
		<br><br>
		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="15" style="text-align:right;"/>
		<br><br>

<?
		//echo $TotalQtyReceived.'-'.$TotalToReturn;
		

		
	if($TotalToReturn<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_TO_NO_RETURN.'</div>';
			$HideSubmit=1;
		}
?>

        </td>
    </tr>
</tfoot>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>

