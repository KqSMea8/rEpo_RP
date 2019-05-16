<?php 
 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
 } 

?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"],input[name^="discount"]', function (event) {
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
            var SerialValue = row.find('input[name^="SerialValue"]').val();

             
            if (qty > 0) {
                var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku +'&serial_value_sel='+serial_value_sel+'&SerialValue='+SerialValue;
                 
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
//update by bhoodev 13Jan for Avg Cost//
function getItemCondionQty(Sku,SelID,Condi){
	
	
	
	if(Sku!='')
	{			
	    ShowHideLoader('1', 'P');    
	    SendUrl = 'action=getItemCondionQty&Sku='+Sku+'&Condi='+Condi;
	    $.ajax({
		    type: "GET",
		    url: "../sales/ajax.php",
		    data: SendUrl,
		    dataType : "JSON",
		    success: function(responseText){                                               
			document.getElementById("on_hand_qty" + SelID).value =responseText["condition_qty"];  

                       
	       		if(responseText["AvgCost"]!='' && typeof responseText["AvgCost"] != 'undefined' ){ 
			
			$ParentItemId = $('#parent_ItemID'+SelID).val();
			$('#avgCost'+SelID).val(responseText["AvgCost"]);
			if($('#parent_ItemID'+SelID).closest('tr').prevAll().length > 0 && $('#parent_ItemID'+SelID).val() != '')
			{
				$MainselID = $('#parent_ItemID'+SelID).closest('tr').prevAll().find('input[name^="item_id"][value="'+$ParentItemId+'"]').last().attr('id').replace(/[^0-9\.]/g, '');
					if($('#Condition'+$MainselID).hasClass('disabled')){
							$start = Number($MainselID)+Number(1);
					}else{			
							$start = Number($MainselID);
					}
			}else{
				$start = $MainselID = SelID;
			}

			if($('#parent_ItemID'+SelID).closest('tr').nextAll().length > 0 && $('#parent_ItemID'+SelID).closest('tr').next().find('input[name^="parent_ItemID"][value!=""]').length > 0)
			{
				if($('#parent_ItemID'+SelID).closest('tr').nextAll().find('input[name^="item_id"][value!=""]').length > 0){				
					$Last = $('#parent_ItemID'+SelID).closest('tr').nextAll().find('input[name^="item_id"][value!=""]').prev().attr('id').replace(/[^0-9\.]/g, '');
				}else{
					$Last = $('#parent_ItemID'+SelID).closest('tr').nextAll().last().find('input[name^="item_id"]').attr('id').replace(/[^0-9\.]/g, '');	
				}
				
				
			}else{
				$Last = SelID;
			}
			
			$totalPrice = 0;
			for(k=$start; k<=$Last;k++)
			{
				if($('#avgCost'+k+'').val()!='')
				{				
				   $totalPrice = Number($totalPrice) + Number($('#avgCost'+k+'').val());
				}	
			}
			//$totalPrice = Number($('#avgCost'+$MainselID+'').val()) + Number(responseText["AvgCost"]);
			$('#avgCost'+$MainselID).val($totalPrice);
			
			}else{
			
				if($('#avgCost'+SelID+'').length == '1' &&  $('#avgCost'+SelID+'').val()!= '')//&& $('#parent_ItemID'+SelID).val()!=''
				{
					$ParentItemId = $('#parent_ItemID'+SelID).val();
					if($('#parent_ItemID'+SelID).closest('tr').prevAll().length > 0 && $('#parent_ItemID'+SelID).val() != '' )
					{
						$MainselID = $('#parent_ItemID'+SelID).closest('tr').prevAll().find('input[name^="item_id"][value="'+$ParentItemId+'"]').last().attr('id').replace(/[^0-9\.]/g, '');
					}else{
						$MainselID = SelID;
						
					}
					
					if($('#avgCost'+SelID+'').val()!= '')
					{
						$totalPrice = Number($('#avgCost'+$MainselID+'').val()) - Number($('#avgCost'+SelID+'').val());
					}

					$('#avgCost'+$MainselID).val($totalPrice.toFixed(2));
					$('#avgCost'+SelID).val('');

					if($('#parent_ItemID'+SelID).closest('tr').next().find('input[name^="parent_ItemID"][value!=""]').length > 0 && $totalPrice==0)
					{		$totalPrice = 0;
							$('input[name^="avgCost"]').each(function(){
																	
												$totalPrice = Number($totalPrice) + Number($(this).val()); 
							})
							$('#avgCost'+$MainselID).val($totalPrice.toFixed(2));
					}

	
				}

			}	


	
			ShowHideLoader('2', 'P');    
		                                
		}
	    }); 
	}	
}

</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading" >SKU</td>
<td width="10%" class="heading">Condition</td>
		<td width="15%" class="heading">Description</td>
		<td width="10%" class="heading">Qty Ordered</td>
		<td width="10%" class="heading">Qty Invoiced</td>
		<td width="10%" class="heading">Qty shipped</td>
		<td width="10%"  class="heading">Qty Ship</td>
		<td width="10%"  class="heading">Unit Price</td>
    <td width="3%" class="heading">Cost</td>
		<td width="10%"  class="heading">Discount</td>
		<td width="6%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$ConditionSelectedDrop  =$objCondition->GetConditionDropValue($arrySaleItem[$Count]["Condition"]);
//echo $arrySaleItem[$Count]["Condition"];
		if($arrySaleItem[$Count]["qty_shipped"] == $arrySaleItem[$Count]["qty"])
		{  
			  
			$textFld = $arrySaleItem[$Count]["qty_shipped"];
			$textFld .= '<input type="hidden"  name="qty'.$Line.'" id="qty'.$Line.'" onkeypress="return isNumberKey(event);" maxlength="6" value ="'.$arrySaleItem[$Count]["qty_shipped"].'" size="5"  class="textbox">';
		  }else{
			 
			  $textFld = '<input type="text" value="" name="qty'.$Line.'" id="qty'.$Line.'"  onkeypress="return isNumberKey(event);" maxlength="6" size="5"  class="textbox">';
		  }
			if(!empty($_GET['ship'])){
			$remainQty = $arrySaleItem[$Count]["qty"];
			}else{
			$remainQty = $arrySaleItem[$Count]["qty"] - $arrySaleItem[$Count]["qty_shipped"];
			}



		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){	
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}


		#$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
                $ReqDisplay = 'style="display:none"';
                

		if($arrySaleItem[$Count]["DropshipCheck"] == 1){
                    $DropshipCheck = 'Yes';
                }else{
                    $DropshipCheck = 'No';
                }
		  
	?>
     <tr class='itembg'>
		<td>
		 <input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arrySaleItem[$Count]["sku"])?>"/><a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>>&nbsp;&nbsp;<img src="../images/tab-new.png" border="0" title="Additional Items"></a>

		 <input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["id"])?>" readonly maxlength="20"  />
	 <input type="hidden" name="parent_ItemID<?=$Line?>" id="parent_ItemID<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["parent_ItemID"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="remainQty<?=$Line?>" id="remainQty<?=$Line?>" value="<?=$remainQty?>" readonly maxlength="20"  />		
<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
 <input type="hidden" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["on_hand_qty"])?>" readonly maxlength="20"  />
		</td>
<td><div <?=$style?>>


<select name="Condition_val<?=$Line?>" disabled id="Condition_val<?=$Line?>" class="disabled"  <?php if($_GET['edit']>0){ ?>onchange="getItemCondionQty('<?=stripslashes($arrySaleItem[$Count]['sku'])?>','<?=$Line?>',this.value)" <?php }?> style="width:110px;"><option value="">Select </option><?=$ConditionSelectedDrop?></select>
<input type="hidden" name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox"  value="<?=stripslashes($arrySaleItem[$Count]["Condition"])?>"/>
 </div></td>
        <td><?=stripslashes($arrySaleItem[$Count]["description"])?>
		<input type="hidden" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/>
<input type="hidden" name="DesComment<?=$Line?>" id="DesComment<?=$Line?>" class="textbox" style="width:150px;"   value="<?=stripslashes($arrySaleItem[$Count]["DesComment"])?>"/>
		</td>
        <td><input type="text" value="<?=$arrySaleItem[$Count]["qty"]?>" size="5" readonly=""  class="disabled" id="ordered_qty<?=$Line?>" name="ordered_qty<?=$Line?>">
        
        
        
        </td>
        <td><input type="text" value="<?=$arrySaleItem[$Count]["qty_received"]?>" size="5" readonly="" class="disabled" id="received_qty<?=$Line?>" name="received_qty<?=$Line?>">
        
         
        
        
        </td>
		<td><?=$arrySaleItem[$Count]["qty_shipped"];?>
                </td>
		<td>


<?=$textFld;?>  <?php   //$arrySaleItem[$Count]["DropshipCheck"] != 1 &&


 if( $arrySaleItem[$Count]["evaluationType"] == 'Serialized' || $arrySaleItem[$Count]["evaluationType"] == 'Serialized Average'){ ?>
                    <br> 
<? if($_GET['edit']>0 && $_GET['ship']!=''){?>

<a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?= $Line ?>&cond=<?=$arrySaleItem[$Count]["Condition"]?>&total=<?=$arrySaleItem[$Count]["qty_shipped"]?>&sku=<?=stripslashes($arrySaleItem[$Count]["sku"])?>&serial_value_sel=&SerialValue=<?=$arrySaleItem[$Count]["SerialNumbers"]?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a>
<? }else{?>
<a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?= $Line ?>&cond=<?=$arrySaleItem[$Count]["Condition"]?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a>
<? }?>
        <?php }?>
             <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?=$arrySaleItem[$Count]["SerialNumbers"]?>"  />
             <input type="hidden" name="SerialValue<?= $Line ?>" id="SerialValue<?= $Line ?>" value="<?=$arrySaleItem[$Count]["SerialNumbers"]?>"  />
<input type="hidden" name="evaluationType<?=$Line?>" id="evaluationType<?=$Line?>" value="<?=$arrySaleItem[$Count]["evaluationType"]?>"  />   
                <input type="hidden" name="DropshipCost<?= $Line ?>" id="DropshipCost<?= $Line ?>" value="<?=$arrySaleItem[$Count]["DropshipCost"]?>"  />
<input type="hidden" name="DropshipCheck<?= $Line ?>" id="DropshipCheck<?= $Line ?>" value="<?=$arrySaleItem[$Count]["DropshipCheck"]?>"  />
                
                </td>
        <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" readonly="" class="disabled" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/>
<!--input type="hidden" name="avgCost<?= $Line ?>" id="avgCost<?= $Line ?>" value="<?=$arrySaleItem[$Count]["avgCost"]?>"  /--></td>

<td>
           <input type="text" <? if($arrySaleItem[$Count]["DropshipCheck"] == 1){?>style="display:none;"<?php }?> name="avgCost<?=$Line?>" id="avgCost<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['avgCost'])?>" class="disabled textbox avgCost formactive" maxlength="6" size="3" readonly>
           <input  <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1 || $disable){?>style="display:none;"<?php }?> type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>"  class="textbox formactive" size="3" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["DropshipCost"])?>"></td>

		<td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" readonly="" class="disabled" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>"/>



</td>
       <td> 
<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />

<!--span style="display:<?=$TaxShowHide?>">
		<input type="text" name="tax<?=$Line?>" id="tax<?=$Line?>" size="5"  readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax'];?>">
		<input type="hidden" name="tax_id<?=$Line?>" id="tax_id<?=$Line?>" readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax_id'];?>">
		</span-->
	   </td>
       <td align="right">
	   
	   <input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=$arrySaleItem[$Count]["amount"]?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="12" align="right">

		 <!--<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>-->
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		//$subtotal = number_format($subtotal,2);
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight']; // number_format($arrySale[0]['Freight'],2);
		$TotalAmount = $arrySale[0]['TotalAmount']; //number_format($arrySale[0]['TotalAmount'],2);
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/>
		<br><br>

		

		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		
		<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$arrySale[0]['taxAmnt']?>" size="13" style="text-align:right;"/><br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
		<br><br>
		<?php
		 echo '<div class=redmsg style="float:left">'.$RtnInvoiceMess.'</div>';
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
			'width'         : 300
		 });
                 
                 

});

</script>
<? echo '<script>SetInnerWidth();</script>'; ?>
