<?  
(empty($style))?($style=""):("");
?>
<style>
html {
  font-family: "roboto", helvetica;
  position: relative;
  height: 100%;
  font-size: 100%;
  line-height: 1.5;
  color: #444;
}

h2 {
  margin: 1.75em 0 0;
  font-size: 5vw;
}
#popup1{

top: 18.5px;
}
h3 { font-size: 1.3em; }

.v-center {
  height: 100vh;
  width: 100%;
  display: table;
  position: relative;
  text-align: center;
}

.v-center > div {
  display: table-cell;
  vertical-align: middle;
  position: relative;
  top: -10%;
}



.btn:hover {
  background-color: #ddd;
  -webkit-transition: background-color 1s ease;
  -moz-transition: background-color 1s ease;
  transition: background-color 1s ease;
}

.btn-small {
  padding: .75em 1em;
  font-size: 0.8em;
float: right;
}

.modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 98%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}
@media (min-width: 32em) {

.modal-box { width: 70%; }
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

//.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}

</style>




<?php
 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
 } 

#print_r($arryCompany[0]['TrackInventory']);


?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">
var inputstr;   //By chetan 2Sept//
var addVariant;
var CondDrop;

	$(document).ready(function () {
	var counter = 2;
	var reqcounter = 1;
        
	var TaxRateOption = $("#TaxRateOption").val();
var ComSType = $("#ComSType").val();

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
<?php if($Config['TrackVariant']==1){?>

 addVariant ='<td><div id="VariantINvalues' + counter + '" style="width:100%;"></div></td>';


<?php } ?>

if(ComSType ==0){

CondDrop = '<td><div ><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:110px;"><option value="">Select Condition</option><?=$ConditionDrop?></select></div></td>';

}



	//By Chetan 31Aug//		
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input data-sku="y" type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox" size="10" maxlength="10" style="width: 83px;"  onclick="Javascript:SetAutoComplete(this);" onblur="SearchQUOTEComponent(this.value,'+counter+')" />&nbsp;<a href="#" onclick="javascript:selectItem(\''+counter+ '\',1);return false;"><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /><input data-parent="y" type="hidden" name="parent_ItemID' + counter + '" id="parent_ItemID' + counter + '" value="" readonly=""/><input data-ReqItem="y" type="hidden" name="Req_ItemID' + counter + '" id="Req_ItemID' + counter + '" value="" readonly=""/><input data-OrgQty="y" type="hidden" name="Org_Qty' + counter + '" id="Org_Qty' + counter + '" value="" readonly=""/></td>'+addVariant+' '+CondDrop+'<td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:400px;"   maxlength="50" onkeypress="return isAlphaKey(event);" /> <a class="fancybox" href="#comments_div' + counter + '" ><img src="../images/comments.png" title="Comments" border="0"/></a><div id="comments_div' + counter + '" style="display:none;"><textarea style="height:100px;" maxlength="100" name="DesComment' + counter + '" id="DesComment' + counter + '"></textarea> </div></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="3"/></td><td><input data-qty="y" type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="3" maxlength="6" onkeypress="return isNumberKey(event);" /><input type="hidden" align="right" name="CustDiscount' + counter + '" id="CustDiscount' + counter + '" readonly class="disabled"  value="" /><span style="display:none;" id="serial' + counter + '"><a class="fancybox slnoclass fancybox.iframe addSerialItem" onclick="Javascript:SetSerialUrl('+ counter +');" href="addSerial.php?id=' + counter + '" id="addSlItem' + counter + '"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a><input type="hidden" name="serial_value' + counter + '" id="serial_value' + counter + '" value=""  /></span><input type="hidden" name="evaluationType' + counter + '" id="evaluationType' + counter + '" value=""  /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="6" maxlength="15" onkeypress="return isDecimalKey(event);"/><input type="hidden" align="right" name="CustDiscount' + counter + '" id="CustDiscount' + counter + '" readonly class="disabled"  value="" /></td><td align="center"><input type="checkbox" name="DropshipCheck'+counter+'" id="DropshipCheck'+counter+'" onclick="return dropshipcost('+counter+');"></td><td><input type="text" name="DropshipCost'+counter+'" id="DropshipCost'+counter+'" style="display:none;"  class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);"></td><td><input type="text" name="discount' +counter+ '" id="discount' +counter+ '" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" /></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" readonly size="2" maxlength="20"  /><!--select name="tax' + counter + '" id="tax' + counter + '" class="textbox" style="width:120px;display:'+TaxShowHide+'">'+TaxRateOption+'</select--></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="disabled ReAmnt" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;


	});






	$("table.order-list").on("blur", 'input[name^="price"],input[name^="DropshipCost"],input[name^="qty"],input[name^="discount"]', function (event) {
		
                calculateRow($(this).closest("tr"));
		GlobalRestockingVal();
		calculateGrandTotal();
		 
		
	});

	$("table.order-list").on("focus",'input[name^="sku"]', function (event) {
			
			var add_req_flag = $(this).closest("tr").find('input[name^="add_req_flag"]').val();
			if(add_req_flag == 0){
			  addRequiredItem($(this).closest("tr"));
			}		
			
			
			
			
			
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



	$("table.order-list").on("click", "a.addSerialItem", function(event) {

            /********Edited by pk **********/

            var row = $(this).closest("tr");console.log(row);
            var qty = row.find('input[name^="qty"]').val();console.log(row.find('input[name^="qty"]'));
            var serial_sku = row.find('input[name^="sku"]').val();
            var serial_value_sel = row.find('input[name^="serial_value"]').val();
             
            if (qty > 0) {
                var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku +'&SerialValue='+serial_value_sel;
                 
                $(this).attr("href", linkhref);
            }
            /*****************************/

        });



	$('#ReSt').change(function(){
		GlobalRestockingVal();
		calculateGrandTotal();
        });
	 
	$('#Freight').keyup(function(){
	calculateGrandTotal();
	});


	});

 

function GlobalRestockingVal(){
    var total = 0;
    var RestockingVal = $('#RsValhidden').val();
    var restock=$('#ReSt').val();

    //console.log(restock);
    if(restock=='1'){

    document.getElementById("ReSID").style.display="block";
    
    $("table.order-list").find("tr.itembg").each(function () {
        var objtr = $(this);
            if(objtr.find('.ReAmnt').val()>0){
                total +=parseFloat(objtr.find('.ReAmnt').val())*RestockingVal/100;
            }
            else{
               $('#ReStocking').val(total.toFixed(2));
            }

       });
    }else{
		document.getElementById("ReSID").style.display="none";

		document.getElementById("ReStocking").value = "";
     }
    
    //console.log(total);
    if(total!=0){
           $('#ReStocking').val(total.toFixed(2));
        }
     return total;

}



     function addRequiredItem(row) { 
			
			inputstr = row.find('input[name^="sku"]').val().toLowerCase();           //By chetan 3Sep//
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
							document.getElementById("qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;    //By Chetan 22Sep//
							document.getElementById("on_hand_qty"+m).value = req_itm_sp_pipe[4];
							document.getElementById("price"+m).value = '0.00';
                                                        document.getElementById("price"+m).disabled=true;
                                                        document.getElementById("price"+m).setAttribute("class", "disabled");
                                                        document.getElementById("qty"+m).setAttribute("class", "disabled");
                                                        document.getElementById("qty"+m).setAttribute("readonly", "readonly");
							document.getElementById("parent_ItemID"+m).value = row.find('input[name^="item_id"]').val(); //By Chetan 28Aug//
							document.getElementById("Org_Qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;    //By Chetan 22Sep//	
                                                        $("#sku"+m).next('a').attr('onclick','return false;');              //By Chetan 18Sep//
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
//alert(taxRate);
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
		var SubTotal = price*qty;
		//var SubTotal = price*qty+DropshipCost*qty;
			if(TotalDisCount > 0){
				SubTotal = SubTotal-TotalDisCount;
			}
		var tax_add = 0;


		if(taxRate!='' && item_taxable=="Yes"){

			var arrField = taxRate.split(":");
			var tax = arrField[2];
 
			tax_add = (SubTotal*tax)/100;
			
			//SubTotal += tax_add;
		}
                
                

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {		
		var subtotal=0, TotalAmount=0 , taxAmnt=0,  ReStocking=0;		
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

/********************************************/
if(document.getElementById("freightTxSet") != null){
	var fr =	$("#Freight").val();
	freightTaxSet = document.getElementById("freightTxSet").value;
	//alert(freightTaxSet);
	 console.log(freightTaxSet);
	if(fr!='' && tax>0 && freightTaxSet =='Yes'){		
		FrtaxAmnt = (fr*tax)/100;	
		FrtaxAmnt = taxAmnt+FrtaxAmnt;
		taxAmnt  = FrtaxAmnt;
	}
}

if($("#ReSt").val()==1 && tax>0){
	var RetaxAmnt = ($("#ReStocking").val()*tax)/100;
	console.log(RetaxAmnt);
	RetaxAmnt = taxAmnt+RetaxAmnt;
	taxAmnt  = RetaxAmnt;
	//subtotal += +RetaxAmnt;
}

/********************************************/
	
		taxAmnt = roundNumber(taxAmnt,2);	

		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));

		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();
		subtotal += -$("#ReStocking").val();


		$("#TotalAmount").val(subtotal.toFixed(2));
		
    
	}



	function ProcessTotal() {
		var Taxable = $("#Taxable").val();
		var NumLine = document.getElementById("NumLine").value;
		
		var tax_auths='';
		if(document.getElementById("tax_auths").value=="Yes"){
			tax_auths='Yes';
		}


		/*for(var i=1;i<=NumLine;i++){
			//var TaxElement = document.getElementById("tax"+i);
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
		/*$("table.order-list").find('input[name^="req_item"]').each(function () {

			addRequiredItem($(this).closest("tr"));
			
			
		});*/

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
     
    if(document.getElementById("DropshipCheck"+num).checked == true)
        {
            document.getElementById("DropshipCost"+num).style.display = 'inline';
        }else{
            document.getElementById("DropshipCost"+num).style.display = 'none';
            document.getElementById("DropshipCost"+num).value='0';
     
        }
       
}
//END






function SearchQUOTEComponent(key,count){


	//By Chetan 2Sep// 
	if($.trim(key)==''){return false;}
	key = key.toLowerCase();
	if(inputstr == key){ 
	return false;
	}
	inputstr = key;
    	//End//


 var NumLine = document.getElementById("NumLine").value;   
   
    /******************/
    var SkuExist = 0;
	if(document.getElementById("sku"+count).value == ''){
		return false;
	}
  
	//By Chetan 9Sep// 
    ShowHideLoader('1', 'P');
    $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',true);})
    //End// 


   /*for(var i=1;i <= NumLine;i++){
	   if(i!=count){
		if(document.getElementById("sku"+i) !=null){
		    if(document.getElementById("sku"+i).value == key){
		        SkuExist = 1;
		        break;
		    }
		}
	  }
    }*/



    /******************/
    if(SkuExist == 1){
   	
         alert('Item Sku [ '+key+' ] has been already selected.');
	 document.getElementById("sku"+count).value = '';
          //By Chetan 9Sep// 
         ShowHideLoader('2', 'P');
         $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);})
         //End//
 
    }else{
        //ResetSearch();
        document.getElementById("sku"+count).value = '';
        var SelID = count;
       //alert(SelID );
        var SendUrl = "&action=SearchQuoteCode&key="+escape(key)+"&SelID="+SelID+"&r="+Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
            //alert(responseText["variantDisplay"]);
                   if(responseText["Sku"] == undefined){
                        //alert('Item Sku [ '+key+' ] is not exists.');
                        document.getElementById("sku"+SelID).value='';
			document.getElementById("sku"+SelID).value='';
			document.getElementById("item_id"+SelID).value='';
                        document.getElementById("Condition"+SelID).value='';
			document.getElementById("on_hand_qty"+SelID).value='';//responseText["qty_on_hand"];
			document.getElementById("description"+SelID).value='';
			document.getElementById("qty"+SelID).value='';
			document.getElementById("price"+SelID).value='';
			 //By Chetan 9Sep// 
			ShowHideLoader('2', 'P');
                        $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);})
                        //End//

                   }else{

			 document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];      //By Chetan2Sep//
                        //By Chetan 2Sep for display component//                       
                        if(responseText["itemType"] == 'Kit' && typeof responseText["KitItemsCount"] != 'undefined' && responseText["KitItemsCount"] > 0 && typeof responseText["showPopUp"] == 'undefined')
                        {
                            if(confirm("Display Component Item!")) {
                                document.getElementById("req_item" + SelID).value = responseText["RequiredItem"]+'#'+responseText["KitItems"];
                            } 
                        }    
                        
            
                        //to show alias and option code popup//
                        if(typeof responseText["showPopUp"] != 'undefined' && responseText["showPopUp"] == 'y')        //By Chetan 18Sep//  
                        {
                            $.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'getOptionCode.php?ItemID='+responseText["ItemID"]+'&key='+responseText["Sku"]+'&proc=Sale&id='+SelID+'&back=No',
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
                            
                            ShowHideLoader('2', 'P');           //By Chetan 9Sep// 
                            return false;
                        }
                       //End//

			document.getElementById("sku"+SelID).value=responseText["Sku"];
			document.getElementById("item_id"+SelID).value=responseText["ItemID"];
                        //document.getElementById("Condition"+SelID).value=responseText["Condition"];
			document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
			document.getElementById("description"+SelID).value=responseText["description"];
			document.getElementById("qty"+SelID).value='1';
                        /*document.getElementById("qty"+SelID).setAttribute("class", "disabled");
                        document.getElementById("qty"+SelID).setAttribute("readonly", "readonly");*/  //By Chetan 22Sep//
			//document.getElementById("price"+SelID).value=responseText["purchase_cost"];
			//document.getElementById("qty"+SelID).focus();
			window.parent.document.getElementById("Req_ItemID" + SelID).value = responseText["ReqItemIDs"];   //By Chetan 31Aug//
                        
                        var MDAmount = document.getElementById("MDAmount").value;
                        var MDType = document.getElementById("MDType").value;
                        var MDiscount = document.getElementById("MDiscount").value;
                        var CustDisType = document.getElementById("CustDisType").value;
                        var totDiscountAmt =0;
                        var totDiscountCal =0;
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
				totDiscountCal = Number(responseText["price"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["price"])-Number(totDiscountCal);

			}else if(CustDisType == "Fixed"){
				  totDiscountCal =  Number(MDAmount);
				  totDiscountAmt = Number(responseText["price"]) - Number(MDAmount); 
				  
			}

		 }else if(MDType == 'Markup'){

				totDiscountCal = Number(responseText["price"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["price"]) + Number(totDiscountCal);

                     }
   
	document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2);
       document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);



}else{

       document.getElementById("price" + SelID).value = responseText["price"];
       document.getElementById("CustDiscount"+ SelID).value = '';
}
                    document.getElementById("item_taxable" + SelID).value = responseText["sale_tax_rate"]; //responseText["Taxable"];


                    if (document.getElementById("serial" + SelID) != null) {
                        if (responseText["evaluationType"] == 'Serialized') {

                            document.getElementById("serial" + SelID).style.display = "block";
			    document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];


                        } else {
                            document.getElementById("serial" + SelID).style.display = "none";
                        }
                    }   
                    /***/
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

                        //document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];
			//document.getElementById("no_req_item" + SelID).value = responseText["NumRequiredItem"];
                           

                    }
                    /***/

//var prev=document.getElementById("VariantINvalues" + SelID).innerHTML;
       
          //COde for variant
          //alert(responseText['variantDisplay']);
          //prev= prev+'<div id="innerVariantlist_<?=$_GET['id']?>">'+jQuery.parseJSON(responseText);
          //prev=prev+responseText['variantDisplay'];

//By chetan 21Sep//
if(responseText['variantDisplay']!=''){ 
         document.getElementById("VariantINvalues" + SelID).innerHTML=responseText['variantDisplay'];
}

       //End//
		 $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);});           //By Chetan 9Sep// 
		document.getElementById("price" + SelID).focus();
		document.getElementById("sku" + SelID).focus();         //By chetan 31Aug//


                    ProcessTotal();
                    //ShowHideLoader('1', 'P');
		ShowHideLoader('2', 'P');            //By Chetan 9Sep// 

                        
                        
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

//By Chetan 18sep//
$(function(){
    
    //For removing required item if main item sku changed//
    $(document).on('keypress','.itembg td:first-child input[data-sku="y"]',function(e){
       
        textstr = $.trim($(this).val());
       
    })
    
    $(document).on('keyup','.itembg td:first-child input[data-sku="y"]',function(e){
        
        //IndexRow = (parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''))); 
       // if(e.keyCode === 8){
                if($.trim($(this).val()) !== textstr){
                removeChild($(this));
           }
        //}
        
    });    
    /*$(document).on('input','.itembg td:first-child input[data-sku="y"]',function(){
      
        if($.trim($(this).val()) !== textstr)
        {
           removeChild($(this));           
        }    
       
   })*/
   //End//   
   
   //For changing qty of all required item on main item qty change//
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
                       	$res = QtyVAl * ($('#Org_Qty'+Indexing+'').val().replace(/[^0-9\.]/g, ''));
                        $(this).val($res);
                        $(this).addClass('disabled');
                        $(this).attr('readonly', 'readonly');
                    }
            });
        //}
     
   })
   
    //End//   

	 //By chetan 9sep//
   //to remove disable attr and to call again same item name typed before//
   $(document).on('click','.fancybox-close', function(){
       inputstr = '';
       $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);});
   });
   
    //End//   
	

	 //Pop up css script//
    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
	    $("body").append(appendthis);
	    $(".modal-overlay").fadeTo(500, 0.7);
			var modalBox = $(this).attr('data-modal-id');
			$('#'+modalBox).fadeIn($(this).data());
		});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() + $(".modal-box").outerHeight()),
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2,
        posititon:'fixed'
    });
});

	
//pop up search on keyup21Sep//
$(document).on('click', '#go', function(){  searchTable($('#search').val()); });

    
})

//function to remove item all required items//
function removeChild(obj){
    var ids = [];
    IndexRow = (parseInt(obj.attr('id').replace(/[^0-9\.]/g, ''))); 
    if($('#req_item'+IndexRow+'').val() !='')
    {
        var selItem = $('#item_id'+IndexRow+'').val();
        if(selItem!='')
        {
            $('.itembg td:first-child input[data-parent="y"]').each(function(number){

                ids.push((parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''))));
            });
           
            $(ids).each(function(index, value){
              
               if($('#parent_ItemID'+value+'').val() == selItem)
                {    
                    $('#parent_ItemID'+value+'').closest('tr').remove();
                }
               
           })

        }
    } 
}




//18Sep//
function selectItem(line,pageNo)
{   
    ShowHideLoader('1', 'P');    
    SendUrl = 'action=SelectItem&proc=Sale&id='+line+'&curP='+pageNo;
    $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function(responseText){  
                                                $('#popup1 .modal-body').html(responseText);
                                                $('#popup1').css('display','block');
                                                
                                                //convert php paging into jquery ajax//    
    
                                                $('a.pagenumber, a.edit22').each(function(){
                                                   
                                                    arrstr = $(this).attr('href').split('?');
                                                    arrstr = arrstr[1].split('&');
                                                    $.each(arrstr, function( index, value ) {
                                                        
                                                        if(/curP/.test(value))
                                                        {
                                                             page = parseInt(value.replace(/[^0-9\.]/g, '')); 
                                                        }
                                                    })
                                                   
                                                    $(this).attr('href','#');
                                                    line = $('#NumLine').val();
                                                    $(this).attr('onclick','javascript:selectItem("'+line+'","'+page+'")');

                                                });
                                                //End//
                                                $(window).resize();
						$(window).scrollTop($(window).height() + $(".modal-box").outerHeight());
                                                ShowHideLoader('2', 'P');    
                                                
                                                
                                            }
    }); 
}    


function SetItemCode(ItemID, Sku, SelID,proc) {
	var NumLine = document.getElementById("NumLine").value;
//var SelID = $("#id").val();

	/******************/
	var SkuExist = 0;

	/*for (var i = 1; i <= NumLine; i++) {
	    if (document.getElementById("sku" + i) != null) {
		if (document.getElementById("sku" + i).value == Sku) {
		    SkuExist = 1;
		    break;
		}
	    }
	}*/
	/******************/
        if (SkuExist == 1) {
            $("#msg_div").html('Item Sku [ ' + Sku + ' ] has been already selected.');
        } else {
                ShowHideLoader('1', 'P');
		//ResetSearch();
		//var SelID = $("#id").val();
		//var proc = $("#proc").val();
		/*By Chetan14Aug*/
		var showComponent = ($('#yes').is(':checked'))? '1' :''; 
		var SendUrl = "&action=ItemInfo&ItemID=" + escape(ItemID) + "&proc=" + escape(proc) +"&showcompo="+ showComponent + "&SelID="+SelID+"&r=" + Math.random();


            /******************/
            $.ajax({
                type: "GET",
                url: "../sales/ajax.php",
                data: SendUrl,
                dataType: "JSON",
                success: function(responseText) {

			document.getElementById("sku" + SelID).value = responseText["Sku"];
			document.getElementById("item_id" + SelID).value = responseText["ItemID"];
			document.getElementById("description" + SelID).value = responseText["description"];
			document.getElementById("qty" + SelID).value = '1';
			document.getElementById("on_hand_qty" + SelID).value = responseText["qty_on_hand"];
			document.getElementById("Req_ItemID" + SelID).value = responseText["ReqItemIDs"];     //By Chetan 31Aug//
			document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];	
               	var MDAmount = document.getElementById("MDAmount").value;
                var MDType = document.getElementById("MDType").value;
		var MDiscount = document.getElementById("MDiscount").value;
		var CustDisType = document.getElementById("CustDisType").value;
                var totDiscountAmt =0;
		var totDiscountCal =0;
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

		
  
}
document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2); document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);
 
}else if(MDiscount == "Sale"){


		if(MDType == "Discount"){

			if(CustDisType == "Percentage"){
				totDiscountCal = Number(responseText["price"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["price"])-Number(totDiscountCal);

			}else if(CustDisType == "Fixed"){
				  totDiscountCal =  Number(MDAmount);
				  totDiscountAmt = Number(responseText["price"]) - Number(MDAmount); 
				  
			}

		 }else if(MDType == 'Markup'){

				totDiscountCal = Number(responseText["price"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["price"]) + Number(totDiscountCal);

                     }
   
	document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2);
       document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);



}else{

       document.getElementById("price" + SelID).value = responseText["price"];
       document.getElementById("CustDiscount"+ SelID).value = '';
}
                    document.getElementById("item_taxable" + SelID).value = responseText["sale_tax_rate"]; //responseText["Taxable"];


                    if (document.getElementById("serial" + SelID) != null) {
                        if (responseText["evaluationType"] == 'Serialized') {

                            document.getElementById("serial" + SelID).style.display = "block";
			    document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];


                        } else {
                            document.getElementById("serial" + SelID).style.display = "none";
                        }
                    }   
                    /***/
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
if(responseText['variantDisplay']!=''){ 
var prev=document.getElementById("VariantINvalues" + SelID).innerHTML;
       
          //COde for variant
         
          prev=prev+responseText['variantDisplay'];
          document.getElementById("VariantINvalues" + SelID).innerHTML=prev;
       //End
    }               document.getElementById("price" + SelID).focus();
		    document.getElementById("sku" + SelID).focus();			//By Chetan 31Aug//


                    ProcessTotal();
                    /**********************************/


                    //parent.jQuery.fancybox.close();
                    ShowHideLoader('2', 'P');

		$('#popup1').css('display','none');   //By Chetan 18Sep//


                }
            });
            /******************/
        }

    }
/*function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
        $("#msg_div").html("");
    }

    function ShowList() {
        $("#prv_msg_div").hide();
        $("#frmSrch").show();
        $("#preview_div").show();
    }*/

//21Sep//
function searchTable(inputVal)
{
	 ShowHideLoader('1', 'P');
    line = $('#id').val();
    SendUrl = 'action=SelectItem&str='+inputVal+'&proc=Sale&id='+line+'&curP=1';
    $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function(responseText){
                
                        $('#popup1 .modal-body').html(responseText);
                        $('#popup1').css('display','block');

                        //convert php paging into jquery ajax//    

                        $('a.pagenumber, a.edit22').each(function(){

                            arrstr = $(this).attr('href').split('?');
                            arrstr = arrstr[1].split('&');
                            $.each(arrstr, function( index, value ) {

                                if(/curP/.test(value))
                                {
                                     page = parseInt(value.replace(/[^0-9\.]/g, '')); 
                                }
                            })

                            $(this).attr('href','#');
                            line = $('#NumLine').val();
                            $(this).attr('onclick','javascript:selectItem("'+line+'","'+page+'")');

                        });
                        //End//
                        $(window).resize();
                        $(window).scrollTop($(window).height() + $(".modal-box").outerHeight());
                        ShowHideLoader('2', 'P');    


                    }
    }); 
}




function SetSerialUrl(id){
	/*var sku = $("#sku"+id).val();
	$("#addSlItem"+id).attr("href", "addSerial.php?sku="+sku);*/
}
</script>


<input type="hidden" align="right" name="RsValhidden" id="RsValhidden" readonly size="13" maxlength="10" value="<?=$RsValhidden;?>" />

 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td width="12%" class="heading">&nbsp;&nbsp;SKU</td>
                <?php if($Config['TrackVariant']==1) {?><td  class="heading" width="10%"> Variant</td><?php }?>
<? if($Config['SelectOneItem']!=1){?>
		<td width="8%" class="heading">Condition</td>
<? }?>
		<td  class="heading">Description</td>
		<td width="5%" class="heading">Qty on Hand</td>
		<td width="5%" class="heading">Qty</td>
		<td width="5%" class="heading">Unit Price</td>
                	<td width="4%" class="heading" align="center">Dropship</td>
                	<td width="5%" class="heading">Cost</td>
		<td width="3%" class="heading">Discount</td>
		<td width="5%" class="heading">Taxable</td>
		<td width="5%" class="heading" align="right">Amount</td>
    </tr>
</thead>
<tbody>
	<? 
	$subtotal=0;
	
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		

	#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
	if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}
	$evaluationType = !empty($arrySaleItem[$Count]['evaluationType'])?($arrySaleItem[$Count]['evaluationType']):("");

	if($evaluationType=='Serialized' || $evaluationType=='Serialized Average'){
            $SlNoHide = 'inline';
	}else{
	   $SlNoHide = 'none';
	}
	$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
        $ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($arrySaleItem[$Count]["Condition"]);
	if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';


	?>
     <tr class='itembg'>
		<td>

<?=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;")?>
		<input data-sku='y' type="text" name="sku<?=$Line?>" style="width:83px;"  id="sku<?=$Line?>" class="textbox"  size="50" maxlength="50"  value="<?=stripslashes($arrySaleItem[$Count]['sku'])?>" onblur="SearchQUOTEComponent(this.value,<?=$Line?>)" onclick="Javascript:SetAutoComplete(this);"/>&nbsp;<a href="#" onclick="javascript:selectItem('<?=$Line?>','1');return false;" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['item_id'])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arrySaleItem[$Count]['id']?>" readonly maxlength="20"  />
		
		<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
               

                 <input type="hidden" name="old_req_item<?=$Line?>" id="old_req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
                 <input type="hidden" name="add_req_flag<?=$Line?>" id="add_req_flag<?=$Line?>" value="" readonly />
		<!--By Chetan 31Aug-->
                <input data-parent='y' type="hidden" name="parent_ItemID<?=$Line?>" id="parent_ItemID<?=$Line?>" value="" readonly=""/>
                <input data-ReqItem='y' type="hidden" name="Req_ItemID<?=$Line?>" id="Req_ItemID<?=$Line?>" value="" readonly=""/>
		<input data-OrgQty="y" type="hidden" name="Org_Qty<?=$Line?>" id="Org_Qty<?=$Line?>" value="" readonly=""/>
                <!--End--> 

		</td>
 <?php if($Config['TrackVariant']==1) {?>               
<td><!--a class="fancybox fancybox.iframe" href="variantList.php?id=<?=$Line?>" ><?=$search?></a-->
                    
                        <div id="VariantINvalues<?=$Line?>" style="width:100%;"></div>
                        
                         <?php 
                         /********code start  for edit******/
                         if($_GET['edit']>0){  ?>
                          <div style="width:100%;" id="VariantINvalues1">
        <?php 
        /**code start for variant Listing**/
       
        $varianttype='SalesQuote';// bysachin
        $quoteItemVariant=$objvariant->GetQuoteVariantfotQuoteItem($arrySaleItem[$Count]["id"],$varianttype);
        
        if(!empty($quoteItemVariant)){
            
            foreach($quoteItemVariant as $values){
         
        ?>
                              
        <div id="innerVariantlist_<?php echo $arrySaleItem[$Count]["id"]; echo $values['variantID'];?>">
                <input type="text" disabled="" style="" class="inputbox" value="<?php echo $values['variant_name']; ?>" name="variantname_<?=$Line?>">
                
                <input type="hidden" value="<?php echo $values['variantID'];?>" name="variantID_<?=$Line?>[]">
                <?php 
                if($values['variant_type_id']=='4'){
                    
                    $quoteItemVariantOptionValue=$objvariant->GetQuoteVariantOptionValuefotQuoteItem($arrySaleItem[$Count]["id"],$values['variantID'],$varianttype);
                      $data_slected_option=  array();
                    if(count($quoteItemVariantOptionValue)>0){
                           foreach($quoteItemVariantOptionValue as $val){
                               
                                $data_slected_option[] =  $val['variantOPID'];
                               
                               
                           }
                         
                         
                     }
                    
                    
                    $arryvariantOP = $objvariant->GetMultipleVariantOption($values['variantID']);
                    //echo '<pre>'; print_r($quoteItemVariantOptionValue);
                     //echo '<pre>'; print_r($arryvariantOP);die;
                    //echo '<pre>'; print_r($data_slected_option);
                    if(!empty($arryvariantOP)){ ?>
                
                    <select name="varmul_<?=$Line?>[<?php echo $values['variantID']; ?>][]" multiple style="width: 100%;">
                        <?php
                    $i=0;
                    
                    foreach($arryvariantOP as $arryvariantOPv)
                        { ?>
                    
                    <option value="<?php echo $arryvariantOPv['id']; ?>" <?php if(in_array($arryvariantOPv['id'], $data_slected_option)){ echo 'selected';}?>><?php echo $arryvariantOPv['option_value']; ?></option>
                    <?php $i++;
                    }
                    echo '</select>'; ?>
                    
                    
                <?php } }
                else if($values['variant_type_id']=='5'){
                    //echo 'drop';
                    $quoteItemVariantOptionValue=$objvariant->GetQuoteVariantOptionValuefotQuoteItem($arrySaleItem[$Count]["id"],$values['variantID'],$varianttype);
                    $data_slected_option=  array();
                    if(count($quoteItemVariantOptionValue)>0){
                           foreach($quoteItemVariantOptionValue as $val){
                               
                                $data_slected_option[] =  $val['variantOPID'];
                               
                               
                           }
                         
                         
                     } ?>
                    
                     <?php 
                    
                    $arryvariantOP = $objvariant->GetMultipleVariantOption($values['variantID']);
                    //echo '<pre>'; print_r($arryvariantOP);die;
                    if(!empty($arryvariantOP)){ ?>
                   <select name="varmul_<?=$Line?>[<?php echo $values['variantID']; ?>][]" style="width: 100%;">
                       <?php
                    $i=0;
                    foreach($arryvariantOP as $arryvariantOPv)
                        { ?>
                    
                    <option value="<?php echo $arryvariantOPv['id']; ?>" <?php if(in_array($arryvariantOPv['id'], $data_slected_option)){ echo 'selected';}?>><?php echo $arryvariantOPv['option_value']; ?></option>
                    <?php $i++;
                    }
                    echo '</select>'; 
                //$quoteItemVariantOptionValue=$objvariant->GetQuoteVariantOptionValuefotQuoteItem($arrySaleItem[$Count]["id"],$values['variantID']);
                    ?>
                    
                <?php } } ?>
                
                <!--<select name="varmul_1[16][]">
                <option value="">select</option>
                <option value="62">rr</option>
                
                </select>
                <img style="float: right; margin-top: 20px; margin-bottom: 10px; cursor: pointer;" title="Delete" onclick="myFunctionvariant(161)" id="variantDel1" src="../images/delete.png">
                -->
                <!--img src="../images/delete.png" id="variantDel<?=$_GET['id']?>"  title="Delete" onclick="myFunctionvariantD('<?php echo $arrySaleItem[$Count]["id"];?>','<?php echo $values['variantID'];?>','<?php echo $values['type'];?>')" style="float: right; margin-top: 20px; margin-bottom: 10px; cursor: pointer;"-->
                </div>
        
        
        <?php  /**code End for variant Listing**/ }/*end foreach*/}/*end if*/?>
            </div>   
                             
                             
                       <?php  }
                         /************End Code for edit**********************/
                         ?>  
                    
                    <!--<input type="text" id="variantName" value=""/>
                    <input type="hidden" id="variantID" value=""/>-->
                
                </td>
 <?php }?>

<? if($Config['SelectOneItem']!=1){?>
<td ><div <?=$style?>><select name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:110px;"><option value="">Select </option><?=$ConditionSelectedDrop?></select></div></td>
<? }?>
        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:400px;"   onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]['description'])?>"/>

<a class="fancybox" href="#DesComment<?=$Line?>" ><img src="../images/comments.png" title="Comments" border="0" /></a>
<div id="comments_div<?=$Line?>" style="display:none;height:100px;">        
<textarea name="DesComment<?=$Line?>" id="DesComment<?=$Line?>" style="height:100px;" maxlength="100"><?=stripslashes($arrySaleItem[$Count]["DesComment"])?></textarea>
</div>




</td>
        <td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="3"  value="<?=stripslashes($arrySaleItem[$Count]['on_hand_qty'])?>"/></td>
        <td><input data-qty="y" type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="3" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arrySaleItem[$Count]['qty'])?>"/><span style="display:<?=$SlNoHide?>;"  id="serial<?= $Line ?>">
                  <a  class="fancybox slnoclass fancybox.iframe addSerialItem" onclick="Javascript:SetSerialUrl(<?=$Line?>);" href="addSerial.php?id=<?=$Line?>" id="addSlItem<?=$Line?>"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
 <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?=$arrySaleItem[$Count]['SerialNumbers']?>"  />

                   </span>
  <?php if(empty($arrySaleItem[$Count]['evaluationType'])){ $arrySaleItem[$Count]['evaluationType']='';}?>               
<input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arrySaleItem[$Count]['evaluationType']?>"  /></td>
       <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="6" maxlength="15" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]['price'])?>"/><input type="hidden" align="right" name="CustDiscount<?=$Line?>" id="CustDiscount<?=$Line?>" readonly class="disabled"  value="<?=$arrySaleItem[$Count]['CustDiscount']?>" size="13" style="text-align:right;"/></td>
       <td align="center"><input type="checkbox" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" <?php if($arrySaleItem[$Count]["DropshipCheck"] == '1'){echo "checked";}?> onclick="return dropshipcost(<?=$Line?>);"></td>
       <td><input type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>" <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1){?>style="display:none;"<?php }?>  class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]['DropshipCost'])?>"></td>
       <td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]['discount'])?>"/></td>
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
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled ReAmnt" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arrySaleItem[$Count]['amount'])?>"/></td>
       
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
		$subtotal = number_format($subtotal,2,".","");
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight']; 
		$ReStocking = $arrySale[0]['ReStocking'];
		$TotalAmount = $arrySale[0]['TotalAmount'];
if($arrySale[0]['CustDisAmt']!='') $displayBlock ="style=display:block;"; else $displayBlock ="style=display:none;";
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/><br><br>

<input type="hidden" align="right" name="MDType" id="MDType" readonly class="disabled"  value="<?=$arrySale[0]['MDType']?>" /> 


<input type="hidden" align="right" name="MDAmount" id="MDAmount" readonly class="disabled"  value="<?=$arrySale[0]['MDAmount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="MDiscount" id="MDiscount" readonly class="disabled"  value="<?=$arrySale[0]['MDiscount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="CustDisType" id="CustDisType" class="disabled"  value="<?=$arrySale[0]['CustDisType']?>" />
<input type="hidden" align="right" name="ComSType" id="ComSType" class="disabled"  value="<?=$Config['SelectOneItem']?>" />


<!--/div-->
		

		
		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>

<div id="ReSID" <?=($arrySale[0]['ReSt']=='1')?('style="display: inline;"'):('style="display: none;"')?> >
			<span style="color:red;">Re-Stocking Fee :</span> <input type="text" align="right" name="ReStocking"
				id="ReStocking" class="textbox"  value="<?=$ReStocking?>"  size="13" maxlength="10"
				onkeypress="return isDecimalKey(event);"
				onblur="calculateGrandTotal();" style="text-align: right; color:red;" /> <br><br>
			</div>

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
			'width'         : 300
		 });
                 
                 

});

</script>

<? #echo '<script>SetInnerWidth();</script>'; ?>

<div id="popup1" class="modal-box">
  <header> <a href="#" class="btn btn-small js-modal-close">Close</a> 
    <h3>Select Item</h3>
  </header>
  <div class="modal-body">
      
  </div>    
     <footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
</div>
