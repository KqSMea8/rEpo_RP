<? 


 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arryPurchaseTax);$i++) {
	$TaxRateOption .= "<option value='".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['TaxRate']."'>
	".$arryPurchaseTax[$i]['RateDescription']." : ".$arryPurchaseTax[$i]['TaxRate']."</option>";
 } 
if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:none;"'; }
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

	/*$("table.order-list").on("change", 'select[name^="tax"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});*/


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
		var taxRate = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		//var taxRate = row.find('select[name^="tax"]').val();

		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		var item_taxable = row.find('input[name^="item_taxable"]').val();

		var SubTotal = price*qty;

		var tax_add = 0;

		if(taxRate!=0 && item_taxable=="Yes"){
			var arrField = taxRate.split(":");
			var tax = arrField[2];
			tax_add = (SubTotal*tax)/100;
			//SubTotal += tax_add;
		}

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {		
		var subtotal=0, TotalAmount=0 , taxAmnt=0;		
		var item_taxable = ''; 		
		var taxRate = 0; var tax = 0; var amount = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		if(taxRate!=0){
			var arrField = taxRate.split(":");
			tax = arrField[2];			
		}


		$("table.order-list").find('input[name^="amount"]').each(function () {
			amount = $(this).val();
			subtotal += +amount;			
			item_taxable = $(this).closest("tr").find('input[name^="item_taxable"]').val();
			if(tax>0 && item_taxable=="Yes"){
				taxAmnt += (amount*tax)/100;	
			}
			
		});

		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));

		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();

		$("#TotalAmount").val(subtotal.toFixed(2));
	}


</script>


 <table width="100%" id="myTable" class="order-list" cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td width="8%" class="heading" >SKU</td>
                <td width="10%" class="heading" >Condition</td>
		<td class="heading" >Description</td>
		<td width="10%" class="heading" style="display:none">Qty Ordered</td>
		<td width="10%" class="heading" >Total Qty Received</td>
		<td width="10%" class="heading" >Total Qty RMA</td>
		<td width="10%" class="heading" >Qty RMA</td>
		<td width="8%"  class="heading" >Unit Price</td>
		<td width="7%" class="heading" >Taxable</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	


		$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["ref_id"]);
		$total_returned = $objPurchase->GetQtyReturned($arryPurchaseItem[$Count]["ref_id"]);
		
		$ordered_qty = $arryPurchaseItem[$Count]["qty"];
		
		$to_return = $total_received - $total_returned;

		$QtyType = ($to_return > 0)?('text'):('hidden');
		


	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';

	?>
     <tr class='itembg'>
        <td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?><input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arryPurchaseItem[$Count]["id"]?>" readonly maxlength="20"  />



		</td>
<td><div <?=$style?>><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?></div></td>
        <td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
        <td style="display:none"><?=number_format($arryPurchaseItem[$Count]["qty"])?><input type="hidden" name="ordered_qty<?=$Line?>" id="ordered_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=number_format($arryPurchaseItem[$Count]["qty"])?>"/></td>
         <td><?=number_format($total_received)?><input type="hidden" name="total_received<?=$Line?>" id="total_received<?=$Line?>" class="disabled" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=number_format($total_received)?>"/></td>
         <td><?=number_format($total_returned)?><input type="hidden" name="total_returned<?=$Line?>" id="total_returned<?=$Line?>" class="disabled" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=number_format($total_returned)?>"/></td>
       <td><input type="<?=$QtyType?>" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value=""/></td>
       <td><?=number_format($arryPurchaseItem[$Count]["price"],2)?><input type="hidden" name="price<?=$Line?>" id="price<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=$arryPurchaseItem[$Count]["price"]?>"/></td>
       <td> 
<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />

<!--span style="display:<?=$TaxShowHide?>"><?
		/* if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				echo $arryPurchaseItem[$Count]["RateDescription"].' : ';
				echo number_format($arryPurchaseItem[$Count]["tax"],2);
			*/	
			?>
		</span-->  
	   <!--select name="tax<?=$Line?>" id="tax<?=$Line?>" class="disabled" style="width:120px;display:none">
			<option value="0">None</option>
			<? for($i=0;$i<sizeof($arryPurchaseTax);$i++) {?>
			<option value="<?=$arryPurchaseTax[$i]['RateId'].':'.$arryPurchaseTax[$i]['TaxRate']?>" <? if($arryPurchaseTax[$i]['RateId']==$arryPurchaseItem[$Count]['tax_id']){echo "selected";}?>>
			<?=$arryPurchaseTax[$i]['RateDescription'].' : '.$arryPurchaseTax[$i]['TaxRate']?>
			</option>
			<? } ?>			
		</select-->
	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=number_format($amount,2)?>"/></td>
       
    </tr>
	<? 
		//$subtotal += $arryPurchaseItem[$Count]["amount"];
		

		$TotalQtyReceived += $total_received;
		$TotalToReturn += $to_return;

	} ?>
</tbody>
<tfoot>

     <tr class='itembg'>
        <td colspan="10" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
		<?	


		/*
		$subtotal = number_format($subtotal,2);
		$Freight = number_format($Freight,2);
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$TotalAmount = number_format($TotalAmount,2);
		*/


		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="15" style="text-align:right;"/>
		<br><br>

		<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="" size="15" style="text-align:right;"/><br><br>


		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="15" style="text-align:right;"/>
		<br><br>

<?
		//echo $TotalQtyReceived.'-'.$TotalToReturn;
		

		
		if($TotalQtyReceived<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_NOT_RECEIVED.'</div>';
			$HideSubmit=1;
		}else if($TotalToReturn<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_TO_NO_RETURN.'</div>';
			$HideSubmit=1;
		}
?>

        </td>
    </tr>
</tfoot>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
