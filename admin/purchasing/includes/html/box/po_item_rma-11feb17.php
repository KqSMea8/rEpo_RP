
<? 


 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arryPurchaseTax);$i++) {
	$TaxRateOption .= "<option value='".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['TaxRate']."'>
	".$arryPurchaseTax[$i]['RateDescription']." : ".$arryPurchaseTax[$i]['TaxRate']."</option>";
 } 
if($arryCompany[0]['TrackInventory'] !=1){ $style ='style="display:block;"'; }
?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	jQuery('.Retype').change(function(){
		calculateGrandTotal();
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


	$("table.order-list").on("click", "#addItem", function(event) {

		//alert('hello');

        /********Edited by pk **********/
        var row = $(this).closest("tr");
        var qty = row.find('input[name^="qty"]').val();
        var serial_sku = row.find('input[name^="sku"]').val();
		var condition=row.find('input[name^="condition"]').val();

        //alert(serial_sku);
        
        var serial_value_sel = row.find('input[name^="serial_value"]').val();
         
        if (qty > 0) {
            var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku+'&condition='+condition ;
          
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
		GlobalRestockingVal();		
		var subtotal=0, TotalAmount=0 , taxAmnt=0; Restocking_fee=0;			
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
		subtotal += +$("#Restocking_fee").val();

		$("#TotalAmount").val(subtotal.toFixed(2));
	}



 function GlobalRestockingVal(){
    	 var total = 0;
         var RestockingVal = $('#RestockingGlobal').val(); 
         var restock=$('#Restocking').val();
         
         //console.log(restock);
         if(restock=='1'){
         $("table.order-list").find("tr.itembg").each(function () {         
         	var objtr = $(this);
         		if(objtr.find('.Retype').val()=="C" || objtr.find('.Retype').val()=="AC"){   		
         			total +=parseFloat(objtr.find('.ReAmnt').val())*RestockingVal/100;	
         		}
         		else{
        	        jQuery('#Restocking_fee').val(total.toFixed(2));
         		}
    			
    		});
         }        
         //console.log(total);
         if(total!=0){
				jQuery('#Restocking_fee').val(total.toFixed(2));
             }
     	 return total;
     	
    }



function RestockingTo(){

    var RestockVal = document.getElementById("Restocking").value;

    if(RestockVal==1){
    	$("#RestVal").show();
    }else{
    	$("#RestVal").hide();
	$("#Restocking_fee").val(0); 
    }
	
   calculateGrandTotal();

}
</script>


 <table width="100%" id="myTable" class="order-list" cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td width="8%" class="heading" >SKU</td>
		
                <td width="10%" class="heading" >Condition</td>
		<td class="heading" >Description</td>
		<td width="8%" class="heading" >Type</td>
		<td width="8%" class="heading" >Action</td>
		<td width="8%" class="heading" >Reason</td>
	
		<td width="15%" class="heading" >Total Qty Invoiced</td>
		<td width="10%" class="heading" >Total Qty RMA</td>
		<td width="10%" class="heading" >Qty RMA</td>
		<td width="8%"  class="heading" >Unit Price</td>
		<td width="5%" class="heading" >Taxable</td>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	

		if(!empty($_GET['edit'])){
			$total_received = $objPurchase->GetQtyInvoiced($arryPurchaseItem[$Count]["ref_id"]);
			$qty_rma = $arryPurchaseItem[$Count]["qty"];
			$total_rma = $objPurchase->GetQtyRma($arryPurchaseItem[$Count]["ref_id"]) - $qty_rma;
				
			$to_return = $total_received - $total_rma;	
		}else{
			$total_received = $arryPurchaseItem[$Count]["qty_received"];
			$total_rma = $objPurchase->GetQtyRma($arryPurchaseItem[$Count]["id"]);	
			$qty_rma = '';
			$to_return = $total_received - $total_rma;
		}


        		
				
        	$ordered_qty = $arryPurchaseItem[$Count]["qty"];
		
		
		$QtyType = ($to_return > 0)?('text'):('hidden');
		


	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}
	
	
	
	 $SlNoHide = 'none';
    if($total_received == $total_rma) { 
    	
    	$DisplayN ='style="display:none;"';
    	
    }else {
	if(!empty($arryPurchaseItem[$Count]["SerialNumbers"])){
            $SlNoHide = 'inline';
	}
    	$DisplayN ='style="display:block;"';
    }
	

	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';

	?>
     <tr class='itembg'>
        <td><?=stripslashes($arryPurchaseItem[$Count]["sku"])?><input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arryPurchaseItem[$Count]['id']?>" readonly maxlength="20"  />
		
		<input type="hidden" name="sku<?=$Line?>" id="sku<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["sku"])?>"/>
		
		</td>

		
	<td><div ><?=stripslashes($arryPurchaseItem[$Count]["Condition"])?>
	<input type="hidden" name="condition<?=$Line?>" id="condition<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["Condition"])?>"/>
	</div></td>
	<td><?=stripslashes($arryPurchaseItem[$Count]["description"])?></td>
        
        <td>
	<div>
		
		<select name="Type<?=$Line?>" id="Type<?=$Line?>" class="textbox Retype" style="width:80px;">
			<option value="C" <?=($arryPurchaseItem[$Count]['Type']=="C")?("selected"):("")?>>Credit</option>
			<option value="R" <?=($arryPurchaseItem[$Count]['Type']=="R")?("selected"):("")?>>Replacement</option>
			<option value="AC" <?=($arryPurchaseItem[$Count]['Type']=="AC")?("selected"):("")?>>Advanced Credit</option>
			<option value="AR" <?=($arryPurchaseItem[$Count]['Type']=="AR")?("selected"):("")?>>Advanced Replacement</option>
		</select>

	</div>
	</td>
		
		<td>
		<div>
		<select name="Action<?=$Line?>" id="Action<?=$Line?>" class="textbox" style="width:80px;">
		<?php 
		foreach($ListRmaValues as $ListRmaVal){?>
			<option value="<?php echo stripslashes($ListRmaVal['action']);?>" <?=($ListRmaVal['action']==$arryPurchaseItem[$Count]['Action'])?("selected"):("")?>><?php echo addslashes($ListRmaVal['action']);?></option>
		<?php }?>
		</select>
		</div>
		</td>
		
		<td>
		<div >
		<select   name="Reason<?=$Line?>" id="Reason<?=$Line?>" class="textbox" style="width:80px;">
		<?php 
		foreach($ListRmaReasonVal as $ListRmaReasonValue){?>
			<option value="<?php echo stripslashes($ListRmaReasonValue['attribute_value']);?>" <?=($ListRmaReasonValue['attribute_value']==$arryPurchaseItem[$Count]['Reason'])?("selected"):("")?>><?php echo stripslashes($ListRmaReasonValue['attribute_value']);?></option>
		<?php }?>
		</select>
		</div>
		</td>
        
  
         <td><?=$total_received?><input type="hidden" name="total_received<?=$Line?>" id="total_received<?=$Line?>" class="disabled" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=$total_received?>"/></td>
         <td><?=number_format($total_rma)?><input type="hidden" name="total_returned<?=$Line?>" id="total_returned<?=$Line?>" class="disabled" readonly size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=number_format($total_rma)?>"/></td>
       <td><input <?=$DisplayN?> type="<?=$QtyType?>" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=$qty_rma?>"/>
		
		<?php  if($arryPurchaseItem[$Count]["evaluationType"] == 'Serialized' && $arryPurchase[0]['OrderType'] != 'Dropship' && $total_rma < $total_received){ ?>
		<span style="display:<?=$SlNoHide?>;"  id="serial<?= $Line ?>">
		<a  <?=$DisplayN?>class="fancybox slnoclass fancybox.iframe" href="addPoSerialRma.php?id=<?= $Line ?>&OrderID=<?=$InvoiceOrderID?>&item_id=<?=$arryPurchaseItem[$Count]['item_id']?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
		<?php }?>
		<?php //$arryPurchaseItem[$Count]["SerialNumbers"]?>
		<input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value=""  /></span>
		<input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arryPurchaseItem[$Count]["evaluationType"]?>"  />
		<input type="hidden" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" class="textbox" value="<?=$arryPurchase[0]['OrderType'];?>"/>
		
		</td>
		
       
      
       <td><?#=number_format($arryPurchaseItem[$Count]["price"],2)?><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox"  size="8" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=$arryPurchaseItem[$Count]["price"]?>"/></td>
       <td> 
<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />


	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled ReAmnt" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=$arryPurchaseItem[$Count]["amount"]?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["amount"];
		

		$TotalQtyReceived += $total_received;
		$TotalToReturn += $to_return;

	} ?>
</tbody>
<tfoot>

     <tr class='itembg'>
        <td colspan="13" align="right">


 <input type="hidden" name="RestockingGlobal" id="RestockingGlobal" value="<?=$RestockingGlobal?>" readonly maxlength="20"  />
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
		<?	
		$taxAmnt = $arryPurchase[0]['taxAmnt'];
		$Freight = $arryPurchase[0]['Freight']; 
		$Restocking_fee =  $arryPurchase[0]['Restocking_fee'];
		$TotalAmount = $arryPurchase[0]['TotalAmount']; 		 
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="15" style="text-align:right;"/>
		<br><br>

		


		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>

		<div id="RestVal" <?=($arryPurchase[0]['Restocking']=='1')?('style="display: inline;"'):('style="display: none;"')?>>
            Re-Stocking Fee : <input type="text" align="right" name="Restocking_fee"
                id="Restocking_fee" class="disabled" readonly  value="<?=$Restocking_fee?>" size="13" maxlength="10"
                onkeypress="return isDecimalKey(event);"
                onblur="calculateGrandTotal();" style="width:143px;text-align:right;" /> <br><br>
        </div>
<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="15" style="text-align:right;"/><br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="15" style="text-align:right;"/>
		<br><br>

<?
		//echo $TotalQtyReceived.'-'.$TotalToReturn;
		

		
		if($TotalQtyReceived<=0){
			echo '<div class=redmsg style="float:left">'.PO_ITEM_NOT_RECEIVED.'</div>';
			$HideSubmit=1;
		}else if($TotalToReturn<=0){
			echo '<div class=redmsg style="float:left">No qauntities left for RMA</div>';
			$HideSubmit=1;
		}
?>

        </td>
    </tr>
</tfoot>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });

});

</script>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });
                 
                 $(".slnoclass").fancybox({
						'width'         : 50%
		 });
                 
                 

});

</script>

<? echo '<script>SetInnerWidth();</script>'; ?>

