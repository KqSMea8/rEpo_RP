/*************************************/
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
/*************************************/
function validateForm(frm){
	var ReceivedAmount = frm.ReceivedAmount.value;
	var TotalPaidAmount = document.getElementById("total_payment").value;
	var totalOpenBalance = document.getElementById("totalOpenBalance").value;
	var ContraAcnt = document.getElementById("ContraAcnt").value;
	var totalInvoice = 0;
	totalInvoice = document.getElementById("totalInvoice").value;
	if(frm.ReceivedAmount.value == "" || frm.ReceivedAmount.value == 0){
	      alert("Please Enter Received Amount.");
	      frm.ReceivedAmount.focus();
	      return false;
	}     
	if(frm.EntryType.value == ""){
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
	}
	if(frm.PaidTo.value == ""){
		   alert("Please Select Account.");
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
        
        for(var i=1; i <= totalInvoice;i++){
            var payment_amnt = parseFloat(document.getElementById("payment_amnt_"+i).value);
            var invoice_amnt = parseFloat(document.getElementById("invoice_amnt_"+i).value);
            if( payment_amnt > 0 &&  payment_amnt > invoice_amnt){
                 alert("You Can Receive Only "+document.getElementById("invoice_amnt_"+i).value);
                 document.getElementById("payment_amnt_"+i).focus();
		 return false;
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
        
       if(parseFloat(ReceivedAmount) != parseFloat(TotalPaidAmount) || parseFloat(ReceivedAmount) != parseFloat(TotalPaidAmount) ){
		alert("Received Amount and Total Payment Should be Same.");
		frm.ReceivedAmount.focus();
		return false;
	}                
	
	if(ContraAcnt==1){
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


   		if(parseFloat(ReceivedAmount) != parseFloat(TotalVendorPaidAmount)){
			alert("Paid Amount and Total Payment Should be Same.");
			return false;
		} 
                
          	if(parseFloat(ReceivedAmount) > parseFloat(totalVendorOpenBalance)){
			alert(" Payment Amount Should be "+totalVendorOpenBalance);
		        frm.ReceivedAmount.focus();
			return false;
		}

        }      

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
	$("#invoiveList").html(''); 	
	if(custID>0){
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
	if(CustIDOld!=custID){
		TransactionID = '';
	}

	var SendUrl = 'ajax_receipt.php?action=getCustomerInvoice&custID='+custID+'&TransactionID='+TransactionID+'&confirm='+con+'&r='+Math.random()+'&select=1'; 
	httpObj.open("GET", SendUrl, true);
	//alert(SendUrl);
	httpObj.onreadystatechange = function CustomerInvoiceRecieve(){
		if (httpObj.readyState == 4) {
			
			document.getElementById("invoiveList").innerHTML  = httpObj.responseText;
                        if(httpObj.responseText.length > 1500){
                            document.getElementById("save_payment").style.display = 'block';
                        }else{
                            document.getElementById("save_payment").style.display = 'none';
                        }

			if(TransactionID==''){SetPaymentMethod(custID);}else{
				  ShowHideLoader('');
			}
                       
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
		}else{
			document.getElementById("payment_amnt_"+i).value = '';
			document.getElementById("invoice_check_"+i).checked = false;
			LastBalance = MainOpenBalance;
		}
            
            	document.getElementById("openBalance_"+i).value = parseFloat(LastBalance).toFixed(2);
        }

	if(totalAmt > 0){
		document.getElementById("total_payment").value = totalAmt;
	}else{
		document.getElementById("total_payment").value = '';
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
	    }else{
	        document.getElementById("payment_vendor_amnt_"+i).value = '';
	        document.getElementById("Vendor_invoice_check_"+i).checked = false;
		LastBalance = MainOpenBalance;
	    }
		document.getElementById("vendoropenBalance_"+i).value = parseFloat(LastBalance).toFixed(2);
        }
            if(totalAmt > 0){
                //document.getElementById("PaidAmount").value = totalAmt;
                document.getElementById("total_payment_ventor").value = totalAmt;
            }else{
                //document.getElementById("PaidAmount").value = '';
                document.getElementById("total_payment_ventor").value = '';
            }



 }
/*************************************/  
 function SetApPayAmntByCheck(line){
          
         var totalAmt = 0,totalInvoice = 0,PaidAmount = 0,invAmnt = 0,remainInvAmnt = 0;
        
         totalInvoice = document.getElementById("totalInvoiceVendor").value;
         PaidAmount = document.getElementById("ReceivedAmount").value;


         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("payment_vendor_amnt_"+i).value  > 0){
              invAmnt +=  parseFloat(document.getElementById("payment_vendor_amnt_"+i).value);
             }
         }
        
       remainInvAmnt = parseFloat(PaidAmount)-parseFloat(invAmnt);
     

            if(document.getElementById("Vendor_invoice_check_"+line).checked){
                 //document.getElementById("payment_amnt_"+line).value = parseFloat(document.getElementById("invoice_amnt_"+line).value);
                 if(remainInvAmnt > parseFloat(document.getElementById("vendorinvoice_amnt_"+line).value))
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
         ReceivedAmount = document.getElementById("ReceivedAmount").value;
         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("payment_amnt_"+i).value > 0){
              invAmnt +=  parseFloat(document.getElementById("payment_amnt_"+i).value);
             }
         }
         
       remainInvAmnt = parseFloat(ReceivedAmount)-parseFloat(invAmnt);

         
            if(document.getElementById("invoice_check_"+line).checked){
                 
                 if(remainInvAmnt > parseFloat(document.getElementById("invoice_amnt_"+line).value))
                     {
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

    if(EntryType == "GL Account")
        {
            document.getElementById("showGLCode").style.display='';
            document.getElementById("showGLCode").style.display='';
        }else{
            document.getElementById("showGLCode").style.display='none';
            document.getElementById("showGLCode").style.display='none';
        }
     
 }
/*************************************/  
 
