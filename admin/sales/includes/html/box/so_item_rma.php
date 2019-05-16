<?php
$styleCond='';
if($arryCompany[0]['TrackInventory'] !=1){ $styleCond ='style="display:none;"'; } 
//echo "<pre>";print_r($arrySaleItem);

$TaxRateOption = "<option value='0'>None</option>";
for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
}
if($arryCompany[0]['TrackInventory'] !=1){

	$style ='style="display:none;"';

}
?>

<input
	type="hidden" name="TaxRateOption" id="TaxRateOption"
	value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("table.order-list").on("keyup", 'input[name^="price"],input[name^="qty"],input[name^="discount"]', function (event) {
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

$('#ReSt').change(function(){
        GlobalRestockingVal();
calculateGrandTotal();
        });
    
    $('.Retype').change(function(){
        GlobalRestockingVal();
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
        
             $("table.order-list").on("click", "#addItem", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var qty = row.find('input[name^="qty"]').val();
            var serial_sku = row.find('input[name^="sku"]').val();
            var serial_value_sel = row.find('input[name^="serial_value"]').val();
            var SerialValue = row.find('input[name^="SerialValue"]').val();
            var condition = row.find('select[name^="Condition"]').val();
            
             
            if (qty > 0) {
               // var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku +'&serial_value_sel='+serial_value_sel+'&SerialValue='+SerialValue;
               var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku+'&condition='+condition ;
                 
                $(this).attr("href", linkhref);
            }
            /*****************************/

        });
$('#Freight').keyup(function(){
    calculateGrandTotal();
});
$('#TDiscount').keyup(function(){
    calculateGrandTotal();
});

$('#ReStocking').keyup(function(){
    calculateGrandTotal();
});

$(document).on('input','.itembg td input[data-qty="y"]',function(){
   
        QtyVAl = $(this).val().replace(/[^0-9\.]/g, '');

        ReqArr = [];
        IndexRow = (parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''))); 
        //if($('#Req_ItemID'+IndexRow+'').val()!='')
        //{
            selItemId = $('#item_id'+IndexRow+'').val();
            ReqArr = $('#Req_ItemID'+IndexRow+'').val().split('#');
            $(this).closest('tr').nextAll().find('td input[data-qty="y"]').each(function(i){

                    Indexing = parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''));  
                    if($('#parent_ItemID'+Indexing+'').val() == selItemId || jQuery.inArray($('#item_id'+Indexing+'').val(),ReqArr) !='-1')
                    {    
                       	$res = QtyVAl * ($('#Org_Qty'+Indexing+'').val().replace(/[^0-9\.]/g,''));
                        $(this).val($res);
                        //$(this).addClass('disabled');
                       // $(this).attr('readonly', 'readonly');
                    }
            });
        //}
     
   })


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
		//GlobalRestockingVal();	
		var subtotal=0, TotalAmount=0 , taxAmnt=0 , ReStocking=0;
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
var TDiscount =	$("#TDiscount").val();
if(TDiscount!=''){

TDiscount = (TDiscount*tax)/100;
taxAmnt = taxAmnt-TDiscount;
}
var fr =	$("#Freight").val();
//freightTaxSet = document.getElementById("freightTxSet").value;
  //freightTaxSet = $("#TaxRate :selected").attr("freight_tax");
var freightTaxSet=document.getElementById("freightTxSet").value ;
console.log(freightTaxSet);
if(fr!='' && tax>0 && freightTaxSet =='Yes'){		
				FrtaxAmnt = (fr*tax)/100;	
				FrtaxAmnt = taxAmnt+FrtaxAmnt;
				taxAmnt  = FrtaxAmnt;
}
if($("#ReSt").val()==1 && tax>0){
var RetaxAmnt = ($("#ReStocking").val()*tax)/100;
console.log(RetaxAmnt);
RetaxAmnt = taxAmnt+RetaxAmnt;
				taxAmnt  = RetaxAmnt;
//subtotal += +RetaxAmnt;
}
taxAmnt = roundNumber(taxAmnt,2);	
		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));

		subtotal += +$("#Freight").val();	
		subtotal += +$("#taxAmnt").val();
		subtotal += -$("#ReStocking").val();
		subtotal += -$("#TDiscount").val();
//subtotal += +RetaxAmnt;

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

 

<?

$TypeInfo = '<img src="'.$MainPrefix.'icons/help.png"  border="0"   onMouseover="ddrivetip(\''.SALES_RMA_TYPE_INFO.'\', 520,\'\')"; onMouseout="hideddrivetip()" >';

?>

<input type="hidden" align="right" name="RsValhidden" id="RsValhidden" readonly size="13" maxlength="10" value="<?=$RsValhidden;?>" />

<table width="100%" id="myTable" class="order-list" cellpadding="0"
	cellspacing="1">
	<thead>
		<tr align="left">
			<td class="heading" width="12%">SKU</td>
			<td class="heading" width="6%">Warehouse</td>
			<td class="heading" width="6%">Condition</td>
			<td class="heading" width="5%">Type

<?=$TypeInfo?>
</td>
			<td class="heading" width="5%">Action</td>
			<td class="heading" width="5%">Reason</td>
			<td class="heading">Description</td>
			<!--  td class="heading">Qty Ordered</td -->
			<td class="heading" width="5%">Qty Invoiced</td>
			<td class="heading" width="5%">Total RMA Qty</td>
			<td class="heading" width="5%">RMA Qty</td>
			<td class="heading" width="5%">Unit Price</td>
			<td class="heading" width="5%">Discount</td>
			<td class="heading" width="5%">Taxable</td>
			<td class="heading rest_td" width="5%" <?=($arrySale[0]['ReSt']=='1')?(''):('style="display: none;"')?> >Re-Stocking Fee</td>
			<td class="heading" width="10%" align="right">Amount</td>
		</tr>
	</thead>
	<tbody>
	<? $subtotal=0;
	$QtyFlag=0;
 
	for($Line=1;$Line<=$NumLine;$Line++) {
		$Count=$Line-1;

		$SlNoHide = 'none';
 		
		if(!empty($_GET['edit'])){
			$totalRmaQuenty = $objrmasale->GetQtyRma($arrySaleItem[$Count]["ref_id"]);
			$qty_invoiced = $objrmasale->GetQtyInvoicedRma($arrySaleItem[$Count]["ref_id"]);
			$qty_rma = $arrySaleItem[$Count]["qty"];
			$totalQtyRma = (!empty($totalRmaQuenty[0]['QtyRma']))?($totalRmaQuenty[0]['QtyRma']):('');			
			$totalQtyRma = $totalQtyRma-$qty_rma;
			
		}else{
			$totalRmaQuenty = $objrmasale->GetQtyRma($arrySaleItem[$Count]["id"]);	
			$qty_invoiced = $arrySaleItem[$Count]["qty_invoiced"];	
			$qty_rma = '';
			$totalQtyRma = (!empty($totalRmaQuenty[0]['QtyRma']))?($totalRmaQuenty[0]['QtyRma']):('');	
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



		if($totalQtyRma>0 && $totalQtyRma == $qty_invoiced)
		{

			$textFld = '';
			$textFld .= '<input type="hidden" value="'.$qty_rma.'" data-qty="y" name="qty'.$Line.'" id="qty'.$Line.'"  onkeypress="return isNumberKey(event);" maxlength="6" size="5"  class="textbox">';
		}else{
			$QtyFlag=1;
			$textFld = '<input type="text" value="'.$qty_rma.'" data-qty="y" name="qty'.$Line.'" id="qty'.$Line.'" onkeypress="return isNumberKey(event);" maxlength="6" size="5"  class="textbox">';

if($arrySaleItem[$Count]["Condition"]=='' && !empty($arrySaleItem[$Count]['req_item'])){

$arrySaleItem[$Count]["evaluationType"] ='';
$readonly = '';
$class2 = 'textbox';

}else{
$class2 = 'textbox';
$readonly = '';
}


			if($arrySaleItem[$Count]["evaluationType"]=='Serialized' || $arrySaleItem[$Count]["evaluationType"]=='Serialized Average' ){
				$SlNoHide = 'inline';
				if($_GET['edit']) { $SerialNumbers = $arrySaleItem[$Count]["SerialNumbers"];} else{ $SerialNumbers= '';}
			}
		}

		$remainQty = $qty_invoiced-$totalQtyRma;



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

		
      $ConditionSelectedDrop  =$objCondition->GetConditionDropValue($arrySaleItem[$Count]["Condition"]);
$warehouseSelectedDrop  =$objCondition-> GetWarehouseDropValue($arrySaleItem[$Count]["WID"]);
    
        //By chetan 29Mar2017 for color//
        
        if(!empty($arrySaleItem[$Count]['parent_item_id'])){
                $disable = 'class = "disabled" readonly="readonly"';
		$color = "style='background-color:#d33f3e'";
		$class = 'child';
        }else{
		if($arrySaleItem[$Count]['req_item']){
            		$color =  "style='background-color:#106db2'";
		 }else{
			$color = '';
		 }
		$class = 'parent';
                $disable = "";
        }//End////End//
if(!empty($_GET['Inv'])){

 $arrySaleItem[$Count]['amount']='0.00'; 

}

		?>
		
			
		<tr class='itembg <?=$class?>' <?=$color?> >
			<td><input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>"
				class="disabled" readonly size="8" maxlength="10"
				value="<?=stripslashes($arrySaleItem[$Count]["sku"])?>" /><a
				class="fancybox reqbox  fancybox.iframe"
				href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>"
				id="req_link<?=$Line?>" <?=$ReqDisplay?>>&nbsp;&nbsp;<img
				src="../images/tab-new.png" border="0" title="Additional Items"></a>
 <input data-parent='y' type="hidden" name="parent_ItemID<?=$Line?>" id="parent_ItemID<?=$Line?>" value="<?=($arrySaleItem[$Count]['parent_item_id']) ? $arrySaleItem[$Count]['parent_item_id'] : '';?>" readonly=""/>
			<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]['item_id'])?>" readonly
				maxlength="20" /> <input type="hidden" name="id<?=$Line?>"
				id="id<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]['id'])?>" readonly
				maxlength="20" /> <input type="hidden" name="remainQty<?=$Line?>"
				id="remainQty<?=$Line?>" value="<?=$remainQty?>" readonly
				maxlength="20" /> <input type="hidden" name="req_item<?=$Line?>"
				id="req_item<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>"
				readonly />

 <input data-ReqItem='y' type="hidden" name="Req_ItemID<?=$Line?>" id="Req_ItemID<?=$Line?>" value="" readonly=""/>
		<input data-OrgQty="y" type="hidden" name="Org_Qty<?=$Line?>" id="Org_Qty<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["Org_Qty"])?>" readonly=""/>
</td>
<td><div <?=$style?>>
<select name="WID_val<?=$Line?>" disabled id="WID_val<?=$Line?>" class="disabled"   style="width:80px;"><?=$warehouseSelectedDrop?></select>
<input type="hidden" name="WID<?=$Line?>" id="WID<?=$Line?>" class="textbox"  value="<?=stripslashes($arrySaleItem[$Count]["WID"])?>"/>
 </div></td>
			<td>
			<div <?=$styleCond?>><select name="Condition<?=$Line?>"
				id="Condition<?=$Line?>" class="<?=$class2?>"  style="width: 80px;">
				<option value="">Select Condition</option>
				<?=$ConditionSelectedDrop?>
			</select></div>
 <!--input  type="hidden" name="Condition<?=$Line?>" id="Condition<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["Condition"])?>" readonly=""/-->
			</td>



<td><select name="Type<?=$Line?>" id="Type<?=$Line?>" class="textbox Retype" style="width:61px; ">
	 
	<option value="C" <?=($arrySaleItem[$Count]['Type']=="C")?("selected"):("")?>>Credit</option>
	<option value="R" <?=($arrySaleItem[$Count]['Type']=="R")?("selected"):("")?>>Replacement</option>
	<option value="AC" <?=($arrySaleItem[$Count]['Type']=="AC")?("selected"):("")?>>Advanced Credit</option>
	<option value="AR" <?=($arrySaleItem[$Count]['Type']=="AR")?("selected"):("")?>>Advanced Replacement</option>
</select></td>

			<td><select name="Action<?=$Line?>" id="Action<?=$Line?>" class="textbox" style="width:61px; ">
				 
				<?php
				foreach($ListRmaValues as $ListRmaVal){?>
				<option value="<?php echo stripslashes($ListRmaVal['action']);?>" <?=($ListRmaVal['action']==$arrySaleItem[$Count]['Action'])?("selected"):("")?>><?php echo addslashes($ListRmaVal['action']);?></option>
				<?php }?>
			</select></td>

			<td><select name="Reason<?=$Line?>" id="Reason<?=$Line?>" class="textbox" style="width:61px; ">
				 

				<?php
				foreach($ListRmaReasonVal as $ListRmaReasonValue){?>
				<option
					value="<?php echo stripslashes($ListRmaReasonValue['attribute_value']);?>" <?=($ListRmaReasonValue['attribute_value']==$arrySaleItem[$Count]['Reason'])?("selected"):("")?>><?php echo addslashes($ListRmaReasonValue['attribute_value']);?></option>
					<?php }?>

			</select></td>


			<td><?=stripslashes($arrySaleItem[$Count]["description"])?> 
<input type="hidden" name="description<?=$Line?>"	id="description<?=$Line?>" class="textbox" style="width: 150px;" maxlength="50" onkeypress="return isAlphaKey(event);"	value="<?=stripslashes($arrySaleItem[$Count]["description"])?>" /></td>
			<!--td><input type="text" value="<?=$arrySaleItem[$Count]["qty"]?>" size="5" readonly="" class="disabled" id="ordered_qty<?=$Line?>" name="ordered_qty<?=$Line?>"-->
			</td>
			<td><input type="text"
				value="<?=$qty_invoiced?>" size="3"
				readonly="" class="disabled" id="received_qty<?=$Line?>"
				name="received_qty<?=$Line?>"></td>
			<td><input type="text" value="<?=$totalQtyRma?>"
				size="3" readonly="" class="disabled"></td>
			<td><?=$textFld;?> <span style="display:<?=$SlNoHide?>;"  id="serial<?= $Line ?>">
			<?php if($arrySaleItem[$Count]["DropshipCheck"]==1){?>
<a  class="fancybox slnoclass fancybox.iframe" href="../warehouse/addPOSerial.php?id=<?= $Line ?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
<input	type="hidden" name="serialdesc<?= $Line ?>"	id="serialdesc<?= $Line ?>"	value="" />
<? }else{?>
			<a class="fancybox slnoclass fancybox.iframe"
				href="addSerialRma.php?id=<?= $Line ?>&OrderID=<?=$InvoiceOrderID?>&item_id=<?=$arrySaleItem[$Count]['item_id']?>&Lid=<?=$arrySaleItem[$Count]['id']?>" id="addItem">
				<img src="../images/tab-new.png" title="Serial number">&nbsp;Add S.N.</a> 
<? }?>
				<input type="hidden" name="serial_value<?= $Line ?>"	value="<?=$SerialNumbers?>"			id="serial_value<?= $Line ?>"
				value="" />
				<input type="hidden" name="serial_return_value<?= $Line ?>"	id="serial_return_value<?= $Line ?>" value="<?=$SerialNumbers?>"			value="" />
				<input type="hidden" name="avgcost<?= $Line ?>"
				id="avgcost<?= $Line ?>"
				value="<?=$arrySaleItem[$Count]['avgCost']?>" />
				 </span> 
<input	type="hidden" name="evaluationType<?= $Line ?>"	id="evaluationType<?= $Line ?>"	value="<?=$arrySaleItem[$Count]["evaluationType"]?>" /></td>
			<td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>"
				 class="textbox" class="textbox" size="5"
				maxlength="10" onkeypress="return isDecimalKey(event);"
				value="<?=stripslashes($arrySaleItem[$Count]["price"])?>" /></td>
			<td><input type="text" name="discount<?=$Line?>"
				id="discount<?=$Line?>"   class="textbox" class="textbox"
				size="3" maxlength="10" onkeypress="return isDecimalKey(event);"
				value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>" /></td>
			<td><input type="text" class="normal" name="item_taxable<?=$Line?>"
				id="item_taxable<?=$Line?>"
				value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly
				size="2" maxlength="20" /> <!--span style="display:<?=$TaxShowHide?>">
		<input type="text" name="tax<?=$Line?>" id="tax<?=$Line?>" size="5"  readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax'];?>">
		<input type="hidden" name="tax_id<?=$Line?>" id="tax_id<?=$Line?>" readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax_id'];?>"></span-->
<input type="hidden" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" readonly="" value="<?=$arrySaleItem[$Count]["DropshipCheck"];?>">
<input type="hidden" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>" readonly="" value="<?=$arrySaleItem[$Count]["DropshipCost"];?>">
		</td>

		<td class="rest_td" <?=($arrySale[0]['ReSt']=='1')?(''):('style="display: none;"')?> ><input type="text" name="restocking_fee<?=$Line?>"
				id="restocking_fee<?=$Line?>"   class="textbox" class="textbox"
				size="3" maxlength="10" onkeypress="return isDecimalKey(event);"
				value="<?=stripslashes($arrySaleItem[$Count]["fee"])?>" <?=($arrySaleItem[$Count]['Type']=="C" || $arrySaleItem[$Count]['Type']=="AC")?(""):('style="display: none;"')?> /></td>


			<td align="right"><input type="text" align="right"
				name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled"
				readonly size="10" maxlength="10"
				onkeypress="return isDecimalKey(event);" style="text-align: right;"
				value="<?=$arrySaleItem[$Count]['amount']?>" /></td>
				
				
			
				
				

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
				readonly />
				<?				
				$taxAmnt = $arrySale[0]['taxAmnt'];
				$Freight = $arrySale[0]['Freight']; 
				$ReStocking = $arrySale[0]['ReStocking'];
$TDiscount = $arrySale[0]['TDiscount'];
				$TotalAmount = $arrySale[0]['TotalAmount']; 
				?> <br>
			Sub Total : <input type="text" align="right" name="subtotal"
				id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13"
				style="text-align: right;" /> <br>
			<br>

			
<? 
     
   if(!empty($arryShippInfo[0]['totalFreight'])){
	$ActualFreightDisplay = '';
	$ActualFreight = $arryShippInfo[0]['totalFreight'];	
   }else{
	$ActualFreightDisplay = 'style="display:none"';
	$ActualFreight =  '';
   }	
?>
 <div id="ActualFreightDiv" <?=$ActualFreightDisplay?>>Actual Freight :
        <input type="text" align="right" name="ActualFreight" id="ActualFreight" class="disabled" readonly value="<?=$ActualFreight?>" size="13" style="text-align:right;"/><br><br>
</div>




			Freight : <input type="text" align="right" name="Freight"
				id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10"
				onkeypress="return isDecimalKey(event);"
				onblur="calculateGrandTotal();" style="text-align: right;" /> <br>
			<br>


			<div id="ReSID" <?=($arrySale[0]['ReSt']=='1')?(''):('style="display: none;"')?> >
			<span style="color:red;">Re-Stocking Fee :</span> <input type="text" align="right" name="ReStocking"
				id="ReStocking" class="disabled" readonly value="<?=$ReStocking?>"  size="13" maxlength="10"
				onkeypress="return isDecimalKey(event);"
				onblur="calculateGrandTotal();" style="text-align: right; color:red;" /> <br><br>
			</div>
Add'l Discount : <input type="text" align="right" name="TDiscount" id="TDiscount" class="textbox" value="<?=$TDiscount?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right; color:red;"/>
		<br><br>
<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt"
				class="textbox"  value="<?=$taxAmnt?>" size="13"
				style="text-align: right;" /><br>
			<br>

			Grand Total : <input type="text" align="right" name="TotalAmount"
				id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13"
				style="text-align: right;" /> <br>
			<br>
			<?php
			if($QtyFlag==0){
				$HideSubmit=1;
			 echo '<div class=redmsg style="float:left">'.SO_ITEM_TO_NO_RETURN.'</div>';
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

