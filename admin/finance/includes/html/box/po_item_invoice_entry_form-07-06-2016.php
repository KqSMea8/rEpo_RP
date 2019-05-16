<? 


 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arryPurchaseTax);$i++) {
	$TaxRateOption .= "<option value='".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['TaxRate']."'>
	".$arryPurchaseTax[$i]['RateDescription']." : ".$arryPurchaseTax[$i]['TaxRate']."</option>";
 } 
if($arryCompany[0]['TrackInventory'] !=1){
		$style ='style="display:none;"';
		$numTd = 11;
	}else{
	       $numTd = 12;
	}
?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;

		var newRow = $("<tr class='itembg'>");
		var cols = "";

		//var Taxable = $("#Taxable").val();
		var Taxable = $("#tax_auths").val();

		var TaxShowHide = 'none';
		if(Taxable=='Yes'){
			TaxShowHide = 'inline';
		}



		/*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
		cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="disabled" readonly size="10" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="../inventory/SelectItem.php?proc=Purchase&id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /></td><td><div <?=$style?>><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionDrop?></select></div></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><input type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" /><span style="display:none;" id="serial' + counter + '"><a class="fancybox slnoclass fancybox.iframe" href="addPOSerial.php?id=' + counter + '" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a><input type="hidden" name="serial_value' + counter + '" id="serial_value' + counter + '" value=""  /></span><input type="hidden" name="evaluationType' + counter + '" id="evaluationType' + counter + '" value=""  /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);"/></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" readonly size="2" maxlength="20"  /><!--select name="tax' + counter + '" id="tax' + counter + '" class="textbox" style="width:120px;display:'+TaxShowHide+'">' + TaxRateOption + '</select--></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="textbox"  size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

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
        


$("table.order-list").on("blur", 'input[name^="amount"]', function (event) {

var row = $(this).closest("tr");
var amount = row.find('input[name^="amount"]').val();
var qty = row.find('input[name^="qty"]').val();
//var price = row.find('input[name^="price"]').val();
if(amount!=''){

if(qty==''){
qty =1;
row.find('input[name^="qty"]').val(qty);
}
var PriceVal = (amount/qty)
row.find('input[name^="price"]').val(PriceVal.toFixed(2));
//console.log(price);

}


ProcessTotal();
               
	});



         $("table.order-list").on("click", "#addItem", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var qty = row.find('input[name^="qty"]').val();
            var serial_sku = row.find('input[name^="sku"]').val();
             var serial_value_sel = row.find('input[name^="serial_value"]').val();
             
            if (qty > 0) {
                var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku +'&serial_value_sel='+serial_value_sel;
                $(this).attr("href", linkhref);
            }
            /*****************************/

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



	function ProcessTotal() {
		var Taxable = $("#Taxable").val();
		var NumLine = document.getElementById("NumLine").value;

		var tax_auths='';
		if(document.getElementById("tax_auths").value=="Yes"){
			tax_auths='Yes';
		}


		/*
		for(var i=1;i<=NumLine;i++){
			var TaxElement = document.getElementById("tax"+i);
			var ItemTaxableElement = document.getElementById("item_taxable"+i);
			if(ItemTaxableElement != null){
				var ShowHideTax = 'none';
				if(tax_auths=="Yes" && ItemTaxableElement.value=="Yes"){
					ItemTaxableElement.style.display = 'inline';
				}else{
					ItemTaxableElement.style.display = 'none';
					ItemTaxableElement.value = 'No';
				}							
				
			}
		}*/

		/*********************/
		$("table.order-list").find('input[name^="amount"]').each(function () {
			calculateRow($(this).closest("tr"));
			
		});
		calculateGrandTotal();
	}






	function ProcessTotalOld() {
		var Taxable = $("#Taxable").val();
		var NumLine = document.getElementById("NumLine").value;
		for(var i=1;i<=NumLine;i++){
			var TaxElement = document.getElementById("tax"+i);
			var ItemTaxableElement = document.getElementById("item_taxable"+i);
			if(TaxElement != null){
				var ShowHideTax = 'none';
				if(Taxable=="Yes" && ItemTaxableElement.value=="Yes"){
					TaxElement.style.display = 'inline';
				}else{
					TaxElement.style.display = 'none';
					TaxElement.value = '0';
				}							
				
			}
		}

		/*********************/
		$("table.order-list").find('input[name^="amount"]').each(function () {
			calculateRow($(this).closest("tr"));
			
		});
		calculateGrandTotal();
	}

</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading">&nbsp;&nbsp;&nbsp;SKU</td>
<td width="12%" class="heading">Condition</td>
		<td width="18%" class="heading">Description</td>
		<td width="10%" class="heading">Qty on Hand</td>
		<td width="8%" class="heading">Qty</td>
		<td width="12%" class="heading">Unit Price</td>
		<td width="8%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right">Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		

	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';
        
        if(!empty($arryPurchaseItem[$Count]["SerialNumbers"])){
            $SlNoHide = 'inline';
	}else{
	   $SlNoHide = 'none';
	}
$ConditionSelectedDrop  = $objCondition->GetConditionDropValue($arryPurchaseItem[$Count]["Condition"]);
	?>
     <tr class='itembg'>
		<td><?=($Line>1)?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arryPurchaseItem[$Count]["sku"])?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="../inventory/SelectItem.php?proc=Purchase&id=<?=$Line?>" ><img src="../images/view.gif" border="0"></a>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["id"])?>" readonly maxlength="20"  />


		</td>
<td><div <?=$style?>><select name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:120px;>"><option value="">Select Condition</option><?=$ConditionSelectedDrop?></select></div></td>
        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["description"])?>"/></td>
        <td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arryPurchaseItem[$Count]["on_hand_qty"])?>"/></td>
        <td>
            <input type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["qty"])?>"/>
<input type="hidden" name="oldqty<?=$Line?>" id="oldqty<?=$Line?>" class="textbox" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["qty"])?>"/>
             <span style="display:<?=$SlNoHide?>;"  id="serial<?= $Line ?>">
                  <a  class="fancybox slnoclass fancybox.iframe" href="addPOSerial.php?id=<?= $Line ?>"id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
                    <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?=$arryPurchaseItem[$Count]["SerialNumbers"]?>"  />

                   </span>
                 
             <input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arryPurchaseItem[$Count]["evaluationType"]?>"  />
        </td>
       <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["price"])?>"/></td>
       <td>
	<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />
	   <!--select name="tax<?=$Line?>" id="tax<?=$Line?>" class="textbox" style="width:120px;display:<?=$TaxShowHide?>">
			<option value="0">None</option>
			<? for($i=0;$i<sizeof($arryPurchaseTax);$i++) {?>
			<option value="<?=$arryPurchaseTax[$i]['RateId'].':'.$arryPurchaseTax[$i]['TaxRate']?>" <? if($arryPurchaseTax[$i]['RateId']==$arryPurchaseItem[$Count]['tax_id']){echo "selected";}?>>
			<?=$arryPurchaseTax[$i]['RateDescription'].' : '.$arryPurchaseTax[$i]['TaxRate']?>
			</option>
			<? } ?>			
		</select-->
	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="textbox"  size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arryPurchaseItem[$Count]["amount"])?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="9" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		//$subtotal = number_format($subtotal,2);
		$taxAmnt = $arryPurchase[0]['taxAmnt'];
		$Freight = $arryPurchase[0]['Freight']; // number_format($arryPurchase[0]['Freight'],2);
		$TotalAmount = $arryPurchase[0]['TotalAmount']; //number_format($arryPurchase[0]['TotalAmount'],2);
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="15" style="text-align:right;"/>
		<br><br>

		Tax : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="15" style="text-align:right;"/><br><br>

		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="15" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>

<? //echo '<script>SetInnerWidth();</script>'; ?>
