<? 
//echo "<pre>";print_r($arryRMAItem);

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
	

	$("table.order-list").on("keyup", 'input[name^="price"],input[name^="qty"]', function (event) {
		calculateRow($(this).closest("tr"));
GlobalRestockingVal();
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
		var condition= row.find('select[name^="Condition"]').val();

        //alert(serial_sku);
        
        var serial_value_sel = row.find('input[name^="serial_value"]').val();
         
        if (qty > 0) {
            var linkhref = $(this).attr("href") + '&total=' + qty + '&shsku=' + serial_sku+'&condition='+condition;
          
            $(this).attr("href", linkhref);
        }
        /*****************************/

    });
$('#Freight').keyup(function(){
    calculateGrandTotal();
});
$('#Restocking_fee').keyup(function(){
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

	/*function calculateGrandTotal() {		
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
		if(document.getElementById("Restocking_fee") != null){
			subtotal += +$("#Restocking_fee").val();
		}
		$("#TotalAmount").val(subtotal.toFixed(2));
	}*/
function calculateGrandTotal() {
		//GlobalRestockingVal();		
		var subtotal=0, TotalAmount=0 , taxAmnt=0; Restocking_fee=0;			
		var item_taxable = ''; 		
		var taxRate = 0; var tax = 0; var amount = 0;
var PrepaidAmount=0;
var FrtaxAmnt = 0;	
var fr = 0;
				var FrtaxAmnt=0;
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

 fr =	$("#Freight").val();

var freightTaxSet = document.getElementById("freightTxSet").value;

//document.getElementById("freightTxSet").value = freightTaxSet;
/*if($("#PrepaidFreight").val() == 1){
	//PrepaidAmount = $("#PrepaidAmount").val();
}else{
	PrepaidAmount = 0;
}*/
//alert(freightTaxSet);
 console.log(freightTaxSet);
//if((fr!='' || PrepaidAmount!='') && tax>0 && freightTaxSet =='Yes'){		
if(fr!='' && tax>0 && freightTaxSet =='Yes'){
var totFr = Number(fr)+Number(PrepaidAmount);
				FrtaxAmnt = (totFr*tax)/100;	
				FrtaxAmnt = taxAmnt+FrtaxAmnt;
				taxAmnt  = FrtaxAmnt;
}
if($("#Restocking").val()==1 && tax>0){
var RetaxAmnt = ($("#Restocking_fee").val()*tax)/100;
console.log(RetaxAmnt);
//RetaxAmnt = taxAmnt+RetaxAmnt;
				//taxAmnt  = RetaxAmnt;

}

		$("#subtotal").val(subtotal.toFixed(2));
//if(taxAmnt>0){
		$("#taxAmnt").val(taxAmnt.toFixed(2));
//}

		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();
if($("#Restocking").val()==1){
		subtotal += -$("#Restocking_fee").val();
}
console.log(subtotal);
if(RetaxAmnt>0){
    //subtotal += +RetaxAmnt;
}

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


</script>

<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading" >SKU</td>
		<td width="10%" class="heading">Condition</td>
		<td width="20%" class="heading">Description</td>
		<td width="8%" class="heading">Type</td>
		<td width="8%" class="heading">Action</td>
		<td width="11%" class="heading">Reason</td>
		<!--  <td width="10%" class="heading">Qty Ordered</td>-->
		<td width="8%" class="heading">Qty RMA</td>
		<td width="8%" class="heading">Original Qty Returned</td>
		<td width="10%"  class="heading">Qty Returned</td>
		<td width="8%"  class="heading">Bin Location</td>
		<td width="5%"  class="heading">Unit Price</td>
		
		<td width="6%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	$QtyFlag=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;

		$binloc =$objWarehouse->getWareHouseByAction($arryRMAItem[$Count]["Action"]);
		$WhRMAType =$objWarehouse->WHRmaTypeValue($arryRMAItem[$Count]["Type"]);
		//echo "<pre>";print_r($binloc);
		
		$ValReciept = $objWarehouse->GetPurchaseSumQtyReceipt($arryRMAItem[$Count]["OrderID"],$arryRMAItem[$Count]["item_id"]);
		
		//echo "<pre>";print_r($ValReciept);exit;
		
		
		if($arryRMAItem[$Count]["qty_returned"] == $arryRMAItem[$Count]["qty_receipt"])
		{  
			  
			$textFld = $arryRMAItem[$Count]["qty_returned"];
			$textFld .= '<input type="hidden" value="" name="qty'.$Line.'" id="qty'.$Line.'" onkeypress="return isNumberKey(event);" maxlength="6" size="5"  class="textbox">';
		  }else{
			 
			  $textFld = '<input type="text" value="" name="qty'.$Line.'" id="qty'.$Line.'" onkeypress="return isNumberKey(event);" maxlength="6" size="5"  class="textbox">';
		  }
		  
		  $textFld1 = '<input type="text" value="" name="qty'.$Line.'" id="qty'.$Line.'" readonly="" class="disabled" onkeypress="return isNumberKey(event);" maxlength="6" size="5"  class="textbox">';
		  
		  //$remainQty = $arryRMAItem[$Count]["qty_received"]-$arryRMAItem[$Count]["qty"];
		  
		  $remainQty = $arryRMAItem[$Count]["qty"]-$ValReciept;

		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arryRMAItem[$Count]['Taxable']=='Yes'){
		if($arryPurchase[0]['tax_auths']=='Yes' && $arryRMAItem[$Count]['Taxable']=='Yes'){	
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}


		$ReqDisplay = !empty($arryRMAItem[$Count]['req_item'])?(''):('style="display:none"');
                
                 if($arryRMAItem[$Count]["DropshipCheck"] == 1){
                    $DropshipCheck = 'Yes';
                }else{
                    $DropshipCheck = 'No';
                }
               
	    $ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($arryRMAItem[$Count]["Condition"]);


$checkProduct=$objItem->checkItemSku($arryRMAItem[$Count]["sku"]);

		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($arryRMAItem[$Count]["sku"]);
			if(count($arryAlias))
			{

					$mainSku = $arryAlias[0]['sku'];
					//$arryPurchaseItem[$Count]['description'] = $arryAlias[0]['description'];
					$arryRMAItem[$Count]['evaluationType'] = $arryAlias[0]['evaluationType'];
					$arryRMAItem[$Count]['item_id'] = $arryAlias[0]['ItemID'];
			}
		}else{

$mainSku = $arryRMAItem[$Count]["sku"];
}


	?>
     <tr class='itembg'>
		<td>
		 <input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arryRMAItem[$Count]["sku"])?>"/><a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arryRMAItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>>&nbsp;&nbsp;<img src="../images/tab-new.png" border="0" title="Additional Items"></a>
		 <input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryRMAItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arryRMAItem[$Count]["id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="remainQty<?=$Line?>" id="remainQty<?=$Line?>" value="<?=$remainQty?>" readonly maxlength="20"  />		
<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arryRMAItem[$Count]['req_item'])?>" readonly />
		</td>
		<td><div <?#=$style?>><select name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionSelectedDrop?></select></div></td>
        <td><?=stripslashes($arryRMAItem[$Count]["description"])?>
		<input type="hidden" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryRMAItem[$Count]["description"])?>"/>
		</td>
		
		<td><?=$WhRMAType?>
		<input type="hidden" name="Type<?= $Line ?>" id="Type<?= $Line ?>" value="<?=$WhRMAType?>"  />
<input type="hidden" name="Retype<?= $Line ?>" id="Retype<?= $Line ?>" class="Retype" value="<?=$arryRMAItem[$Count]["Type"]?>"  /></td>
		<td><?=stripslashes($arryRMAItem[$Count]["Action"])?>
		<input type="hidden" name="Action<?= $Line ?>" id="Action<?= $Line ?>" value="<?=$arryRMAItem[$Count]["Action"]?>"  /></td></td>
		<td><?=stripslashes($arryRMAItem[$Count]["Reason"])?>
		<input type="hidden" name="Reason<?= $Line ?>" id="Reason<?= $Line ?>" value="<?=$arryRMAItem[$Count]["Reason"]?>"  /></td></td>
		
        <?php /*?><td><input type="text" value="<?=$arryRMAItem[$Count]["qty"]?>" size="5" readonly="" class="disabled" id="ordered_qty<?=$Line?>" name="ordered_qty<?=$Line?>"><?php */?>
        
        
        
        </td>
        <td><input type="text" value="<?=$arryRMAItem[$Count]["qty"]?>" size="5" readonly="" class="disabled" id="ordered_qty<?=$Line?>" name="ordered_qty<?=$Line?>">
        
         
        
        
        </td>
       
		<td><input type="text" value="<?=$ValReciept;?>" size="4" readonly="" class="disabled">
                </td>
                
		    <td>  
		     <?php if($arryRMAItem[$Count]["qty"] == $ValReciept) { ?>
		   
		      <?php }else { 
				$QtyFlag=1;
			?>
		       <?=$textFld;?><?php if($arryRMAItem[$Count]["DropshipCheck"] != 1 && ($arryRMAItem[$Count]["evaluationType"] == 'Serialized' || $arryRMAItem[$Count]["evaluationType"] == 'Serialized Average')  ){ ?>
		                    <br> 
		          
		      <a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?  echo $Line ?>&OrderID=<?php echo $arryRMAItem[$Count]['OrderID']?>&item_id=<?php echo $arryRMAItem[$Count]['item_id']?>&sku=<?=$mainSku?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a>
		        <?php }?>
		             <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?=$arryRMAItem[$Count]["SerialNumbers"]?>"  />
		             <input type="hidden" name="SerialValue<?= $Line ?>" id="SerialValue<?= $Line ?>" value="<?=$arryRMAItem[$Count]["SerialNumbers"]?>"  />
		              <input type="hidden" name="avgCost<?= $Line ?>" id="avgCost<?= $Line ?>" value=""  />
		<input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arryRMAItem[$Count]["evaluationType"]?>"  />   
		       <?php } ?>    
                
              </td>
              
                <td>
                <?php if(sizeof($binloc)>0) { ?>
                <select name="bin<?=$Line?>" id="bin<?=$Line?>" class="textbox" >
                <?php foreach ($binloc as $locbin):?>
                  <option value="<?php echo $locbin['binid']."_".$locbin['warehouse_id'];?>"><?php echo $locbin['binlocation_name']?></option>  
                <?php endforeach; ?>
                <?php } ?>
                </select>
                </td>
        <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" readonly="" class="disabled" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryRMAItem[$Count]["price"])?>"/></td>
		
		
       <td> 
<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryRMAItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />
<!--span style="display:<?=$TaxShowHide?>">
		<input type="text" name="tax<?=$Line?>" id="tax<?=$Line?>" size="5"  readonly="" class="disabled" class="textbox" value="<?=$arryRMAItem[$Count]['tax'];?>">
		<input type="hidden" name="tax_id<?=$Line?>" id="tax_id<?=$Line?>" readonly="" class="disabled" class="textbox" value="<?=$arryRMAItem[$Count]['tax_id'];?>">
		</span-->
	   </td>
       <td align="right">
	   
	   <input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled ReAmnt" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=number_format($amount,2)?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arryRMAItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="14" align="right">
 <input type="hidden" name="RestockingGlobal" id="RestockingGlobal" value="<?=$RestockingGlobal?>" readonly maxlength="20"  />
		 <!--<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>-->
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$subtotal = number_format($subtotal,2);
		$taxAmnt = $arryRMAItem[0]['taxAmnt'];
		$Freight = $arryRMA[0]['Freight']; // number_format($arrySale[0]['Freight'],2);
		$Restocking_fee = $arryRMA[0]['Restocking_fee'];
		$TotalAmount = $arryRMAItem[0]['TotalAmount']; //number_format($arrySale[0]['TotalAmount'],2);
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="" size="13" style="text-align:right;"/>
		<br><br>

		

		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>

		<?php if($arryRMA[0]['Restocking'] == 1) { ?>
		<span style="color:red;">Re-Stocking Fee:</span> <input type="text" align="right" name="Restocking_fee"
                id="Restocking_fee" class="textbox" value="<?=$Restocking_fee?>" size="13" maxlength="10"
                onkeypress="return isDecimalKey(event);"
                onblur="calculateGrandTotal();" style="width:130px;text-align:right;color:red;" /> <br><br>
		<?php } else { echo "";}?>


<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="textbox" readonly value="" size="13" style="text-align:right;"/><br><br>

		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="" size="13" style="text-align:right;"/>
		<br><br>
		<?php
		if($QtyFlag==0){
			$HideSubmit=1;
		 echo '<div class=redmsg style="float:left">
No quantities are left to Return for this RMA.</div>';
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
			'width'         : '70%'
		 });
                 
                 

});

</script>
<? echo '<script>SetInnerWidth();</script>'; ?>


<?php /****************************************************************************/?>


