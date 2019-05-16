<!-- General details -->
<script>
function validateQuote(frm){

	

	if( ValidateForSimpleBlank(frm.subject, " Quote subject")
		&& ValidateForSelect(frm.quotestage, "Quote Stage")
		&& ValidateForSelect(frm.assignTo,"Assign To")
		&& ValidateForTextareaMand(frm.bill_street,"Billing Address",10,300)
		&& ValidateForTextareaMand(frm.ship_street,"Shipping Address",10,300)
		&& ValidateForSimpleBlank(frm.productName1, " Item Line")
		
		
		
		){
		
		
					
				
	
                  var Url = "isRecordExists.php?QuoteSubject="+escape(document.getElementById("subject").value)+"&editID="+document.getElementById("quoteid").value+"&Type=Quote";
					SendExistRequest(Url,"subject", "Quote Subject");

					return false;	
					
			}else{
					return false;	
			}	

		
}
function numValue(row){
if (/\D/g.test(row.value)){ row.value = row.value.replace(/\D/g,"");}
}
$(document).on('change', 'input[type="number"]', function (event) {
val=this.value ;
 val = parseFloat(val);
   val = Math.round(val*100)/100;
   val = val.toString();
   
   if (val.indexOf(".")<0) {
      val+=".00"
   } else {
      var dec=val.substring(val.indexOf(".")+1,val.length)
      if (dec.length>2)
         val=val.substring(0,val.indexOf("."))+"."+dec.substring(0,2)
      else if (dec.length==1)
         val=val+"0"
   }

});
</script>
																			
<script type="text/javascript" src="javascript/js/Inventory.js"></script>

<script>

  
function displayCoords(currObj,obj,mode,curr_row) 
{
	if(mode != 'discount_final' && mode != 'sh_tax_div_title')
	{
		var curr_productid = document.getElementById("hdnProductId"+curr_row).value;
		if(curr_productid == '')
		{
			alert("Please select a Line Product");
			return false;
		}

		var curr_quantity = document.getElementById("qty"+curr_row).value;
		if(curr_quantity == '')
		{
			alert("Please fill in the quantity");
			return false;
		}
	}

	//Set the Header value for Discount
	if(mode == 'discount')
	{
	
	//alert(curr_row);
		document.getElementById("discount_div_title"+curr_row).innerHTML = '<b>Set Discount for : '+document.getElementById("productTotal"+curr_row).innerHTML+'</b>';
		//alert(obj);
	
	}
	else if(mode == 'tax')
	{
	
	
		document.getElementById("tax_div_title"+curr_row).innerHTML = "<b>Set Tax for "+document.getElementById("totalAfterDiscount"+curr_row).innerHTML+'</b>';
	}
	else if(mode == 'discount_final')
	{
		document.getElementById("discount_div_title_final").innerHTML = '<b>Set Discount for '+document.getElementById("netTotal").innerHTML+'</b>';
	}
	else if(mode == 'sh_tax_div_title')
	{
		document.getElementById("sh_tax_div_title").innerHTML = '<b>Set S&H Tax for : '+document.getElementById("shipping_handling_charge").value+'</b>';
	}
	document.getElementById(obj).style.display = "block";

	fnvshobj(currObj,'tax_container');
	if(document.all)
	{
		var divleft = document.getElementById("tax_container").style.left;
		var divabsleft = divleft.substring(0,divleft.length-2);
		document.getElementById(obj).style.left = eval(divabsleft) - 120;

		var divtop = document.getElementById("tax_container").style.top;
		var divabstop =  divtop.substring(0,divtop.length-2);
		document.getElementById(obj).style.top = eval(divabstop) - 200;
	}else
	{
		document.getElementById(obj).style.left =  document.getElementById("tax_container").left;
		document.getElementById(obj).style.top = document.getElementById("tax_container").top;
	}
	

}
  
	function doNothing(){
	}
	
	function fnHidePopDiv(obj){
		document.getElementById(obj).style.display = 'none';
	}
</script>
<form name="form1" id="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validateQuote(this); return validateInventory('Products');" enctype="multipart/form-data">
	<table  border="0" class="borderall" cellpadding="0" cellspacing="0" width="900">
	
	<tbody>

								 
		<tr>
			<td colspan="2"  class="head" align="left" >	Quote Information	</td>
		 </tr>


			<tr >
																									 	
								
			<td  width="45%" align="right" class="blackbold" >Subject :	<span class="red">*</span> </td>
			<td  align="left" >
				<input name="subject" id="subject" class="inputbox" value="<?=$arryQuote[0]['subject']?>"   type="text">
			</td>
				</tr>																						 	
							
						<tr>				
							<td  align="right" class="blackbold" >
				Opportunity Name :			</td>
			<td  align="left" >
				<input name="opportunityName" id="opportunityName" readonly="readonly" class="inputbox"   value="" type="text">
                <input name="opportunityID" id="opportunityID" value="" type="hidden">&nbsp;&nbsp;<img src="images/select.gif" border="0" alt="Select" title="Select" language="javascript" onclick="return window.open(&quot;select_file.php?module=opportunity&amp;action=Popup&amp;popuptype=opportunity&amp;form=TasksEditView&amp;form_submit=false&amp;fromlink=&quot;,&quot;test&quot;,&quot;width=640,height=602,resizable=0,scrollbars=0&quot;);" style="cursor:hand;cursor:pointer" align="absmiddle">
				<input src="images/clear_field.gif" border="0" alt="Clear" title="Clear" language="javascript" onclick="this.form.opportunityID.value=''; this.form.opportunityName.value='';return false;" style="cursor:hand;cursor:pointer" align="absmiddle" type="image">
			</td>

			   </tr>
			<tr style="display:none;" >
			
				<td  align="right" class="blackbold" >Quote No :</td>
                                <td  align="left" ><input  class="inputbox" name="quote_no" id="quote_no" value="AUTO GEN ON SAVE"   type="text"></td>
																										 	
					</tr>		
						<tr>				
							<td  align="right" class="blackbold" >
				
				Quote Stage 	:	<span class="red">*</span> 	</td>
			<td  align="left" >
							   		<select name="quotestage" class="inputbox" >
			   						<option value="Created"> Created </option>
						             <option value="Delivered">Delivered</option>
									<option value="Reviewed">Reviewed</option>
									<option value="Accepted">Accepted</option>
									<option value="Rejected">Rejected</option>									
												   </select>
			</td>
			   </tr>
			<tr >
																									 	
							
										
							<td  align="right" class="blackbold" >
				Valid Till 	:		</td>
			<td  align="left" >
		<script type="text/javascript">
     $(function() {


	$('#validtill').datepicker(
		{
		
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>', 
		minDate: "-D", 
        changeMonth: true,
		changeYear: true
		}
	);
});
</script>													
				<input name="validtill" class="disabled" id="validtill"  size="11" readonly="readonly" maxlength="10" value="" type="date">
			
			</td>
</tr>
																										 	
							
					<tr style="display:none;">					
							<td  align="right" class="blackbold" >
				Contact Name 	:		</td>
			<td  align="left" >
									
                                    
                                    <input  name="contact_name" id="single_accountid" value="" class="inputbox" type="text"><input name="contact_id" value="" type="hidden">&nbsp;<img src="images/select.gif" alt="Select" title="Select" language="javascript" onclick="return window.open(&quot;index.php?module=Accounts&amp;action=Popup&amp;popuptype=specific_account_address&amp;form=TasksEditView&amp;form_submit=false&amp;fromlink=&quot;,&quot;test&quot;,&quot;width=640,height=602,resizable=0,scrollbars=0&quot;);" style="cursor:hand;cursor:pointer" align="absmiddle">
				<input src="images/clear_field.gif" alt="Clear" title="Clear" language="javascript" onclick="this.form.contact_id.value=''; this.form.contact_name.value='';return false;" style="cursor:hand;cursor:pointer" align="absmiddle" type="image">
							</td>

			   </tr>
               
			<tr >
																									 	
							
										
							<td  align="right" class="blackbold" >
				
				Carrier 	:		</td>
			<td  align="left" >
							   		<select name="carrier" class="inputbox" >
                                    <option value=""> --Select--</option>
			   										<option value="FedEx"> FedEx </option>
													
											        <option value="USPS">USPS</option>
													
												   </select>
			</td>
					</tr>																					 	
							
							<tr>			
							<td  align="right" class="blackbold" >Shipping </td>

							<td  align="left" ><input class="inputbox" name="shipping" id="shipping" value=""   type="text"></td>
						   </tr>
			<tr >
																									 	
							
										
							<td  align="right" class="blackbold" >
				Assign To 		: <span class="red">*</span> 	</td>
			<td  align="left" >
            
            
             <? if($HideSibmit!=1){?>
               <select name="assignTo" class="inputbox" id="assignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryLead[0]['assignTo']){echo "selected";}?>>
							<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['JobTitle']);?>)
							</option>
						<? } ?>
					</select>
					
					<? }else{ 
						$HideSibmit = 1;
					?>
					<div class="redmsg">No employee exist.</div>
					<? } ?>
									
			</td>
            </tr>
																										 	
							</tr>
					<tr style="display:none;">					
							<td  align="right" class="blackbold" >
				Organization Name 	:		</td>
			<td  align="left" >
				<input  name="account_name" id="single_accountid" value="" class="inputbox" type="text"><input name="account_id" value="" type="hidden">&nbsp;<img src="images/select.gif" alt="Select" title="Select" language="javascript" onclick="return window.open(&quot;index.php?module=Accounts&amp;action=Popup&amp;popuptype=specific_account_address&amp;form=TasksEditView&amp;form_submit=false&amp;fromlink=&quot;,&quot;test&quot;,&quot;width=640,height=602,resizable=0,scrollbars=0&quot;);" style="cursor:hand;cursor:pointer" align="absmiddle">
				<input src="images/clear_field.gif" alt="Clear" title="Clear" language="javascript" onclick="this.form.account_id.value=''; this.form.account_name.value='';return false;" style="cursor:hand;cursor:pointer" align="absmiddle" type="image">
			</td>

			   </tr>
               
		   <tr> <td colspan="2" class="head" align="left" >Bill Address Information </td></tr>

			<tr ><td  align="right" class="blackbold" >
					
				Billing Address 	:	<span class="red">*</span> 	</td>
			<td  align="left" >
				<textarea value="" name="bill_street" id="bill_street" class="inputbox"  rows="2"></textarea>
			</td>
          <tr style="display:none;"><td  align="right" class="blackbold" >Billing PO Box :</td>
							<td  align="left" ><input class="inputbox" name="bill_pobox" id="bill_pobox" value=""   type="text"></td>
								</tr>	
                      <tr >
										
							<td  align="right" class="blackbold" >Billing City </td>

							<td  align="left" ><input class="inputbox" name="bill_city" id="bill_city" value=""   type="text"></td>
																													 	
							</tr>	             
			         <tr >
						<td  align="right" class="blackbold" >Billing State :</td>

							<td  align="left" ><input class="inputbox" name="bill_state" id="bill_state" value=""   type="text"></td>
																													 	
							</tr>
                            <tr >			
							<td  align="right" class="blackbold" >Billing Postal Code :</td>

							<td  align="left" ><input class="inputbox" name="bill_code" id="bill_code" value=""   type="text"></td>
																													 	
							</tr>	
                            <tr >
																									 	
							
										
							<td  align="right" class="blackbold" >Billing Country :</td>

							<td  align="left" ><input class="inputbox" name="bill_country" id="bill_country" value=""   type="text"></td>
																													 	
							</tr>
																										 	
						   <tr>
									   									     <td colspan="2" class="head" align="left" >
										                                                                        	
	                                                                          	                                                                
                	                                                   <span>Ship Address Information</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	                                               
                                	                                        <input name="cpy" onclick="return copyAddressRight(form1)" type="radio"><b>Copy Billing address</b>
                                        	                        </td>    										
									      </tr>	
						<tr>				
							<td  align="right" class="blackbold" >
					
				Shipping Address 		:	<span class="red">*</span> </td>
			<td  align="left" >
				<textarea value="" name="ship_street" class="inputbox"   rows="2"></textarea>
			</td>
			   </tr>
																								 	
							
							<tr style="display:none;">			
							<td  align="right" class="blackbold" >Shipping PO Box :</td>

							<td  align="left" ><input class="inputbox" name="ship_pobox" id="ship_pobox" value=""   type="text"></td>
						   </tr>
			
							<tr>			
							<td  align="right" class="blackbold" >Shipping City :</td>

							<td  align="left" ><input class="inputbox" name="ship_city" id="ship_city" value=""   type="text"></td>
						   </tr>
                           
             		
							<tr>			
							<td  align="right" class="blackbold" >Shipping State : </td>

							<td  align="left" ><input class="inputbox" name="ship_state" id="ship_state" value=""   type="text"></td>
						   </tr>
                           
			
								<tr>		
							<td  align="right" class="blackbold" >Shipping Postal Code :</td>

							<td  align="left" ><input class="inputbox" name="ship_code" id="ship_code" value=""   type="text"></td>
						   </tr>
			
							<tr>			
							<td  align="right" class="blackbold" >Shipping Country :</td>

							<td  align="left" ><input class="inputbox" name="ship_country" id="ship_country" value=""   type="text"></td>
						   </tr>
									   									      <tr>
																				  <td colspan="2" class="head" align="left" >
											<b>Terms &amp; Conditions</b>
																				</td>
									      </tr>


								   <!-- Here we should include the uitype handlings-->
										

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
			<tr >
																									 	
							
										
							<!-- In Add Comment are we should not display anything -->
						<td  align="right" class="blackbold" >
					
				Terms &amp; Conditions 		:	</td>
			<td  align="left">
				<textarea   onfocus="this.className='On'" class="inputbox"  style="width:700px;" name="terms_conditions" onblur="this.className=''" cols="90" rows="8"> - Unless otherwise agreed in writing by the supplier all invoices are payable within thirty (30) days of the date of invoice, in the currency of the invoice, drawn on a bank based in India or by such other method as is agreed in advance by the Supplier.

 - All prices are not inclusive of VAT which shall be payable in addition by the Customer at the applicable rate.</textarea>
							</td>
			   </tr>
									   									      <tr>
																				  <td colspan="2" class="head" align="left" >
											Description Information
																				</td>
									      </tr>


								   <!-- Here we should include the uitype handlings-->
										

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
			<tr >
																									 	
							
										
							<!-- In Add Comment are we should not display anything -->
						<td  align="right" class="blackbold" >
					
				Description 	:		</td>
			<td align="left">
				<textarea  onfocus="this.className='On'" class="inputbox"  style="width:500px;" name="description" onblur="this.className=''" ></textarea>
							</td>
			   </tr>
									   
								   <!-- This if is added to restrict display in more tab-->
								   								   	<!-- Added to display the product details -->
									<!-- This if is added when we want to populate product details from the related entity  for ex. populate product details in new SO page when select Quote -->






<!-- Added this file to display and hanld the Product Details in Inventory module  -->
 
  <tr>
	<td align="left" colspan="4">



<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" id="proTab" class="crmTable">
   <tbody>
   <tr>
   		<td class="head" colspan="3">
			<b>Item Details</b>
	</td>
	
	<td align="center" colspan="2" class="head">
		
	</td>
	
	<td align="center" colspan="2" class="head">
		
	</td>
   </tr>


   <!-- Header for the Product Details -->
   <tr valign="top">
	<td width="5%" valign="top" align="right" class="lvtCol"><b>Tools</b></td>
	<td width="40%" class="lvtCol"><font color="red">*</font><b>Item Name</b></td>
			<td width="10%" class="lvtCol"><b>Qty In Stock</b></td>
		<td width="10%" class="lvtCol"><b>Qty</b></td>
	<td width="10%" align="right" class="lvtCol"><b>List Price</b></td>
	<td width="12%" nowrap="" align="right" class="lvtCol"><b>Total</b></td>
	<td width="13%" valign="top" align="right" class="lvtCol"><b>Net Price</b></td>
   </tr>






<!-- Following code is added for form the first row. Based on these we should form additional rows using script -->

   <!-- Product Details First row - Starts -->
   <tr valign="top" id="row1">

	<!-- column 1 - delete link - starts -->
	<td class="crmTableRow small lineOnTop">&nbsp;
		<input type="hidden" value="0" name="deleted1" id="deleted1">
	</td>
	<!-- column 1 - delete link - ends -->

	<!-- column 2 - Product Name - starts -->
	<td class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="1" border="0">
		   <tbody><tr>
			<td class="small">
				<input type="text" value="" readonly="readonly" style="width:70%" class="small txtProdName" name="productName1" id="productName1">
				<input type="hidden" value="" name="hdnProductId1" id="hdnProductId1" >
				<input type="hidden" value="Products" name="lineItemType1" id="lineItemType1">
				&nbsp;<img align="absmiddle" onclick="productPickList(this,'Quotes',1)" style="cursor: pointer;" src="images/products.gif" title="Products" id="searchIcon1">
			</td>
		</tr>
		<tr>
			<td class="small">
				<input type="hidden" name="subproduct_ids1" id="subproduct_ids1" value="">
				<span style="color:#C0C0C0;font-style:italic;" name="subprod_names1" id="subprod_names1"> </span>
			</td>
		   </tr>
		   <tr valign="bottom">
			<td id="setComment" class="small">
				<textarea style="width:70%;height:40px" class="small" name="comment1" id="comment1"></textarea>
				<img style="cursor:pointer;"  onclick="<script>$('#comment1').value='';</script>" src="
                images/clear_field.gif">
			</td>
		   </tr>
		</tbody></table>
	</td>
	<!-- column 2 - Product Name - ends -->

	<!-- column 3 - Quantity in Stock - starts -->
			<td class="crmTableRow small lineOnTop"><span id="qtyInStock1"></span></td>
		<!-- column 3 - Quantity in Stock - ends -->


	<!-- column 4 - Quantity - starts -->
	<td class="crmTableRow small lineOnTop">
		<input type="text" value="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'');" onblur="settotalnoofrows();calcTotal(); loadTaxes_Ajax(1); setDiscount(this,'1'); calcTotal();"  style="width:50px" class="small " name="qty1" id="qty1"><br><span id="stock_alert1"></span>
	</td>
	<!-- column 4 - Quantity - ends -->


	<!-- column 5 - List Price with Discount, Total After Discount and Tax as table - starts -->
	<td align="right" class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="0">
		   <tbody><tr>
			<td align="right">
				<input type="text" onblur="calcTotal();setDiscount(this,'1'); callTaxCalc(1);calcTotal();" style="width:70px" readonly="readonly" class="small " value="" name="listPrice1" id="listPrice1">
			</td>
		   </tr>
		   <tr>
			<td nowrap="" align="right" style="padding:5px;">
				(-)&nbsp;<b><a onclick="displayCoords(this,'discount_div1','discount','1')" href="javascript:doNothing();">Discount</a> : </b>
				<div id="discount_div1" class="discountUI">
					<input type="hidden" value="" name="discount_type1" id="discount_type1">
					<table width="100%" cellspacing="0" cellpadding="5" border="0" class="small">
					   <tbody><tr>
						<td nowrap="" align="left" id="discount_div_title1"></td>
						<td align="right"><img border="0" style="cursor:pointer;" onclick="fnHidePopDiv('discount_div1')" src="images/close.gif"></td>
					   </tr>
					   <tr>
						<td align="left" class="lineOnTop"><input type="radio" onclick="setDiscount(this,1); callTaxCalc(1);calcTotal();" checked="" name="discount1">&nbsp; Zero Discount</td>
						<td class="lineOnTop">&nbsp;</td>
					   </tr>
					   <tr>
						<td align="left"><input type="radio" onclick="setDiscount(this,1); callTaxCalc(1);calcTotal();" value="50" name="discount1">&nbsp; % of Price</td>
						<td align="right"><input type="text" onblur="setDiscount(this,1); callTaxCalc(1);calcTotal();" style="visibility:hidden" value="10" name="discount_percentage1" id="discount_percentage1" size="5" class="small">&nbsp;%</td>
					   </tr>
					   <tr>
						<td nowrap="" align="left"><input type="radio" onclick="setDiscount(this,1); callTaxCalc(1);calcTotal();" name="discount1">&nbsp;Direct Price Reduction</td>
						<td align="right"><input type="text" onblur="setDiscount(this,1); callTaxCalc(1);calcTotal();" style="visibility:hidden" value="5" size="5" name="discount_amount1" id="discount_amount1"></td>
					   </tr>
					</tbody></table>
				</div>
                
			</td>
		   </tr>
		   <tr>
			<td nowrap="" align="right" style="padding:5px;">
				<b>Total After Discount :</b>
			</td>
		   </tr>
		   <tr class="TaxShow" id="individual_tax_row1">
			<td nowrap="" align="right" style="padding:5px;">&nbsp;
				
			</td>
		   </tr>
		</tbody></table> 
	</td>
	<!-- column 5 - List Price with Discount, Total After Discount and Tax as table - ends -->


	<!-- column 6 - Product Total - starts -->
	<td align="right" class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="5">
		   <tbody><tr>
			<td align="right" id="productTotal1">&nbsp;</td>
		   </tr>
		   <tr>
			<td align="right" id="discountTotal1">0.00</td>
		   </tr>
		   <tr>
			<td align="right" id="totalAfterDiscount1">&nbsp;</td>
		   </tr>
		   <tr>
			<td align="right" id="taxTotal1">&nbsp;</td>
		   </tr>
		</tbody></table>
	</td>
	<!-- column 6 - Product Total - ends -->


	<!-- column 7 - Net Price - starts -->
	<td valign="bottom" align="right" class="crmTableRow small lineOnTop"><span id="netPrice1"><b>&nbsp;</b></span></td>
	<!-- column 7 - Net Price - ends -->

   </tr>
   <!-- Product Details First row - Ends -->
</tbody></table>
<!-- Upto this has been added for form the first row. Based on these above we should form additional rows using script -->


<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="crmTable">
   <!-- Add Product Button -->
   <tbody><tr>
	<td colspan="3">
			<input type="button" onclick="fnAddProductRow('Quotes','themes/softed/images/');" value="Add Product" class="crmbutton small create" name="Button">
			&nbsp;&nbsp;
			<!--<input type="button" onclick="fnAddServiceRow('Quotes','themes/softed/images/');" value="Add Service" class="crmbutton small create" name="Button">-->
	</td>
   </tr>




   <!-- Product Details Final Total Discount, Tax and Shipping&Hanling  - Starts -->
   <tr valign="top">
	<td width="88%" align="right" class="crmTableRow small lineOnTop" colspan="2"><b>Net Total</b></td>
	<td width="12%" align="right" class="crmTableRow small lineOnTop" id="netTotal">0.00</td>
   </tr>

   <tr valign="top">
	<td width="60%" style="border-right:1px #dadada;" class="crmTableRow small lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow small lineOnTop">
		(-)&nbsp;<b><a onclick="displayCoords(this,'discount_div_final','discount_final','1')" href="javascript:doNothing();">Discount</a>
		<!-- Popup Discount DIV -->
		<div id="discount_div_final" class="discountUI">
			<input type="hidden" value="" name="discount_type_final" id="discount_type_final">
			<table width="100%" cellspacing="0" cellpadding="5" border="0" class="small">
			   <tbody><tr>
				<td nowrap="" align="left" id="discount_div_title_final"></td>
				<td align="right"><img border="0" style="cursor:pointer;" onclick="fnHidePopDiv('discount_div_final')" src="images/close.gif"></td>
			   </tr>
			   <tr>
				<td align="left" class="lineOnTop"><input type="radio" onclick="setDiscount(this,'_final'); calcGroupTax();calcTotal();" checked="" name="discount_final">&nbsp; Zero Discount</td>
				<td class="lineOnTop">&nbsp;</td>
			   </tr>
			   <tr>
				<td align="left"><input type="radio" onclick="setDiscount(this,'_final'); calcGroupTax();calcTotal();" name="discount_final">&nbsp; % of Price</td>
				<td align="right"><input type="text" onblur="setDiscount(this,'_final'); calcGroupTax();calcTotal();" style="visibility:hidden" value="0" name="discount_percentage_final" id="discount_percentage_final" size="5" class="small">&nbsp;%</td>
			   </tr>
			   <tr>
				<td nowrap="" align="left"><input type="radio" onclick="setDiscount(this,'_final'); calcGroupTax();calcTotal();" name="discount_final">&nbsp;Direct Price Reduction</td>
				<td align="right"><input type="text" onblur="setDiscount(this,'_final'); calcGroupTax();calcTotal();" style="visibility:hidden" value="0" size="5" name="discount_amount_final" id="discount_amount_final"></td>
			   </tr>
			</tbody></table>
		</div>
		<!-- End Div -->
	</b></td>
	<td align="right" class="crmTableRow small lineOnTop" id="discountTotal_final">0.00</td>
   </tr>


   <!-- Group Tax - starts -->
   <tr valign="top" class="TaxHide" id="group_tax_row">
	<td style="border-right:1px #dadada;" class="crmTableRow small lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow small lineOnTop">
		(+)&nbsp;<b><a onclick="displayCoords(this,'group_tax_div','group_tax_div_title',''); calcGroupTax();" href="javascript:doNothing();">Tax</a></b>
				<!-- Pop Div For Group TAX -->
				<div id="group_tax_div" class="discountUI">
					<table width="100%" cellspacing="0" cellpadding="5" border="0" class="small">
					   <tbody><tr>
						<td nowrap="" align="left" colspan="2" id="group_tax_div_title"></td>
						<td align="right"><img border="0" style="cursor:pointer;" onclick="fnHidePopDiv('group_tax_div')" src="images/close.gif"></td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcTotal()" value="0.00" id="group_tax_percentage1" name="tax1_group_percentage" size="5" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">VAT</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="0.00" style="cursor:pointer;" id="group_tax_amount1" name="tax1_group_amount" size="6" class="small">
						</td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcTotal()" value="0.00" id="group_tax_percentage2" name="tax2_group_percentage" size="5" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">Sales</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="0.00" style="cursor:pointer;" id="group_tax_amount2" name="tax2_group_amount" size="6" class="small">
						</td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcTotal()" value="0.00" id="group_tax_percentage3" name="tax3_group_percentage" size="5" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">Service</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="0.00" style="cursor:pointer;" id="group_tax_amount3" name="tax3_group_amount" size="6" class="small">
						</td>
					   </tr>

										<input type="hidden" value="3" id="group_tax_count">

					</table>

				</div>
				<!-- End Popup Div Group Tax -->

	</td>
	<td align="right" class="crmTableRow small lineOnTop" id="tax_final">0.00</td>
   </tr>
   <!-- Group Tax - ends -->


   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		(+)&nbsp;<b>Shipping &amp; Handling Charges </b>
	</td>
	<td align="right" class="crmTableRow small">
		<input type="text" align="right" onblur="calcSHTax();" value="0.00" style="width:40px" class="small" name="shipping_handling_charge" id="shipping_handling_charge">
	</td>
   </tr>

   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		(+)&nbsp;<b><a onclick="displayCoords(this,'shipping_handling_div','sh_tax_div_title',''); calcSHTax();" href="javascript:doNothing();">Taxes For Shipping and Handling </a></b>

				<!-- Pop Div For Shipping and Handlin TAX -->
				<div id="shipping_handling_div" class="discountUI">
					<table width="100%" cellspacing="0" cellpadding="5" border="0" class="small">
					  
                       <tr>
						<td nowrap="" align="left" colspan="2" id="sh_tax_div_title"></td>
						<td align="right"><img border="0" style="cursor:pointer;" onclick="fnHidePopDiv('shipping_handling_div')" src="images/close.gif"></td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcSHTax()" value="4.500" id="sh_tax_percentage1" name="shtax1_sh_percent" size="3" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">VAT</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="0.00" style="cursor:pointer;" id="sh_tax_amount1" name="shtax1_sh_amount" size="4" class="small">
						</td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcSHTax()" value="10.000" id="sh_tax_percentage2" name="shtax2_sh_percent" size="3" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">Sales</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="0.00" style="cursor:pointer;" id="sh_tax_amount2" name="shtax2_sh_amount" size="4" class="small">
						</td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcSHTax()" value="12.500" id="sh_tax_percentage3" name="shtax3_sh_percent" size="3" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">Service</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="0.00" style="cursor:pointer;" id="sh_tax_amount3" name="shtax3_sh_amount" size="4" class="small">
						</td>
					   </tr>

										<input type="hidden" value="3" id="sh_tax_count">

					</table>
				</div>
				<!-- End Popup Div for Shipping and Handling TAX -->

	</td>
	<td align="right" class="crmTableRow small" id="shipping_handling_tax">0.00</td>
   </tr>
   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		Adjustment
		<select onchange="calcTotal();" class="small" name="adjustmentType" id="adjustmentType">
			<option value="+">Add</option>
			<option value="-">Deduct</option>
		</select>
	</td>
	<td align="right" class="crmTableRow small">
		<input type="text" align="right" onblur="calcTotal();" value="0.00" style="width:40px" class="small" name="adjustment" id="adjustment">
	</td>
   </tr>
   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow big lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow big lineOnTop"><b>Grand Total</b></td>
	<td align="right" class="crmTableRow big lineOnTop" name="grandTotal" id="grandTotal">&nbsp;</td>
   </tr>
</tbody></table>
		<input type="hidden" value="" id="totalProductCount" name="totalProductCount">
		<input type="hidden" value="" id="subtotal" name="subtotal">
		<input type="hidden" value="" id="total" name="total">




	</td>
   </tr>
   
</table>
<!-- Upto this has been added for form the first row. Based on these above we should form additional rows using script -->



	</td>
   </tr>



									   
								   									   <tr>
										<td colspan="4" style="padding:5px">
											<div align="center">
										<input title="Save [Alt+S]" accesskey="S" class="button" onclick="this.form.action.value='Save'; return validateInventory('Quotes')" name="button" value="  Save  " style="width:70px" type="submit">
												<input title="Cancel [Alt+X]" accesskey="X" class="button" onclick="window.history.back()" name="button" value="  Cancel  " style="width:70px" type="button">
										<input name="quoteid" value="" id="quoteid" type="hidden">
                                        <input name="created_by" value="<?=$_SESSION['AdminType']?>" id="created_by" type="hidden">
                                        <input name="created_id" value="<?=$_SESSION['AdminID']?>" id="created_id" type="hidden">
                                                                                <input name="duplicate_from" value="" type="hidden">
											</div>
										</td>
									   </tr>
									</tbody></table>
								<!-- General details - end -->
			</form>			
            
            
         
<? echo '<script>SetInnerWidth();</script>'; ?>   
            


		
