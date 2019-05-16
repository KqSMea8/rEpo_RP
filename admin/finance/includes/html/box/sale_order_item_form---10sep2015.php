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


		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="disabled" readonly size="10" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="../sales/SelectItem.php?proc=Sale&id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /></td><td><div <?=$style?>><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionDrop?></select></div></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:100px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><input type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" /><span style="display:none;" id="serial' + counter + '"><a class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=' + counter + '" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a><input type="hidden" name="serial_value' + counter + '" id="serial_value' + counter + '" value=""  /></span><input type="hidden" name="evaluationType' + counter + '" id="evaluationType' + counter + '" value=""  /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);"/><input type="hidden" align="right" name="CustDiscount' + counter + '" id="CustDiscount' + counter + '" readonly class="disabled"  value="" /></td><td align="center"><input type="checkbox" name="DropshipCheck'+counter+'" id="DropshipCheck'+counter+'" onclick="return dropshipcost('+counter+');"></td><td><input type="text" name="DropshipCost'+counter+'" id="DropshipCost'+counter+'" style="display:none;"  class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);"></td><td><input type="text" name="discount' +counter+ '" id="discount' +counter+ '" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" /></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" readonly size="2" maxlength="20"  /><!--select name="tax' + counter + '" id="tax' + counter + '" class="textbox" style="width:120px;display:'+TaxShowHide+'">'+TaxRateOption+'</select--></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="DropshipCost"],input[name^="qty"],input[name^="discount"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});

         $("table.order-list").on("click", 'input[name^="DropshipCheck"]', function (event) {
		
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
        

	


//By Chetan//
        $("table.order-list").on("focus",'input[name^="sku"]', function (event) {
			
			var add_req_flag = $(this).closest("tr").find('input[name^="add_req_flag"]').val();
			if(add_req_flag == 0){
			  addRequiredItem($(this).closest("tr"));
			}		
	});


	});
        
        
        function addRequiredItem(row) { 
			
			var req_item = row.find('input[name^="req_item"]').val();
			//var no_req_item = row.find('input[name^="no_req_item"]').val();
			if(req_item != ''){
				var req_itm_sp = req_item.split("#");	
				var req_item_length = req_itm_sp.length;
			}	
	
			//FOR ITEM DELETE CODE//
			var old_req_item = row.find('input[name^="old_req_item"]').val();
              
			if(old_req_item != ''){
				var old_req_itm_sp = old_req_item.split("#");	
				var lenOldReqItem = old_req_itm_sp.length;
			}
			
			var NumLineOld =  parseInt($("#NumLine").val());

		   if(lenOldReqItem > 0){

			for(var f = 0; f<lenOldReqItem; f++){
				var oldreqItem = old_req_itm_sp[f];
				var old_req_itm_sp_pipe = oldreqItem.split("|");
			  for(var a = 1; a<=NumLineOld; a++){
				if(document.getElementById("sku"+a) != null){
                                            
					if(document.getElementById("sku"+a).value == old_req_itm_sp_pipe[1])
						{
                                                     
                                                      var rowTR =  $("#sku"+a).closest("tr");
                                                      var skutemp = rowTR.find('input[name^="sku"]').val();
                                                     // alert(old_req_itm_sp_pipe[1]+"=="+skutemp);
                                                      
                                                      	var id = rowTR.find('input[name^="id"]').val(); 
                                                        if(id>0){
                                                                var DelItemVal = $("#DelItem").val();
                                                                if(DelItemVal!='') DelItemVal = DelItemVal+',';
                                                                $("#DelItem").val(DelItemVal+id);
                                                        }
                                                        /*****************************/
                                                        rowTR.remove();
                                                       			
							 
                                                }
						

				   }	
			  }
			}		
	          }

		//END ITEM DELETE CODE//

		//FOR ITEM ADD CODE//
 		 
		if(req_item_length > 0){
			for(var r = 1; r<=req_item_length; r++){
				$("#addrow").click();
			}

			var NumLine =  parseInt($("#NumLine").val());

					
			for(var s = 0; s < req_item_length; s++){
				var reqItem = req_itm_sp[s];
				var req_itm_sp_pipe = reqItem.split("|");
				 

				for(var m = 1; m<=NumLine; m++){
				if(document.getElementById("sku"+m) != null){
					if(document.getElementById("sku"+m).value == "")
						{
							document.getElementById("item_id"+m).value = req_itm_sp_pipe[0];
							document.getElementById("sku"+m).value = req_itm_sp_pipe[1];
							document.getElementById("description"+m).value = req_itm_sp_pipe[2];
							document.getElementById("qty"+m).value = req_itm_sp_pipe[3];
							document.getElementById("on_hand_qty"+m).value = req_itm_sp_pipe[4];
							document.getElementById("price"+m).value = '0.00';
                                                        document.getElementById("price"+m).disabled=true;
                                                        document.getElementById("price"+m).setAttribute("class", "disabled");
                                                        //class="disabled"
							break;	
                                                }		

				   }	
				}		
			}

		}	
			
		//END ITEM ADD CODE//
		        
		row.find('input[name^="add_req_flag"]').val('1');		

	}
        
        
      //End//  

	function calculateRow(row) {
		var taxRate = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		//var taxRate = row.find('select[name^="tax"]').val();

		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();		
		var discount = +row.find('input[name^="discount"]').val();
		var TotalDisCount = discount*qty;
                var DropshipCost = +row.find('input[name^="DropshipCost"]').val();
                var item_taxable = row.find('input[name^="item_taxable"]').val();

	    if(discount>0 && discount>=price)
		{
		   alert("Discount Should be Less Than Unit Price!");
		   return false;
		}
		var SubTotal = price*qty+DropshipCost*qty;
			if(TotalDisCount > 0){
				SubTotal = SubTotal-TotalDisCount;
			}
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


		for(var i=1;i<=NumLine;i++){
			var TaxElement = document.getElementById("tax"+i);
			var ItemTaxableElement = document.getElementById("item_taxable"+i);
			if(TaxElement != null){
				var ShowHideTax = 'none';
				if(tax_auths=="Yes" && ItemTaxableElement.value=="Yes"){
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
        
        
        
        function ProcessTotalOld() {
		var Taxable = $("#Taxable").val();
		var NumLine = document.getElementById("NumLine").value;
		
		var Reseller='';
		if(document.getElementById("Reseller1").checked){
			Reseller='Yes';
		}


		for(var i=1;i<=NumLine;i++){
			var TaxElement = document.getElementById("tax"+i);
			var ItemTaxableElement = document.getElementById("item_taxable"+i);
			if(TaxElement != null){
				var ShowHideTax = 'none';
				if(Taxable=="Yes" && Reseller!="Yes" && ItemTaxableElement.value=="Yes"){
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

    //FOR DROP SHIP

function dropshipcost(num){
      var SlnoHide = 'none';
      	if(document.getElementById("DropshipCheck"+num).checked == true)
        {
            document.getElementById("DropshipCost"+num).style.display = 'inline';
	    SlnoHide = 'none';           
        }else{
            document.getElementById("DropshipCost"+num).style.display = 'none';
            document.getElementById("DropshipCost"+num).value='0';
	    if(document.getElementById("evaluationType"+num).value == 'Serialized'){
	   	SlnoHide = 'inline';
	   }
          
       }

       document.getElementById("serial"+num).style.display=SlnoHide;
	
      
}
//END
</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading">&nbsp;&nbsp;&nbsp;SKU</td>
                <td width="10%" class="heading">Condition</td>
		<td width="11%" class="heading">Description</td>
		<td width="8%" class="heading">Qty on Hand</td>
		<td width="8%" class="heading">Qty</td>
		<td width="10%" class="heading">Unit Price</td>
                <td width="4%" class="heading" align="center">Dropship</td>
                <td width="7%" class="heading">Cost</td>
		<td width="7%" class="heading">Discount</td>
		<td width="6%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right">Amount</td>
    </tr>
</thead>
<!-- By Chetan --->
<tbody>
	<?php 
	$subtotal=0;
	
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		

	#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
	if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
            $TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}



	if(!empty($arrySaleItem[$Count]["SerialNumbers"])){
            $SlNoHide = 'inline';
	}else{
	   $SlNoHide = 'none';
	}
       
        $ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
    	$ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($arrySaleItem[$Count]["Condition"]);
	if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';

	?><!-- By Chetan --->
     <tr class='itembg'>
		<td><?=($Line>1)?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arrySaleItem[$Count]["sku"])?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="../sales/SelectItem.php?proc=Sale&id=<?=$Line?>" ><img src="../images/view.gif" border="0"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['id'])?>" readonly maxlength="20"  />
		
                
                
                
                <input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
                <!--<input type="hidden" name="no_req_item<?=$Line?>" id="no_req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['no_req_item'])?>" readonly />-->

                <input type="hidden" name="old_req_item<?=$Line?>" id="old_req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
                <input type="hidden" name="add_req_flag<?=$Line?>" id="add_req_flag<?=$Line?>" value="" readonly />
                
                <!-- End--->
		

		</td>
<td><div <?=$style?>><select name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionSelectedDrop?></select></div></td>
        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:100px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/></td>
        <td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["on_hand_qty"])?>"/></td>
        <td><input type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["qty"])?>"/>
        
             <span style="display:<?=$SlNoHide?>;"  id="serial<?= $Line ?>">
                  <a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?= $Line ?>"id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
 <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?=$arrySaleItem[$Count]["SerialNumbers"]?>"  />

                   </span>
                 
<input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arrySaleItem[$Count]["evaluationType"]?>"  />

   
                  
        </td>
       <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/><input type="hidden" align="right" name="CustDiscount<?=$Line?>" id="CustDiscount<?=$Line?>" readonly class="disabled"  value="<?=$arrySaleItem[$Count]['CustDiscount']?>" size="13" style="text-align:right;"/></td>
       <td align="center"><input type="checkbox" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" <?php if($arrySaleItem[$Count]["DropshipCheck"] == 1){echo "checked";}?> onclick="return dropshipcost(<?=$Line?>);"></td>
       <td><input type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>" <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1){?>style="display:none;"<?php }?>  class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["DropshipCost"])?>"></td>
       <td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>"/></td>
       <td>
<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />
	   <!--select name="tax<?=$Line?>" id="tax<?=$Line?>" class="textbox" style="width:120px;display:<?=$TaxShowHide?>">
			<option value="0">None</option>
			<? for($i=0;$i<sizeof($arrySaleTax);$i++) {?>
			<option value="<?=$arrySaleTax[$i]['RateId'].':'.$arrySaleTax[$i]['TaxRate']?>" <? if($arrySaleTax[$i]['RateId']==$arrySaleItem[$Count]['tax_id']){echo "selected";}?>>
			<?=$arrySaleTax[$i]['RateDescription'].' : '.$arrySaleTax[$i]['TaxRate']?>
			</option>
			<? } ?>			
		</select-->
	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arrySaleItem[$Count]["amount"])?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="12" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		//$subtotal = number_format($subtotal,2);
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight']; // number_format($arrySale[0]['Freight'],2);
		$TotalAmount = $arrySale[0]['TotalAmount']; //number_format($arrySale[0]['TotalAmount'],2);
if($arrySale[0]['CustDisAmt']!='') $displayBlock ="style=display:block;"; else $displayBlock ="style=display:none;";
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/>
		<br><br>
<!--div id="DisType" <?=$displayBlock?>><span id="LevelType"><?=$arryQuote[0]['MDType']?>:</span-->

<input type="hidden" align="right" name="MDType" id="MDType" readonly class="disabled"  value="<?=$arrySale[0]['MDType']?>" /> 


<input type="hidden" align="right" name="MDAmount" id="MDAmount" readonly class="disabled"  value="<?=$arrySale[0]['MDAmount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="MDiscount" id="MDiscount" readonly class="disabled"  value="<?=$arrySale[0]['MDiscount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="CustDisType" id="CustDisType" class="disabled"  value="<?=$arrySale[0]['CustDisType']?>" />


<!--/div-->
		Tax : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="13" style="text-align:right;"/><br><br>

		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		 
                 
                 $(".slnoclass").fancybox({
			'width'         : 300
		 });
                 
                 

});

</script>
<? echo '<script>SetInnerWidth();</script>'; ?>
