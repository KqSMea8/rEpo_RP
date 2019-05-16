/*************************************/
function EnableAmount(){
	var  Amount = $("#ReceivedAmount").val();  
	if(Amount!=''){
		$("#CustomerName").attr("disabled",false);
		//$("#CustomerName").attr("class","inputbox");	
		$("#PaidTo").attr("disabled",false);
		$("#PaidTo").attr("class","inputbox");
		$("#Method").attr("disabled",false);
		$("#Method").attr("class","inputbox");	
		$("#Date").attr("disabled",false);
		$("#Date").attr("class","datebox");
		$("#ReferenceNo").attr("disabled",false);
		$("#ReferenceNo").attr("class","inputbox");	
		$("#Comment").attr("disabled",false);
		$("#Comment").attr("class","inputbox");	
		$("#save_payment").attr("disabled",false);			
	}else{
		$("#CustomerName").attr("disabled",true);
		//$("#CustomerName").attr("class","disabled_inputbox");
		$("#PaidTo").attr("disabled",true);
		$("#PaidTo").attr("class","disabled_inputbox");
		$("#Method").attr("disabled",true);
		$("#Method").attr("class","disabled_inputbox");
		$("#Date").attr("disabled",true);
		$("#Date").attr("class","datebox disabled");
		$("#ReferenceNo").attr("disabled",true);
		$("#ReferenceNo").attr("class","disabled_inputbox");	
		$("#Comment").attr("disabled",true);
		$("#Comment").attr("class","disabled_inputbox");
		$("#save_payment").attr("disabled",true);
	}
} 
/*************************************/
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
/*************************************/
function validateForm(frm){

	var ReceivedAmount = frm.ReceivedAmount.value;	
	var CmpID = frm.CmpID.value;	
	if(frm.ReceivedAmount.value == ""){
	      alert("Please Enter Total Deposit Amount.");
	      frm.ReceivedAmount.focus();
	      return false;
	}     
	/*if(frm.EntryType.value == ""){
		alert("Please Select Entry Type.");
		frm.EntryType.focus();
		return false;
	}        
	if(frm.EntryType.value == "GL Account"){
		if(frm.GLCode.value == ""){
		    alert("Please Select GL Account.");
		    frm.GLCode.focus();
		    return false;
		}
	}*/
	

	 if(CmpID == "31" || CmpID == "76"){     
		if(!ValidateForSimpleBlank(frm.ReferenceNo, "Reference No")){
			return false;
		} 
	 }


	


	if(frm.PaidTo.value == ""){
		   alert("Please Select Deposit Account.");
		   frm.PaidTo.focus();
		   return false;
	}
        if(frm.Method.value == ""){
                alert("Please Select Payment Method.");
                frm.Method.focus();
                return false;
        }
        
        if(frm.Method.value == "Check"){     
		if(!ValidateForSimpleBlank(frm.CheckNumber, "Check Number")){
			return false;
		}           
                /*if(frm.CheckBankName.value == ""){
                    alert("Please Enter Bank Name.");
                    frm.CheckBankName.focus();
                    return false;
                }
                if(frm.CheckFormat.value == ""){
                    alert("Please Select Check Format.");
                    frm.CheckFormat.focus();
                    return false;
                }*/
                
        }





	var TotalSavedAmount=0;
	if(document.getElementById("total_saved_payment") != null){
		TotalSavedAmount = parseFloat($("#total_saved_payment").val());
	}
	if(parseFloat(ReceivedAmount) != parseFloat(TotalSavedAmount)){
		alert("Total Deposit Amount and Total Payment Should be Same.");	
		return false;
	} 


        var totalInvoice = 0;
	if(document.getElementById("totalInvoice") != null){
		totalInvoice = document.getElementById("totalInvoice").value;
		for(var i=1; i <= totalInvoice;i++){
		    var payment_amnt = parseFloat(document.getElementById("payment_amnt_"+i).value);
		    var invoice_amnt = parseFloat(document.getElementById("invoice_amnt_"+i).value);
		    if( payment_amnt > 0 &&  payment_amnt > invoice_amnt){
		         alert("You Can Receive Only "+document.getElementById("invoice_amnt_"+i).value);
		         document.getElementById("payment_amnt_"+i).focus();
			 return false;
		    } 
		}     
      }
        

 
         //CODE FOR PERIOD END SETTING
        var BackFlag = 0;
        var PDate = Trim(document.getElementById("Date")).value;
        var CurrentPeriodDate = Trim(document.getElementById("CurrentPeriodDate")).value;
        var CurrentPeriodMsg = Trim(document.getElementById("CurrentPeriodMsg")).value;
        var strBackDate = Trim(document.getElementById("strBackDate")).value;
        var strSplitBackDate = strBackDate.split(",");
        var backDateLength = strSplitBackDate.length;
        
        var spliPDate = PDate.split("-");
        var StrspliPDate = spliPDate[0]+"-"+spliPDate[1];        
        
	for(var bk=0;bk<backDateLength;bk++){
		if(strSplitBackDate[bk] == StrspliPDate){
			BackFlag = 1;
			break;
		}
	}       
        
        var CurrentPeriodDate = Date.parse(CurrentPeriodDate);
        var PDate = Date.parse(PDate);
       
        if(PDate < CurrentPeriodDate && BackFlag == 0){
		alert("Sorry! You Can Not Enter Back Date Entry.\n"+CurrentPeriodMsg+".");
		document.getElementById("Date").focus();
		return false;
        }
            
	

          //END PERIOD SETTING  
        //var TotalPaidAmount = document.getElementById("total_payment").value;
       /*if(parseFloat(ReceivedAmount) != parseFloat(TotalPaidAmount) || parseFloat(ReceivedAmount) != parseFloat(TotalPaidAmount) ){
		alert("Total Deposit Amount and Total Payment Should be Same.");
		frm.ReceivedAmount.focus();
		return false;
	}  */   

	 
       /* if(document.getElementById("totalInvoice") != null){   
		var ContraAcnt = document.getElementById("ContraAcnt").value;
		if(ContraAcnt==1){
			var totalOpenBalance = document.getElementById("totalOpenBalance").value;
			var TotalVendorPaidAmount = document.getElementById("total_payment_ventor").value;
			var totalVendorOpenBalance = document.getElementById("totalOpenBalanceVendor").value;
			var totalVendorInvoice = 0;
			totalVendorInvoice = document.getElementById("totalInvoiceVendor").value;
	
		 	for(var j=1; j <= totalVendorInvoice;j++){
			    
			    var payment_vendor_amnt = parseFloat(document.getElementById("payment_vendor_amnt_"+j).value);
			    var invoice_vendor_amnt = parseFloat(document.getElementById("vendorinvoice_amnt_"+j).value);
			    if( payment_vendor_amnt > 0 &&  payment_vendor_amnt > invoice_vendor_amnt){
				 alert("You Can Pay Only "+document.getElementById("vendorinvoice_amnt_"+j).value);
				 document.getElementById("payment_vendor_amnt_"+j).focus();
				 return false;
			    } 
			}

			 

		}  
	}*/
    
	window.onbeforeunload = null;
	$("#CustomerName").attr("disabled",false);
	ShowHideLoader('1','P');	
}
/*************************************/
function ChangeConversionrate(line){

	var ConversionRate = document.getElementById("ConversionRate_"+line).value;
	var TotalInvoiceAmount=document.getElementById("TotalInvoiceAmountOld_"+line).value;
	var receivedAmnt=document.getElementById("payment_amnt_"+line).value;	


	var Totalamount=TotalInvoiceAmount*ConversionRate;
	Totalamount = parseFloat(Totalamount).toFixed(2);
	document.getElementById("TotalInvoiceAmount_"+line).value=Totalamount;


	var Openbalance = Totalamount-receivedAmnt;
	Openbalance = parseFloat(Openbalance).toFixed(2);

	document.getElementById("invoice_amnt_"+line).value=Openbalance;
	document.getElementById("openBalance_"+line).value=Openbalance ;
}
/*************************************/
function ChangeVendorConversionrate(line){
	var ConversionRate = document.getElementById("VendorConversionRate_"+line).value;
	var InvoiceAmount=document.getElementById("TotalVendorAmountOld_"+line).value;	
	var paidAmnt=document.getElementById("paidVendorAmnt_"+line).value;	
	var PayAmount=document.getElementById("payment_vendor_amnt_"+line).value;

	var Totalamount=InvoiceAmount*ConversionRate;
	
	Totalamount = parseFloat(Totalamount).toFixed(2);
	document.getElementById("TotalVendorInvoiceAmount_"+line).value=Totalamount;

	var Openbalance = Totalamount-paidAmnt;
	
	Openbalance = parseFloat(Openbalance).toFixed(2);
	document.getElementById("vendorinvoice_amnt_"+line).value=Openbalance;
	document.getElementById("vendoropenBalance_"+line).value=Openbalance-PayAmount;

}
/*************************************/
function ChangeAmount(){
	var  Amount = $("#ReceivedAmount").val();
	var  OldAmount = $("#ReceivedAmountOld").val();
	var custID = $("#CustomerName").val();
	var ConfirmContra = $("#ConfirmContra").val();
	$("#ReceivedAmountOld").val(Amount);
	if(OldAmount!='' && Amount!=OldAmount && custID!=''){
		SetCustomerInvoice(custID,ConfirmContra);
	}
}
/*************************************/
function checkContra(custID){
	$("#save_payment").hide();
	$("#glList").hide();
	$("#invoiveList").html(''); 
	var ContraFlag = $("#ContraFlag").val();  
		
	if(custID>0){
			if(ContraFlag==''){
					$("#invoiveList").html('<strong>Loading.....</strong>'); 
					var sendParam='&action=CheckContraAR&custID='+escape(custID)+'&r='+Math.random();  
					$.ajax({
						type: "GET",
						async:false,
						url: 'ajax_receipt.php',
						data: sendParam,
						success: function (responseText) {  
							if(responseText>0){
								confirmContra(custID);
							}else{
								SetCustomerInvoice(custID,0);
							}
						}
					});
			}else{
				SetCustomerInvoice(custID,0);
			}
	}
}

/*************************************/

function confirmContra(custID){
	$("#ConfirmContra").val(0);
	if(custID!=''){
		$("#dialog-modal2").html("Do you want to select contra account.");
		$("#dialog-modal2").dialog(
		{
		title: "Contra Account ",
			modal: true,
			width: 400,
			buttons: {
				"Yes": function() {
					//var luink =  $(obj).attr('href');
					//location.href = luink;
					$("#ConfirmContra").val(1);
						SetCustomerInvoice(custID,1);
					 $(this).dialog("close");
					 ShowHideLoader(1,'P');
				},
				"No": function() {
					 $(this).dialog("close");
		SetCustomerInvoice(custID,0);
				}
			}

		});

		return false;
	}else{
		SetCustomerInvoice(custID,0);
	}
}

/*************************************/

function SetCustomerInvoice(custID,con){
	
	ShowHideLoader('1','L');
	$("#invoiveList").html('<strong>Loading.....</strong>'); 
	var TransactionID = document.getElementById("TransactionID").value;

	var CustIDOld = document.getElementById("CustIDOld").value;	
	/*if(CustIDOld!=custID){  //reset TransactionID to blank
		TransactionID = '';
	}*/

	var SendUrl = 'ajax_receipt.php?action=getCustomerInvoice&custID='+custID+'&TransactionID='+TransactionID+'&confirm='+con+'&r='+Math.random()+'&select=1'; 
	httpObj.open("GET", SendUrl, true);
 
	httpObj.onreadystatechange = function CustomerInvoiceRecieve(){
		if (httpObj.readyState == 4) {			
			document.getElementById("invoiveList").innerHTML  = httpObj.responseText;
			
			//if(document.getElementById("totalInvoice").value>0){				
				$("#save_payment").show();
				$("#glList").show();
			//} 
			
			/*if(TransactionID==''){
				SetPaymentMethod(custID);
			}else{
				ShowHideLoader('');
			}*/

			ShowHideLoader('');
                       
		}
	};
	httpObj.send(null);
	 
}

/*************************************/      
function SetPaymentMethod(custID){
	
	var SendUrl = 'ajax_receipt.php?action=getCustomerPaymentMethod&custID='+custID+'&r='+Math.random()+'&select=1'; 
	httpObj2.open("GET", SendUrl, true);
	//alert(SendUrl);
	httpObj2.onreadystatechange = function PaymentMethodRecieve(){
		if (httpObj2.readyState == 4) {
			
			document.getElementById("Method").value = httpObj2.responseText;
                        getPaymentMethodName(httpObj2.responseText);
                         ShowHideLoader('');
		}
	};
	httpObj2.send(null);

}
/*************************************/
function setDefaultCheckNumber(){
	var BankAccountID = $("#PaidTo").val();
	$("#CheckNumber").val('');
	if(BankAccountID>0){
		var sendParam='&action=DefaultCheckNumber&BankAccountID='+escape(BankAccountID)+'&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
			dataType : "JSON",
			data: sendParam,
			success: function (responseText) { 				
				$("#CheckNumber").val(responseText['NextCheckNumber']);	
			}
		});
	}
}
/*************************************/       
 function SetPayAmnt(){
	var totalAmt = 0;
	var PayAmount = 0;
	var totalInvoice = 0;
	var ReceivedAmount = 0;
	var MainOpenBalance = 0 ;
	var LastBalance = 0 ;
	totalInvoice = document.getElementById("totalInvoice").value;
	ReceivedAmount = document.getElementById("ReceivedAmount").value;

        for(var i=1; i <= totalInvoice;i++){
		MainOpenBalance = parseFloat(document.getElementById("invoice_amnt_"+i).value);
		PayAmount = parseFloat(document.getElementById("payment_amnt_"+i).value);

		if(document.getElementById("payment_amnt_"+i).value > 0){
			totalAmt += PayAmount;
			document.getElementById("invoice_check_"+i).checked = true;
			LastBalance = MainOpenBalance - PayAmount;
			//$("#addrow_"+i).show(); 
		}else{
			document.getElementById("payment_amnt_"+i).value = '';
			document.getElementById("invoice_check_"+i).checked = false;
			LastBalance = MainOpenBalance;
			//$("#addrow_"+i).hide(); 
		}
            
            	document.getElementById("openBalance_"+i).value = parseFloat(LastBalance).toFixed(2);
        }

	if(totalAmt > 0){
		document.getElementById("total_payment").value = totalAmt.toFixed(2);
	}else{
		document.getElementById("total_payment").value = '';
	}

	ChangeAddButton();
}     
/*************************************/ 
function ChangeAddButton() {	
    	
	var totalInvoice = document.getElementById("totalInvoice").value;

	var orderno="";	var j=0;	
	for(var i=1; i<=totalInvoice; i++){
		if(document.getElementById("invoice_check_"+i).checked){
			j++;
			var posttogl = document.getElementById("invoice_check_"+i).value;
			orderno+=posttogl+',';
		}
	}

	if(j>0){
		if((document.getElementById("addallrow").style.display == 'none')){ 
			document.getElementById("addallrow").style.display = '' ;	
		}
        }else{
		document.getElementById("addallrow").style.display = 'none';  	
	}
    	
    }
/*************************************/  
function SetPayAPAmnt(){
	var PayAmount = 0;
	var totalAmt = 0;
	var totalInvoice = 0;
	var MainOpenBalance = 0 ;
	var LastBalance = 0 ;
	totalInvoice = document.getElementById("totalInvoiceVendor").value;
        for(var i=1; i <= totalInvoice;i++){
		MainOpenBalance = parseFloat(document.getElementById("vendorinvoice_amnt_"+i).value);
		PayAmount = parseFloat(document.getElementById("payment_vendor_amnt_"+i).value);
	    if(document.getElementById("payment_vendor_amnt_"+i).value > 0){
	         totalAmt += PayAmount;
	         document.getElementById("Vendor_invoice_check_"+i).checked = true;
		 LastBalance = MainOpenBalance - PayAmount;
		 $("#addrov_"+i).show(); 
	    }else{
	        document.getElementById("payment_vendor_amnt_"+i).value = '';
	        document.getElementById("Vendor_invoice_check_"+i).checked = false;
		LastBalance = MainOpenBalance;
		$("#addrov_"+i).hide(); 
	    }
		document.getElementById("vendoropenBalance_"+i).value = parseFloat(LastBalance).toFixed(2);
        }
            if(totalAmt > 0){
                //document.getElementById("PaidAmount").value = totalAmt;
                document.getElementById("total_payment_ventor").value = totalAmt.toFixed(2);
            }else{
                //document.getElementById("PaidAmount").value = '';
                document.getElementById("total_payment_ventor").value = '';
            }



 }
/*************************************/  
 function SetApPayAmntByCheck(line){
          
         var totalAmt = 0,totalInvoice = 0,PaidAmount = 0,invAmnt = 0,remainInvAmnt = 0;
        
         totalInvoice = document.getElementById("totalInvoiceVendor").value;
         PaidAmount = parseFloat(document.getElementById("ReceivedAmount").value);


         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("payment_vendor_amnt_"+i).value  > 0){
              invAmnt +=  parseFloat(document.getElementById("payment_vendor_amnt_"+i).value);
             }
         }
        
       remainInvAmnt = PaidAmount-parseFloat(invAmnt);
     

            if(document.getElementById("Vendor_invoice_check_"+line).checked){
                 //document.getElementById("payment_amnt_"+line).value = parseFloat(document.getElementById("invoice_amnt_"+line).value);
                 if(PaidAmount=='0' || remainInvAmnt > parseFloat(document.getElementById("vendorinvoice_amnt_"+line).value))
                     {
                       document.getElementById("payment_vendor_amnt_"+line).value =  parseFloat(document.getElementById("vendorinvoice_amnt_"+line).value); 
                     }else{
                         
                             document.getElementById("payment_vendor_amnt_"+line).value = remainInvAmnt;
                     }
            }else{
                document.getElementById("payment_vendor_amnt_"+line).value = '';
            }
        
        SetPayAPAmnt();
       
     }

/***************************************************/
      function SetPayAmntByCheck(line){
         var totalAmt = 0,totalInvoice = 0,ReceivedAmount = 0,invAmnt = 0,remainInvAmnt = 0;
          
         totalInvoice = document.getElementById("totalInvoice").value;
         ReceivedAmount = parseFloat(document.getElementById("ReceivedAmount").value);
        
         for(var i=1; i <= totalInvoice;i++){            
             if(document.getElementById("payment_amnt_"+i).value > 0){
              invAmnt +=  parseFloat(document.getElementById("payment_amnt_"+i).value);
             }
         }
         
       remainInvAmnt = ReceivedAmount-parseFloat(invAmnt);

      
            if(document.getElementById("invoice_check_"+line).checked){
                 
		if(ReceivedAmount=='0' || remainInvAmnt > parseFloat(document.getElementById("invoice_amnt_"+line).value)){
			document.getElementById("payment_amnt_"+line).value =  parseFloat(document.getElementById("invoice_amnt_"+line).value); 
		}else{
			document.getElementById("payment_amnt_"+line).value = remainInvAmnt;
		}
                     
                       
            }else{
                document.getElementById("payment_amnt_"+line).value = '';
            }
        
        
        SetPayAmnt();
       
     }
/*************************************/       
    function getPaymentMethodName(method){

    if(method == "Check")
        {
           // document.getElementById("CheckBankNameTr").style.display='';
            //document.getElementById("CheckFormatTr").style.display='';
		document.getElementById("CheckNumberTr").style.display='';
        }else{
           // document.getElementById("CheckBankNameTr").style.display='none';
           // document.getElementById("CheckFormatTr").style.display='none';
		document.getElementById("CheckNumberTr").style.display='none';
        }
     
 }
 /*************************************/ 
  function getEntryType(EntryType){
    	if(EntryType == "GL Account"){
            document.getElementById("showGLCode").style.display='';
            document.getElementById("showGLCode").style.display='';
        }else{
            document.getElementById("showGLCode").style.display='none';
            document.getElementById("showGLCode").style.display='none';
        }
     
 }
/*************************************/  
function AddAllToTransaction(){
	ShowHideLoader('1','S');
	//$("#savedList").html('<strong>Saving.......</strong>');
	var totalInvoice = document.getElementById("totalInvoice").value;
	for(var i=1; i<=totalInvoice; i++){
		if(document.getElementById("invoice_check_"+i).checked){			
			AddToTransaction(i);			
		}
	}
	document.getElementById("addallrow").style.display = 'none';  
	ListTransaction();	
}
/*************************************/  

 function AddToTransaction(Line){
	var row = $("#addrow_"+Line).closest("tr");	
	var TransactionID = $("#TransactionID").val();
	var Amount = parseFloat(document.getElementById("payment_amnt_"+Line).value);
	var InvoiceID = document.getElementById("InvoiceID_"+Line).value;
	var OrderID = document.getElementById("OrderID_"+Line).value;
	var CustID = $("#CustomerName").val();
	var ReceivedAmount = parseFloat($("#ReceivedAmount").val());
	var ConversionRate = document.getElementById("ConversionRate_"+Line).value;
	var SavedAmount = 0;
	if(document.getElementById("total_saved_payment") != null){
		SavedAmount = parseFloat($("#total_saved_payment").val());
	}
	var NextAmount = SavedAmount+Amount;
	NextAmount = parseFloat(NextAmount.toFixed(2));

	var errorMsg = '';
	 
	if(CustID==''){
		errorMsg = "Please select customer.";
	}else if(NextAmount>ReceivedAmount){
		errorMsg = "Saved payment amount can't exceed total deposit amount.";
	}else{
		var sendParam='&action=CheckTransaction&CustID='+escape(CustID)+'&OrderID='+escape(OrderID)+'&TransactionID='+escape(TransactionID)+'&PaymentType=Invoice&r='+Math.random(); 
		
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) {  
				if(responseText==1){
					errorMsg = "This invoice has been already saved by other user.";
				}else{
					errorMsg = responseText;
				}
			}
		});
	}





	if(errorMsg!=''){
		alert(errorMsg);
	}else{		
		row.hide();
		$("#total_payment").val('');
		$("#payment_amnt_"+Line).val('');
		document.getElementById("invoice_check_"+Line).checked = false;

		//ShowHideLoader('1','S');
		//$("#savedList").html('<strong>Saving.......</strong>');
		//$("#addrow_"+Line).hide(); 
		var sendParam='&action=AddToTransaction&CustID='+escape(CustID)+'&Amount='+escape(Amount)+'&InvoiceID='+escape(InvoiceID)+'&OrderID='+escape(OrderID)+'&ConversionRate='+escape(ConversionRate)+'&PaymentType=Invoice&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) {
				$("#ContraFlag").val('No');  
				//ListTransaction();
			}
		});
	}
	
 }
/*************************************/  
 function AddContraToTransaction(Line){
	var row = $("#addrov_"+Line).closest("tr");	
	var Amount = parseFloat(document.getElementById("payment_vendor_amnt_"+Line).value);
	var InvoiceID = document.getElementById("VendorInvoiceID_"+Line).value;
	var OrderID = document.getElementById("VendorOrderID_"+Line).value;
	var CustID = $("#CustomerName").val();
	var SuppCode = $("#SuppCode").val();
	var ReceivedAmount = parseFloat($("#ReceivedAmount").val());
	var ConversionRate = document.getElementById("VendorConversionRate_"+Line).value;
	var SavedAmount = 0;
	if(document.getElementById("total_saved_payment") != null){
		SavedAmount = parseFloat($("#total_saved_payment").val());
	}
	var NextAmount = SavedAmount+Amount;
	NextAmount = parseFloat(NextAmount.toFixed(2));

	if(CustID>0 && SuppCode!='' && NextAmount<=ReceivedAmount){
		
		row.hide();
		$("#total_payment_ventor").val('');
		$("#payment_vendor_amnt_"+Line).val('');
		document.getElementById("Vendor_invoice_check_"+Line).checked = false;
		ShowHideLoader('1','S');

		$("#savedList").html('<strong>Saving.....</strong>');
		//$("#addrov_"+Line).hide(); 
		var sendParam='&action=AddToTransaction&CustID='+escape(CustID)+'&SuppCode='+escape(SuppCode)+'&Amount='+escape(Amount)+'&InvoiceID='+escape(InvoiceID)+'&ConversionRate='+escape(ConversionRate)+'&PaymentType=Contra Invoice&OrderID='+escape(OrderID)+'&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) {  
				$("#ContraFlag").val('Yes');  
				$("#CustomerName").attr("disabled",true);
				//$("#CustomerName").attr("class","disabled_inputbox");
				ListTransaction();
			}
		});
	}else{
		alert("Saved payment amount can't exceed total deposit amount.");
	}
	
 }



/*************************************/  
 function AddGlToTransaction(Line){
	var row = $("#addrog_"+Line).closest("tr");	
	var Amount = parseFloat(document.getElementById("paymentGL"+Line).value);
	var AccountID = document.getElementById("AccountIDGL"+Line).value;
	var TransactionID = $("#TransactionID").val();	
	var CustID = $("#CustomerName").val();
	var ReceivedAmount = parseFloat($("#ReceivedAmount").val());
	var ConversionRate = document.getElementById("ConversionRateGl"+Line).value;
	var SavedAmount = 0;
	if(document.getElementById("total_saved_payment") != null){
		SavedAmount = parseFloat($("#total_saved_payment").val());
	}
	var NextAmount = SavedAmount+Amount;
	NextAmount = parseFloat(NextAmount.toFixed(2));

	var errorMsg = '';

	if(CustID==''){
		errorMsg = "Please select customer.";
	}else if(AccountID==''){
		errorMsg = "Please select gl account.";
	}else{
		var sendParam='&action=CheckGlTransaction&CustID='+escape(CustID)+'&AccountID='+escape(AccountID)+'&TransactionID='+escape(TransactionID)+'&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) {  
				if(responseText==1){
					errorMsg = "Gl account has been already saved for selected customer.";
				}else{
					errorMsg = responseText;
				}
			}
		});
	}
       


	if(errorMsg!=''){
		alert(errorMsg);
	}else if(NextAmount<=ReceivedAmount){
		
		row.hide();
		$("#TotalAmountGL").val('');
		$("#AmountGL"+Line).val('');
		$("#paymentGL"+Line).val('');

		ShowHideLoader('1','S');
		$("#savedList").html('<strong>Saving.....</strong>');
		//$("#addrow_"+Line).hide(); 
		var sendParam='&action=AddToTransaction&CustID='+escape(CustID)+'&Amount='+escape(Amount)+'&AccountID='+escape(AccountID)+'&ConversionRate='+escape(ConversionRate)+'&PaymentType=GL&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) {  
				ListTransaction();
			}
		});
	}else{
		alert("Saved payment amount can't exceed total deposit amount.");
	}
	
 }
/*************************************/  
 function RemoveTransaction(TrID,Line){	
	if(TrID>0){
		var row = $("#savedrow_"+Line).closest("tr");	
		row.hide();		
		var sendParam='&action=RemoveTransaction&TrID='+escape(TrID)+'&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) { 
				ListTransaction();
				
				var custID = $("#CustomerName").val();
				var ConfirmContra = $("#ConfirmContra").val();				
				if(custID!=''){
					SetCustomerInvoice(custID,ConfirmContra);
				}


			}
		});
	}
	
 }
/*************************************/  
 function ListTransaction(){
	var TransactionID = $("#TransactionID").val();	
	var ContraTransactionID = $("#ContraTransactionID").val();	

	var sendParam='&TransactionID='+TransactionID+'&ContraTransactionID='+ContraTransactionID+'&action=ListTransaction&r='+Math.random();  
	if(TransactionID>0){
		$("#save_payment").attr("disabled",false);
		$("#save_payment").show();
	}else{
		/*$("#ReceivedAmount").attr("class","disabled");
		$("#ReceivedAmount").attr("readonly","true");*/

	}


	$.ajax({
		type: "GET",
		async:false,
		url: 'ajax_receipt.php',
		data: sendParam,
		success: function (responseText) { 			
			$("#savedList").html(responseText);
			$(window).scrollTop($('#savedList').offset().top);
			ShowHideLoader('');
		}
	});	
	
 }
/***************************************************/
      function SetPayAmntByCheckCr(line){
         var totalAmt = 0,totalCredit = 0,ReceivedAmount = 0,CrAmnt = 0,remainCrAmnt = 0;
          
         totalCredit = document.getElementById("totalCredit").value;
         ReceivedAmount = parseFloat(document.getElementById("ReceivedAmount").value);
         
         for(var i=1; i <= totalCredit;i++){
            
             if(document.getElementById("payment_amntcr_"+i).value > 0){
              CrAmnt +=  parseFloat(document.getElementById("payment_amntcr_"+i).value);
             }
         }
         
       remainCrAmnt = ReceivedAmount-parseFloat(CrAmnt);

         
            if(document.getElementById("credit_check_"+line).checked){
                
                 if(ReceivedAmount=='0' || remainCrAmnt > parseFloat(document.getElementById("credit_amnt_"+line).value))
                     {
                       document.getElementById("payment_amntcr_"+line).value =  parseFloat(document.getElementById("credit_amnt_"+line).value); 
                     }else{
                        
                             document.getElementById("payment_amntcr_"+line).value = remainCrAmnt;
                     }
                     
                       
            }else{
                document.getElementById("payment_amntcr_"+line).value = '';
            }
        
        
        SetPayAmntCr();
       
     }
/*************************************/  
function SetPayAmntCr(){
	var totalAmt = 0;
	var PayAmount = 0;
	var totalCredit = 0;	 
	var MainOpenBalance = 0 ;
	var LastBalance = 0 ;
	totalCredit = document.getElementById("totalCredit").value;
	

        for(var i=1; i <= totalCredit;i++){
		MainOpenBalance = parseFloat(document.getElementById("credit_amnt_"+i).value);
		PayAmount = parseFloat(document.getElementById("payment_amntcr_"+i).value);

		if(document.getElementById("payment_amntcr_"+i).value > 0){
			totalAmt += PayAmount;
			document.getElementById("credit_check_"+i).checked = true;
			LastBalance = MainOpenBalance - PayAmount;
			$("#addrowcr_"+i).show(); 
		}else{
			document.getElementById("payment_amntcr_"+i).value = '';
			document.getElementById("credit_check_"+i).checked = false;
			LastBalance = MainOpenBalance;
			$("#addrowcr_"+i).hide(); 
		}
            
            	document.getElementById("openBalanceCr_"+i).value = parseFloat(LastBalance).toFixed(2);
        }

	if(totalAmt > 0){
		document.getElementById("total_paymentcr").value = totalAmt.toFixed(2);
	}else{
		document.getElementById("total_paymentcr").value = '';
	}

}
/*************************************/  
function ChangeConversionrateCr(line){

	var ConversionRate = document.getElementById("ConversionRateCr_"+line).value;
	var TotalInvoiceAmount=document.getElementById("TotalCreditAmountOld_"+line).value;
	var receivedAmnt=document.getElementById("payment_amntcr_"+line).value;	


	var Totalamount=TotalInvoiceAmount*ConversionRate;
	Totalamount = parseFloat(Totalamount).toFixed(2);
	document.getElementById("TotalCreditAmount_"+line).value=Totalamount;


	var Openbalance = Totalamount-receivedAmnt;
	Openbalance = parseFloat(Openbalance).toFixed(2);

	document.getElementById("credit_amnt_"+line).value=Openbalance;
	document.getElementById("openBalanceCr_"+line).value=Openbalance ;
}
/*************************************/  
 function AddCreditToTransaction(Line){
	var row = $("#addrowcr_"+Line).closest("tr");	
	var TransactionID = $("#TransactionID").val();
	var Amount = parseFloat(document.getElementById("payment_amntcr_"+Line).value);
	var CreditID = document.getElementById("CreditID_"+Line).value;
	var OrderID = document.getElementById("OrderIDCr_"+Line).value;
	var CustID = $("#CustomerName").val();
	var ReceivedAmount = parseFloat($("#ReceivedAmount").val());
	var ConversionRate = document.getElementById("ConversionRateCr_"+Line).value;
	var openBalance = parseFloat(document.getElementById("openBalanceCr_"+Line).value) + Amount;

	/*var SavedAmount = 0;
	if(document.getElementById("total_saved_payment") != null){
		SavedAmount = parseFloat($("#total_saved_payment").val());
	}
	var NextAmount = SavedAmount-Amount;
	NextAmount = parseFloat(NextAmount.toFixed(2));*/




	var errorMsg = '';
	 
	if(CustID==''){
		errorMsg = "Please select customer.";	
	}else if(Amount>openBalance){
		errorMsg = "You can apply a maximum amount of "+openBalance+" for this credit memo.";	
	}else{
		var sendParam='&action=CheckTransaction&CustID='+escape(CustID)+'&OrderID='+escape(OrderID)+'&TransactionID='+escape(TransactionID)+'&PaymentType=Credit&r='+Math.random(); 
		
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) {  
				if(responseText==1){
					errorMsg = "This credit has been already saved by other user.";
				}else{
					errorMsg = responseText;
				}
			}
		});
	}





	if(errorMsg!=''){
		alert(errorMsg);
	}else{		
		row.hide();
		$("#total_paymentcr").val('');
		$("#payment_amntcr_"+Line).val('');
		document.getElementById("credit_check_"+Line).checked = false;

		ShowHideLoader('1','S');
		$("#savedList").html('<strong>Applying.......</strong>');
		//$("#addrow_"+Line).hide(); 
		var sendParam='&action=AddToTransaction&CustID='+escape(CustID)+'&Amount='+escape(Amount)+'&CreditID='+escape(CreditID)+'&OrderID='+escape(OrderID)+'&ConversionRate='+escape(ConversionRate)+'&PaymentType=Credit&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_receipt.php',
			data: sendParam,
			success: function (responseText) {				
				ListTransaction();
			}
		});
	}
	
 }
/*************************************/  


