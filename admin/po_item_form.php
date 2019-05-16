<? 


 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arryPurchaseTax);$i++) {
	$TaxRateOption .= "<option value='".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['TaxRate']."'>
	".$arryPurchaseTax[$i]['RateDescription']." : ".$arryPurchaseTax[$i]['TaxRate']."</option>";
 } //echo $Config['TrackInventory'];
if($Config['TrackInventory'] ==1){ //$style ='style="display:none;"'; 
$TracInv = '<input type="hidden" name="TracInv" id="TracInv" value="1">';}else{ $TracInv = '<input type="hidden" name="TracInv" id="TracInv" value="0">'; $style =''; }
?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">
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
	$(document).ready(function () {
	var inputstr;
	var counter = 2;
	var reqcounter = 1;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;

		var newRow = $("<tr class='itembg'>");
		var cols = "";

		//var Taxable = $("#Taxable").val();
		var Taxable = $("#tax_auths").val();
		var TaxShowHide = 'none';
		var DropshipHide = 'none';
		if(Taxable=='Yes'){
			TaxShowHide = 'inline';
		}
		if(document.getElementById("OrderType").value=="Dropship"){
			DropshipHide = 'inline';
		}


		/*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
		cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="7"  onclick="Javascript:SetAutoComplete(this);" onblur="SearchItem(this.value,'+counter+');"   />&nbsp;<a class="fancybox fancybox.iframe" href="SelectItem.php?proc=Purchase&id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly   /><a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /><input data-parent="y" type="hidden" name="parent_ItemID' + counter + '" id="parent_ItemID' + counter + '" value="" readonly=""/><input data-ReqItem="y" type="hidden" name="Req_ItemID' + counter + '" id="Req_ItemID' + counter + '" value="" readonly=""/><input data-OrgQty="y" type="hidden" name="Org_Qty' + counter + '" id="Org_Qty' + counter + '" value="" readonly=""/><input  type="hidden" name="child_line_id' + counter + '" id="child_line_id' + counter + '" value="" readonly=""/><input  type="hidden" name="parent_line_id' + counter + '" id="parent_line_id' + counter + '" value="" readonly=""/></td><td><div <?=$style?>><select name="WID'+counter+'" id="WID'+counter+'" class="textbox" style="width:80px;"><?=$WarehouseDrop?></select></div></td><td><div <?=$style?>><input type="text" name="bin'+ counter +'" id="bin'+ counter +'" onclick="Javascript:SetAutoCompleteBin(this,'+counter+');" class="textbox"  onblur="SearchBin(this.value,'+counter+')" onclick="Javascript:SetAutoComplete(this);" size="6"   value=""/>&nbsp;<a href="javascript:void(0)" onclick="frameDisplay('+counter+');" ><img src="../images/view.gif" border="0"></a></div><input type="hidden" name="binid'+counter+'" id="binid'+counter+'" value="" readonly /></td><td <?=$style?>><div <?=$style?>><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:100px;"><option value="">Select</option> <?=$ConditionDrop?></select></div></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:332px;"  maxlength="50"  /> <a class="fancybox" href="#comments_div' + counter + '" ><img src="../images/comments.png" title="Comments" border="0"/></a><div id="comments_div' + counter + '" style="display:none;"><textarea style="height:100px;" maxlength="100" name="DesComment' + counter + '" id="DesComment' + counter + '"></textarea> </div></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="3"/></td><?if($module!="Quote"){?><td><input type="text" name="recqty' + counter + '" id="recqty' + counter + '" class="disabled" readonly size="3"/></td><?}?><td><input type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="3" maxlength="6" onkeypress="return isNumberKey(event);" /><input type="hidden" name="evaluationType' + counter + '"  id="evaluationType' + counter + '"  class="textbox"  /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="6"  onkeypress="return isDecimalKey(event);"/></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" readonly size="2" maxlength="20"  /><!--select name="tax' + counter + '" id="tax' + counter + '" class="textbox" style="width:120px;display:'+TaxShowHide+'">' + TaxRateOption + '</select--></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"],input[name^="DropshipCost"]', function (event) {
		calculateRow($(this).closest("tr"));
ProcessTotal();
		calculateGrandTotal();

	});

$("table.order-list").on("change", 'input[name^="price"]', function (event) {
		var prn = parseFloat($(this).val());
		if(prn>0){
			   $(this).val(prn.toFixed(2));  
		}else if(prn == 'NaN'){
			$(this).val('0.00');
		}else{
			$(this).val('0.00');
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
	/*$("table.order-list").on("change", 'select[name^="tax"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});*/
$("table.order-list").on("click", "#SubmitButton", function (event) {
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
//$('#Freight').on('change', function() {
$('#Freight').keyup(function(){
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
		//var DropshipCost = +row.find('input[name^="DropshipCost"]').val();
		//var SubTotal = (price*qty) + (DropshipCost*qty);
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
		var subtotal=0, TotalAmount=0 , taxAmnt=0;	
		var PrepaidAmount = 0;	
		var fr = 0;
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
	 fr =	$("#Freight").val();

var freightTaxSet = $("#TaxRate :selected").attr("freight_tax");
if(freightTaxSet=="Yes" || freightTaxSet=="No"){
	document.getElementById("freightTxSet").value = freightTaxSet;
}
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

//taxAmnt = roundNumber(taxAmnt,2);
		
		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));

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

		var tax_auths='';
		if(document.getElementById("tax_auths").value=="Yes"){
			tax_auths='Yes';
		}


		/*
		for(var i=1;i<=NumLine;i++){
			var TaxElement = document.getElementById("tax"+i);
			var ItemTaxableElement = document.getElementById("item_taxable"+i);
			if(ItemTaxableElement != null){
				var ShowHideTax = 'none';
				if(tax_auths=="Yes" && ItemTaxableElement.value=="Yes"){
					ItemTaxableElement.style.display = 'inline';
				}else{
					ItemTaxableElement.style.display = 'none';
					ItemTaxableElement.value = 'No';
				}							
				
			}
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


//By Chetan//
$(document).ready(function () {
        
      $("table.order-list").on("focus",'input[name^="sku"]', function (event) {
			
			var add_req_flag = $(this).closest("tr").find('input[name^="add_req_flag"]').val();
			if(add_req_flag == 0){
			  addRequiredItem($(this).closest("tr"));
			}		
			
    });
    });


function addRequiredItem(row) { 
			 inputstr = row.find('input[name^="sku"]').val().toLowerCase();           //By chetan 27Jan//
			
			var req_item = row.find('input[name^="req_item"]').val();
			//alert(req_item);
			//var no_req_item = row.find('input[name^="no_req_item"]').val();
			if(req_item != ''){
				var req_itm_sp = req_item.split("#");	
				var req_item_length = req_itm_sp.length;
			}	
	
			<!--FOR ITEM DELETE CODE -->
			/*var old_req_item = row.find('input[name^="old_req_item"]').val();
              
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
                                                        
                                                        rowTR.remove();
                                                       			
							 
                                                }
						

				   }	
			  }
			}		
	          }*/

		<!--END ITEM DELETE CODE-->

		<!--FOR ITEM ADD CODE -->
 		 //alert(req_item_length);
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
							/*************update by bhoodev 19jan*******************/
							document.getElementById("description"+m).setAttribute("class", "disabled");
							document.getElementById("description"+m).setAttribute("readonly", "readonly");
							/*******************************************************/
							document.getElementById("qty"+m).value = req_itm_sp_pipe[3];

							/*************update by bhoodev 19jan*******************/
							document.getElementById("qty"+m).setAttribute("class", "disabled");
							document.getElementById("qty"+m).setAttribute("readonly", "readonly");
							/*******************************************************/
							document.getElementById("on_hand_qty" + m).value = '0'; 	//responseText["qty_on_hand"];	//by chetan 27Jan//
							document.getElementById("price"+m).value = '0.00';
              document.getElementById("price"+m).disabled=true;
              document.getElementById("price"+m).setAttribute("class", "disabled");
              //class="disabled"
						// added by bhoodev for Condition Quantity 19Jan
			document.getElementById("Condition" + m).setAttribute('onChange', "getItemCondionQty('"+req_itm_sp_pipe[1]+"','"+m+"',this.value)");
			//document.getElementById("discount"+m).setAttribute("class", "disabled");	 //by chetan 27Jan//		
	// end				
		break;	
                                                }		

				   }	
				}		
			}

		}	
			
		<!--END ITEM ADD CODE-->
		        
		row.find('input[name^="add_req_flag"]').val('1');		

			
		}


//End//


function getItemCondionQty(Sku,SelID,Condi){
	

	 ShowHideLoader('1', 'P');    
	    SendUrl = 'action=getItemCondionQty&Sku='+Sku+'&Condi='+Condi;

	    $.ajax({
	            type: "GET",
	            url: "../sales/ajax.php",
	            data: SendUrl,
	            dataType : "JSON",
	            success: function(responseText){                                               
	                document.getElementById("on_hand_qty" + SelID).value =responseText["condition_qty"];  
								$('#price'+SelID).val(responseText["AvgCost"]); 
 ProcessTotal();                      
               		ShowHideLoader('2', 'P');    
                                                
                }
	    }); 
	
}
/****************************************************/

function SearchItem(Sku, SelID) {


	//By Chetan 27Jan//
	if($('#sku'+SelID).closest('tr').next().length == 1)
	{
		if($('#sku'+SelID).closest('tr').find('input[name^="item_id"]').val() == $('#sku'+SelID).closest('tr').next().find('input[name^="parent_ItemID"]').val())
 		{
			return false;
		}
	}
	//End//

		//By Chetan 27Jan// 
	if($.trim(Sku)==''){return false;}
	Sku = Sku.toLowerCase();
	if(inputstr == Sku){ 
	return false;
	}
	inputstr = Sku;
    	//End//
	
	//inputstr = Sku;
    	//End//

var ItemID ='';
var AliasID ='';
        var NumLine = document.getElementById("NumLine").value;
 var SuppCode = document.getElementById("SuppCode").value;

        /******************/
        var SkuExist = 0;
if(document.getElementById("sku"+SelID).value == ''){
		return false;
	}
       /* for (var i = 1; i <= NumLine; i++) {
            if (document.getElementById("sku" + i) != null) {
                if (document.getElementById("sku" + i).value == Sku) {
                    SkuExist = 1;
                    break;
                }
            }
        }*/
        /******************/
        if (SkuExist == 1) {
            //$("#msg_div").html('Item Sku [ ' + Sku + ' ] has been already selected.');
        } else {
            //ResetSearch();
document.getElementById("sku"+SelID).value = '';
            //var SelID = $("#id").val();
            var proc = 'Purchase';
    //By Chetan// 
            var SendUrl = "&action=SerachItemInfoCode&ItemID="+ escape(ItemID) +"&key="+escape(Sku)+"&AliasID="+escape(AliasID)+"&proc=" + escape(proc) + "&SuppCode="+SuppCode+"&r=" + Math.random();

//alert(SendUrl);

    //End//
            /******************/
            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: SendUrl,
                dataType: "JSON",
                success: function(responseText) {

			if(responseText["Sku"] == ''){


									$.fancybox.open({
											padding : 0,
											closeClick  : false, // prevents closing when clicking INSIDE fancybox
											href:'../sales/addItem.php?Sku='+Sku+'&selectid='+SelID,
											type: 'iframe',
											helpers   : { 
																		  overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
																	}
									});

										/*document.getElementById("sku" + SelID).value = '';
                    document.getElementById("item_id" + SelID).value = '';
                    document.getElementById("description" + SelID).value = '';
                    document.getElementById("qty" + SelID).value = '';
                    document.getElementById("on_hand_qty" + SelID).value = '';
                    document.getElementById("price" + SelID).value = '';
                    document.getElementById("item_taxable" + SelID).value = '';*/



}else{
                    document.getElementById("sku" + SelID).value = responseText["Sku"];
                    document.getElementById("item_id" + SelID).value = responseText["ItemID"];
                    document.getElementById("description" + SelID).value = responseText["description"];
                    document.getElementById("qty" + SelID).value = '1';
                    document.getElementById("on_hand_qty" + SelID).value = '0'; 	//responseText["qty_on_hand"];	//by chetan 27Jan//

//alert(responseText["price"]);
                    //document.getElementById("price" + SelID).value = responseText["price"];
                    document.getElementById("item_taxable" + SelID).value = responseText["purchase_tax_rate"];


                    //if (document.getElementById("serial" + SelID) != null) {
                        if (responseText["evaluationType"] == 'Serialized') {

                            //document.getElementById("serial" + SelID).style.display = "block";
			    document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];


                        }
                    //}   
                    /***/
//alert(document.getElementById("req_link" + SelID));
                    if (document.getElementById("req_link" + SelID) != null) {
                        var ReqDisplay = 'none';
                        if (responseText["NumRequiredItem"] > 0) {
                            ReqDisplay = 'inline';
                            var link_req = document.getElementById("req_link" + SelID);
                            link_req.setAttribute("href", 'reqItem.php?item=' + responseText["ItemID"]);

                        }
                        document.getElementById("req_link" + SelID).style.display = ReqDisplay;

		  	if (document.getElementById("old_req_item" + SelID) != null) {
			  document.getElementById("old_req_item" + SelID).value = document.getElementById("req_item" + SelID).value;
			  document.getElementById("add_req_flag" + SelID).value = 0;
			}

                        document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];
			//document.getElementById("no_req_item" + SelID).value = responseText["NumRequiredItem"];

			

                    }
                    /***/
document.getElementById("Condition" + SelID).setAttribute('onChange', "getItemCondionQty('"+responseText["Sku"]+"','"+SelID+"',this.value)");
                    document.getElementById("price" + SelID).focus();
		    document.getElementById("sku" + SelID).focus();     //by chetan 27Jan//
document.getElementById("qty" + SelID).focus();


                    ProcessTotal();
                    /**********************************/


                    //parent.jQuery.fancybox.close();
                    //ShowHideLoader('1', 'P');




                }
}
            });
            /******************/
        }

    }



/***************************************************/
function SetAutoComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});

}
function SetAutoCompleteBin(elm,lin){		
//alert(lin);

 var warehouse = jQuery('#WID'+lin).val();
	$(elm).autocomplete({
		source: "../jsonBin.php?WID="+warehouse,
		minLength: 1,select: function( event, ui ) {
		
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#binid'+lin).val(ui.item.id);
					 jQuery('#bin'+lin).val(ui.item.label);
					
					
					}
		}
	});

}
function frameDisplay(ln){

 var sku = document.getElementById("sku"+ln).value;
if(sku ==''){

alert('Please select sku first.');
return false;

}
 
var id = ln;
var warehouse = document.getElementById("WID"+ln).value;

$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'SelectBinLoc.php?id='+ln+'&WID='+warehouse+'&sku='+sku,
                                type: 'iframe',
  width:'50%', height:'75%',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });

}

ProcessTotal();  
</script>


 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading" width="13%">&nbsp;&nbsp;&nbsp;SKU</td>
<td  <?=$style?> width="8%" class="heading">Warehouse</td>
<td <?=$style?> width="8%" class="heading">Bin</td>
		<td <?=$style?> width="8%" class="heading">Condition</td>

		<td  class="heading">Description</td>
		<td width="6%" class="heading">Qty on Hand</td>
	<?if($module!='Quote'){?><td width="4%" class="heading" >Qty Received</td><?}?>
		<td width="6%" class="heading">Po Qty</td>
		<td width="6%" class="heading">Unit Price</td>
		<!--td width="12%" class="heading">Dropship Cost</td-->
		<td width="5%" class="heading">Taxable</td>
		<td width="10%" class="heading" align="right">Amount</td>
    </tr>
</thead>
<tbody>
	<?php $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		

	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}
$ReqDisplay = !empty($arryPurchaseItem[$Count]['req_item'])?(''):('style="display:none"');
$ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($arryPurchaseItem[$Count]["Condition"]);
$warehouseSelectedDrop  =$objCondition-> GetWarehouseDropValue($arryPurchaseItem[$Count]["WID"]);  //warehouse
$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["id"]);

	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';

	if(empty($arryPurchaseItem[$Count]['evaluationType'])) $arryPurchaseItem[$Count]['evaluationType']='';
	if(empty($arryPurchaseItem[$Count]['req_item'])) $arryPurchaseItem[$Count]['req_item']=''; 
	?>
     <tr class='itembg'>
		<td><?/*=($Line>1)?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")*/?>
<?=('<img src="../images/delete.png" id="ibtnDel">')?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="textbox"  onblur="SearchItem(this.value,<?=$Line?>)" onclick="Javascript:SetAutoComplete(this);" size="7" maxlength="10"  value="<?=stripslashes($arryPurchaseItem[$Count]["sku"])?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="SelectItem.php?proc=Purchase&id=<?=$Line?>" ><img src="../images/view.gif" border="0"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arryPurchaseItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["id"])?>" readonly maxlength="20"  />
               <!--By Chetan-->
 
                <input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['req_item'])?>" readonly />
                <input type="hidden" name="old_req_item<?=$Line?>" id="old_req_item<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['req_item'])?>" readonly />
               <!--By Chetan 27Jan-->
                 <input type="hidden" name="add_req_flag<?=$Line?>" id="add_req_flag<?=$Line?>" value="<?=($arryPurchaseItem[$Count]['sku']) ? 1 : '';?>" readonly />
                 
                 <input data-parent='y' type="hidden" name="parent_ItemID<?=$Line?>" id="parent_ItemID<?=$Line?>" value="<?=($arryPurchaseItem[$Count]['parent_item_id']) ? $arryPurchaseItem[$Count]['parent_item_id'] : '';?>" readonly=""/>
               
                <input data-ReqItem='y' type="hidden" name="Req_ItemID<?=$Line?>" id="Req_ItemID<?=$Line?>" value="" readonly=""/>
		<input data-OrgQty="y" type="hidden" name="Org_Qty<?=$Line?>" id="Org_Qty<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["Org_Qty"])?>" readonly=""/>

<input  type="hidden" name="child_line_id<?=$Line?>" id="child_line_id<?=$Line?>" value="<?=($arryPurchaseItem[$Count]['child_line_id']) ? $arryPurchaseItem[$Count]['child_line_id'] : '';?>" readonly=""/>

<input  type="hidden" name="parent_line_id<?=$Line?>" id="parent_line_id<?=$Line?>" value="<?=($arryPurchaseItem[$Count]['parent_line_id']) ? $arryPurchaseItem[$Count]['parent_line_id'] : '';?>" readonly=""/> 
                 
                 
                 
                 
               <!--End-->


		</td>
<td ><div <?=$style?>>


<select name="WID<?=$Line?>" id="WID<?=$Line?>" class="textbox"   style="width:80px;"><?=$warehouseSelectedDrop?></select>

 </div></td>
<td ><div <?=$style?>>


<input type="text" name="bin<?=$Line?>" id="bin<?=$Line?>" class="textbox"    onclick="Javascript:SetAutoCompleteBin(this,<?=$Line?>);" size="6"   value="<?=stripslashes($arryPurchaseItem[$Count]["bin"])?>"/>&nbsp;<a  href="javascript:void(0)" onclick="frameDisplay('<?=$Line?>');" ><img src="../images/view.gif" border="0"></a>
<input type="hidden" name="binid<?=$Line?>" id="binid<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['binid'])?>" readonly />

 </div></td>
<td <?=$style?>><div <?=$style?>><select name="Condition<?=$Line?>" id="Condition<?=$Line?>" <?php if($_GET['edit']>0){ ?>onchange="getItemCondionQty('<?=stripslashes($arryPurchaseItem[$Count]['sku'])?>','<?=$Line?>',this.value)" <?php }?> class="textbox" style="width:100px;"><option value="">Select</option><?=$ConditionSelectedDrop?></select></div></td>
        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:332px;"  maxlength="50"  value="<?=stripslashes($arryPurchaseItem[$Count]["description"])?>"/>

<a class="fancybox" href="#DesComment<?=$Line?>" ><img src="../images/comments.png" title="Comments" border="0" /></a>
<div id="comments_div<?=$Line?>" style="display:none;height:100px;">        
<textarea name="DesComment<?=$Line?>" id="DesComment<?=$Line?>" style="height:100px;" maxlength="100"><?=stripslashes($arryPurchaseItem[$Count]["DesComment"])?></textarea>
</div>

</td>
        <td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="3"  value="<?=stripslashes($arryPurchaseItem[$Count]["on_hand_qty"])?>"/></td>

 <?if($module!='Quote'){?><td><input type="text" name="recqty<?=$Line?>" id="recqty<?=$Line?>" class="disabled" readonly size="3"  onkeypress="return isNumberKey(event);" value="<?=$total_received?>"/></td><? }?>

        <td><input type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="3"  onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["qty"])?>"/>

<input type="hidden" name="evaluationType<?=$Line?>" id="evaluationType<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]["evaluationType"])?>">


</td>
       <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="6"  onkeypress="return isDecimalKey(event);" value="<? if($arryPurchaseItem[$Count]['DropshipCheck'] ==1 && !empty($_GET['SaleID'])){  echo stripslashes($arryPurchaseItem[$Count]["DropshipCost"]); } else { echo stripslashes($arryPurchaseItem[$Count]["price"]); }?>"/>

<input type="hidden" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" class="textbox" readonly value="<?=stripslashes($arryPurchaseItem[$Count]["DropshipCheck"])?>"/>
</td>
	<!--td><input type="text" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryPurchaseItem[$Count]["DropshipCheck"])?>"/></td-->
       <td>
       <input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryPurchaseItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />
	   
	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arryPurchaseItem[$Count]['amount'])?>"/>


</td>
       
    </tr>
	<? 
		$subtotal += $arryPurchaseItem[$Count]["qty"]*$arryPurchaseItem[$Count]["price"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="11" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
	 <input type="hidden" name="DelItemID" id="DelItemID" value="" class="inputbox" readonly />
		<? 	
		 $subtotal = number_format($subtotal, 2, ".", "");
		$taxAmnt = $arryPurchase[0]['taxAmnt'];
		$Freight = $arryPurchase[0]['Freight']; 
		$PrepaidAmount = $arryPurchase[0]['PrepaidAmount'];
		$TotalAmount = $arryPurchase[0]['TotalAmount'];  
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/>
		<br><br>
 	Freight Cost : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>

		<div id="PrepaidAmountDiv" <?  if($arryPurchase[0]['PrepaidFreight']!=1){echo 'style="display:none"';}?>>
		Prepaid Freight : <input type="text" align="right" name="PrepaidAmount" id="PrepaidAmount" class="textbox" value="<?=$PrepaidAmount?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		</div>
		<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="13" style="text-align:right;"/><br><br>


	


		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
		<br><br>
 
        </td>
    </tr>
</tfoot>
</table>
 
 
