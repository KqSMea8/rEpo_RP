<script language="JavaScript1.2" type="text/javascript">

function AutoCompleteCustomer(elm){
	$(elm).autocomplete({
		source: "../jsonCustomer.php",
		minLength: 1,
		select: function( event, ui ) {
			console.log(ui.item.hold);
			if(ui.item.hold==1){
				 event.preventDefault();
				 jQuery('#CustomerName').val('');
				alert('This customer on hold');
				//return false;
				//
				}
			}
	}).data("ui-autocomplete")
	._renderItem = function(ul, item) {
		console.log(item);
		var classitem='';
		classitem=(item.hold==1)?'customer-search-hold':'';
	    var listItem = $("<li class='"+classitem+"'></li>")
	        .data("item.autocomplete", item)
	        .append( item.label)
	        .appendTo(ul);

	    if (item.personal) {
	        listItem.addClass("personal");
	    }

	    return listItem;
	};


} 




function ResetSearchdd(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function SetCustInfo(inf){ 
 
	if(inf == ''){
		document.getElementById("form1").reset();
		return false;
	}

	ResetSearchdd();
	document.getElementById("CustomerCompany").value='';
	document.getElementById("CustomerName").value='';
 	document.getElementById("Taxable").value='';
	document.getElementById("Address").value='';
	document.getElementById("City").value='';
	document.getElementById("State").value='';
	document.getElementById("Country").value='';
	document.getElementById("ZipCode").value='';
	document.getElementById("Mobile").value='';
	document.getElementById("Landline").value='';
	document.getElementById("Fax").value='';
	document.getElementById("Email").value='';
	
	document.getElementById("ShippingCompany").value='';
	document.getElementById("ShippingName").value='';
	document.getElementById("ShippingAddress").value='';
	document.getElementById("ShippingCity").value='';
	document.getElementById("ShippingState").value='';
	document.getElementById("ShippingCountry").value='';
	document.getElementById("ShippingZipCode").value='';
	document.getElementById("ShippingMobile").value='';
	document.getElementById("ShippingLandline").value='';
	document.getElementById("ShippingFax").value='';
	document.getElementById("ShippingEmail").value='';	        
			
var SendUrl = "&action=CustomerName&CustName="+escape(inf)+"&r="+Math.random();
	//var SendUrl = "&action=CustomerInfo&CustCode="+escape(CustCode)+"&r="+Math.random();


   	$.ajax({
	type: "GET",
	url: "../sales/ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText) {
		//alert(responseText["Cid"]);
		document.getElementById("CustCode").value=responseText["CustCode"];
		document.getElementById("CustID").value=responseText["Cid"];
var CustId = responseText["Cid"];
		document.getElementById("CustomerName").value=responseText["CustomerName"];

document.getElementById("tax_auths").value=responseText["Taxable"];
if(responseText["Taxable"] =='Yes' ){
//SetTaxable(1);
	//document.getElementById("TaxRate").value=responseText["TaxRate"];
document.getElementById("MainTaxRate").value=responseText["c_taxRate"];
SetTaxable();
freightSett(responseText["c_taxRate"]);

}


		//document.getElementById("tax_auths").value=responseText["Taxable"];

        if(responseText["MDType"]){
		  if(responseText["MDType"] == 'Discount'){
                        
			document.getElementById("CustDisType").value=responseText["DiscountType"];
			document.getElementById("MDAmount").value=responseText["MDAmount"];
			document.getElementById("MDType").value=responseText["MDType"];
      document.getElementById("MDiscount").value=responseText["MDiscount"];


		}else{

				document.getElementById("CustDisType").value='Percentage';
				document.getElementById("MDAmount").value=responseText["MDAmount"];
				document.getElementById("MDType").value=responseText["MDType"];
				document.getElementById("MDiscount").value=responseText["MDiscount"];
		}


	}else{
				document.getElementById("CustDisType").value='';
				document.getElementById("MDAmount").value='';
				document.getElementById("MDType").value='';
				document.getElementById("MDiscount").value='';
	}
		
		if(responseText["SalesPerson"]){
			window.parent.document.getElementById("SalesPerson").value=responseText["SalesPerson"];
			window.parent.document.getElementById("SalesPersonID").value=responseText["SalesPersonID"];
			window.parent.document.getElementById("vendorSalesPersonID").value=responseText["VendorSalesPerson"];
			window.parent.document.getElementById("SalesPersonName").value=responseText["SalesPersonName"];
			window.parent.document.getElementById("vendorSalesPersonName").value=responseText["vendorSalesPersonName"];
		        window.parent.document.getElementById("SalesPersonType").value=responseText["SalesPersonType"];
		}else{
			window.parent.document.getElementById("SalesPerson").value='';
			window.parent.document.getElementById("SalesPersonID").value='';
			window.parent.document.getElementById("vendorSalesPersonID").value='';
		        window.parent.document.getElementById("SalesPersonType").value='';
		        window.parent.document.getElementById("SalesPersonName").value='';
		        window.parent.document.getElementById("vendorSalesPersonName").value='';
	
		}
		

		//Order Quote
		//if(creditnote == ""){
		document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
		//document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
		document.getElementById("ShippingMethod").value=responseText["ShippingMethod"];
		//}
		
	
	document.getElementById("CustomerCompany").value=responseText["CustomerCompany"];
	document.getElementById("BillingName").value=responseText["Name"];
	document.getElementById("Address").value=responseText["Address"];
	document.getElementById("City").value=responseText["CityName"];
	document.getElementById("State").value=responseText["StateName"];
	document.getElementById("Country").value=responseText["CountryName"];
	document.getElementById("ZipCode").value=responseText["ZipCode"];
	document.getElementById("Mobile").value=responseText["Mobile"];
	document.getElementById("Landline").value=responseText["Landline"];
	document.getElementById("Fax").value=responseText["Fax"];
	document.getElementById("Email").value=responseText["Email"];	
	document.getElementById("ShippingCompany").value=responseText["CustomerCompany"];
	document.getElementById("ShippingName").value=responseText["sName"];
	document.getElementById("ShippingAddress").value=responseText["sAddress"];
	document.getElementById("ShippingCity").value=responseText["sCityName"];
	document.getElementById("ShippingState").value=responseText["sStateName"];
	document.getElementById("ShippingCountry").value=responseText["sCountryName"];
	document.getElementById("ShippingZipCode").value=responseText["sZipCode"];
	document.getElementById("ShippingMobile").value=responseText["sMobile"];
	document.getElementById("ShippingLandline").value=responseText["sLandline"];
	document.getElementById("ShippingFax").value=responseText["sFax"];
	document.getElementById("ShippingEmail").value=responseText["sEmail"];
	if(document.getElementById("CustomerCurrency") != null){
		document.getElementById("CustomerCurrency").value=responseText["Currency"];
	}
    
	SelectCreditCard();

	SetTaxable(1);
	//ProcessTotal();
	//shipCarrier();
	/************************************/
	

		   
	}

   });
				


}
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0"   >

   <tr>
    <td  align="center">

 


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Search Customer	</td>
</tr>
  <tr>
            <td  class="blackbold" width="20%" align="right"> Customer :<span class="red">*</span> </td>
            <td  align="left">
                    <input name="CustomerName" type="text" class="inputbox"  id="CustomerName" value="<?php echo stripslashes($arrySale[0]['CustomerName']); ?>"  maxlength="60" autocomplete="off"  onblur="SetCustInfo(this.value);" onclick="Javascript:AutoCompleteCustomer(this);" />
                    <input name="CustCode" id="CustCode" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustCode']); ?>">
                    <input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustID']); ?>">
                    <input name="Taxable" id="Taxable" type="hidden" value="<?php echo stripslashes($arrySale[0]['Taxable']); ?>">
                    <a class="fancybox fancybox.iframe" href="CustomerList.php" ><?=$search?></a>

            </td>
	 </tr>
       
  <tr>
            <td colspan="2"><? include("includes/html/box/generate_invoice_entry_form.php");?></td>
         </tr>

</table>



</td>
   </tr>


<tr id="billingForm" >
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("includes/html/box/sale_order_billto_form.php");?></td>
			<td align="left" valign="top"><? include("includes/html/box/sale_order_shipto_form.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
			 <td align="right">
		<?
		
		$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
		//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
		?>	 
			 </td>
		</tr>



<tr id="itemForm"  >
	<td align="left" >
		
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" >

		<?php
			if($_SESSION['SelectOneItem'] == 1){ 
				   include("includes/html/box/sale_order_item_subform.php");
			}else{
			    include("includes/html/box/sale_order_item_form.php");
			}
		?> 	 
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>


</table>
