
function ResetSearch(){   
    $("#prv_msg_div").show();
    $("#frmSrch").hide();
    $("#preview_div").hide();
    $("#msg_div").html("");
}

function ShowList(){   
    $("#prv_msg_div").hide();
    $("#frmSrch").show();
    $("#preview_div").show();
}

 function validateForm(frm) {
            var NumLine = parseInt($("#NumLine").val());


            var bomID = Trim(document.getElementById("bomID")).value;



            if (ValidateForSelect(frm.bom_Sku, "Bill Number")
                    && ValidateForSelect(frm.bill_option, "Bill WIth Option")

                    ) {
 if(document.getElementById("bill_option").value == 'No'){
                for(var i=1;i<=NumLine;i++){
                
                 if(document.getElementById("bill_option"+i).value <=0){
                 if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
                 return false;
                 }
                 }
                
                 }
}

                for (var i = 1; i <= NumLine; i++) {
                    if (document.getElementById("sku" + i) != null) {
                        if (document.getElementById("evaluationType" + i) == "Serialized") {
                            if (!ValidateForSimpleBlank(document.getElementById("serial_qty" + i), "Serial Number for " + document.getElementById("sku" + i).value)) {
                                return false;
                            }

                        }

                    }
                }

                //var Url2 = "isRecordExists.php?bom_code="+escape(document.getElementById("bom_code").value)+"&editID="+bomID;
                //SendExistRequest(Url2,'bom_code', "Bill Number"); 


                var Url = "isRecordExists.php?BOMSKU=" + escape(document.getElementById("Sku").value) + "&editID=" + bomID;
                SendExistRequest(Url, 'Sku', "Bill Number");



                return false;


            } else {
                return false;
            }

        }


function OpenLink(){
    
    
                if (document.getElementById("Sku").value != '' && document.getElementById("item_id").value > 0 && bill_option == 'Yes') {
                
            var linkhref = $('#addOption').attr("href") + '?Sku=' + document.getElementById("Sku").value + '&item_id=' + document.getElementById("item_id").value + '&description=' + document.getElementById("description").value + '&bill_option=' + document.getElementById("bill_option").value + '&bomID=' + document.getElementById("bomID").value;
                        $('#addOption').attr("href", linkhref);
                    } else {

                        var styleU = "pointer-events: none; cursor: default";
                        $('#addOption').attr("style", styleU);
                    }
    
}




        $(document).ready(function() {
            $('#bill_option').on('change', function() {
                var Sku = $('#bom_Sku').val();
                var item_id = $('#bom_item_id').val();
                var description = $('#bom_description').val();
                var bill_option = $('#bill_option').val();
                var bomID = $('#bomID').val();
                if (this.value == 'Yes') {
                    $('#opt_cat').show();
                    $('#component').hide();

                    if (Sku != '' && item_id > 0 && description != '' && bill_option == 'Yes') {
                        var linkhref = $('#addOption').attr("href") + '?Sku=' + Sku + '&item_id=' + item_id + '&description=' + description + '&bill_option=' + bill_option + '&bomID=' + bomID;
                        $('#addOption').attr("href", linkhref);
                    } else {

                        var styleU = "pointer-events: none; cursor: default";
                        $('#addOption').attr("style", styleU);
                    }
                } else {
                    $('#opt_cat').hide();
                    $('#component').show();
                    var linkhref = $('#addOption').attr("href") + '';
                    $('#addOption').attr("href", linkhref);
                }
            });


        });

               





function SearchBoCode(Key){
  
var DataExist =0;
 var bomID = window.parent.document.getElementById("bom_Sku").value;
if(document.getElementById("bom_Sku").value==''){
return false;
}

DataExist = CheckExistingData("isRecordExists.php","&BOMSKU="+escape(Key)+"&editID="+bomID, "Sku","Bill Number");
  
 if(DataExist == 1){
         $("#msg_div").html('Item Sku [ '+Key+' ] has been already selected.');
    }else{

  var SendUrl = "&action=SearchBomCode&key="+escape(Key)+"&r="+Math.random();
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {


             if(responseText["Sku"] == undefined){
                 alert('Item Sku [ '+document.getElementById("bom_Sku").value+' ] is not exists.');
                   document.getElementById("bom_Sku").value='';
                   document.getElementById("bomCondition").value='';
                   document.getElementById("bom_item_id").value='';
                   document.getElementById("bom_description").value='';
                   document.getElementById("bom_on_hand_qty").value='';
                   document.getElementById("bom_price").value='';
                   
                  }else{
		           document.getElementById("bom_Sku").value=responseText["Sku"];
		           document.getElementById("bomCondition").value=responseText["Condition"];
		           document.getElementById("bom_item_id").value=responseText["ItemID"];
		           document.getElementById("bom_description").value=responseText["description"];
		            document.getElementById("bom_on_hand_qty").value=responseText["qty_on_hand"];
		            document.getElementById("bom_price").value=responseText["sell_price"];
		           
               }
           


            }
        });
        /******************/
  }

}

function SearchBOMComponent(key,count){
 var NumLine = document.getElementById("NumLine").value;   
   
    /******************/
    var SkuExist = 0;
	if(document.getElementById("sku"+count).value == ''){
		return false;
	}
  //alert(NumLine );
 for(var i=1;i<=NumLine;i++){
 if (document.getElementById("sku" + i) != null) {
        if(document.getElementById("sku"+count).value != ''){
	   if(i!=count){
            if(document.getElementById("sku"+i).value == key){
                SkuExist = 1;
                break;
            }
	  }
        }else{
          return false;
}
}
    }

//alert(NumLine );

    /******************/
    if(SkuExist == 1){
   	
         alert('Item Sku [ '+key+' ] has been already selected.');
	 document.getElementById("sku"+count).value = '';
          
    }else{
        ResetSearch();
         document.getElementById("sku"+count).value = '';
        var SelID = count;
       //alert(SelID );
        var SendUrl = "&action=SearchBomCode&key="+escape(key)+"&r="+Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
            //alert(responseText["Condition"]);
                   if(responseText["Sku"] == undefined){
                        alert('Item Sku [ '+key+' ] is not exists.');
                        document.getElementById("sku"+SelID).value='';
			document.getElementById("sku"+SelID).value='';
			document.getElementById("item_id"+SelID).value='';
                        document.getElementById("Condition"+SelID).value='';
			//window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
			document.getElementById("description"+SelID).value='';
			document.getElementById("qty"+SelID).value='';
			document.getElementById("price"+SelID).value='';
			
                   }else{
			document.getElementById("sku"+SelID).value=responseText["Sku"];
			document.getElementById("item_id"+SelID).value=responseText["ItemID"];
                        document.getElementById("Condition"+SelID).value=responseText["Condition"];
			//window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
			document.getElementById("description"+SelID).value=responseText["description"];
			document.getElementById("qty"+SelID).value='1';
			document.getElementById("price"+SelID).value=responseText["purchase_cost"];
			document.getElementById("qty"+SelID).focus();
                      }



                   //parent.jQuery.fancybox.close();
                   //ShowHideLoader('1','P');
                     //jQuery.fancybox.close();
           


            }
        });
        /******************/
    }

}



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
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="10" onclick="Javascript:SetAutoComplete(this);" onblur="return SearchBOMComponent(this.value,'+counter+');" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="comItemList.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /></td><td style="display:none"><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionDrop?></select></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly style="width:350px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="qty' + counter + '" id="qty' + counter + '" class="textbox"  size="5"/><input type="hidden" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isNumberKey(event);"/><input type="hidden" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="WastageQty"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});
        
      $("table.order-list").on("focus",'input[name^="sku"]', function (event) {
			
			var add_req_flag = $(this).closest("tr").find('input[name^="add_req_flag"]').val();
			if(add_req_flag == 0){
			  addRequiredItem($(this).closest("tr"));
			}		
			
			
			
			
			
		});

	$("table.order-list").on("blur", 'input[name^="WastageQty"]', function (event) {
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
                var Wastageqty = row.find('input[name^="Wastageqty"]').val(); 
                var serial_sku = row.find('input[name^="sku"]').val(); 
		if(qty>0){
                        var linkhref = $(this).attr("href")+'&total='+qty+'&Wastageqty='+Wastageqty+'&sku='+serial_sku;
                       	$(this).attr("href", linkhref);
		}
		/*****************************/

	});
        

	});

	function calculateRow(row) {
            
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		var WastageQty = +row.find('input[name^="WastageQty"]').val();
                var totalQ = qty;
		var SubTotal = price*totalQ;
//alert(totalQ);
		

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
							document.getElementById("qty"+m).value = req_itm_sp_pipe[3];
							//document.getElementById("on_hand_qty"+m).value = req_itm_sp_pipe[4];
							//document.getElementById("price"+m).value = '0.00';
                                                       // document.getElementById("price"+m).disabled=true;
                                                        //document.getElementById("price"+m).setAttribute("class", "disabled");
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


