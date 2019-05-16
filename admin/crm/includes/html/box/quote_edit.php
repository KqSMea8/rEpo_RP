<!-- General details -->
<script language="JavaScript1.2" type="text/javascript">
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

$(document).on('change', 'input[type="number"]', function (event) {
    this.value = this.value.replace(/[^0-9\.]+/g, '');
    if (this.value < 1) this.value = 0.00;
});

 calcTotal();
</script>
<form name="form1" id="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validateQuote(this);  validateInventory('Products');" enctype="multipart/form-data">
<table  border="0" class="borderall" cellpadding="0" cellspacing="0" width="100%">
									   <tbody>

<tr>
<td colspan="2" class="head" align="left" >	Quote Information	</td>
</tr>

<tr >
																									 	
								
				<td  align="right" class="blackbold" >Subject :	<span class="red">*</span> </td>
			<td  align="left" width="45%">
				<input name="subject" id="subject" class="inputbox" value="<?=$arryQuote[0]['subject']?>"   type="text">
			</td>
				</tr>																						 	
							
						<tr>				
							<td  align="right" class="blackbold" >
				Opportunity Name :			</td>
			<td  align="left" >
				<input name="opportunityName" id="opportunityName" readonly="readonly" class="inputbox"   value="<?=$arryQuote[0]['opportunityName']?>" type="text">
                <input name="opportunityID" id="opportunityID" value="<?=$arryQuote[0]['OpportunityID']?>" type="hidden">&nbsp;&nbsp;<img src="images/select.gif" border="0" alt="Select" title="Select" language="javascript" onclick="return window.open(&quot;select_file.php?module=opportunity&amp;action=Popup&amp;popuptype=opportunity&amp;form=TasksEditView&amp;form_submit=false&amp;fromlink=&quot;,&quot;test&quot;,&quot;width=640,height=602,resizable=0,scrollbars=0&quot;);" style="cursor:hand;cursor:pointer" align="absmiddle">
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
                                    <option value="" > --Select-- </option>
			   						<option value="Created" <? if($arryQuote[0]['quotestage']=='Created'){ echo "selected"; }?>> Created </option>
						             <option value="Delivered" <? if($arryQuote[0]['quotestage']=='Delivered'){ echo "selected"; }?>>Delivered</option>
									<option value="Reviewed" <? if($arryQuote[0]['quotestage']=='Reviewed'){ echo "selected"; }?>>Reviewed</option>
									<option value="Accepted" <? if($arryQuote[0]['quotestage']=='Accepted'){ echo "selected"; }?>>Accepted</option>
									<option value="Rejected" <? if($arryQuote[0]['quotestage']=='Rejected'){ echo "selected"; }?>>Rejected</option>									
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
				<input name="validtill" class="disabled" id="validtill"  size="11" readonly="readonly" maxlength="10" value="<?=$arryQuote[0]['validtill']?>" type="date">
			
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
			   										<option value="FedEx" <? if($arryQuote[0]['carrier']=='FedEx'){ echo "selected"; }?>> FedEx </option>
													
											        <option value="USPS" <? if($arryQuote[0]['carrier']=='USPS'){ echo "selected"; }?>>USPS</option>
													
												   </select>
			</td>
					</tr>																					 	
							
							<tr>			
							<td  align="right" class="blackbold" >Shipping </td>

							<td  align="left" ><input class="inputbox" name="shipping" id="shipping" value="<?=$arryQuote[0]['shipping']?>"   type="text"></td>
						   </tr>
			<tr >
																									 	
							
										
							<td  align="right" class="blackbold" >
				Assign To 		: <span class="red">*</span> 	</td>
			<td  align="left" >
            
            
             <? if($HideSibmit!=1){?>
               <select name="assignTo" class="inputbox" id="assignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryQuote[0]['assignTo']){echo "selected";}?>>
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
				<textarea value="" name="bill_street" id="bill_street" class="inputbox"  rows="2"><?=$arryQuoteAdd[0]['bill_street']?></textarea>
			</td>
          <tr style="display:none;"><td  align="right" class="blackbold" >Billing PO Box :</td>
							<td  align="left" ><input class="inputbox" name="bill_pobox" id="bill_pobox" value="<?=$arryQuoteAdd[0]['bill_pobox']?>"   type="text"></td>
								</tr>	
                      <tr >
										
							<td  align="right" class="blackbold" >Billing City </td>

							<td  align="left" ><input class="inputbox" name="bill_city" id="bill_city" value="<?=$arryQuoteAdd[0]['bill_city']?>"   type="text"></td>
																													 	
							</tr>	             
			         <tr >
						<td  align="right" class="blackbold" >Billing State :</td>

							<td  align="left" ><input class="inputbox" name="bill_state" id="bill_state" value="<?=$arryQuoteAdd[0]['bill_state']?>"   type="text"></td>
																													 	
							</tr>
                            <tr >			
							<td  align="right" class="blackbold" >Billing Postal Code :</td>

							<td  align="left" ><input class="inputbox" name="bill_code" id="bill_code" value="<?=$arryQuoteAdd[0]['bill_code']?>"   type="text"></td>
																													 	
							</tr>	
                            <tr >
																									 	
							
										
							<td  align="right" class="blackbold" >Billing Country :</td>

							<td  align="left" ><input class="inputbox" name="bill_country" id="bill_country" value="<?=$arryQuoteAdd[0]['bill_country']?>"   type="text"></td>
																													 	
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
				<textarea value="" name="ship_street" class="inputbox"   rows="2"><?=stripslashes($arryQuoteAdd[0]['ship_street'])?></textarea>
			</td>
			   </tr>
																								 	
							
							<tr style="display:none;">			
							<td  align="right" class="blackbold" >Shipping PO Box :</td>

							<td  align="left" ><input class="inputbox" name="ship_pobox" id="ship_pobox" value="<?=stripslashes($arryQuoteAdd[0]['ship_pobox'])?>"   type="text"></td>
						   </tr>
			
							<tr>			
							<td  align="right" class="blackbold" >Shipping City :</td>

							<td  align="left" ><input class="inputbox" name="ship_city" id="ship_city" value="<?=stripslashes($arryQuoteAdd[0]['ship_city'])?>"   type="text"></td>
						   </tr>
                           
             		
							<tr>			
							<td  align="right" class="blackbold" >Shipping State : </td>

							<td  align="left" ><input class="inputbox" name="ship_state" id="ship_state" value="<?=stripslashes($arryQuoteAdd[0]['ship_state'])?>"   type="text"></td>
						   </tr>
                           
			
								<tr>		
							<td  align="right" class="blackbold" >Shipping Postal Code :</td>

							<td  align="left" ><input class="inputbox" name="ship_code" id="ship_code" value="<?=stripslashes($arryQuoteAdd[0]['ship_code'])?>"   type="text"></td>
						   </tr>
			
							<tr>			
							<td  align="right" class="blackbold" >Shipping Country :</td>

							<td  align="left" ><input class="inputbox" name="ship_country" id="ship_country" value="<?=stripslashes($arryQuoteAdd[0]['ship_country'])?>"   type="text"></td>
						   </tr>
									   									      <tr>
																				  <td colspan="2" class="head" align="left" >
											<b>Terms &amp; Conditions</b>
																				</td>
									      </tr>

						<td  align="right" class="blackbold" >
					
				Terms &amp; Conditions 		:	</td>
			<td  align="left">
				<textarea   onfocus="this.className='On'" class="inputbox"  style="width:700px;" name="terms_conditions" onblur="this.className=''" cols="90" rows="8"> <?=stripslashes($arryQuote[0]['terms_conditions'])?></textarea>
							</td>
			   </tr>
									   									      <tr>
																				  <td colspan="2" class="head" align="left" >
											Description Information
																				</td>
									      </tr>

						<td  align="right" class="blackbold" >
					
				Description 	:		</td>
			<td align="left">
				<textarea  onfocus="this.className='On'" class="inputbox"  style="width:500px;" name="description" onblur="this.className=''" ><?=stripslashes($arryQuote[0]['description'])?></textarea>
							</td>
			   </tr>
								
																			
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




<!-- Added this file to display and hanld the Product Details in Inventory module  -->
 
  <tr>
	<td align="left" colspan="4">



<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" id="proTab" class="crmTable">
   <tbody><tr>
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
   
   <?php 
   
   for($i=0;$i<sizeof($arryQuoteProduct); $i++){
   
   $j++;
   $discount=0;
   ?>
   <tr valign="top" id="row1">

	<!-- column 1 - delete link - starts -->
	<td class="crmTableRow small lineOnTop">&nbsp;
		<input type="hidden" value="0" name="deleted<?=$j?>" id="deleted<?=$j?>">
	</td>
	<!-- column 1 - delete link - ends -->

	<!-- column 2 - Product Name - starts -->
	<td class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="1" border="0">
		   <tbody><tr>
			<td class="small">
				<input type="text" value="<?=$arryQuoteProduct[$i]['productName']?>" readonly="readonly" style="width:70%" class="small txtProdName" name="productName<?=$j?>" id="productName<?=$j?>">
				<input type="hidden" value="<?=$arryQuoteProduct[$i]['hdnProductId']?>" name="hdnProductId<?=$j?>" id="hdnProductId<?=$j?>" >
				<input type="hidden" value="Products" name="lineItemType<?=$j?>" id="lineItemType<?=$j?>">
				&nbsp;<img align="absmiddle" onclick="productPickList(this,'Quotes',<?=$j?>)" style="cursor: pointer;" src="images/products.gif" title="Products" id="searchIcon<?=$j?>">
			</td>
		</tr>
		<tr>
			<td class="small">
				<input type="hidden" name="subproduct_ids<?=$j?>" id="subproduct_ids<?=$j?>" value="">
				<span style="color:#C0C0C0;font-style:italic;" name="subprod_names<?=$j?>" id="subprod_names<?=$j?>"> </span>
			</td>
		   </tr>
		   <tr valign="bottom">
			<td id="setComment" class="small">
				<textarea style="width:70%;height:40px" class="small" name="comment<?=$j?>" id="comment<?=$j?>"></textarea>
				<img style="cursor:pointer;"  onclick="<script>$('#comment<?=$j?>').value='';</script>" src="
                images/clear_field.gif">
			</td>
		   </tr>
		</tbody></table>
	</td>
	<!-- column 2 - Product Name - ends -->

	<!-- column 3 - Quantity in Stock - starts -->
			<td class="crmTableRow small lineOnTop"><span id="qtyInStock<?=$j?>"><?=$arryQuoteProduct[$i]['qty_in_stock']?></span></td>
		<!-- column 3 - Quantity in Stock - ends -->


	<!-- column 4 - Quantity - starts -->
	<td class="crmTableRow small lineOnTop">
		<input type="text" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'');" value="<?=$arryQuoteProduct[$i]['qty']?>" onblur="settotalnoofrows();calcTotal(); loadTaxes_Ajax(<?=$j?>); setDiscount(this,'<?=$j?>'); calcTotal();" onfocus="this.className='detailedViewTextBoxOn'" style="width:50px" class="small " name="qty<?=$j?>" id="qty<?=$j?>"><br><span id="stock_alert<?=$j?>"></span>
	</td>
	<!-- column 4 - Quantity - ends -->


	<!-- column 5 - List Price with Discount, Total After Discount and Tax as table - starts -->
	<td align="right" class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="0">
		   <tbody><tr>
			<td align="right">
				<input type="text" onblur="calcTotal();setDiscount(this,'<?=$j?>'); callTaxCalc(<?=$j?>);" style="width:70px" readonly="readonly" class="small " value="<?=$arryQuoteProduct[$i]['SalePrice']?>" name="listPrice<?=$j?>" id="listPrice<?=$j?>">
               
               
			</td>
		   </tr>
		   <tr>
			<td nowrap="" align="right" style="padding:5px;">
				(-)&nbsp;<b>
                <? if($arryQuoteProduct[$i]['discount_type']=="percentage" && $arryQuoteProduct[$i]['discount']==50){
			 
			 $discounttype=$arryQuoteProduct[$i]['discount_type'];
			$discount_price= $arryQuoteProduct[$i]['discount_percentage'].'%';
			
			}else if($arryQuoteProduct[$i]['discount_type']=="amount" && $arryQuoteProduct[$i]['discount']=="on" ){
			
			 $discounttype=$arryQuoteProduct[$i]['discount_type'];
			$discount_price= $arryQuoteProduct[$i]['discount_amount'];
			
		
			
			}else{
			 $discounttype=$arryQuoteProduct[$i]['discount_type'];
			$discount_price= 0.00;
			 
			} ?>
                <a onclick="alert('Direct <?=$discounttype?> Discount = <?=$discount_price?>'); " href="javascript:;">Discount : </a> </b>
				
                
			</td>
		   </tr>
		   <tr>
			<td nowrap="" align="right" style="padding:5px;">
				<b>Total After Discount :</b>
			</td>
		   </tr>
		   <tr class="TaxShow" id="iiindividual_tax_row<?=$j?>">
			<td nowrap="" align="right" style="padding:5px;">&nbsp;
				
			</td>
		   </tr>
		</tbody></table> 
	</td>
	<!-- column 5 - List Price with Discount, Total After Discount and Tax as table - ends -->


	<!-- column 6 - Product Total - starts -->
     <? 
			 ?>
	<td align="right" class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="5">
		   <tbody><tr>
			<td align="right" id="productTotal<?=$j?>"><? $productTotal= $arryQuoteProduct[$i]['SalePrice']*$arryQuoteProduct[$i]['qty']; echo $productTotal;?></td>
		   </tr>
		   <tr>
           
          
			<td align="right" id="discountTotal<?=$j?>">
			<? if($arryQuoteProduct[$i]['discount_type']=="percentage" && $arryQuoteProduct[$i]['discount']==50){
			 
			echo $discount=($productTotal*$arryQuoteProduct[$i]['discount_percentage'])/100;
			 //echo 'ss:'.$$arryQuoteProduct[$i]['discount_percentage'];
			//echo "bhoodev1";
			}else if($arryQuoteProduct[$i]['discount_type']=="amount" && $arryQuoteProduct[$i]['discount']=="on" ){
			//echo "bhoodev";
			
			 //$discount=($productTotal-$arryQuoteProduct[$i]['discount_amount']);
			 echo $arryQuoteProduct[$i]['discount_amount'];
			
			}else{
			//echo "bhoodev0";
			//echo $discount=$arryQuoteProduct[$i]['SalePrice']*$arryQuoteProduct[$i]['qty']-0;
			 echo $discount='0.00';
			} ?></td>
		   </tr>
		   <tr>
			<td align="right" id="totalAfterDiscount<?=$j?>"><? $nettotal= $productTotal-$discount; echo $nettotal;?></td>
		   </tr>
           
		   <tr>
			<td align="right" id="taxTotal<?=$j?>">&nbsp;</td>
		   </tr>
		</tbody></table>
	</td>
	<!-- column 6 - Product Total - ends -->


	<!-- column 7 - Net Price - starts -->
	<td valign="bottom" align="right" class="crmTableRow small lineOnTop"><span id="netPrice<?=$j?>"><b><? echo $nettotal;?></b></span></td>
	<!-- column 7 - Net Price - ends -->

   </tr>
   
   <? }?>
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
	<td width="12%" align="right" class="crmTableRow small lineOnTop" id="netTotal"><?=$arryQuote[0]['subtotal']?></td>
   </tr>

   <tr valign="top">
	<td width="60%" style="border-right:1px #dadada;" class="crmTableRow small lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow small lineOnTop">
     <? if($arryQuoteProduct[0][' 	discount_type_final']=="percentage" && $arryQuoteProduct[0]['discount_final']==50){
			 
			 $discounttypefinal=$arryQuoteProduct[0]['discount_type_final'];
			$discount_pricefinal= $arryQuoteProduct[0]['discount_percentage_final'].'%';
			$checked="checked";
			
			}else if($arryQuoteProduct[$i]['discount_type_final']=="amount" && $arryQuoteProduct[0]['discount_final']=="on" ){
			
			 $discounttypefinal=$arryQuoteProduct[0]['discount_type_final'];
			$discount_pricefinal= $arryQuoteProduct[0]['discount_type_final'];
			$checked="checked";
			
		
			
			}else{
			 $discounttypefinal=$arryQuoteProduct[0]['discount_type_final'];
			$discount_pricefinal= 0.00;
			$checked="checked";
			 
			} ?>
    
    <a onclick="alert('Direct <?=$discounttypefinal?> Discount = <?=$discount_pricefinal?>'); " href="javascript:;">(-)Discount : </a> </b>
    <!-- Popup Discount DIV -->
		<div id="discount_div_final" class="discountUI">
			<input type="hidden" value="" name="discount_type_final" id="discount_type_final">
			<table width="100%" cellspacing="0" cellpadding="5" border="0" class="small">
			   <tbody><tr>
				<td nowrap="" align="left" id="discount_div_title_final"></td>
				<td align="right"><img border="0" style="cursor:pointer;" onclick="fnHidePopDiv('discount_div_final')" src="images/close.gif"></td>
			   </tr>
			   <tr>
				<td align="left" class="lineOnTop"><input type="radio" <?=$checked?> onclick="setDiscount(this,'_final'); calcGroupTax();calcTotal();" checked="" name="discount_final">&nbsp; Zero Discount</td>
				<td class="lineOnTop">&nbsp;</td>
			   </tr>
			   <tr>
				<td align="left"><input type="radio" <?=$checked?> onclick="setDiscount(this,'_final'); calcGroupTax();calcTotal();" name="discount_final">&nbsp; % of Price</td>
				<td align="right"><input type="text"  onblur="setDiscount(this,'_final'); calcGroupTax();calcTotal();" style="visibility:hidden" value="<?=$arryQuoteProduct[0]['discount_percentage_final']?>" name="discount_percentage_final" id="discount_percentage_final" size="5" class="small">&nbsp;%</td>
			   </tr>
			   <tr>
				<td nowrap="" align="left"><input type="radio" <?=$checked?> onclick="setDiscount(this,'_final'); calcGroupTax();calcTotal();" name="discount_final">&nbsp;Direct Price Reduction</td>
				<td align="right"><input type="text" onblur="setDiscount(this,'_final'); calcGroupTax();calcTotal();" style="visibility:hidden" value="<?=$arryQuoteProduct[0]['discount_amount_final']?>" size="5" name="discount_amount_final" id="discount_amount_final"></td>
			   </tr>
			</tbody></table>
		</div>
		<!-- End Div -->
	
		
	
	</td>
	<td align="right" class="crmTableRow small lineOnTop" id="discountTotal_final">0.00</td>
   </tr>


   <!-- Group Tax - starts -->
   <tr valign="top" class="TaxHide" id="group_tax_row">
	<td style="border-right:1px #dadada;" class="crmTableRow small lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow small lineOnTop">
		&nbsp;
				<!-- End Popup Div Group Tax -->

	</td>
	<td align="right" class="crmTableRow small lineOnTop" id="tax_final">&nbsp;</td>
   </tr>
   <!-- Group Tax - ends -->


   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		(+)&nbsp;<b>Shipping &amp; Handling Charges </b>
	</td>
	<td align="right" class="crmTableRow small">
		<input type="text" align="right" onblur="calcSHTax();" value="<? echo $arryQuote[0]['shipping_handling_charge']?>" style="width:40px" class="small" name="shipping_handling_charge" id="shipping_handling_charge">
	</td>
   </tr>

   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		(+)&nbsp; <a onclick="alert('Shipping &amp; Handling Charge = <? echo $arryQuote[0]['shipping_handling_charge']?>\nVAT : <? echo $arryQuote[0]['shtax1_sh_percent']?> % =  <? echo $arryQuote[0]['shtax1_sh_amount']?> \nSales : <? echo $arryQuote[0]['shtax2_sh_percent']?> % = <? echo $arryQuote[0]['shtax2_sh_amount']?> \nService : <? echo $arryQuote[0]['shtax3_sh_percent']?> % = <? echo $arryQuote[0]['shtax3_sh_amount']?> \n\n Total Tax Amount = <? echo $arryQuote[0]['shtax3_sh_amount'];?>')" href="javascript:;">Taxes For Shipping and Handling</a>
        
        <div id="shipping_handling_div" class="discountUI">
					<table width="100%" cellspacing="0" cellpadding="5" border="0" class="small">
					  
                       <tr>
						<td nowrap="" align="left" colspan="2" id="sh_tax_div_title"></td>
						<td align="right"><img border="0" style="cursor:pointer;" onclick="fnHidePopDiv('shipping_handling_div')" src="images/close.gif"></td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcSHTax()" value="<? echo $arryQuote[0]['shtax1_sh_percent']?>" id="sh_tax_percentage1" name="shtax1_sh_percent" size="3" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">VAT</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="<? echo $arryQuote[0]['shtax1_sh_amount']?>" style="cursor:pointer;" id="sh_tax_amount1" name="shtax1_sh_amount" size="4" class="small">
						</td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcSHTax()" value="<? echo $arryQuote[0]['shtax2_sh_percent']?>" id="sh_tax_percentage2" name="shtax2_sh_percent" size="3" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">Sales</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="<? echo $arryQuote[0]['shtax2_sh_amount']?>" style="cursor:pointer;" id="sh_tax_amount2" name="shtax2_sh_amount" size="4" class="small">
						</td>
					   </tr>

					
					   <tr>
						<td align="left" class="lineOnTop">
							<input type="text" onblur="calcSHTax()" value="<? echo $arryQuote[0]['shtax3_sh_percent']?>" id="sh_tax_percentage3" name="shtax3_sh_percent" size="3" class="small">&nbsp;%
						</td>
						<td align="center" class="lineOnTop">Service</td>
						<td align="right" class="lineOnTop">
							<input type="text" readonly="" value="<? echo $arryQuote[0]['shtax3_sh_amount']?>" style="cursor:pointer;" id="sh_tax_amount3" name="shtax3_sh_amount" size="4" class="small">
						</td>
					   </tr>

										<input type="hidden" value="3" id="sh_tax_count">

					</table>
				</div>

				

	</td>
	<td align="right" class="crmTableRow small" id="shipping_handling_tax"><? if($arryQuote[0]['shtax3_sh_amount']){ echo $arryQuote[0]['shtax3_sh_amount']; }else{ echo"0.00";}?></td>
   </tr>
   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		Adjustment
		<select onchange="calcTotal();" class="small" name="adjustmentType" id="adjustmentType">
			<option value="+"  <? if($arryQuote[0]['adjustmentType']=='+'){ echo "selected"; }?>>Add</option>
			<option value="-" <? if($arryQuote[0]['adjustmentType']=='-'){ echo "selected"; }?>>Deduct</option>
		</select>
	</td>
	<td align="right" class="crmTableRow small">
		<input type="text" align="right" onblur="calcTotal();" value="<? if($arryQuote[0]['adjustment']){ echo $arryQuote[0]['adjustment'];}else{ echo"0.00";}?>" style="width:40px" class="small" name="adjustment" id="adjustment">
	</td>
   </tr>
   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow big lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow big lineOnTop"><b>Grand Total</b></td>
	<td align="right" class="crmTableRow big lineOnTop" name="grandTotal" id="grandTotal"><?=$arryQuote[0]['total']?></td>
   </tr>
</tbody></table>
		<input type="hidden" value="<?=$arryQuote[0]['totalProductCount']?>" id="totalProductCount" name="totalProductCount">
		<input type="hidden" value="<?=$arryQuote[0]['subtotal']?>" id="subtotal" name="subtotal">
		<input type="hidden" value="<?=$arryQuote[0]['total']?>" id="total" name="total">




	</td>
   </tr>
   
</table>


	</td>
   </tr>
                                   <tr>
										<td colspan="4" style="padding:5px">
											<div align="center">
                                            
                                            <? if($_GET['edit']!=''){ $button="Update";}?>
										<input title="Save" accesskey="S" class="button" onclick="this.form.action.value='Save'; return validateInventory('Quotes')" name="button" value=" <?=$button?> " style="width:70px" type="submit">
												<input title="Cancel" accesskey="X" class="button" onclick="window.history.back()" name="button" value="  Cancel  " style="width:70px" type="button">
										<input name="quoteid" value="<?=$quoteid?>" id="quoteid" type="hidden">
                                                                                <input name="duplicate_from" value="" type="hidden">
											</div>
										</td>
									   </tr>
									</tbody></table>
								<!-- General details - end -->
			</form>			
            
            
            
            
            
<script type="text/javascript" language="JavaScript">
var prodList=document.getElementById("productList")
var rowCnt={ROWCOUNT};
//var rowCnt=1;
var listTableStart="<table width='100%' border='0' cellspacing='0' cellpadding='0' class='formBorder'>"

function settotalnoofrows() {
	document.EditView.totalProductCount.value = rowCnt;	
}

</script>

<? echo '<script>SetInnerWidth();</script>'; ?>
