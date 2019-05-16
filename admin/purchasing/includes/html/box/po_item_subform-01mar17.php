<? 
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

	$("#addrow").on("click", function () { 
		

		counter = parseInt($("#NumLine").val()) + 1;

		var newRow = $("<tr class='itembg'>");
		var cols = "";

		


		/*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
		cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="13"  onblur="SearchItem(this.value,' + counter +')" onclick="Javascript:SetAutoComplete(this);" />&nbsp;<a class="fancybox fancybox.iframe" href="SelectAllItem.php?proc=Purchase&id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="Condition' + counter + '" id="Condition' + counter + '" class="textbox"  value=""/></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:500px;"   onkeypress="return isAlphaKey(event);" /><input type="hidden" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><input type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="15" maxlength="6" onkeypress="return isNumberKey(event);" /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);"/></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" value="" readonly size="2" maxlength="20"  /></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="textbox"  size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		;
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});


	$("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"]', function (event) {		
		calculateRow($(this).closest("tr"));
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


	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}

		var item_id = row.find('input[name^="item_id"]').val(); 
		if(item_id>0){
			var DelItemIDVal = $("#DelItemID").val();
			if(DelItemIDVal!='') DelItemIDVal = DelItemIDVal+',';
			$("#DelItemID").val(DelItemIDVal+item_id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		calculateGrandTotal();

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
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
var item_taxable = row.find('input[name^="item_taxable"]').val();

		var SubTotal = (price*qty);
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
		var subtotal=0, TotalAmount=0; taxAmnt=0;		
		var item_taxable = ''; 		
		var fr = 0;
		var PrepaidAmount = 0;	

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

		fr =	$("#Freight").val();

	var freightTaxSet = document.getElementById("freightTxSet").value;
	if($("#PrepaidFreight").val() == 1){
		//PrepaidAmount = $("#PrepaidAmount").val();
	}else{
		PrepaidAmount = 0;
	}
//alert(freightTaxSet);
 console.log(freightTaxSet);
if((fr!='' || PrepaidAmount!='') && tax>0 && freightTaxSet =='Yes'){		

var totFr = Number(fr)+Number(PrepaidAmount);
				FrtaxAmnt = (totFr*tax)/100;	
				FrtaxAmnt = taxAmnt+FrtaxAmnt;
				taxAmnt  = FrtaxAmnt;
}



		$("#taxAmnt").val(taxAmnt.toFixed(2));
		$("#subtotal").val(subtotal.toFixed(2));

		subtotal += +$("#Freight").val();
		if(document.getElementById("PrepaidFreight").value=="1"){
			subtotal += +PrepaidAmount;
		}
		subtotal += +$("#taxAmnt").val();
		$("#TotalAmount").val(subtotal.toFixed(2));
	}



	function ProcessTotal() {
		var Taxable = $("#Taxable").val();
var NumLine = $("#NumLine").val();
		//var NumLine = document.getElementById("NumLine").value;
		var ItemTaxableElement = document.getElementById("item_taxable"+i);


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


	/*	var tax_auths='';
		if(document.getElementById("tax_auths").value=="Yes"){
			tax_auths='Yes';
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

	function ResetSearch() {
	    $("#prv_msg_div").show();
	    $("#frmSrch").hide();
	    $("#preview_div").hide();
	    $("#msg_div").html("");
	}

	function ShowList() {
	    $("#prv_msg_div").hide();
	    $("#frmSrch").show();
	    $("#preview_div").show();
	}

    function SearchItem(Sku,ItemID) {
        var NumLine = document.getElementById("NumLine").value;
if(Sku==''){

return false;
}
        var SkuExist = 0;
       
        if (SkuExist == 1) {
            $("#msg_div").html('Item Sku [ ' + Sku + ' ] has been already selected.');
        } else {
            ResetSearch();
            var SelID = ItemID;
            var proc = 'purchase';
           // var SendUrl = "&action=ItemAllInfo&ItemID=" + escape(ItemID) + "&proc=" + escape(proc) + "&r=" + Math.random();
            var SendUrl = "&action=SerachItemInformationCode&ItemID="+ escape(ItemID) +"&key="+escape(Sku)+"&proc=" + escape(proc) + "&r=" + Math.random();
            /******************/
            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: SendUrl,
                dataType: "JSON",
                success: function(responseText) {
                console.log(responseText);
				//alert(responseText);
				if(responseText == null){
							          document.getElementById("sku" + SelID).value = '';
		                    document.getElementById("item_id" + SelID).value = '';
		                    document.getElementById("description" + SelID).value = '';
		                    document.getElementById("qty" + SelID).value = '';
		                    document.getElementById("on_hand_qty" + SelID).value = '';
		                    document.getElementById("price" + SelID).value = '';
		                    alert('Item Sku  is not exists.');

											$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'../sales/addItem.php?Sku='+Sku+'&selectid='+SelID,
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });





				}else{		
		                    document.getElementById("sku" + SelID).value = responseText["Sku"];
		                    document.getElementById("item_id" + SelID).value = responseText["ItemID"];
		                    document.getElementById("description" + SelID).value = responseText["description"];
		                    document.getElementById("qty" + SelID).value = '1';
		                    document.getElementById("on_hand_qty" + SelID).value = responseText["qty_on_hand"];
		                    document.getElementById("price" + SelID).value = responseText["purchase_cost"];
                        document.getElementById("item_taxable" + SelID).value = responseText["purchase_tax_rate"];
 


                    if (document.getElementById("serial" + SelID) != null) {
                        if (responseText["evaluationType"] == 'Serialized') {

															document.getElementById("serial" + SelID).style.display = "block";
															document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];


                        } else {
                            document.getElementById("serial" + SelID).style.display = "none";
                            document.getElementById("evaluationType"+SelID).value='';
                        }
                    }   
                  

                //    document.getElementById("price" + SelID).focus();
		    		//document.getElementById("sku" + SelID).focus();


                    ProcessTotal();
                    /**********************************/
						}

               



                }
            });
            /******************/
        }

    }

    function SetAutoComplete(elm){		
    	$(elm).autocomplete({
    		source: "../jsonSku.php",
    		minLength: 1
    	});

    }




</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td  width="20%" class="heading">&nbsp;&nbsp;SKU</td>
		<td  class="heading">Description</td>
		<!--td width="12%" class="heading">Qty on Hand</td-->
		<td width="12%" class="heading">Qty</td>
		<td width="12%" class="heading">Unit Price</td>
		<td width="5%" class="heading">Taxable</td>
		<td width="16%" class="heading" align="right">Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		


	?>
     <tr class='itembg'>
		<td><?=($Line>1)?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="textbox"  size="13"   value="<?=stripslashes($arryPurchaseItem[$Count]["sku"])?>" onblur="SearchItem(this.value,<?=$Line?>)" onclick="Javascript:SetAutoComplete(this);"/>&nbsp;<a class="fancybox fancybox.iframe" href="SelectAllItem.php?proc=Purchase&id=<?=$Line?>" ><img src="../images/view.gif" border="0"></a>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["id"])?>" readonly maxlength="20"  />

<input type="hidden" name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox"  value=""/>
		</td>
        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:450px;"  onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["description"])?>"/>
        <input type="hidden" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>"  size="5"  value="<?=stripslashes($arryPurchaseItem[$Count]["on_hand_qty"])?>"/></td>
        <td><input type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="15" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["qty"])?>"/></td>
       <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["price"])?>"/></td>
  <td>
       <input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />
	   
	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" class="textbox"  id="amount<?=$Line?>" class="text"  size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arryPurchaseItem[$Count]["amount"])?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]['amount'];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="8" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
	 	 <input type="hidden" name="DelItemID" id="DelItemID" value="" class="inputbox" readonly />
		<? 	
		$subtotal = number_format($subtotal, 2, ".", "");
		$taxAmnt = $arryPurchase[0]['taxAmnt'];
		$Freight = $arryPurchase[0]['Freight'];  
		$PrepaidAmount = $arryPurchase[0]['PrepaidAmount'];
		$TotalAmount = $arryPurchase[0]['TotalAmount']; //number_format($arryPurchase[0]['TotalAmount'],2);
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="15" style="text-align:right;"/>
		<br><br>

		


		Freight Cost : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>

		<div id="PrepaidAmountDiv" <?  if($arryPurchase[0]['PrepaidFreight']!=1){echo 'style="display:none"';}?>>
		Prepaid Freight : <input type="text" align="right" name="PrepaidAmount" id="PrepaidAmount" class="textbox" value="<?=$PrepaidAmount?>" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		</div>

<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="15" style="text-align:right;"/><br><br>

		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="15" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>

<? #echo '<script>SetInnerWidth();</script>'; ?>

