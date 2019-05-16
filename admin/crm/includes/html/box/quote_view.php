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
</script>

<? if($_GET['tab']=="Quote"){ ?>
<form name="form1" id="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validateQuote(this);  validateInventory('Products');" enctype="multipart/form-data">
									<table  border="0" class="borderall" cellpadding="0" cellspacing="0" width="100%">
									   <tbody>

								 
					<tr>
						<td colspan="2" class="head" align="left" >	Quote Information	</td>
									      </tr>


			<tr >
																									 	
								
				<td  align="right" class="blackbold" width="45%" >Subject :	 </td>
			<td  align="left" >
				<?=$arryQuote[0]['subject']?>
			</td>
				</tr>																						 	
							
						<tr>				
							<td  align="right" class="blackbold" >
				Opportunity Name :			</td>
			<td  align="left" >
				<?=$arryQuote[0]['opportunityName']?>
              
			</td>

			   </tr>
			<tr style="display:none;" >
			
				<td  align="right" class="blackbold" >Quote No :</td>
                                <td  align="left" ><input  class="inputbox" name="quote_no" id="quote_no" value="AUTO GEN ON SAVE"   type="text"></td>
																										 	
					</tr>		
						<tr>				
							<td  align="right" class="blackbold" >
				
				Quote Stage 	:	 	</td>
			<td  align="left" >
							   		<? echo $arryQuote[0]['quotestage']; ?>
			</td>
			   </tr>
			<tr >
																									 	
							
										
							<td  align="right" class="blackbold" >
				Valid Till 	:		</td>
			<td  align="left" >
	<?=date($config['DateFormat'],strtotime($arryQuote[0]['validtill']))?>
			
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
			<td  align="left" >	<? echo $arryQuote[0]['carrier']; ?>
							   		
			</td>
					</tr>																					 	
							
							<tr>			
							<td  align="right" class="blackbold" >Shipping </td>

							<td  align="left" ><?=$arryQuote[0]['shipping']?></td>
						   </tr>
			<tr >
																									 	
							
										
							<td  align="right" class="blackbold" >
				Assign To 		:  	</td>
			<td  align="left" >
            
            
             <? if($HideSibmit!=1){?>
  <select name="assignTo" disabled="disabled" style=" background: none repeat scroll 0 0 #F3F3EB; border: 1px solid #DAE1E8;border-radius: 2px 2px 2px 2px;color: #73787C;font-size: 12px; padding: 4px;
    width: 160px;"  id="assignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryQuote[0]['assignTo']){echo "selected";}?>>
							<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)
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
					
				Billing Address 	:	 	</td>
			<td  align="left" >
				<?=$arryQuoteAdd[0]['bill_street']?>
			</td>
          <tr style="display:none;"><td  align="right" class="blackbold" >Billing PO Box :</td>
							<td  align="left" ><?=$arryQuoteAdd[0]['bill_pobox']?></td>
								</tr>	
                      <tr >
										
							<td  align="right" class="blackbold" >Billing City </td>

							<td  align="left" ><?=$arryQuoteAdd[0]['bill_city']?></td>
																													 	
							</tr>	             
			         <tr >
						<td  align="right" class="blackbold" >Billing State :</td>

							<td  align="left" ><?=$arryQuoteAdd[0]['bill_state']?></td>
																													 	
							</tr>
                            <tr >			
							<td  align="right" class="blackbold" >Billing Postal Code :</td>

							<td  align="left" ><?=$arryQuoteAdd[0]['bill_code']?></td>
																													 	
							</tr>	
                            <tr >
																									 	
							
										
							<td  align="right" class="blackbold" >Billing Country :</td>

							<td  align="left" ><?=$arryQuoteAdd[0]['bill_country']?></td>
																													 	
							</tr>
																										 	
						   <tr>
									   									     <td colspan="2" class="head" align="left" >
										                                                                        	
	                                                                          	                                                                
                	                                                   <span>Ship Address Information</span> 
                                        	                        </td>    										
									      </tr>	
						<tr>				
							<td  align="right" class="blackbold" >
					
				Shipping Address 		:	 </td>
			<td  align="left" >
				<?=stripslashes($arryQuoteAdd[0]['ship_street'])?>
			</td>
			   </tr>
																								 	
							
							<tr style="display:none;">			
							<td  align="right" class="blackbold" >Shipping PO Box :</td>

							<td  align="left" ><?=stripslashes($arryQuoteAdd[0]['ship_pobox'])?></td>
						   </tr>
			
							<tr>			
							<td  align="right" class="blackbold" >Shipping City :</td>

							<td  align="left" ><?=stripslashes($arryQuoteAdd[0]['ship_city'])?></td>
						   </tr>
                           
             		
							<tr>			
							<td  align="right" class="blackbold" >Shipping State : </td>

							<td  align="left" ><?=stripslashes($arryQuoteAdd[0]['ship_state'])?></td>
						   </tr>
                           
			
								<tr>		
							<td  align="right" class="blackbold" >Shipping Postal Code :</td>

							<td  align="left" ><?=stripslashes($arryQuoteAdd[0]['ship_code'])?></td>
						   </tr>
			
							<tr>			
							<td  align="right" class="blackbold" >Shipping Country :</td>

							<td  align="left" ><?=stripslashes($arryQuoteAdd[0]['ship_country'])?></td>
						   </tr>
									   									      <tr>
																				  <td colspan="2" class="head" align="left" >
											<b>Terms &amp; Conditions</b>
																				</td>
									      </tr>

						<td  align="right" class="blackbold" >
					
				Terms &amp; Conditions 		:	</td>
			<td  align="left">
				 <?=stripslashes($arryQuote[0]['terms_conditions'])?>
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
				<?=stripslashes($arryQuote[0]['description'])?>
							</td>
			   </tr>
								


<style>
input, textarea, select{background: none repeat scroll 0 0 #FFFFFF;
border: 1px solid #DAE1E8;
border-radius: 2px 2px 2px 2px;
color: #73787C;
font-size: 12px;
padding: 4px;}
input[type="checkbox"], input[type="radio"]{ width:auto;}
.crmTable {
  border: 1px solid #DADADA;
}.dvInnerHeader {
  background: url("images/inner.gif") repeat-x scroll center bottom #DDDCDD;
  border-color: #DEDEDE;
  border-style: solid;
  border-width: 1px;
  color: #000000;
  padding: 8px;
}.dvInnerHeader {
  color: #000000;
}.lvtCol {
  background: url("images/level2Bg.gif") repeat-x scroll center bottom #FFFFFF;
  border-color: #FFFFFF #FFFFFF #FFFFFF #DDDDDD;
  border-style: solid;
  border-width: 1px 0 0 1px;
  font-weight: bold;
}.lineOnTop {
  border-top: 1px solid #999999;
}.crmTableRow {
  border-bottom: 1px dotted #DADADA;
  border-right: 1px dotted #DADADA;
}
.discountUI{
background-color: #FFFFFF;
    border: 3px solid #CCCCCC;
    display: none;
    padding: 5px;
    position: absolute;
    width: 250px;
}



.small {
    color: #000000;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 11px;
}
</style>
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
	<td width="40%" class="lvtCol"><b>Item Name</b></td>
			<td width="10%" class="lvtCol"><b>Qty In Stock</b></td>
		<td width="10%" class="lvtCol"><b>Qty</b></td>
	<td width="10%" align="right" class="lvtCol"><b>List Price</b></td>
	<td width="12%" nowrap="" align="right" class="lvtCol"><b>Total</b></td>
	<td width="13%" valign="top" align="right" class="lvtCol"><b>Net Price</b></td>
   </tr>








   <!-- Product Details First row - Starts -->
   
   <?php 
   
   for($i=0;$i<sizeof($arryQuoteProduct); $i++){
   
   $j++;
   
   ?>
   <tr valign="top" id="row1">

	<!-- column 1 - delete link - starts -->
	<td class="crmTableRow small lineOnTop">&nbsp;
		
	</td>
	<!-- column 1 - delete link - ends -->

	<!-- column 2 - Product Name - starts -->
	<td class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="1" border="0">
		   <tbody><tr>
			<td class="small">
				<?=stripslashes($arryQuoteProduct[$i]['productName'])?>
				
				
			</td>
		</tr>
		
		   <tr valign="bottom">
			<td id="setComment" class="small">
				<?=stripslashes($arryQuoteProduct[$i]['comment'])?>
				
			</td>
		   </tr>
		</tbody></table>
	</td>
	<!-- column 2 - Product Name - ends -->

	<!-- column 3 - Quantity in Stock - starts -->
			<td class="crmTableRow small lineOnTop"><span id="qtyInStock<?=$j?>"><?=$arryQuoteProduct[$i]['Quantity']?></span></td>
		<!-- column 3 - Quantity in Stock - ends -->


	<!-- column 4 - Quantity - starts -->
	<td class="crmTableRow small lineOnTop">
		<?=$arryQuoteProduct[$i]['qty']?> </span>
	</td>
	<!-- column 4 - Quantity - ends -->


	<!-- column 5 - List Price with Discount, Total After Discount and Tax as table - starts -->
	<td align="right" class="crmTableRow small lineOnTop">
		<table width="100%" cellspacing="0" cellpadding="0">
		   <tbody><tr>
			<td align="right">
				<?=$arryQuoteProduct[$i]['SalePrice']?>&nbsp;<? echo $Config['Currency'];?>
			</td>
		   </tr>
		   <tr>
			<td nowrap="" align="right" style="padding:5px;">
				(-)&nbsp;<b>  <? if($arryQuoteProduct[$i]['discount_type']=="percentage" && $arryQuoteProduct[$i]['discount']==50){
			 
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
		   <tr class="TaxShow" id="individual_tax_row<?=$j?>">
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
			<td align="right" id="productTotal<?=$j?>"><?=$arryQuoteProduct[$i]['SalePrice']*$arryQuoteProduct[$i]['qty']?>&nbsp;<? echo $Config['Currency'];?></td>
		   </tr>
		   <tr>
			<td align="right" id="discountTotal<?=$j?>"><? 
			if($arryQuoteProduct[$i]['discount_type']=="percentage"){
			$discount=$arryQuoteProduct[$i]['SalePrice']*$arryQuoteProduct[$i]['qty']*$arryQuoteProduct[$i]['discount_percentage']/100;
			
			}else if($arryQuoteProduct[$i]['discount_type']=="amount"){
			
			$discount=$arryQuoteProduct[$i]['SalePrice']*$arryQuoteProduct[$i]['qty']-$arryQuoteProduct[$i]['discount_amount'];
			
			}else{
			$discount='0.00';
			}
			if($arryQuoteProduct[$i]['discount']=='on'){echo '0.00';} else{ echo $discount;}?>&nbsp;<? echo $Config['Currency'];?></td>
		   </tr>
		   <tr>
			<td align="right" id="totalAfterDiscount<?=$j?>"><? $nettotal= $arryQuoteProduct[$i]['SalePrice']*$arryQuoteProduct[$i]['qty']-$discount; echo $nettotal;?>&nbsp;<? echo $Config['Currency'];?></td>
		   </tr>
		   <tr>
			<td align="right" id="taxTotal<?=$j?>">&nbsp;</td>
		   </tr>
		</tbody></table>
	</td>
	<!-- column 6 - Product Total - ends -->


	<!-- column 7 - Net Price - starts -->
	<td valign="bottom" align="right" class="crmTableRow small lineOnTop"><span id="netPrice<?=$j?>"><b> <? echo $nettotal;?> &nbsp;<? echo $Config['Currency'];?></b></span></td>
	<!-- column 7 - Net Price - ends -->

   </tr>
   
   <? }?>
   <!-- Product Details First row - Ends -->
</tbody></table>
<!-- Upto this has been added for form the first row. Based on these above we should form additional rows using script -->


<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="crmTable">
   <!-- Add Product Button -->
   <tr>
	<td colspan="3">
			<!--<input type="button" onclick="fnAddProductRow('Quotes','themes/softed/images/');" value="Add Product" class="crmbutton small create" name="Button">-->
			&nbsp;&nbsp;
			<!--<input type="button" onclick="fnAddServiceRow('Quotes','themes/softed/images/');" value="Add Service" class="crmbutton small create" name="Button">-->
	</td>
   </tr>




   <!-- Product Details Final Total Discount, Tax and Shipping&Hanling  - Starts -->
   <tr valign="top">
	<td width="88%" align="right" class="crmTableRow small lineOnTop" colspan="2"><b>Net Total</b></td>
	<td width="12%" align="right" class="crmTableRow small lineOnTop" id="netTotal"><?=$arryQuote[0]['subtotal']?>&nbsp;<? echo $Config['Currency'];?></td>
   </tr>

   <tr valign="top">
	<td width="60%" style="border-right:1px #dadada;" class="crmTableRow small lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow small lineOnTop">
     <? if($arryQuoteProduct[$i][' 	discount_type_final']=="percentage" && $arryQuoteProduct[$i]['discount_final']==50){
			 
			 $discounttypefinal=$arryQuoteProduct[$i][' 	discount_type_final'];
			$discount_pricefinal= $arryQuoteProduct[$i]['discount_percentage_final'].'%';
			
			}else if($arryQuoteProduct[$i]['discount_type_final']=="amount" && $arryQuoteProduct[$i]['discount_final']=="on" ){
			
			 $discounttypefinal=$arryQuoteProduct[$i]['discount_type_final'];
			$discount_pricefinal= $arryQuoteProduct[$i]['discount_type_final'];
			
		
			
			}else{
			 $discounttypefinal=$arryQuoteProduct[$i]['discount_type_final'];
			$discount_pricefinal= 0.00;
			 
			} ?>
    
    <a onclick="alert('Direct <?=$discounttypefinal?> Discount = <?=$discount_pricefinal?>'); " href="javascript:;">(-)Discount : </a> </b>
		
		<!-- End Div -->
	</td>
	<td align="right" class="crmTableRow small lineOnTop" id="discountTotal_final">0.00&nbsp;<? echo $Config['Currency'];?></td>
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
		<? echo $arryQuote[0]['shipping_handling_charge']?>&nbsp;<? echo $Config['Currency'];?>
	</td>
   </tr>

   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		(+)&nbsp;
        
        <a onclick="alert('Shipping &amp; Handling Charge = <? echo $arryQuote[0]['shipping_handling_charge']?>\nVAT : <? echo $arryQuote[0]['shtax1_sh_percent']?> % =  <? echo $arryQuote[0]['shtax1_sh_amount']?> \nSales : <? echo $arryQuote[0]['shtax2_sh_percent']?> % = <? echo $arryQuote[0]['shtax2_sh_amount']?> \nService : <? echo $arryQuote[0]['shtax3_sh_percent']?> % = <? echo $arryQuote[0]['shtax3_sh_amount']?> \n\n Total Tax Amount = <? echo $arryQuote[0]['shtax3_sh_amount'];?>')" href="javascript:;">Taxes For Shipping and Handling</a>

			

	</td>
	<td align="right" class="crmTableRow small" id="shipping_handling_tax"><? if($arryQuote[0]['shtax3_sh_amount']){ echo $arryQuote[0]['shtax3_sh_amount']; }else{ echo"0.00";}?>&nbsp;<? echo $Config['Currency'];?></td>
   </tr>
   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow small">&nbsp;</td>
	<td align="right" class="crmTableRow small">
		Adjustment
		( <? if($arryQuote[0]['adjustmentType']=='+'){ echo $arryQuote[0]['adjustmentType']; }?>)
			
	</td>
	<td align="right" class="crmTableRow small">
		<? if($arryQuote[0]['adjustment']){ echo $arryQuote[0]['adjustment'];}else{ echo"0.00";}?>&nbsp;<? echo $Config['Currency'];?>
	</td>
   </tr>
   <tr valign="top">
	<td style="border-right:1px #dadada;" class="crmTableRow big lineOnTop">&nbsp;</td>
	<td align="right" class="crmTableRow big lineOnTop"><b>Grand Total</b></td>
	<td align="right" class="crmTableRow big lineOnTop" name="grandTotal" id="grandTotal"><?=$arryQuote[0]['total']?>&nbsp;<? echo $Config['Currency'];?></td>
   </tr>
</tbody></table>
		<input type="hidden" value="<?=$arryQuote[0]['adjustment']?>" id="totalProductCount" name="totalProductCount">
		<input type="hidden" value="<?=$arryQuote[0]['subtotal']?>" id="subtotal" name="subtotal">
		<input type="hidden" value="<?=$arryQuote[0]['total']?>" id="total" name="total">




	</td>
   </tr>
   
</table>
<!-- Upto this has been added for form the first row. Based on these above we should form additional rows using script -->



	</td>
   </tr>



									   
								   	
									</tbody></table>
								<!-- General details - end -->
			</form>			
            
     <? }?>       
            
            
<script type="text/javascript" language="JavaScript">
var prodList=document.getElementById("productList")
var rowCnt={ROWCOUNT};
//var rowCnt=1;
var listTableStart="<table width='100%' border='0' cellspacing='0' cellpadding='0' class='formBorder'>"

function settotalnoofrows() {
	document.EditView.totalProductCount.value = rowCnt;	
}

function productPickList546465(currObj) {

alert('');
	var trObj=currObj.parentNode.parentNode
	var rowId=parseInt(trObj.id.substr(trObj.id.indexOf("w")+1,trObj.id.length))
	window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype=inventory_prod&curr_row="+rowId,"productWin","width=600,height=400,resizable=1,scrollbars=1,top=150,left=200");
}

function priceBookPickList(currObj) {
	var trObj=currObj.parentNode.parentNode
	var rowId=parseInt(trObj.id.substr(trObj.id.indexOf("w")+1,trObj.id.length))
	window.open("index.php?module=Products&action=PriceBookPopup&html=Popup_picker&form=EditView&popuptype=inventory_pb&fldname=txtListPrice"+rowId+"&productid="+document.getElementById("hdnProductId"+rowId).value,"priceBookWin","width=600,height=400,resizable=1,scrollbars=1,top=150,left=200");
}

function getProdListBody() {
	if (browser_ie) {
		var prodListBody=document.getElementById("productList").children[0].children[0]
	} else if (browser_nn4 || browser_nn6) {
		if (document.getElementById("productList").childNodes.item(0).tagName=="TABLE") {
			var prodListBody=document.getElementById("productList").childNodes.item(0).childNodes.item(0)
		} else {
			var prodListBody=document.getElementById("productList").childNodes.item(1).childNodes.item(1)
		}
	}
	return prodListBody;
}

function addRow() {
   //adding new row
   rowCnt++;

   if (rowCnt%2==0)
       var newRow="<tr id=row"+rowCnt+" class='evenListRow'>"
   else
       var newRow="<tr id=row"+rowCnt+" class='oddListRow'>"
         newRow+="<td style='padding:3px;'><input id='txtProduct"+rowCnt+"' name='txtProduct"+rowCnt+"' type='text' readonly> <img src='{IMAGE_PATH}search.gif' onclick='productPickList(this)' align='absmiddle' style='cursor:hand;cursor:pointer'></td>"
   newRow+="<td WIDTH='1' class='blackLine'><IMG SRC='{IMAGE_PATH}blank.gif'></td>"
   newRow+="<td style='padding:3px;'><div id='qtyInStock"+rowCnt+"'></div></td>"
   newRow+="<td WIDTH='1' class='blackLine'><IMG SRC='{IMAGE_PATH}blank.gif'></td>"
   newRow+="<td style='padding:3px;'><input type=text id='txtQty"+rowCnt+"' name='txtQty"+rowCnt+"' size='7' value='1' onBlur='calcTotal(this)'></td>"
   newRow+="<td WIDTH='1' class='blackLine'><IMG SRC='{IMAGE_PATH}blank.gif'></td>"
   newRow+="<td style='padding:3px;'><div id='unitPrice"+rowCnt+"'></div></td>"
   newRow+="<td WIDTH='1' class='blackLine'><IMG SRC='{IMAGE_PATH}blank.gif'></td>"
   newRow+="<td style='padding:3px;'><input type=text id='txtListPrice"+rowCnt+"' name='txtListPrice"+rowCnt+"' size='12' value='0.00' onBlur='calcTotal(this)'> <img src='{IMAGE_PATH}pricebook.gif' onclick='priceBookPickList(this)' align='absmiddle' style='cursor:hand;cursor:pointer'></td>"
   newRow+="<td WIDTH='1' class='blackLine'><IMG SRC='{IMAGE_PATH}blank.gif'></td>"
   newRow+="<td style='padding:3px;'><div id='total"+rowCnt+"' align='right'></div></td>"
   newRow+="<td WIDTH='1' class='blackLine'><IMG SRC='{IMAGE_PATH}blank.gif'></td>"
   newRow+="<td style='padding:3px;' align='center' width='50'><a id='delRow"+rowCnt+"' href='javascript:;' onclick='delRow(this.id)'>Del</a>"
   newRow+="<input type=hidden id='hdnProductId"+rowCnt+"' name='hdnProductId"+rowCnt+"'>"
   newRow+="<input type=hidden id='hdnRowStatus"+rowCnt+"' name='hdnRowStatus"+rowCnt+"'>"
   newRow+="<input type=hidden id='hdnTotal"+rowCnt+"' name='hdnTotal"+rowCnt+"'></td></tr>"
     var prodListBody=getProdListBody()
     if (browser_nn4 || browser_nn6) {
       var product=new Array(rowCnt-1)
       var qty=new Array(rowCnt-1)
       var listPrice=new Array(rowCnt-1)
       var productId=new Array(rowCnt-1)
       var total=new Array(rowCnt-1)
       var rowStatus=new Array(rowCnt-1)
	//alert(rowCnt)
         for (var i=1,k=0;i<=rowCnt-1;i++,k++) {
           product[k]=document.getElementById("txtProduct"+i).value
           qty[k]=document.getElementById("txtQty"+i).value
           listPrice[k]=document.getElementById("txtListPrice"+i).value
           total[k]=document.getElementById("hdnTotal"+i).value
           productId[k]=document.getElementById("hdnProductId"+i).value
           rowStatus[k]=document.getElementById("hdnRowStatus"+i).value
       }
   }
     prodList.innerHTML=listTableStart+prodListBody.innerHTML+newRow+"</table>"
     if (browser_nn4 || browser_nn6) {
       for (var i=1,k=0;i<=rowCnt-1;i++,k++) {
           document.getElementById("txtProduct"+i).value=product[k]
           document.getElementById("txtQty"+i).value=qty[k]
           document.getElementById("txtListPrice"+i).value=listPrice[k]
           document.getElementById("hdnTotal"+i).value=total[k]
           document.getElementById("hdnProductId"+i).value=productId[k]
           document.getElementById("hdnRowStatus"+i).value=rowStatus[k]
       }
   }
} 

function delRow(rowId) {
   var rowId=parseInt(rowId.substr(rowId.indexOf("w")+1,rowId.length))
      //removing the corresponding row
   var prodListBody=getProdListBody()
   prodListBody.removeChild(document.getElementById("row"+rowId))
      //assigning new innerHTML after deleting a row
   var newInnerHTML="<tr class='moduleListTitle' height='20' id='tablehead'>"+document.getElementById("tablehead").innerHTML+"</tr>"
   newInnerHTML+="<tr id='tableheadline'>"+document.getElementById("tableheadline").innerHTML+"</tr>";
      var rowArray=new Array(rowCnt-1);
      if (browser_nn4 || browser_nn6) {
       var product=new Array(rowCnt-1)
       var qty=new Array(rowCnt-1)
       var listPrice=new Array(rowCnt-1)
       var productId=new Array(rowCnt-1)
       var total=new Array(rowCnt-1)
       var rowStatus=new Array(rowCnt-1)
   }
      for (var i=1,k=0;i<=rowId-1;i++,k++) {
       if (i%2==0) var rowClass="evenListRow"
       else var rowClass="oddListRow"
              rowArray[k]="<tr id='row"+i+"' class='"+rowClass+"'>"+document.getElementById("row"+i).innerHTML+"</tr>"
       newInnerHTML+=rowArray[k]
              if (browser_nn4 || browser_nn6) {
           product[k]=document.getElementById("txtProduct"+i).value
           qty[k]=document.getElementById("txtQty"+i).value
           listPrice[k]=document.getElementById("txtListPrice"+i).value
           total[k]=document.getElementById("hdnTotal"+i).value
           productId[k]=document.getElementById("hdnProductId"+i).value
           rowStatus[k]=document.getElementById("hdnRowStatus"+i).value
       }
   }
      for (var i=rowId+1;i<=rowCnt;i++,k++) {
       rowArray[k]=document.getElementById("row"+i).innerHTML
       var temp=rowArray[k]
       temp=temp.replace("row"+i,"row"+(i-1))
       temp=temp.replace("txtProduct"+i,"txtProduct"+(i-1))
       temp=temp.replace("txtProduct"+i,"txtProduct"+(i-1))
       temp=temp.replace("qtyInStock"+i,"qtyInStock"+(i-1))
       temp=temp.replace("txtQty"+i,"txtQty"+(i-1))
       temp=temp.replace("txtQty"+i,"txtQty"+(i-1))
       temp=temp.replace("unitPrice"+i,"unitPrice"+(i-1))
       temp=temp.replace("txtListPrice"+i,"txtListPrice"+(i-1))
       temp=temp.replace("txtListPrice"+i,"txtListPrice"+(i-1))
       temp=temp.replace("total"+i,"total"+(i-1))
       temp=temp.replace("delRow"+i,"delRow"+(i-1))
       temp=temp.replace("hdnProductId"+i,"hdnProductId"+(i-1))
       temp=temp.replace("hdnProductId"+i,"hdnProductId"+(i-1))
       temp=temp.replace("hdnRowStatus"+i,"hdnRowStatus"+(i-1))
       temp=temp.replace("hdnRowStatus"+i,"hdnRowStatus"+(i-1))
       temp=temp.replace("hdnTotal"+i,"hdnTotal"+(i-1))
       temp=temp.replace("hdnTotal"+i,"hdnTotal"+(i-1))
              if ((i-1)%2==0) var rowClass="evenListRow"
       else var rowClass="oddListRow"
              rowArray[k]="<tr id='row"+(i-1)+"' class='"+rowClass+"'>"+temp+"</tr>"
       newInnerHTML+=rowArray[k]
              if (browser_nn4 || browser_nn6) {
           product[k]=document.getElementById("txtProduct"+i).value
           qty[k]=document.getElementById("txtQty"+i).value
           listPrice[k]=document.getElementById("txtListPrice"+i).value
           total[k]=document.getElementById("hdnTotal"+i).value
           productId[k]=document.getElementById("hdnProductId"+i).value
           rowStatus[k]=document.getElementById("hdnRowStatus"+i).value
       }           }

   var prodListBody=getProdListBody()
   prodList.innerHTML=listTableStart+newInnerHTML+"</table>"


   rowCnt--

   for (var i=1,k=0;i<=rowCnt;i++,k++) {
       if (browser_nn4 || browser_nn6) {
           document.getElementById("txtProduct"+i).value=product[k]
           document.getElementById("txtQty"+i).value=qty[k]
           document.getElementById("txtListPrice"+i).value=listPrice[k]
           document.getElementById("hdnTotal"+i).value=total[k]
           document.getElementById("hdnProductId"+i).value=productId[k]
           document.getElementById("hdnRowStatus"+i).value=rowStatus[k]
       }
   }

   calcGrandTotal()
}


function calcTotal(currObj) {
	var trObj=currObj.parentNode.parentNode
	var rowId=parseInt(trObj.id.substr(trObj.id.indexOf("w")+1,trObj.id.length))
	var total=eval(document.getElementById("txtQty"+rowId).value*document.getElementById("txtListPrice"+rowId).value)
	document.getElementById("total"+rowId).innerHTML=document.getElementById("hdnTotal"+rowId).value=roundValue(total.toString())
	calcGrandTotal()
}

function calcGrandTotal() {
	var subTotal=0,grandTotal=0;
	for (var i=1;i<=rowCnt;i++) {
		if (document.getElementById("hdnTotal"+i).value=="") 
			document.getElementById("hdnTotal"+i).value=0
		if (!isNaN(document.getElementById("hdnTotal"+i).value)) 
			subTotal+=parseFloat(document.getElementById("hdnTotal"+i).value)
	}
	
	grandTotal=subTotal+parseFloat(document.getElementById("txtTax").value)+parseFloat(document.getElementById("txtAdjustment").value)
	
	document.getElementById("subTotal").innerHTML=document.getElementById("hdnSubTotal").value=roundValue(subTotal.toString())
	document.getElementById("grandTotal").innerHTML=document.getElementById("hdnGrandTotal").value=roundValue(grandTotal.toString())
}

function roundValue(val) {
	if (val.indexOf(".")<0) {
		val+=".00"
	} else {
		var dec=val.substring(val.indexOf(".")+1,val.length)
		if (dec.length>2)
			val=val.substring(0,val.indexOf("."))+"."+dec.substring(0,2)
		else if (dec.length==1)
			val=val+"0"
	}
	
	return val;
}
</script>







<script>


//jQuery(document).ready(function() {
//	jQuery(".txtProdName").live('click', function() {
//		//alert(jQuery(this).val());
//	});
//	
//	
//	
//	
//	
//	jQuery(".delTR").live('click', function() {
//		jQuery(this).parent("td").parent("tr").remove();
//	});
//	
//	
//	
//	
//	
//	
//});
</script> 

<? if($_GET['tab']=="Event"){?>


        
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
           <a class="add" href="editActivity.php?module=event&parent_type=<?=$_GET['module']?>&parentID=<?=$_GET['view']?>" >Add Event</a>
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','eventID','<?=sizeof($arryActivity)?>');" /></td>-->
  <td width="6%"  class="head1" >ID</td>
      <td width="15%"  class="head1" >Title</td>
	  <td width="13%" class="head1"> Activity Type </td>
	  <td width="12%" class="head1" >Priority</td>
      <td width="12%" class="head1" >Assign To</td>
	  <td width="19%" class="head1" > Add Date</td>
      <td width="11%"  align="center" class="head1" >  Status</td>
      <td width="12%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryActivity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryActivity as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="eventID[]" id="eventID<?=$Line?>" value="<?=$values['eventID']?>" /></td>-->
      <td ><?=$values["eventID"]?></td>
      <td height="22" > 
	  <?
		  echo  stripslashes($values["subject"]); 
		  
		  
		  ?>		       </td>
		   <td><?=$values['activityType']?></td>
      <td><?  echo $values['priority'];?> </td>
	  <td><?=$values['AssignTo']?> (<?=$values['Department']?>)</td>
      <td>
      <?php  
	   $stdate= $values["startDate"]." ".$values["startTime"];
	 echo date($Config['DateFormat']." H:i A" , strtotime($stdate));?>
      </td>
       
    <td align="center"><? $status = $values['event_status']; echo $status;?></td>
	<td  align="center" ><a href="vActivity.php?view=<?php echo $values['eventID'];?>&amp;curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['module'];?>"><?=$view?></a>
	<a href="editActivity.php?edit=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Activity" ><?=$edit?></a>
	<a href="editActivity.php?del_id=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryActivity)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  </td>
  </tr>  
 </TABLE>
        
        <? }?>
        
        
        <? 
		
if($_GET['tab']=="Task"){?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="add" href="<?=$AddRef?>" >Add Task</a>
        
         
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','eventID','<?=sizeof($arryActivity)?>');" /></td>-->
  <td width="6%"  class="head1" >ID</td>
      <td width="15%"  class="head1" >Title</td>
	  <td width="13%" class="head1"> Activity Type </td>
	  <td width="12%" class="head1" >Priority</td>
      <td width="12%" class="head1" >Assign To</td>
	  <td width="19%" class="head1" > Add Date</td>
      <td width="11%"  align="center" class="head1" >  Status</td>
      <td width="12%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryActivity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryActivity as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="eventID[]" id="eventID<?=$Line?>" value="<?=$values['eventID']?>" /></td>-->
      <td ><?=$values["eventID"]?></td>
      <td height="22" > 
	  <?
		  echo  stripslashes($values["subject"]); 
		  
		  
		  ?>		       </td>
		   <td><?=$values['activityType']?></td>
      <td><?  echo $values['priority'];?> </td>
	  <td><?=$values['AssignTo']?> (<?=$values['Department']?>)</td>
      <td>
      <?php  
	   $stdate= $values["startDate"]." ".$values["startTime"];
	 echo date($Config['DateFormat']." H:i A" , strtotime($stdate));?>
      </td>
       
    <td align="center"><? $status = $values['event_status']; echo $status;?></td>
	<td  align="center" ><a href="vActivity.php?view=<?php echo $values['eventID'];?>&amp;curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['module'];?>"><?=$view?></a>
	<a href="editActivity.php?edit=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Activity" ><?=$edit?></a>
	<a href="editActivity.php?del_id=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryActivity)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
        
        
       <?  if($_GET['tab']=="Campaign"){?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="button" style="font-size:12px; color:#FFFFFF;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Campaign</b></a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    

	 <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?=sizeof($arryCampaign)?>');" /></td>-->
      <td width="18%"  class="head1" >Campaign Name</td>
      <td width="14%"  class="head1" >Campaign Type</td>
      <td width="12%"  class="head1" >Campaign Status</td>
       <td width="12%" class="head1" >Expected Revenue</td>
     <td width="13%" class="head1" >Expected Close Date</td>
     
      <td width="16%"  align="center" class="head1" >Assign To</td>
      <td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCampaign) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCampaign as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values['campaignID']?>" /></td>-->
      <td ><?=stripslashes($values["campaignname"])?></td>
      <td height="20" > <?=stripslashes($values["campaigntype"])?>	 </td>
	    <td height="20" > <?=stripslashes($values["campaignstatus"])?>	 </td>
			
		<td><?=$values['expectedrevenue']?> <?=$Config['Currency']?></td>
        <td height="20" > 
	<?  	if($values["closingdate"]!="0000-00-00"){//echo $Config['DateFormat'];
		echo date($Config['DateFormat'] , strtotime($values["closingdate"])); }?> </td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
	  
   
      <td  align="center"  >
	   <a href="vCampaign.php?view=<?=$values['campaignID']?>&module=Campaign&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editCampaign.php?edit=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editCampaign.php?del_id=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCampaign)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
     <? if($_GET['tab']=='Comments'){ include("comment.php");  }?>
	
<? if($_GET['tab']=='Ticket'){?>
 

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <a href="editTicket.php?module=Ticket&parent_type=<?=$_GET['module']?>&parentID=<?=$arryLead[0]['leadID']?>&mode_type=<?=$_GET['module']?>" class="add" >Add  Ticket</a>
        <a class="red_bt" style="display: inline-block;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" >Select Ticket</a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?=sizeof($arryTicket)?>');" /></td>-->
      <td width="13%"  class="head1" >Ticket ID</td>
      <td width="25%"  class="head1" >Title</td>
      <td width="14%" class="head1" > Add Date</td>
	  <td width="16%" class="head1" > Assign To</td>
    
      <td width="12%"  align="center" class="head1" >Status</td>
      <td width="20%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryTicket) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTicket as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?=$Line?>" value="<?=$values['TicketID']?>" /></td>-->
      <td ><?=$values["TicketID"]?></td>
      <td > 
	  <?
		  echo stripslashes($values['title']);
		  
		  
		  ?>		       </td>
        <td> <? echo date($Config['DateFormat']  , strtotime($values["ticketDate"]));?></td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
       
    <td align="center">
	
	 

	<? echo $values['Status'];
		
	 ?></td>
      <td  align="center"  ><a href="vTicket.php?view=<? echo $values['TicketID']?>&module=<?php echo $_GET['tab'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$view?></a>&nbsp;
	 &nbsp;&nbsp; <a href="editTicket.php?edit=<?php echo $values['TicketID'];?>&module=<?php echo $_GET['tab'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$edit?></a>
	  
	&nbsp;&nbsp;<a href="vLead.php?view=<?php echo $values['TicketID'];?>&select_del_id=<?php echo $values['sid'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=<?=$_GET['tab']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTicket)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </td>
  </tr>
  </TABLE>
  
  </div> 

<? }?>



<!-- END: main -->

		