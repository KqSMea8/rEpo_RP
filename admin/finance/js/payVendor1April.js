/*************************************/
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

/*************************************/
function validateForm(frm)
{
	var DataExist=0;
	var PaidAmount = frm.PaidAmount.value;
	var TotalPaidAmount = document.getElementById("total_payment").value;
        var totalOpenBalance = document.getElementById("totalOpenBalance").value;
	var ContraAcnt = document.getElementById("ContraAcnt").value;
        var totalInvoice = 0;
        totalInvoice = document.getElementById("totalInvoice").value;

        if(frm.PaidAmount.value == "" || frm.PaidAmount.value == 0)
        {
                  alert("Please Enter Amount Paid.");
                  frm.PaidAmount.focus();
                  return false;
         }
//bhoodev
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
	
           
        for(var i=1; i <= totalInvoice;i++){
            
            var payment_amnt = parseFloat(document.getElementById("payment_amnt_"+i).value);
            var invoice_amnt = parseFloat(document.getElementById("invoice_amnt_"+i).value);
            if( payment_amnt > 0 &&  payment_amnt > invoice_amnt){
                 alert("You Can Pay Only "+document.getElementById("invoice_amnt_"+i).value);
                 document.getElementById("payment_amnt_"+i).focus();
		 return false;
            } 
        }
             //AP Payment bu bhoodev
	
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
            
          //END PERIOD SETTING  
        
         if(parseFloat(PaidAmount) != parseFloat(TotalPaidAmount)){
		alert("Paid Amount and Total Payment Should be Same.");
		return false;

		} 
                
          if(parseFloat(PaidAmount) > parseFloat(totalOpenBalance)){
		alert(" Payment Amount Should be "+totalOpenBalance);
                frm.PaidAmount.focus();
		return false;

		}
        
        else{
		 parent.jQuery.fancybox.close();
	     ShowHideLoader('1','P');
	 }

		
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
					SetVendorInvoice(SuppCode,0);
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
					SetVendorInvoice(venID,1);
					document.getElementById("EntryTpe").style.display='';
					$(this).dialog("close");
					ShowHideLoader(1,'P');
				},
				"No": function() {
					$(this).dialog("close");
					SetVendorInvoice(venID,0);
					document.getElementById("EntryTpe").style.display='none';
				}
			}

		});

		return false;
	}else{
		SetVendorInvoice(venID,0);
	}
}

/*************************************/

function SetVendorInvoice(SuppCode,con){

		ShowHideLoader('1','L');
		$("#invoiveList").html('<strong>Loading.....</strong>'); 
		
		var TransactionID = document.getElementById("TransactionID").value;
		var SuppCodeOld = document.getElementById("SuppCodeOld").value;	
		if(SuppCodeOld!=SuppCode){
			TransactionID = '';
		}
		var SendUrl = 'ajax_pay.php?action=getVendorInvoice&SuppCode='+SuppCode+'&TransactionID='+TransactionID+'&confirm='+con+'&r='+Math.random()+'&select=1'; 
		httpObj.open("GET", SendUrl, true);
		
		httpObj.onreadystatechange = function VendorInvoiceRecieve(){
			if (httpObj.readyState == 4) {
				
				document.getElementById("invoiveList").innerHTML  = httpObj.responseText;
                                if(httpObj.responseText.length > 1500){
                                    document.getElementById("save_payment").style.display = 'block';
                                }else{
                                    document.getElementById("save_payment").style.display = 'none';
                                }
                                
			 	if(TransactionID==''){SetPaymentMethod(SuppCode);}else{
					  ShowHideLoader('');
				}

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
            }else{
                document.getElementById("payment_amnt_"+i).value = '';
                document.getElementById("invoice_check_"+i).checked = false;
		LastBalance = MainOpenBalance;
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
     }
  /*************************************/   
      function SetPayAmntByCheck(line){
          
         var totalAmt = 0,totalInvoice = 0,PaidAmount = 0,invAmnt = 0,remainInvAmnt = 0;
        
         totalInvoice = document.getElementById("totalInvoice").value;
         PaidAmount = document.getElementById("PaidAmount").value;
         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("payment_amnt_"+i).value  > 0){
              invAmnt +=  parseFloat(document.getElementById("payment_amnt_"+i).value);
             }
         }
        
       remainInvAmnt = parseFloat(PaidAmount)-parseFloat(invAmnt);
     

            if(document.getElementById("invoice_check_"+line).checked){
                 //document.getElementById("payment_amnt_"+line).value = parseFloat(document.getElementById("invoice_amnt_"+line).value);
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
            }else{
                document.getElementById("Arpayment_amnt_"+i).value = '';
                 document.getElementById("Arinvoice_check_"+i).checked = false;
		LastBalance = MainOpenBalance;
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
         ReceivedAmount = document.getElementById("PaidAmount").value;
         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("Arpayment_amnt_"+i).value > 0){
              invAmnt +=  parseFloat(document.getElementById("Arpayment_amnt_"+i).value);
             }
         }
         
       remainInvAmnt = parseFloat(ReceivedAmount)-parseFloat(invAmnt);

         
            if(document.getElementById("Arinvoice_check_"+line).checked){
                 
                 if(remainInvAmnt > parseFloat(document.getElementById("Arinvoice_amnt_"+line).value))
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
/*************************************/

