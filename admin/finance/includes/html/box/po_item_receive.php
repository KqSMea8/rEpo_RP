<? 


 $TaxRateOption = "<option value='0'>None</option>";
if(isset($arryPurchaseTax)){
 for($i=0;$i<sizeof($arryPurchaseTax);$i++) {
	$TaxRateOption .= "<option value='".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['TaxRate']."'>
	".$arryPurchaseTax[$i]['RateDescription']." : ".$arryPurchaseTax[$i]['TaxRate']."</option>";
 } 
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


$('#Freight').keyup(function(){
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
		var DropshipCost = +row.find('input[name^="DropshipCost"]').val();
		var SubTotal = (price*qty) + (DropshipCost*qty);

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
		var subtotal=0, TotalAmount=0 , taxAmnt=0, PrepaidAmount = 0;		
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


var fr =	$("#Freight").val();

freightTaxSet = document.getElementById("freightTxSet").value;
if($("#PrepaidFreight").val() == 1){
//PrepaidAmount = $("#PrepaidAmount").val();
}else{

PrepaidAmount = 0;
}
//alert(freightTaxSet);
console.log(taxAmnt);
console.log(fr);
 console.log(freightTaxSet);
if(fr!='' && tax>0 && freightTaxSet =='Yes'){	
var totFr = Number(fr)+Number(PrepaidAmount);	
				FrtaxAmnt = (totFr*tax)/100;	
				FrtaxAmnt = taxAmnt+FrtaxAmnt;
				taxAmnt  = FrtaxAmnt;
}



		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));

		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();
		if(document.getElementById("AdjustmentAmount") != null){
			subtotal += +$("#AdjustmentAmount").val();
		}
		if(document.getElementById("PrepaidFreight").value=="1"){
			subtotal += +PrepaidAmount;
		}
		$("#TotalAmount").val(subtotal.toFixed(2));
		ProcessFreight();
	}

	function ProcessFreight() { 
		var OrderType = $("#OrderType").val();

		if(OrderType!='Dropship'){

				var AllocationMethod = $("#AllocationMethod").val();
				var PercentLine=0 , PercentFreight=0 , TotalFreight=0 , TotalQty=0, TotalWeight=0, TotalVolume=0, TotalPercentFreight=0;	
				var subtotal = parseFloat($("#subtotal").val());
				var Freight = parseFloat($("#Freight").val());
				var PrepaidAmount = parseFloat($("#PrepaidAmount").val());
				if(Freight>0){
					TotalFreight += Freight;
				}
				if(document.getElementById("PrepaidFreight").value=="1" && PrepaidAmount>0){
					TotalFreight += PrepaidAmount;
				}
		
				$("table.order-list").find('input[name^="qty"]').each(function () {	
					var qty  = parseInt($(this).val());
					var weight = parseFloat($(this).closest("tr").find('input[name^="weight"]').val());
					var volume = parseFloat($(this).closest("tr").find('input[name^="volume"]').val());
					if(qty>0){		
						TotalQty += qty;
			
						if(weight>0){	
							weight = weight*qty;	
							TotalWeight += weight;
						}
						if(volume>0){	
							volume = volume*qty;		
							TotalVolume += volume;
						}
					}
				});
				 
		 
				 
				$("table.order-list").find('input[name^="amount"]').each(function () {
					var qty = parseInt($(this).closest("tr").find('input[name^="qty"]').val());
					PercentLine=0;
					PercentFreight=0;
					if(qty>0 && TotalFreight>0){				
						var amount = $(this).val();					
						var weight = parseFloat($(this).closest("tr").find('input[name^="weight"]').val());
						var volume = parseFloat($(this).closest("tr").find('input[name^="volume"]').val());
						weight = weight*qty;
						volume = volume*qty;		
						if(amount>0 && AllocationMethod=='Cost'){	
							PercentLine = ((amount*100)/subtotal).toFixed(2);
						}else if(qty>0 && AllocationMethod=='Quantity'){		
							PercentLine = ((qty*100)/TotalQty).toFixed(2);
						}else if(weight>0 && AllocationMethod=='Weight'){		
							PercentLine = ((weight*100)/TotalWeight).toFixed(2);
						}else if(volume>0 && AllocationMethod=='Volume'){		
							PercentLine = ((volume*100)/TotalVolume).toFixed(2);
						}

						PercentFreight = ((TotalFreight*PercentLine)/100).toFixed(2);
						TotalPercentFreight += parseFloat(PercentFreight);
					}
					$(this).closest("tr").find('input[name^="freight_cost"]').val(PercentFreight);	
				});



			 
			var RemAmount = parseFloat((TotalFreight - TotalPercentFreight).toFixed(2));
			if(RemAmount!='0.00'){
				var freight_cost = parseFloat($("#freight_cost1").val());
				var first_freight_cost = (freight_cost + RemAmount).toFixed(2);
				$("#freight_cost1").val(first_freight_cost);
			}



		}
	}

</script>


 <table width="100%" id="myTable" class="order-list" cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td width="10%" class="heading" >SKU</td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
	<td width="8%" class="heading" >Warehouse</td>
<td width="8%" class="heading" >Bin</td>
   		<td width="8%" class="heading" >Condition</td>
<?}?>
		<td  class="heading" >Description</td>
		<td width="10%" class="heading" >Qty Ordered</td>
		<td width="12%" class="heading" >Total Qty Received</td>
		<td width="11%" class="heading" >Qty Received</td>
		<td width="8%"  class="heading" >Unit Price</td>
		<td width="10%" class="heading">Dropship Cost</td>
		<td width="8%" class="heading" >Taxable</td>
		<td width="12%" class="heading" align="center" >Amount Received</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=$TotalQtyReceived=0;

 
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	


		$total_received = $objPurchase->GetQtyTotalReceived($arryPurchaseItem[$Count]["ref_id"],$_GET['edit']);
		$ordered_qty = $arryPurchaseItem[$Count]["qty"];
		
		//$QtyType = ($total_received >= $ordered_qty)?('hidden'):('text');
		$QtyType = 'text';
		
	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	 if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';



		/*******Weight*******/
		$weight = $arryPurchaseItem[$Count]['weight'];
		if($weight>0 && $arryPurchaseItem[$Count]['wt_Unit']!='Kg'){
			$weight = round($weight*0.4535, 2);  //Lbs to Kg
		}		
		/********************/



		
		/*******Length*******/
		$length = $arryPurchaseItem[$Count]['width'];
		if($length>0 && $arryPurchaseItem[$Count]['ln_Unit']!='Cm'){
			$length = $length*2.54;  //Inch to Cm
		}
		/*******Width*******/
		$width = $arryPurchaseItem[$Count]['height'];
		if($width>0 && $arryPurchaseItem[$Count]['wd_Unit']!='Cm'){
			$width = $width*2.54;  //Inch to Cm
		}
		/*******Height*******/
		$height = $arryPurchaseItem[$Count]['depth'];
		if($height>0 && $arryPurchaseItem[$Count]['ht_Unit']!='Cm'){
			$height = $height*2.54;  //Inch to Cm
		}		
		/********************/
		$volume = round($length*$width*$height,2);




	?>
     <tr class='itembg'>
	<td>
	<?=stripslashes($arryPurchaseItem[$Count]["sku"])?>
	<input type="hidden" name="sku<?= $Line ?>" id="sku<?= $Line ?>" size="10" maxlength="10"  value="<?= stripslashes($arryPurchaseItem[$Count]["sku"]) ?>"/>
	<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["item_id"])?>" readonly maxlength="20"  />
	<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arryPurchaseItem[$Count]['id']?>" readonly maxlength="20"  /></td>
<?php if ($_SESSION['SelectOneItem']!='1'){?>
	<td><?=stripslashes($arryPurchaseItem[$Count]["warehouse_code"])?>
<input type="hidden" name="WID<?=$Line?>" id="WID<?=$Line?>" value="<?=$arryPurchaseItem[$Count]["WID"]?>" /></td>
<td><?=stripslashes($arryPurchaseItem[$Count]["bin"])?>
<input type="hidden" name="binid<?=$Line?>" id="binid<?=$Line?>" value="<?=$arryPurchaseItem[$Count]["binid"]?>" /></td>
<? }?>
	<td><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?>
<input type="hidden" name="Condition<?=$Line?>" id="Condition<?=$Line?>" value="<?=$arryPurchaseItem[$Count]['Condition']?>" /></td>
	<td><?=stripslashes($arryPurchaseItem[$Count]["description"])?>
	<input type="hidden" name="description<?=$Line?>" id="description<?=$Line?>" value="<?=$arryPurchaseItem[$Count]['description']?>" />
	</td>
	<td><?=number_format($arryPurchaseItem[$Count]["qty"])?><input type="hidden" name="ordered_qty<?=$Line?>" id="ordered_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=number_format($arryPurchaseItem[$Count]["qty"])?>"/></td>
	<td><?=number_format($total_received)?><input type="hidden" name="total_received<?=$Line?>" id="total_received<?=$Line?>" class="disabled" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=number_format($total_received)?>"/></td>
	<td><input type="<?=$QtyType?>" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=$arryPurchaseItem[$Count]['qty_received']?>"/>
<input type="hidden" name="oldqty<?=$Line?>" id="oldqty<?=$Line?>" class="textbox" readonly size="2" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=$arryPurchaseItem[$Count]['qty_received']?>"/>

	<br>
	<?php  if($arryPurchaseItem[$Count]["evaluationType"] == 'Serialized' && $arryPurchase[0]['OrderType'] != 'Dropship' && $total_received <= $ordered_qty){ ?>
	<a  class="fancybox slnoclass fancybox.iframe" href="addPOSerial.php?id=<?=$Line?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
	<?php }?>
	<input type="hidden" name="serial_value<?=$Line?>" id="serial_value<?=$Line?>" value="<?=$arryPurchaseItem[$Count]['SerialNumbers']?>"  />
	<input type="hidden" name="evaluationType<?=$Line?>" id="evaluationType<?=$Line?>" value="<?=$arryPurchaseItem[$Count]["evaluationType"]?>"  />
	<input type="hidden" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" class="textbox" value="<?=$arryPurchase[0]['DropshipCheck'];?>"/>
	</td>
	<td><?/*=number_format($arryPurchaseItem[$Count]["price"],2)*/?><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox"  size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=$arryPurchaseItem[$Count]["price"]?>"/></td>
	<td><?=number_format($arryPurchaseItem[$Count]["DropshipCost"],2)?><input type="hidden" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=$arryPurchaseItem[$Count]['DropshipCost']?>"/></td>
	<td> 
	<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />

	</td>
	<td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=$arryPurchaseItem[$Count]['amount']?>"/><input type="hidden" align="right" name="freight_cost<?=$Line?>" id="freight_cost<?=$Line?>" class="textbox" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=$arryPurchaseItem[$Count]['freight_cost']?>"/>
<input type="hidden" align="right" name="weight<?=$Line?>" id="weight<?=$Line?>" class="textbox" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=$weight?>"/>
<input type="hidden" align="right" name="volume<?=$Line?>" id="volume<?=$Line?>" class="textbox" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=$volume?>"/>


</td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];
		$TotalQtyReceived += $total_received;	

	} 

	
	$taxAmnt = $arryPurchase[0]['taxAmnt'];
	$Freight = $arryPurchase[0]['Freight'];
	$PrepaidAmount = $arryPurchase[0]['PrepaidAmount'];
	$TotalAmount = $arryPurchase[0]['TotalAmount'];

?>
</tbody>
<tfoot>

     <tr class='itembg'>
        <td colspan="13" align="right">

         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
		
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/>
		<br><br>

		


		Freight Cost : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>


		<div id="PrepaidAmountDiv" <?  if($arryPurchase[0]['PrepaidFreight']!=1){echo 'style="display:none"';}?>>
		Prepaid Freight : <input type="text" align="right" name="PrepaidAmount" id="PrepaidAmount" class="textbox" value="<?=$PrepaidAmount?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		</div>


		<? if($arryPurchase[0]['AdjustmentAmount']!='0.00'){ ?>
		Adjustments : <input type="text" align="right" name="AdjustmentAmount" id="AdjustmentAmount" class="disabled" readonly value="<?=$arryPurchase[0]['AdjustmentAmount']?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		<? } ?>

		<div <?  if($arryPurchase[0]['OrderType']=='Dropship'){echo 'style="display:none"';}?>>
		Allocation Method : <?=$AllocDropdown?><br><br>
		</div>

<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="13" style="text-align:right;"/><br><br>

		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
		<br><br>

<?
		/*****************************
		$TotalQtyLeft = $objPurchase->GetTotalQtyLeft($arryPurchase[0]['PurchaseID']);
		if($TotalQtyLeft<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
		}

		/*****************************/
?>

        </td>
    </tr>
</tfoot>
</table>
<input type="hidden" name="OrderType" id="OrderType" value="<?=$arryPurchase[0]['OrderType']?>" readonly />
<input type="hidden" name="PrepaidFreight" id="PrepaidFreight" value="<?=$arryPurchase[0]['PrepaidFreight']?>" readonly />
 
