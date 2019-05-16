/*************************************/
function EnableAmount(){
	var  Amount = $("#PaidAmount").val();  
	if(Amount!=''){
		$("#SuppCode").attr("disabled",false);
		 
		$("#EntryType").attr("disabled",false);
		$("#EntryType").attr("class","inputbox");
		$("#GLCode").attr("disabled",false);
		$("#GLCode").attr("class","inputbox");
		$("#PaidFrom").attr("disabled",false);
		$("#PaidFrom").attr("class","inputbox");
		$("#Method").attr("disabled",false);
		$("#Method").attr("class","inputbox");	
		$("#CheckBankName").attr("disabled",false);
		$("#CheckBankName").attr("class","inputbox");	
		$("#CheckNumber").attr("disabled",false);
		$("#CheckNumber").attr("class","inputbox");	
		$("#CheckFormat").attr("disabled",false);
		$("#CheckFormat").attr("class","inputbox");
		$("#Date").attr("disabled",false);
		$("#Date").attr("class","datebox");
		$("#ReferenceNo").attr("disabled",false);
		$("#ReferenceNo").attr("class","inputbox");	
		$("#Comment").attr("disabled",false);
		$("#Comment").attr("class","inputbox");	
		$("#save_payment").attr("disabled",false);
		 				
	}else{
		$("#SuppCode").attr("disabled",true);

		$("#EntryType").attr("disabled",true);
		$("#EntryType").attr("class","disabled_inputbox");
		$("#GLCode").attr("disabled",true);
		$("#GLCode").attr("class","disabled_inputbox");
		$("#PaidFrom").attr("disabled",true);
		$("#PaidFrom").attr("class","disabled_inputbox");
		$("#Method").attr("disabled",true);
		$("#Method").attr("class","disabled_inputbox");
		$("#CheckBankName").attr("disabled",true);
		$("#CheckBankName").attr("class","disabled_inputbox");
		$("#CheckNumber").attr("disabled",true);
		$("#CheckNumber").attr("class","disabled_inputbox");
		$("#CheckFormat").attr("disabled",true);
		$("#CheckFormat").attr("class","disabled_inputbox");
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
function validateForm(frm)
{
	var DataExist=0; var TotalSavedAmount=0;
	var PaidAmount = frm.PaidAmount.value;
	var ContraAcnt = 0;

	 if(frm.PaidAmount.value == ""){
                  alert("Please Enter Total Amount Paid.");
                  frm.PaidAmount.focus();
                  return false;
         }
 
	if(document.getElementById("ContraAcnt") != null){
		ContraAcnt = $("#ContraAcnt").val();
	}

	if(document.getElementById("total_saved_payment") != null){
		TotalSavedAmount = parseFloat($("#total_saved_payment").val());
	}
	if(parseFloat(PaidAmount) != parseFloat(TotalSavedAmount)){
		alert("Total Amount Paid and Total Payment Should be Same.");	
		return false;
	} 
	
	

        /*var totalOpenBalance = document.getElementById("totalOpenBalance").value;
	
        var totalInvoice = document.getElementById("totalInvoice").value;
	if(document.getElementById("total_paymentcr") != null){
		var TotalCreditAmount = parseFloat(document.getElementById("total_paymentcr").value);
		if(TotalCreditAmount<0){
			TotalPaidAmount = TotalPaidAmount + TotalCreditAmount;
		}		
	}      
	
	 if(parseFloat(PaidAmount) != parseFloat(TotalPaidAmount)){
		alert("Paid Amount and Total Payment Should be Same.");
		return false;

	  } 
                
          if(parseFloat(PaidAmount) > parseFloat(totalOpenBalance)){
		alert(" Payment Amount Should be "+totalOpenBalance);
                frm.PaidAmount.focus();
		return false;
	   }*/



	if(ContraAcnt ==1){
		if(!ValidateForSelect(frm.EntryType, "Entry Type")){
			return false;
		}

		if(frm.EntryType.value == "GL Account")
		{
			if(!ValidateForSelect(frm.GLCode, "GL Account")){
				return false;
			}
		}

	} 
//end
	if(!ValidateForSelect(frm.PaidFrom, "Payment Account")){
		return false;
	}
	if(!ValidateForSelect(frm.Method, "Payment Method")){
		return false;
	}
       
	if(frm.Method.value == "Check") {
		if(!ValidateForSimpleBlank(frm.CheckBankName, "Bank Name")){
			return false;
		}
		if(!ValidateForSimpleBlank(frm.CheckNumber, "Check Number")){
			return false;
		}
		if(!ValidateForSelect(frm.CheckFormat, "Check Format")){
			return false;
		}
		/***************/
		var Voided = $("#Voided").val();
		if(Voided!=1){
			DataExist = CheckExistingData("isRecordExists.php", "&VendorCheckNumber="+escape(document.getElementById("CheckNumber").value)+'&editID='+escape(document.getElementById("TransactionID").value), "CheckNumber","Check Number");
			if(DataExist==1)return false;
		}
		/***************/

	}
	
           
        /*for(var i=1; i <= totalInvoice;i++){
            
            var payment_amnt = parseFloat(document.getElementById("payment_amnt_"+i).value);
            var invoice_amnt = parseFloat(document.getElementById("invoice_amnt_"+i).value);
            if( payment_amnt > 0 &&  payment_amnt > invoice_amnt){
                 alert("You Can Pay Only "+document.getElementById("invoice_amnt_"+i).value);
                 document.getElementById("payment_amnt_"+i).focus();
		 return false;
            } 
        }
              
	
	if(ContraAcnt==1){  
	
		var ArtotalInvoice = 0;
		 ArtotalInvoice = document.getElementById("ArtotalInvoice").value;
	var ArTotalPaidAmount = document.getElementById("Artotal_payment").value;
		  for(var i=1; i <= ArtotalInvoice;i++){
		    var Ar_payment_amnt = parseFloat(document.getElementById("Arpayment_amnt_"+i).value);
		    var Ar_invoice_amnt = parseFloat(document.getElementById("Arinvoice_amnt_"+i).value);
		    if( Ar_payment_amnt > 0 &&  Ar_payment_amnt > Ar_invoice_amnt){
		         alert("You Can Receive Only "+document.getElementById("Arinvoice_amnt_"+i).value);
		         document.getElementById("Arpayment_amnt_"+i).focus();
			 return false;
		    } 
		}

	 	 if(parseFloat(PaidAmount) != parseFloat(ArTotalPaidAmount) || parseFloat(PaidAmount) != parseFloat(ArTotalPaidAmount) ){
		      alert("Received Amount and Total Payment Should be Same.");
		      frm.PaidAmount.focus();
		      return false;

		      }	
      }*/
        
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
        
        
        for(var bk=0;bk<backDateLength;bk++)
            {
                if(strSplitBackDate[bk] == StrspliPDate)
                    {
                        BackFlag = 1;
                        break;
                    }
               
            }
        
        
        var CurrentPeriodDate = Date.parse(CurrentPeriodDate);
        var PDate = Date.parse(PDate);
       
        if(PDate < CurrentPeriodDate && BackFlag == 0) 
            {
                alert("Sorry! You Can Not Enter Back Date Entry.\n"+CurrentPeriodMsg+".");
                document.getElementById("Date").focus();
		return false;
            }
        
	window.onbeforeunload = null;
	$("#SuppCode").attr("disabled",false);
	ShowHideLoader('1','P');
	

		
}

/*************************************/

function getPaymentMethodName(method){
	
	if(method == "Check"){
		document.getElementById("CheckBankNameTr").style.display='';
		document.getElementById("CheckFormatTr").style.display='';
		document.getElementById("CheckNumberTr").style.display='';
		//document.getElementById("CheckFormatLink").style.display='';
		
	}else{
		document.getElementById("CheckBankNameTr").style.display='none';
		document.getElementById("CheckFormatTr").style.display='none';
		document.getElementById("CheckNumberTr").style.display='none';
		//document.getElementById("CheckFormatLink").style.display='none';
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
function setDefaultCheckNumber(){
	var BankAccountID = $("#PaidFrom").val();
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
				$("#CheckBankName").val(responseText['BankName']);	
				$("#CheckNumber").val(responseText['NextCheckNumber']);	
			}
		});
	}
}
/*************************************/
function ChangeConversionrate(line){

	var ConversionRate = document.getElementById("ConversionRate_"+line).value;
	var InvoiceAmount=document.getElementById("TotalAmountOld_"+line).value;	
	var paidAmnt=document.getElementById("paidAmnt_"+line).value;
	var PayAmount=document.getElementById("payment_amnt_"+line).value;
	

	var Totalamount=InvoiceAmount*ConversionRate;
	
	Totalamount = parseFloat(Totalamount).toFixed(2);
	document.getElementById("TotalInvoiceAmount_"+line).value=Totalamount;

	var Openbalance = Totalamount-paidAmnt;
	
	Openbalance = parseFloat(Openbalance).toFixed(2);
	document.getElementById("invoice_amnt_"+line).value=Openbalance;
	document.getElementById("openBalance_"+line).value=Openbalance - PayAmount;
}
/*************************************/
function ChangeArConversionrate(line){

	var ConversionRate = document.getElementById("ArConversionRate_"+line).value;
	var TotalInvoiceAmount=document.getElementById("ArTotalInvoiceAmountOld_"+line).value;
	var receivedAmnt=document.getElementById("Arpayment_amnt_"+line).value;	
	

	var Totalamount=TotalInvoiceAmount*ConversionRate;
	Totalamount = parseFloat(Totalamount).toFixed(2);
	document.getElementById("ArTotalInvoiceAmount_"+line).value=Totalamount;


	var Openbalance = Totalamount-receivedAmnt;
	Openbalance = parseFloat(Openbalance).toFixed(2);
	document.getElementById("Arinvoice_amnt_"+line).value=Openbalance;
	document.getElementById("AropenBalance_amnt_"+line).value=Openbalance;

}
/*************************************/


function CheckNumberExist(MSG_SPAN,FieldName){
	document.getElementById(MSG_SPAN).innerHTML="";

	var CheckNumber = $("#CheckNumber").val();
	var Voided = $("#Voided").val();
	if(CheckNumber!='' && Voided!=1){
		FieldLength = document.getElementById(FieldName).value.length;

		if(FieldLength>=3){
			document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';
			var Url = "isRecordExists.php?VendorCheckNumber="+escape(document.getElementById(FieldName).value)+'&editID='+escape(document.getElementById("TransactionID").value);
			var SendUrl = Url+"&r="+Math.random(); 

			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function RecieveAvailRequest(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Already Exist!</span>";
						CheckVoidPopup();
					}else if(httpObj.responseText==0) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>OK</span>";
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
				}
			};
			httpObj.send(null);

		}else if(FieldLength>0){
			document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>It should be minimum of 3 digits long.</span>";
		}

	}
}

/*************************************/

function CheckVoidPopup(){ 	
	$("#checkvoid_div").fancybox().click();
}

function PrintCheck(){ 	
	var CheckFormat = $("#CheckFormat").val();
	var SuppCode = $("#SuppCode").val();
	var PaymentDate = $("#Date").val();
	var PaidAmount = $("#PaidAmount").val();
	var CheckNumber = $("#CheckNumber").val();
	if(CheckFormat!=''){
		var SendUrl ="checkFormat.php?SuppCode="+SuppCode+'&Date='+PaymentDate+'&Amt='+PaidAmount+'&Chk='+CheckNumber+'&frm='+CheckFormat;
		/*$("#CheckFormatLink").attr("href", SendUrl);
		$("#CheckFormatLink").fancybox().click();*/

		$.fancybox({
		 'href' : SendUrl,
		 'type' : 'iframe',
		 'width': '800',
		 'height': '700'
		 });

	}
}
/*************************************/

function checkContra(SuppCode){
	$("#invoiveList").html(''); 	
	if(SuppCode!=''){
		$("#invoiveList").html('<strong>Loading.....</strong>'); 
		var sendParam='&action=CheckContraAP&SuppCode='+escape(SuppCode)+'&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
			data: sendParam,
			success: function (responseText) {  
				if(responseText>0){
					confirmContra(SuppCode);
				}else{
					SetVendorInvoice(SuppCode,0,1);
				}
			}
		});
	}
}
/*************************************/
function confirmContra(venID)
{

	if(venID!=''){
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
					SetVendorInvoice(venID,1,1);
					$("#ConfirmContra").val(1);
					document.getElementById("EntryTpe").style.display='';
					$(this).dialog("close");
					ShowHideLoader(1,'P');
				},
				"No": function() {
					$(this).dialog("close");
					SetVendorInvoice(venID,0,1);
					document.getElementById("EntryTpe").style.display='none';
				}
			}

		});

		return false;
	}else{
		SetVendorInvoice(venID,0,1);
	}
}

/*************************************/
function SearchInvoiceEnter(evt){	 
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if(charCode == 13){
		var SuppCode = $("#SuppCode").val();	
		SetVendorInvoice(SuppCode,0,1);
        	return false;
	}
	 
}

function SearchInvoice(){	 
	var SuppCode = $("#SuppCode").val();	
	SetVendorInvoice(SuppCode,0,1);
}

/*************************************/

function GetPagingData(curPage,module){
	if(curPage<1){
		curPage=1;
	}

	var SuppCode = $("#SuppCode").val();
	SetVendorInvoice(SuppCode,0,curPage);
}

/*************************************/
function SetVendorInvoice(SuppCode,con,curPage){
 		if(curPage<1){
			curPage=1;
		}

		var curP = 1; var SearchKey = '';
		if(curPage>0){
			curP = curPage;
		}else if(document.getElementById("curPage") != null){
			curP = $("#curPage").val();
		}

		if(document.getElementById("SearchKey") != null){   
			SearchKey = $("#SearchKey").val();
		}


		ShowHideLoader('1','L');
		$("#invoiveList").html('<strong>Loading.....</strong>'); 
		
		var TransactionID = document.getElementById("TransactionID").value;
		var SuppCodeOld = document.getElementById("SuppCodeOld").value;	
		if(SuppCodeOld!=SuppCode){
			TransactionID = '';
		}
		
		
		 
		var SendUrl = 'ajax_pay.php?action=getVendorInvoice&SuppCode='+SuppCode+'&TransactionID='+TransactionID+'&confirm='+con+'&r='+Math.random()+'&select=1&curP='+escape(curP)+'&key='+escape(SearchKey); 
		
		httpObj.open("GET", SendUrl, true);
		
		httpObj.onreadystatechange = function VendorInvoiceRecieve(){
			if (httpObj.readyState == 4) {
				
				document.getElementById("invoiveList").innerHTML  = httpObj.responseText;
                                if(httpObj.responseText.length > 1500){
                                    document.getElementById("save_payment").style.display = 'block';
                                }else{
                                    document.getElementById("save_payment").style.display = 'none';
                                }
                                
			 	/*if(TransactionID==''){SetPaymentMethod(SuppCode);}else{
					  ShowHideLoader('');
				}*/
				 ShowHideLoader('');

			}
		};
		httpObj.send(null);
		 
	}
 /*************************************/       
    function SetPaymentMethod(SuppCode)
     {  
		var SendUrl = 'ajax_pay.php?action=getVendorPaymentMethod&SuppCode='+SuppCode+'&r='+Math.random()+'&select=1';
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
     function SetPayAmnt(){
         var totalAmt = 0;
	var PayAmount = 0;
         var totalInvoice = 0;
	var MainOpenBalance = 0 ;
	var LastBalance = 0 ;
         totalInvoice = document.getElementById("totalInvoice").value;
        for(var i=1; i <= totalInvoice;i++){
		MainOpenBalance = parseFloat(document.getElementById("invoice_amnt_"+i).value);
		PayAmount = parseFloat(document.getElementById("payment_amnt_"+i).value);
            if(document.getElementById("payment_amnt_"+i).value > 0){
		totalAmt += PayAmount
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
                //document.getElementById("PaidAmount").value = totalAmt;
                document.getElementById("total_payment").value = totalAmt.toFixed(2);
            }else{
                //document.getElementById("PaidAmount").value = '';
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
      function SetPayAmntByCheck(line){
          
         var totalAmt = 0,totalInvoice = 0,PaidAmount = 0,invAmnt = 0,remainInvAmnt = 0;
        
         totalInvoice = document.getElementById("totalInvoice").value;
         PaidAmount = parseFloat(document.getElementById("PaidAmount").value);
         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("payment_amnt_"+i).value  > 0){
              invAmnt +=  parseFloat(document.getElementById("payment_amnt_"+i).value);
             }
         }
        
       remainInvAmnt = PaidAmount-parseFloat(invAmnt);
     

            if(document.getElementById("invoice_check_"+line).checked){
                 //document.getElementById("payment_amnt_"+line).value = parseFloat(document.getElementById("invoice_amnt_"+line).value);
                 if(PaidAmount=='0' || remainInvAmnt > parseFloat(document.getElementById("invoice_amnt_"+line).value))
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
 function SetArPayAmnt(){
         var totalAmt = 0;
         var totalInvoice = 0;
	var PayAmount = 0;
          var ReceivedAmount = 0;
	var MainOpenBalance = 0 ;
	var LastBalance = 0 ;
         totalInvoice = document.getElementById("ArtotalInvoice").value;
          ReceivedAmount = document.getElementById("PaidAmount").value;
        for(var i=1; i <= totalInvoice;i++){
	        MainOpenBalance = parseFloat(document.getElementById("Arinvoice_amnt_"+i).value);
		PayAmount = parseFloat(document.getElementById("Arpayment_amnt_"+i).value);

            if(document.getElementById("Arpayment_amnt_"+i).value > 0){
                 totalAmt += parseFloat(document.getElementById("Arpayment_amnt_"+i).value);
                  document.getElementById("Arinvoice_check_"+i).checked = true;
		LastBalance = MainOpenBalance - PayAmount;
		 $("#addrov_"+i).show(); 
            }else{
                document.getElementById("Arpayment_amnt_"+i).value = '';
                 document.getElementById("Arinvoice_check_"+i).checked = false;
		LastBalance = MainOpenBalance;
		$("#addrov_"+i).hide(); 
            }
            
            document.getElementById("AropenBalance_amnt_"+i).value = parseFloat(LastBalance).toFixed(2);
        }
            if(totalAmt > 0){
                //document.getElementById("ReceivedAmount").value = totalAmt;
                document.getElementById("Artotal_payment").value = totalAmt.toFixed(2);
            }else{
                //document.getElementById("ReceivedAmount").value = '';
                document.getElementById("Artotal_payment").value = '';
            }
     }
 /*************************************/    
      function SetArPayAmntByCheck(line){
         var totalAmt = 0,totalInvoice = 0,ReceivedAmount = 0,invAmnt = 0,remainInvAmnt = 0;
          
         totalInvoice = document.getElementById("ArtotalInvoice").value;
         ReceivedAmount = parseFloat(document.getElementById("PaidAmount").value);
         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("Arpayment_amnt_"+i).value > 0){
              invAmnt +=  parseFloat(document.getElementById("Arpayment_amnt_"+i).value);
             }
         }
         
       remainInvAmnt = ReceivedAmount-parseFloat(invAmnt);

         
            if(document.getElementById("Arinvoice_check_"+line).checked){
                 
                 if(ReceivedAmount=='0' || remainInvAmnt > parseFloat(document.getElementById("Arinvoice_amnt_"+line).value))
                     {
                       document.getElementById("Arpayment_amnt_"+line).value =  parseFloat(document.getElementById("invoice_amnt_"+line).value); 
                     }else{
                        
                             document.getElementById("Arpayment_amnt_"+line).value = remainInvAmnt;
                     }
                     
                       
            }else{
                document.getElementById("Arpayment_amnt_"+line).value = '';
            }
        
        
        SetArPayAmnt();
       
     }

/***************************************************/
      function SetPayAmntByCheckCr(line){
         var totalAmt = 0,totalCredit = 0,PaidAmount = 0,CrAmnt = 0,remainCrAmnt = 0;
          
         totalCredit = document.getElementById("totalCredit").value;
         PaidAmount = parseFloat(document.getElementById("PaidAmount").value);
         
         for(var i=1; i <= totalCredit;i++){
            
             if(document.getElementById("payment_amntcr_"+i).value > 0){
              CrAmnt +=  parseFloat(document.getElementById("payment_amntcr_"+i).value);
             }
         }
         
       remainCrAmnt = PaidAmount-parseFloat(CrAmnt);

         
            if(document.getElementById("credit_check_"+line).checked){
                
                 if(PaidAmount=='0' || remainCrAmnt > parseFloat(document.getElementById("credit_amnt_"+line).value))
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

		if(document.getElementById("payment_amntcr_"+i).value > 0 ){
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

	if(totalAmt < 0 ){
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
	var SuppCode = $("#SuppCode").val();

	var PaidAmount = parseFloat($("#PaidAmount").val());
	var ConversionRate = document.getElementById("ConversionRate_"+Line).value;
	var SavedAmount = 0;
	if(document.getElementById("total_saved_payment") != null){
		SavedAmount = parseFloat($("#total_saved_payment").val());
	}
	var NextAmount = SavedAmount+Amount;
	NextAmount = parseFloat(NextAmount.toFixed(2));

	var errorMsg = '';
	 
	if(SuppCode==''){
		errorMsg = "Please select vendor.";
	}else if(NextAmount>PaidAmount){
		errorMsg = "Saved payment amount can't exceed total paid amount.";
	}else{
		var sendParam='&action=CheckTransaction&SuppCode='+escape(SuppCode)+'&OrderID='+escape(OrderID)+'&TransactionID='+escape(TransactionID)+'&PaymentType=Invoice&r='+Math.random(); 
		
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
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
		var sendParam='&action=AddToTransaction&SuppCode='+escape(SuppCode)+'&Amount='+escape(Amount)+'&InvoiceID='+escape(InvoiceID)+'&OrderID='+escape(OrderID)+'&ConversionRate='+escape(ConversionRate)+'&PaymentType=Invoice&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
			data: sendParam,
			success: function (responseText) {
				$("#ContraFlag").val('No');  
				//ListTransaction();
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
		/*$("#PaidAmount").attr("class","disabled");
		$("#PaidAmount").attr("readonly","true");*/

	}


	$.ajax({
		type: "GET",
		async:false,
		url: 'ajax_pay.php',
		data: sendParam,
		success: function (responseText) { 			
			$("#savedList").html(responseText);
			$(window).scrollTop($('#savedList').offset().top);
			ShowHideLoader('');
		}
	});	
	
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
			url: 'ajax_pay.php',
			data: sendParam,
			success: function (responseText) { 
				ListTransaction();
				
				var SuppCode = $("#SuppCode").val();
				var ConfirmContra = $("#ConfirmContra").val();				
				if(SuppCode!=''){
					SetVendorInvoice(SuppCode,ConfirmContra);
				}


			}
		});
	}
	
 }

/*************************************/  
 function AddContraToTransaction(Line){
	var row = $("#addrov_"+Line).closest("tr");	
	var Amount = parseFloat(document.getElementById("Arpayment_amnt_"+Line).value);
	var InvoiceID = document.getElementById("ArInvoiceID_"+Line).value;
	var OrderID = document.getElementById("ArOrderID_"+Line).value;
	var CustID = $("#CustomerName").val();
	var SuppCode = $("#SuppCode").val();
	var PaidAmount = parseFloat($("#PaidAmount").val());
	var ConversionRate = document.getElementById("ArConversionRate_"+Line).value;
	var SavedAmount = 0;
	if(document.getElementById("total_saved_payment") != null){
		SavedAmount = parseFloat($("#total_saved_payment").val());
	}
	var NextAmount = SavedAmount+Amount;
	NextAmount = parseFloat(NextAmount.toFixed(2));

	if(CustID>0 && SuppCode!='' && NextAmount<=PaidAmount){		
		row.hide();
		$("#Artotal_payment").val('');
		$("#Arpayment_amnt_"+Line).val(''); 


		document.getElementById("Arinvoice_check_"+Line).checked = false;
		ShowHideLoader('1','S');

		$("#savedList").html('<strong>Saving.....</strong>');
		//$("#addrov_"+Line).hide(); 
		var sendParam='&action=AddToTransaction&CustID='+escape(CustID)+'&SuppCode='+escape(SuppCode)+'&Amount='+escape(Amount)+'&InvoiceID='+escape(InvoiceID)+'&ConversionRate='+escape(ConversionRate)+'&PaymentType=Contra Invoice&OrderID='+escape(OrderID)+'&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
			data: sendParam,
			success: function (responseText) {  
				$("#ContraFlag").val('Yes');  
				$("#SuppCode").attr("disabled",true);				 
				ListTransaction();
			}
		});
	}else{
		alert("Saved payment amount can't exceed total paid amount.");
	}
	
 }



/*************************************/  
function AddCreditToTransaction(Line){
	var row = $("#addrowcr_"+Line).closest("tr");	
	var TransactionID = $("#TransactionID").val();
	var Amount = parseFloat(document.getElementById("payment_amntcr_"+Line).value);
	var CreditID = document.getElementById("CreditID_"+Line).value;
	var OrderID = document.getElementById("OrderIDCr_"+Line).value;
	var SuppCode = $("#SuppCode").val();
	var PaidAmount = parseFloat($("#PaidAmount").val());
	var ConversionRate = document.getElementById("ConversionRateCr_"+Line).value;
	var openBalance = parseFloat(document.getElementById("openBalanceCr_"+Line).value) + Amount;

 	var errorMsg = '';
	 
	if(SuppCode==''){
		errorMsg = "Please select vendor.";	
	}else if(Amount>openBalance){
		errorMsg = "You can apply a maximum amount of "+openBalance+" for this credit memo.";	
	}else{
		var sendParam='&action=CheckTransaction&SuppCode='+escape(SuppCode)+'&OrderID='+escape(OrderID)+'&TransactionID='+escape(TransactionID)+'&PaymentType=Credit&r='+Math.random(); 
		
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
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
		var sendParam='&action=AddToTransaction&SuppCode='+escape(SuppCode)+'&Amount='+escape(Amount)+'&CreditID='+escape(CreditID)+'&OrderID='+escape(OrderID)+'&ConversionRate='+escape(ConversionRate)+'&PaymentType=Credit&r='+Math.random();  
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
			data: sendParam,
			success: function (responseText) {				
				ListTransaction();
			}
		});
	}
	
 }
/*************************************/  

