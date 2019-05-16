/*************************************/
function SetGLAccountLineItem(str)
{ 
	
    /*if(str == "LineItem"){ 
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
    }*/

    if(str == "LineItem"){ 
        $("#lineItemForm").show(1000);
        $("#glForm").hide(1000);
        $("#GLAccountLineItemType").val('LineItem');        
    }else{         
         $("#lineItemForm").hide(1000);
         $("#glForm").show(1000);
         $("#GLAccountLineItemType").val('GLAccount');
	 //setDefaultAccount(1);
    }

}
/*************************************/

function setDefaultAccount(optOnLoad){
	 
	var CustCode = $("#CustCodeGL").val();
	if(optOnLoad!=1)$("#DefaultAccount").val('');	 
	sendParam='&action=CustomerInfo&CustCode='+CustCode+'&r='+Math.random();  

	 

	if(CustCode!=''){
		$("#glCreditCardRow").show();
	}else{	
		$("#glCreditCardRow").hide();
	}


	$.ajax({
		type: "GET",
		async:false,
		url: "../sales/ajax.php",
		dataType : "JSON",
		data: sendParam,
		success: function (responseText) {  
		 
			var DefaultAccount = responseText['DefaultAccount'];
			var Currency = responseText['Currency'];
			//var PaymentTerm = responseText['PaymentTerm'];

			if(optOnLoad!=1){
				$("#DefaultAccount").val(DefaultAccount);
				$("#IncomeTypeID").val(DefaultAccount);
				$("#AccountID1").val(DefaultAccount);
				/*
				$("#PaymentTermGL").val(PaymentTerm); 
				if(PaymentTerm.toLowerCase() == 'credit card'){
					$("#glCreditCardRow").show();	
				}*/
				

				var AccountID = $("#AccountID1").val();
				SetAccountName(AccountID,1);
 
				if(Currency!=''){
					$("#CurrencyGL").val(Currency);
					GetCurrencyRateGL();
				}

				
			}
		}
	});
}


/************************* Sanjiv ****************************/
	function hashDiff(h1, h2) {
		  var d = {};
		  for (k in h2) {
		    if (h1[k] !== h2[k]) d[k] = h1[k];
		  }
		  return d;
		}


		function convertSerializedArrayToHash(a) { 
		  var r = {}; 
		  for (var i = 0;i<a.length;i++) { 
		    r[a[i].name] = a[i].value;
		  }
		  return r;
		}

		$(function() {
			  var startItems = convertSerializedArrayToHash( $('form[name="form1"] [type!="hidden"]').serializeArray() ); 
			  $('form[name="form1"]').submit(function () { 
			    var currentItems = convertSerializedArrayToHash($('form[name="form1"] [type!="hidden"]').serializeArray());
			    var itemsToSubmit = hashDiff( startItems, currentItems);
			    var NewItemsToSubmit = hashDiff( currentItems, startItems);
					$("#USER_LOG").val(JSON.stringify(itemsToSubmit));
					$("#USER_LOG_NEW").val(JSON.stringify(NewItemsToSubmit));
			  });
			});


$(function() {
	$("#Mobile,#Landline,#ShippingMobile,#ShippingLandline").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //alert("Digits Only");
               return false;
    }
    

   });
});
/************************* End ****************************/
$(function() {
	var ModuleID = '';
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

/*************************************/
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
	//var EntryToGL = Trim(document.getElementById("EntryToGL")).value;
	var TotalGlAmount  = Trim(document.getElementById("TotalGlAmount")).value;

/***added code by sachin*/
	
  if(document.getElementById("validfileval").value==1){
  	alert('Only following filetypes are supported:\n1) pdf\n2) doc\n3) docx\n4) ppt\n5) pptx\n6) xls\n7) xlsx\n8) rtf\n9) txt');
     return false;
  }
	/***added code by sachin*/

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

                   /* if(!ValidateForSelect(frm.EntryToGL, "Entry To")){        
                        return false;
                    }
                    if(EntryFromGL >= EntryToGL) {
                        document.getElementById("EntryFromGL").focus();   
                        alert("End Date Should be Greater Than Start Date.");
                        return false;
                     }*/
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
                 
		
    	        if(document.getElementById("CurrencyGL") != null){
			if(!ValidateForSelect(frm.CurrencyGL, "Currency")){        
			    return false;
			}			 
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


		/*******************************/		 
		if(OrderID>0 && $("#PaymentTermGL").val()=='Credit Card'){
			var TotalAmount = parseFloat($("#Amount").val());
			var TransactionAmount = parseFloat($("#TransactionAmount").val());
			if(TotalAmount<=0){
				 alert("Invoice Amount must be greater than 0.");
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


	 if(document.getElementById("CustomerCurrency") != null){
		if(!ValidateForSelect(frm.CustomerCurrency, "Currency")){        
		    return false;
		}			 
	}


	if( PaymentTerm=='credit card'){
		var CreditCardType = $("#CreditCardType").val();
		var CreditCardNumber = $("#CreditCardNumber").val();
		if(CreditCardNumber == '' || CreditCardType == ''){
			alert("Please Select Credit Card");
			frm.PaymentTerm.focus();
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
var comType = document.getElementById("comType").value;

		

		for(var i=1;i<=NumLine;i++){
                   	if(document.getElementById("sku"+i) === null){
				var nullVal=1;
			}else{
  
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
                                
				

                                if(parseInt(seriallength) != parseInt(inQty) && evaluationType == 'Serialized' && DropshipCheck == false && parseInt(inQty) > 0 &&  comType !=1)
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




/*************************************/
