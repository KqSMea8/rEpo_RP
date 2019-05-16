<?php 
 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
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

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="DropshipCost"],input[name^="qty"],input[name^="discount"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});

	/*$("table.order-list").on("change", 'input[name^="tax"]', function (event) {
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

	});

	function calculateRow(row) {
		var taxRate = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		//var taxRate = row.find('input[name^="tax"]').val();
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		var item_taxable = row.find('input[name^="item_taxable"]').val();
		var discount = +row.find('input[name^="discount"]').val();
		var TotalDisCount = discount*qty;
                var DropshipCost = +row.find('input[name^="DropshipCost"]').val();
                
               
                
		var SubTotal = price*qty+DropshipCost*qty;;
		if(TotalDisCount > 0){
				SubTotal = SubTotal-TotalDisCount;
			}
		var tax_add = 0;

		if(taxRate!=0 && item_taxable=="Yes"){
			var arrField = taxRate.split(":");
			var taxRate = arrField[2];
			tax_add = (SubTotal*taxRate)/100;
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

		 var MDAmount = document.getElementById("MDAmount").value;
                var MDType = document.getElementById("MDType").value;
		var CustDisType = document.getElementById("CustDisType").value;
                var totDiscountAmt =0;
		var totDiscountCal =0;

		if(MDType !=null){

			if(MDType =='Discount'){

				
                               if(CustDisType == "Percentage"){
					totDiscountCal = subtotal*MDAmount/100;
                                        totDiscountAmt = subtotal-totDiscountCal;
                                        $("#CustDiscount").val(totDiscountCal.toFixed(2));
				 }else{
                                          totDiscountAmt = subtotal - MDAmount; 
                                          document.getElementById("CustDiscount").value = MDAmount;
				}
                             
			
			}else{

				 totDiscountCal = subtotal*MDAmount/100;   
                                 totDiscountAmt = subtotal+totDiscountCal;
				$("#CustDiscount").val(totDiscountCal.toFixed(2));
			
			}
                     
                     $("#TotalAmount").val(totDiscountAmt.toFixed(2));
		  }else{

	      		$("#TotalAmount").val(subtotal.toFixed(2));
		}
    
	}


</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td  class="heading" >SKU</td>
              <? if($arryCompany[0]['TrackInventory'] !=1){?>
                <td  width="9%" class="heading">Condition</td>
		<?}?>
		<td width="15%" class="heading">Description</td>
		<td width="9%" class="heading">Qty Ordered</td>
		<td width="9%" class="heading">Already Invoiced</td>
		<td width="9%" class="heading">Total Qty Invoice</td>
		<td width="10%"  class="heading">Unit Price</td>
                <td width="4%" class="heading" align="center">Dropship</td>
                <td width="10%" class="heading">Cost</td>
		<td width="10%"  class="heading">Discount</td>
		<td width="9%" class="heading">Taxable</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		if($arrySaleItem[$Count]["qty_received"] == $arrySaleItem[$Count]["qty"])
		{
		  $dd = "disabled";
		  $rd = "readonly";
		  }else{
			$dd = "textbox";
			$rd = "";
		  }
		  
		  $remainQty = $arrySaleItem[$Count]["qty"]-$arrySaleItem[$Count]["qty_received"];


		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}

		$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
                
                 if($arrySaleItem[$Count]["DropshipCheck"] == 1){
                    $DropshipCheck = 'Yes';
                }else{
                    $DropshipCheck = 'No';
                }
		  if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';
                  /*$NumSerial = $objSale->CountSkuSerialNo($arrySaleItem[$Count]["sku"]);
                  $SerialNoAndQtyInvoiced = $objSale->CountSkuSerialNoAndQtyInvoiced($arrySaleItem[$Count]["sku"]);
                  $SerialNoAndQtyInvoiced = explode("#",$SerialNoAndQtyInvoiced);
                  $TotalSerial = $SerialNoAndQtyInvoiced[0];
                  $QtyInvoiced = $SerialNoAndQtyInvoiced[1];*/
                 //echo "=>".$TotalSerial."=>>>".$QtyInvoiced;
	?>
     <tr class='itembg'>
		<td>
		 <input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arrySaleItem[$Count]["sku"])?>"/>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="../sales/reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display: none;" border="0" title="Additional Items"></a>
		 <input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="remainQty<?=$Line?>" id="remainQty<?=$Line?>" value="<?=$remainQty?>" readonly maxlength="20"  />

<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />

		</td>
<? if($arryCompany[0]['TrackInventory'] !=1){?>
 <td><div <?=$style?>><?=stripslashes($arrySaleItem[$Count]["Condition"])?>
		<input type="hidden" name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["Condition"])?>"/></div>
		</td>
<? }?>
        <td><?=stripslashes($arrySaleItem[$Count]["description"])?>
		<input type="hidden" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/>
		</td>
        <td><input type="text" value="<?=$arrySaleItem[$Count]["qty"]?>" size="5" readonly="" class="disabled" id="ordered_qty<?=$Line?>" name="ordered_qty<?=$Line?>"></td>
        <td><input type="text" value="<?=$arrySaleItem[$Count]["qty_received"]?>" size="5" readonly="" class="disabled" id="received_qty<?=$Line?>" name="received_qty<?=$Line?>"></td>
        <td><input type="text" value="" name="qty<?=$Line?>" id="qty<?=$Line?>" onkeypress="return isNumberKey(event);" maxlength="6" size="5" <?=$rd;?> class="<?=$dd;?>">
            <br>
        <?php 
if($arrySaleItem[$Count]["DropshipCheck"] != 1 && $arrySaleItem[$Count]["evaluationType"] == 'Serialized'){

?>
        <a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?= $Line ?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
        <?php }?>
         <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value=""  />
<input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arrySaleItem[$Count]["evaluationType"]?>"  />
        </td>
        <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" readonly="" class="disabled"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/></td>
        <td align="center"><?=$DropshipCheck;?>
        <input type="hidden" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" class="textbox" value="<?=$arrySaleItem[$Count]["DropshipCheck"];?>"/>
        </td>
       <td><input type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>" readonly="" class="disabled" size="6" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["DropshipCost"])?>"/></td>
       <td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" readonly="" class="disabled"  size="6" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>"/></td>
       <td><input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />
		<!--span style="display:<?=$TaxShowHide?>">
		<input type="text" name="tax<?=$Line?>" id="tax<?=$Line?>" size="6" readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax'];?>">
		<input type="hidden" name="tax_id<?=$Line?>" id="tax_id<?=$Line?>" readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax_id'];?>">
		</span-->

	   </td>
       <td align="right">
	   
	   <input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value=""/></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="<?=$numTd?>" align="right">

		 <!--<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>-->
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$subtotal = number_format($subtotal,2);
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight']; // number_format($arrySale[0]['Freight'],2);
		$TotalAmount = $arrySale[0]['TotalAmount']; //number_format($arrySale[0]['TotalAmount'],2);
if($arrySale[0]['CustDisAmt']!='') $displayBlock ="style=display:block;"; else $displayBlock ="style=display:none;";
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="" size="13" style="text-align:right;"/>
		<br><br>

		
<div id="DisType" <?=$displayBlock?>><span id="LevelType"><?=$arrySale[0]['MDType']?></span>

<input type="hidden" align="right" name="MDType" id="MDType" readonly class="disabled"  value="<?=$arrySale[0]['MDType']?>" />: 
<input type="text" align="right" name="CustDiscount" id="CustDiscount" readonly class="disabled"  value="<?=$arrySale[0]['CustDisAmt']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="MDAmount" id="MDAmount" readonly class="disabled"  value="<?=$arrySale[0]['MDAmount']?>" size="13" style="text-align:right;"/>



<input type="hidden" align="right" name="CustDisType" id="CustDisType" class="disabled"  value="<?=$arrySale[0]['CustDisType']?>" />
<br><br>

</div>Tax : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" value="" readonly size="13" style="text-align:right;"/><br><br>
		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="" size="13" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>


<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });
                 
                 $(".slnoclass").fancybox({
			'width'         : 300
		 });
                 
                 

});

</script>

<? //echo '<script>SetInnerWidth();</script>'; ?>
