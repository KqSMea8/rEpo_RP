<?
(empty($disable))?($disable=""):("");
(empty($style))?($style=""):("");

(empty($arrySaleItem[$Count]["FromDate"]))?($arrySaleItem[$Count]["FromDate"]=""):("");
(empty($arrySaleItem[$Count]["ToDate"]))?($arrySaleItem[$Count]["ToDate"]=""):("");
 
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

	$(document).ready(function () {
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
		if(Taxable=='Yes'){
			TaxShowHide = 'inline';
		}
<?php if($Config['TrackVariant']==1){?>

 addVariant ='<td><div id="VariantINvalues' + counter + '" style="width:100%;"></div></td>';


<?php } ?>
	
	//********************** Amit Singh***************************
        if($("#EntryType").val()=="recurring"){
            var optn="block";
            //$("#calenderDiv").show(1000);//Amit Singh
            //alert('recurring');
        }else{
            var optn="none";
            //$("#calenderDiv").hide(1000);//Amit Sin
        }
        //*********************************************************/	

	//By Chetan 31Aug//		
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input data-sku="y" type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox" size="10" maxlength="10" style="width: 83px;"  onclick="Javascript:SetAutoComplete(this);" onblur="SearchQUOTEComponent(this.value,'+counter+')" />&nbsp;<a href="#" onclick="javascript:selectItem(\''+counter+ '\',1);return false;"><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /><input data-parent="y" type="hidden" name="parent_ItemID' + counter + '" id="parent_ItemID' + counter + '" value="" readonly=""/><input data-ReqItem="y" type="hidden" name="Req_ItemID' + counter + '" id="Req_ItemID' + counter + '" value="" readonly=""/><input data-OrgQty="y" type="hidden" name="Org_Qty' + counter + '" id="Org_Qty' + counter + '" value="" readonly=""/></td>'+addVariant+'<td><div <?=$style?>><select name="WID'+counter+'" id="WID'+counter+'" class="textbox" style="width:80px;"><?=$WarehouseDrop?></select></div></td><td><div <?=$style?>><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:80px;"><option value="">Select</option><?=$ConditionDrop?></select></div></td><td><input type="checkbox" name="RecurringCheck' + counter + '" id="RecurringCheck' + counter + '"  onchange="return RecurringCheck('+counter+');"><a class="fancybox reqbox  fancybox.iframe" href="../EntryType.php?line=' + counter + '" id="controle' + counter + '" class="controle" ><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a><input type="hidden" name="EntryType' + counter + '" id="EntryType' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryDate' + counter + '" id="EntryDate' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryInterval' + counter + '" id="EntryInterval' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryMonth' + counter + '" id="EntryMonth' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryWeekly' + counter + '" id="EntryWeekly' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryFrom' + counter + '" id="EntryFrom' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="EntryTo' + counter + '" id="EntryTo' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="CardChargeDate' + counter + '" id="CardChargeDate' + counter + '" class="disabled" readonly size="5"  value=""/><input type="hidden" name="CardCharge' + counter + '" id="CardCharge' + counter + '" class="disabled" readonly   value=""/></td><td><textarea name="description' + counter + '" id="description' + counter + '"  class="textbox" style="width:190px; height: 16px;"></textarea> <a class="fancybox" href="#comments_div' + counter + '" ><img src="../images/comments.png" title="Comments" border="0"/></a><div id="comments_div' + counter + '" style="display:none;"><textarea style="height:100px;" maxlength="100" name="DesComment' + counter + '" id="DesComment' + counter + '"></textarea> </div><div class="FTdate" style=" display: none"><div id="PDateDiv' + counter + '" style=" display: none;"><input type="hidden" name="FTDateLine[]" id="" value="' + counter + '" />From Date:&nbsp;&nbsp;<input type="text" readonly="" name="PFromDate' + counter + '" id="PFromDate' + counter + '" class="textbox" style="width:70px;background: #F3F3EB none repeat scroll 0% 0%;" value="<?=stripslashes($arrySaleItem[$Count]["FromDate"])?>"/><br>To Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" readonly="" name="PToDate' + counter + '" id="PToDate' + counter + '" class="textbox" style="width:70px;background: #F3F3EB none repeat scroll 0% 0%;" value="<?=stripslashes($arrySaleItem[$Count]["ToDate"])?>"/></div></div><div class="calenderDiv" style="display:'+ optn +'; float: right;"><a class="fancybox fancyboxDate fancybox.iframe" href="SalseSkuDateTime.php?line=' + counter + '"><img src="../images/calendar.gif" title="Comments" border="0" /></a></div></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="3"/></td><td><input data-qty="y" type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox"  onblur=" PriceDiscount(' + counter + ');"  size="3" maxlength="10" onkeypress="return isNumberKey(event);" /><a  class="fancybox slnoclass fancybox.iframe addSerialItem" href="addSerial.php?id=' + counter + '" id="addItem' + counter + '" style="display:none;"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a><input type="hidden" name="serial_value' + counter + '" id="serial_value' + counter + '" value=""  /></span><input type="hidden" name="evaluationType' + counter + '" id="evaluationType' + counter + '" value=""  /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="5" maxlength="15" onkeypress="return isDecimalKey(event);"/><input type="hidden" align="right" name="CustDiscount' + counter + '" id="CustDiscount' + counter + '" readonly class="disabled"  value="" /><input type="hidden" name="priceOrig' + counter + '"  id="priceOrig' + counter + '" class="textbox" size="3" maxlength="15" /></td><td align="center"><input type="checkbox" name="DropshipCheck'+counter+'" id="DropshipCheck'+counter+'" onclick="return dropshipcost('+counter+');" size="2"></td><td><input type="text" name="avgCost'+counter+'" id="avgCost'+counter+'" value="" class="disabled textbox" maxlength="6" size="3" readonly><input type="text" name="DropshipCost'+counter+'" id="DropshipCost'+counter+'" style="display:none;"  class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);"></td><td><input type="text" name="discount' +counter+ '" id="discount' +counter+ '" class="textbox" size="3" maxlength="10" onkeypress="return isDecimalKey(event);" /></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" readonly size="2" maxlength="20"  /><!--select name="tax' + counter + '" id="tax' + counter + '" class="textbox" style="width:120px;display:'+TaxShowHide+'">'+TaxRateOption+'</select--></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;


	});






	$("table.order-list").on("keyup", 'input[name^="price"],input[name^="DropshipCost"],input[name^="qty"],input[name^="discount"]', function (event) {
		
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
        //End//
	 

        
        $("table.order-list").on("click", 'input[name^="DropshipCheck"]', function (event) {
		
                //calculateRow($(this).closest("tr"));
		//calculateGrandTotal();
if($(this).closest("tr").find('input[name^="parent_ItemID"][value=""]').length=='1')
            {
                calculateRow($(this).closest("tr"));
            	calculateGrandTotal();
            }    
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
		//$(this).closest("tr").remove();
		//added by chetan on 23Mar2017//
		if((row.find('input[name^="parent_ItemID"]').val() == "") && (row.find('input[name^="item_id"]').val()!=''))
		{
			//update by chetan on 10May2017//
			if(row.hasClass('parent')){
				var delChildval = new Array();
				row.nextUntil('tr.parent').addBack().each(function(){
					delChildval.push($(this).find('input[name^="id"]').val()) ;
				});
				olddel = $("#DelItem").val().split(',');
				newArr = $.merge( olddel, delChildval);
				delChildval = $.unique(newArr);
				$("#DelItem").val(delChildval.join(','));	
				//End//
				row.nextUntil('tr.parent').addBack().remove();
			}else{
				$(this).closest("tr").remove();
			}
		}else{
			$(this).closest("tr").remove();
		}
		//end//
		calculateGrandTotal();

	});


	 
	$("table.order-list").on("click", "a.addSerialItem", function(event) {

           
            var row = $(this).closest("tr");
var Condition = row.find('select[name^="Condition"]').val();
            var qty = row.find('input[name^="qty"]').val();

            var serial_sku = row.find('input[name^="sku"]').val();
            var serial_value_sel = row.find('input[name^="serial_value"]').val();
// var serial_value_sel = row.find('input[name^="serial_value"]').val();
            var SerialValue = row.find('input[name^="SerialValue"]').val();
             
            if (qty > 0) {
                //'+serial_value_sel+' By Ravi
                var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku +'&SerialValue=&cond='+Condition;
                 
                $(this).attr("href", linkhref);
            }
            

        });




	});


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
		/*	var old_req_item = row.find('input[name^="old_req_item"]').val();
              
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
                                                        
                                                        rowTR.remove();
                                                       			
							 
                                                }
						

				   }	
			  }
			}		
	          }*/

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
							$("#sku"+m).closest('tr').css("background-color", "#d33f3e").addClass('child'); //added by chetan 21Mar2017//							
							document.getElementById("item_id"+m).value = req_itm_sp_pipe[0];
							document.getElementById("sku"+m).value = req_itm_sp_pipe[1];
							document.getElementById("description"+m).value = req_itm_sp_pipe[2];
							document.getElementById("qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;    //By Chetan 22Sep//
							//document.getElementById("on_hand_qty"+m).value = req_itm_sp_pipe[4];
							document.getElementById("on_hand_qty"+m).value = '0';
							document.getElementById("price"+m).value = '0.00';
                                                        document.getElementById("price"+m).disabled=true;
                                                        document.getElementById("price"+m).setAttribute("class", "disabled");
							//9feb//
							document.getElementById("priceOrig"+m).value = '0.00';
							document.getElementById("priceOrig"+m).disabled=true;
							document.getElementById("priceOrig"+m).setAttribute("class", "disabled");
							//End//


                                                        document.getElementById("qty"+m).setAttribute("class", "disabled");
                                                        document.getElementById("qty"+m).setAttribute("readonly", "readonly");
							document.getElementById("parent_ItemID"+m).value = row.find('input[name^="item_id"]').val(); //By Chetan 28Aug//
							document.getElementById("Org_Qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;    //By Chetan 22Sep//	
                                                        $("#sku"+m).next('a').attr('onclick','return false;');              //By Chetan 18Sep//


// added by Chetan for Condition Quantity 9feb
document.getElementById("Condition" + m).setAttribute('onChange', "getItemCondionQty('"+req_itm_sp_pipe[1]+"','"+m+"',this.value)");
document.getElementById("discount"+m).setAttribute("class", "disabled");
			
if(row.find('input[name^="evaluationType"]').val() === 'Serialized' || row.find('input[name^="evaluationType"]').val() === 'Serialized Average')
		{
			document.getElementById("addItem"+m).style.display='block';
			//$('#addItem'+ m).show();		
		}
			
		//End//
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

		//var taxRate = row.find('select[name^="tax"]').val();	
	
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();		
		var discount = +row.find('input[name^="discount"]').val();
		var TotalDisCount = discount*qty;
               
		var item_taxable = row.find('input[name^="item_taxable"]').val();

<?php if ($_SESSION['SelectOneItem']!='1'){?>	
                var DropshipCost = +row.find('input[name^="DropshipCost"]').val();
<? }else{?>
var DropshipCost =0;
<? }?>


	        if(discount>0 && discount>=price)
		{
		   alert("Discount Should be Less Than Unit Price!");
		   return false;
		}
		//var SubTotal = price*qty+DropshipCost*qty;
		var SubTotal = price*qty;
			if(TotalDisCount > 0){
				SubTotal = SubTotal-TotalDisCount;
			}
		var tax_add = 0;


		if(taxRate!=0 && item_taxable=="Yes"){

			var arrField = taxRate.split(":");
			var tax = arrField[2];
			tax_add = (SubTotal*tax)/100;
			
			//SubTotal += tax_add; //open by chetan on 23feb//
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
/********************************************/
var TDiscount =	$("#TDiscount").val();
if(TDiscount!=''){

TDiscount = (TDiscount*tax)/100;
taxAmnt = taxAmnt-TDiscount;
}
var fr =	$("#Freight").val();
//freightTaxSet = document.getElementById("freightTxSet").value;
 var freightTaxSet = $("#TaxRate :selected").attr("freight_tax");
document.getElementById("freightTxSet").value = freightTaxSet;
//alert(freightTaxSet);
// console.log(freightTaxSet);
if(fr>0 && tax>0 && freightTaxSet =='Yes'){		
				FrtaxAmnt = (fr*tax)/100;	
				FrtaxAmnt = taxAmnt+FrtaxAmnt;
				taxAmnt  = FrtaxAmnt;
}

/********************************************/
		taxAmnt = roundNumber(taxAmnt,2);	

		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));
		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();
		subtotal += -$("#TDiscount").val();


               

	      		$("#TotalAmount").val(subtotal.toFixed(2));
		
    
}



	function ProcessTotal() {
		var Taxable = $("#Taxable").val();
		var NumLine = document.getElementById("NumLine").value;
		
		var tax_auths='';
		if(document.getElementById("tax_auths").value=="Yes"){
			tax_auths='Yes';
		}

                   //By chetan 8Jan// 
		$("table.order-list").find('input[name^="amount"]').each(function () {
                    if($(this).closest("tr").find('input[name^="parent_ItemID"][value=""]').length=='1')
                    {
			calculateRow($(this).closest("tr"));
                    }    
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
     
   /* if(document.getElementById("DropshipCheck"+num).checked == true)
        {
            document.getElementById("DropshipCost"+num).style.display = 'inline';
        }else{
            document.getElementById("DropshipCost"+num).style.display = 'none';
            document.getElementById("DropshipCost"+num).value='0';
     
        }*/

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
//END






function SearchQUOTEComponent(key,count){

	
	//By Chetan 18Jan//
	if($('#sku'+count).closest('tr').next().length == 1)
	{
		if($('#sku'+count).closest('tr').find('input[name^="item_id"]').val() == $('#sku'+count).closest('tr').next().find('input[name^="parent_ItemID"]').val())
 		{
			return false;
		}
	}
	//End//

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
$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'../sales/addItem.php?Sku='+key+'&selectid='+SelID,
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
//AlertMsg(document.getElementById("sku"+SelID),'Item Sku [ '+key+' ] is not exists, click here to <a href="../inventory/editItem.php" target="_blank">Add Item</a>.');
                        document.getElementById("sku"+SelID).value='';
			document.getElementById("sku"+SelID).value='';
			document.getElementById("item_id"+SelID).value='';
                        document.getElementById("Condition"+SelID).value='';
			document.getElementById("on_hand_qty"+SelID).value='';//responseText["qty_on_hand"];
			document.getElementById("description"+SelID).value='';
			document.getElementById("qty"+SelID).value='';
			document.getElementById("price"+SelID).value='';
			document.getElementById("priceOrig"+SelID).value='';   //9feb//
			 //By Chetan 9Sep// 
			ShowHideLoader('2', 'P');
                        $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);})
                        //End//

                   }else{

			//document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];       //By Chetan2Sep//hide by chetan on 21Mar2017//
                        //By Chetan 2Sep for display component//                       
                        if(responseText["itemType"] == 'Kit' && typeof responseText["KitItemsCount"] != 'undefined' && responseText["KitItemsCount"] > 0 && typeof responseText["showPopUp"] == 'undefined')
                        {
                            if(confirm("Display Component Item!")) {
				$reqitem = (responseText["RequiredItem"]) ? responseText["RequiredItem"]+'#' : '';  //Added by chetan 26Feb//                               
				document.getElementById("req_item" + SelID).value = $reqitem + responseText["KitItems"];
				if(document.getElementById("req_item" + SelID).value) $("#sku"+SelID).closest('tr').addClass('parent').css("background-color", "#106db2"); else  $("#sku"+SelID).closest('tr').addClass('parent');  //Added by chetan on 23Mar2017//
                            }else{
				$("#sku"+SelID).closest('tr').addClass('parent');  //Added by chetan on 23Mar2017//
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
			
			$("#sku"+SelID).closest('tr').addClass('parent');   //added by chetan 29Mar2017//
			document.getElementById("sku"+SelID).value=responseText["Sku"];
			document.getElementById("item_id"+SelID).value=responseText["ItemID"];
                        //document.getElementById("Condition"+SelID).value=responseText["Condition"];
			document.getElementById("on_hand_qty"+SelID).value='0';
			document.getElementById("description"+SelID).value=responseText["description"];
			document.getElementById("qty"+SelID).value='1';
                        /*document.getElementById("qty"+SelID).setAttribute("class", "disabled");
                        document.getElementById("qty"+SelID).setAttribute("readonly", "readonly");*/  //By Chetan 22Sep//
			//document.getElementById("price"+SelID).value=responseText["purchase_cost"];
			//document.getElementById("qty"+SelID).focus();
			window.parent.document.getElementById("Req_ItemID" + SelID).value = responseText["ReqItemIDs"];   //By Chetan 31Aug//

			 // added by Chetan for Condition Quantity 9feb
			document.getElementById("Condition" + SelID).setAttribute('onChange', "getItemCondionQty('"+responseText["Sku"]+"','"+SelID+"',this.value)");

			document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];	
			if(responseText["evaluationType"] == 'Serialized' || responseText["evaluationType"] == 'Serialized Average')
			{
				document.getElementById("addItem"+SelID).style.display ='block';
				//$('#addItem'+ SelID).show();		
			}else{
				//$('#addItem'+ SelID).hide();
				document.getElementById("addItem"+SelID).style.display ='none';	
			}
			document.getElementById("item_taxable" + SelID).value = responseText["sale_tax_rate"];//responseText["Taxable"];// update by chetan 23Feb  //	
			//End//
                        
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
                    //document.getElementById("item_taxable" + SelID).value = responseText["Taxable"];


                    /*by chetan 26feb
			if (document.getElementById("serial" + SelID) != null) {
                        if (responseText["evaluationType"] == 'Serialized' || responseText["evaluationType"] == 'Serialized Average') {

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

//To disable condition select if sku have children 9feb//

$('.itembg td:first-child input[data-parent="y"][value="0"]').each(function(){

	if($(this).closest('tr').next().length > 0)
	{
		if($(this).closest('tr').next().find('input[name^="parent_ItemID"]').val() == $(this).closest('tr').find('input[name^="item_id"]').val() && $(this).closest('tr').find('input[name^="NotitemAlias"]').length > 0)
		{
			$(this).closest('tr').find('select[name^="Condition"]').addClass('disabled').prop('disabled',true);
		}
	}

})
//End//
$('#Freight').keyup(function(){
    calculateGrandTotal();
});
$('#TDiscount').keyup(function(){
    calculateGrandTotal();
});

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
			//Updated by Chetan 9feb//
			document.getElementById("on_hand_qty" + SelID).value = '0';//responseText["qty_on_hand"];
			document.getElementById("Req_ItemID" + SelID).value = responseText["ReqItemIDs"];     //By Chetan 31Aug//
			document.getElementById("Condition" + SelID).setAttribute('onChange', "getItemCondionQty('"+responseText["Sku"]+"','"+SelID+"',this.value)");

		
		document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];	
		if(responseText["evaluationType"] == 'Serialized' || responseText["evaluationType"] == 'Serialized Average')
		{
						document.getElementById("addItem" + SelID).style.display = 'block';
			//$('#addItem'+ SelID).show();		
		}else{
	document.getElementById("addItem" + SelID).style.display = 'none';
			//$('#addItem'+ SelID).hide();	
		}
		document.getElementById("item_taxable" + SelID).value = responseText["sale_tax_rate"];//responseText["Taxable"];// update by chetan 23Feb  //	
		//End//

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
	document.getElementById("priceOrig" + SelID).value = responseText["price"];//amit singh 
	document.getElementById("CustDiscount"+ SelID).value = '';
}
                    //document.getElementById("item_taxable" + SelID).value = responseText["Taxable"];

		/*by chetan 26feb
                    if (document.getElementById("serial" + SelID) != null) {
                        if (responseText["evaluationType"] == 'Serialized' || responseText["evaluationType"] == 'Serialized Average') {

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




/*function SetSerialUrl(id){
	var sku = $("#sku"+id).val();
	$("#addSlItem"+id).attr("href", "addSerial.php?sku="+sku);
}*/

//update by Chetan 13Jan for Avg Cost//
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
				$MainselID = $('#parent_ItemID'+SelID).closest('tr').prevAll().find('input[name^="item_id"][value="'+$ParentItemId+'"]').last().attr('id').replace(/[^0-9\.]/g, '');//console.log($MainselID+'-main');
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

 PriceDiscount(SelID);
	
			ShowHideLoader('2', 'P');    
		                                
		}
	    }); 
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
//var Inprice = document.getElementById("price"+SelID).value;
var price = document.getElementById("price"+SelID).value;
//alert(price);
var avgCost = document.getElementById("avgCost"+SelID).value;
//document.getElementById("priceOrig" + SelID).value =  price;
//alert(MDiscount);
if(MDiscount == 'Cost'){
 
	//alert(1); 
	/*	if(MDType == 'Discount'){

			if(CustDisType == "Percentage"){
				totDiscountCal = Number(avgCost)*Number(MDAmount)/100;
				totDiscountAmt = Number(avgCost)-Number(totDiscountCal);

			}else{
				  totDiscountCal = Number(MDAmount);
				  totDiscountAmt = Number(avgCost) - Number(MDAmount); 
				  
			}


		}else{*/


			if(CustDisType == "Percentage" && avgCost>0){
				totDiscountCal = Number(avgCost)*Number(MDAmount)/100;
				totDiscountAmt = Number(avgCost)+Number(totDiscountCal);

			//}

		
  
}else{
//alert(2);
totDiscountCal =0.00;
totDiscountAmt = Number(price);
 

}
document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2);
 document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);

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
 //alert(3);
		document.getElementById("price" + SelID).value = price;
		document.getElementById("priceOrig" + SelID).value = price;
		//jQuery("#price" + SelID).val(responseText["price"]);
		//jQuery("#priceOrig" + SelID).val(price);
		document.getElementById("CustDiscount"+ SelID).value = '';
}
   
return true;

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
$('#CardChargeDate'+lin).val('');
$('#CardCharge'+lin).val('');

}


}
</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
					<td width="12%" class="heading">&nbsp;&nbsp;SKU</td>
					<?php if($Config['TrackVariant']==1) {?><td  class="heading" width="10%"> Variant</td><?php }?>
<td width="8%" class="heading">Warehouse</td>
					<td width="8%" class="heading">Condition</td>
					<td width="3%" class="heading">Recurring</td>
					<td  class="heading">Description</td>
					<td width="5%" class="heading">Qty on Hand</td>
					<td width="5%" class="heading">Qty</td>
					<td width="5%" class="heading">Unit Price</td>
					<td width="3%" class="heading" align="center">Dropship</td>
					<td width="5%" class="heading">Cost</td>
					<td width="3%" class="heading">Discount</td>
					<td width="3%" class="heading">Taxable</td>
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
if(!empty($arrySaleItem[$Count]["SerialNumbers"])){
            $SlNoHide = 'inline';
	}else{
	   $SlNoHide = 'none';
	}
	$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
 
	$ConditionSelectedDrop='';
	if(!empty($arrySaleItem[$Count]["Condition"])){
		$ConditionSelectedDrop  = $objCondition-> GetConditionDropValue($arrySaleItem[$Count]["Condition"]);
	}
	$warehouseSelectedDrop='';
	if(!empty($arrySaleItem[$Count]["WID"])){
		$warehouseSelectedDrop  =$objCondition-> GetWarehouseDropValue($arrySaleItem[$Count]["WID"]);  //warehouse 
	}

	if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';


	?>
     <?php 
        //By chetan 6Jan//updated on 23Mar2017 for color//
        
        if(!empty($arrySaleItem[$Count]['parent_item_id'])){
		$color = "style='background-color:#d33f3e'";
		$class = 'child';
        }else{
		if(!empty($arrySaleItem[$Count]['req_item'])){
            		$color = (!empty($_GET['edit'])) ? "style='background-color:#106db2'" : '';
		}else{
			$color = '';
		}
		$class = 'parent';
        }//End//?>

     <tr class='itembg <?=$class?>'   <?=$color?>>
		<td>

<?//=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;");edited by amit 22Jan16?>
<img src="../images/delete.png" id="ibtnDel" title="Delete">
<!--By chetan 18Jan--->
		<input style="width:83px;" data-sku="y" type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" size="50" maxlength="50" value="<?=stripslashes($arrySaleItem[$Count]['sku'])?>" <?php if($disable){ echo 'readonly class="disabled textbox"';}else{?> onblur="SearchQUOTEComponent(this.value,<?=$Line?>)" onclick="Javascript:SetAutoComplete(this);" class="textbox" <?php } ?>/>&nbsp;
<?php if(empty($disable)){?><a href="#" onclick="javascript:selectItem('<?=$Line?>','1');return false;" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a><?php }?>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['item_id'])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arrySaleItem[$Count]['id']?>" readonly maxlength="20"  />
		
		<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
                  

                 <input type="hidden" name="old_req_item<?=$Line?>" id="old_req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
                
                 <input type="hidden" name="add_req_flag<?=$Line?>" id="add_req_flag<?=$Line?>" value="<?=($arrySaleItem[$Count]['sku']) ? 1 : '';?>" readonly />
               <input data-parent='y' type="hidden" name="parent_ItemID<?=$Line?>" id="parent_ItemID<?=$Line?>" value="<?=$arrySaleItem[$Count]['parent_item_id']?>" readonly=""/>
                <input data-ReqItem='y' type="hidden" name="Req_ItemID<?=$Line?>" id="Req_ItemID<?=$Line?>" value="" readonly=""/>
		<input data-OrgQty="y" type="hidden" name="Org_Qty<?=$Line?>" id="Org_Qty<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["Org_Qty"])?>" readonly=""/>
                
               <?php	
	//2feb by chetan//
	$ItemEvType = $objItem->checkItemSku($arrySaleItem[$Count]["sku"]);
	if($ItemEvType){?>
	<input data-alias="n" type="hidden" name="NotitemAlias<?=$Line?>" id="NotitemAlias<?=$Line?>" value="" readonly=""/>
<?php } //End//?>

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
<td ><div <?=$style?>>


<select name="WID<?=$Line?>" id="WID<?=$Line?>" class="textbox"   style="width:80px;"><?=$warehouseSelectedDrop?></select>

 </div></td>
<td ><div <?=$style?>><?php 
//By chetan 9feb//

if(empty($disable)){?>

<select name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" <?php if($_GET['edit']>0){ ?>onchange="getItemCondionQty('<?=stripslashes($arrySaleItem[$Count]['sku'])?>','<?=$Line?>',this.value)" <?php }?> style="width:80px;"><option value="">Select </option><?=$ConditionSelectedDrop?></select>

<?php }else{

if($arrySaleItem[$Count]["Condition"])
{
echo $arrySaleItem[$Count]["Condition"];
}else{
echo "No Value Selected";
} }?></div>

</td>

<td><input type="checkbox" name="RecurringCheck<?=$Line?>" id="RecurringCheck<?=$Line?>" <?php if($arrySaleItem[$Count]["RecurringCheck"] == 'on'){echo "checked";}?> onchange="return RecurringCheck(<?=$Line?>);">
<?php if($_GET['edit']!='' && $arrySaleItem[$Count]["RecurringCheck"] == 'on' ){   $RecDis =''; }else{ $RecDis ='display:none;'; } ?>
<a class="fancybox reqbox  fancybox.iframe" style="<?=$RecDis?>" href="../EntryType.php?line=<?=$Line?>&edit=<?=$arrySaleItem[$Count]['id']?>" id="controle<?=$Line?>" class="controle" ><?=$edit?></a>

<?
$EntryFrom='';
$EntryTo='';
$CardChargeDate='';

if($arrySaleItem[$Count]["EntryFrom"]>0) $EntryFrom = $arrySaleItem[$Count]["EntryFrom"];
if($arrySaleItem[$Count]["EntryTo"]>0) $EntryTo = $arrySaleItem[$Count]["EntryTo"];
if($arrySaleItem[$Count]["CardChargeDate"]>0) $CardChargeDate = $arrySaleItem[$Count]["CardChargeDate"];

?>

<input type="hidden" name="EntryType<?=$Line?>" id="EntryType<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryType"])?>"/>
<input type="hidden" name="EntryDate<?=$Line?>" id="EntryDate<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryDate"])?>"/>
<input type="hidden" name="EntryInterval<?=$Line?>" id="EntryInterval<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryInterval"])?>"/>
<input type="hidden" name="EntryMonth<?=$Line?>" id="EntryMonth<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryMonth"])?>"/>
<input type="hidden" name="EntryWeekly<?=$Line?>" id="EntryWeekly<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryWeekly"])?>"/>
<input type="hidden" name="EntryFrom<?=$Line?>" id="EntryFrom<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($EntryFrom)?>"/>
<input type="hidden" name="EntryTo<?=$Line?>" id="EntryTo<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($EntryTo)?>"/>

<input type="hidden" name="CardChargeDate<?=$Line?>" id="CardChargeDate<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($CardChargeDate)?>"/>
<input type="hidden" name="CardCharge<?=$Line?>" id="CardCharge<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["CardCharge"])?>"/>

</td>
        <td>
<!--<input  <?php if(empty($disable)){?> class="textbox" <?php }else{ echo $disable; }?>type="text" name="description<?=$Line?>" id="description<?=$Line?>" style="width:200px;"   onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/>-->
<textarea name="description<?=$Line?>" id="description<?=$Line?>"  <?php if(empty($disable)){?> class="textbox" <?php }else{ echo $disable; }?> style="width:190px; height: 16px;"><?=stripslashes($arrySaleItem[$Count]["description"])?></textarea>

<?php if(empty($disable)){?><a class="fancybox" href="#DesComment<?=$Line?>" ><img src="../images/comments.png" title="Comments" border="0" /></a><?php } //End//?>


<!-----------------------------------------Amit Singh----27nov2015------------------------------------>
<div class="FTdate" style=" display: none">
<div id="PDateDiv<?=$Line?>" style=" display: none;">
    <input type="hidden" name="FTDateLine[]" id="" value="<?=$Line?>" />
    From Date:&nbsp;&nbsp;<input type="text" readonly="" name="PFromDate<?=$Line?>" id="PFromDate<?=$Line?>" class="textbox" style="width:70px;background: #F3F3EB none repeat scroll 0% 0%;" value="<?=stripslashes($arrySaleItem[$Count]["FromDate"])?>"/><br>
    To Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" readonly="" name="PToDate<?=$Line?>" id="PToDate<?=$Line?>" class="textbox" style="width:70px;background: #F3F3EB none repeat scroll 0% 0%;" value="<?=stripslashes($arrySaleItem[$Count]["ToDate"])?>"/>
</div>
</div>
<div class="calenderDiv" style="display:none; float: right;">
    <!--a class="fancyboxDate" href="#calenderPop<?=$Line?>"-->
    <a class="fancybox fancyboxDate fancybox.iframe" href="SalseSkuDateTime.php?line=<?=$Line?>">
        <img src="../images/calendar.gif" title="Choose date" border="0" />
    </a>
</div>

<!-----------------------------------------End---------------------------------------->



<div id="comments_div<?=$Line?>" style="display:none;height:100px;">        
<textarea name="DesComment<?=$Line?>" id="DesComment<?=$Line?>" style="height:100px;" maxlength="100"><?=stripslashes($arrySaleItem[$Count]["DesComment"])?></textarea>
</div>




</td>
        <td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="3"  value="<?=stripslashes($arrySaleItem[$Count]['on_hand_qty'])?>"/></td>
        <td><input <?=$disable?> data-qty="y" type="text" name="qty<?=$Line?>"  onblur=" PriceDiscount('<?=$Line?>');"  id="qty<?=$Line?>" class="textbox" size="3" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arrySaleItem[$Count]['qty_invoiced'])?>"/>


<?php  
//by chetan 9feb//
 	$ItemEvType = $objItem->checkItemSku($arrySaleItem[$Count]["sku"]);
	if(empty($ItemEvType))
        {
            $ItemEvType = $objItem->checkItemAliasSku($arrySaleItem[$Count]["sku"]);
	}
        if((!empty($ItemEvType) && ($ItemEvType[0]["evaluationType"] == 'Serialized' || $ItemEvType[0]["evaluationType"] == 'Serialized Average'))){
        
?>
        <a  class="fancybox slnoclass fancybox.iframe addSerialItem" href="../finance/addSerial.php?id=<?= $Line ?>" id="addItem<?= $Line ?>" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
        <?php }else{?>
<a  class="fancybox slnoclass fancybox.iframe addSerialItem" href="../finance/addSerial.php?id=<?= $Line ?>" id="addItem<?= $Line ?>" style="display:none"><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
<?php }


if(empty($arrySaleItem[$Count]["evaluationType"])) $arrySaleItem[$Count]["evaluationType"]='';
?>
<input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?=$arrySaleItem[$Count]["SerialNumbers"]?>"  />
<input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arrySaleItem[$Count]["evaluationType"]?>"  />
<!--End-->

</td>
       <td>
<!--by chetan 9feb--->
<?php if($disable){?>
            <input  <?=$disable?>   type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="5" maxlength="15" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/>
     <?php }else{?>        

 <input   type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="5" maxlength="15" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/>
<? }//End//?>



<input type="hidden" align="right" name="CustDiscount<?=$Line?>" id="CustDiscount<?=$Line?>" readonly class="disabled"  value="<?=$arrySaleItem[$Count]['CustDiscount']?>" size="5" style="text-align:right;"/>
<!---------Amit Singh-------->
       <input type="hidden" name="priceOrig<?=$Line?>" id="priceOrig<?=$Line?>" class="textbox" onkeypress="return isDecimalKey(event);"
              value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/>
</td>
       <td align="center"><input type="checkbox" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" <?php if($arrySaleItem[$Count]["DropshipCheck"] == '1'){echo "checked";}?> onclick="return dropshipcost(<?=$Line?>);"></td>



       <!--By chetan 18Jan--->
       <td>
          <input type="text" <? if($arrySaleItem[$Count]["DropshipCheck"] == 1){?>style="display:none;"<?php }?> name="avgCost<?=$Line?>" id="avgCost<?=$Line?>" value="<?=$arrySaleItem[$Count]["avgCost"]?>" class="disabled textbox avgCost" maxlength="6" size="3" readonly>
           <input  <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1 || $disable){?>style="display:none;"<?php }?> type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>"  class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["DropshipCost"])?>"></td>
<!--By chetan 18Jan--->
       <td><input <?php if(empty($disable)){?> class="textbox" <?php }else{ echo $disable; }?> type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" size="3" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>" style="color:red;"/></td>
<!--End--->
      

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
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arrySaleItem[$Count]['amount'])?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="13" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
		 
       		 <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
        	 <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />



		<?	
		$subtotal = number_format($subtotal,2,".","");
		$taxAmnt = $arrySale[0]['taxAmnt'];
		$Freight = $arrySale[0]['Freight']; 
		$TDiscount = $arrySale[0]['TDiscount']; 
		$TotalAmount = $arrySale[0]['TotalAmount'];
if($arrySale[0]['CustDisAmt']!='') $displayBlock ="style=display:block;"; else $displayBlock ="style=display:none;";
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/><br><br>
 

<input type="hidden" align="right" name="MDType" id="MDType" readonly class="disabled"  value="<?=$arrySale[0]['MDType']?>" /> 


<input type="hidden" align="right" name="MDAmount" id="MDAmount" readonly class="disabled"  value="<?=$arrySale[0]['MDAmount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="MDiscount" id="MDiscount" readonly class="disabled"  value="<?=$arrySale[0]['MDiscount']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="CustDisType" id="CustDisType" class="disabled"  value="<?=$arrySale[0]['CustDisType']?>" />


<!--/div-->
		

		
		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>


Add'l Discount : <input type="text" align="right" name="TDiscount" id="TDiscount" class="textbox" value="<?=$TDiscount?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;color:red;"/>
		<br><br>
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


		 
                 
                 /*$(".slnoclass").fancybox({
			'width'         : 300
		 });*/
                 
                 

});
//-----------------------------------------Amit SIngh---------------------------------------->
function calcAttrPrice(id,sel){
    
    var PriceO=$('#priceOrig'+sel).val();
    if($('#priceOrig'+sel).val()=='')PriceO='0';
   
   
    //alert(PriceO);
    $('input[name="compulsoryattr[]"]').each(function(index,value) {
        var attrval=$('#attribute_input_'+this.value).val();

        if(attrval!=''){

            
            //var data = '&OptionId=' + attrval +'&Price=' + Price+'&Weight=' + Weight +'&action=checkAttribute';
            var data = 'price_id='+attrval+'&row='+sel;	
		
            if (data) {
                $.ajax({
                    type: "GET",
                    url: "../sales/ajax.php",
                    data: data,
                    dataType: 'JSON',
                    success: function (msg) {	

                       			
                            //console.log(msg);
                                       
                            if(msg.Price != ''){
                                
                                //console.log(Price);
                                //console.log(msg.Price);
                               // var Price=parseFloat(msg.Price) + parseFloat(Price);
                              PriceO=parseFloat(msg.Price) + parseFloat(PriceO);
                               
                                 $('#price'+sel).val(PriceO.toFixed(2));
                           }else{
$('#price'+sel).val(PriceO.toFixed(2));
                            
}
                        
                    }//end success
                });
            }
        }else{
            PriceO=parseFloat(PriceO);
                               
            $('#price'+sel).val(PriceO.toFixed(2));//console.log(PriceO);
        }
    });
   	 	
}
jQuery(document).ready(function(){
    $(".fancyboxDate").fancybox({
        'width':400,
        'height':250,
        'autoSize' : false,
        'afterClose':function(){
            
        }, 
    });	
});
jQuery(document).ready(function(){
    $(".addSerialItem").fancybox({
        'width':50%,
        'height':75%,
        'autoSize' : false,
        'afterClose':function(){
            
        }, 
    });	

 $(".controle").fancybox({
        'width':300,
        'height':800,
        'autoSize' : false,
        'afterClose':function(){
            
        }, 
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
