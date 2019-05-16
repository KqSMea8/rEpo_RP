<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	//var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;
                
                setInterval(function() {
                    var number = 1 + Math.floor(Math.random() * 6);
                        $('#num_gen').value(number);
                     }, 10);
                
                //alert(counter);

		var newRow = $("<tr class='itembg'>");
		var cols = "";

		/*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
		cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="disabled" readonly size="10" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="ItemFetchList.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /></td><td><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionDrop?></select></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:200px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><input type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" /><span style="display:none;" id="serial'+counter+'"><a class="fancybox fancybox.iframe" href="editSerial.php?id='+counter+'" id="addItem"><img src="../images/tab-new.png"  title="Serial number"></a></span></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);"/></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



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

	$("table.order-list").on("blur", 'input[name^="qty"]', function (event) {
		calculateRow($(this).closest("tr"));
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
        
        $("table.order-list").on("click", "#addItem", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var qty = row.find('input[name^="qty"]').val(); 
                var serial_sku = row.find('input[name^="sku"]').val(); 
		if(qty>0){
                        var linkhref = $(this).attr("href")+'&total='+qty+'&sku='+serial_sku;
                       	$(this).attr("href", linkhref);
		}
		/*****************************/

	});
        

	});

	function calculateRow(row) {
            
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		//var taxRate = row.find('select[name^="tax"]').val();
		var SubTotal = price*qty;
//alert(qty);
		

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {
		var subtotal=0, TotalValue=0;
                var TotalQty=0;
		//var Currency = $("#Currency").val();
		
		$("table.order-list").find('input[name^="amount"]').each(function () {
			subtotal += +$(this).val();
		});
                $("table.order-list").find('input[name^="qty"]').each(function () {
			TotalQty += +$(this).val();
		});
                $("#TotalQty").val(TotalQty.toFixed(2));
		$("#TotalValue").val(subtotal.toFixed(2));

		subtotal += +$("#Freight").val();
		
		//$("#TotalAmount").val(subtotal.toFixed(2));
	}

function frameDisplay(ln){

 var sku = document.getElementById("sku"+ln).value;
 var cond = document.getElementById("Condition"+ln).value;
var total = document.getElementById("qty"+ln).value;
//var link ='../warehouse/addSerial.php?id='+ln+'&cond='+cond+'&sku='+sku+'';
//alert(link);
//openIframe(link)
$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'addSerialNumber.php?id='+ln+'&total='+total+'&cond='+cond+'&sku='+sku,
                                type: 'iframe',
  width:'50%', height:'75%',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });

}

function openIframe(link) {

alert(link);
 $.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:link,
                                type: 'iframe',
width:240+'px',
height:240+'px',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
}


function SetAutoComplete(elm) {
        $(elm).autocomplete({
            source: "../jsonSku.php",
            minLength: 1
        });

    }
function getItemCondionQty(Sku,SelID,Condi){
	
	var skuSelect = document.getElementById("sku" + SelID).value;
	
	if(skuSelect!='')
	{			
	    ShowHideLoader('1', 'P');    
	    SendUrl = 'action=getItemCondionQty&Sku='+skuSelect+'&Condi='+Condi;
	    $.ajax({
		    type: "GET",
		    url: "../sales/ajax.php",
		    data: SendUrl,
		    dataType : "JSON",
		    success: function(responseText){                                               
			document.getElementById("on_hand_qty" + SelID).value =responseText["condition_qty"];  
ShowHideLoader('2', 'P');
}
});
}
}
</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td class="head1" >&nbsp;&nbsp;&nbsp;SKU</td>
                <td width="12%" class="head1" >Condition</td>
		<td width="19%" class="head1" >Description</td>
		<td width="10%" class="head1" >Qty on Hand</td>
		<td width="12%" class="head1" > Qty</td>
		<td width="14%"  class="head1" >Value</td>
                <td width="14%" align="right"  class="head1" >Total Value</td>
		
		
    </tr>
</thead>
<tbody>
	<?  $TotalQty=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
          $ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($arryTransferItem[$Count]["Condition"]);  
	?>
     <tr class="itembg">
		<td><?=($Line>1)?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arryTransferItem[$Count]["sku"])?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="ItemFetchList.php?id=<?=$Line?>" ><img src="../images/view.gif" border="0"></a>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryTransferItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arryTransferItem[$Count]["id"])?>" readonly maxlength="20"  />
		</td>

<td><select name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" onchange="getItemCondionQty('<?=stripslashes($arryTransferItem[$Count]['sku'])?>','<?=$Line?>',this.value)" style="width:120px;display:<?=$TaxShowHide?>"><option value="">Select Condition</option><?=$ConditionSelectedDrop?></select></td>



        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="disabled" readonly style="width:200px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryTransferItem[$Count]["description"])?>"/></td>

        <td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arryTransferItem[$Count]["on_hand_qty"])?>"/></td>

        <td><input type="text" name="qty<?= $Line ?>" id="qty<?= $Line ?>" <? if($_GET['edit']>0){  echo "readonly  "; echo 'class="disabled"'; }else{  echo 'class="textbox"'; } ?> size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?= stripslashes($arryTransferItem[$Count]["qty"]) ?>"/>
                    <span id="serialqty1"></span><br><span style="display:none;"  id="serial<?= $Line ?>"><a  onclick="frameDisplay(<?= $Line ?>);"   ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a>
                        <input type="hidden" name="valuationType<?= $Line ?>" id="valuationType<?= $Line ?>" value="<?= stripslashes($arryTransferItem[$Count]['valuationType']) ?>" readonly maxlength="20"  />
                    </span>
                    <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?= stripslashes($arryTransferItem[$Count]["serial_value"]) ?>" readonly maxlength="20"  />
                    <? if($arryTransferItem[$Count]['valuationType']=="Serialized" || $arryTransferItem[$Count]['valuationType']=="Serialized Average"){?>
                        
<span style="<?=$serDisSub?>"  id="serialSub<?= $Line ?>"><a  onclick="frameDisplay(<?= $Line ?>);"   ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Select S.N.</a>

                    <? //echo '<br><a  class="fancybox fancybox.iframe" href="vSerial.php?id='.$Line.'&SerialType=adjust&adjID='.$_GET['edit'].'&Sku='.$arryTransferItem[$Count]["sku"].'" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;View S.N.</a>';   
                        
                    }
                  ?>
                    
                </td>
       <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryTransferItem[$Count]["price"])?>"/></td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arryTransferItem[$Count]["amount"])?>"/></td>
       
       
    </tr>
	<? 
		$TotalQty += $arryTransferItem[$Count]["qty"];
                //$TotalQty += $arryTransferItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class="itembg">
        <td colspan="8" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		$TotalQty =$TotalQty;
		
		$TotalValue = $arryTransfer[0]['total_transfer_value'];
		?>
		<br>
	         Total Adjust Quantity : <input type="text" align="right" name="TotalQty" id="TotalQty" class="disabled" readonly value="<?=$TotalQty?>" size="15" style="text-align:right;"/>
		<br><br>
		
		Total Value : <input type="text" align="right" name="TotalValue" id="TotalValue" class="disabled" readonly value="<?=$TotalValue?>" size="15" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>

<? //echo '<script>SetInnerWidth();</script>'; ?>
<script type="text/javascript">
	$(document).ready(function() {
                $("#addItemBackup").click(function() {                   
                    var TotQty = $("#qty1").val();                   
                    $(this).attr("href", "editSerial.php?id=1&total="+TotQty);
                    $('.fancybox').fancybox();
                })
		
	});
</script>
