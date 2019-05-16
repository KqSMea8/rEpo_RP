<a href="<?=$BackURL?>" class="back">Back</a>

<?
if($CreditCardFlag==1 && !empty($ProviderName)){	 
		 if($CardProcessed==1 && $CardVoided!=1){						
			echo '<div style="float:right"><a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void Credit Card</a></div>';
			 
			
		}else{
			echo '<div style="float:right"><a href="'.$AuthorizeCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Authorize Credit Card\', \''.AUTH_CARD.'\')" >Authorize Credit Card</a></div>';
 
		}
}

?>



<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
			</span>
</div>

<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){


	var NumLine = parseInt($("#NumLine").val());
	var NumLine1 = parseInt($("#NumLine1").val());
	var OrderID = Trim(document.getElementById("OrderID")).value;

	//var EntryType = Trim(document.getElementById("EntryType")).value;
	//var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
	//var EntryTo = Trim(document.getElementById("EntryTo")).value;

	var ModuleVal = Trim(document.getElementById("SaleInvoiceID")).value;
       
	var GLAccountLineItem = Trim(document.getElementById("GLAccountLineItem")).value;	
	var EntryTypeGL = Trim(document.getElementById("EntryTypeGL")).value;
	var EntryFromGL = Trim(document.getElementById("EntryFromGL")).value;
	var EntryToGL = Trim(document.getElementById("EntryToGL")).value;
	var TotalGlAmount  = Trim(document.getElementById("TotalGlAmount")).value;




//alert('aaaaaaaaa');
//return false;

 if(!ValidateOptionalScan(document.getElementById("UploadDocuments"), "Upload Document")){
			return false;
		}
	
	/*********************************/
	if(GLAccountLineItem == "GLAccount")
           {  
               
                if(EntryTypeGL == "recurring")
		{    
                    if(!ValidateForSelect(frm.EntryFromGL, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryToGL, "Entry To")){        
                        return false;
                    }
                    if(EntryFromGL >= EntryToGL) {
                        document.getElementById("EntryFromGL").focus();   
                        alert("End Date Should be Greater Than Start Date.");
                        return false;
                     }
                }
                
                     if(!ValidateForSelect(frm.CustCodeGL, "Customer")){        
            		return false;
       		     }
                    
                     if(frm.Amount.value == "" || frm.Amount.value == 0)
                    {
                        alert("Please Enter Amount.");
                        frm.Amount.focus();
                        return false;
                    }
                    
                     if(frm.GlEntryType.value == "")
                    {
                        alert("Please Select GL Entry Type.");
                        frm.GlEntryType.focus();
                        return false;
                    }
                 
                    if(frm.IncomeTypeID.value == "" && frm.GlEntryType.value == "Single")
                    { 
                        alert("Please Select GL Account.");
                        frm.IncomeTypeID.focus();
                        return false;
                    }
                    
                     if(frm.PaymentDate.value == "")
                    {
                        alert("Please Select Invoice Date.");
                        frm.PaymentDate.focus();
                        return false;
                    }


                    
              if(frm.GlEntryType.value == "Multiple") 
                  {  
                          for(var i=1;i<=NumLine1;i++){ 

					if(document.getElementById("GlAmnt"+i) != null){
		                        	var GlAmnt = document.getElementById("GlAmnt"+i).value;

		                                if(!ValidateForSelect(document.getElementById("AccountID"+i), "GL Account.")){
		                                        return false;
		                                }

		                                if(parseInt(GlAmnt) == 0){

		                                        alert("Please enter amount.");
		                                        document.getElementById("GlAmnt"+i).focus();
		                                        return false;
		                                } 
					}


                           }

			if(parseFloat(frm.Amount.value) != parseFloat(TotalGlAmount))  
                        {
                               alert("Amount Should be Equal.");
                                frm.Amount.focus();
                                return false;
                        }
                         
                            	
                  }



                      if(frm.SoInvoiceIDGL.value != ''){
                               var Url = 'isRecordExists.php?SaleInvoiceID='+escape(frm.SoInvoiceIDGL.value)+'&editID='+OrderID;
				SendExistRequest(Url,SoInvoiceIDGL, "Invoice Number");
                              return false;	
                      }else{
                    	ShowHideLoader('1','S');
                      	 return true;
                    }
               
           }else{

	/***********Line Item***********/
	
        if(!ValidateForSelect(frm.CustomerName, "Customer")){        
            return false;
        }

	if(ModuleVal!='' || OrderID>0 ){
		if(!ValidateMandRange(document.getElementById("SaleInvoiceID"), "Invoice Number",3,20)){
			return false;
		}
	}


      /*  if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                    if(EntryFrom >= EntryTo) {
                      document.getElementById("EntryFrom").focus();   
                      alert("End Date Should be Greater Than Start Date.");
                      return false;
                     }
                }*/

	var PaymentTerm = $("#PaymentTerm").val().toLowerCase();;
	if(PaymentTerm == 'prepayment'){
		if(!ValidateForSelect(frm.BankAccount, "Bank Account")){        
		    return false;
		}
	}


	if(document.getElementById("OrderSource") != null){
		if(document.getElementById("PaymentMethod") != null){
			if(!ValidateForSelect(frm.PaymentMethod, "Payment Method")){        
			    return false;
			}
			}

		if(!ValidateForSelect(frm.OrderSource, "Order Source")){        
		    return false;
		}
	}


	if(   ValidateForSimpleBlank(frm.Address, "Address")
		&& ValidateForSimpleBlank(frm.City, "City")
		&& ValidateForSimpleBlank(frm.State, "State")
		&& ValidateForSimpleBlank(frm.Country, "Country")
		&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)	
		//&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmailOpt(frm.Email)
		
		//&& ValidateForSimpleBlank(frm.ShippingName, "Shipping Name")
		&& ValidateForSimpleBlank(frm.ShippingAddress, "Shipping Address")
		&& ValidateForSimpleBlank(frm.ShippingCity, "City")
		&& ValidateForSimpleBlank(frm.ShippingState, "State")
		&& ValidateForSimpleBlank(frm.ShippingCountry, "Country")
		&& ValidateForSimpleBlank(frm.ShippingZipCode, "Zip Code")
		//&& ValidatePhoneNumber(frm.ShippingMobile,"Mobile Number",10,20)
		//&& ValidateForSimpleBlank(frm.ShippingEmail, "Email Address")
		&& isEmailOpt(frm.ShippingEmail)
	){
		 


var totalSum = 0;var remainQty=0;var inQty=0;
var evaluationType=''; 

		for(var i=1;i<=NumLine;i++){
                    
                                  var DropshipCheck = document.getElementById("DropshipCheck"+i).checked;
                                  var serial_value = document.getElementById("serial_value"+i).value;
                                  inQty = document.getElementById("qty"+i).value;
                                  var seriallength=0;
                                 if(serial_value != ''){
                                    var resSerialNo = serial_value.split(",");
                                    var seriallength = resSerialNo.length;
                                 }
		 		evaluationType = document.getElementById("evaluationType"+i).value;
	
			//if(document.getElementById("sku"+i).value == ""){
				if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
					return false;
				}
				if(!ValidateForSimpleBlank(document.getElementById("description"+i), "Item Description")){
					return false;
				}
				if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}
                                
				

                                if(parseInt(seriallength) != parseInt(inQty) && evaluationType == 'Serialized' && DropshipCheck == false && parseInt(inQty) > 0)
                                    {
                                        alert("Please add "+inQty+" serial number.");
					document.getElementById("qty"+i).focus();
					return false;
                                    }
			//}
		 
			if(parseInt(document.getElementById("discount"+i).value) > parseInt(document.getElementById("price"+i).value))
			{
			   alert("Discount Should be Less Than Unit Price!");
			   return false;
			}
		}




		/*******************************/		 
		if(OrderID>0 && $("#PaymentTerm").val()=='Credit Card'){
			var TotalAmount = parseFloat($("#TotalAmount").val());
			var TransactionAmount = parseFloat($("#TransactionAmount").val());
			if(TotalAmount<=0){
				 alert("Invoice Total must be greater than 0.");
			   	return false;
			}

			if(TransactionAmount>0 && TotalAmount>0 && TotalAmount!=TransactionAmount){
				var TransactionDiff = TotalAmount - TransactionAmount;
				if(TransactionDiff>0){
					var ChargeRefundMsg = "An amount of "+TransactionDiff.toFixed(2)+" will be charged on credit card.\nAre you sure you want to authorize and charge the credit card?";
				}else{
					TransactionDiff = -TransactionDiff;
					var ChargeRefundMsg = "An amount of "+TransactionDiff.toFixed(2)+" will be refunded on credit card.\nAre you sure you want to refund this amount for credit card?";
				}

				/*confirmAlert("ChargeRefund","Credit Card", ChargeRefundMsg);
				if($("#ChargeRefund").val('0')){
					return false;
				}*/

				if(confirm(ChargeRefundMsg)){
					$("#ChargeRefund").val('1');
				}else{
					$("#ChargeRefund").val('0');
					return false;
				}				 
				
			}
		}
		/*******************************/
		



		 if(ModuleVal!=''){
			var Url = 'isRecordExists.php?SaleInvoiceID='+escape(ModuleVal)+'&editID='+OrderID;
			SendExistRequest(Url,SaleInvoiceID, "Invoice Number");
			return false;	
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
	}
	/*************************/
   }	
		
}


function SetGlEntryType(){
	//alert("fff");die;
	var GlEntryType = $("#GlEntryType").val();
	if(GlEntryType == "Single"){ 

	 $("#glAccountSingleRow").show(1000);
	 $("#glAccountSingleRowFld").show(1000);
	 $("#glAccountMultipleRow").hide(1000);

	 
	}else if(GlEntryType == "Multiple"){ 

		$("#glAccountSingleRow").hide(1000);
		$("#glAccountSingleRowFld").hide(1000);
		$("#glAccountMultipleRow").show(1000);
	}else{ 
		$("#glAccountMultipleRow").hide(1000);
		$("#glAccountSingleRow").hide(1000);
		$("#glAccountSingleRowFld").hide(1000);
	}	
    
}



function SetGLAccountLineItem(str)
{ 
	
    if(str == "LineItem"){ 
        $("#billingForm").show(500);
        $("#itemForm").show(500);
        $("#invoiceForm").show(500);
        $("#glForm").hide(500);
        $("#GLAccountLineItemType").val('LineItem');
        
        
    }else{ 
         $("#billingForm").hide(500);
         $("#itemForm").hide(500);
         $("#invoiceForm").hide(500);
         $("#glForm").show(500);
         $("#GLAccountLineItemType").val('GLAccount');
	setDefaultAccount(1);
    }
}



function setDefaultAccount(optOnLoad){
	 
	var CustCode = $("#CustCodeGL").val();
	if(optOnLoad!=1)$("#DefaultAccount").val('');	 
	sendParam='&action=CustomerInfo&CustCode='+CustCode+'&r='+Math.random();  
	
	$.ajax({
		type: "GET",
		async:false,
		url: "../sales/ajax.php",
		dataType : "JSON",
		data: sendParam,
		success: function (responseText) {  
		 
			var DefaultAccount = responseText['DefaultAccount'];
			
			if(optOnLoad!=1){
				$("#DefaultAccount").val(DefaultAccount);
				$("#IncomeTypeID").val(DefaultAccount);
				$("#AccountID1").val(DefaultAccount);
				var AccountID = $("#AccountID1").val();
				SetAccountName(AccountID,1);
			}
		}
	});
}



function AutoCompleteCustomer(elm){
	$(elm).autocomplete({
		source: "../jsonCustomer.php",
		minLength: 1
	});

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
			
var SendUrl = "&action=CustomerName&CustName="+inf+"&r="+Math.random();
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
			document.getElementById("SalesPerson").value=responseText["SalesPerson"];
			document.getElementById("SalesPersonID").value=responseText["SalesPersonID"];
			document.getElementById("OldSalesPersonID").value=responseText["SalesPersonID"];
		}else{
			document.getElementById("SalesPerson").value='';
			document.getElementById("SalesPersonID").value='';
			document.getElementById("OldSalesPersonID").value='';
			
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
    


	//SetTaxable();
	//ProcessTotal();
	//shipCarrier();
	/************************************/
	

		   
	}

   });
				


}






</script>




 <script>
$(function() {
	var ModuleID = '<?=$ModuleID555?>';
$( "#"+ModuleID ).tooltip({
	position: {
	my: "center bottom-2",
	at: "center+110 bottom+70",
		using: function( position, feedback ) {
			$( this ).css( position );

		}
	}
	});
});
</script>


<div class="message" align="center"><? if(!empty($_SESSION['mess_gen'])) {echo $_SESSION['mess_gen']; unset($_SESSION['mess_gen']); }?></div>
<form name="form1" id="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">


<table cellspacing="0" cellpadding="0" border="0" id="search_table" style="margin:0;"> 
	<tr>
		<td align="left"><b>GL Account/Line Item:</b></td>
		<td align="left">
			<?if($OrderID>0){ ?>
			<?=$GLAccountLineItem?>
			<input type="hidden" name="GLAccountLineItem" id="GLAccountLineItem" value="<?=$GLAccountLineItemType?>" readonly>
			<?}else{?>
			<select name="GLAccountLineItem" class="inputbox" id="GLAccountLineItem" onchange="Javascript: SetGLAccountLineItem(this.value);"> 
			<option value="GLAccount">GL Account</option>
			<option value="LineItem">Line Item</option>
			</select>
			<?}?>
		</td>
	</tr> 
</table>



<div <?=($GLAccountLineItemType == 'GLAccount')?(''):('style="display: none;"');?>>
<? include("includes/html/box/invoice_entry_gl.php");?>
</div>




<table width="100%" border="0" cellpadding="0" cellspacing="0"   >
<tr id="invoiceForm" style="display: none;">
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Search Customer</td>
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

  

<tr id="billingForm" style="display: none;">
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

<tr id="itemForm" style="display: none;">
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




				<? //include("includes/html/box/sale_order_item_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>


   <tr>
    <td  align="center">

<input type="hidden" name="TransactionAmount" id="TransactionAmount" class="inputbox" readonly value="<?=$CreditCardBalance?>" /> 

<input type="hidden" name="ChargeRefund" id="ChargeRefund" class="inputbox" readonly value="0" /> 



	 <input type="hidden" name="GLAccountLineItemType" id="GLAccountLineItemType" value="<?=$GLAccountLineItemType?>" readonly />
	 <input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
         <input type="hidden" name="GenerateInVoice" id="GenerateInVoice" value="1" />
		<input type="hidden" name="PrefixSale" id="PrefixSale" value="<?=$PrefixSale?>" />
        <input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />

	</td>
   </tr>
  
</table>

 </form>


<? } ?>




<script language="JavaScript1.2" type="text/javascript">
<? if($OrderID>0){ ?>
SetGLAccountLineItem('<?=$GLAccountLineItemType?>');
<? } ?>
</script>

