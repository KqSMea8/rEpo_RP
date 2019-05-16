<?php
//echo "<pre>";print_r($arrySale);

$TaxRateOption = "<option value='0'>None</option>";
for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
}
?>
<input type="hidden" name="TaxRateOption" id="TaxRateOption"
	value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">


	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"],input[name^="discount"]', function (event) {
		calculateRow($(this).closest("tr"));
		GlobalRestockingVal();
		calculateGrandTotal();
	});

	$("table.order-list").on("keyup", 'input[name^="restocking_fee"]', function (event) {
		calculateRow($(this).closest("tr"));
		GlobalRestockingVal(1);
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
            var SerialValue = row.find('input[name^="SerialValue"]').val();
            var condition= row.find('input[name^="Condition"]').val();
            var ReturnOrderID=jQuery('#ReturnOrderID').val();
             
            if (qty > 0) {
            //    var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku +'&serial_value_sel='+serial_value_sel+'&SerialValue='+SerialValue;
                  var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku+'&condition='+condition+'&OrderID='+ReturnOrderID;
                 
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
		
		var discount = +row.find('input[name^="discount"]').val();
		var item_taxable = row.find('input[name^="item_taxable"]').val();

		var TotalDisCount = discount*qty;
		var SubTotal = price*qty;
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
		var subtotal=0, TotalAmount=0 ,rsVal=0, taxAmnt=0;		
		var item_taxable = ''; 	
var freightTaxSet='';	
var FrtaxAmnt = 0;
//var fr ='';
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


var TDiscount =	$("#TDiscount").val();
if(TDiscount!=''){

TDiscount = (TDiscount*tax)/100;
taxAmnt = taxAmnt-TDiscount;
}
		var fr = $("#Freight").val();
		freightTaxSet = document.getElementById("freightTxSet").value;		 
		console.log(freightTaxSet);
		if(fr!='' && tax>0 && freightTaxSet =='Yes'){		
			FrtaxAmnt = (fr*tax)/100;	
			FrtaxAmnt = taxAmnt+FrtaxAmnt;
			taxAmnt  = FrtaxAmnt;
		}


		taxAmnt = roundNumber(taxAmnt,2);	


		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));

		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();

        rsVal = $("#ReStocking").val();

		if(rsVal != null){
			subtotal += -$("#ReStocking").val();
		}
subtotal += -$("#TDiscount").val();
		$("#TotalAmount").val(subtotal.toFixed(2));
	}





function GlobalRestockingVal(opt){
	var total = 0;
	var RestockingVal = $('#RsValhidden').val();
	var restock=$('#ReSt').val();
	var restocking_fee = 0;
	var amount = 0;

	if(restock=='1'){
		$('#ReSID').show();  $('.rest_td').show(); 
		$("table.order-list").find("tr.itembg").each(function () {
			var objtr = $(this);
			restocking_fee = 0;
			amount = 0;
			if(objtr.find('.Retype').val()=="C" || objtr.find('.Retype').val()=="AC"){
				$(this).closest("tr").find('input[name^="restocking_fee"]').show();
				amount = $(this).closest("tr").find('input[name^="amount"]').val();

				if(opt==1){
					if(amount>0){
						restocking_fee = parseFloat($(this).closest("tr").find('input[name^="restocking_fee"]').val());
					}else{
						restocking_fee=0;
						$(this).closest("tr").find('input[name^="restocking_fee"]').val(restocking_fee);
					}

				}else{		

					if(amount>0){
						restocking_fee = parseFloat(amount)*RestockingVal/100;
						
					}
					$(this).closest("tr").find('input[name^="restocking_fee"]').val(restocking_fee);
				}
 
				total += restocking_fee;
 
			}else{
				
				$(this).closest("tr").find('input[name^="restocking_fee"]').val('0');
				$(this).closest("tr").find('input[name^="restocking_fee"]').hide();

				$('#ReStocking').val(total.toFixed(2));
			}
		});
	}else{
		$('#ReSID').hide();  $('.rest_td').hide(); 
		$('#ReStocking').val('0');
		$('.rest_td').closest("tr").find('input[name^="restocking_fee"]').val('0');
	}
 
	if(total>0){
		$('#ReStocking').val(total.toFixed(2));
	}
	return total;

}

</script>

<input type="hidden" align="right" name="RsValhidden" id="RsValhidden" readonly size="13" maxlength="10" value="<?=$RsValhidden;?>" />

<table width="100%" id="myTable" class="order-list" cellpadding="0"
	cellspacing="1">
	<thead>
		<tr align="left">
			<td class="heading">SKU</td>
			<td width="20%" class="heading">Description</td>
      <td width="10%" class="heading">Warehouse</td>
			<td width="10%" class="heading">Condition</td>
			<td width="10%" class="heading">Type</td>
			<td width="10%" class="heading">Action</td>
			<td width="10%" class="heading">Reason</td>
			<!--  td width="10%" class="heading">Qty Ordered</td-->
			<td width="7%" class="heading">Qty RMA</td>
			<td width="10%" class="heading">Original Qty Returned</td>
			<td width="7%" class="heading">Qty Return</td>
			
			<td width="10%" class="heading">Unit Price</td>
			<td width="10%" class="heading">Discount</td>
			<td width="6%" class="heading">Taxable</td>
			<td class="heading rest_td" width="5%" <?=($arrySale[0]['ReSt']=='1')?(''):('style="display: none;"')?> >Re-Stocking Fee</td>
			<td width="12%" class="heading" align="right">Amount</td>
		</tr>
	</thead>
	<tbody>
	<?
 	$TotalAmount=0;
	$textFld ='';
	$subtotal=0;
	$QtyFlag=0;
	for($Line=1;$Line<=$NumLine;$Line++) {
		$Count=$Line-1;

		$SlNoHide = 'none';	
	
	


		 $valReceipt = $objWarehouseRma->GetSumQtyReceipt($arrySaleItem[$Count]['OrderID'],$arrySaleItem[$Count]['item_id']);
			
		$TypeVal = $objWarehouseRma->WarehouseRmaTypeValue($arrySaleItem[$Count]["Type"]);
		 
		
		$remainQty = $arrySaleItem[$Count]["qty"]-$valReceipt; 
		 
		if($remainQty<=0)
		{

			//$textFld = $arrySaleItem[$Count]["qty_returned"];
			$textFld .= '<input type="hidden" value="" name="qty'.$Line.'" id="qty'.$Line.'" onkeypress="return isNumberKey(event);" maxlength="6" size="4"  class="textbox">';
		}else{
			 $QtyFlag=1;
			 
			$textFld = '<input type="text" value="" name="qty'.$Line.'" id="qty'.$Line.'" onkeypress="return isNumberKey(event);" maxlength="6" size="4"  class="textbox">';
			if(!empty($arrySaleItem[$Count]["SerialNumbers"])){
	           		 $SlNoHide = 'inline';
			}
		}
		
	
   $checkProduct=$objConfig->IsItemSku($arrySaleItem[$Count]["sku"]);

		
		if(empty($checkProduct))
		{
		$arryAlias = $objConfig->IsItemAliasSku($arrySaleItem[$Count]["sku"]);
			if(count($arryAlias))
			{

					$mainSku = $arryAlias[0]['sku'];
					$arrySaleItem[$Count]['description'] = $arryAlias[0]['description'];
					$arrySaleItem[$Count]['evaluationType'] = $arryAlias[0]['evaluationType'];
					$arrySaleItem[$Count]['item_id'] = $arryAlias[0]['ItemID'];
			}
		}else{

		$mainSku = $arrySaleItem[$Count]["sku"];
		}

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

		$binList = $objWarehouseRma->getWareHouseByAction($arrySaleItem[$Count]['Action']);
		//echo "<pre>";print_r($binList);
		
		    $ConditionSelectedDrop = $objCondition->GetConditionDropValue($arrySaleItem[$Count]["Condition"]);
         $warehouseSelectedDrop  =$objCondition-> GetWarehouseDropValue($arrySaleItem[$Count]["WID"]);
		    
		    if(($arrySaleItem[$Count]["evaluationType"] =='Serialized Average' || $arrySaleItem[$Count]["evaluationType"] =='Serialized') && empty($arrySaleItem[$Count]['req_item'])){
$SlNoHide = '';

        }
		    

		?>

		<tr class='itembg'>
			<td><input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" 		value="<?=stripslashes($arrySaleItem[$Count]["sku"])?>" />
<input type="hidden" name="mainSku<?=$Line?>" id="mainSku<?=$Line?>" class="disabled" readonly 		value="<?=stripslashes($mainSku)?>" />
			<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]["item_id"])?>" readonly
				maxlength="20" /> <input type="hidden" name="id<?=$Line?>"
				id="id<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]["id"])?>" readonly
				maxlength="20" /> <input type="hidden" name="remainQty<?=$Line?>"
				id="remainQty<?=$Line?>" value="<?=$remainQty?>" readonly
				maxlength="20" /> <input type="hidden" name="req_item<?=$Line?>"
				id="req_item<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>"
				readonly /></td>


			<td><?=stripslashes($arrySaleItem[$Count]["description"])?> <input
				type="hidden" name="description<?=$Line?>"
				id="description<?=$Line?>" class="textbox" style="width: 150px;"
				maxlength="50" onkeypress="return isAlphaKey(event);"
				value="<?=stripslashes($arrySaleItem[$Count]["description"])?>" /></td>
<td><div>
<select name="WID_val<?=$Line?>" disabled id="WID_val<?=$Line?>" class="disabled"   style="width:80px;"><?=$warehouseSelectedDrop?></select>
<input type="hidden" name="WID<?=$Line?>" id="WID<?=$Line?>" class="textbox"  value="<?=stripslashes($arrySaleItem[$Count]["WID"])?>"/>
 </div></td>

	     <td><?=stripslashes($arrySaleItem[$Count]["Condition"])?>
		<input type="hidden" name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50"  value="<?=stripslashes($arrySaleItem[$Count]['Condition'])?>"/>
		</td>


	          <td>
<?=$TypeVal;?>
	          <input type="hidden" value="<?=stripslashes($arrySaleItem[$Count]["Type"])?>"
				size="20" readonly="" class="disabled Retype" id="Type<?=$Line?>"
				name="Type<?=$Line?>"></td>
				
				
					<td><?=stripslashes($arrySaleItem[$Count]["Action"])?><input type="hidden" value="<?=stripslashes($arrySaleItem[$Count]["Action"])?>"
				size="20" readonly="" class="disabled" id="Action<?=$Line?>"
				name="Action<?=$Line?>"></td>
				
					<td><?=stripslashes($arrySaleItem[$Count]["Reason"])?><input type="hidden" value="<?=stripslashes($arrySaleItem[$Count]["Reason"])?>"
				size="20" readonly="" class="disabled" id="Reason<?=$Line?>"
				name="Reason<?=$Line?>"></td>
				
				
				

			<!--  td><input type="text" value="<?=$arrySaleItem[$Count]["qty"]?>"
				size="3" readonly="" class="disabled" id="ordered_qty<?=$Line?>"
				name="ordered_qty<?=$Line?>"></td-->
			<td><input type="text"
				value="<?=$arrySaleItem[$Count]["qty"]?>" size="3"
				readonly="" class="disabled" id="received_qty<?=$Line?>"
				name="received_qty<?=$Line?>"></td>
			<td><input type="text" value="<?=$valReceipt;?>" size="3" readonly=""
				class="disabled"></td>
 <td>

           
          <?=$textFld;?> 
           

			
			
		
		<br>
		
		<span style="display:<?=$SlNoHide?>;"  id="serial<?= $Line ?>">
			<?php if($arrySaleItem[$Count]["DropshipCheck"]==1){?>
<a  class="fancybox slnoclass fancybox.iframe" href="addPOSerial.php?id=<?= $Line ?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
<input	type="hidden" name="serialdesc<?= $Line ?>"	id="serialdesc<?= $Line ?>"	value="" />
<? }else{?>
			<a class="fancybox slnoclass fancybox.iframe"
				href="addRmaSerial.php?id=<?= $Line ?>" id="addItem"><img
				src="../images/tab-new.png" title="Serial number">&nbsp;Select S.N.</a>
<? }?>
		</span>

				<input type="hidden" name="serial_value<?= $Line ?>"
				id="serial_value<?= $Line ?>" value="<?=$arrySaleItem[$Count]["SerialNumbers"]?>" /> <input type="hidden"
				name="SerialValue<?= $Line ?>" id="SerialValue<?= $Line ?>"
				value="<?=$arrySaleItem[$Count]["SerialNumbers"]?>" /> <input
				type="hidden" name="evaluationType<?= $Line ?>"
				id="evaluationType<?= $Line ?>"
				value="<?=$arrySaleItem[$Count]["evaluationType"]?>" />


<input type="hidden" name="avgcost<?= $Line ?>"
				id="avgcost<?= $Line ?>"
				value="<?=$arrySaleItem[$Count]['avgCost']?>" />
</td>

			<!--td><select name="bin<?=$Line?>" id="bin<?=$Line?>" class="inputbox" style="width:132px">
				<option value="">--Select--</option>

				<?php
				if(sizeof($binList)>0){
					foreach($binList as $Bls){?>
				<option value="<?php echo $Bls['binid']."_".$Bls['warehouse_id'];?>"><?php echo $Bls['binlocation_name'];?></option>
				<?php }
				}
				?>

			</select></td-->


			<td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>"
				readonly="" class="disabled" class="textbox" size="10"
				maxlength="10" onkeypress="return isDecimalKey(event);"
				value="<?=stripslashes($arrySaleItem[$Count]["price"])?>" /></td>
			<td><input type="text" name="discount<?=$Line?>"
				id="discount<?=$Line?>" readonly="" class="disabled" class="textbox"
				size="5" maxlength="10" onkeypress="return isDecimalKey(event);"
				value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>" /></td>
			<td><input type="text" class="normal" name="item_taxable<?=$Line?>"
				id="item_taxable<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly
				size="2" maxlength="20" /> <!--span style="display:<?=$TaxShowHide?>">
		<input type="text" name="tax<?=$Line?>" id="tax<?=$Line?>" size="5"  readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax'];?>">
		<input type="hidden" name="tax_id<?=$Line?>" id="tax_id<?=$Line?>" readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax_id'];?>">
		</span--><input type="hidden" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" size="5"  readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]["DropshipCheck"]?>">

<input type="hidden" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=$arrySaleItem[$Count]["DropshipCost"]?>"/></td>

		
			<td class="rest_td" <?=($arrySale[0]['ReSt']=='1')?(''):('style="display: none;"')?> ><input type="text" name="restocking_fee<?=$Line?>"
				id="restocking_fee<?=$Line?>"   class="textbox" class="textbox"
				size="3" maxlength="10" onkeypress="return isDecimalKey(event);"
				value="<?=stripslashes($arrySaleItem[$Count]["fee"])?>" <?=($arrySaleItem[$Count]['Type']=="C" || $arrySaleItem[$Count]['Type']=="AC")?(""):('style="display: none;"')?> /></td>


			<td align="right"><input type="text" align="right"
				name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled"
				readonly size="13" maxlength="10"
				onkeypress="return isDecimalKey(event);" style="text-align: right;"
				value="0.00" /></td>

		</tr>
		<?
		$subtotal += $arrySaleItem[$Count]["amount"];
		
		
		
		
	} ?>
	</tbody>
	<tfoot>

		<tr class='itembg'>
			<td colspan="15" align="right"><!--<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>-->
			<input type="hidden" name="NumLine" id="NumLine"
				value="<?=$NumLine?>" readonly maxlength="20" /> <input
				type="hidden" name="DelItem" id="DelItem" value="" class="inputbox"
				readonly /> <?	
				//$subtotal = number_format($subtotal,2);
				$taxAmnt = $arrySale[0]['taxAmnt'];
				$Freight = $arrySale[0]['Freight'];  

				
				if(!empty($arrySale[0]['TotalAmount'])){
					$TotalAmount = $arrySale[0]['TotalAmount'];  
				}

				$TDiscount=0;
				if(!empty($arrySale[0]['TDiscount'])){
					$TDiscount = $arrySale[0]['TDiscount'];  
				}


				?> <br>
			Sub Total : <input type="text" align="right" name="subtotal"
				id="subtotal" class="disabled" readonly value="" size="13"
				style="text-align: right;" /> <br><br>
			

 <div id="ActualFreightDiv" style="display:none">Actual Freight :
        <input type="text" align="right" name="ActualFreight" id="ActualFreight" class="disabled" readonly value="0" size="13" style="text-align:right;"/><br><br>
</div>

			
			Freight : <input type="text" align="right" name="Freight"
				id="Freight" class="textbox" value="" size="13" maxlength="10"
				onkeypress="return isDecimalKey(event);"
				onblur="calculateGrandTotal();" style="text-align: right; " /> <br><br>



		
		Add'l Discount  : <input type="text" align="right" name="TDiscount" id="TDiscount" class="textbox" value="<?=$TDiscount?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;color:red;"/>
		<br><br>

 
		   <div id="ReSID" <?=($arrySale[0]['ReSt']=='1')?(''):('style="display: none;"')?> >
		    <span style="color:red;">Re-Stocking Fee: </span><input type="text" align="right" name="ReStocking"
				id="ReStocking" class="disabled" readonly value="<?=$arrySale[0]['ReStocking'];?>" size="13" maxlength="10"
				onkeypress="return isDecimalKey(event);"
				onblur="calculateGrandTotal();" style="text-align: right;color:red;" /> <br> <br>
		    </div>
		   
		 

		    	<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt"
				class="textbox"  value="" size="13"
				style="text-align: right;" /><br>
			<br>
		
			
		    
			Grand Total : <input type="text" align="right" name="TotalAmount"
				id="TotalAmount" class="disabled" readonly value="" size="13"
				style="text-align: right;" /> <br>
			<br>
			<?php
			
			if($QtyFlag==0){
				
								 
				$HideSubmit=1;
		 		echo '<div class=redmsg style="float:left">No quantities are left to Receipt for this RMA.</div>';
			}
		 ?></td>
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
