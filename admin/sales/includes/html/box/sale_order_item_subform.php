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
	var reqcounter = 1;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
	

		counter = parseInt($("#NumLine").val()) + 1;
	

		var newRow = $("<tr class='itembg'>");
		var cols = "";

		
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="10"  onblur="SearchQUOTEComponent(this.value,' + counter + ')"  onclick="Javascript:SetAutoComplete(this);" />&nbsp;<a class="fancybox fancybox.iframe" href="SelectAllItem.php?proc=Sale&id=' + counter + '" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /></td><td><input type="checkbox" name="RecurringCheck' + counter + '" id="RecurringCheck' + counter + '"  onchange="return RecurringCheck('+counter+');"><a class="fancybox reqbox  fancybox.iframe" href="../EntryType.php?line=' + counter + '" id="controle' + counter + '" class="controle" ><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a><input type="hidden" name="EntryType' + counter + '" id="EntryType' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryDate' + counter + '" id="EntryDate' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryInterval' + counter + '" id="EntryInterval' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryMonth' + counter + '" id="EntryMonth' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryWeekly' + counter + '" id="EntryWeekly' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryFrom' + counter + '" id="EntryFrom' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryTo' + counter + '" id="EntryTo' + counter + '" class="disabled" readonly size="5"  value=""/></td><td><textarea style="width:400px;height:16px;"  name="description' + counter + '" class="textbox" id="description' + counter + '"></textarea><a class="fancybox" href="#comments_div' + counter + '" ><img src="../images/comments.png" title="Comments" border="0"/></a><div id="comments_div' + counter + '" style="display:none;"><textarea style="height:100px;" maxlength="100" name="DesComment' + counter + '" id="DesComment' + counter + '"></textarea> </div><input type="hidden" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><input type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" onblur=" PriceDiscount(' + counter +');"class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);"/><input type="hidden" align="right" name="CustDiscount' + counter + '" id="CustDiscount' + counter + '" readonly class="disabled"  value="" /><input type="hidden" name="priceOrig' + counter + '"  id="priceOrig' + counter + '" class="textbox" size="10" maxlength="15" /></td><td align="center"><input type="checkbox" name="DropshipCheck'+counter+'" id="DropshipCheck'+counter+'" onclick="return dropshipcost('+counter+');"></td><td><input type="text" name="avgCost'+counter+'" id="avgCost'+counter+'" value="" class="disabled textbox" maxlength="6" size="3" readonly><input type="text" name="DropshipCost'+counter+'" id="DropshipCost'+counter+'" style="display:none;"  class="textbox" size="3"  onkeypress="return isDecimalKey(event);"></td><td><input type="text" name="discount' +counter+ '" id="discount' +counter+ '" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" /></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" readonly size="2"   /></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="textbox"  size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
	
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;


	});






	$("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"],input[name^="discount"]', function (event) {
		
                calculateRow($(this).closest("tr"));
				calculateGrandTotal();
		 
		
	});

	$("table.order-list").on("focus",'input[name^="sku"]', function (event) {
			
			var add_req_flag = $(this).closest("tr").find('input[name^="add_req_flag"]').val();
			if(add_req_flag == 0){
			  addRequiredItem($(this).closest("tr"));
			}		
			
			
			
			
			
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
		/*****************************/
		$(this).closest("tr").remove();
		calculateGrandTotal();

	});


	 

	});


     function addRequiredItem(row) { 
			
			var req_item = row.find('input[name^="req_item"]').val();
			//alert(req_item);
			//var no_req_item = row.find('input[name^="no_req_item"]').val();
			if(req_item != ''){
				var req_itm_sp = req_item.split("#");	
				var req_item_length = req_itm_sp.length;
			}	
	
			<!--FOR ITEM DELETE CODE -->
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

		<!--END ITEM DELETE CODE-->

		<!--FOR ITEM ADD CODE -->
 		 
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
			
		<!--END ITEM ADD CODE-->
		        
		row.find('input[name^="add_req_flag"]').val('1');		

			
		}

	function calculateRow(row) { 
		var taxRate = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}

		
	
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();		
		var discount = +row.find('input[name^="discount"]').val();
		var TotalDisCount = discount*qty;
		var item_taxable = row.find('input[name^="item_taxable"]').val();

	        if(discount>0 && discount>=price)
		{
		   alert("Discount Should be Less Than Unit Price!");
		   return false;
		}
		var SubTotal = price*qty;//+DropshipCost*qty;
			if(TotalDisCount > 0){
				SubTotal = SubTotal-TotalDisCount;
		}
		var tax_add = 0;

		if(taxRate!=0 && item_taxable=="Yes"){
			var arrField = taxRate.split(":");
			var tax = arrField[2];
			tax_add = (SubTotal*tax)/100;
		}
	           

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {		
		var subtotal=0, TotalAmount=0 , taxAmnt=0;		
		var item_taxable = ''; 	
		var freightTaxSet ='';	
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


		var fr = $("#Freight").val();
		freightTaxSet = document.getElementById("freightTxSet").value;		 
		console.log(freightTaxSet);
		if(fr!='' && tax>0 && freightTaxSet =='Yes'){		
			FrtaxAmnt = (fr*tax)/100;	
			FrtaxAmnt = taxAmnt+FrtaxAmnt;
			taxAmnt  = FrtaxAmnt;
		}
		taxAmnt = roundNumber(taxAmnt,2);

		/****************/
		 var TaxReadonly = $("#TaxReadonly").val();
		 var taxAmntOld = $("#taxAmnt").val();
		 var tax_auths = $("#tax_auths").val();
		 if(TaxReadonly=="1" && taxAmntOld > 0 && tax_auths=="Yes"){
			taxAmnt = roundNumber(taxAmntOld,2);
		 }	
		/****************/


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

function SearchQUOTEComponent(sku,SelID) {
    var NumLine = document.getElementById("NumLine").value;

    /******************/
    var SkuExist = 0;
if(sku==''){

return false;
}
  
    /******************/
    if (SkuExist == 1) {
        $("#msg_div").html('Item Sku [ ' + Sku + ' ] has been already selected.');
    } else {
        ResetSearch();
        var SelID = SelID;
        var proc = $("#proc").val();
        //var SendUrl = "&action=ItemAllInfo&ItemID=" + escape(ItemID) + "&proc=" + escape(proc) + "&r=" + Math.random();
         var SendUrl = "&action=SearchSalesCode&key="+escape(sku)+"&SelID="+SelID+"&r="+Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType: "JSON",
            success: function(responseText) {
		
                //    alert(responseText);
                    
                    if(responseText == null){

 												$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'addItem.php?Sku='+sku+'&selectid='+SelID,
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });


                    	 document.getElementById("sku" + SelID).value = '';
                         document.getElementById("item_id" + SelID).value = '';
                         document.getElementById("description" + SelID).value = '';
                         document.getElementById("qty" + SelID).value = '';
                         document.getElementById("on_hand_qty" + SelID).value = '';
                         document.getElementById("price" + SelID).value = '';
                         alert('Item Sku  is not exists.');
                         
                    }else{
                    
                document.getElementById("sku" + SelID).value = responseText["Sku"];
                document.getElementById("item_id" + SelID).value = responseText["ItemID"];
                document.getElementById("description" + SelID).value = responseText["description"];
                document.getElementById("qty" + SelID).value = '1';
                document.getElementById("on_hand_qty" + SelID).value = responseText["qty_on_hand"];
                document.getElementById("price" + SelID).value = responseText["sell_price"];
     	       document.getElementById("item_taxable" + SelID).value = responseText["sale_tax_rate"]; 


                if (document.getElementById("serial" + SelID) != null) {
                    if (responseText["evaluationType"] == 'Serialized') {

                        document.getElementById("serial" + SelID).style.display = "block";
		   				document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];


                    } else {
                        document.getElementById("serial" + SelID).style.display = "none";
                    }
                }   
              

             //   document.getElementById("price" + SelID).focus();
	    	//	document.getElementById("qty" + SelID).focus();


                ProcessTotal();
                /**********************************/
                    }

                //parent.jQuery.fancybox.close();
                //ShowHideLoader('1', 'P');




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

   

function RecurringCheck(lin){
if($("#RecurringCheck"+lin).is(':checked')){   $('a#controle'+lin).trigger('click');}else{



$('#EntryType'+lin).val('');
$('#EntryDate'+lin).val('');
$('#EntryInterval'+lin).val('');
$('#EntryMonth'+lin).val('');
$('#EntryWeekly'+lin).val('');
$('#EntryFrom'+lin).val('');
$('#EntryTo'+lin).val('');


}


}
function dropshipcost(num){
    
    if(document.getElementById('DropshipCheck'+num).checked == true)
    {
        
               $("#avgCost"+num).hide();    
		document.getElementById("DropshipCost"+num).style.display = 'inline';
        
    }else{
       
        document.getElementById("DropshipCost"+num).style.display = 'none';
        document.getElementById("DropshipCost"+num).value='0';
	$("#avgCost"+num).show();
    }
     
}


function PriceDiscount(SelID){
//alert(SelID);
var MDAmount = document.getElementById("MDAmount").value;
                        var MDType = document.getElementById("MDType").value;
                        var MDiscount = document.getElementById("MDiscount").value;
                        var CustDisType = document.getElementById("CustDisType").value;
                        var totDiscountAmt =0;
                        var tuotDiscountCal =0;
var price = document.getElementById("price"+SelID).value;
if(MDiscount == 'Cost'){
 
	 
		if(MDType == 'Discount'){

			if(CustDisType == "Percentage"){
				totDiscountCal = Number(responseText["purchasePrice"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["purchasePrice"])-Number(totDiscountCal);

			}else{
				  totDiscountCal = Number(MDAmount);
				  totDiscountAmt = Number(responseText["purchasePrice"]) - Number(MDAmount); 
				  
			}


		}else{


			if(CustDisType == "Percentage"){
				totDiscountCal = Number(responseText["purchasePrice"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["purchasePrice"])+Number(totDiscountCal);

			}

		
//CustDiscount = MDAmount;
  
}
document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2); document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);
 
}else if(MDiscount == "Sale"){


		if(MDType == "Discount"){

			if(CustDisType == "Percentage"){
				totDiscountCal = Number(price)*Number(MDAmount)/100;
				totDiscountAmt = Number(price)-Number(totDiscountCal);

			}else if(CustDisType == "Fixed"){
				  totDiscountCal =  Number(MDAmount);
				  totDiscountAmt = Number(price) - Number(MDAmount); 
				  
			}

		 }else if(MDType == 'Markup'){

				totDiscountCal = Number(price)*Number(MDAmount)/100;
				totDiscountAmt = Number(price) + Number(totDiscountCal);

       }
   
	     document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2);
       document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);

}else{

		document.getElementById("price" + SelID).value = responseText["price"];
		document.getElementById("priceOrig" + SelID).value = price;
		//jQuery("#price" + SelID).val(responseText["price"]);
		//jQuery("#priceOrig" + SelID).val(price);
		document.getElementById("CustDiscount"+ SelID).value = '';
}
   
ProcessTotal();

}

</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td width="15%" class="heading">&nbsp;&nbsp;&nbsp;SKU</td>
<td width="5%" class="heading">Recurring</td>
		<td  class="heading">Description</td>
		<!--td width="12%" class="heading">Qty on Hand</td-->
		<td width="12%" class="heading">Qty</td>
		<td width="12%" class="heading">Sell Price</td>
<td width="4%" class="heading" align="center">Dropship</td>
					<td width="3%" class="heading">Cost</td>
		<td width="12%" class="heading">Discount</td>
		<td width="3%" class="heading">Taxable</td>
		<td width="15%" class="heading" align="right">Amount</td>
    </tr>
</thead>
<tbody>
	<? 
	$subtotal=0;
	
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		

	
	if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');

	if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';
  if(!empty($arrySaleItem[$Count]['parent_item_id'])){
                $disable = 'class = "disabled" readonly="readonly"';
        }else{
            
                $disable = "";
        }//End//

	?>
     <tr class='itembg'>
		<td>

<?/*=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;")*/?>

<? echo '<img src="../images/delete.png" id="ibtnDel" title="Delete">'; ?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="textbox"  size="10"  value="<?=stripslashes($arrySaleItem[$Count]['sku'])?>"  onblur="SearchQUOTEComponent(this.value,<?=$Line?>)" onclick="Javascript:SetAutoComplete(this);"   />&nbsp;<a class="fancybox fancybox.iframe" href="SelectAllItem.php?proc=Sale&id=<?=$Line?>" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['item_id'])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arrySaleItem[$Count]['id']?>" readonly maxlength="20"  />
		
		<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
               
                 <input type="hidden" name="old_req_item<?=$Line?>" id="old_req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
                 <input type="hidden" name="add_req_flag<?=$Line?>" id="add_req_flag<?=$Line?>" value="" readonly />


		</td>
<td><input type="checkbox" name="RecurringCheck<?=$Line?>" id="RecurringCheck<?=$Line?>" <?php if($arrySaleItem[$Count]["RecurringCheck"] == 'on'){echo "checked";}?> onchange="return RecurringCheck(<?=$Line?>);">
<?php if($_GET['edit']!='' && $arrySaleItem[$Count]["RecurringCheck"] == 'on' ){   $RecDis =''; }else{ $RecDis ='display:none;'; } ?>
<a class="fancybox reqbox  fancybox.iframe" style="<?=$RecDis?>" href="../EntryType.php?line=<?=$Line?>&edit=<?=$arrySaleItem[$Count]['id']?>" id="controle<?=$Line?>" class="controle" ><?=$edit?></a>

<?
$EntryFrom='';
$EntryTo='';

if($arrySaleItem[$Count]["EntryFrom"]>0) $EntryFrom = $arrySaleItem[$Count]["EntryFrom"];
if($arrySaleItem[$Count]["EntryTo"]>0) $EntryTo = $arrySaleItem[$Count]["EntryTo"];

?>

<input type="hidden" name="EntryType<?=$Line?>" id="EntryType<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryType"])?>"/>
<input type="hidden" name="EntryDate<?=$Line?>" id="EntryDate<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryDate"])?>"/>
<input type="hidden" name="EntryInterval<?=$Line?>" id="EntryInterval<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryInterval"])?>"/>
<input type="hidden" name="EntryMonth<?=$Line?>" id="EntryMonth<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryMonth"])?>"/>
<input type="hidden" name="EntryWeekly<?=$Line?>" id="EntryWeekly<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryWeekly"])?>"/>
<input type="hidden" name="EntryFrom<?=$Line?>" id="EntryFrom<?=$Line?>" class="disabled" readonly size="4"  value="<?=stripslashes($EntryFrom)?>"/>
<input type="hidden" name="EntryTo<?=$Line?>" id="EntryTo<?=$Line?>" class="disabled" readonly size="4"  value="<?=stripslashes($EntryTo)?>"/>

</td>
        <td>
<textarea name="description<?=$Line?>" id="description<?=$Line?>"  class="textbox" style="width:400px;height:16px;" ><?=stripslashes($arrySaleItem[$Count]["description"])?></textarea><!--input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:400px;"    value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/-->

<?php if(empty($disable)){?><a class="fancybox" href="#DesComment<?=$Line?>" ><img src="../images/comments.png" title="Comments" border="0" /></a><?php } ?>

<div id="comments_div<?=$Line?>" style="display:none;height:100px;">        
<textarea name="DesComment<?=$Line?>" id="DesComment<?=$Line?>" style="height:100px;" maxlength="100"><?=stripslashes($arrySaleItem[$Count]["DesComment"])?></textarea>
</div>
        <input type="hidden" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["on_hand_qty"])?>"/></td>
        <td><input type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["qty"])?>"/></td>
        <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="10" maxlength="10" onblur=" PriceDiscount('<?=$Line?>');" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/>
<input type="hidden" align="right" name="CustDiscount<?=$Line?>" id="CustDiscount<?=$Line?>" readonly class="disabled"  value="<?=$arrySaleItem[$Count]['CustDiscount']?>" size="3" style="text-align:right;"/> 
 <input type="hidden" name="priceOrig<?=$Line?>" id="priceOrig<?=$Line?>" class="textbox" onkeypress="return isDecimalKey(event);"
              value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/></td>
 <td align="center"><input type="checkbox" class="formactive" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" <?php if($arrySaleItem[$Count]["DropshipCheck"] == 1){echo "checked";}?> onclick="return dropshipcost(<?=$Line?>);"></td>

 <!--By chetan 13Jan--->
       <td>
           <input type="text" <? if($arrySaleItem[$Count]["DropshipCheck"] == 1){?>style="display:none;"<?php }?> name="avgCost<?=$Line?>" id="avgCost<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['avgCost'])?>" class="disabled textbox avgCost formactive" maxlength="6" size="3" readonly>
           <input  <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1 || $disable){?>style="display:none;"<?php }?> type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>"  class="textbox formactive" size="3" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["DropshipCost"])?>"></td>
  
        <td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>"/></td>

	 <td>
<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly size="2"   />
	   </td>
  
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="textbox"  size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arrySaleItem[$Count]["amount"])?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="10" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
		 
       		 <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
        	 <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />



		<?	
		$subtotal = number_format($subtotal, 2, ".", "");
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight']; // number_format($arrySale[0]['Freight'],2);
		$TotalAmount = $arrySale[0]['TotalAmount']; //number_format($arrySale[0]['TotalAmount'],2);
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/><br><br>

<input type="hidden" align="right" name="MDType" id="MDType" readonly class="disabled"  value="<?=$arrySale[0]['MDType']?>" /> 


<input type="hidden" align="right" name="MDAmount" id="MDAmount" readonly class="disabled"  value="<?=$arrySale[0]['MDAmount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="MDiscount" id="MDiscount" readonly class="disabled"  value="<?=$arrySale[0]['MDiscount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="CustDisType" id="CustDisType" class="disabled"  value="<?=$arrySale[0]['CustDisType']?>" />


		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/><br><br>

		
		
		<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="13" style="text-align:right;"/><br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
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
			'width'         : 50%
		 });
                 
    $(".controle").fancybox({
        'width':300,
        'height':500,
        'autoSize' : false,
        'afterClose':function(){
            
        }, 
    });	  

});

</script>

<? #echo '<script>SetInnerWidth();</script>'; ?>


