
<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	

?>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine = parseInt($("#NumLine").val());
	var NumLine1 = parseInt($("#NumLine1").val());
        var OrderID = parseInt($("#OrderID").val());

        var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;
        
        var EntryTypeGL = Trim(document.getElementById("EntryTypeGL")).value;
        var EntryFromGL = Trim(document.getElementById("EntryFromGL")).value;
        var EntryToGL = Trim(document.getElementById("EntryToGL")).value;
        
	var ModuleVal = Trim(document.getElementById("PoInvoiceID")).value;
	var ModuleValGL = Trim(document.getElementById("PoInvoiceIDGL")).value;
	var GLAccountLineItem = Trim(document.getElementById("GLAccountLineItem")).value;
        var TotalGlAmount  = Trim(document.getElementById("TotalGlAmount")).value;

        
       if(GLAccountLineItem == "GLAccount")
           {  
               
		          	/****** Abid ***********/
if(!ValidateOptionalScan(document.getElementById("UploadDocuments"), "Upload Documents")){
			return false;
		}
/****** End Abid ***********/


		if(ModuleValGL!='' || OrderID>0){
			if(!ValidateMandRange(document.getElementById("PoInvoiceIDGL"), "Invoice Number",3,20)){
				return false;
			}
		}



                if(EntryTypeGL == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFromGL, "Entry From")){        
                      return false;
                    }

                    /*if(!ValidateForSelect(frm.EntryToGL, "Entry To")){        
                        return false;
                    }
                    if(EntryFromGL >= EntryToGL) {
                        document.getElementById("EntryFromGL").focus();   
                        alert("End Date Should be Greater Than Start Date.");
                        return false;
                     }*/
                }
                
                    if(frm.PaidTo.value == "")
                    {
                        alert("Please Select Vendor.");
                        frm.PaidTo.focus();
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
                     /*if(frm.PaymentMethodGL.value == "")
                    {
                        alert("Please Select Payment Method.");
                        frm.PaymentMethodGL.focus();
                        return false;
                    }*/


		if(document.getElementById("Currency") != null){
			if(!ValidateForSelect(frm.CurrencyGL, "Currency")){        
			    return false;
			}	 
		}


                    if(frm.ExpenseTypeID.value == "0" && frm.GlEntryType.value == "Single")
                    {
                        alert("Please Select GL Account.");
                        frm.ExpenseTypeID.focus();
                        return false;
                    }
                    
                     if(frm.PaymentDate.value == "")
                    {
                        alert("Please Select Invoice Date.");
                        frm.PaymentDate.focus();
                        return false;
                    }

                    //CODE FOR PERIOD END SETTING
                    var BackFlag = 0;
                    var PaymentDate = Trim(document.getElementById("PaymentDate")).value;
                    var CurrentPeriodDate = Trim(document.getElementById("CurrentPeriodDate")).value;
                    var CurrentPeriodMsg = Trim(document.getElementById("CurrentPeriodMsg")).value;
                    var strBackDate = Trim(document.getElementById("strBackDate")).value;
                    var strSplitBackDate = strBackDate.split(",");
                    var backDateLength = strSplitBackDate.length;

                    var spliPDate = PaymentDate.split("-");
                    var StrspliPDate = spliPDate[0]+"-"+spliPDate[1];


                    for(var bk=0;bk<backDateLength;bk++)
                    {
                      if(strSplitBackDate[bk] == StrspliPDate)
                          {
                              BackFlag = 1;
                              break;
                          }

                    }


                    var CurrentPeriodDate = Date.parse(CurrentPeriodDate);
                    var PDate = Date.parse(PaymentDate);

                    if(PDate < CurrentPeriodDate && BackFlag == 0) 
                    {
                      alert("Sorry! You Can Not Enter Back Date Entry.\n"+CurrentPeriodMsg+".");
                      document.getElementById("PaymentDate").focus();
                      return false;
                    }

                    //END PERIOD SETTING  
                   /*  if(frm.BankAccount.value == "")
                    {
                        alert("Please Select Account.");
                        frm.BankAccount.focus();
                        return false;
                    } */
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


			 if((parseFloat(frm.Amount.value) != parseFloat(TotalGlAmount)))  
                        {
                               alert("Amount Should be Equal.");
                                frm.Amount.focus();
                                return false;
                        }


			
                  }



                   if(frm.PoInvoiceIDGL.value != '' && frm.AdjustInvoice.value != '1'){
                              var Url = "isRecordExists.php?PoInvoiceIDGL="+escape(frm.PoInvoiceIDGL.value)+'&editID='+escape(OrderID);
                              //alert(Url);return false;
                              SendExistRequest(Url,PoInvoiceIDGL, "InvoiceID");
                              return false;	
                    }else{
                      
                        ShowHideLoader('1','S');
                       	return true;
		   }
                   
               
           }
        
        else{ 

		if(document.getElementById("TaxRate") != null){
			document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
		}

         	if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    /*if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                    if(EntryFrom >= EntryTo) {
                      document.getElementById("EntryFrom").focus();   
                      alert("End Date Should be Greater Than Start Date.");
                      return false;
                     }*/
                }
       
	if(ModuleVal!='' || OrderID>0){
		if(!ValidateMandRange(document.getElementById("PoInvoiceID"), "Invoice Number",3,20)){
			return false;
		}
	}

 /*************************/
 

    if(document.getElementById("PaymentTerm") != null){
    	var PaymentTerm = $("#PaymentTerm").val().toLowerCase();
    	if(PaymentTerm == 'prepayment'){
    		if(!ValidateForSelect(frm.BankAccount, "Bank Account")){        
    		    return false;
    		}
    	}else if(PaymentTerm == 'credit card'){
		if(!ValidateForSelect(frm.CreditVendor, "Credit Card Vendor")){        
		    return false;
		}
	}
	}
    /*************************/

	


	if( ValidateForSelect(frm.SuppCode, "Vendor")
		&& ValidateForSelect(frm.PaymentTerm, "Payment Term")
		&& ValidateForSelect(frm.Currency, "Currency")
		//&& ValidateForSimpleBlank(frm.SuppCompany, "Company Name")
		//&& ValidateForSimpleBlank(frm.Address, "Address")
		//&& ValidateForSimpleBlank(frm.City, "City")
		//&& ValidateForSimpleBlank(frm.State, "State")
		//&& ValidateForSimpleBlank(frm.Country, "Country")
		//&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		//&& ValidateForSimpleBlank(frm.SuppContact, "Contact Name")
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateForSimpleBlank(frm.Landline,"Landline Number")
		//&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmailOpt(frm.Email)
		&& isEmailOpt(frm.wEmail)
	){
               

                var evaluationType =''; var serial_value = '';
		
		for(var i=1;i<=NumLine;i++){
			 if(document.getElementById("sku"+i) === null){
				var nullVal=1;
			}else{
 
			
                             //evaluationType = document.getElementById("evaluationType"+i).value;
                            var  qty = document.getElementById("qty"+i).value;
                             //serial_value = document.getElementById("serial_value"+i).value;

 
                                 var seriallength=0;
                                 if(serial_value != ''){
                                    var resSerialNo = serial_value.split(",");
                                    var seriallength = resSerialNo.length;
                                 }
                    
			
				if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
					return false;
				}
				if(!ValidateForSimpleBlank(document.getElementById("description"+i), "Item Description")){
					return false;
				}
				if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}
                                /*if(parseInt(seriallength) != parseInt(qty) && evaluationType == 'Serialized'  &&  parseInt(qty) > 0)
                                   {
                                       alert("Please add "+qty+" serial number.");
                                       document.getElementById("qty"+i).focus();
                                       return false;
                                   }*/
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}
				

			}
		}

	var TotalAmount = parseFloat($("#TotalAmount").val());
	if(TotalAmount<=0){
		alert("Grand Total must be greater than 0.");
		return false;
	}


                if(ModuleVal!='' ){
                        var Url = "isRecordExists.php?PoInvoiceID="+escape(ModuleVal)+"&editID="+escape(OrderID);
                        SendExistRequest(Url,"PoInvoiceID", "Invoice Number");
                        return false;	
                }else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
	}	
      }	
}





function setShipTo(){
	if(document.getElementById("OrderType").value=="Drop Ship"){
		$("#wCodeTitle").hide();
		$("#wCodeVal").hide();
		$("#wNameTitle").html('Customer');		
	}else{
		$("#wCodeTitle").show();
		$("#wCodeVal").show();
		$("#wNameTitle").html('Warehouse');		
	}

}

function SetGLAccountLineItem(str)
{
    if(str == "LineItem"){
        $("#vendorFrom").show(500);
        $("#itemFrom").show(500);
        $("#invoiceFrom").show(500);
        $("#glFrom").hide(500);
        $("#GLAccountLineItemType").val('LineItem');
        
        
    }else{
         $("#vendorFrom").hide(500);
         $("#itemFrom").hide(500);
         $("#invoiceFrom").hide(500);
         $("#glFrom").show(500);
         $("#GLAccountLineItemType").val('GLAccount');
	setDefaultAccount(1);
    }
}



function setDefaultAccount(optOnLoad){
	var SuppCode = $("#PaidTo").val();
	if(SuppCode!=''){
		if(optOnLoad!=1)$("#DefaultAccount").val('');

		$("#CreditCardVendor").val('');
		$("#TransferFundLink").hide();

	sendParam='&action=SupplierInfo&SuppCode='+SuppCode+'&r='+Math.random();  
	$.ajax({
		type: "GET",
		async:false,
		url: 'ajax.php',
		dataType : "JSON",
		data: sendParam,
		success: function (responseText) {  
			var DefaultAccount = responseText['AccountID'];
			var CreditCardVendor = responseText['CreditCard'];
			var Currency = responseText['Currency'];
			var SuppID = responseText['SuppID'];
			var OrderID = $("#OrderID").val();
			var FundTransferRef = $("#FundTransferRef").val();
			var Currency = responseText['Currency'];
			if(CreditCardVendor==1 && SuppID>0){				
				if(optOnLoad!=1){
					ShowTransferFundPopup();
				}else{
					$("#CreditCardVendor").val(1);
					$("#TransferFundLink").attr("href", "payVendorTransfer.php?SuppID="+SuppID+"&OrderID="+OrderID+"&Ref="+FundTransferRef);
					$("#TransferFundLink").show();
				}
			}

			if(optOnLoad!=1){
				$("#DefaultAccount").val(DefaultAccount);
				$("#ExpenseTypeID").val(DefaultAccount);
				$("#AccountID1").val(DefaultAccount);
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
}




function CheckInvoiceField(MSG_SPAN,FieldName,editID){
	document.getElementById(MSG_SPAN).innerHTML="";

	var AdjustInvoiceFlag = $("#AdjustInvoice").val();
	if(AdjustInvoiceFlag!=1){
		FieldLength = document.getElementById(FieldName).value.length;

		if(FieldLength>=3){
			document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';
			var Url = "isRecordExists.php?"+FieldName+"="+escape(document.getElementById(FieldName).value)+"&editID="+editID; //+"&CheckForAdjust=1"
			var SendUrl = Url+"&r="+Math.random(); 
			
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function RecieveAvailFieldRequest(){
				if (httpObj.readyState == 4) {
					
					/*if(httpObj.responseText==1) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Already Exist!</span>";
						
					}else */
					if(httpObj.responseText==1) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Already Exist!</span>";
						ShowAdjustPopup();
					}else if(httpObj.responseText==0) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>OK</span>";
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
				}
			};
			httpObj.send(null);

		}else if(FieldLength>0){
			document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>It should be minimum of 3 characters long.</span>";
		}

	}
}


function SetOpenTransferForm(){ 
	var SuppID = $("#PaidTo :selected").attr("suppid"); 
	var OrderID = $("#OrderID").val();
	var FundTransferRef = $("#FundTransferRef").val();
 
	var url  = "payVendorTransfer.php?SuppID="+SuppID+"&OrderID="+OrderID+"&Ref="+FundTransferRef;

	$("#CreditCardVendor").val(1);
	$("#TransferFundLink").attr("href", url);
	$("#TransferFundLink").show();
	//$("#TransferFundLink").fancybox().click();


	/*$("#EntryTypeGL").closest('td').hide();
	$("#EntryTypeGL").closest('td').prev('td').hide();
	$("#InvoiceCommentGL").closest('td').hide();
	$("#InvoiceCommentGL").closest('td').prev('td').hide();
	$("#VendorInvoiceDateGL").closest('td').hide();
	$("#VendorInvoiceDateGL").closest('td').prev('td').hide();
	$("#GlEntryType").closest('td').hide();
	$("#GlEntryType").closest('td').prev('td').hide();
	$("#ExpenseTypeID").closest('td').hide();
	$("#ExpenseTypeID").closest('td').prev('td').hide();
	$("#SubmitButton").hide();*/


	if(url!=''){
		$.fancybox({
		 'href' :url,
		 'type' : 'iframe',
		 'width': '900'		  
		 });
	}

}


function ShowAdjustPopup(){ 	
	$("#adjust_div").fancybox().click();
}

function ShowTransferFundPopup(){ 	
	$("#transfer_div").fancybox().click();
}

function SetAdjustForm(){
	$("#PoInvoiceIDGL").attr('class', 'disabled');
	$('#PoInvoiceIDGL').attr('readonly', 'true');
	$("#AdjustInvoice").val('1');
	$("#MsgSpan_InvoiceIDGL").html('');
	$("#adjustamountspan").html('Adjustment Amount');
	$("#adjdate").html('Adjustment Date');

	$('#EntryTypeGL').val('one_time');
	$('#EntryTypeGL').attr('disabled', 'true');
	$('#dIntervalGL').hide('');
	$('#dFromGL').hide('');   
}


function SetGlEntryType(){
	var GlEntryType = $("#GlEntryType").val();
	if(GlEntryType == "Single"){

	 $("#glAccountSingleRow").show(1000);
	 $("#glAccountSingleRowFld").show(1000);
	 $("#glAccountMultipleRow").hide(1000);

	 
	}else if(GlEntryType == "Multiple"){
		$("#glAccountMultipleRow").show(1000);
		$("#glAccountSingleRow").hide(1000);
		$("#glAccountSingleRowFld").hide(1000);
	}else{
		$("#glAccountMultipleRow").hide(1000);
		$("#glAccountSingleRow").hide(1000);
		$("#glAccountSingleRowFld").hide(1000);
	}	
    
}






function shipCarrier(){
	var method = document.getElementById("ShippingMethod").value;
	var spval = document.getElementById("spval").value;
	 
	var countryCode= '';
	var SendParam = 'action='+method+'&countryCode='+countryCode+'&shippval='+spval; 

	if(method==''){
		 document.getElementById("spmethod").style.display = 'none'; 
		document.getElementById("ShippingMethodVal").value=''; 
	}else{

		 $.ajax({
			type: "GET",
			url: '../ajax.php',
			data: SendParam,
			success: function (responseText) {
				if(responseText!=''){
					document.getElementById("spmethod").style.display = 'table-row';
					document.getElementById("ShippingMethodVal").innerHTML=responseText; 
				}else{
					 document.getElementById("spmethod").style.display = 'none'; 
					document.getElementById("ShippingMethodVal").value=''; 
				}
		
			}
		});	
 	}

}

function ResetSearchdd(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetVendorInfo(inf){
 
	if(inf == ''){
		//document.getElementById("form1").reset();

//document.getElementById("PaymentMethod").value='';
document.getElementById("PaymentTerm").value='';
document.getElementById("SuppCode").value='';
document.getElementById("SuppCompany").value='';
document.getElementById("SuppContact").value='';
document.getElementById("Address").value='';
document.getElementById("City").value='';
document.getElementById("State").value='';
document.getElementById("Country").value='';
document.getElementById("ZipCode").value='';
document.getElementById("Mobile").value='';
document.getElementById("Landline").value='';
document.getElementById("Email").value='';
document.getElementById("Currency").value='';
//alert(responseText["Taxable"]);
document.getElementById("tax_auths").value='';
document.getElementById("MainTaxRate").value='';
SetTaxable();

		return false;
	}
 
	/*var arrayOfStrings = inf.split('-');
	//alert(arrayOfStrings[0]);
 	inf = arrayOfStrings[1];*/

	ResetSearchdd();

var separator = '-';
var arrayOfStrings = inf.split(separator);

    //console.log('The original string is: "' + inf + '"');
 // console.log('The separator is: "' + separator + '"');
  //console.log('The array has ' + arrayOfStrings.length + ' elements: ' + arrayOfStrings.join(' / '));  
			//console.log(arrayOfStrings);

//alert(arrayOfStrings[0]);
var SendUrl = "&action=SupplierInfo&SuppCode="+escape(arrayOfStrings[0])+"&r="+Math.random(); 

				$.ajax({
					type: "GET",
					url: "../purchasing/ajax.php",
					data: SendUrl,
					dataType : "JSON",
					success: function (responseText) {
if(responseText["SuppID"]>0){
//document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
//document.getElementById("Currency").value=responseText["Currency"];
//document.getElementById("SuppCurrency").value=responseText["Currency"];




//alert(responseText["Currency"])
document.getElementById("SuppCode").value=responseText["SuppCode"];
document.getElementById("SuppCompany").value=responseText["CompanyName"];
document.getElementById("SuppContact").value=responseText["UserName"];
//document.getElementById("SuppCurrency").value=responseText["Currency"];
document.getElementById("Address").value=responseText["Address"];
document.getElementById("City").value=responseText["City"];
document.getElementById("State").value=responseText["State"];
document.getElementById("Country").value=responseText["Country"];
document.getElementById("ZipCode").value=responseText["ZipCode"];
document.getElementById("Mobile").value=responseText["Mobile"];
document.getElementById("Landline").value=responseText["Landline"];
document.getElementById("Email").value=responseText["Email"];
//if(document.getElementById("Currency") != null){
	//document.getElementById("Currency").value=responseText["Currency"];

//}

if(responseText["Currency"] != null){
	document.getElementById("Currency").value=responseText["Currency"];

}


//alert(responseText["Taxable"]);
document.getElementById("tax_auths").value=responseText["Taxable"];
if(responseText["Taxable"] =='Yes' ){
//SetTaxable(1);
	//document.getElementById("TaxRate").value=responseText["TaxRate"];
document.getElementById("MainTaxRate").value=responseText["TaxRate"];
SetTaxable();
freightSett(responseText["TaxRate"]);

}

}else{
	document.getElementById("SuppCode").value='';
	document.getElementById("SuppCompany").value='';
	document.getElementById("SuppContact").value='';
	document.getElementById("Address").value='';
	document.getElementById("City").value='';
	document.getElementById("State").value='';
	document.getElementById("Country").value='';
	document.getElementById("ZipCode").value='';
	document.getElementById("Mobile").value='';
	document.getElementById("Landline").value='';
	document.getElementById("Email").value='';	
}
        
	SelectPaymentTerm();					 


					}
				});

	}





function AutoCompleteVendor(elm){
	$(elm).autocomplete({
		source: "../jsonVendor.php",
		minLength: 1
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
	/************************* End ****************************/		

var ConfigCurrency = '<?=$Config["Currency"]?>';


function GetCurrencyRateGL(){	
	var CurrencyGL = $("#CurrencyGL").val();
	var CurrencyDate =  $("#PaymentDate").val();
	$("#ConversionRateGL").val('');
	$("#ConversionRateGL").addClass('loaderbox');
	if(ConfigCurrency!=CurrencyGL){	
		$("#ConversionRateGL").show();
		$("#ConversionRateGLLabel").show();		
		var SendUrl ='action=getCurrencyRateByModule&Module=AP&Currency='+escape(CurrencyGL)+'&CurrencyDate='+escape(CurrencyDate)+'&r='+Math.random(); 
		
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendUrl,
			success: function (responseText) { 
				$("#ConversionRateGL").removeClass('loaderbox');	
				$("#ConversionRateGL").val(responseText);						
			}

		});
	}else{
		$("#ConversionRateGL").removeClass('loaderbox');	
		$("#ConversionRateGL").val('1');
		$("#ConversionRateGL").hide();
		$("#ConversionRateGLLabel").hide();			
	}

	
}

</script>


<a class="fancybox fancybox.iframe" style="float:right;margin: 10px 6px 0px;" href="../sales/order_log.php?OrderID=<?=$_GET['edit']?>&module=PurchasesVInvoiceEntry" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()"></a>
	<table cellspacing="0" cellpadding="0" border="0" id="search_table" style="margin:0">
	<tbody>
            <tr>
                <td align="left"><b>GL Account/Line Item:</b></td>
             <td align="left">
		<?if($OrderID>0){?>
		<?=$GLAccountLineItem?>
		<input type="hidden" name="GLAccountLineItem" id="GLAccountLineItem" value="<?=$GlLine?>" readonly>
		<?}else{?>
              <select name="GLAccountLineItem" class="inputbox" id="GLAccountLineItem" onchange="Javascript: SetGLAccountLineItem(this.value);"> 
                        <option value="GLAccount">GL Account</option>
                        <option value="LineItem">Line Item</option>
                   </select>
		<?}?>

             </td>

	</tr>
			

</tbody>
        </table>
            
<br>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
    <input type="hidden" name="USER_LOG" id="USER_LOG" value="" />
		<input type="hidden" name="USER_LOG_NEW" id="USER_LOG_NEW" value="" />
    <!--FOR GL ACCOUNT-->

  <table width="100%"  border="0" align="center" id="glFrom"  cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

     <!---Recurring Start-->
        <?php   
        $arryRecurr = $arryPurchase;
        include("../includes/html/box/recurring_gl.php");
        
        ?>

        <!--Recurring End-->

<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>

    <tr>
        <td  align="right"   class="blackbold" width="15%"> Invoice Number # : </td>
        <td   align="left" width="35%">
<?if($OrderID>0){?>
<input name="PoInvoiceIDGL" type="text" class="inputbox" style="width:100px;" id="PoInvoiceIDGL" value="<?=$arryPurchase[0]['InvoiceID']?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_InvoiceIDGL');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_InvoiceIDGL','PoInvoiceIDGL','<?=$_GET['edit']?>');" oncontextmenu="return false" />
		 &nbsp;&nbsp;<span id="MsgSpan_InvoiceIDGL"></span>

<?}else{?>
		 <input name="PoInvoiceIDGL" type="text" class="inputbox" style="width:100px;" id="PoInvoiceIDGL" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_InvoiceIDGL');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckInvoiceField('MsgSpan_InvoiceIDGL','PoInvoiceIDGL','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" oncontextmenu="return false" />
		 &nbsp;&nbsp;<span id="MsgSpan_InvoiceIDGL"></span>

<? } ?>
		</td>
   
	<td  align="right" width="20%"  class="blackbold">Pay to Vendor : <span class="red">*</span></td>
	<td   align="left" >


	 <select name="PaidTo" class="inputbox" id="PaidTo" onchange="Javascript:setDefaultAccount(0);">
		  	<option value="">--- Select ---</option>
			<? 



for($i=0;$i<sizeof($arryVendorList);$i++) {
                             
        
                            ?>
			 <option suppid="<?=$arryVendorList[$i]['SuppID']?>" value="<?=$arryVendorList[$i]['SuppCode']?>" <?php if($arryOtherExpense[0]['PaidTo'] == $arryVendorList[$i]['SuppCode']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($arryVendorList[$i]["VendorName"]))?></option>
				<? } ?>
		</select> 

	<input type="hidden" name="DefaultAccount" id="DefaultAccount" value="" class="textbox">

	<script>
$("#PaidTo").select2();
</script> 


	</td>
	</tr>	
        
         <tr>
        <td align="right"   class="blackbold"> <span id="adjustamountspan">Invoice Amount :</span> <span class="red">*</span></td>
        <td align="left">
		<?php if(!empty($arryPurchase[0]['TotalAmount'])){$Amnt = $arryPurchase[0]['TotalAmount'];}else{$Amnt = "0.00";}?>
    	<input name="Amount" type="text" class="textbox" size="15" id="Amount" onkeypress="return isDecimalKeyNeg(event,this);"  value="<?=$Amnt?>" maxlength="20" autocomplete="off"/>  
		   
		</td>
    
	<td  align="right"   class="blackbold" >GL Entry Type : <span class="red">*</span></td>
	<td   align="left" >
	 <select name="GlEntryType" class="inputbox" id="GlEntryType" onchange="Javascript:SetGlEntryType();">
		  	<option value="">--- Select ---</option>
                        <option value="Single" <?php if($arryOtherExpense[0]['GlEntryType'] == 'Single'){echo "selected";}?>>Single</option>
                        <option value="Multiple" <?php if($arryOtherExpense[0]['GlEntryType'] == 'Multiple'){echo "selected";}?>>Multiple</option>
			 
		</select> 
	</td>
	</tr>	
     



 <tr>

<td  align="right"   class="blackbold" > Currency  :<span class="red">*</span> </td>
	<td   align="left" >
<? 
 
if(empty($arryPurchase[0]['Currency']))$arryPurchase[0]['Currency']= $Config['Currency'];

$arrySelCurrency=array();
if(!empty($arryCompany[0]['AdditionalCurrency'])) $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryPurchase[0]['Currency']) && !in_array($arryPurchase[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryPurchase[0]['Currency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);

if($arryPurchase[0]['Currency']==$Config['Currency']){
	$HideRate = 'style="display:none;"';
}else{
$HideRate ='';
}
 
?>
<select name="CurrencyGL" class="textbox" id="CurrencyGL"  style="width:100px;" onChange="Javascript: GetCurrencyRateGL();">

	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryPurchase[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>

<td  align="right"   class="blackbold" id="ConversionRateGLLabel" <?=$HideRate?>> Conversion Rate  : </td>
	<td   align="left" >
<input type="text" onkeypress="return isDecimalKey(event);" maxlength="20" size="8"  class="textbox"  value="<?=$arryPurchase[0]['ConversionRate']?>" id="ConversionRateGL" name="ConversionRateGL" <?=$HideRate?>>

</td>
 
      </tr>


	<tr>
            <!--td  align="right" class="blackbold">Payment Method : <span class="red">*</span></td>
		<td   align="left">
		  <select name="PaymentMethodGL" class="inputbox" id="PaymentMethodGL">
			<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?php if($arryOtherExpense[0]['PaymentMethod'] == $arryPaymentMethod[$i]['attribute_value']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td-->
                <td  align="right" class="blackbold"><span id="glAccountSingleRow" style="display: none;">GL Account : <span class="red">*</span></span></td>
		<td  align="left">
                    <span id="glAccountSingleRowFld" style="display: none;">
                    <select name="ExpenseTypeID" class="inputbox" id="ExpenseTypeID">
                    <option value="0">--- Select ---</option>
                    <? for($i=0;$i<sizeof($arryExpenseType);$i++) {?>
                    <option value="<?=$arryExpenseType[$i]['BankAccountID']?>" <?php if($arryOtherExpense[0]['ExpenseTypeID'] == $arryExpenseType[$i]['BankAccountID']){echo "selected";}?>>
                    &nbsp;<?=$arryExpenseType[$i]['AccountName']?> [<?=$arryExpenseType[$i]['AccountNumber']?>]
                    </option>
                    <? } ?>
                    </span>
                    </select> 

		</td>
	 
		
	</tr>  
	
	<tr>
		<td  align="right" valign="top"  class="blackbold"><span id="adjdate">Invoice Date  :</span><span class="red">*</span> </td>
		
		<td   align="left" valign="top" >
                    <script type="text/javascript">
			$(function() {
			$('#PaymentDate').datepicker(
			{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

			}
			);
			});
			</script>
		<?php 	
			
			if(!empty($arryOtherExpense[0]['PaymentDate'])){
				$paymentDate = $arryOtherExpense[0]['PaymentDate'];
			}else{
			 $arryTime = explode(" ",$Config['TodayDate']);
			 $paymentDate = $arryTime[0];
			}
			 
		?>
		 <input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$paymentDate;?>"  type="text" > 
                 
                 <input type="hidden" name="CurrentPeriodDate"  class="datebox" id="CurrentPeriodDate" value="<?php echo $CurrentPeriodDate;?>">
                 <input type="hidden" name="CurrentPeriodMsg"  class="datebox" id="CurrentPeriodMsg" value="<?php echo $IECurrentPeriod;?>">
                 <input type="hidden" name="strBackDate"  class="datebox" id="strBackDate" value="<?php echo $strBackDate;?>">
                &nbsp;&nbsp;<span class="red"><?//=$GLCurrentPeriod;?></span>
		</td>

		<td valign="top" align="right" class="blackbold"> Vendor Invoice Date :  </td>
		<td align="left">

		<script type="text/javascript">
			$(function() {
				$('#VendorInvoiceDateGL').datepicker(
					{
						showOn: "both",
						yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true

					}
				);

				$("#VendorInvoiceDateGL").on("click", function () { 
					 $(this).val("");
					}
				);
			});
		</script>
		<?php 	
			
			if($arryPurchase[0]['VendorInvoiceDate']>0){
				$VendorInvoiceDateGL = $arryPurchase[0]['VendorInvoiceDate'];
			}else{
			 	 
			 	$VendorInvoiceDateGL = '';
			}
			 
		?>
		 <input id="VendorInvoiceDateGL" name="VendorInvoiceDateGL" readonly="" class="datebox" value="<?=$VendorInvoiceDateGL;?>"  type="text" > 
                 

                   </td>
	 
	<!--td  align="right"   class="blackbold"> Paid From A/C :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="BankAccount" class="inputbox" id="BankAccount">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?php if($arryOtherExpense[0]['BankAccount'] == $arryBankAccount[$i]['BankAccountID']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> [<?=stripslashes($arryBankAccount[$i]['AccountNumber'])?>]</option>
				<? } ?>
		</select> 
	</td-->

	<td  align="right"   class="blackbold"> <a href="payVendorTransfer.php" class="fancybox grey_bt fancybox.iframe"  id="TransferFundLink" style="display:none" >Invoice Transfer</a> 


<input type="hidden" name="FundTransferRef" id="FundTransferRef" value="" class="inputbox" readonly>


</td>
	<td   align="left" >
	 

	</td>


	</tr>	



<tr>
		<td align="right" valign="top">	
	PO / Reference # :
		</td>
		<td valign="top">  <input type="text" name="PurchaseIDGL" id="PurchaseIDGL" value="<?=stripslashes($arryPurchase[0]['PurchaseID'])?>" class="inputbox" >  </td>	

		<td align="right" valign="top">	
	Invoice Comment :
		</td>
		<td >  <textarea id="InvoiceCommentGL" class="textarea" type="text" name="InvoiceCommentGL"><?=stripslashes($arryPurchase[0]['InvoiceComment'])?></textarea> </td>	

	</tr>



	<? if($arryOtherExpense[0]['GlEntryType'] == 'Single' && $arryPurchase[0]['AdjustmentAmount']!='0.00'){ ?>
	<tr>
		<td align="right" >	
	Adjustments : 
		</td>
		<td ><?
		
				echo ''.$arryPurchase[0]['AdjustmentAmount'];
		
	?> </td>	
	</tr>
	<? } ?>	
   <!--tr>
        <td  align="right" valign="top"   class="blackbold">Reference No#  : </td>
        <td   align="left" valign="top">
		 <input name="ReferenceNo" type="text" class="inputbox" id="ReferenceNo" value="<?=$arryOtherExpense[0]['ReferenceNo']?>"  />
		</td>
    
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><textarea id="Comment" class="textarea" type="text" name="Comment"><?=$arryOtherExpense[0]['Comment']?></textarea></td>
	</tr-->


	

        <tr id="glAccountMultipleRow" style="display: none;">
			<td colspan="4">
				<? 	include("includes/html/box/add_multi_gl.php");?>
			</td>
		</tr>
	 
</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
	    <input type="hidden" name="ExpenseID" id="ExpenseID" value="<?=$_GET['edit'];?>">
	
	</td>
	</tr>
</table>
<? if($arryPurchase[0]['InvoiceEntry']==2){?>
<script language="JavaScript1.2" type="text/javascript">
  SetGlEntryType();
</script>    
<? } ?>

 <!--END FOR GL ACCOUNT--->
  <table width="100%" border="0" cellpadding="5" cellspacing="0" id="invoiceFrom" style="display: none;"  class="borderall">	 

<tr>
	 <td colspan="4" align="left" class="head">Vendor</td>
</tr>

<tr>
			<td  align="right"   class="blackbold" width="20%"> Vendor Code  :<span class="red">*</span> </td>
			<td   align="left" >
	<!--input name="SuppCode" type="text" class="disabled" style="width:90px;" id="SuppCode" value="<?php echo stripslashes($arryPurchase[0]['SuppCode']); ?>"  maxlength="40" readonly /-->
<input name="SuppCode" type="text" class="textbox" style="width:90px;" autocomplete="off"  onclick="Javascript:AutoCompleteVendor(this);" onblur="SetVendorInfo(this.value);" id="SuppCode" value="<?php echo stripslashes($arryPurchase[0]['SuppCode']); ?>"    />
	<a class="fancybox fancybox.iframe" href="SupplierList.php" ><?=$search?></a>

			</td>
	 </tr>
 <tr>
	 <td colspan="4" align="left" class="head">Invoice Information</td>
</tr>
  <!---Recurring Start-->
        <?php   
        //$arryRecurr = $arrySale;
        //include("../includes/html/box/recurring_2column.php");
        include("../includes/html/box/recurring_2column_sales.php");
        
        ?>

        <!--Recurring End-->
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" width="36%">
<? if(!empty($_GET['edit'])) {?>
	<input name="PoInvoiceID" type="text" class="datebox" id="PoInvoiceID" value="<?=$arryPurchase[0]['InvoiceID']?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','PoInvoiceID','<?=$_GET['edit']?>');" oncontextmenu="return false" />
	<span id="MsgSpan_ModuleID"></span>
<? }else{?>
	<input name="PoInvoiceID" type="text" class="datebox" id="PoInvoiceID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','PoInvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" oncontextmenu="return false" />
	<span id="MsgSpan_ModuleID"></span>
<? } ?>
</td>

        <td  align="right"  class="blackbold" >Invoice Date  : </td>
        <td   align="left">
<script type="text/javascript">
$(function() {
	$('#PostedDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$PostedDate = ($arryPurchase[0]['PostedDate']>0)?($arryPurchase[0]['PostedDate']):($arryTime[0]); 
?>
<input id="PostedDate" name="PostedDate" readonly="" class="datebox" value="<?=$PostedDate?>"  type="text" > 

		</td>
      </tr>  
      
      
      
 <tr>
        <td  align="right"   class="blackbold" >Item Received Date  :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ReceivedDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?($arryPurchase[0]['ReceivedDate']):($arryTime[0]); 
?>
<input id="ReceivedDate" name="ReceivedDate" readonly="" class="datebox" value="<?=$ReceivedDate?>"  type="text" > 


</td>
		<td  align="right"   class="blackbold" >Vendor Invoice Date  :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#VendorInvoiceDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
	$("#VendorInvoiceDate").on("click", function () { 
		 $(this).val("");
		}
	);
});
</script>

<? 	 
$VendorInvoiceDate = ($arryPurchase[0]['VendorInvoiceDate']>0)?($arryPurchase[0]['VendorInvoiceDate']):(''); 
?>
<input id="VendorInvoiceDate" name="VendorInvoiceDate" readonly="" class="datebox" value="<?=$VendorInvoiceDate?>"  type="text" > 


</td>
  
      </tr>
      

<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>

      <tr>

	<td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
	<? if($_SESSION['AdminType'] != 'admin' && $FullAcessLabel!=1){ ?>
		<input type="text" name="PaymentTerm" id="PaymentTerm" maxlength="30" readonly class="disabled_inputbox"  value="<?=stripslashes($arryPurchase[0]['PaymentTerm'])?>">
	<? }else{ ?>
		  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
					if($arryPaymentTerm[$i]['termType']==1){
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
						}else{
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
						}
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arryPurchase[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
	<? } ?>
		</td>
        <!--td  align="right" class="blackbold">Payment Method  :</td>
        <td   align="left">
		  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryPurchase[0]['PaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td-->
 
 
</tr>


<tr id="BankAccountTR">
		<td  align="right" class="blackbold">Bank Account :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
		
	<select name="BankAccount" class="inputbox" id="BankAccount" >
		<option value="">--- Select ---</option>
		<? 
		for($i=0;$i<sizeof($arryBankAccount);$i++) {
		$selected='';
		if($_GET['edit']>0){ 
			
			if($arryBankAccount[$i]['BankAccountID']==$arryPurchase[0]['AccountID']) $selected='Selected'; 
		}else if($arryBankAccount[$i]['DefaultAccount']==1){
			$selected='Selected';
		}

		?>
		<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?=$selected?>>
		<?=$arryBankAccount[$i]['AccountName']?>  [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
		<? } ?>		
	</select> 

		</td>
</tr>



<tr id="CreditCardVendorTR">
		<td  align="right" class="blackbold">Credit Card Vendor :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
		
	<select name="CreditVendor" class="inputbox" id="CreditVendor" >
		 <option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryCreditCardVendor);$i++) {     ?>
			 <option value="<?=$arryCreditCardVendor[$i]['SuppCode']?>" <?php if($arryPurchase[0]['CreditCardVendor'] == $arryCreditCardVendor[$i]['SuppCode']){echo "selected";}?>>
			 <?=stripslashes($arryCreditCardVendor[$i]["VendorName"])?></option>
				<? } ?>
	</select> 
<script>
$("#CreditCardVendor").select2();
</script> 
		</td>
</tr>

 
<!--<tr>
        <td  align="right"   class="blackbold">Assigned To  : </td>
        <td   align="left">

<input name="EmpName" id="EmpName" type="text" class="disabled" style="width:250px;" value="<?=$arryPurchase[0]['AssignedEmp']?>" readonly />
<input name="EmpID" id="EmpID" type="hidden" class="disabled" value="<?=$arryPurchase[0]['AssignedEmpID']?>"  maxlength="20" readonly />
<input name="OldEmpID" id="OldEmpID" type="hidden" class="disabled" value="<?=$arryPurchase[0]['AssignedEmpID']?>"  maxlength="20" readonly />

<a class="fancybox fancybox.iframe" href="../purchasing/EmpList.php?dv=4" ><?=$search?></a>	  
		  
		   </td>
                   <td valign="top" align="right" class="blackbold">Reference No#  :</td>
                   <td valign="top" align="left">
                    <input type="text" name="ReferenceNo" class="inputbox" id="ReferenceNo" value="">
                </td>
      </tr>-->
<tr>
    <td  align="right" class="blackbold">Shipping Carrier  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod"  onchange="Javascript:shipCarrier();">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryPurchase[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>

	<td  align="right"   class="blackbold" valign="top" > Currency  :<span class="red">*</span> </td>
	<td   align="left" valign="top" >
<?

 if(empty($arryPurchase[0]['Currency']))$arryPurchase[0]['Currency']= $Config['Currency'];

$arrySelCurrency=array();
if(!empty($arryCompany[0]['AdditionalCurrency']))$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryPurchase[0]['Currency']) && !in_array($arryPurchase[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryPurchase[0]['Currency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);

 ?>
<select name="Currency" class="inputbox" id="Currency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryPurchase[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>
</tr>

<tr id="spmethod" style="display:none;">
	<td align="right" class="blackbold">Shipping Method : </td>
	<td align="left">
	<select name="ShippingMethodVal" class="inputbox" id="ShippingMethodVal">
	</select>
	<input type="hidden" name="spval" id="spval" value="<?=$arryPurchase[0]['ShippingMethodVal'];?>">

	</td>
</tr>
<script language="JavaScript1.2" type="text/javascript">
shipCarrier();
</script>
 
 	<tr>

			<td  align="right"  valign="top" class="blackbold" > Comments  : </td>
			<td  valign="top" align="left" >
                        <textarea name="InvoiceComment" type="text" class="textarea" id="InvoiceComment"><?=stripslashes($arryPurchase[0]['InvoiceComment'])?></textarea>
		</td>

<?php
// Abid //
 if($arryCurrentLocation[0]['country_id']==106){ ?>

	<td valign="top" align="right" class="blackbold">Upload Documents :</td>
		<td  align="left" valign="top" >
	<input name="UploadDocuments" type="file" class="inputbox" id="UploadDocuments" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
               	<?=SUPPORTED_SCAN_DOC?>
	<? 
	 
        if(IsFileExist($Config['P_DocomentDir'],$arryPurchase[0]['UploadDocuments']) ){

	$OldUploadDocuments = $arryPurchase[0]['UploadDocuments'];
 ?>
	<br><br>
	<input type="hidden" name="OldUploadDocuments" value="<?=$OldUploadDocuments?>">
	<div id="UploadDocumentsDiv">
	<?=$arryPurchase[0]['UploadDocuments']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryPurchase[0]['UploadDocuments']?>&folder=<?=$Config['P_DocomentDir']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['P_DocomentDir']?>', '<?=$arryPurchase[0]['UploadDocuments']?>','UploadDocumentsDiv')"><?=$delete?></a>
	</div>
<? } 
// End //
?>
               
                </td>
	
<?php }else{

echo '<input name="UploadDocuments" id="UploadDocuments" type="hidden" class="disabled" readonly style="width:90px;"  value=""  maxlength="20" />';


} ?>
	</tr>

</table>  
    
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr id="vendorFrom" style="display: none;">
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"   >
		<tr>
			<td align="left" valign="top" width="50%"  class="borderpo"><? include("includes/html/box/po_supp_form.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top"  class="borderpo"><? include("includes/html/box/po_warehouse_form.php");?></td>
		</tr>
	</table>

</td>
</tr>



<tr>
			 <td align="right">
		<?
		
		$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
		//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
		?>	 
			 </td>
		</tr>

<tr id="itemFrom" style="display: none;">
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" ><?=LINE_ITEM?></td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/po_item_invoice_entry_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($HideSubmit != 1){ ?>

   <tr>
    <td  align="center">
        <input type="hidden" name="GLAccountLineItemType" id="GLAccountLineItemType" value="<?=$GLAccountLineItemType?>" readonly />
        <input type="hidden" name="ReceiveOrderID" id="ReceiveOrderID" value="1" readonly />
        <input type="hidden" name="OrderID" id="OrderID" value="<?=$OrderID?>" readonly />
        <input type="hidden" name="PrefixPO" id="PrefixPO" value="<?=$PrefixPO?>" />
        <input name="Taxable" id="Taxable" type="hidden" value="<?=stripslashes($arryPurchase[0]['Taxable'])?>">
        <input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />

<input type="hidden" name="AdjustInvoice" id="AdjustInvoice" value="0" readonly />
<input type="hidden" name="CreditCardVendor" id="CreditCardVendor" value="0" readonly />

	</td>
   </tr>



<? } ?>
  
</table>

 </form>


<? } ?>


<? 	include("includes/html/box/adjust_form.php");

	include("includes/html/box/transfer_popup.php");
?>

<script language="JavaScript1.2" type="text/javascript">

function SelectPaymentTerm(){
	var PaymentTerm = $("#PaymentTerm").val().toLowerCase();;
 
	/**********************/
	if(PaymentTerm == 'prepayment'){
		 $("#BankAccountTR").show();
		 $("#CreditCardVendorTR").hide();
	}else if(PaymentTerm == 'credit card'){
		$("#CreditCardVendorTR").show();
		$("#BankAccountTR").hide();
	}else{
		 $("#BankAccountTR").hide();	
		 $("#CreditCardVendorTR").hide();  
	}
	
}



<? if($OrderID>0){ ?>
SetGLAccountLineItem('<?=$GLAccountLineItemType?>');
<? } ?>


$(document).ready(function() {
	<? if($TransactionID>0){ ?>	
	SetOpenTransferForm();
	<? } ?>


 	$('#yesAdj').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		//$(this).parent().hide();
		$.fancybox.close();
		SetAdjustForm();
	});


	$('#cancelAdj').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		//$(this).parent().hide();
		$.fancybox.close();
	});



	$('#yesTrf').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		//$(this).parent().hide();
		$.fancybox.close();
		SetOpenTransferForm();
	});


	$('#cancelTrf').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		//$(this).parent().hide();
		$.fancybox.close();
	});



  	$(".slnoclass").fancybox({
		'width'         : 300
	 });
		 
         $("#TransferFundLink").fancybox({
		'width'         : 950
	 });


jQuery("#PaymentTerm").change(function(){
		
		   SelectPaymentTerm();
});

SelectPaymentTerm();
//added by nisha  for phone no pattern
	$("#Mobile,#Landline,#wMobile,#wLandline").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //alert("Digits Only");
               return false;
    }
    

   });	

});

</script>

